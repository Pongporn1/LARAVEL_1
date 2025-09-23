<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-emerald-500">➕ เพิ่ม Social Link</h2>
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

                <form method="POST" action="{{ route('social-links.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-emerald-400">แพลตฟอร์ม</label>
                        <input type="text" name="platform_name"
                               value="{{ old('platform_name') }}"
                               class="mt-2 w-full rounded-xl border-emerald-200 dark:border-gray-700 bg-white dark:bg-gray-900
                                      focus:border-emerald-500 focus:ring-emerald-500 px-4 py-2.5 text-emerald-600 placeholder-emerald-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-emerald-400">URL</label>
                        <input type="url" name="url" placeholder="https://..."
                               value="{{ old('url') }}"
                               class="mt-2 w-full rounded-xl border-emerald-200 dark:border-gray-700 bg-white dark:bg-gray-900
                                      focus:border-emerald-500 focus:ring-emerald-500 px-4 py-2.5 text-emerald-600 placeholder-emerald-300">
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('social-links.index') }}"
                           class="px-4 py-2 rounded-xl border border-emerald-200 text-emerald-500 hover:bg-emerald-50">
                            ยกเลิก
                        </a>
                        <button class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition">
                            บันทึก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
