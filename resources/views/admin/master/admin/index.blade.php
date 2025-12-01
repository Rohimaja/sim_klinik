<x-app-layout>
    @vite(['resources/js/pages/superadmin/data-admin.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Master Data > Admin') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700">

                <!-- Search dan Tambah Dokter -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i
                            class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>

                        <input type="text" id="tableSearch"
                            placeholder="Cari nama dokter, spesialis, atau STR..."
                            class="w-full border border-gray-300 dark:border-gray-600
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                            rounded-lg pl-10 pr-3 py-2 text-sm
                            focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>

                    <div class="w-full sm:w-auto">
                        <a href="{{ route('superadmin.master-admin.create') }}"
                            class="w-full sm:w-auto 
                                   bg-[#4C4CFF] hover:bg-[#3A63FF] dark:bg-[#2F80FF] dark:hover:bg-[#1F6EFF]
                                   text-white 
                                   px-4 py-2 text-sm rounded-lg font-medium 
                                   flex items-center justify-center gap-2 
                                   shadow-md transition">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Admin
                        </a>
                    </div>
                </div>

                <!-- Tabel Dokter -->
                <div x-data="{ viewModal: false }">

                    <div class="overflow-x-auto">
                        <table id="dataTable"
                            class="min-w-full border border-gray-200 dark:border-slate-600
                                   text-xs sm:text-sm overflow-hidden">

                            <thead class="bg-[#4C4CFF] dark:bg-gray-700 text-white text-left">
                                <tr>
                                    <th class="px-3 sm:px-4 py-3">No</th>
                                    <th class="px-3 sm:px-4 py-3">Nama Lengkap</th>
                                    <th class="px-3 sm:px-4 py-3">Umur</th>
                                    <th class="px-3 sm:px-4 py-3">No. Telepon</th>
                                    <th class="px-3 sm:px-4 py-3">Status</th>
                                    <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700 dark:text-gray-200">

                                @foreach ($admin as $i => $a)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700
                                        hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                        <td class="px-3 sm:px-4 py-2">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-3 sm:px-4 py-2 text-gray-600 dark:text-gray-300">
                                            {{ $a->nama ?? '' }}
                                        </td>

                                        <td class="px-3 sm:px-4 py-2">
                                            {{ \Carbon\Carbon::parse($a->tgl_lahir)->age ?? '-' }} tahun
                                        </td>

                                        <td class="px-3 sm:px-4 py-2">
                                            {{ $a->no_telp ?? '' }}
                                        </td>

                                        <td class="px-3 sm:px-4 py-2">
                                            @if ($a->status === 1)
                                                <span
                                                    class="inline-flex items-center justify-center
                                                    min-w-[70px] h-6
                                                    bg-green-100 dark:bg-green-900
                                                    text-green-700 dark:text-green-300
                                                    rounded-full text-[11px] font-medium">
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center
                                                    min-w-[70px] h-6
                                                    bg-red-100 dark:bg-red-900
                                                    text-red-700 dark:text-red-300
                                                    rounded-full text-[11px] font-medium">
                                                    Non-Aktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-3 sm:px-4 py-2 text-center">
                                            <div class="flex justify-center gap-1 sm:gap-2">

                                                <!-- View Button -->
                                                <button
                                                    @click="viewModal = true; $nextTick(() => loadAdminDetail({{ $a->id }}))"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs
                                                    transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <a
                                                    href="{{ route('superadmin.master-admin.edit', $a->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs
                                                    transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('superadmin.master-admin.destroy', $a->id) }}"
                                                    method="POST" class="form-hapus">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs
                                                        transition-all duration-300 hover:shadow-lg hover:scale-105">
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

                    <!-- VIEW MODAL -->
                    <div
                        x-show="viewModal" x-cloak
                        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4"
                        style="display:none">

                        <div @click.away="viewModal = false"
                            class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                            rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden
                            flex flex-col">

                            <!-- HEADER -->
                            <div
                                class="flex items-center justify-between p-6 pb-4
                                border-b border-blue-500 bg-gradient-to-r from-blue-50 to-blue-100
                                dark:from-gray-700 dark:to-gray-800">

                                <div>
                                    <h2
                                        class="text-2xl font-bold flex items-center gap-2 text-gray-800 dark:text-white">
                                        <i
                                            class="fa-solid fa-user-doctor text-blue-500"></i>
                                        Detail Admin
                                    </h2>
                                    <p
                                        class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Informasi lengkap data admin
                                    </p>
                                </div>

                                <button @click="viewModal = false"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                    <i class="fa-solid fa-times text-2xl"></i>
                                </button>

                            </div>

                            <!-- CONTENT -->
                            <div class="overflow-y-auto p-6 space-y-5">

                                <!-- IDENTITAS -->
                                <div
                                    class="p-5 rounded-xl border-l-4 border-blue-500
                                    bg-blue-50 dark:bg-gray-700">

                                    <h3
                                        class="text-lg font-bold mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-id-card text-blue-500"></i>
                                        Identitas Pribadi
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Nama Lengkap</p>
                                            <p class="text-base font-semibold" id="nama"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Jenis Kelamin</p>
                                            <p class="text-base font-semibold" id="jenis_kelamin"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Tempat Lahir</p>
                                            <p class="text-base font-semibold" id="tempat_lahir"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Tanggal Lahir</p>
                                            <p class="text-base font-semibold" id="tgl_lahir"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- KONTAK -->
                                <div
                                    class="p-5 rounded-xl border-l-4 border-green-500
                                    bg-green-50 dark:bg-gray-700">

                                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-address-book text-green-500"></i>
                                        Informasi Kontak
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">Email</p>
                                            <p class="text-base font-semibold" id="email"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">No. Telepon</p>
                                            <p class="text-base font-semibold" id="no_telp"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ALAMAT -->
                                <div
                                    class="p-5 rounded-xl border-l-4 border-red-500
                                    bg-red-50 dark:bg-gray-700">

                                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-red-500"></i>
                                        Alamat Lengkap
                                    </h3>

                                    <p class="text-base font-semibold" id="alamat"></p>
                                </div>

                                <!-- STATUS -->
                                <div
                                    class="p-5 rounded-xl border-l-4 border-teal-500
                                    bg-teal-50 dark:bg-gray-700">

                                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-circle-info text-teal-500"></i>
                                        Status Aktif
                                    </h3>

                                    <div
                                        class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-lg">

                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">
                                                Status Dokter
                                            </p>
                                            <p class="text-base font-semibold">
                                                Sedang Tidak Aktif Bertugas
                                            </p>
                                        </div>

                                        <span
                                            class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-full shadow flex items-center gap-2"
                                            id="status">
                                            <i class="fa-solid fa-times"></i>
                                            Non-Aktif
                                        </span>

                                    </div>

                                    <div
                                        class="mt-3 bg-blue-100 dark:bg-gray-800 p-3 rounded-lg border border-blue-200 dark:border-gray-600">

                                        <p class="text-xs text-blue-700 dark:text-blue-300" id="update_at"></p>
                                    </div>

                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div
                                class="p-6 pt-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900
                                flex justify-end gap-3">

                                <button
                                    @click="viewModal = false"
                                    class="px-6 py-2.5 bg-gray-300 dark:bg-gray-700
                                    text-gray-800 dark:text-gray-100
                                    rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-times mr-2"></i>
                                    Tutup
                                </button>

                                <a href="#"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white
                                    rounded-lg shadow font-medium">
                                    <i class="fa-solid fa-print mr-2"></i>
                                    Cetak Detail
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
