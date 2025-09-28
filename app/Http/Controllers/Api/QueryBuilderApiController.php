<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QueryBuilderApiController extends Controller
{
    /**
     * Demonstrate pluck() vs select() difference
     */
    public function comparePluckVsSelect()
    {
        $userId = Auth::id();
        
        // Using pluck() - returns flat array
        $contentsPluck = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->pluck('content');
        
        // Using select() + get() - returns collection of objects
        $contentsSelect = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->select('content')
            ->get();
        
        // Using pluck with key-value pairs
        $titlesKeyValue = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->pluck('title', 'id');

        return response()->json([
            'pluck_result' => $contentsPluck,
            'select_result' => $contentsSelect,
            'pluck_key_value' => $titlesKeyValue,
            'explanation' => [
                'pluck' => 'Returns a flat array of values - perfect for dropdowns',
                'select' => 'Returns collection of objects - use when you need object structure',
                'pluck_with_key' => 'Creates key-value pairs - ideal for HTML select options'
            ]
        ]);
    }

    /**
     * Create diary entry using Query Builder with transaction
     */
    public function createDiaryEntry(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
            'emotion_ids' => 'nullable|array',
            'emotion_ids.*' => 'integer|exists:emotions,id'
        ]);

        try {
            DB::beginTransaction();

            // Insert diary entry using Query Builder
            $entryId = DB::table('diary_entries')->insertGetId([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
                'date' => $request->date ?? now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach emotions if provided
            if ($request->has('emotion_ids') && !empty($request->emotion_ids)) {
                $emotionData = [];
                foreach ($request->emotion_ids as $emotionId) {
                    $emotionData[] = [
                        'diary_entry_id' => $entryId,
                        'emotion_id' => $emotionId,
                        'intensity' => rand(1, 10), // Random intensity for demo
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('diary_entry_emotions')->insert($emotionData);
            }

            DB::commit();

            return response()->json([
                'message' => 'Diary entry created successfully',
                'entry_id' => $entryId,
                'query_used' => [
                    'insert' => "DB::table('diary_entries')->insertGetId([...])",
                    'emotions' => "DB::table('diary_entry_emotions')->insert([...])"
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Failed to create diary entry',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Advanced search with multiple conditions
     */
    public function advancedSearch(Request $request)
    {
        $userId = Auth::id();
        
        $query = DB::table('diary_entries')
            ->where('user_id', $userId);

        // Add search term if provided
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        // Add date range if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Add emotion filter if provided
        if ($request->filled('emotion_id')) {
            $query->whereExists(function($q) use ($request) {
                $q->select(DB::raw(1))
                  ->from('diary_entry_emotions')
                  ->whereRaw('diary_entry_emotions.diary_entry_id = diary_entries.id')
                  ->where('emotion_id', $request->emotion_id);
            });
        }

        // Add ordering
        $orderBy = $request->get('order_by', 'date');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        // Get results with pagination
        $perPage = $request->get('per_page', 10);
        $results = $query->paginate($perPage);

        return response()->json([
            'data' => $results,
            'applied_filters' => [
                'search' => $request->search,
                'date_range' => [
                    'start' => $request->start_date,
                    'end' => $request->end_date
                ],
                'emotion_id' => $request->emotion_id,
                'ordering' => "{$orderBy} {$orderDirection}"
            ],
            'sql_example' => "SELECT * FROM diary_entries WHERE user_id = ? AND (conditions) ORDER BY {$orderBy} {$orderDirection}"
        ]);
    }

    /**
     * Get comprehensive statistics using various aggregate functions
     */
    public function getDiaryStatistics()
    {
        $userId = Auth::id();

        $stats = [
            // Basic counts
            'total_entries' => DB::table('diary_entries')->where('user_id', $userId)->count(),
            'entries_this_month' => DB::table('diary_entries')
                ->where('user_id', $userId)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),

            // Date statistics
            'first_entry_date' => DB::table('diary_entries')->where('user_id', $userId)->min('date'),
            'latest_entry_date' => DB::table('diary_entries')->where('user_id', $userId)->max('date'),

            // Content statistics
            'avg_content_length' => DB::table('diary_entries')
                ->where('user_id', $userId)
                ->avg(DB::raw('LENGTH(content)')),
            'longest_entry_length' => DB::table('diary_entries')
                ->where('user_id', $userId)
                ->max(DB::raw('LENGTH(content)')),

            // Monthly breakdown
            'monthly_counts' => DB::table('diary_entries')
                ->select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('MONTHNAME(date) as month_name'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('user_id', $userId)
                ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'), DB::raw('MONTHNAME(date)'))
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get(),

            // Emotion usage (if emotions exist)
            'emotion_usage' => DB::table('emotions as e')
                ->leftJoin('diary_entry_emotions as dee', 'e.id', '=', 'dee.emotion_id')
                ->leftJoin('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
                ->where('de.user_id', $userId)
                ->select('e.name', DB::raw('COUNT(dee.emotion_id) as count'))
                ->groupBy('e.id', 'e.name')
                ->orderBy('count', 'desc')
                ->get(),
        ];

        return response()->json([
            'statistics' => $stats,
            'query_methods_used' => [
                'count()' => 'Count total records',
                'min()/max()' => 'Get smallest/largest values',
                'avg()' => 'Calculate average values',
                'DB::raw()' => 'Use raw SQL expressions',
                'groupBy()' => 'Group results by columns',
                'leftJoin()' => 'Join tables with optional matches'
            ]
        ]);
    }

    /**
     * Bulk operations demonstration
     */
    public function bulkOperations(Request $request)
    {
        $userId = Auth::id();

        $operations = [];

        // Bulk update - mark entries as archived
        if ($request->has('archive_ids')) {
            $updated = DB::table('diary_entries')
                ->whereIn('id', $request->archive_ids)
                ->where('user_id', $userId)
                ->update(['archived' => true, 'updated_at' => now()]);
            
            $operations['archived'] = $updated . ' entries archived';
        }

        // Bulk delete - remove entries older than specified date
        if ($request->has('delete_before_date')) {
            $deleted = DB::table('diary_entries')
                ->where('user_id', $userId)
                ->where('date', '<', $request->delete_before_date)
                ->delete();
            
            $operations['deleted'] = $deleted . ' entries deleted';
        }

        // Bulk insert - create multiple sample entries
        if ($request->has('create_samples')) {
            $sampleData = [];
            for ($i = 1; $i <= 5; $i++) {
                $sampleData[] = [
                    'user_id' => $userId,
                    'title' => "Sample Entry {$i}",
                    'content' => "This is sample content for entry {$i} created via Query Builder bulk insert.",
                    'date' => now()->subDays($i)->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            DB::table('diary_entries')->insert($sampleData);
            $operations['created'] = '5 sample entries created';
        }

        return response()->json([
            'operations_performed' => $operations,
            'bulk_methods' => [
                'whereIn()' => 'Match multiple IDs in single query',
                'update()' => 'Bulk update matching records',
                'delete()' => 'Bulk delete matching records', 
                'insert()' => 'Insert multiple records at once'
            ]
        ]);
    }
}