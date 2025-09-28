<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DiaryEntry;
use App\Models\Emotion;
use App\Models\Tag;

class QueryBuilderController extends Controller
{
    /**
     * 1. Basic Select - Get all diary entries for authenticated user
     */
    public function display_diary()
    {
        $userId = Auth::id();
        
        // Query Builder approach
        $diaryEntries = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->get();

        return view('diary.display_diary', compact('diaryEntries'));
    }

    /**
     * 2. Select with specific columns using pluck()
     */
    public function get_diary_contents()
    {
        $userId = Auth::id();
        
        // Get only content column as flat array
        $contents = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->pluck('content');

        return response()->json($contents);
    }

    /**
     * 3. Pluck with key-value pairs for dropdowns
     */
    public function get_diary_titles_for_dropdown()
    {
        $userId = Auth::id();
        
        // Get id => title pairs for select options
        $titles = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->pluck('title', 'id');

        return response()->json($titles);
    }

    /**
     * 4. Order By - Sort diary entries by date
     */
    public function get_sorted_diary()
    {
        $userId = Auth::id();
        
        $diaryEntries = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($diaryEntries);
    }

    /**
     * 5. Count - Get total diary entries
     */
    public function count_diary_entries()
    {
        $userId = Auth::id();
        
        $entryCount = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->count();

        return response()->json(['total_entries' => $entryCount]);
    }

    /**
     * 6. Other Aggregate Functions
     */
    public function diary_statistics()
    {
        $userId = Auth::id();
        
        $stats = [
            'total_count' => DB::table('diary_entries')->where('user_id', $userId)->count(),
            'latest_date' => DB::table('diary_entries')->where('user_id', $userId)->max('date'),
            'earliest_date' => DB::table('diary_entries')->where('user_id', $userId)->min('date'),
            'avg_content_length' => DB::table('diary_entries')
                ->where('user_id', $userId)
                ->avg(DB::raw('LENGTH(content)'))
        ];

        return response()->json($stats);
    }

    /**
     * 7. Insert - Add new diary entry
     */
    public function store_diary_entry(Request $request)
    {
        $userId = Auth::id();
        
        DB::table('diary_entries')->insert([
            'user_id' => $userId,
            'date' => $request->date ?? now(),
            'title' => $request->title,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Diary entry created successfully']);
    }

    /**
     * 8. Update - Modify existing diary entry
     */
    public function update_diary_entry(Request $request, $id)
    {
        $userId = Auth::id();
        
        $affected = DB::table('diary_entries')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update([
                'title' => $request->title,
                'content' => $request->content,
                'updated_at' => now()
            ]);

        return response()->json(['updated_rows' => $affected]);
    }

    /**
     * 9. Delete - Remove diary entry
     */
    public function delete_diary_entry($id)
    {
        $userId = Auth::id();
        
        $deleted = DB::table('diary_entries')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->delete();

        return response()->json(['deleted_rows' => $deleted]);
    }

    /**
     * 10. Like Search - Find entries with specific content
     */
    public function search_diary($keyword)
    {
        $userId = Auth::id();
        
        $results = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->where(function($query) use ($keyword) {
                $query->where('content', 'like', "%{$keyword}%")
                      ->orWhere('title', 'like', "%{$keyword}%");
            })
            ->get();

        return response()->json($results);
    }

    /**
     * 11. Join - Get diary entries with user information
     */
    public function get_entries_with_users()
    {
        $entries = DB::table('diary_entries')
            ->join('users', 'diary_entries.user_id', '=', 'users.id')
            ->select('diary_entries.*', 'users.name', 'users.email')
            ->get();

        return response()->json($entries);
    }

    /**
     * 12. Complex Join - Count happy diary entries for user
     */
    public function count_happy_diary()
    {
        $userId = Auth::id();
        
        $happyEmotionCount = DB::table('users as u')
            ->join('diary_entries as de', 'u.id', '=', 'de.user_id')
            ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
            ->where('u.id', $userId)
            ->where('dee.emotion_id', 1) // Assuming emotion_id 1 is "happy"
            ->count('de.id');

        return response()->json(['happyEmotionCount' => $happyEmotionCount]);
    }

    /**
     * 13. Pagination - Get paginated diary entries
     */
    public function get_paginated_diary()
    {
        $userId = Auth::id();
        
        $entries = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return response()->json($entries);
    }

    /**
     * 14. Distinct - Get unique dates
     */
    public function get_unique_diary_dates()
    {
        $userId = Auth::id();
        
        $dates = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');

        return response()->json($dates);
    }

    /**
     * 15. Raw Expressions - Group by date with count
     */
    public function get_daily_entry_count()
    {
        $userId = Auth::id();
        
        $diary_count = DB::table('diary_entries')
            ->select('date', DB::raw('count(*) as count'))
            ->where('user_id', $userId)
            ->groupBy('date')
            ->having('count', '>=', 2)
            ->get();

        return response()->json(['diary_count' => $diary_count]);
    }

    /**
     * 16. Having Between - Get dates with specific entry count range
     */
    public function get_diary_count_between()
    {
        $userId = Auth::id();
        
        $diary_count = DB::table('diary_entries')
            ->select('date', DB::raw('count(*) as count'))
            ->where('user_id', $userId)
            ->groupBy('date')
            ->havingBetween('count', [3, 4])
            ->get();

        return response()->json(['diary_count' => $diary_count]);
    }

    /**
     * 17. Having Raw - Users with many entries
     */
    public function get_prolific_users()
    {
        $results = DB::table('diary_entries')
            ->select('user_id', DB::raw('COUNT(*) as total_entries'))
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 5')
            ->get();

        return response()->json($results);
    }

    /**
     * 18. Where Raw with parameter binding (SAFE)
     */
    public function get_entries_by_date_range($startDate, $endDate)
    {
        $userId = Auth::id();
        
        $entries = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->whereRaw("date BETWEEN ? AND ?", [$startDate, $endDate])
            ->get();

        return response()->json($entries);
    }

    /**
     * 19. Complex query - Get emotion statistics for user
     */
    public function get_emotion_statistics()
    {
        $userId = Auth::id();
        
        $emotionStats = DB::table('emotions as e')
            ->leftJoin('diary_entry_emotions as dee', 'e.id', '=', 'dee.emotion_id')
            ->leftJoin('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->where('de.user_id', $userId)
            ->select('e.name', DB::raw('COUNT(dee.emotion_id) as usage_count'), DB::raw('AVG(dee.intensity) as avg_intensity'))
            ->groupBy('e.id', 'e.name')
            ->orderBy('usage_count', 'desc')
            ->get();

        return response()->json($emotionStats);
    }

    /**
     * 20. Advanced query - Get monthly diary summary
     */
    public function get_monthly_summary()
    {
        $userId = Auth::id();
        
        $monthlySummary = DB::table('diary_entries')
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('MONTHNAME(date) as month_name'),
                DB::raw('COUNT(*) as entry_count'),
                DB::raw('AVG(LENGTH(content)) as avg_content_length')
            )
            ->where('user_id', $userId)
            ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'), DB::raw('MONTHNAME(date)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json($monthlySummary);
    }

    /**
     * 21. Tags dropdown using pluck
     */
    public function get_tags_for_dropdown()
    {
        $tags = DB::table('tags')
            ->pluck('name', 'id');

        return response()->json($tags);
    }

    /**
     * 22. Get entries with their tags (many-to-many through pivot)
     */
    public function get_entries_with_tags()
    {
        $userId = Auth::id();
        
        $entriesWithTags = DB::table('diary_entries as de')
            ->leftJoin('taggables as t', function($join) {
                $join->on('de.id', '=', 't.taggable_id')
                     ->where('t.taggable_type', '=', 'App\Models\DiaryEntry');
            })
            ->leftJoin('tags as tag', 't.tag_id', '=', 'tag.id')
            ->where('de.user_id', $userId)
            ->select('de.*', DB::raw('GROUP_CONCAT(tag.name) as tag_names'))
            ->groupBy('de.id', 'de.user_id', 'de.date', 'de.title', 'de.content', 'de.created_at', 'de.updated_at')
            ->get();

        return response()->json($entriesWithTags);
    }

    /**
     * 23. Subquery example - Get users with their latest diary entry
     */
    public function get_users_with_latest_entry()
    {
        $latestEntries = DB::table('users as u')
            ->leftJoin('diary_entries as de', 'u.id', '=', 'de.user_id')
            ->select(
                'u.name',
                'u.email',
                DB::raw('(SELECT content FROM diary_entries WHERE user_id = u.id ORDER BY date DESC LIMIT 1) as latest_entry'),
                DB::raw('(SELECT date FROM diary_entries WHERE user_id = u.id ORDER BY date DESC LIMIT 1) as latest_date')
            )
            ->get();

        return response()->json($latestEntries);
    }

    /**
     * 24. Transaction example with Query Builder
     */
    public function create_entry_with_emotions_transaction(Request $request)
    {
        $userId = Auth::id();
        
        try {
            DB::beginTransaction();
            
            // Insert diary entry
            $entryId = DB::table('diary_entries')->insertGetId([
                'user_id' => $userId,
                'date' => $request->date ?? now(),
                'title' => $request->title,
                'content' => $request->content,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert emotions if provided
            if ($request->has('emotions')) {
                $emotionData = [];
                foreach ($request->emotions as $emotionId => $intensity) {
                    $emotionData[] = [
                        'diary_entry_id' => $entryId,
                        'emotion_id' => $emotionId,
                        'intensity' => $intensity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('diary_entry_emotions')->insert($emotionData);
            }

            DB::commit();
            
            return response()->json([
                'message' => 'Diary entry with emotions created successfully',
                'entry_id' => $entryId
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create entry: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 25. Conditional queries based on filters
     */
    public function get_filtered_entries(Request $request)
    {
        $userId = Auth::id();
        
        $query = DB::table('diary_entries')
            ->where('user_id', $userId);

        // Add date range filter if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Add search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        // Add emotion filter if provided
        if ($request->has('emotion_id')) {
            $query->whereExists(function($q) use ($request) {
                $q->select(DB::raw(1))
                  ->from('diary_entry_emotions')
                  ->whereRaw('diary_entry_emotions.diary_entry_id = diary_entries.id')
                  ->where('emotion_id', $request->emotion_id);
            });
        }

        $entries = $query->orderBy('date', 'desc')->paginate(15);

        return response()->json($entries);
    }

    /**
     * 26. Emotion Summary - Count diary entries by emotion (Practice Exercise)
     */
    public function get_emotion_summary()
    {
        $userId = Auth::id();
        
        // Count how many diaries are related to each emotion (emotion_id 1-5)
        $emotionCounts = DB::table('diary_entry_emotions as dee')
            ->join('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->select('dee.emotion_id', DB::raw('count(dee.diary_entry_id) as diary_count'))
            ->where('de.user_id', $userId)
            ->whereIn('dee.emotion_id', [1, 2, 3, 4, 5])
            ->groupBy('dee.emotion_id')
            ->get();

        // Convert the data into a PHP array for easier use
        $summary = [];
        foreach ($emotionCounts as $count) {
            $summary[$count->emotion_id] = $count->diary_count;
        }

        // Add emotion names for context
        $emotions = [
            1 => 'Happy',
            2 => 'Sad', 
            3 => 'Angry',
            4 => 'Excited',
            5 => 'Anxious'
        ];

        $result = [];
        foreach ($emotions as $id => $name) {
            $result[] = [
                'emotion_id' => $id,
                'emotion_name' => $name,
                'diary_count' => $summary[$id] ?? 0
            ];
        }

        return response()->json([
            'summary' => $result,
            'total_entries' => array_sum($summary),
            'query_explanation' => [
                'join' => 'diary_entry_emotions JOIN diary_entries',
                'group_by' => 'dee.emotion_id',
                'aggregate' => 'COUNT(dee.diary_entry_id)',
                'filter' => 'WHERE de.user_id = ? AND dee.emotion_id IN (1,2,3,4,5)'
            ]
        ]);
    }

    /**
     * 27. Conflicting Emotions - Find diary entries with "Sad" emotion but containing "happy" in content
     */
    public function get_conflicting_emotions()
    {
        $userId = Auth::id();
        
        // Query Builder to find conflicting emotions:
        // 1. User expressed "Sad" emotion (emotion_id = 2)
        // 2. But mentioned "happy" in the diary content
        $conflictingEntries = DB::table('diary_entries as de')
            ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
            ->select(
                'de.id',
                'de.date', 
                'de.title',
                'de.content',
                'dee.emotion_id',
                'dee.intensity',
                'de.created_at'
            )
            ->where('de.user_id', $userId)
            ->where('dee.emotion_id', 2) // Sad emotion
            ->where('de.content', 'like', '%happy%') // Contains "happy" in content
            ->orderBy('de.date', 'desc')
            ->get();

        return view('diary.conflicting_emotions', compact('conflictingEntries'));
    }

    /**
     * 28. API endpoint for conflicting emotions
     */
    public function get_conflicting_emotions_api()
    {
        $userId = Auth::id();
        
        $conflictingEntries = DB::table('diary_entries as de')
            ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
            ->leftJoin('emotions as e', 'dee.emotion_id', '=', 'e.id')
            ->select(
                'de.id',
                'de.date', 
                'de.title',
                'de.content',
                'e.name as emotion_name',
                'dee.emotion_id',
                'dee.intensity',
                'de.created_at'
            )
            ->where('de.user_id', $userId)
            ->where('dee.emotion_id', 2) // Sad emotion
            ->where('de.content', 'like', '%happy%') // Contains "happy" in content
            ->orderBy('de.date', 'desc')
            ->get();

        return response()->json([
            'conflicting_entries' => $conflictingEntries,
            'count' => $conflictingEntries->count(),
            'explanation' => 'Diary entries where user felt SAD but mentioned HAPPY in content',
            'raw_sql' => "
                SELECT de.id, de.date, de.title, de.content, e.name as emotion_name, 
                       dee.emotion_id, dee.intensity, de.created_at
                FROM diary_entries as de
                JOIN diary_entry_emotions as dee ON de.id = dee.diary_entry_id
                LEFT JOIN emotions as e ON dee.emotion_id = e.id
                WHERE de.user_id = {$userId}
                  AND dee.emotion_id = 2
                  AND de.content LIKE '%happy%'
                ORDER BY de.date DESC
            "
        ]);
    }
}