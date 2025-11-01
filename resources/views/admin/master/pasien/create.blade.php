<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Form Tambah Pasien') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                
                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Tambah Data Pasien Baru</h3>
                            <p class="text-blue-100 text-sm">Lengkapi semua informasi Pasien dengan benar</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="#" method="POST" class="p-6 space-y-6">
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
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="Contoh: Dr. Ahmad Fauzi, Sp.PD">
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
                                               class="w-4 h-4 text-blue-500 focus:ring-blue-500">
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
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Contoh: Surabaya">
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
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
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
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="contoh@hospital.com">
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
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="+62 812-3456-7890">
                                </div>
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
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Provinsi</option>
                                    <option value="11">Aceh</option>
                                    <option value="12">Sumatera Utara</option>
                                    <option value="13">Sumatera Barat</option>
                                    <option value="31">DKI Jakarta</option>
                                    <option value="32">Jawa Barat</option>
                                    <option value="33">Jawa Tengah</option>
                                    <option value="35">Jawa Timur</option>
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
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kecamatan <span class="text-red-500">*</span>
                                </label>
                                <select name="kecamatan" required id="kecamatan"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <!-- Kelurahan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kelurahan/Desa <span class="text-red-500">*</span>
                                </label>
                                <select name="kelurahan" required id="kelurahan"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                            </div>

                            <!-- Alamat Detail -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Alamat Detail (Jalan, RT/RW, Kode Pos) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat_detail" required rows="3"
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                          placeholder="Contoh: Jl. Airlangga No. 45, RT 003 RW 005, Kode Pos 60286"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 gap-3 sm:gap-0">
                        
                        <!-- Tombol Kembali -->
                        <a href="/admin/masterData/pasien"
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
</x-app-layout>