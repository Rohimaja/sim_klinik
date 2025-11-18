<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

            <!-- Header -->
            <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fa-solid fa-hospital-user text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Tambah Pasien Baru</h3>
                        <p class="text-blue-100 text-sm">Isi data identitas pasien dengan lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Identitas Pasien -->
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-blue-500"></i>
                        Identitas Pasien
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Nama Pasien -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: Budi Santoso">
                        </div>

                        <!-- NIK -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="number" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="16 digit NIK">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="jk" value="L" class="w-4 h-4">
                                    <span>Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="jk" value="P" class="w-4 h-4">
                                    <span>Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                    </div>
                </div>

                <!-- Kontak -->
                <div class="border-l-4 border-green-500 pl-4">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-phone text-green-500"></i>
                        Kontak Pasien
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- No Telepon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                No. Telepon
                            </label>
                            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="Contoh: 081234567890">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="contoh@email.com">
                        </div>

                    </div>
                </div>

                <!-- Kunjungan Pasien -->
                <div class="border-l-4 border-purple-500 pl-4">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-stethoscope text-purple-500"></i>
                        Data Kunjungan Pasien
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Poli Tujuan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Poli Tujuan <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="">-- Pilih Poli --</option>
                                <option value="umum">Poli Umum</option>
                                <option value="gigi">Poli Gigi</option>
                                <option value="anak">Poli Anak</option>
                                <option value="kandungan">Poli Kandungan</option>
                                <option value="mata">Poli Mata</option>
                                <option value="kulit">Poli Kulit & Kelamin</option>
                            </select>
                        </div>

                        <!-- Dokter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Dokter (Opsional)
                            </label>
                            <select class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">-- Pilih Dokter --</option>

                                <!-- Silakan tambah list dokter sesuai kebutuhan -->
                                <option value="dr_umum_1">dr. Andi – Poli Umum</option>
                                <option value="dr_umum_2">dr. Rina – Poli Umum</option>

                                <option value="dr_gigi_1">drg. Sari – Poli Gigi</option>
                                <option value="dr_gigi_2">drg. Putra – Poli Gigi</option>

                                <option value="dr_anak_1">dr. Lestari – Poli Anak</option>

                                <option value="dr_kandungan_1">dr. Maya – Poli Kandungan</option>

                                <option value="dr_mata_1">dr. Budi – Poli Mata</option>

                                <option value="dr_kulit_1">dr. Dimas – Poli Kulit & Kelamin</option>
                            </select>
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500"
                                value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Keluhan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Keluhan Pasien <span class="text-red-500">*</span>
                            </label>
                            <textarea rows="3" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500"
                                placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan"></textarea>
                        </div>

                    </div>
                </div>


                <!-- Alamat -->
                <div class="border-l-4 border-red-500 pl-4">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-red-500"></i>
                        Alamat Pasien
                    </h4>

                    <textarea rows="3" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: Jl. Mawar No. 12, RT 02 RW 03, Jember"></textarea>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row justify-between border-t pt-6 gap-3">
                    
                    <a href="{{ route('petugas.kunjungan.index') }}"
                        class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-center font-medium">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>

                    <div class="flex gap-3">
                        <button type="reset"
                            class="px-6 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-md">
                            <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                        </button>

                        <button type="button"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-md">
                            <i class="fa-solid fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
</x-app-layout>