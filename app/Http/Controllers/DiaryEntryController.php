<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use App\Models\Emotion; // ใช้ดึงรายการอารมณ์
use App\Models\Tag;     // ใช้ดึงรายการแท็ก
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class DiaryEntryController extends Controller
{
    public function index()
    {
        // Get the paginated diary entries with their associated emotions
        $diaryEntries = Auth::user()->diaryEntries()
            ->with('emotions', 'tags')
            ->orderBy('date', 'desc')
            ->paginate(5);

        // Get the logged-in user ID. Stores the current user's ID in $userId for raw query builder usage.
        $userId = Auth::id();

        // Count how many diaries are related to each emotion
        $emotionCounts = DB::table('diary_entry_emotions as dee')
            ->join('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->select('dee.emotion_id', DB::raw('count(dee.diary_entry_id) as diary_count'))
            ->where('de.user_id', $userId)
            ->whereIn('dee.emotion_id', [1, 2, 3, 4, 5])
            ->groupBy('dee.emotion_id')
            ->get();

        // Convert the data into a PHP array
        $summary = [];
        foreach ($emotionCounts as $count) {
            $summary[$count->emotion_id] = $count->diary_count;
        }

        // Return the view with both diary entries and summary data
        return view('diary.index', compact('diaryEntries', 'summary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emotions = Emotion::all(); // สำหรับ checkbox อารมณ์
        $tags     = Tag::all();     // สำหรับ checkbox แท็ก
        return view('diary.create', compact('emotions', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date'      => ['required', 'date'],
            'title'     => ['nullable', 'string', 'max:255'],
            'content'   => ['required', 'string'],

            // emotions + intensity
            'emotions'  => ['nullable', 'array'],
            'intensity' => ['nullable', 'array'],

            // tags (polymorphic)
            'tags'      => ['nullable', 'array'],
            'tags.*'    => ['integer', 'exists:tags,id'],
        ]);

        // สร้าง entry ผูกกับผู้ใช้ปัจจุบัน
        $entry = Auth::user()->diaryEntries()->create([
            'date'    => $validated['date'],
            'title'   => $validated['title'] ?? null,
            'content' => $validated['content'],
        ]);

        // แนบ tags (ถ้าเลือก)
        $entry->tags()->sync($validated['tags'] ?? []);

        // แนบ emotions + intensity (ถ้าเลือก)
        if (!empty($validated['emotions'])) {
            $attach = [];
            foreach ($validated['emotions'] as $emotionId) {
                $attach[$emotionId] = [
                    'intensity' => $validated['intensity'][$emotionId] ?? null,
                ];
            }
            $entry->emotions()->attach($attach);
        }

        return redirect()->route('diary.index')->with('status', 'Diary entry added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diaryEntry = Auth::user()
            ->diaryEntries()
            ->with(['emotions', 'tags'])
            ->findOrFail($id);

        return view('diary.show', compact('diaryEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diaryEntry = Auth::user()
            ->diaryEntries()
            ->with(['emotions', 'tags'])
            ->findOrFail($id);

        $emotions = Emotion::all();
        $tags     = Tag::all();

        return view('diary.edit', compact('diaryEntry', 'emotions', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $entry = Auth::user()->diaryEntries()->findOrFail($id);

        $validated = $request->validate([
            'date'      => ['required', 'date'],
            'title'     => ['nullable', 'string', 'max:255'],
            'content'   => ['required', 'string'],

            'emotions'   => ['nullable', 'array'],
            'emotions.*' => ['integer', 'exists:emotions,id'],
            'intensity'  => ['nullable', 'array'],

            'tags'      => ['nullable', 'array'],
            'tags.*'    => ['integer', 'exists:tags,id'],
        ]);

        // อัปเดตฟิลด์หลัก
        $entry->update([
            'date'    => $validated['date'],
            'title'   => $validated['title'] ?? null,
            'content' => $validated['content'],
        ]);

        // sync tags (ไม่มี -> เคลียร์)
        $entry->tags()->sync($validated['tags'] ?? []);

        // sync emotions + intensity (ไม่มี -> เคลียร์)
        if (!empty($validated['emotions'])) {
            $sync = [];
            foreach ($validated['emotions'] as $eid) {
                $sync[$eid] = ['intensity' => $validated['intensity'][$eid] ?? null];
            }
            $entry->emotions()->sync($sync);
        } else {
            $entry->emotions()->sync([]);
        }

        return redirect()->route('diary.index')->with('status', 'Diary entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $entry = DiaryEntry::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $entry->delete(); // FK cascade จะลบ pivot ให้อัตโนมัติ

        return redirect()->route('diary.index')->with('status', 'Diary entry deleted successfully!');
    }
}
