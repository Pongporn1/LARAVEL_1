@extends('layouts.app')

@section('header')
  <h2 class="font-semibold text-xl text-gray-100 leading-tight">Create Reminder</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="rounded-2xl bg-slate-800/70 border border-slate-700 shadow-sm p-6">
    <form method="POST" action="{{ route('reminders.store') }}">
      @include('reminders._form', ['reminder' => new \App\Models\Reminder()])
    </form>
  </div>
</div>
@endsection
