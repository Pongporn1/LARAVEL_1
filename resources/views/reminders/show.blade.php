@extends('layouts.app')

@section('header')
  <h2 class="font-semibold text-xl text-gray-100 leading-tight">
    Reminder Details
  </h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="rounded-2xl bg-slate-800/70 border border-slate-700 shadow-sm">
    <div class="p-6 space-y-5">
      <div class="flex items-start justify-between">
        <div class="text-sm text-slate-400">
          {{ \Illuminate\Support\Carbon::parse($reminder->remind_at)->format('ddd, d M Y H:i') }}
        </div>
        <span class="px-3 py-1 rounded-full text-xs bg-blue-900/40 text-blue-200 border border-blue-700">
          {{ $reminder->status ?? 'New' }}
        </span>
      </div>

      <h1 class="text-2xl font-semibold text-white">{{ $reminder->title }}</h1>

      <div>
        <div class="text-sm font-medium text-slate-300 mb-2">Tags</div>
        <div class="flex flex-wrap gap-2">
          @forelse($reminder->tags as $tag)
            <span class="inline-block px-2.5 py-1 text-xs rounded-full bg-slate-700 text-slate-100 border border-slate-600">
              {{ $tag->name }}
            </span>
          @empty
            <span class="text-sm text-slate-500">No tags</span>
          @endforelse
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ route('reminders.edit',$reminder) }}"
           class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm">Edit</a>
        <a href="{{ route('reminders.index') }}"
           class="px-4 py-2 rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-100 text-sm">Back</a>
      </div>
    </div>
  </div>
</div>
@endsection
