<x-app-layout>
    @vite(['resources/js/pages/petugas/kunjungan.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{
        viewModal: false,
        selectedKunjungan: null,
        deleteId: null,
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-100 dark:border-gray-700">

                <!-- Header: Search dan Tombol Tambah -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <!-- Search Box -->
                    <div class="relative w-full sm:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="tableSearch" placeholder="Cari nama pasien, dokter, atau poli..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>

                    <!-- Tombol Tambah Kunjungan -->
                    <div x-data="{ dropdownOpen: false, modalOpen: false, searchPasien: '', pasienDipilih: null, }" class="relative">
                        {{-- x-init="loadPasien()"
                        dataPasien() --}}
                        <!-- Tombol Dropdown -->
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="inline-flex items-center justify-center gap-2 bg-[#4C4CFF] hover:bg-[#3A63FF] dark:bg-[#2F80FF] dark:hover:bg-[#1F6EFF] text-white px-5 py-2.5 rounded-lg font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200 w-full sm:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Kunjungan
                            <svg class="w-4 h-4 transition-transform duration-200"
                                :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
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
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="font-medium">Cari Pasien Lama</span>
                            </button>
                            <a href="{{ route('petugas.kunjungan.create') }}"
                                class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Tambah Pasien Baru</span>
                                </div>
                            </a>
                        </div>

                        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
                            <div
                                class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                                <div @click="modalOpen = false" x-show="modalOpen"
                                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
                                </div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                                <div x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">

                                    <!-- Header Modal -->
                                    <div
                                        class="bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-900 dark:to-indigo-800 px-6 py-4 flex justify-between items-center">
                                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                                            <i class="fa-solid fa-user-plus"></i>
                                            Pilih Pasien
                                        </h2>
                                        <button @click="modalOpen = false"
                                            class="text-white hover:bg-indigo-800 p-1 rounded transition">
                                            <i class="fa-solid fa-times text-2xl"></i>
                                        </button>
                                    </div>

                                    <!-- Table Container -->
                                    <div class="px-6 py-4">
                                        <div
                                            class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">

                                            <div class="overflow-x-auto">
                                                <table id="data-pasien" class="w-full text-sm stripe hover">
                                                    <thead class="bg-indigo-600 text-white">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left w-10">#</th>
                                                            <th class="px-4 py-3 text-left">Nama</th>
                                                            <th class="px-4 py-3 text-left w-32">No RM</th>
                                                            <th class="px-4 py-3 text-left w-40">Jenis Kelamin</th>
                                                            <th class="px-4 py-3 text-left">Alamat</th>
                                                            <th class="px-4 py-3 text-center w-20">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-700 dark:text-gray-300">
                                                        @foreach ($pasien as $i => $p)
                                                            <tr class="border-b hover:bg-gray-50 transition">
                                                                <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}
                                                                </td>
                                                                <td class="px-3 sm:px-4 py-2">
                                                                    {{ $p->nama ?? '' }}</td>
                                                                <td class="px-3 sm:px-4 py-2">
                                                                    {{ $p->no_rm ?? '' }}</td>
                                                                <td class="px-3 sm:px-4 py-2">
                                                                    {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                                                </td>
                                                                <td class="px-3 sm:px-4 py-2">{{ $p->alamat ?? '' }}
                                                                </td>

                                                                <td class="px-3 sm:px-4 py-2 text-center">
                                                                    <div class="flex justify-center gap-1 sm:gap-2">
                                                                        <!-- Edit Button -->
                                                                        <a href="{{ route('petugas.kunjungan.create', ['pasien_id' => $p->id]) }}"
                                                                            class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                                            Pilih
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- <div
                                        class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span x-show="pasienDipilih"
                                                x-text="'Dipilih: ' + (pasienDipilih?.nama || '')"></span>
                                            <span x-show="!pasienDipilih"
                                                class="text-gray-400 dark:text-gray-500">Pilih
                                                pasien dari
                                                daftar</span>
                                        </p>
                                        <div class="flex gap-3">
                                            <button @click="modalOpen = false; pasienDipilih = null"
                                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 font-medium transition-colors">
                                                Batal
                                            </button>

                                            <button
                                                @click="if(pasienDipilih) { alert('Pasien ' + pasienDipilih.nama + ' (' + pasienDipilih.rm + ') ditambahkan ke kunjungan!'); modalOpen = false; pasienDipilih = null; }"
                                                :disabled="!pasienDipilih"
                                                :class="pasienDipilih ? 'bg-indigo-600 hover:bg-indigo-700 cursor-pointer text-white' : 'bg-gray-300 dark:bg-gray-600 cursor-not-allowed text-gray-500'"
                                                class="px-5 py-2 rounded-lg font-medium transition-all shadow-md flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Pilih Pasien
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Tabel Kunjungan Pasien -->
                <div class="overflow-x-auto border border-gray-200 dark:border-gray-700">
                    <table id="dataTable"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        <thead class="bg-[#4C4CFF] dark:bg-gray-700 text-white text-left">
                            <tr>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    No Antrian</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Nama Pasien</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    No. Rekam Medis</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Dokter</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Poli</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-3.5 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach ($kunjungan as $i => $k)
                                <tr class="hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full bg-[#4C4CFF] dark:bg-[#2F80FF]  text-white font-bold text-sm shadow-md">
                                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </td>

                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $k->pasien->nama ?? '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            {{ $k->pasien->no_rm ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                            {{ $k->dokter->nama ?? '' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400">
                                            {{ $k->poli->nama }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($k->status === 'menunggu')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                Menunggu Skrining
                                            </span>
                                        @elseif ($k['status'] === 'dipanggil')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Sedang Periksa
                                            </span>
                                        @elseif ($k['status'] === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                Selesai Diperiksa
                                            </span>
                                        @elseif ($k['status'] === 'dibatalkan')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Batal
                                            </span>
                                        @elseif ($k['status'] === 'tidak hadir')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 text-center">
                                        <div class="flex justify-center gap-1 sm:gap-2">

                                            <div class="relative group">
                                                <!-- Tombol (hanya hiasan) -->
                                                <button
                                                    class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-colors text-gray-600 dark:text-gray-300">
                                                    ⋮
                                                </button>

                                                <!-- Dropdown -->
                                                <div
                                                    class="absolute top-1/2 -translate-y-1/2 right-0 w-32
                                                            bg-white dark:bg-gray-800
                                                            border border-gray-200 dark:border-gray-700
                                                            rounded-lg shadow-lg dark:shadow-xl z-50
                                                            opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                                            transition-all duration-200">

                                                    <!-- PANGGIL -->
                                                    <form
                                                        action="{{ route('petugas.kunjungan.updateStatus', $k->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="dipanggil">
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2
                                                                    text-gray-700 dark:text-gray-300
                                                                    hover:bg-gray-100 dark:hover:bg-gray-700
                                                                    transition-colors duration-150
                                                                    first:rounded-t-md">
                                                            Panggil
                                                        </button>
                                                    </form>

                                                    <!-- BERUBAH/SELESAI -->
                                                    <form
                                                        action="{{ route('petugas.kunjungan.updateStatus', $k->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2
                                                                    text-gray-700 dark:text-gray-300
                                                                    hover:bg-gray-100 dark:hover:bg-gray-700
                                                                    transition-colors duration-150
                                                                    border-t border-gray-200 dark:border-gray-700">
                                                            Selesai
                                                        </button>
                                                    </form>

                                                    <!-- BATAL -->
                                                    <form
                                                        action="{{ route('petugas.kunjungan.updateStatus', $k->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="dibatalkan">
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2
                                                                    text-red-600 dark:text-red-400
                                                                    hover:bg-gray-100 dark:hover:bg-gray-700
                                                                    hover:text-red-700 dark:hover:text-red-300
                                                                    transition-colors duration-150
                                                                    border-t border-gray-200 dark:border-gray-700
                                                                    last:rounded-b-md">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <button
                                                @click="viewModal = true; $nextTick(() => loadKunjunganDetail({{ $k->id }}))"
                                                class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <a href="{{ route('petugas.kunjungan.edit', $k->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-sm transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('petugas.kunjungan.destroy', $k->id) }}"
                                                method="POST" class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-lg text-sm transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal View Detail Kunjungan -->
                <div x-show="viewModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
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
                        <div
                            class="flex items-center justify-between p-6 pb-4 border-b-2 border-indigo-500 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30">
                            <div>
                                <h2
                                    class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Detail Kunjungan Pasien
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap data
                                    kunjungan pasien</p>
                            </div>
                            <button @click="viewModal = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors hover:rotate-90 duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Content Scrollable -->
                        <div class="overflow-y-auto p-6 space-y-5">

                            <!-- Informasi Kunjungan -->
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-5 rounded-xl border-l-4 border-indigo-500">
                                <h3
                                    class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Informasi Kunjungan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">
                                            Tanggal &
                                            Waktu Kunjungan</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="tgl_kunjungan"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Status
                                            Kunjungan</p>
                                        <span id="status"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Identitas Pasien -->
                            <div
                                class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-5 rounded-xl border-l-4 border-blue-500">
                                <h3
                                    class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Identitas Pasien
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Nama
                                            Lengkap</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="nama"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No.
                                            Rekam
                                            Medis</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="no_rm"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">
                                            Tanggal
                                            Lahir</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="tgl_lahir"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Jenis
                                            Kelamin</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="jenis_kelamin"></p>

                                    </div>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-5 rounded-xl border-l-4 border-green-500">
                                <h3
                                    class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Informasi Kontak
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Email
                                        </p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="email"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No.
                                            Telepon</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="no_telp"></p>

                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Alamat
                                            Lengkap</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="alamat"></p>

                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Medis -->
                            <div
                                class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-5 rounded-xl border-l-4 border-purple-500">
                                <h3
                                    class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                    Informasi Layanan Medis
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Dokter
                                            Pemeriksa</p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="dokter"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">
                                            Poliklinik
                                        </p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="poli"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No.
                                            BPJS
                                        </p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200"
                                            id="no_bpjs"></p>

                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Jenis
                                            Pasien</p>
                                        <span id="jenis_pasien"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Fixed -->
                        <div
                            class="p-6 pt-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3">
                            <button @click="viewModal = false"
                                class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    @vite(['resources/js/pages/petugas/kunjungan.js'])
@endpush

<style>
    /* Styling untuk DataTables */
    .dataTables_wrapper {
        color: inherit;
    }

    /* Light Mode */
    .dataTables_length select,
    .dataTables_filter input {
        color: #000 !important;
        background-color: #fff !important;
        padding: 6px 10px;
        border-radius: 6px;
        margin-left: 6px;
        border: 1px solid #d1d5db !important;
    }

    .dataTables_length select:hover,
    .dataTables_filter input:hover {
        border-color: #9ca3af;
    }

    .dataTables_length select:focus,
    .dataTables_filter input:focus {
        outline: none;
        border-color: #4f46e5;
        background-color: #fff !important;
        color: #000 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .dataTables_info,
    .dataTables_length,
    .dataTables_filter,
    .dataTables_paginate {
        color: #9ca3af !important;
        margin-top: 10px;
    }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button:hover {
        background-color: #4f46e5 !important;
        color: white !important;
        border: 1px solid #4f46e5 !important;
    }

    table.dataTable {
        border-collapse: collapse !important;
    }

    table.dataTable tbody tr {
        background: transparent;
    }

    /* Dark Mode */
    :root {
        color-scheme: light dark;
    }

    /* Untuk browser yang support dark mode dengan class */
    .dark .dataTables_length select,
    .dark .dataTables_filter input {
        color: #e5e7eb !important;
        background-color: #374151 !important;
        border-color: #4b5563 !important;
    }

    .dark .dataTables_length select:hover,
    .dark .dataTables_filter input:hover {
        border-color: #6b7280;
    }

    .dark .dataTables_length select:focus,
    .dark .dataTables_filter input:focus {
        outline: none;
        border-color: #818cf8;
        background-color: #374151 !important;
        color: #e5e7eb !important;
        box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
    }

    .dark .dataTables_info,
    .dark .dataTables_length,
    .dark .dataTables_filter,
    .dark .dataTables_paginate {
        color: #9ca3af !important;
    }

    .dark .dataTables_paginate .paginate_button {
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    .dark .dataTables_paginate .paginate_button:hover {
        background-color: #4f46e5 !important;
        color: white !important;
        border-color: #4f46e5 !important;
    }

    .dark .dataTables_paginate .paginate_button.current {
        background-color: #4f46e5 !important;
        color: white !important;
        border-color: #4f46e5 !important;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ($.fn.DataTable.isDataTable('#data-pasien')) {
            $('#data-pasien').DataTable().destroy();
        }
        $('#data-pasien').DataTable({
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50],
                [5, 10, 25, 50]
            ],
            responsive: true,
            dom: "<'flex flex-col sm:flex-row justify-between items-center mb-4'lf>" +
                "<'overflow-x-auto't>" +
                "<'flex flex-col sm:flex-row justify-between items-center mt-4'ip>",
            language: {
                search: "Cari pasien:",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "‹",
                    next: "›"
                }
            }

            $('#data-pasien').DataTable({
                pageLength: 5,
                responsive: true,

                // Mengatur posisi search & filter di atas
                dom: "<'flex flex-col sm:flex-row justify-between items-center mb-4'lf>" +
                    "<'overflow-x-auto't>" +
                    "<'flex flex-col sm:flex-row justify-between items-center mt-4'ip>",

                language: {
                    search: "Cari pasien:",
                    lengthMenu: "Tampilkan _MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });

        });

        // Observe dark mode changes
        const observer = new MutationObserver(function(mutations) {
            // Trigger DataTables redraw untuk apply styling
            if ($.fn.DataTable.isDataTable('#data-pasien')) {
                $.fn.dataTable.tables().nodes().to$().DataTable().draw(false);
            }
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>
