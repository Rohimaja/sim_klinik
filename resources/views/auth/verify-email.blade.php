<x-guest-layout>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white text-center">
        Verifikasi Email
    </h2>

    <div class="mb-4 text-sm text-center text-gray-600 dark:text-gray-400">
        {{ __('Masukkan email yang terhubung dengan akunmu. Kami akan mengirimkan link verifikasi ke email tersebut untuk mengaktifkan akunmu.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('verify.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4 items-center justify-end mt-9">
            <x-primary-button class="w-full">
                {{ __('Kirim Verifikasi Email') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('kembali ke Login?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
