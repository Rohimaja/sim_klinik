<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Skrining Pasien') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">


                <!-- Info Pasien -->
                <div class="p-6 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">No. RM</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">RM-001234</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Nama Pasien</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">Budi Santoso</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Umur</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">32 tahun</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Jenis Kelamin</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">Laki-laki</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Tanda Vital -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-heartbeat text-blue-500"></i>
                            Tanda Vital
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Tekanan Darah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tekanan Darah <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" placeholder="Sistol" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100" required>
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">/</span>
                                    <input type="number" placeholder="Diastolik" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100" required>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">mmHg</span>
                                </div>
                            </div>

                            <!-- Suhu -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Suhu Tubuh <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" step="0.1" placeholder="36.5" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100" required>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">°C</span>
                                </div>
                            </div>

                            <!-- Berat Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Berat Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" step="0.1" placeholder="70" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">kg</span>
                                </div>
                            </div>

                            <!-- Tinggi Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tinggi Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" placeholder="170" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">cm</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-between border-t pt-6 gap-3">
                        
                        <a href="{{ route('perawat.kunjungan.index') }}"
                            class="px-6 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 text-center font-medium transition-colors">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </a>

                        <div class="flex gap-3">
                            <button type="reset"
                                class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-md font-medium transition-colors">
                                <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                            </button>

                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md font-medium transition-colors">
                                <i class="fa-solid fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>