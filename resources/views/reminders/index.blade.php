@extends('layouts.app')

@section('header')
  <h2 class="font-semibold text-xl text-gray-100 leading-tight">
    Reminders
  </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-100">Reminders</h1>
    <a href="{{ route('reminders.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
       New Reminder
    </a>
  </div>

  {{-- list as cards (เหมือนหน้า Diary) --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($reminders as $reminder)
      <div class="rounded-2xl bg-slate-800/70 border border-slate-700 shadow-sm">
        <div class="p-5 space-y-4">
          <div class="flex items-start justify-between">
            <div class="text-sm text-slate-400">
              {{ \Illuminate\Support\Carbon::parse($reminder->remind_at)->format('ddd, d M Y H:i') }}
            </div>
            <span class="px-3 py-1 rounded-full text-xs bg-blue-900/40 text-blue-200 border border-blue-700">
              {{ $reminder->status ?? 'New' }}
            </span>
          </div>

          <a href="{{ route('reminders.show',$reminder) }}"
             class="block text-lg md:text-xl font-semibold text-slate-100 hover:text-white">
            {{ $reminder->title }}
          </a>

          {{-- Tags --}}
          <div class="flex flex-wrap gap-2">
            @forelse($reminder->tags as $tag)
              <span class="inline-block px-2.5 py-1 text-xs rounded-full bg-slate-700 text-slate-100 border border-slate-600">
                {{ $tag->name }}
              </span>
            @empty
              <span class="text-xs text-slate-500">No tags</span>
            @endforelse
          </div>

          <div class="flex items-center gap-3 pt-1">
            <a href="{{ route('reminders.edit',$reminder) }}"
               class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm">Edit</a>

            <form action="{{ route('reminders.destroy',$reminder) }}" method="POST" onsubmit="return confirm('Delete this reminder?')">
              @csrf @method('DELETE')
              <button class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full">
        <div class="rounded-2xl bg-slate-800/70 border border-slate-700 p-10 text-center text-slate-400">
          No reminders yet.
        </div>
      </div>
    @endforelse
  </div>
</div>
@endsection
