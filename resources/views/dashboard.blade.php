<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 space-y-8">

            {{-- Profile Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 flex flex-col md:flex-row items-center gap-6">
                {{-- Avatar --}}
                <img
                    src="{{ $user->avatar_url }}"
                    alt="Profile photo"
                    class="w-28 h-28 rounded-full ring-4 ring-emerald-500/30 object-cover bg-white"
                />

                {{-- User Info --}}
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition">
                            ⚙️ แก้ไขโปรไฟล์
                        </a>
                    </div>

                    {{-- Birthdate + Age --}}
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">วันเกิด</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                {{ $birthdateLabel ?? '—' }}
                            </p>
                        </div>
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">อายุ</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                {{ $ageYears !== null ? $ageYears.' ปี' : '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Greeting Banner --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-lg text-white">
                <h3 class="text-xl md:text-2xl font-semibold">สวัสดี, {{ $user->name ?? 'User' }} 👋</h3>
                <p class="mt-2">ยินดีต้อนรับกลับเข้าสู่ระบบ!</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">จำนวน Social Links</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ number_format($stats['links_count'] ?? 0) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">วันที่สมัคร</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $user->created_at?->format('d M Y') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">จำนวนวันที่อยู่กับเรา</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $stats['joined_days'] ?? 0 }} วัน
                    </p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">เมนูด่วน</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('social-links.create') }}"
                       class="px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition">
                        ➕ เพิ่ม Social Link
                    </a>
                    <a href="{{ route('social-links.index') }}"
                       class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                        📋 ดู Social Links ทั้งหมด
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="px-4 py-2 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition">
                        ⚙️ แก้ไขโปรไฟล์
                    </a>
                </div>
            </div>

            {{-- Recent Social Links --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    🔗 Social Links ล่าสุด
                </h3>
                @if($user->socialMediaLinks->count() > 0)
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($user->socialMediaLinks->take(5) as $link)
                            <li class="py-3 flex items-center justify-between">
                                <span class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $link->platform_name }}
                                </span>
                                <a href="{{ $link->url }}" target="_blank"
                                   class="text-emerald-600 hover:underline">
                                    {{ $link->url }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 dark:text-gray-400 italic">
                        ยังไม่มี Social Links
                    </p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
