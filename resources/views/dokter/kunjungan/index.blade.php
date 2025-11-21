<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ 
        viewModal: false, 
        selectedKunjungan: null,
        showDetail(data) {
            this.selectedKunjungan = data;
            this.viewModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">

                <!-- Filter & Search -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-search mr-1"></i> Cari Pasien
                            </label>
                            <input type="text" id="tableSearch" 
                                placeholder="Nama pasien atau No. RM..."
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-filter mr-1"></i> Status
                            </label>
                            <select class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Semua Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="sedang_diperiksa">Sedang Diperiksa</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-calendar mr-1"></i> Tanggal
                            </label>
                            <input type="date" 
                                value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>

                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto px-4 py-4">
                    <table class="w-full" id="dataTable">
                        <thead class="bg-gray-100 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">No. RM</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Umur</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Keluhan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Waktu Daftar</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            
                            <!-- Baris 1 - Menunggu -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">1</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">RM-001234</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">Budi Santoso</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">32 tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Demam tinggi, batuk</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">08:15 WIB</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Menunggu
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="showDetail({
                                            no_rm: 'RM-001234',
                                            nama: 'Budi Santoso',
                                            umur: '32 tahun',
                                            jenis_kelamin: 'Laki-laki',
                                            nik: '3509xxxxxxxxxx',
                                            keluhan: 'Demam tinggi, batuk',
                                            waktu: '08:15 WIB',
                                            status: 'Menunggu'
                                        })" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-eye mr-1"></i> Detail
                                        </button>
                                        <button class="px-3 py-1.5 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-notes-medical mr-1"></i> Periksa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 2 - Sedang Diperiksa -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 bg-blue-50/50 dark:bg-blue-900/10 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">2</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">RM-001235</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">Siti Aminah</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">28 tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Sakit kepala, mual</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">08:30 WIB</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        Sedang Diperiksa
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="showDetail({
                                            no_rm: 'RM-001235',
                                            nama: 'Siti Aminah',
                                            umur: '28 tahun',
                                            jenis_kelamin: 'Perempuan',
                                            nik: '3509xxxxxxxxxx',
                                            keluhan: 'Sakit kepala, mual',
                                            waktu: '08:30 WIB',
                                            status: 'Sedang Diperiksa'
                                        })" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-eye mr-1"></i> Detail
                                        </button>
                                        <button class="px-3 py-1.5 bg-purple-500 hover:bg-purple-600 dark:bg-purple-600 dark:hover:bg-purple-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-file-medical mr-1"></i> Lanjut
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 3 - Selesai -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">3</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">RM-001236</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">Ahmad Rizki</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">45 tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Kontrol diabetes</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">07:45 WIB</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Selesai
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="showDetail({
                                            no_rm: 'RM-001236',
                                            nama: 'Ahmad Rizki',
                                            umur: '45 tahun',
                                            jenis_kelamin: 'Laki-laki',
                                            nik: '3509xxxxxxxxxx',
                                            keluhan: 'Kontrol diabetes',
                                            waktu: '07:45 WIB',
                                            status: 'Selesai'
                                        })" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-eye mr-1"></i> Detail
                                        </button>
                                        <button class="px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 dark:bg-indigo-600 dark:hover:bg-indigo-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-file-medical mr-1"></i> Lihat RM
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 4 - Menunggu -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">4</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">RM-001237</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">Rina Wati</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">25 tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Flu, pilek</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">09:00 WIB</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Menunggu
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="showDetail({
                                            no_rm: 'RM-001237',
                                            nama: 'Rina Wati',
                                            umur: '25 tahun',
                                            jenis_kelamin: 'Perempuan',
                                            nik: '3509xxxxxxxxxx',
                                            keluhan: 'Flu, pilek',
                                            waktu: '09:00 WIB',
                                            status: 'Menunggu'
                                        })" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-eye mr-1"></i> Detail
                                        </button>
                                        <button class="px-3 py-1.5 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-notes-medical mr-1"></i> Periksa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 5 - Menunggu -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">5</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">RM-001238</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">Joko Susilo</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">50 tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Nyeri dada</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">09:20 WIB</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Menunggu
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="showDetail({
                                            no_rm: 'RM-001238',
                                            nama: 'Joko Susilo',
                                            umur: '50 tahun',
                                            jenis_kelamin: 'Laki-laki',
                                            nik: '3509xxxxxxxxxx',
                                            keluhan: 'Nyeri dada',
                                            waktu: '09:20 WIB',
                                            status: 'Menunggu'
                                        })" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-eye mr-1"></i> Detail
                                        </button>
                                        <button class="px-3 py-1.5 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-lg transition-colors text-xs font-medium">
                                            <i class="fa-solid fa-notes-medical mr-1"></i> Periksa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Modal Detail Pasien -->
        <div x-show="viewModal" 
             x-cloak
             @click.away="viewModal = false"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click.stop class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full mx-auto transform transition-all">
                    
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 px-6 py-4 rounded-t-xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-user-circle"></i>
                                Detail Pasien
                            </h3>
                            <button @click="viewModal = false" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                                <i class="fa-solid fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4" x-show="selectedKunjungan">
                        
                        <!-- Informasi Utama -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">No. Rekam Medis</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.no_rm"></p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                <p class="text-lg font-semibold" 
                                   :class="{
                                       'text-yellow-600 dark:text-yellow-400': selectedKunjungan?.status === 'Menunggu',
                                       'text-blue-600 dark:text-blue-400': selectedKunjungan?.status === 'Sedang Diperiksa',
                                       'text-green-600 dark:text-green-400': selectedKunjungan?.status === 'Selesai'
                                   }"
                                   x-text="selectedKunjungan?.status"></p>
                            </div>
                        </div>

                        <!-- Data Pasien -->
                        <div class="space-y-3 border-t dark:border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Lengkap:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.nama"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Kelamin:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.jenis_kelamin"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Umur:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.umur"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">NIK:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.nik"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Daftar:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.waktu"></span>
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="border-t dark:border-gray-700 pt-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Keluhan:</p>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedKunjungan?.keluhan"></p>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 rounded-b-xl flex justify-end gap-2">
                        <button @click="viewModal = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded-lg transition-colors font-medium">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>