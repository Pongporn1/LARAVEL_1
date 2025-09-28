@extends('layouts.app')

@section('content')
<!-- Animated Background -->
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 relative overflow-hidden">
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -top-4 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Hero Header -->
            <div class="text-center mb-12 animate-fade-in-down">
                <div class="inline-block p-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl mb-6 shadow-lg">
                    <div class="bg-white dark:bg-gray-900 rounded-xl px-8 py-4">
                        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            ⚡ Laravel Query Builder
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                            Interactive Database Query Examples
                        </p>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex justify-center space-x-4 mb-8">
                    <a href="{{ route('query-builder.comparison') }}" 
                       class="group bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span class="group-hover:animate-pulse">📊</span> View Comparison
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="group bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span class="group-hover:animate-bounce">🏠</span> Dashboard
                    </a>
                </div>
            </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            
            <!-- Basic Operations -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-left">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        ⚙️
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Basic Operations</h2>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('query-builder.display-diary') }}" 
                       class="group/btn block bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">📋</span> Display All Diary Entries
                    </a>
                    <a href="{{ route('query-builder.contents') }}" 
                       class="group/btn block bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">📄</span> Get Contents (pluck)
                    </a>
                    <a href="{{ route('query-builder.titles-dropdown') }}" 
                       class="group/btn block bg-gradient-to-r from-purple-500 to-violet-600 hover:from-purple-600 hover:to-violet-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-spin">⚡</span> Titles for Dropdown (pluck with key)
                    </a>
                    <a href="{{ route('query-builder.sorted') }}" 
                       class="group/btn block bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">🔄</span> Sorted Diary Entries
                    </a>
                    <a href="{{ route('query-builder.count') }}" 
                       class="group/btn block bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">🔢</span> Count Diary Entries
                    </a>
                    <a href="{{ route('query-builder.statistics') }}" 
                       class="group/btn block bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">📊</span> Diary Statistics (Aggregates)
                    </a>
                </div>
            </div>

            <!-- Search and Filtering -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-up">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        🔍
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Search & Filtering</h2>
                </div>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 border border-blue-200 dark:border-gray-600">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">🔎 Search in diary:</label>
                        <div class="flex shadow-lg rounded-xl overflow-hidden">
                            <input type="text" id="searchInput" placeholder="Enter keyword..." 
                                   class="flex-1 px-4 py-3 border-0 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-gray-800 dark:text-white bg-white transition-all duration-300">
                            <button onclick="searchDiary()" 
                                    class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 transition-all duration-300 transform hover:scale-105">
                                <span class="animate-pulse">🚀</span> Search
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('query-builder.filtered') }}" 
                       class="group/btn block bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">⚡</span> Advanced Filtering
                    </a>
                    <a href="{{ route('query-builder.unique-dates') }}" 
                       class="group/btn block bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">📅</span> Unique Dates (Distinct)
                    </a>
                </div>
            </div>

            <!-- Joins and Relationships -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-right">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        🔗
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Joins & Relationships</h2>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('query-builder.with-users') }}" 
                       class="group/btn block bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">👥</span> Entries with User Info (Join)
                    </a>
                    <a href="{{ route('query-builder.happy-count') }}" 
                       class="group/btn block bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">😊</span> Happy Diary Count (Multi-Join)
                    </a>
                    <a href="{{ route('query-builder.with-tags') }}" 
                       class="group/btn block bg-gradient-to-r from-lime-500 to-green-600 hover:from-lime-600 hover:to-green-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">🏷️</span> Entries with Tags
                    </a>
                    <a href="{{ route('query-builder.emotion-stats') }}" 
                       class="group/btn block bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">💭</span> Emotion Statistics
                    </a>
                </div>
            </div>

            <!-- Advanced Queries -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-left animation-delay-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        🚀
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Advanced Queries</h2>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('query-builder.daily-count') }}" 
                       class="group/btn block bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">📈</span> Daily Entry Count (Raw + Having)
                    </a>
                    <a href="{{ route('query-builder.count-between') }}" 
                       class="group/btn block bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">📊</span> Count Between Range
                    </a>
                    <a href="{{ route('query-builder.prolific-users') }}" 
                       class="group/btn block bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">⭐</span> Prolific Users (Having Raw)
                    </a>
                    <a href="{{ route('query-builder.monthly-summary') }}" 
                       class="group/btn block bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">📅</span> Monthly Summary
                    </a>
                    <a href="{{ route('query-builder.emotion-summary') }}" 
                       class="group/btn block bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">💝</span> Emotion Summary (Practice)
                    </a>
                    <a href="{{ route('query-builder.conflicting-emotions') }}" 
                       class="group/btn block bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 ring-2 ring-red-300 animate-pulse">
                        <span class="group-hover/btn:animate-bounce">🚨</span> Conflicting Emotions (Lab Task)
                    </a>
                    <a href="{{ route('query-builder.users-latest') }}" 
                       class="group/btn block bg-gradient-to-r from-stone-500 to-gray-600 hover:from-stone-600 hover:to-gray-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">🔍</span> Users with Latest Entry (Subquery)
                    </a>
                </div>
            </div>

            <!-- Pagination -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-up animation-delay-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-gray-500 to-slate-600 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        📑
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Pagination & Utilities</h2>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('query-builder.paginated') }}" 
                       class="group/btn block bg-gradient-to-r from-gray-500 to-slate-600 hover:from-gray-600 hover:to-slate-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-bounce">📄</span> Paginated Entries
                    </a>
                    <a href="{{ route('query-builder.tags-dropdown') }}" 
                       class="group/btn block bg-gradient-to-r from-neutral-500 to-zinc-600 hover:from-neutral-600 hover:to-zinc-700 text-white px-4 py-3 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">🏷️</span> Tags Dropdown (pluck)
                    </a>
                </div>
            </div>

            <!-- Date Range Search -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-slide-in-right animation-delay-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        📆
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white ml-4">Date Range Search</h2>
                </div>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 border border-indigo-200 dark:border-gray-600">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Start Date</label>
                                <input type="date" id="startDate" 
                                       class="w-full px-3 py-2 border-0 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:bg-gray-800 dark:text-white bg-white shadow-inner transition-all duration-300">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">End Date</label>
                                <input type="date" id="endDate" 
                                       class="w-full px-3 py-2 border-0 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:bg-gray-800 dark:text-white bg-white shadow-inner transition-all duration-300">
                            </div>
                        </div>
                    </div>
                    <button onclick="searchByDateRange()" 
                            class="group/btn w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="group-hover/btn:animate-pulse">🔍</span> Search by Date Range (WhereRaw with Binding)
                    </button>
                </div>
            </div>

        </div>

        <!-- Results Section -->
        <div id="results" class="mt-12 bg-gradient-to-r from-gray-900 to-slate-800 rounded-3xl p-8 shadow-2xl border border-gray-700 animate-slide-in-up" style="display: none;">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold">
                    ⚡
                </div>
                <h3 class="text-xl font-bold text-white ml-4">Query Results</h3>
                <div class="ml-auto">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse animation-delay-200"></div>
                        <div class="w-3 h-3 bg-red-400 rounded-full animate-pulse animation-delay-500"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 rounded-2xl border border-gray-600 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-4 py-2 text-gray-300 text-sm font-mono">
                    💻 Query Output
                </div>
                <pre id="resultsContent" class="bg-gray-900 text-green-400 p-6 overflow-auto max-h-96 text-sm font-mono leading-relaxed"></pre>
            </div>
        </div>

        <!-- Code Explanation -->
        <div class="mt-12 bg-gradient-to-br from-yellow-100 via-orange-50 to-red-100 dark:from-yellow-900/20 dark:via-orange-900/20 dark:to-red-900/20 border-2 border-yellow-300 dark:border-yellow-600 rounded-3xl p-8 shadow-2xl animate-slide-in-up animation-delay-300">
            <div class="text-center mb-8">
                <div class="inline-block p-3 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl mb-4 shadow-lg">
                    <h2 class="text-2xl font-bold text-white">🔍 Understanding pluck() vs select()</h2>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Master the difference between these powerful Laravel methods</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="group bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm p-6 rounded-2xl border-2 border-blue-200 dark:border-blue-600 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold">
                            📋
                        </div>
                        <h3 class="font-bold text-blue-600 dark:text-blue-400 ml-3 text-lg">pluck('content') - Flat Array</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Returns a simple array of values:</p>
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl p-4 border border-gray-600">
                        <pre class="text-green-400 text-xs overflow-auto font-mono">
[
    "My first diary",
    "Laravel notes", 
    "Vacation plans"
]</pre>
                    </div>
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <p class="text-xs text-blue-700 dark:text-blue-300 font-medium">✨ Perfect for dropdowns and simple lists</p>
                    </div>
                </div>

                <div class="group bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm p-6 rounded-2xl border-2 border-green-200 dark:border-green-600 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center text-white font-bold">
                            📦
                        </div>
                        <h3 class="font-bold text-green-600 dark:text-green-400 ml-3 text-lg">select('content')->get() - Objects</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Returns collection of objects:</p>
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl p-4 border border-gray-600">
                        <pre class="text-green-400 text-xs overflow-auto font-mono">
[
    {"content": "My first diary"},
    {"content": "Laravel notes"},
    {"content": "Vacation plans"}
]</pre>
                    </div>
                    <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/30 rounded-xl">
                        <p class="text-xs text-green-700 dark:text-green-300 font-medium">✨ Use when you need object structure</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 p-6 rounded-2xl border-2 border-indigo-200 dark:border-indigo-600 shadow-inner">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold">
                        🔗
                    </div>
                    <h4 class="font-bold text-indigo-800 dark:text-indigo-300 ml-3 text-lg">pluck() with Key-Value pairs:</h4>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    <code class="bg-white/50 dark:bg-gray-800/50 px-2 py-1 rounded font-mono text-indigo-600 dark:text-indigo-400">pluck('name', 'id')</code> 
                    creates perfect dropdown arrays:
                </p>
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl p-4 border border-gray-600">
                    <pre class="text-green-400 text-xs font-mono">
[1 => "work", 2 => "study", 3 => "gardening"]</pre>
                </div>
            </div>
        </div>

        </div>
    </div>
</div>

<style>
/* Custom Animations */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-30px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes slide-in-left {
    0% { opacity: 0; transform: translateX(-50px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes slide-in-right {
    0% { opacity: 0; transform: translateX(50px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes slide-in-up {
    0% { opacity: 0; transform: translateY(50px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes glow {
    0%, 100% { box-shadow: 0 0 5px rgba(147, 51, 234, 0.5); }
    50% { box-shadow: 0 0 20px rgba(147, 51, 234, 0.8), 0 0 30px rgba(147, 51, 234, 0.6); }
}

.animate-blob { animation: blob 7s infinite; }
.animate-fade-in-down { animation: fade-in-down 0.8s ease-out; }
.animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
.animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
.animate-slide-in-up { animation: slide-in-up 0.8s ease-out; }
.animate-float { animation: float 3s ease-in-out infinite; }
.animate-glow { animation: glow 2s ease-in-out infinite; }

.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-300 { animation-delay: 300ms; }
.animation-delay-500 { animation-delay: 500ms; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }

/* Gradient Text */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}

/* Glass Effect */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

/* Hover Effects */
.group:hover .group-hover\:animate-pulse { animation: pulse 1s infinite; }
.group:hover .group-hover\:animate-bounce { animation: bounce 1s infinite; }
.group:hover .group-hover\:animate-spin { animation: spin 1s linear infinite; }

/* Responsive Grid */
@media (min-width: 1280px) {
    .xl\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #8b5cf6, #3b82f6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #7c3aed, #2563eb);
}
</style>

<script>
function searchDiary() {
    const keyword = document.getElementById('searchInput').value;
    if (keyword) {
        fetchAndDisplayResults(`/query-builder/diary/search/${encodeURIComponent(keyword)}`);
    }
}

function searchByDateRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (startDate && endDate) {
        fetchAndDisplayResults(`/query-builder/diary/date-range/${startDate}/${endDate}`);
    } else {
        alert('Please select both start and end dates');
    }
}

async function fetchAndDisplayResults(url) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();
        
        document.getElementById('results').style.display = 'block';
        document.getElementById('resultsContent').textContent = JSON.stringify(data, null, 2);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('results').style.display = 'block';
        document.getElementById('resultsContent').textContent = 'Error fetching data: ' + error.message;
    }
}

// Add click handlers to all links to show results
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href*="query-builder"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            fetchAndDisplayResults(this.href);
        });
    });
});
</script>
@endsection