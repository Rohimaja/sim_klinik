<x-app-layout>
    <div class="py-8 max-w-6xl mx-auto px-4">
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-6 h-6 text-black dark:text-white" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="1.8" 
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 10-16 0"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Pengaturan Profil</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Atur profil anda dan pengaturan akun</p>
        </div>

        <!-- Menu Tabs -->
        <div class="mb-8">
            <div class="flex gap-2 border-b border-gray-200 dark:border-gray-700">
                @include('pengaturan.menu')
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
                <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Informasi Profil</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-8">Atur profil anda dan pengaturan akun</p>

                <form class="space-y-6">
                    <!-- Foto Profil -->
                    <div class="flex flex-col">
                        <div class="flex items-center gap-6 mb-6">
                            <div class="relative">
                                <img src="https://via.placeholder.com/120" alt="Foto Profil" 
                                    class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700">
                                <button type="button" class="absolute bottom-1 right-1 bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] text-white p-2 rounded-full hover:opacity-90 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Edwin Kurniawan" value="{{ $user->name ?? '' }}">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="edwin@gmail.com" value="{{ $user->email ?? '' }}">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Jember, Jl Kaca Piring No 27" value="{{ $user->address ?? '' }}">
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">No. Telepon</label>
                        <input type="tel" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="08165873897" value="{{ $user->phone ?? '' }}">
                    </div>

                    <!-- Button -->
                    <div class="flex justify-start pt-4">
                        <button type="submit" class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] hover:opacity-90 text-white font-medium px-8 py-2 rounded-full transition-opacity duration-300">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>