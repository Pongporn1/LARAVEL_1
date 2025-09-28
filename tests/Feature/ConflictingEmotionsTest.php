<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ConflictingEmotionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_conflicting_emotions_query_builder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions
        $emotionNames = ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => $emotionNames[$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create test diary entries
        $sadWithHappy = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Conflicting Day',
            'content' => 'I felt sad today but tried to stay happy and positive.',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sadWithoutHappy = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Regular Sad Day',
            'content' => 'I felt really down and depressed today.',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $happyWithHappy = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Good Day',
            'content' => 'I am so happy today! Everything went well.',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach emotions
        DB::table('diary_entry_emotions')->insert([
            ['diary_entry_id' => $sadWithHappy, 'emotion_id' => 2, 'intensity' => 8, 'created_at' => now(), 'updated_at' => now()], // Sad + "happy"
            ['diary_entry_id' => $sadWithoutHappy, 'emotion_id' => 2, 'intensity' => 9, 'created_at' => now(), 'updated_at' => now()], // Sad only
            ['diary_entry_id' => $happyWithHappy, 'emotion_id' => 1, 'intensity' => 9, 'created_at' => now(), 'updated_at' => now()], // Happy + "happy"
        ]);

        // Test the conflicting emotions query
        $conflictingEntries = DB::table('diary_entries as de')
            ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
            ->select('de.id', 'de.title', 'de.content', 'dee.emotion_id', 'dee.intensity')
            ->where('de.user_id', $user->id)
            ->where('dee.emotion_id', 2) // Sad emotion
            ->where('de.content', 'like', '%happy%') // Contains "happy"
            ->get();

        // Assertions
        $this->assertCount(1, $conflictingEntries);
        $this->assertEquals($sadWithHappy, $conflictingEntries->first()->id);
        $this->assertEquals('Conflicting Day', $conflictingEntries->first()->title);
        $this->assertEquals(2, $conflictingEntries->first()->emotion_id); // Sad emotion
        $this->assertStringContainsString('happy', $conflictingEntries->first()->content);
    }

    public function test_conflicting_emotions_api_endpoint()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'][$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create conflicting entry
        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Conflict',
            'content' => 'Feeling sad but trying to be happy',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('diary_entry_emotions')->insert([
            'diary_entry_id' => $entryId,
            'emotion_id' => 2, // Sad
            'intensity' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test API endpoint
        $response = $this->get(route('query-builder.conflicting-emotions-api'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'conflicting_entries',
            'count',
            'explanation',
            'raw_sql'
        ]);

        $data = $response->json();
        $this->assertEquals(1, $data['count']);
        $this->assertStringContainsString('SAD', $data['explanation']);
        $this->assertStringContainsString('HAPPY', $data['explanation']);
    }

    public function test_conflicting_emotions_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'][$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create conflicting entry
        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Mixed Emotions',
            'content' => 'Today I felt really sad, but I remember happy moments',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('diary_entry_emotions')->insert([
            'diary_entry_id' => $entryId,
            'emotion_id' => 2, // Sad
            'intensity' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test view
        $response = $this->get(route('query-builder.conflicting-emotions'));

        $response->assertStatus(200);
        $response->assertViewIs('diary.conflicting_emotions');
        $response->assertViewHas('conflictingEntries');
        $response->assertSee('Mixed Emotions');
        $response->assertSee('Conflicting Emotions');
    }

    public function test_no_conflicting_emotions_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create emotions but no conflicting entries
        for ($i = 1; $i <= 5; $i++) {
            DB::table('emotions')->insert([
                'id' => $i,
                'name' => ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious'][$i-1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Test view with no results
        $response = $this->get(route('query-builder.conflicting-emotions'));

        $response->assertStatus(200);
        $response->assertSee('No Conflicting Emotions Found');
        $response->assertSee('emotions and thoughts are well-aligned');
    }
}