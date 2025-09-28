<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 shadow-2xl">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-4 -left-4 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
                <div class="absolute top-10 right-10 w-24 h-24 bg-yellow-300/20 rounded-full animate-float animation-delay-2s"></div>
                <div class="absolute -bottom-8 right-1/3 w-40 h-40 bg-pink-300/15 rounded-full animate-float animation-delay-4s"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <h2 class="font-bold text-4xl text-white mb-2 animate-fade-in-down">
                    ✨ Dashboard
                </h2>
                <p class="text-white/80 text-lg animate-fade-in-up animation-delay-300">
                    Welcome to your personal command center
                </p>
            </div>
        </div>
    </x-slot>

    <!-- Animated Background -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-slate-900 dark:to-indigo-900 relative overflow-hidden py-10">
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-10 w-64 h-64 bg-purple-300/30 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-1/3 right-10 w-64 h-64 bg-yellow-300/30 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-64 h-64 bg-pink-300/30 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8 relative z-10">

            {{-- Profile Card --}}
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 hover:shadow-3xl transition-all duration-700 hover:-translate-y-2 animate-slide-in-up">
                <!-- Gradient Border -->
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 via-blue-500 to-pink-500 rounded-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                
                <div class="relative flex flex-col lg:flex-row items-center gap-8">
                    {{-- Avatar Section --}}
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-spin-slow opacity-75"></div>
                        <img
                            src="{{ $user->avatar_url }}"
                            alt="Profile photo"
                            class="relative w-32 h-32 rounded-full ring-8 ring-white/50 dark:ring-gray-700/50 object-cover bg-white shadow-2xl transform group-hover:scale-110 transition-transform duration-500"
                        />
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                            <span class="text-white text-sm">✓</span>
                        </div>
                    </div>

                    {{-- User Info --}}
                    <div class="flex-1 text-center lg:text-left">
                        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                            <div>
                                <h3 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mt-2 text-lg">
                                    📧 {{ $user->email }}
                                </p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                               class="group/btn inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <span class="group-hover/btn:animate-spin">⚙️</span> แก้ไขโปรไฟล์
                            </a>
                        </div>

                        {{-- Birthdate + Age --}}
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="group/card bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl border-2 border-blue-200 dark:border-blue-600 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center text-white">
                                        🎂
                                    </div>
                                    <p class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-400">วันเกิด</p>
                                </div>
                                <p class="font-bold text-xl text-gray-900 dark:text-gray-100 group-hover/card:text-blue-600 dark:group-hover/card:text-blue-400 transition-colors">
                                    {{ $birthdateLabel ?? '—' }}
                                </p>
                            </div>
                            <div class="group/card bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-2xl border-2 border-purple-200 dark:border-purple-600 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white">
                                        🎈
                                    </div>
                                    <p class="ml-3 text-sm font-medium text-purple-600 dark:text-purple-400">อายุ</p>
                                </div>
                                <p class="font-bold text-xl text-gray-900 dark:text-gray-100 group-hover/card:text-purple-600 dark:group-hover/card:text-purple-400 transition-colors">
                                    {{ $ageYears !== null ? $ageYears.' ปี' : '—' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Greeting Banner --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl p-8 shadow-2xl text-white animate-slide-in-left animation-delay-300">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-0 left-0 w-full h-full">
                        <div class="absolute top-4 left-4 w-16 h-16 border-2 border-white/30 rounded-full animate-ping"></div>
                        <div class="absolute bottom-4 right-4 w-20 h-20 border-2 border-white/20 rounded-full animate-ping animation-delay-1000"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border border-white/10 rounded-full animate-spin-slow"></div>
                    </div>
                </div>
                
                <div class="relative z-10 text-center">
                    <h3 class="text-2xl md:text-4xl font-bold mb-3">
                        สวัสดี, {{ $user->name ?? 'User' }} 
                        <span class="animate-wave inline-block">👋</span>
                    </h3>
                    <p class="text-lg md:text-xl opacity-90">
                        <span class="animate-pulse">✨</span> 
                        ยินดีต้อนรับกลับเข้าสู่ระบบ! 
                        <span class="animate-bounce inline-block">🎉</span>
                    </p>
                    <div class="mt-4 flex justify-center">
                        <div class="flex space-x-1">
                            <div class="w-3 h-3 bg-white/60 rounded-full animate-bounce"></div>
                            <div class="w-3 h-3 bg-white/60 rounded-full animate-bounce animation-delay-200"></div>
                            <div class="w-3 h-3 bg-white/60 rounded-full animate-bounce animation-delay-400"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-slide-in-right animation-delay-500">
                <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center border border-white/20 hover:shadow-3xl transition-all duration-500 hover:-translate-y-4 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:animate-bounce">
                            🔗
                        </div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3">จำนวน Social Links</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent animate-pulse">
                            {{ number_format($stats['links_count'] ?? 0) }}
                        </p>
                        <div class="mt-4 h-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    </div>
                </div>
                
                <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center border border-white/20 hover:shadow-3xl transition-all duration-500 hover:-translate-y-4 overflow-hidden animation-delay-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:animate-bounce">
                            📅
                        </div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3">วันที่สมัคร</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ $user->created_at?->format('d M Y') }}
                        </p>
                        <div class="mt-4 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    </div>
                </div>
                
                <div class="group relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center border border-white/20 hover:shadow-3xl transition-all duration-500 hover:-translate-y-4 overflow-hidden animation-delay-400">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400/20 to-pink-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg group-hover:animate-bounce">
                            ⭐
                        </div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3">จำนวนวันที่อยู่กับเรา</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $stats['joined_days'] ?? 0 }} <span class="text-2xl">วัน</span>
                        </p>
                        <div class="mt-4 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 animate-slide-in-up animation-delay-700">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        ⚡
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 ml-4">เมนูด่วน</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('social-links.create') }}"
                       class="group relative overflow-hidden px-6 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white hover:from-emerald-600 hover:to-teal-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 text-center">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <span class="text-2xl group-hover:animate-bounce inline-block">➕</span>
                            <br><span class="text-sm font-medium">เพิ่ม Social Link</span>
                        </div>
                    </a>
                    <a href="{{ route('social-links.index') }}"
                       class="group relative overflow-hidden px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 text-center">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <span class="text-2xl group-hover:animate-pulse inline-block">📋</span>
                            <br><span class="text-sm font-medium">ดู Social Links ทั้งหมด</span>
                        </div>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="group relative overflow-hidden px-6 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 text-center">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <span class="text-2xl group-hover:animate-spin inline-block">⚙️</span>
                            <br><span class="text-sm font-medium">แก้ไขโปรไฟล์</span>
                        </div>
                    </a>
                    <a href="{{ route('query-builder.index') }}"
                       class="group relative overflow-hidden px-6 py-4 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 text-white hover:from-purple-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 text-center">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <span class="text-2xl group-hover:animate-pulse inline-block">🔍</span>
                            <br><span class="text-sm font-medium">Query Builder Examples</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Recent Social Links --}}
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 animate-slide-in-left animation-delay-900">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg animate-pulse">
                        🔗
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 ml-4">
                        Social Links ล่าสุด
                    </h3>
                </div>
                
                @if($user->socialMediaLinks->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->socialMediaLinks->take(5) as $index => $link)
                            <div class="group bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900/30 rounded-2xl p-4 border border-blue-200 dark:border-blue-600 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 animate-slide-in-right" style="animation-delay: {{ ($index + 1) * 100 }}ms">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ substr($link->platform_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-800 dark:text-gray-200 text-lg">
                                            {{ $link->platform_name }}
                                        </span>
                                    </div>
                                    <a href="{{ $link->url }}" target="_blank"
                                       class="group/link px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <span class="group-hover/link:animate-bounce inline-block">🚀</span>
                                        <span class="ml-1 font-medium">Visit</span>
                                    </a>
                                </div>
                                <div class="mt-3 ml-13">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                        {{ $link->url }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-full mx-auto mb-6 flex items-center justify-center text-4xl animate-bounce">
                            😔
                        </div>
                        <p class="text-xl text-gray-500 dark:text-gray-400 mb-4">
                            ยังไม่มี Social Links
                        </p>
                        <p class="text-gray-400 dark:text-gray-500 mb-6">
                            เริ่มต้นเพิ่ม Social Link แรกของคุณกันเถอะ!
                        </p>
                        <a href="{{ route('social-links.create') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-2xl hover:from-emerald-600 hover:to-teal-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <span class="animate-bounce">➕</span>
                            เพิ่ม Social Link แรก
                        </a>
                    </div>
                @endif
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

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-30px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-up {
    0% { opacity: 0; transform: translateY(30px); }
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

@keyframes spin-slow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
}

.animate-blob { animation: blob 7s infinite; }
.animate-float { animation: float 6s ease-in-out infinite; }
.animate-fade-in-down { animation: fade-in-down 0.8s ease-out; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out; }
.animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
.animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
.animate-slide-in-up { animation: slide-in-up 0.8s ease-out; }
.animate-spin-slow { animation: spin-slow 8s linear infinite; }
.animate-wave { animation: wave 2s ease-in-out infinite; }

.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-300 { animation-delay: 300ms; }
.animation-delay-400 { animation-delay: 400ms; }
.animation-delay-500 { animation-delay: 500ms; }
.animation-delay-700 { animation-delay: 700ms; }
.animation-delay-900 { animation-delay: 900ms; }
.animation-delay-1000 { animation-delay: 1000ms; }
.animation-delay-2s { animation-delay: 2s; }
.animation-delay-4s { animation-delay: 4s; }

/* Gradient Text */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}

/* Glass Effect */
.backdrop-blur-sm {
    backdrop-filter: blur(12px);
}

/* Shadow Variants */
.shadow-3xl {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}
</style>

</x-app-layout>
