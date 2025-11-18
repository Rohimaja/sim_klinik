<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, Dr. {{ Auth::user()->name }}</h3>
                        <p class="text-blue-100">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold" id="clock"></div>
                        <div class="text-sm text-blue-100 mt-1">Praktik: 08:00 - 16:00</div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Pasien Hari Ini -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded">Hari ini</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Total Pasien</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">18</p>
                    </div>
                </div>

                <!-- Card 2: Pasien Menunggu -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-orange-600 bg-orange-100 dark:bg-orange-900 dark:text-orange-300 px-2 py-1 rounded">Antrian</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Pasien Menunggu</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">5</p>
                    </div>
                </div>

                <!-- Card 3: Pasien Selesai -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded">Selesai</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Sudah Diperiksa</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">13</p>
                    </div>
                </div>

                <!-- Card 4: Waktu Rata-rata -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-purple-600 bg-purple-100 dark:bg-purple-900 dark:text-purple-300 px-2 py-1 rounded">Avg</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Waktu Pemeriksaan</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">12<span class="text-lg"> mnt</span></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Pasien Berikutnya -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Daftar Pasien Hari Ini
                            </h3>
                            <button onclick="confirmCallNextPatient()" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Panggil Pasien Berikutnya
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">No. Antrian</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Nama Pasien</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Umur</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Keluhan</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Status</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 bg-blue-50 dark:bg-blue-900/20">
                                        <td class="py-3 px-4"><span class="font-bold text-blue-600 dark:text-blue-400">A001</span></td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200 font-medium">Ahmad Fauzi</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">32 Th</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">Demam, Batuk</td>
                                        <td class="py-3 px-4">
                                            <span class="text-xs px-3 py-1 rounded-full font-medium bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">Sedang Dilayani</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Periksa</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4"><span class="font-bold text-blue-600 dark:text-blue-400">A002</span></td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Siti Nurhaliza</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">28 Th</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">Sakit kepala</td>
                                        <td class="py-3 px-4">
                                            <span class="text-xs px-3 py-1 rounded-full font-medium bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300">Menunggu</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4"><span class="font-bold text-blue-600 dark:text-blue-400">A003</span></td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Budi Santoso</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">45 Th</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">Cek Rutin</td>
                                        <td class="py-3 px-4">
                                            <span class="text-xs px-3 py-1 rounded-full font-medium bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300">Menunggu</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4"><span class="font-bold text-blue-600 dark:text-blue-400">A004</span></td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Dewi Lestari</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">5 Th</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">Flu</td>
                                        <td class="py-3 px-4">
                                            <span class="text-xs px-3 py-1 rounded-full font-medium bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300">Menunggu</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4"><span class="font-bold text-blue-600 dark:text-blue-400">A005</span></td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Rudi Hartono</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">38 Th</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">Hipertensi</td>
                                        <td class="py-3 px-4">
                                            <span class="text-xs px-3 py-1 rounded-full font-medium bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300">Menunggu</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan & Notifikasi -->
                <div class="space-y-6">
                    <!-- Pasien Sedang Diperiksa -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Sedang Diperiksa
                            </h3>
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">A001</span>
                                    <span class="text-xs px-2 py-1 rounded-full font-medium bg-blue-600 text-white">Aktif</span>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-2">Ahmad Fauzi</h4>
                                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                    <p>👤 32 Tahun, Laki-laki</p>
                                    <p>💊 Keluhan: Demam, Batuk</p>
                                    <p>⏱️ Mulai: 10:30</p>
                                </div>
                                <button onclick="showPatientDetail()" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Lihat Detail Pasien
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi Penting -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Perhatian Khusus
                            </h3>
                            <div class="space-y-3">
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-300">⚠️ Pasien dengan alergi obat</p>
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">Siti Nurhaliza - Alergi Penisilin</p>
                                </div>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                    <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">🔔 Pasien kontrol rutin</p>
                                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Rudi Hartono - Hipertensi</p>
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">📋 Rujukan dari poli lain</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Dewi Lestari - Dari Poli Anak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Pemeriksaan Minggu Ini -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Statistik Minggu Ini
                        </h3>
                        <button onclick="showWeeklyStats()" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">Lihat Detail</button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">85</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Pasien</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">72</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Resep Dibuat</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">8</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Rujukan</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">15</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pasien Kontrol</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">14 mnt</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Avg. Waktu</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Konfirmasi Panggil Pasien -->
    <div id="callPatientModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mt-4">Panggil Pasien Berikutnya?</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Anda akan memanggil pasien berikutnya:</p>
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="font-bold text-lg text-blue-600 dark:text-blue-400">A002</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Siti Nurhaliza</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">28 Tahun - Sakit Gigi</p>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="callNextPatient()" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Ya, Panggil Sekarang
                    </button>
                    <button onclick="closeCallPatientModal()" class="mt-3 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pasien -->
    <div id="patientDetailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Detail Pasien</h3>
                <button onclick="closePatientDetailModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 space-y-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">A001</span>
                        <span class="text-xs px-3 py-1 rounded-full font-medium bg-blue-600 text-white">Sedang Dilayani</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">Ahmad Fauzi</h4>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Umur</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">32 Tahun</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Laki-laki</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">No. Telepon</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">0812-3456-7890</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Waktu Mulai</p>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">10:30 WIB</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Keluhan Utama</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">Demam dan Batuk sejak 3 hari yang lalu, disertai nyeri tenggorokan</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Riwayat Penyakit</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">Tidak ada riwayat penyakit kronis</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Alergi</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">Tidak ada</p>
                </div>

                <div class="flex gap-3 mt-6">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Mulai Pemeriksaan
                    </button>
                    <button onclick="closePatientDetailModal()" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Statistik Minggu Ini -->
    <div id="weeklyStatsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Statistik Detail Minggu Ini</h3>
                <button onclick="closeWeeklyStatsModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mt-4 space-y-6">
                <!-- Ringkasan Umum -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">85</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Pasien</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">72</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Resep Dibuat</p>
                    </div>
                    <div class="text-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">8</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Rujukan</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">15</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pasien Kontrol</p>
                    </div>
                    <div class="text-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">14 mnt</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Avg. Waktu</p>
                    </div>
                </div>

                <!-- Data Per Hari -->
                <div>
                    <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-3">Data Per Hari</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Hari</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Pasien</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Resep</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Rujukan</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">Avg. Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Senin</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">18</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">15</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">2</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">13 mnt</td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Selasa</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">16</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">14</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">1</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">15 mnt</td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Rabu</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">19</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">17</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">2</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">12 mnt</td>
                                </tr>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">Kamis</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">14</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">12</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">1</td>
                                    <td class="text-center py-3 px-4 text-gray-600 dark:text-gray-400">14 mnt</td>
                                </tr>
                                <tr class="bg-blue-50 dark:bg-blue-900/20">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200 font-semibold">Jumat (Hari Ini)</td>
                                    <td class="text-center py-3 px-4 text-blue-600 dark:text-blue-400 font-semibold">18</td>
                                    <td class="text-center py-3 px-4 text-blue-600 dark:text-blue-400 font-semibold">14</td>
                                    <td class="text-center py-3 px-4 text-blue-600 dark:text-blue-400 font-semibold">2</td>
                                    <td class="text-center py-3 px-4 text-blue-600 dark:text-blue-400 font-semibold">12 mnt</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Diagnosa Terbanyak -->
                <div>
                    <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-3">Diagnosa Terbanyak Minggu Ini</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="text-gray-700 dark:text-gray-300">ISPA (Infeksi Saluran Pernapasan Akut)</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">24 pasien</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="text-gray-700 dark:text-gray-300">Hipertensi</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">15 pasien</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="text-gray-700 dark:text-gray-300">Dispepsia</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">12 pasien</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="text-gray-700 dark:text-gray-300">Diabetes Mellitus</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">10 pasien</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="text-gray-700 dark:text-gray-300">Lainnya</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">24 pasien</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button onclick="closeWeeklyStatsModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk jam realtime dan modal functions --}}
    @push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = hours + ':' + minutes + ':' + seconds;
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        // Modal Functions
        function confirmCallNextPatient() {
            document.getElementById('callPatientModal').classList.remove('hidden');
        }

        function closeCallPatientModal() {
            document.getElementById('callPatientModal').classList.add('hidden');
        }

        function callNextPatient() {
            // Implementasi logika panggil pasien di sini
            alert('Pasien A002 - Siti Nurhaliza telah dipanggil!');
            closeCallPatientModal();
        }

        function showPatientDetail() {
            document.getElementById('patientDetailModal').classList.remove('hidden');
        }

        function closePatientDetailModal() {
            document.getElementById('patientDetailModal').classList.add('hidden');
        }

        function showWeeklyStats() {
            document.getElementById('weeklyStatsModal').classList.remove('hidden');
        }

        function closeWeeklyStatsModal() {
            document.getElementById('weeklyStatsModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>