<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                
                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-user-doctor text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Edit Data Dokter</h3>
                            <p class="text-blue-100 text-sm">Perbaruhi Data Dokter dengan benar dan lengkap</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div x-data="{ editModal: false }">
                    <form action="#" method="POST" class="p-6 space-y-6" @submit.prevent="editModal = true">
                        @csrf

                        <!-- Section 1: Identitas Pribadi -->
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-blue-500"></i>
                                Identitas Pribadi
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Lengkap -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <input type="text" name="nama_lengkap" required
                                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                               placeholder="Contoh: Dr. Ahmad Fauzi, Sp.PD" value="Dr. Ahmad Fauzi, Sp.PD">
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="L" required
                                                   class="w-4 h-4 text-blue-500 focus:ring-blue-500" checked>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                <i class="fa-solid fa-mars text-blue-500"></i> Laki-laki
                                            </span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="P" required
                                                   class="w-4 h-4 text-pink-500 focus:ring-pink-500">
                                            <span class="text-gray-700 dark:text-gray-300">
                                                <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Tempat Lahir -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Tempat Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="tempat_lahir" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           placeholder="Contoh: Surabaya" value="Surabaya">
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fa-solid fa-calendar"></i>
                                        </span>
                                        <input type="date" name="tanggal_lahir" required
                                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="1980-05-15">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informasi Kontak -->
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-address-book text-green-500"></i>
                                Informasi Kontak
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fa-solid fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" required
                                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                               placeholder="contoh@hospital.com" value="AhmadFauzy@gmail.com">
                                    </div>
                                </div>

                                <!-- No. Telepon -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fa-solid fa-phone"></i>
                                        </span>
                                        <input type="tel" name="telepon" required
                                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                               placeholder="+62 812-3456-7890" value="+62 812-3456-7890">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Informasi Profesional -->
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-stethoscope text-purple-500"></i>
                                Informasi Profesional
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- No. STR -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        No. STR (Surat Tanda Registrasi) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_str" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           placeholder="STR-123456789-2024" value="STR-123456789-2024">
                                </div>

                                <!-- No. SIP -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        No. SIP (Surat Izin Praktik) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_sip" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           placeholder="SIP-987654321-2024" value="SIP-987654321-2024">
                                </div>

                                <!-- Spesialisasi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Spesialisasi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="spesialisasi" required
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="Penyakit Dalam" selected>Penyakit Dalam</option>
                                        <option value="Bedah">Bedah</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Kandungan">Kandungan</option>
                                        <option value="Jantung">Jantung</option>
                                        <option value="Mata">Mata</option>
                                        <option value="THT">THT</option>
                                        <option value="Kulit dan Kelamin">Kulit dan Kelamin</option>
                                        <option value="Saraf">Saraf</option>
                                        <option value="Jiwa">Jiwa</option>
                                        <option value="Gigi dan Mulut">Gigi dan Mulut</option>
                                        <option value="Umum">Umum</option>
                                    </select>
                                </div>

                                <!-- Unit/Poli -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Unit / Poli Bertugas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="unit_poli" required
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Unit/Poli</option>
                                        <option value="Poli Umum">Poli Umum</option>
                                        <option value="Poli Penyakit Dalam" selected>Poli Penyakit Dalam</option>
                                        <option value="Poli Bedah">Poli Bedah</option>
                                        <option value="Poli Anak">Poli Anak</option>
                                        <option value="Poli Gigi">Poli Gigi</option>
                                        <option value="Poli Kandungan">Poli Kandungan</option>
                                        <option value="Poli Jantung">Poli Jantung</option>
                                        <option value="IGD">IGD (Instalasi Gawat Darurat)</option>
                                        <option value="ICU">ICU (Intensive Care Unit)</option>
                                    </select>
                                </div>

                                <!-- Status Kepegawaian -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Status Kepegawaian <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status_kepegawaian" required
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Status</option>
                                        <option value="Dokter Tetap" selected>Dokter Tetap</option>
                                        <option value="Dokter Kontrak">Dokter Kontrak</option>
                                        <option value="Dokter Tamu">Dokter Tamu</option>
                                        <option value="Dokter Mitra">Dokter Mitra</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Alamat Lengkap -->
                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-red-500"></i>
                                Alamat Lengkap
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Provinsi -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Provinsi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="provinsi" required id="provinsi"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Provinsi</option>
                                        <option value="11">Aceh</option>
                                        <option value="12">Sumatera Utara</option>
                                        <option value="13">Sumatera Barat</option>
                                        <option value="31">DKI Jakarta</option>
                                        <option value="32">Jawa Barat</option>
                                        <option value="33">Jawa Tengah</option>
                                        <option value="35" selected>Jawa Timur</option>
                                        <option value="51">Bali</option>
                                        <option value="61">Kalimantan Barat</option>
                                        <option value="73">Sulawesi Selatan</option>
                                    </select>
                                </div>

                                <!-- Kota/Kabupaten -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kota" required id="kota"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Kota/Kabupaten</option>
                                        <option value="Jember" selected>Jember</option>
                                    </select>
                                </div>

                                <!-- Kecamatan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Kecamatan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kecamatan" required id="kecamatan"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Kecamatan</option>
                                        <option value="Patrang" selected>Patrang</option>
                                    </select>
                                </div>

                                <!-- Kelurahan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Kelurahan/Desa <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kelurahan" required id="kelurahan"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Pilih Kelurahan/Desa</option>
                                        <option value="Gebang" selected>Gebang</option>
                                    </select>
                                </div>

                                <!-- Alamat Detail -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Alamat Detail (Jalan, RT/RW, Kode Pos) <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="alamat_detail" required rows="3"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                              placeholder="Jl. Airlangga No. 45, RT 003 RW 005, Kode Pos 60286">Jl. Airlangga No. 45, RT 003 RW 005, Kode Pos 60286</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Status Dokter -->
                        <div class="border-l-4 border-teal-500 pl-4">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-teal-500"></i>
                                Status Dokter
                            </h4>
                            
                            <div class="bg-teal-50 dark:bg-teal-900/20 p-4 rounded-lg">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="status_aktif" value="1" checked
                                          class="w-5 h-5 text-teal-500 rounded focus:ring-teal-500">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">
                                        <i class="fa-solid fa-circle-check text-teal-500 mr-1"></i>
                                        Aktifkan Dokter (Dokter dapat langsung bertugas)
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 dark:border-gray-700 gap-3 sm:gap-0">
                            <!-- Tombol Kembali -->
                            <a href="/admin/masterData/dokter"
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
                                Apakah Anda yakin ingin mengubah data dokter<br>
                                <strong class="text-gray-800 dark:text-white text-lg">Dr. Ahmad Fauzi, Sp.PD</strong>?
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