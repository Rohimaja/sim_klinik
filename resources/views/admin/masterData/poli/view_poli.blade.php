<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Poli') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Search dan Tambah Poli -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="tableSearch" placeholder="Cari poli..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>


                    <div class="w-full sm:w-auto">
                        <a href="{{ route('poli.form') }}"
                            class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah Poli
                        </a>
                    </div>
                </div>

                <!-- Tabel Poli -->
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
                            <tr>
                                <th class="px-3 sm:px-4 py-3">No</th>
                                <th class="px-3 sm:px-4 py-3">Nama Poli</th>
                                <th class="px-3 sm:px-4 py-3">Keterangan</th>
                                <th class="px-3 sm:px-4 py-3">Status</th>
                                <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @php
                                $polis = [
                                    ['nama_poli' => 'Poli Umum', 'keterangan' => 'Melayani pemeriksaan umum dan keluhan ringan', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Gigi', 'keterangan' => 'Melayani perawatan dan pemeriksaan gigi serta mulut', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Anak', 'keterangan' => 'Melayani pemeriksaan dan pengobatan untuk anak-anak', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Penyakit Dalam', 'keterangan' => 'Melayani pasien dengan keluhan penyakit organ dalam', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Bedah', 'keterangan' => 'Melayani tindakan dan konsultasi bedah ringan hingga berat', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Kulit & Kelamin', 'keterangan' => 'Melayani pemeriksaan penyakit kulit dan kelamin', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Kandungan', 'keterangan' => 'Melayani pemeriksaan ibu hamil dan kesehatan reproduksi wanita', 'status' => 'aktif'],
                                    ['nama_poli' => 'Poli Jantung', 'keterangan' => 'Melayani pemeriksaan jantung dan pembuluh darah', 'status' => 'non-aktif'],
                                    ['nama_poli' => 'IGD', 'keterangan' => 'Instalasi Gawat Darurat, buka 24 jam', 'status' => 'aktif'],
                                    ['nama_poli' => 'ICU', 'keterangan' => 'Intensive Care Unit, perawatan intensif pasien kritis', 'status' => 'aktif'],
                                ];
                            @endphp

                            @foreach ($polis as $i => $d)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['nama_poli'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $d['keterangan'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        @if ($d['status'] === 'aktif')
                                            <span
                                                class="inline-flex items-center justify-center min-w-[70px] h-6 bg-green-100 text-green-700 rounded-full text-[11px] font-medium">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center justify-center min-w-[70px] h-6 bg-red-100 text-red-700 rounded-full text-[11px] font-medium">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-3 sm:px-4 py-2 text-center" x-data="{ viewModal: false, deleteModal: false }">
                                        <div class="flex justify-center gap-1 sm:gap-2">

                                            <!-- Edit Button -->
                                            <a href="/admin/masterData/poli/edit" 
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
                                                    Apakah Anda yakin ingin menghapus poli<br>
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
