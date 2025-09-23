<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::with('tags')->latest()->get();
        return view('reminders.index', compact('reminders'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('reminders.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => ['required','string','max:255'],
            'remind_at' => ['nullable','date'],
            'status'    => ['nullable','string','max:50'],
            'tags'      => ['nullable','array'],
            'tags.*'    => ['integer','exists:tags,id'],
        ]);

        $reminder = Reminder::create([
            'title'     => $data['title'],
            'remind_at' => $data['remind_at'] ?? null,
            'status'    => $data['status'] ?? 'New',
        ]);

        if (!empty($data['tags'])) {
            $reminder->tags()->sync($data['tags']); // attach หลายตัว
        }

        return redirect()->route('reminders.index')->with('ok','Created.');
    }

    public function show(Reminder $reminder)
    {
        $reminder->load('tags');
        return view('reminders.show', compact('reminder'));
    }

    public function edit(Reminder $reminder)
    {
        $tags = Tag::orderBy('name')->get();
        $reminder->load('tags');
        return view('reminders.edit', compact('reminder','tags'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $data = $request->validate([
            'title'     => ['required','string','max:255'],
            'remind_at' => ['nullable','date'],
            'status'    => ['nullable','string','max:50'],
            'tags'      => ['nullable','array'],
            'tags.*'    => ['integer','exists:tags,id'],
        ]);

        $reminder->update([
            'title'     => $data['title'],
            'remind_at' => $data['remind_at'] ?? null,
            'status'    => $data['status'] ?? $reminder->status,
        ]);

        $reminder->tags()->sync($data['tags'] ?? []);
        return redirect()->route('reminders.index')->with('ok','Updated.');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->tags()->detach();
        $reminder->delete();
        return back()->with('ok','Deleted.');
    }
}
