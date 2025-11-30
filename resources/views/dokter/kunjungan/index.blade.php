<x-app-layout>
    @vite(['resources/js/pages/dokter/kunjungan.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{
        viewModal: false,
        selectedKunjungan: null,
        {{-- showDetail(data) {
            this.selectedKunjungan = data;
            this.viewModal = true;
        } --}}
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">

                <!-- Filter & Search -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-search mr-1"></i> Cari Pasien
                            </label>
                            <input type="text" id="tableSearch" placeholder="Nama pasien atau No. RM..."
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-filter mr-1"></i> Status
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Semua Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="dipanggil">Sedang Diperiksa</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-calendar mr-1"></i> Tanggal
                            </label>
                            <input type="date" name="tgl_kunjungan" id="tgl_kunjungan" value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>

                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto px-4 py-4">
                    <table class="w-full" id="dataTable">
                        <thead class="bg-gray-100 dark:bg-gray-700/50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    No. RM</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Pasien</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Umur</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Keluhan</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">

                            @foreach ($antrian as $i => $a)
                                <!-- Baris 1 - Menunggu -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $a->kunjungan->pasien->no_rm ?? '' }} </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $a->kunjungan->pasien->nama ?? '' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $a->umur }}
                                        tahun</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $a->kunjungan->keluhan_awal ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($a->status === 'menunggu')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                Menunggu Dokter
                                            </span>
                                        @elseif ($a['status'] === 'dipanggil')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Sedang Periksa
                                            </span>
                                        @elseif ($a['status'] === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                Selesai
                                            </span>
                                        @elseif ($a['status'] === 'dibatalkan')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Batal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                @click="viewModal = true; $nextTick(() => loadKunjunganDetail({{ $a->id }}))"
                                                class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                                <i class="fa-solid fa-eye mr-1"></i> Detail
                                            </button>
                                            @if ($a->pemeriksaan)
                                                {{-- Sudah Skrining --}}
                                                <a href="{{ route('dokter.kunjungan.edit', $a->pemeriksaan->id) }}"
                                                    class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-xs font-medium">
                                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Skrining
                                                </a>
                                            @else
                                                {{-- Belum Skrining --}}
                                                <form action="{{ route('dokter.kunjungan.panggil', $a->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors text-xs font-medium">
                                                        <i class="fa-solid fa-file-medical mr-1"></i> Panggil
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                        {{-- <div class="flex items-center justify-center gap-2">
                                            <button
                                                @click="viewModal = true; $nextTick(() => loadKunjunganDetail({{ $a->id }}))"
                                                class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors text-xs font-medium">
                                                <i class="fa-solid fa-eye mr-1"></i> Detail
                                            </button>
                                            <a href="{{ route('dokter.kunjungan.edit', $a->id) }}"
                                                class="px-3 py-1.5 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-lg transition-colors text-xs font-medium">
                                                <i class="fa-solid fa-notes-medical mr-1"></i> Periksa
                                            </a>
                                        </div> --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Modal Detail Pasien -->
        <div x-show="viewModal" x-cloak @click.away="viewModal = false" class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click.stop
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full mx-auto transform transition-all">

                    <!-- Modal Header -->
                    <div
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 px-6 py-4 rounded-t-xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-user-circle"></i>
                                Detail Pasien
                            </h3>
                            <button @click="viewModal = false"
                                class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                                <i class="fa-solid fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4">

                        <!-- Informasi Utama -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">No. Rekam Medis</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100" id="no_rm"></p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                <p class="text-lg font-semibold text-yellow-600 dark:text-yellow-400" id="statusDetail">
                                </p>
                                {{-- <p class="text-lg font-semibold"
                                    :class="{
                                        'text-yellow-600 dark:text-yellow-400': selectedKunjungan
                                            ?.status === 'Menunggu',
                                        'text-blue-600 dark:text-blue-400': selectedKunjungan
                                            ?.status === 'Sedang Diperiksa',
                                        'text-green-600 dark:text-green-400': selectedKunjungan?.status === 'Selesai'
                                    }"
                                    x-text="selectedKunjungan?.status"></p> --}}
                            </div>
                        </div>

                        <!-- Data Pasien -->
                        <div class="space-y-3 border-t dark:border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Lengkap:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                    id="nama"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Kelamin:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" id="jenis_kelamin"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Umur:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" id="tgl_lahir"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">NIK:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100" id="nik"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Daftar:</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100"></span>
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="border-t dark:border-gray-700 pt-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Keluhan:</p>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <p class="text-sm text-gray-900 dark:text-gray-100" id="keluhan"></p>
                            </div>
                        </div>

                        <!-- Hasil Skrining -->
                        <div class="border-t dark:border-gray-700 pt-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">Hasil Skrining:</p>
                            <div class="space-y-3">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tekanan
                                            Darah:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                            id="tensi"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Suhu
                                            Tubuh:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                            id="suhu"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Berat
                                            Badan:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                            id="berat_badan"></span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tinggi
                                            Badan:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100"
                                            id="tinggi_badan"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 rounded-b-xl flex justify-end gap-2">
                        <button @click="viewModal = false"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded-lg transition-colors font-medium">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
