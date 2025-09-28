<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TestEmotionSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:emotion-summary {user_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the emotion summary Query Builder functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        $this->info("Testing Emotion Summary Query Builder for User ID: {$userId}");
        $this->line('');

        // Test the Query Builder query
        $emotionCounts = DB::table('diary_entry_emotions as dee')
            ->join('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->select('dee.emotion_id', DB::raw('count(dee.diary_entry_id) as diary_count'))
            ->where('de.user_id', $userId)
            ->whereIn('dee.emotion_id', [1, 2, 3, 4, 5])
            ->groupBy('dee.emotion_id')
            ->get();

        // Convert to PHP array
        $summary = [];
        foreach ($emotionCounts as $count) {
            $summary[$count->emotion_id] = $count->diary_count;
        }

        // Display results
        $emotions = [1 => 'Happy', 2 => 'Sad', 3 => 'Angry', 4 => 'Excited', 5 => 'Anxious'];
        
        $this->info('📊 Emotion Summary Results:');
        $this->line('');
        
        $totalEntries = 0;
        foreach ($emotions as $id => $name) {
            $count = $summary[$id] ?? 0;
            $totalEntries += $count;
            $emoji = ['😊', '😢', '😡', '🤩', '😰'][$id - 1];
            
            $this->line("  {$emoji} {$name}: {$count} diary entries");
        }
        
        $this->line('');
        $this->info("Total diary entries with emotions: {$totalEntries}");
        
        // Show the SQL query used
        $this->line('');
        $this->comment('SQL Query Generated:');
        $this->line('SELECT dee.emotion_id, count(dee.diary_entry_id) as diary_count');
        $this->line('FROM diary_entry_emotions as dee');  
        $this->line('JOIN diary_entries as de ON dee.diary_entry_id = de.id');
        $this->line("WHERE de.user_id = {$userId}");
        $this->line('  AND dee.emotion_id IN (1,2,3,4,5)');
        $this->line('GROUP BY dee.emotion_id');

        return Command::SUCCESS;
    }
}
