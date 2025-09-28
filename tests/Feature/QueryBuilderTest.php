<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\DiaryEntry;
use App\Models\Emotion;
use Illuminate\Support\Facades\DB;

class QueryBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_pluck_vs_select_difference()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create test diary entries
        $entry1 = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'First Entry',
            'content' => 'First content',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $entry2 = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Second Entry',
            'content' => 'Second content',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test pluck method
        $contentsPluck = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->pluck('content');

        // Test select method
        $contentsSelect = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->select('content')
            ->get();

        // Test pluck with key-value
        $titlesKeyValue = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->pluck('title', 'id');

        // Assertions
        $this->assertIsArray($contentsPluck->toArray());
        $this->assertEquals(['First content', 'Second content'], $contentsPluck->toArray());

        $this->assertIsObject($contentsSelect->first());
        $this->assertEquals('First content', $contentsSelect->first()->content);

        $this->assertArrayHasKey($entry1, $titlesKeyValue->toArray());
        $this->assertEquals('First Entry', $titlesKeyValue[$entry1]);
    }

    public function test_query_builder_crud_operations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Test INSERT
        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry',
            'content' => 'Test content for CRUD operations',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('diary_entries', [
            'id' => $entryId,
            'title' => 'Test Entry',
            'user_id' => $user->id
        ]);

        // Test SELECT
        $entry = DB::table('diary_entries')
            ->where('id', $entryId)
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotNull($entry);
        $this->assertEquals('Test Entry', $entry->title);

        // Test UPDATE
        $updated = DB::table('diary_entries')
            ->where('id', $entryId)
            ->where('user_id', $user->id)
            ->update(['title' => 'Updated Test Entry']);

        $this->assertEquals(1, $updated);
        $this->assertDatabaseHas('diary_entries', [
            'id' => $entryId,
            'title' => 'Updated Test Entry'
        ]);

        // Test DELETE
        $deleted = DB::table('diary_entries')
            ->where('id', $entryId)
            ->where('user_id', $user->id)
            ->delete();

        $this->assertEquals(1, $deleted);
        $this->assertDatabaseMissing('diary_entries', [
            'id' => $entryId
        ]);
    }

    public function test_query_builder_aggregates()
    {
        $user = User::factory()->create();

        // Create multiple entries
        for ($i = 1; $i <= 5; $i++) {
            DB::table('diary_entries')->insert([
                'user_id' => $user->id,
                'title' => "Entry {$i}",
                'content' => str_repeat('Content ', $i * 10), // Varying length
                'date' => now()->subDays($i)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Test COUNT
        $count = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->count();
        $this->assertEquals(5, $count);

        // Test MIN/MAX dates
        $minDate = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->min('date');
        $maxDate = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->max('date');

        $this->assertEquals(now()->subDays(5)->toDateString(), $minDate);
        $this->assertEquals(now()->subDays(1)->toDateString(), $maxDate);

        // Test AVG content length
        $avgLength = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->avg(DB::raw('LENGTH(content)'));

        // MySQL returns string for AVG, so we need to convert or check numeric
        $this->assertIsNumeric($avgLength);
        $this->assertGreaterThan(0, (float) $avgLength);
    }

    public function test_query_builder_joins()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        $entryId = DB::table('diary_entries')->insertGetId([
            'user_id' => $user->id,
            'title' => 'Test Entry',
            'content' => 'Test content',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test JOIN query
        $result = DB::table('diary_entries')
            ->join('users', 'diary_entries.user_id', '=', 'users.id')
            ->select('diary_entries.title', 'users.name')
            ->where('diary_entries.id', $entryId)
            ->first();

        $this->assertNotNull($result);
        $this->assertEquals('Test Entry', $result->title);
        $this->assertEquals('Test User', $result->name);
    }

    public function test_query_builder_search()
    {
        $user = User::factory()->create();

        // Create entries with different content
        DB::table('diary_entries')->insert([
            [
                'user_id' => $user->id,
                'title' => 'Laravel Tutorial',
                'content' => 'Learning Laravel Query Builder',
                'date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'PHP Basics',
                'content' => 'Understanding PHP fundamentals',
                'date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Test LIKE search
        $results = DB::table('diary_entries')
            ->where('user_id', $user->id)
            ->where(function($query) {
                $query->where('title', 'like', '%Laravel%')
                      ->orWhere('content', 'like', '%Laravel%');
            })
            ->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Laravel Tutorial', $results->first()->title);
    }
}