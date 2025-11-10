<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Form Tambah Jadwal') }}
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
                            <h3 class="text-xl font-bold text-white">Tambah Jadwal Tenaga Klinik Baru</h3>
                            <p class="text-blue-100 text-sm">Lengkapi semua informasi jadwal dengan benar</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="#" method="POST" class="p-6 space-y-6">
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
                                        <option value="5">Dewi Kusuma</option>
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
                                    <option value="Perawat">Perawat</option>
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
                                        <option value="Poli Umum">Poli Umum</option>
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
                                        <input type="checkbox" name="hari[]" value="Senin" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Senin</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                        <input type="checkbox" name="hari[]" value="Selasa" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Selasa</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                        <input type="checkbox" name="hari[]" value="Rabu" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Rabu</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                        <input type="checkbox" name="hari[]" value="Kamis" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Kamis</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                        <input type="checkbox" name="hari[]" value="Jumat" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Jumat</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-all">
                                        <input type="checkbox" name="hari[]" value="Sabtu" class="rounded text-purple-600 focus:ring-purple-500">
                                        <span class="text-sm">Sabtu</span>
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
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_selesai" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                                </label>
                                <textarea name="keterangan" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: Jadwal khusus untuk pasien BPJS atau catatan tambahan lainnya"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 gap-3 sm:gap-0">

                        <!-- Tombol Kembali -->
                        <a href="{{ route('admin.master-jadwal.index') }}"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 font-medium text-center">
                            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                        </a>

                        <!-- Tombol Reset & Simpan -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <button type="reset"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                            </button>
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                <i class="fa-solid fa-save mr-2"></i>Simpan Data
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @vite(['resources/js/masterData/jadwal/form_jadwal.js'])
</x-app-layout>
