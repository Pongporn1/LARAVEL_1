<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-emerald-500">
                🌐 Social Links
            </h2>
            <a href="{{ route('social-links.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition">
                ➕ เพิ่มลิงก์
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- สรุปจำนวน --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-white/90 dark:bg-gray-800 shadow p-6 text-center">
                    <p class="text-sm text-emerald-400">จำนวนลิงก์ทั้งหมด</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-500">
                        {{ number_format($links->total()) }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white/90 dark:bg-gray-800 shadow p-6 text-center">
                    <p class="text-sm text-emerald-400">ช่วงลำดับในหน้านี้</p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-500">
                        {{ $links->count() ? ($links->firstItem().'–'.$links->lastItem()) : '—' }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white/90 dark:bg-gray-800 shadow p-6 text-center">
                    <p class="text-sm text-emerald-400">จำนวนหน้า</p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-500">
                        {{ $links->lastPage() }}
                    </p>
                </div>
            </div>

            {{-- ตารางลิงก์ --}}
            <div class="rounded-2xl bg-white/90 dark:bg-gray-800 shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-emerald-600/10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-emerald-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-emerald-500">แพลตฟอร์ม</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-emerald-500">URL</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold tracking-wider text-emerald-500">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-100 dark:divide-gray-700">
                        @forelse($links as $link)
                            <tr class="hover:bg-emerald-50/50 dark:hover:bg-gray-900/20 transition">
                                <td class="px-6 py-4 text-sm text-emerald-400">
                                    {{ $loop->iteration + ($links->firstItem() - 1) }}
                                </td>
                                <td class="px-6 py-4 font-medium text-emerald-500">
                                    {{ $link->platform_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <a class="text-emerald-400 hover:text-emerald-500 underline break-all"
                                       href="{{ $link->url }}" target="_blank" rel="noopener">
                                        {{ $link->url }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('social-links.edit', $link) }}"
                                           class="px-3 py-1.5 rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition">
                                            แก้ไข
                                        </a>
                                        <form action="{{ route('social-links.destroy', $link) }}"
                                              method="POST" onsubmit="return confirm('ลบลิงก์นี้?')">
                                            @csrf @method('DELETE')
                                            <button class="px-3 py-1.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700 transition">
                                                ลบ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-emerald-400">
                                    ยังไม่มี Social Link — คลิก “เพิ่มลิงก์” เพื่อเริ่มต้น
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- pagination --}}
            <div class="flex justify-center">
                {{ $links->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
