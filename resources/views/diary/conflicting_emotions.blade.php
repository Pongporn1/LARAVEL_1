@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Conflicting Emotions</h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Diary entries where you felt <span class="text-blue-600 font-semibold">SAD</span> 
                    but mentioned <span class="text-yellow-600 font-semibold">"happy"</span> in your content
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('diary.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    🏠 Back to Diary
                </a>
                <a href="{{ route('query-builder.index') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition">
                    🔍 Query Examples
                </a>
            </div>
        </div>

        {{-- Query Information (Hidden) --}}
        {{-- 
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4">🔍 Query Builder Implementation</h3>
            
            <!-- Query Code -->
            <div class="bg-gray-900 rounded-lg p-4 mb-4">
                <pre class="text-green-400 text-sm overflow-auto"><code>$conflictingEntries = DB::table('diary_entries as de')
    ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
    ->select('de.id', 'de.date', 'de.title', 'de.content', 
             'dee.emotion_id', 'dee.intensity', 'de.created_at')
    ->where('de.user_id', $userId)
    ->where('dee.emotion_id', 2)           // Sad emotion
    ->where('de.content', 'like', '%happy%') // Contains "happy"
    ->orderBy('de.date', 'desc')
    ->get();</code></pre>
            </div>

            <!-- Raw SQL -->
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded border">
                <h4 class="font-semibold text-purple-700 dark:text-purple-300 mb-2">📝 Raw SQL Generated:</h4>
                <pre class="text-purple-800 dark:text-purple-200 text-sm"><code>SELECT de.id, de.date, de.title, de.content, 
       dee.emotion_id, dee.intensity, de.created_at
FROM diary_entries as de
JOIN diary_entry_emotions as dee ON de.id = dee.diary_entry_id
WHERE de.user_id = {{ Auth::id() }}
  AND dee.emotion_id = 2
  AND de.content LIKE '%happy%'
ORDER BY de.date DESC;</code></pre>
            </div>
        </div>
        --}}

        <!-- Results Section -->
        @if($conflictingEntries->count() > 0)
            <div class="mb-6">
                <div class="bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="text-yellow-600 dark:text-yellow-400 mr-3">⚠️</div>
                        <div>
                            <h3 class="font-semibold text-yellow-800 dark:text-yellow-200">
                                Found {{ $conflictingEntries->count() }} conflicting {{ Str::plural('entry', $conflictingEntries->count()) }}
                            </h3>
                            <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                                These entries show emotional complexity - feeling sad while thinking about happiness
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">📋 Summary</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Emotion</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Intensity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($conflictingEntries as $entry)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $entry->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($entry->date)->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 max-w-md">
                                        @php
                                            $content = $entry->content;
                                            // Highlight "happy" in the content
                                            $highlighted = preg_replace('/(happy)/i', '<span class="bg-yellow-200 dark:bg-yellow-600 px-1 rounded font-semibold">$1</span>', $content);
                                        @endphp
                                        <div class="break-words">
                                            {!! Str::limit($highlighted, 100) !!}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            😢 Sad
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center">
                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $entry->intensity }}/10</span>
                                            <div class="ml-2 w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($entry->intensity / 10) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detailed Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($conflictingEntries as $entry)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $entry->title ?: 'Untitled Entry' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($entry->date)->format('F j, Y') }} • Entry #{{ $entry->id }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs font-medium">
                                        😢 Sad
                                    </span>
                                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full text-xs">
                                        {{ $entry->intensity }}/10
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                @php
                                    $content = $entry->content;
                                    $highlighted = preg_replace('/(happy)/i', '<mark class="bg-yellow-300 dark:bg-yellow-600 px-1 rounded font-semibold">$1</mark>', $content);
                                @endphp
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {!! $highlighted !!}
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                    <span>Emotional Conflict Detected</span>
                                    <span class="text-orange-500 font-medium">⚠️ Mixed Emotions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- No Results -->
            <div class="text-center py-12">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-8">
                    <div class="text-6xl mb-4">🤔</div>
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-4">No Conflicting Emotions Found</h3>
                    <p class="text-gray-500 dark:text-gray-500 mb-6">
                        You haven't written any diary entries where you felt sad but mentioned "happy" in the content.
                    </p>
                    <p class="text-sm text-gray-400 dark:text-gray-600">
                        This could mean your emotions and thoughts are well-aligned! 😊
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('diary.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition inline-block">
                            Write New Diary Entry
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Technical Details -->
        <div class="mt-8 bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">🛠️ Technical Implementation</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded border">
                    <h4 class="font-semibold text-blue-600 dark:text-blue-400 mb-2">🔗 JOIN Operation</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Links diary entries with their emotions using diary_entry_emotions pivot table
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded border">
                    <h4 class="font-semibold text-green-600 dark:text-green-400 mb-2">🎯 WHERE Clauses</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Filters for emotion_id = 2 (Sad) AND content LIKE '%happy%'
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded border">
                    <h4 class="font-semibold text-purple-600 dark:text-purple-400 mb-2">🔍 LIKE Search</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Uses pattern matching to find "happy" anywhere in diary content
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection