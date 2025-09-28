<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-8 shadow-2xl">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-4 -left-4 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
                <div class="absolute top-10 right-10 w-24 h-24 bg-cyan-300/20 rounded-full animate-float animation-delay-2s"></div>
                <div class="absolute -bottom-8 right-1/3 w-40 h-40 bg-pink-300/15 rounded-full animate-float animation-delay-4s"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <div class="inline-flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center animate-pulse">
                        <span class="text-white text-2xl">👤</span>
                    </div>
                    <h2 class="font-bold text-4xl text-white animate-fade-in-down">
                        Profile Settings
                    </h2>
                </div>
                <p class="text-white/80 text-lg animate-fade-in-up animation-delay-300">
                    Manage your personal information and account settings
                </p>
            </div>
        </div>
    </x-slot>

    <!-- Animated Background -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-100 dark:from-gray-900 dark:via-slate-900 dark:to-purple-900 relative overflow-hidden py-12">
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-10 w-72 h-72 bg-blue-300/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-1/3 right-10 w-72 h-72 bg-purple-300/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-indigo-300/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">
            <!-- Profile Information Section -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/20 hover:shadow-3xl transition-all duration-700 hover:-translate-y-2 animate-slide-in-up">
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:animate-bounce">
                            📝
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Information</h3>
                            <p class="text-gray-600 dark:text-gray-400">Update your account's profile information and email address</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-600">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Profile Photo Section -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/20 hover:shadow-3xl transition-all duration-700 hover:-translate-y-2 animate-slide-in-left animation-delay-200">
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:animate-spin">
                            📸
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Photo</h3>
                            <p class="text-gray-600 dark:text-gray-400">Update your profile photo to personalize your account</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-600">
                        @include('profile.partials.update-profile-photo-form')
                    </div>
                </div>
            </div>

            <!-- Update Password Section -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/20 hover:shadow-3xl transition-all duration-700 hover:-translate-y-2 animate-slide-in-right animation-delay-400">
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:animate-pulse">
                            🔒
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Update Password</h3>
                            <p class="text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password to stay secure</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border border-green-200 dark:border-green-600">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/20 hover:shadow-3xl transition-all duration-700 hover:-translate-y-2 animate-slide-in-up animation-delay-600">
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:animate-bounce">
                            ⚠️
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Delete Account</h3>
                            <p class="text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 rounded-2xl p-6 border border-red-200 dark:border-red-600">
                        @include('profile.partials.delete-user-form')
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

.animate-blob { animation: blob 7s infinite; }
.animate-float { animation: float 6s ease-in-out infinite; }
.animate-fade-in-down { animation: fade-in-down 0.8s ease-out; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out; }
.animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
.animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
.animate-slide-in-up { animation: slide-in-up 0.8s ease-out; }

.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-300 { animation-delay: 300ms; }
.animation-delay-400 { animation-delay: 400ms; }
.animation-delay-600 { animation-delay: 600ms; }
.animation-delay-2s { animation-delay: 2s; }
.animation-delay-4s { animation-delay: 4s; }
.animation-delay-2000 { animation-delay: 2000ms; }
.animation-delay-4000 { animation-delay: 4000ms; }

/* Glass Effect */
.backdrop-blur-sm {
    backdrop-filter: blur(12px);
}

/* Shadow Variants */
.shadow-3xl {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Gradient Text */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}
</style>

</x-app-layout>
