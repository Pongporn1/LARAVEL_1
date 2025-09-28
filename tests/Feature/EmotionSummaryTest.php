<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\DiaryEntry;
use App\Models\Emotion;
use Illuminate\Support\Facades\DB;

class EmotionSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_emotion_summary_query_builder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions first using DB insert
        $emotionNames = ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => $emotionNames[$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create diary entries using DB insert
        $entry1Id = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry 1',
            'content' => 'Test content 1',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $entry2Id = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry 2', 
            'content' => 'Test content 2',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $entry3Id = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry 3',
            'content' => 'Test content 3', 
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach emotions to entries using Query Builder
        DB::table('diary_entry_emotions')->insert([
            ['diary_entry_id' => $entry1Id, 'emotion_id' => 1, 'intensity' => 8, 'created_at' => now(), 'updated_at' => now()], // Happy
            ['diary_entry_id' => $entry1Id, 'emotion_id' => 2, 'intensity' => 3, 'created_at' => now(), 'updated_at' => now()], // Sad
            ['diary_entry_id' => $entry2Id, 'emotion_id' => 1, 'intensity' => 9, 'created_at' => now(), 'updated_at' => now()], // Happy
            ['diary_entry_id' => $entry3Id, 'emotion_id' => 4, 'intensity' => 7, 'created_at' => now(), 'updated_at' => now()], // Excited
        ]);

        // Test the emotion summary query
        $emotionCounts = DB::table('diary_entry_emotions as dee')
            ->join('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->select('dee.emotion_id', DB::raw('count(dee.diary_entry_id) as diary_count'))
            ->where('de.user_id', $user->id)
            ->whereIn('dee.emotion_id', [1, 2, 3, 4, 5])
            ->groupBy('dee.emotion_id')
            ->get();

        // Convert to PHP array
        $summary = [];
        foreach ($emotionCounts as $count) {
            $summary[$count->emotion_id] = $count->diary_count;
        }

        // Assertions
        $this->assertEquals(2, $summary[1] ?? 0); // Happy: 2 entries
        $this->assertEquals(1, $summary[2] ?? 0); // Sad: 1 entry
        $this->assertEquals(0, $summary[3] ?? 0); // Angry: 0 entries
        $this->assertEquals(1, $summary[4] ?? 0); // Excited: 1 entry
        $this->assertEquals(0, $summary[5] ?? 0); // Anxious: 0 entries
    }

    public function test_emotion_summary_controller_endpoint()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions using DB insert
        $emotionNames = ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => $emotionNames[$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create test data
        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry',
            'content' => 'Test content',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('diary_entry_emotions')->insert([
            ['diary_entry_id' => $entryId, 'emotion_id' => 1, 'intensity' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['diary_entry_id' => $entryId, 'emotion_id' => 3, 'intensity' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Test the API endpoint
        $response = $this->get(route('query-builder.emotion-summary'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'summary' => [
                '*' => [
                    'emotion_id',
                    'emotion_name',
                    'diary_count'
                ]
            ],
            'total_entries',
            'query_explanation'
        ]);

        $data = $response->json();
        
        // Check that we have exactly 5 emotions
        $this->assertCount(5, $data['summary']);
        
        // Check specific counts
        $happyEmotion = collect($data['summary'])->firstWhere('emotion_id', 1);
        $angryEmotion = collect($data['summary'])->firstWhere('emotion_id', 3);
        
        $this->assertEquals(1, $happyEmotion['diary_count']);
        $this->assertEquals(1, $angryEmotion['diary_count']);
        $this->assertEquals(2, $data['total_entries']);
    }

    public function test_diary_index_with_summary()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions using DB insert
        $emotionNames = ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => $emotionNames[$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create diary entry with emotions
        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry',
            'content' => 'Test content',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('diary_entry_emotions')->insert([
            ['diary_entry_id' => $entryId, 'emotion_id' => 1, 'intensity' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Test the diary index page
        $response = $this->get(route('diary.index'));

        $response->assertStatus(200);
        $response->assertViewHas(['diaryEntries', 'summary']);
        
        $viewData = $response->viewData('summary');
        $this->assertIsArray($viewData);
        $this->assertEquals(1, $viewData[1] ?? 0); // Should have 1 happy diary
    }
}