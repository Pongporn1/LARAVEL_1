<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100">
                {{ __('Create Diary') }}
            </h2>
            <a href="{{ route('diary.index') }}"
               class="text-sm px-3 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-100">
               {{ __('Back to list') }}
            </a>
        </div>
    </x-slot>

    {{-- Hero / Greeting --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div
            class="rounded-2xl p-5 sm:p-6
                   bg-gradient-to-r from-emerald-500 to-teal-500
                   text-white shadow-lg">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <!-- icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2
                               2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm/5 opacity-90">{{ __('Write your feeling today') }}</p>
                    <h3 class="text-xl font-semibold">{{ __('New Diary Entry') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-12">
        <div class="bg-gray-900/60 backdrop-blur rounded-2xl border border-gray-700 shadow-xl">
            <form method="POST" action="{{ route('diary.store') }}" class="p-6 sm:p-8 space-y-6">
                @csrf

                {{-- 1) Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">
                        {{ __('Date') }}
                    </label>
                    <input type="date" name="date" value="{{ old('date') }}"
                           class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                  focus:border-emerald-500 p-3"
                           required autofocus>
                    @error('date')
                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-400">{{ __('Choose the day you’re writing for') }}</p>
                    @enderror
                </div>

                {{-- 2) Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">
                        {{ __('Title (optional)') }}
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="{{ __('e.g. A calm day at the park') }}"
                           class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                  placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                  focus:border-emerald-500 p-3">
                    @error('title')
                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-400">{{ __('Short headline for your entry') }}</p>
                    @enderror
                </div>

                {{-- 3) Content --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">
                        {{ __('Content') }}
                    </label>
                    <textarea name="content" rows="7"
                              placeholder="{{ __('Write anything you like…') }}"
                              class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                     placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                     focus:border-emerald-500 p-3 resize-y"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                    @else
                        <div class="mt-2 flex items-center justify-between text-xs text-gray-400">
                            <span>{{ __('Tip: be yourself 💬') }}</span>
                            <span id="charCount"></span>
                        </div>
                    @enderror
                </div>

                {{-- 4) Tags --}}
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Tags</label>
                  <div class="flex flex-wrap gap-4">
                    @foreach($tags as $tag)
                      <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="h-5 w-5">
                        <span>{{ $tag->name }}</span>
                      </label>
                    @endforeach
                  </div>
                  @error('tags') <div class="text-red-500 text-sm mt-2">{{ $message }}</div> @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 sm:gap-4 sm:justify-end">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-xl
                              border border-gray-700 text-gray-200 hover:bg-gray-800">
                        {{ __('Cancel') }}
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl
                                   bg-emerald-600 hover:bg-emerald-500 text-white font-medium
                                   shadow-lg shadow-emerald-600/20">
                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        {{ __('Save Entry') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Optional small script: live char count --}}
    <script>
        const ta = document.querySelector('textarea[name="content"]');
        const out = document.getElementById('charCount');
        if (ta && out) {
            const update = () => out.textContent = `${ta.value.length} {{ __('characters') }}`;
            ta.addEventListener('input', update); update();
        }
    </script>
</x-app-layout>
