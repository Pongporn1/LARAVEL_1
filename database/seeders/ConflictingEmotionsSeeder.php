<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ConflictingEmotionsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get the first user (or create one if none exists)
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Ensure emotions exist (1-5)
        $emotions = [
            ['id' => 1, 'name' => 'Happy'],
            ['id' => 2, 'name' => 'Sad'],
            ['id' => 3, 'name' => 'Angry'],
            ['id' => 4, 'name' => 'Excited'],
            ['id' => 5, 'name' => 'Anxious'],
        ];

        foreach ($emotions as $emotion) {
            DB::table('emotions')->updateOrInsert(
                ['id' => $emotion['id']],
                [
                    'name' => $emotion['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Create diary entries that demonstrate conflicting emotions
        $conflictingEntries = [
            [
                'title' => 'Mixed Feelings About Today',
                'content' => 'Today was a sad day 😢, but I tried to stay happy and positive. My friend made me laugh which was nice.',
                'date' => '2025-09-20',
            ],
            [
                'title' => 'Complicated Day',
                'content' => 'happy cooking, but the food is not delicious. So I become sad and disappointed.',
                'date' => '2025-09-20',
            ],
            [
                'title' => 'Rainy Monday',
                'content' => 'The weather made me feel down, but I kept thinking about happy memories from last weekend.',
                'date' => '2025-09-21',
            ],
            [
                'title' => 'Work Stress',
                'content' => 'Work was overwhelming today and I felt really sad. I wish I could go back to happy times.',
                'date' => '2025-09-22',
            ]
        ];

        foreach ($conflictingEntries as $entryData) {
            // Insert diary entry
            $entryId = DB::table('diary_entries')->insertGetId([
                'user_id' => $user->id,
                'title' => $entryData['title'],
                'content' => $entryData['content'],
                'date' => $entryData['date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach sad emotion (emotion_id = 2) with random intensity
            DB::table('diary_entry_emotions')->insert([
                'diary_entry_id' => $entryId,
                'emotion_id' => 2, // Sad emotion
                'intensity' => rand(6, 10), // High intensity for sadness
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Also create some regular entries for comparison
        $regularEntries = [
            [
                'title' => 'Great Day',
                'content' => 'Had an amazing day with friends. Everything was perfect!',
                'date' => '2025-09-23',
                'emotion_id' => 1, // Happy
                'intensity' => 9,
            ],
            [
                'title' => 'Productive Morning',
                'content' => 'Got a lot done today. Feeling accomplished and motivated.',
                'date' => '2025-09-24',
                'emotion_id' => 4, // Excited
                'intensity' => 7,
            ]
        ];

        foreach ($regularEntries as $entryData) {
            $entryId = DB::table('diary_entries')->insertGetId([
                'user_id' => $user->id,
                'title' => $entryData['title'],
                'content' => $entryData['content'],
                'date' => $entryData['date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('diary_entry_emotions')->insert([
                'diary_entry_id' => $entryId,
                'emotion_id' => $entryData['emotion_id'],
                'intensity' => $entryData['intensity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Conflicting emotions test data created successfully!');
        $this->command->info('📊 Created ' . count($conflictingEntries) . ' conflicting entries (Sad + "happy" in content)');
        $this->command->info('📊 Created ' . count($regularEntries) . ' regular entries for comparison');
    }
}
