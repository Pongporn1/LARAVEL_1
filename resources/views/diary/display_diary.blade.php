@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Diary (Query Builder)</h1>
            <a href="{{ route('query-builder.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                ← Back to Examples
            </a>
        </div>

        @if($diaryEntries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($diaryEntries as $entry)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                            <h3 class="text-white font-semibold">
                                {{ $entry->title ?? 'Untitled Entry' }}
                            </h3>
                            <p class="text-blue-100 text-sm">
                                {{ \Carbon\Carbon::parse($entry->date)->format('F j, Y') }}
                            </p>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed">
                                {{ Str::limit($entry->content, 150) }}
                            </p>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500">
                                    Created: {{ \Carbon\Carbon::parse($entry->created_at)->format('M j, Y g:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">No diary entries found</h3>
                    <p class="text-gray-500 mb-6">Start writing your first diary entry!</p>
                    <a href="{{ route('diary.create') }}" 
                       class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition inline-block">
                        Create First Entry
                    </a>
                </div>
            </div>
        @endif

        <!-- Query Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">🔍 Query Builder Code Used:</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded text-sm overflow-auto"><code>// Query Builder approach
$diaryEntries = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->get();

// Equivalent SQL:
SELECT * FROM diary_entries WHERE user_id = ?</code></pre>

            <div class="mt-4 p-4 bg-white rounded border">
                <h4 class="font-semibold text-blue-700 mb-2">Compare with Eloquent:</h4>
                <pre class="bg-gray-100 p-2 text-sm rounded"><code>// Eloquent approach (more concise)
$diaryEntries = Auth::user()->diaryEntries()->get();</code></pre>
            </div>
        </div>
    </div>
</div>
@endsection