<x-guest-layout>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white text-center">
        Login
    </h2>

    <div class="mb-7 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('Silahkan Login Untuk Mengakses Akun Anda.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <!-- Input password -->
                <input id="password"
                    class="block mt-1 w-full pr-10 border-gray-300 rounded-md shadow-sm"
                    x-bind:type="show ? 'text' : 'password'"
                    name="password"
                    required autocomplete="current-password" />

                <!-- Tombol icon mata -->
                <button type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 transition">
                    <i x-bind:class="show ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>




        <!-- Remember Me -->
        <div class="block mt-4 mb-9">
            <div class="flex justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Aku') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md"
                href="{{ route('verification.form') }}">
                {{ __('Verifikasi Email?') }}
            </a>
        </div>

    </form>
</x-guest-layout>
