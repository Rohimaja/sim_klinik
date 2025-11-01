<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Tindakan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Search dan Tambah Tindakan -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="tableSearch" placeholder="Cari nama Tindakan..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>


                    <div class="w-full sm:w-auto">
                        <a href="{{ route('tindakan.form') }}"
                            class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah tindakan
                        </a>
                    </div>
                </div>

                <!-- Tabel Tindakan -->
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
                            <tr>
                                <th class="px-3 sm:px-4 py-3">No</th>
                                <th class="px-3 sm:px-4 py-3">Nama Tindakan</th>
                                <th class="px-3 sm:px-4 py-3">Kategori</th>
                                <th class="px-3 sm:px-4 py-3">Deskripsi</th>
                                <th class="px-3 sm:px-4 py-3">Tarif</th>
                                <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @php
                                $tindakans = [
                                    ['nama' => 'Pemeriksaan Umum', 'kategori' => 'Konsultasi', 'deskripsi' => 'Pemeriksaan dasar oleh dokter umum untuk keluhan umum pasien.', 'tarif' => 50000],
                                    ['nama' => 'Pembersihan Gigi (Scaling)', 'kategori' => 'Gigi dan Mulut', 'deskripsi' => 'Prosedur pembersihan karang gigi untuk menjaga kesehatan gusi dan gigi.', 'tarif' => 150000],
                                    ['nama' => 'Suntik Antibiotik', 'kategori' => 'Tindakan Medis', 'deskripsi' => 'Pemberian antibiotik melalui suntikan sesuai resep dokter.', 'tarif' => 25000],
                                    ['nama' => 'Pemeriksaan Kehamilan', 'kategori' => 'Kebidanan', 'deskripsi' => 'Pemeriksaan kondisi ibu hamil dan janin oleh tenaga medis.', 'tarif' => 60000],
                                    ['nama' => 'Nebulisasi Anak', 'kategori' => 'Anak', 'deskripsi' => 'Terapi pernapasan menggunakan alat nebulizer untuk anak.', 'tarif' => 40000],
                                    ['nama' => 'Pemasangan Infus', 'kategori' => 'Tindakan Umum', 'deskripsi' => 'Pemasangan cairan infus untuk pasien dengan indikasi tertentu.', 'tarif' => 30000],
                                    ['nama' => 'Penjahitan Luka Ringan', 'kategori' => 'Bedah Minor', 'deskripsi' => 'Penutupan luka kecil dengan jahitan sederhana.', 'tarif' => 100000],
                                    ['nama' => 'Pemeriksaan Tekanan Darah', 'kategori' => 'Umum', 'deskripsi' => 'Pengukuran tekanan darah untuk deteksi hipertensi atau hipotensi.', 'tarif' => 10000],
                                    ['nama' => 'Konsultasi Spesialis Anak', 'kategori' => 'Spesialis', 'deskripsi' => 'Konsultasi dengan dokter spesialis anak terkait masalah kesehatan anak.', 'tarif' => 80000],
                                    ['nama' => 'Konsultasi Kulit & Kelamin', 'kategori' => 'Spesialis', 'deskripsi' => 'Pemeriksaan dan konsultasi untuk masalah kulit dan kelamin.', 'tarif' => 90000],
                                ];
                            @endphp

                            @foreach ($tindakans as $i => $d)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['nama'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['kategori'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['deskripsi'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['tarif'] }}</td>

                                    <td class="px-3 sm:px-4 py-2 text-center" x-data="{ viewModal: false, deleteModal: false }">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            <!-- Edit Button -->
                                            <a href="/admin/masterData/tindakan/edit" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <button @click="deleteModal = true" 
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
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
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
                                                
                                                <!-- Icon Warning -->
                                                <div class="flex justify-center mb-4">
                                                    <div class="bg-red-100 rounded-full p-4 animate-pulse">
                                                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-4xl"></i>
                                                    </div>
                                                </div>

                                                <!-- Header -->
                                                <h2 class="text-2xl font-bold mb-3 text-red-600 text-center">Konfirmasi Hapus</h2>
                                                
                                                <!-- Content -->
                                                <p class="text-gray-600 text-center mb-6">
                                                    Apakah Anda yakin ingin menghapus tindakan<br>
                                                </p>
                                                <p class="text-sm text-gray-500 text-center mb-6 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                                                    <i class="fa-solid fa-info-circle mr-1"></i>
                                                    Data yang dihapus tidak dapat dikembalikan!
                                                </p>

                                                <!-- Footer -->
                                                <div class="flex gap-3">
                                                    <button @click="deleteModal = false" 
                                                            class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 font-medium">
                                                        <i class="fa-solid fa-arrow-left mr-1"></i>Batal
                                                    </button>
                                                    <form action="#" method="POST" class="flex-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg font-medium">
                                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    


</x-app-layout>
