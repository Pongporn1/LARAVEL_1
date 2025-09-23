<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-amber-400">✏️ แก้ไข Social Link</h2>
            <a href="{{ route('social-links.index') }}" class="text-sm text-emerald-400 hover:underline">กลับหน้ารายการ</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="rounded-2xl bg-white/90 dark:bg-gray-800 shadow p-6 space-y-6">

                @if ($errors->any())
                    <div class="rounded-xl bg-rose-50 text-rose-700 px-4 py-3 border border-rose-200">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('social-links.update', $social_link) }}" class="space-y-6">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-emerald-400">แพลตฟอร์ม</label>
                        <input type="text" name="platform_name"
                               value="{{ old('platform_name', $social_link->platform_name) }}"
                               class="mt-2 w-full rounded-xl border-amber-200 dark:border-gray-700 bg-white dark:bg-gray-900
                                      focus:border-amber-500 focus:ring-amber-500 px-4 py-2.5 text-emerald-600 placeholder-emerald-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-emerald-400">URL</label>
                        <input type="url" name="url"
                               value="{{ old('url', $social_link->url) }}"
                               class="mt-2 w-full rounded-xl border-amber-200 dark:border-gray-700 bg-white dark:bg-gray-900
                                      focus:border-amber-500 focus:ring-amber-500 px-4 py-2.5 text-emerald-600 placeholder-emerald-300">
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('social-links.index') }}"
                           class="px-4 py-2 rounded-xl border border-emerald-200 text-emerald-500 hover:bg-emerald-50">
                            กลับ
                        </a>
                        <button class="px-5 py-2.5 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition">
                            อัปเดต
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
