<x-app-layout>
    @vite(['resources/js/pages/admin/data-petugas.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Petugas Rekamedis') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700">

                <!-- Search dan Tambah Petugas -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        <input type="text" id="tableSearch" placeholder="Cari nama petugas, Jabatan, atau KTA..."
                            class="w-full border border-gray-300 dark:border-gray-600 
                                   bg-white dark:bg-gray-700 
                                   text-gray-800 dark:text-gray-200
                                   rounded-lg pl-10 pr-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>

                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-petugas.create') }}"
                            class="w-full sm:w-auto 
                                   bg-[#4C4CFF] hover:bg-[#3A63FF] dark:bg-[#2F80FF] dark:hover:bg-[#1F6EFF]
                                   text-white 
                                   px-4 py-2 text-sm rounded-lg font-medium 
                                   flex items-center justify-center gap-2 
                                   shadow-md transition">
                            <i class="fa-solid fa-plus"></i> Tambah Petugas
                        </a>
                    </div>
                </div>

                <!-- Tabel Petugas -->
                <div x-data="{ viewModal: false }">
                    <div class="overflow-x-auto">
                        <table id="dataTable"
                            class="min-w-full border border-gray-200 dark:border-slate-600
                                   text-xs sm:text-sm overflow-hidden">

                            <thead class="bg-[#4C4CFF] dark:bg-gray-700 text-white text-left">
                                <tr>
                                    <th class="px-3 sm:px-4 py-3">No</th>
                                    <th class="px-3 sm:px-4 py-3">Nama Lengkap</th>
                                    <th class="px-3 sm:px-4 py-3">No. KTA</th>
                                    <th class="px-3 sm:px-4 py-3">Jabatan</th>
                                    <th class="px-3 sm:px-4 py-3">Telp</th>
                                    <th class="px-3 sm:px-4 py-3">Status</th>
                                    <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700 dark:text-gray-300">
                                @foreach ($petugas as $i => $p)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->nama ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->no_kta ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->jabatan ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->no_telp ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        @if ($p->status === 1)
                                            <span class="inline-flex items-center justify-center min-w-[70px] h-6 
                                                         bg-green-100 dark:bg-green-900/40
                                                         text-green-700 dark:text-green-400
                                                         rounded-full text-[11px] font-medium">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center min-w-[70px] h-6 
                                                         bg-red-100 dark:bg-red-900/40
                                                         text-red-700 dark:text-red-400
                                                         rounded-full text-[11px] font-medium">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-3 sm:px-4 py-2 text-center">
                                        <div class="flex justify-center gap-1 sm:gap-2">

                                            <button
                                                @click="viewModal = true; $nextTick(() => loadPetugasDetail({{ $p->id }}))"
                                                class="bg-blue-500 hover:bg-blue-600 text-white 
                                                       p-2 rounded-lg text-xs transition-all duration-300 
                                                       hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.master-petugas.edit', $p->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white 
                                                       p-2 rounded-lg text-xs transition-all duration-300 
                                                       hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form action="{{ route('admin.master-petugas.destroy', $p->id) }}" method="POST" class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white 
                                                           p-2 px-2.5 rounded-lg text-xs 
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

                    <!-- === Modal Detail Petugas (Dark Mode) === -->
                    <div x-show="viewModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">

                        <div @click.away="viewModal = false"
                            class="bg-white dark:bg-gray-800 
                                   rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] 
                                   overflow-hidden flex flex-col">

                            <!-- Header -->
                            <div class="flex items-center justify-between p-6 
                                        border-b border-blue-500 
                                        bg-gradient-to-r from-blue-50 to-blue-100 
                                        dark:from-gray-900 dark:to-gray-800">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                                    Detail Petugas Rekamedis
                                </h2>

                                <button @click="viewModal = false"
                                        class="text-gray-400 hover:text-white transition">
                                    <i class="fa-solid fa-times text-2xl"></i>
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="overflow-y-auto p-6 space-y-5">
                                @foreach(['Nama Lengkap'=>'nama', 'Jenis Kelamin'=>'jenis_kelamin','Tempat Lahir'=>'tempat_lahir','Tanggal Lahir'=>'tgl_lahir','Email'=>'email','No Telepon'=>'no_telp','No STR'=>'no_str','No SIP'=>'no_sip','No KTA'=>'no_kta','Jabatan'=>'jabatan','Alamat'=>'alamat'] as $label => $id)
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $label }}</p>
                                    <p class="text-base font-semibold text-gray-800 dark:text-gray-200" id="{{ $id }}"></p>
                                </div>
                                @endforeach  
                            </div>

                            <!-- Footer -->
                            <div class="p-4 border-t border-gray-200 dark:border-gray-700 
                                        bg-gray-50 dark:bg-gray-900 flex justify-end gap-3">
                                <button @click="viewModal = false"
                                        class="px-5 py-2 bg-gray-200 dark:bg-gray-700 
                                               text-gray-700 dark:text-gray-200 
                                               rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                                    Tutup
                                </button>

                                <a href="#"
                                   class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
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
