<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ 
        viewModal: false, 
        deleteModal: false,
        selectedKunjungan: null,
        deleteId: null
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">

                <!-- Header: Search dan Tombol Tambah -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <!-- Search Box -->
                    <div class="relative w-full sm:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               id="tableSearch" 
                               placeholder="Cari nama pasien, dokter, atau poli..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <!-- Tombol Tambah Kunjungan -->
                    <div x-data="{ dropdownOpen: false, modalOpen: false, searchPasien: '', pasienDipilih: null }" class="relative">
                        <!-- Tombol Dropdown -->
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-5 py-2.5 rounded-lg font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Kunjungan
                            <svg class="w-4 h-4 transition-transform duration-200" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 sm:right-0 sm:left-auto mt-2 w-full sm:w-56 bg-white dark:bg-gray-700 rounded-lg shadow-xl border border-gray-200 dark:border-gray-600 z-50 overflow-hidden"
                             style="display: none;">
                            <button @click="modalOpen = true; dropdownOpen = false"
                                class="w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-colors flex items-center gap-3 border-b border-gray-100 dark:border-gray-600">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="font-medium">Cari Pasien Lama</span>
                            </button>
                            <a href="{{ route('petugas.kunjungan.create') }}" 
                                class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    <span class="font-medium">Tambah Pasien Baru</span>
                                </div>
                            </a>
                        </div>

                        <!-- Modal Cari Pasien Lama -->
                        <div x-show="modalOpen" 
                             x-cloak
                             class="fixed inset-0 z-50 overflow-y-auto" 
                             style="display: none;">
                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div @click="modalOpen = false" 
                                     x-show="modalOpen"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                                <div x-show="modalOpen"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                    
                                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                                Cari Pasien Lama
                                            </h3>
                                            <button @click="modalOpen = false" class="text-white hover:text-gray-200 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="px-6 py-4">
                                        <div class="mb-4">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <input x-model="searchPasien" 
                                                       type="text" 
                                                       placeholder="Cari nama atau nomor rekam medis pasien..."
                                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            </div>
                                        </div>

                                        <div class="max-h-96 overflow-y-auto space-y-2">
                                            @php
                                                $pasienList = [
                                                    ['id' => 1, 'nama' => 'Budi Santoso', 'rm' => 'RM-001', 'tgl_lahir' => '15-05-1990', 'jk' => 'L', 'alamat' => 'Jl. Merdeka No. 10'],
                                                    ['id' => 2, 'nama' => 'Siti Aminah', 'rm' => 'RM-002', 'tgl_lahir' => '22-08-1985', 'jk' => 'P', 'alamat' => 'Jl. Sudirman No. 25'],
                                                    ['id' => 3, 'nama' => 'Ahmad Fauzi', 'rm' => 'RM-003', 'tgl_lahir' => '10-12-1992', 'jk' => 'L', 'alamat' => 'Jl. Gatot Subroto No. 5'],
                                                    ['id' => 4, 'nama' => 'Dewi Lestari', 'rm' => 'RM-004', 'tgl_lahir' => '03-03-1988', 'jk' => 'P', 'alamat' => 'Jl. Ahmad Yani No. 15'],
                                                    ['id' => 5, 'nama' => 'Rudi Hartono', 'rm' => 'RM-005', 'tgl_lahir' => '28-07-1995', 'jk' => 'L', 'alamat' => 'Jl. Diponegoro No. 8']
                                                ];
                                            @endphp

                                            <template x-for="pasien in {{ json_encode($pasienList) }}.filter(p => searchPasien === '' || p.nama.toLowerCase().includes(searchPasien.toLowerCase()) || p.rm.toLowerCase().includes(searchPasien.toLowerCase()))" :key="pasien.id">
                                                <div @click="pasienDipilih = pasien" 
                                                     :class="pasienDipilih?.id === pasien.id ? 'bg-indigo-50 dark:bg-indigo-900/30 border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                                     class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                                                                <span x-text="pasien.nama.charAt(0).toUpperCase()"></span>
                                                            </div>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-900 dark:text-gray-100" x-text="pasien.nama"></h4>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                    <span x-text="pasien.rm"></span>
                                                                </p>
                                                                <p class="text-xs text-gray-500 dark:text-gray-500 flex items-center gap-1 mt-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    <span x-text="'Lahir: ' + pasien.tgl_lahir + ' (' + pasien.jk + ')'"></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div x-show="pasienDipilih?.id === pasien.id" class="flex-shrink-0">
                                                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span x-show="pasienDipilih" x-text="'Dipilih: ' + (pasienDipilih?.nama || '')"></span>
                                            <span x-show="!pasienDipilih" class="text-gray-400 dark:text-gray-500">Pilih pasien dari daftar</span>
                                        </p>
                                        <div class="flex gap-3">
                                            <button @click="modalOpen = false; pasienDipilih = null" 
                                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium transition-colors">
                                                Batal
                                            </button>
                                            <button @click="if(pasienDipilih) { alert('Pasien ' + pasienDipilih.nama + ' (' + pasienDipilih.rm + ') ditambahkan ke kunjungan!'); modalOpen = false; pasienDipilih = null; }"
                                                    :disabled="!pasienDipilih"
                                                    :class="pasienDipilih ? 'bg-indigo-600 hover:bg-indigo-700 cursor-pointer' : 'bg-gray-300 dark:bg-gray-600 cursor-not-allowed'"
                                                    class="px-5 py-2 rounded-lg text-white font-medium transition-all shadow-md">
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Pilih Pasien
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kunjungan Pasien -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table id="dataTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-indigo-600 to-indigo-700">
                            <tr>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">No Antrian</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">No. Rekam Medis</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Dokter</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Poli</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $kunjungan = [
                                    ['id' => 1, 'nama' => 'Budi Santoso', 'rm' => 'RM-001', 'dokter' => 'dr. Andi Putra', 'poli' => 'Poli Umum', 'status' => 'menunggu-skrining', 'tgl_lahir' => '15-05-1990', 'jk' => 'Laki-laki', 'email' => 'budi@email.com', 'telp' => '081234567890', 'alamat' => 'Jl. Merdeka No. 10', 'bpjs' => '0001234567890', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 08:00'],
                                    ['id' => 2, 'nama' => 'Siti Aminah', 'rm' => 'RM-002', 'dokter' => 'dr. Sutomo', 'poli' => 'Poli Gigi', 'status' => 'menunggu-dokter', 'tgl_lahir' => '22-08-1985', 'jk' => 'Perempuan', 'email' => 'siti@email.com', 'telp' => '081234567891', 'alamat' => 'Jl. Sudirman No. 25', 'bpjs' => '0001234567891', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 08:30'],
                                    ['id' => 3, 'nama' => 'Ahmad Fauzi', 'rm' => 'RM-003', 'dokter' => 'dr. Desi Amalia', 'poli' => 'Poli Anak', 'status' => 'sedang-periksa', 'tgl_lahir' => '10-12-1992', 'jk' => 'Laki-laki', 'email' => 'ahmad@email.com', 'telp' => '081234567892', 'alamat' => 'Jl. Gatot Subroto No. 5', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 09:00'],
                                    ['id' => 4, 'nama' => 'Dewi Lestari', 'rm' => 'RM-004', 'dokter' => 'dr. Edwin Kurniawan', 'poli' => 'Poli Bedah', 'status' => 'selesai', 'tgl_lahir' => '03-03-1988', 'jk' => 'Perempuan', 'email' => 'dewi@email.com', 'telp' => '081234567893', 'alamat' => 'Jl. Ahmad Yani No. 15', 'bpjs' => '0001234567893', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 07:30'],
                                    ['id' => 5, 'nama' => 'Rudi Hartono', 'rm' => 'RM-005', 'dokter' => 'dr. Putri Lestari', 'poli' => 'Poli Kulit', 'status' => 'batal', 'tgl_lahir' => '28-07-1995', 'jk' => 'Laki-laki', 'email' => 'rudi@email.com', 'telp' => '081234567894', 'alamat' => 'Jl. Diponegoro No. 8', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 10:00'],
                                    ['id' => 6, 'nama' => 'Lina Rosita', 'rm' => 'RM-006', 'dokter' => 'dr. Maya Arsita', 'poli' => 'Poli Kandungan', 'status' => 'menunggu-skrining', 'tgl_lahir' => '12-02-1991', 'jk' => 'Perempuan', 'email' => 'lina@email.com', 'telp' => '081234567895', 'alamat' => 'Jl. Kenanga No. 3', 'bpjs' => '0001234567894', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 07:45'],
                                    ['id' => 7, 'nama' => 'Doni Saputra', 'rm' => 'RM-007', 'dokter' => 'dr. Rudi Santoso', 'poli' => 'Poli Mata', 'status' => 'menunggu-dokter', 'tgl_lahir' => '09-09-1993', 'jk' => 'Laki-laki', 'email' => 'doni@email.com', 'telp' => '081234567896', 'alamat' => 'Jl. Melati No. 12', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 08:10'],
                                    ['id' => 8, 'nama' => 'Ayu Kartika', 'rm' => 'RM-008', 'dokter' => 'dr. Yuni Pratiwi', 'poli' => 'Poli Gizi', 'status' => 'sedang-periksa', 'tgl_lahir' => '18-04-1997', 'jk' => 'Perempuan', 'email' => 'ayu@email.com', 'telp' => '081234567897', 'alamat' => 'Jl. Rajawali No. 9', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 09:20'],
                                    ['id' => 9, 'nama' => 'Hendra Wijaya', 'rm' => 'RM-009', 'dokter' => 'dr. Farhan Hidayat', 'poli' => 'Poli Saraf', 'status' => 'menunggu-skrining', 'tgl_lahir' => '03-11-1980', 'jk' => 'Laki-laki', 'email' => 'hendra@email.com', 'telp' => '081234567898', 'alamat' => 'Jl. Semeru No. 2', 'bpjs' => '0001234567895', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 08:55'],
                                    ['id' => 10, 'nama' => 'Mira Agustin', 'rm' => 'RM-010', 'dokter' => 'dr. Rani Safitri', 'poli' => 'Poli Umum', 'status' => 'menunggu-dokter', 'tgl_lahir' => '21-06-1994', 'jk' => 'Perempuan', 'email' => 'mira@email.com', 'telp' => '081234567899', 'alamat' => 'Jl. Mangga No. 14', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 09:35'],
                                    ['id' => 11, 'nama' => 'Umar Hasan', 'rm' => 'RM-011', 'dokter' => 'dr. Bayu Prakoso', 'poli' => 'Poli Jantung', 'status' => 'sedang-periksa', 'tgl_lahir' => '10-01-1983', 'jk' => 'Laki-laki', 'email' => 'umar@email.com', 'telp' => '081234567800', 'alamat' => 'Jl. Anggrek No. 5', 'bpjs' => '0001234567896', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 10:10'],
                                    ['id' => 12, 'nama' => 'Salsa Dewanti', 'rm' => 'RM-012', 'dokter' => 'dr. Novi Astuti', 'poli' => 'Poli Paru', 'status' => 'menunggu-skrining', 'tgl_lahir' => '05-02-1999', 'jk' => 'Perempuan', 'email' => 'salsa@email.com', 'telp' => '081234567801', 'alamat' => 'Jl. Mawar No. 18', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 07:50'],
                                    ['id' => 13, 'nama' => 'Gilang Mahendra', 'rm' => 'RM-013', 'dokter' => 'dr. Putri Lestari', 'poli' => 'Poli Kulit', 'status' => 'batal', 'tgl_lahir' => '30-08-1990', 'jk' => 'Laki-laki', 'email' => 'gilang@email.com', 'telp' => '081234567802', 'alamat' => 'Jl. Diponegoro No. 30', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 11:00'],
                                    ['id' => 14, 'nama' => 'Rara Melani', 'rm' => 'RM-014', 'dokter' => 'dr. Andi Putra', 'poli' => 'Poli Umum', 'status' => 'selesai', 'tgl_lahir' => '12-12-1998', 'jk' => 'Perempuan', 'email' => 'rara@email.com', 'telp' => '081234567803', 'alamat' => 'Jl. Balai Kota No. 6', 'bpjs' => '0001234567897', 'jenis_pasien' => 'BPJS', 'tgl_kunjungan' => '18-11-2025 06:45'],
                                    ['id' => 15, 'nama' => 'Yoga Prasetyo', 'rm' => 'RM-015', 'dokter' => 'dr. Farhan Hidayat', 'poli' => 'Poli Saraf', 'status' => 'menunggu-dokter', 'tgl_lahir' => '27-03-1991', 'jk' => 'Laki-laki', 'email' => 'yoga@email.com', 'telp' => '081234567804', 'alamat' => 'Jl. Srikaya No. 7', 'bpjs' => '-', 'jenis_pasien' => 'Umum', 'tgl_kunjungan' => '18-11-2025 10:20'],
                                ];

                            @endphp

                            @foreach ($kunjungan as $i => $k)
                                <tr class="hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-bold text-sm shadow-md">
                                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $k['nama'] }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            {{ $k['rm'] }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                            {{ $k['dokter'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400">
                                            {{ $k['poli'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($k['status'] === 'menunggu-skrining')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                Menunggu Skrining
                                            </span>
                                        @elseif ($k['status'] === 'menunggu-dokter')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400 border border-orange-200 dark:border-orange-800">
                                                Menunggu Dokter
                                            </span>
                                        @elseif ($k['status'] === 'sedang-periksa')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Sedang Periksa
                                            </span>
                                        @elseif ($k['status'] === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                Selesai
                                            </span>
                                        @elseif ($k['status'] === 'batal')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Batal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 text-center">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            <!-- View Button -->
                                            <button @click="selectedKunjungan = {{ json_encode($k) }}; viewModal = true"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>

                                            <!-- Edit Button -->
                                            <a href="#"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105 inline-flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <button @click="deleteId = {{ $k['id'] }}; deleteModal = true"
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal View Detail Kunjungan -->
                <div x-show="viewModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                    style="display: none;">
                    <div @click.away="viewModal = false"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200 transform"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-4"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col">

                        <!-- Header Fixed -->
                        <div class="flex items-center justify-between p-6 pb-4 border-b-2 border-indigo-500 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Detail Kunjungan Pasien
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap data kunjungan pasien</p>
                            </div>
                            <button @click="viewModal = false"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors hover:rotate-90 duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Content Scrollable -->
                        <div class="overflow-y-auto p-6 space-y-5">

                            <!-- Informasi Kunjungan -->
                            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-5 rounded-xl border-l-4 border-indigo-500">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Informasi Kunjungan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Tanggal & Waktu Kunjungan</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.tgl_kunjungan || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Status Kunjungan</p>
                                        <span x-show="selectedKunjungan?.status === 'menunggu-skrining'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            Menunggu Skrining
                                        </span>
                                        <span x-show="selectedKunjungan?.status === 'menunggu-dokter'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                            Menunggu Dokter
                                        </span>
                                        <span x-show="selectedKunjungan?.status === 'sedang-periksa'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            Sedang Periksa
                                        </span>
                                        <span x-show="selectedKunjungan?.status === 'selesai'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                        <span x-show="selectedKunjungan?.status === 'batal'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Batal
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Identitas Pasien -->
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-5 rounded-xl border-l-4 border-blue-500">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Identitas Pasien
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Nama Lengkap</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.nama || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No. Rekam Medis</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.rm || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Tanggal Lahir</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.tgl_lahir || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Jenis Kelamin</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.jk || '-'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-5 rounded-xl border-l-4 border-green-500">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Informasi Kontak
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Email</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.email || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No. Telepon</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.telp || '-'"></p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Alamat Lengkap</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.alamat || '-'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Medis -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-5 rounded-xl border-l-4 border-purple-500">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                    Informasi Layanan Medis
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Dokter Pemeriksa</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.dokter || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Poliklinik</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.poli || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No. BPJS</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200" x-text="selectedKunjungan?.bpjs || '-'"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Jenis Pasien</p>
                                        <span x-show="selectedKunjungan?.jenis_pasien === 'BPJS'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            BPJS
                                        </span>
                                        <span x-show="selectedKunjungan?.jenis_pasien === 'Umum'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            Umum
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Fixed -->
                        <div class="p-6 pt-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3">
                            <button @click="viewModal = false"
                                    class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Konfirmasi Delete -->
                <div x-show="deleteModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                    style="display: none;">
                    <div @click.away="deleteModal = false"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200 transform"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-4"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">

                        <!-- Header -->
                        <div class="p-6 pb-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 border-b-2 border-red-500">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Konfirmasi Batal Kunjungan</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tindakan ini tidak dapat dipulihkan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed">
                                Apakah Anda yakin ingin menghapus data kunjungan ini? 
                                <span class="font-semibold text-red-600 dark:text-red-400">Semua data yang terkait akan dibatalkan secara permanen</span> 
                                dan tidak dapat dikembalikan.
                            </p>
                            
                            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex gap-3">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-red-800 dark:text-red-300">
                                        <span class="font-semibold">Peringatan:</span> Data yang telah dibatalkan tidak dapat dipulihkan kembali.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-6 pt-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3">
                            <button @click="deleteModal = false; deleteId = null"
                                    class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                            <button @click="alert('Data kunjungan dengan ID ' + deleteId + ' berhasil dihapus!'); deleteModal = false; deleteId = null"
                                    class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Ya, Batal Kunjungan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>