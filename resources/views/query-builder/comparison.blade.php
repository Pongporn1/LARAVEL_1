@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">🔍 Query Builder vs Eloquent vs Raw SQL</h1>
            <p class="text-gray-600 text-lg">Complete comparison of Laravel database query methods</p>
        </div>

        <!-- Navigation -->
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('query-builder.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                🏠 Query Builder Examples
            </a>
            <a href="{{ route('dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                📊 Dashboard
            </a>
        </div>

        <!-- 1. Basic SELECT -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">1. Basic SELECT Operation</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <div class="bg-blue-50 p-4 rounded border">
                    <h3 class="font-semibold text-blue-700 mb-3">🔧 Query Builder</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>$diaryEntries = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->get();</code></pre>
                </div>
                <div class="bg-green-50 p-4 rounded border">
                    <h3 class="font-semibold text-green-700 mb-3">✨ Eloquent</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>$diaryEntries = Auth::user()
    ->diaryEntries()
    ->get();</code></pre>
                </div>
                <div class="bg-purple-50 p-4 rounded border">
                    <h3 class="font-semibold text-purple-700 mb-3">🗃️ Raw SQL</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>SELECT *
FROM diary_entries
WHERE user_id = ?</code></pre>
                </div>
            </div>
        </div>

        <!-- 2. pluck() vs select() -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">2. pluck() vs select() - The Key Difference</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-yellow-50 p-4 rounded border">
                        <h3 class="font-semibold text-yellow-700 mb-3">🎯 pluck('content') - Flat Array</h3>
                        <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded mb-3 overflow-auto"><code>$contents = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->pluck('content');</code></pre>
                        <div class="bg-white p-3 rounded border">
                            <p class="text-sm font-medium text-gray-700 mb-2">Result:</p>
                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto"><code>[
    "My first diary",
    "Laravel notes", 
    "Vacation plans"
]</code></pre>
                            <p class="text-xs text-gray-500 mt-2">✅ Perfect for dropdowns and simple lists</p>
                        </div>
                    </div>
                    <div class="bg-cyan-50 p-4 rounded border">
                        <h3 class="font-semibold text-cyan-700 mb-3">🎯 select()->get() - Objects</h3>
                        <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded mb-3 overflow-auto"><code>$contents = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->select('content')
    ->get();</code></pre>
                        <div class="bg-white p-3 rounded border">
                            <p class="text-sm font-medium text-gray-700 mb-2">Result:</p>
                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto"><code>[
    {"content": "My first diary"},
    {"content": "Laravel notes"},
    {"content": "Vacation plans"}
]</code></pre>
                            <p class="text-xs text-gray-500 mt-2">✅ Use when you need object structure</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-indigo-50 p-4 rounded border">
                    <h3 class="font-semibold text-indigo-700 mb-3">🔑 pluck() with Key-Value pairs</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded mb-3 overflow-auto"><code>$titles = DB::table('diary_entries')->pluck('title', 'id');</code></pre>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded border">
                            <p class="text-sm font-medium text-gray-700 mb-2">Result:</p>
                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto"><code>[
    1 => "My first diary",
    2 => "Laravel notes",
    3 => "Vacation plans"
]</code></pre>
                        </div>
                        <div class="bg-white p-3 rounded border">
                            <p class="text-sm font-medium text-gray-700 mb-2">Perfect for HTML selects:</p>
                            <pre class="text-xs bg-gray-100 p-2 rounded overflow-auto"><code>&lt;select name="entry_id"&gt;
    @foreach ($titles as $id => $title)
        &lt;option value="{{ $id }}"&gt;
            {{ $title }}
        &lt;/option&gt;
    @endforeach
&lt;/select&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. INSERT Operations -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">3. INSERT Operations</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <div class="bg-blue-50 p-4 rounded border">
                    <h3 class="font-semibold text-blue-700 mb-3">🔧 Query Builder</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>DB::table('diary_entries')->insert([
    'user_id' => Auth::id(),
    'date' => now(),
    'content' => 'Laravel Query Builder!',
    'created_at' => now(),
    'updated_at' => now(),
]);</code></pre>
                </div>
                <div class="bg-green-50 p-4 rounded border">
                    <h3 class="font-semibold text-green-700 mb-3">✨ Eloquent</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>Auth::user()->diaryEntries()->create([
    'date' => now(),
    'content' => 'Laravel Eloquent!',
]);</code></pre>
                </div>
                <div class="bg-purple-50 p-4 rounded border">
                    <h3 class="font-semibold text-purple-700 mb-3">🗃️ Raw SQL</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>INSERT INTO diary_entries 
(user_id, date, content, 
 created_at, updated_at)
VALUES (?, NOW(), ?, NOW(), NOW())</code></pre>
                </div>
            </div>
        </div>

        <!-- 4. Complex JOIN Operations -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">4. Complex JOIN - Count Happy Diary Entries</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                <div class="bg-blue-50 p-4 rounded border">
                    <h3 class="font-semibold text-blue-700 mb-3">🔧 Query Builder</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>$happyCount = DB::table('users as u')
    ->join('diary_entries as de', 
           'u.id', '=', 'de.user_id')
    ->join('diary_entry_emotions as dee', 
           'de.id', '=', 'dee.diary_entry_id')
    ->where('u.id', $userId)
    ->where('dee.emotion_id', 1)
    ->count('de.id');</code></pre>
                </div>
                <div class="bg-purple-50 p-4 rounded border">
                    <h3 class="font-semibold text-purple-700 mb-3">🗃️ Raw SQL</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>SELECT COUNT(de.id)
FROM users as u 
JOIN diary_entries as de 
  ON u.id = de.user_id
JOIN diary_entry_emotions dee 
  ON de.id = dee.diary_entry_id
WHERE u.id = ? 
  AND dee.emotion_id = 1;</code></pre>
                </div>
            </div>
        </div>

        <!-- 5. Aggregate Functions -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">5. Aggregate Functions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-red-50 p-4 rounded border">
                        <h4 class="font-semibold text-red-700 mb-2">📊 COUNT</h4>
                        <pre class="bg-gray-900 text-green-400 p-2 text-xs rounded overflow-auto"><code>DB::table('diary_entries')
    ->where('user_id', $userId)
    ->count()</code></pre>
                    </div>
                    <div class="bg-blue-50 p-4 rounded border">
                        <h4 class="font-semibold text-blue-700 mb-2">📉 MIN/MAX</h4>
                        <pre class="bg-gray-900 text-green-400 p-2 text-xs rounded overflow-auto"><code>// Earliest date
->min('date')

// Latest date  
->max('date')</code></pre>
                    </div>
                    <div class="bg-green-50 p-4 rounded border">
                        <h4 class="font-semibold text-green-700 mb-2">📊 AVERAGE</h4>
                        <pre class="bg-gray-900 text-green-400 p-2 text-xs rounded overflow-auto"><code>// Avg content length
->avg(DB::raw('LENGTH(content)'))</code></pre>
                    </div>
                    <div class="bg-purple-50 p-4 rounded border">
                        <h4 class="font-semibold text-purple-700 mb-2">➕ SUM</h4>
                        <pre class="bg-gray-900 text-green-400 p-2 text-xs rounded overflow-auto"><code>// Total word count
->sum(DB::raw('LENGTH(content)'))</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Raw Expressions with GROUP BY -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">6. Raw Expressions with GROUP BY and HAVING</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                <div class="bg-blue-50 p-4 rounded border">
                    <h3 class="font-semibold text-blue-700 mb-3">🔧 Query Builder</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>$dailyCount = DB::table('diary_entries')
    ->select('date', DB::raw('count(*) as count'))
    ->where('user_id', $userId)
    ->groupBy('date')
    ->having('count', '>=', 2)
    ->get();</code></pre>
                </div>
                <div class="bg-purple-50 p-4 rounded border">
                    <h3 class="font-semibent text-purple-700 mb-3">🗃️ Raw SQL</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>SELECT date, COUNT(*) as count
FROM diary_entries
WHERE user_id = ?
GROUP BY date
HAVING COUNT(*) >= 2;</code></pre>
                </div>
            </div>
        </div>

        <!-- 7. Safe Parameter Binding -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">7. 🛡️ SQL Injection Prevention</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                <div class="bg-red-100 border border-red-300 p-4 rounded">
                    <h3 class="font-semibold text-red-700 mb-3">❌ DANGEROUS - SQL Injection Risk</h3>
                    <pre class="bg-gray-900 text-red-400 p-3 text-xs rounded overflow-auto"><code>$date = $_GET['date']; // User input
$entries = DB::table('diary_entries')
    ->whereRaw("date = '$date'")
    ->get();
    
// If $date = "'; DROP TABLE users; --"
// SQL becomes: WHERE date = ''; DROP TABLE users; --'</code></pre>
                </div>
                <div class="bg-green-100 border border-green-300 p-4 rounded">
                    <h3 class="font-semibold text-green-700 mb-3">✅ SAFE - Parameter Binding</h3>
                    <pre class="bg-gray-900 text-green-400 p-3 text-xs rounded overflow-auto"><code>$startDate = $request->start_date;
$endDate = $request->end_date;

$entries = DB::table('diary_entries')
    ->whereRaw("date BETWEEN ? AND ?", 
               [$startDate, $endDate])
    ->get();
    
// Laravel safely escapes the values</code></pre>
                </div>
            </div>
        </div>

        <!-- 8. When to Use What -->
        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 px-6 py-4">
                <h2 class="text-xl font-bold text-white">8. 🤔 When to Use What?</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded border">
                        <h3 class="font-semibold text-blue-700 mb-3">🔧 Use Query Builder When:</h3>
                        <ul class="text-sm space-y-2 text-gray-700">
                            <li>✅ Need precise SQL control</li>
                            <li>✅ Building complex reporting queries</li>
                            <li>✅ Working with legacy databases</li>
                            <li>✅ Performance is critical</li>
                            <li>✅ Dynamic query building</li>
                            <li>✅ Creating dropdowns (pluck)</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 p-4 rounded border">
                        <h3 class="font-semibold text-green-700 mb-3">✨ Use Eloquent When:</h3>
                        <ul class="text-sm space-y-2 text-gray-700">
                            <li>✅ Working with model relationships</li>
                            <li>✅ Need model events/observers</li>
                            <li>✅ Want clean, readable code</li>
                            <li>✅ Using accessors/mutators</li>
                            <li>✅ Rapid prototyping</li>
                            <li>✅ Standard CRUD operations</li>
                        </ul>
                    </div>
                    <div class="bg-purple-50 p-4 rounded border">
                        <h3 class="font-semibold text-purple-700 mb-3">🗃️ Use Raw SQL When:</h3>
                        <ul class="text-sm space-y-2 text-gray-700">
                            <li>✅ Extremely complex queries</li>
                            <li>✅ Database-specific functions</li>
                            <li>✅ Performance optimization</li>
                            <li>✅ Stored procedures</li>
                            <li>✅ Migration from existing SQL</li>
                            <li>✅ Advanced window functions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg p-6 text-white text-center">
            <h2 class="text-2xl font-bold mb-4">🎯 Key Takeaways</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div>
                    <h3 class="font-semibold mb-2">🔍 pluck() vs select():</h3>
                    <p class="text-sm">Use <code class="bg-purple-500 px-2 py-1 rounded">pluck()</code> for flat arrays and dropdowns. Use <code class="bg-purple-500 px-2 py-1 rounded">select()</code> when you need object structure.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">🛡️ Security First:</h3>
                    <p class="text-sm">Always use parameter binding with <code class="bg-purple-500 px-2 py-1 rounded">whereRaw()</code> to prevent SQL injection attacks.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">⚡ Performance:</h3>
                    <p class="text-sm">Query Builder can be faster for complex queries, while Eloquent is better for relationships and readability.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">🎨 Choose Wisely:</h3>
                    <p class="text-sm">Pick the right tool for the job - Query Builder for control, Eloquent for convenience, Raw SQL for complexity.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection