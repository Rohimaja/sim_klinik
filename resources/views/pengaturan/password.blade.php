<x-app-layout>
    <div class="py-8 max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-6 h-6 text-black dark:text-white" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 17h.01M8 11V8a4 4 0 118 0v3m-9 0h10a2 2 0 012 2v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7a2 2 0 012-2z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Pengaturan Password
                </h2>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Atur profil anda dan pengaturan akun
            </p>
        </div>

        <!-- Menu -->
        <div class="mb-8">
            <div class="flex gap-2 border-b border-gray-200 dark:border-gray-700">
                @include('pengaturan.menu')
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">

            <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                Pengaturan Perubahan Password
            </h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-8">
                Perbarui password akun Anda menggunakan form di bawah ini
            </p>

            <form class="space-y-6 max-w-xl">

                <!-- PASSWORD SAAT INI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password Saat Ini
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            class="password-field w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                            focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Password Saat Ini">

                        <button type="button"
                                class="toggle-password absolute right-4 top-2.5 text-gray-500 hover:text-purple-600 transition">
                            <!-- Eye Open -->
                            <svg class="w-5 h-5 eye-open" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd"
                                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                      clip-rule="evenodd"/>
                            </svg>

                            <!-- Eye Close -->
                            <svg class="w-5 h-5 eye-close hidden" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3l18 18M10.58 10.58a2 2 0 002.83 2.83M7.36 7.36A7.417 7.417 0 003 12c1.64 3.526 5.08 6 9 6a9.95 9.95 0 003.64-.69M14.12 14.12A3.999 3.999 0 0110 16a4 4 0 01-4-4 4 4 0 01.88-2.46"/>
                            </svg>
                        </button>
                    </div>
                </div>


                <!-- PASSWORD BARU -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password Baru
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            class="password-field w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                            focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Password Baru">

                        <button type="button"
                                class="toggle-password absolute right-4 top-2.5 text-gray-500 hover:text-purple-600 transition">
                            <svg class="w-5 h-5 eye-open" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd"
                                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                      clip-rule="evenodd"/>
                            </svg>

                            <svg class="w-5 h-5 eye-close hidden" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>


                <!-- KONFIRMASI PASSWORD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Konfirmasi Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            class="password-field w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                            focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Konfirmasi Password">

                        <button type="button"
                                class="toggle-password absolute right-4 top-2.5 text-gray-500 hover:text-purple-600 transition">
                            <svg class="w-5 h-5 eye-open" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd"
                                      d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                      clip-rule="evenodd"/>
                            </svg>

                            <svg class="w-5 h-5 eye-close hidden" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>


                <!-- Button -->
                <div class="flex justify-start pt-4">
                    <button type="submit"
                            class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)]
                            hover:opacity-90 text-white font-medium px-8 py-2 rounded-full
                            transition-all duration-300 shadow-md">
                        Save Password
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>

<!-- SCRIPT TOGGLE PASSWORD -->
<script>
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('.password-field');
        const eyeOpen = button.querySelector('.eye-open');
        const eyeClose = button.querySelector('.eye-close');

        if (input.type === "password") {
            input.type = "text";
            eyeOpen.classList.add("hidden");
            eyeClose.classList.remove("hidden");
        } else {
            input.type = "password";
            eyeOpen.classList.remove("hidden");
            eyeClose.classList.add("hidden");
        }
    });
});
</script>
