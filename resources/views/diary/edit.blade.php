<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100">
                {{ __('Edit Diary Entry') }}
            </h2>
            <a href="{{ route('diary.index') }}"
               class="text-sm px-3 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-100">
               {{ __('Back to list') }}
            </a>
        </div>
    </x-slot>

    {{-- Hero --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="rounded-2xl p-5 sm:p-6 bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v2a2 2 0 002 2h12M4 12l4 4 8-10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm/5 opacity-90">{{ __('Update your note') }}</p>
                    <h3 class="text-xl font-semibold">{{ $diaryEntry->title ?: __('Untitled') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-12">
        <div class="bg-gray-900/60 backdrop-blur rounded-2xl border border-gray-700 shadow-xl">
            <form method="POST" action="{{ route('diary.update', $diaryEntry) }}" class="p-6 sm:p-8 space-y-6">
                @csrf @method('PUT')

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">{{ __('Date') }}</label>
                    <input type="date" name="date"
                           value="{{ old('date', $diaryEntry->date?->format('Y-m-d')) }}"
                           class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 p-3"
                           required>
                    @error('date') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">{{ __('Title (optional)') }}</label>
                    <input type="text" name="title" value="{{ old('title', $diaryEntry->title) }}"
                           placeholder="{{ __('e.g. A better day') }}"
                           class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                  placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                  focus:border-emerald-500 p-3">
                    @error('title') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">{{ __('Content') }}</label>
                    <textarea name="content" rows="7"
                              class="w-full rounded-xl border border-gray-700 bg-gray-800 text-gray-100
                                     placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500
                                     focus:border-emerald-500 p-3 resize-y"
                              required>{{ old('content', $diaryEntry->content) }}</textarea>
                    @error('content') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
                </div>

                {{-- Emotions --}}
                <div class="mb-1">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Select Emotions</label>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($emotions as $emotion)
                            <div class="flex items-center mb-1">
                                {{-- checkbox --}}
                                <input type="checkbox"
                                       id="emotion_{{ $emotion->id }}"
                                       name="emotions[]"
                                       value="{{ $emotion->id }}"
                                       {{ in_array($emotion->id, old('emotions', $diaryEntry->emotions->pluck('id')->toArray())) ? 'checked' : '' }}
                                       onchange="toggleIntensityInput({{ $emotion->id }})"
                                       class="h-5 w-5 text-emerald-500 rounded border-gray-600 bg-gray-800">

                                <label for="emotion_{{ $emotion->id }}"
                                       class="ml-2 text-gray-200">{{ $emotion->name }}</label>

                                {{-- intensity (ซ่อนถ้าไม่ถูกติ๊ก) --}}
                                <div id="intensity_container_{{ $emotion->id }}"
                                     class="ml-4 {{ in_array($emotion->id, old('emotions', $diaryEntry->emotions->pluck('id')->toArray())) ? '' : 'hidden' }}">
                                    <input type="number"
                                           name="intensity[{{ $emotion->id }}]"
                                           min="1" max="10"
                                           class="w-32 rounded-md border border-gray-700 bg-gray-800 text-gray-100 p-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                           value="{{ old('intensity.' . $emotion->id, $diaryEntry->emotions->find($emotion->id)?->pivot?->intensity) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('emotions')
                        <div class="text-rose-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tags --}}
<div class="mb-4">
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Tags</label>
  <div class="flex flex-wrap gap-4">
    @foreach($tags as $tag)
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
               @checked(in_array($tag->id, old('tags', $diaryEntry->tags->pluck('id')->toArray())))>
        <span class="text-white">{{ $tag->name }}</span> {{-- 👈 เพิ่ม text-white --}}
      </label>
    @endforeach
  </div>
  @error('tags')
    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
  @enderror
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        {{ __('Update Entry') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script: toggle intensity --}}
    <script>
    function toggleIntensityInput(id){
        const cb = document.getElementById('emotion_' + id);
        const box = document.getElementById('intensity_container_' + id);
        const input = box?.querySelector('input');
        if (!box || !input) return;
        if (cb.checked) {
            box.classList.remove('hidden');
            input.setAttribute('required','required');
        } else {
            box.classList.add('hidden');
            input.removeAttribute('required');
            input.value = '';
        }
    }
    </script>
</x-app-layout>
