<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100">
                {{ __('My Diary') }}
            </h2>
            <a href="{{ route('diary.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                      bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                {{ __('Add New Entry') }}
            </a>
        </div>
    </x-slot>

    {{-- Hero --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="rounded-2xl p-5 sm:p-6 bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm/5 opacity-90">{{ __('Welcome back') }}</p>
                        <h3 class="text-xl font-semibold">{{ __('Your recent entries') }}</h3>
                    </div>
                </div>
                <a href="{{ route('diary.create') }}"
                   class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25">
                    {{ __('Write now') }}
                </a>
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-12">
        @if (session('status'))
            <div class="mb-4 rounded-xl border border-emerald-700/50 bg-emerald-900/40 text-emerald-200 px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        @if ($diaryEntries->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-700 bg-gray-900/60 p-10 text-center text-gray-300">
                <p class="text-lg">{{ __('No diary entries yet.') }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ __('Start your first note by clicking the button above!') }}</p>
            </div>
        @else
            <div class="grid gap-4 sm:gap-6 md:grid-cols-2">
                @foreach ($diaryEntries as $entry)
                    <div class="group rounded-2xl border border-gray-700 bg-gray-900/60 backdrop-blur p-5 shadow-xl hover:border-emerald-600/50 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-gray-400">
                                    {{ $entry->date?->format('D, d M Y') }}
                                </div>
                                <h3 class="mt-1 text-lg font-semibold text-gray-100">
                                    {{ $entry->title ?: __('Untitled') }}
                                </h3>
                            </div>
                            <span class="px-2 py-1 rounded-lg text-xs bg-emerald-600/20 text-emerald-300 border border-emerald-700/40">
                                {{ __('Diary') }}
                            </span>
                        </div>

                        <p class="mt-3 text-gray-300">
                            {{ \Illuminate\Support\Str::limit($entry->content, 200) }}
                        </p>

                        {{-- Emotions --}}
                        @if ($entry->emotions->isNotEmpty())
                            <div class="mt-4">
                                <h4 class="text-sm font-semibold text-gray-200 mb-1">Emotions</h4>
                                <ul class="ms-5 list-disc text-gray-300">
                                    @foreach ($entry->emotions as $emotion)
                                        <li>
                                            {{ $emotion->name }}
                                            <span class="ml-1 text-xs text-gray-400">
                                                (Intensity: {{ $emotion->pivot->intensity }})
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Tags (เพิ่มใหม่) --}}
                        @if ($entry->tags->isNotEmpty())
                            <div class="mt-4">
                                <h4 class="text-sm font-semibold text-gray-200 mb-1">Tags</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($entry->tags as $tag)
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs
                                                     bg-blue-200/70 text-blue-800
                                                     dark:bg-blue-900/40 dark:text-blue-200
                                                     border border-blue-500/20">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-5 flex items-center justify-end gap-2">
                            <a href="{{ route('diary.edit', $entry) }}"
                               class="inline-flex items-center px-3 py-2 rounded-xl
                                      border border-gray-700 text-gray-200 hover:bg-gray-800">
                                {{ __('Edit') }}
                            </a>

                            <form method="POST" action="{{ route('diary.destroy', $entry) }}"
                                  onsubmit="return confirm('{{ __('Delete this entry?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-2 rounded-xl
                                               bg-rose-600 hover:bg-rose-500 text-white">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
