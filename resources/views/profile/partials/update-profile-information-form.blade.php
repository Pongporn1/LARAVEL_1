<section>
    {{-- Header is now handled by the parent container --}}

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="group">
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 flex items-center">
                <span class="w-5 h-5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mr-2 flex items-center justify-center text-white text-xs">👤</span>
                {{ __('Name') }}
            </x-input-label>
            <x-text-input id="name" name="name" type="text" 
                          class="mt-1 block w-full rounded-xl border-2 border-blue-200 dark:border-blue-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-all duration-300 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 flex items-center">
                <span class="w-5 h-5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mr-2 flex items-center justify-center text-white text-xs">📧</span>
                {{ __('Email') }}
            </x-input-label>
            <x-text-input id="email" name="email" type="email" 
                          class="mt-1 block w-full rounded-xl border-2 border-purple-200 dark:border-purple-600 focus:border-purple-500 focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-800 transition-all duration-300 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm"
                          :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Bio Information Section --}}
        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-2xl p-6 border border-cyan-200 dark:border-cyan-600">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center text-white font-bold">
                    📝
                </div>
                <h4 class="font-bold text-cyan-800 dark:text-cyan-300 ml-3 text-lg">
                    {{ __('Bio Information') }}
                </h4>
            </div>

            <div class="bg-white/60 dark:bg-gray-800/60 rounded-xl p-4 mb-4 border border-cyan-100 dark:border-cyan-700">
                <p class="text-gray-700 dark:text-gray-300 italic">
                    {{ $user->bio->bio ?? 'No bio available yet. Click below to add your personal bio!' }}
                </p>
            </div>

            <a href="{{ route('profile.show-bio') }}"
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 border border-transparent rounded-xl font-semibold text-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <span class="group-hover:animate-pulse mr-2">✏️</span>
                {{ __('Click to Manage Bio') }}
            </a>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-blue-200 dark:border-blue-600">
            <x-primary-button class="group px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <span class="group-hover:animate-pulse mr-2">💾</span>
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl border border-green-300 dark:border-green-600 animate-pulse">
                    <span class="mr-2">✅</span>
                    {{ __('Successfully Saved!') }}
                </p>
            @endif
        </div>
    </form>
</section>
