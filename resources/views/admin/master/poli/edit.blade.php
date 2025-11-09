<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Edit Poli') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-hospital text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Edit Data Poli</h3>
                            <p class="text-blue-100 text-sm">Perbaruhi Data Poli dengan benar dan lengkap</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div x-data="{ editModal: false }">
                    <form action="#" method="POST" class="p-6 space-y-6" @submit.prevent="editModal = true">
                        @csrf

                        <!-- Section 3: Informasi Profesional -->
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-stethoscope text-purple-500"></i>
                                Informasi Poli
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- No. STR -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Poli <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_str" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Poli Umum" value="Poli Umum">
                                </div>

                                <!-- No. SIPP -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Keterangan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_sip" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Melayani pemeriksaan umum dan keluhan ringan" value="Melayani pemeriksaan umum dan keluhan ringan">
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Status Poli -->
                        <div class="border-l-4 border-teal-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-teal-500"></i>
                                Status Poli
                            </h4>

                            <div class="bg-teal-50 p-4 rounded-lg">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="status_aktif" value="1" checked
                                        class="w-5 h-5 text-teal-500 rounded focus:ring-teal-500">
                                    <span class="text-gray-700 font-semibold">
                                        <i class="fa-solid fa-circle-check text-teal-500 mr-1"></i>
                                        Aktifkan Poli
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 dark:border-gray-700 gap-3 sm:gap-0">
                            <!-- Tombol Kembali -->
                            <a href="{{route('admin.master-poli.index')}}"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium text-center">
                                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                            </a>

                            <!-- Tombol Submit -->
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                <i class="fa-solid fa-pen mr-2"></i> Simpan Edit Data
                            </button>
                        </div>

                    </form>

                    <!-- Edit Confirmation Modal -->
                    <div x-show="editModal"
                        x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                        style="display: none;">

                        <div @click.outside="editModal = false"
                            x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200 transform"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-md">

                            <!-- Icon Info -->
                            <div class="flex justify-center mb-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 rounded-full p-4 animate-pulse">
                                    <i class="fa-solid fa-circle-info text-blue-500 text-4xl"></i>
                                </div>
                            </div>

                            <!-- Header -->
                            <h2 class="text-2xl font-bold mb-3 text-blue-600 dark:text-blue-400 text-center">Konfirmasi Edit</h2>

                            <!-- Content -->
                            <p class="text-gray-600 dark:text-gray-300 text-center mb-6">
                                Apakah Anda yakin ingin mengubah data poli<br>
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6 bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                <i class="fa-solid fa-info-circle mr-1"></i>
                                Pastikan data yang diedit sudah benar sebelum melanjutkan!
                            </p>

                            <!-- Footer -->
                            <div class="flex gap-3">
                                <button @click="editModal = false" type="button"
                                        class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium">
                                    <i class="fa-solid fa-xmark mr-1"></i> Batal
                                </button>
                                <button type="button" @click="$refs.form.submit()"
                                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg font-medium">
                                    <i class="fa-solid fa-check mr-1"></i> Ya, Edit
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
