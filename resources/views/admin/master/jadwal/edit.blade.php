<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Edit Jadwal Tenaga Klinik') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                
                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-calendar-days text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Edit Data Jadwal</h3>
                            <p class="text-blue-100 text-sm">Perbaruhi Data Jadwal dengan benar dan lengkap</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div x-data="{ editModal: false }">
                    <form action="#" method="POST" class="p-6 space-y-6" @submit.prevent="editModal = true">
                        @csrf

                        <!-- Informasi Tenaga Klinik -->
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-user-doctor text-purple-500"></i>
                                Informasi Tenaga Klinik
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Tenaga -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Tenaga Klinik <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_tenaga" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                        <option value="">Pilih Tenaga Klinik</option>
                                        <optgroup label="Dokter">
                                            <option value="1">dr. Aditya Pratama</option>
                                            <option value="2">dr. Siti Nurhaliza</option>
                                            <option value="3">dr. Budi Santoso</option>
                                        </optgroup>
                                        <optgroup label="Perawat">
                                            <option value="4">Rani Wijaya</option>
                                            <option value="5" selected>Dewi Kusuma</option>
                                            <option value="6">Ahmad Fauzi</option>
                                        </optgroup>
                                        <optgroup label="Petugas">
                                            <option value="7">Sinta Marlina</option>
                                            <option value="8">Rudi Hermawan</option>
                                            <option value="9">Lisa Permata</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <!-- Role -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <select name="role" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                        <option value="">Pilih Role</option>
                                        <option value="Dokter">Dokter</option>
                                        <option value="Perawat" selected>Perawat</option>
                                        <option value="Petugas">Petugas</option>
                                    </select>
                                </div>

                                <!-- Poli/Area Kerja -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Poli / Area Kerja <span class="text-red-500">*</span>
                                    </label>
                                    <select name="poli_area" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                        <option value="">Pilih Poli/Area</option>
                                        <optgroup label="Poliklinik">
                                            <option value="Poli Umum" selected>Poli Umum</option>
                                            <option value="Poli Gigi">Poli Gigi</option>
                                            <option value="Poli Anak">Poli Anak</option>
                                            <option value="Poli KIA">Poli KIA (Kesehatan Ibu dan Anak)</option>
                                        </optgroup>
                                        <optgroup label="Unit Penunjang">
                                            <option value="Pendaftaran">Pendaftaran</option>
                                            <option value="Rekam Medis">Rekam Medis</option>
                                            <option value="Farmasi">Farmasi</option>
                                            <option value="Laboratorium">Laboratorium</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <!-- Hari (Checkbox Multiple) -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Hari <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2 p-4 border border-gray-300 rounded-lg max-h-48 overflow-y-auto bg-gray-50">
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Senin" class="rounded text-purple-600 focus:ring-purple-500" checked>
                                            <span class="text-sm">Senin</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Selasa" class="rounded text-purple-600 focus:ring-purple-500" checked>
                                            <span class="text-sm">Selasa</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Rabu" class="rounded text-purple-600 focus:ring-purple-500" checked> 
                                            <span class="text-sm">Rabu</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Kamis" class="rounded text-purple-600 focus:ring-purple-500" checked>
                                            <span class="text-sm">Kamis</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Jumat" class="rounded text-purple-600 focus:ring-purple-500" checked>
                                            <span class="text-sm">Jumat</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Sabtu" class="rounded text-purple-600 focus:ring-purple-500">
                                            <span class="text-sm" @checked(true)>Sabtu</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                            <input type="checkbox" name="hari[]" value="Minggu" class="rounded text-purple-600 focus:ring-purple-500">
                                            <span class="text-sm">Minggu</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fa-solid fa-info-circle"></i> Centang satu atau lebih hari
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Waktu -->
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-clock text-blue-500"></i>
                                Informasi Waktu
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Jam Mulai -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jam Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="jam_mulai" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" value="08:00">
                                </div>

                                <!-- Jam Selesai -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jam Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="jam_selesai" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" value="16:00">
                                </div>

                                <!-- Keterangan -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <textarea name="keterangan" rows="3"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Contoh: Jadwal khusus untuk pasien BPJS atau catatan tambahan lainnya">-</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 dark:border-gray-700 gap-3 sm:gap-0">
                            <!-- Tombol Kembali -->
                            <a href="/admin/masterData/jadwal"
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
                                Apakah Anda yakin ingin mengubah data jadwal<br>
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