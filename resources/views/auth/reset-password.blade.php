<x-guest-layout>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white text-center">
        Reset Password
    </h2>

    <div class="mb-7 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('Masukkan password baru untuk akunmu. Password harus minimal 8 karakter.') }}
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" 
                    class="block mt-1 w-full pr-10"
                    x-bind:type="show ? 'text' : 'password'"
                    name="password"
                    required autocomplete="new-password" />

                <button type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                    <i x-bind:class="show ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ showConfirm: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" 
                    class="block mt-1 w-full pr-10"
                    x-bind:type="showConfirm ? 'text' : 'password'"
                    name="password_confirmation"
                    required autocomplete="new-password" />

                <button type="button"
                    @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                    <i x-bind:class="showConfirm ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="flex flex-col gap-2 items-center justify-end mt-6">
            <x-primary-button class="w-full">
                {{ __('Reset Password') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('kembali ke Login?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
