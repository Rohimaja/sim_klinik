<x-app-layout>
    @vite(['resources/js/pages/admin/data-perawat.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Perawat') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                <!-- Search dan Tambah Perawat -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        <input
                            type="text"
                            id="tableSearch"
                            placeholder="Cari nama perawat, Unit, atau NIRA..."
                            class="w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 
                                   border border-gray-300 dark:border-gray-600 
                                   rounded-lg pl-10 pr-3 py-2 text-sm 
                                   focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        >
                    </div>

                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-perawat.create') }}"
                            class="w-full sm:w-auto 
                                   bg-[#4C4CFF] hover:bg-[#3A63FF] dark:bg-[#2F80FF] dark:hover:bg-[#1F6EFF]
                                   text-white 
                                   px-4 py-2 text-sm rounded-lg font-medium 
                                   flex items-center justify-center gap-2 
                                   shadow-md transition">
                            <i class="fa-solid fa-plus"></i> Tambah Perawat
                        </a>
                    </div>
                </div>

                <!-- Tabel Perawat -->
                <div x-data="{viewModal: false}">
                    <div class="overflow-x-auto">
                        <table id="dataTable"
                            class="min-w-full border border-gray-200 dark:border-slate-600
                                   text-xs sm:text-sm overflow-hidden">

                            <thead class="bg-[#4C4CFF] dark:bg-gray-700 text-white text-left">
                                <tr>
                                    <th class="px-3 sm:px-4 py-3">No</th>
                                    <th class="px-3 sm:px-4 py-3">Nama Lengkap</th>
                                    <th class="px-3 sm:px-4 py-3">No. NIRA</th>
                                    <th class="px-3 sm:px-4 py-3">Unit</th>
                                    <th class="px-3 sm:px-4 py-3">No. Telepon</th>
                                    <th class="px-3 sm:px-4 py-3">Status</th>
                                    <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700 dark:text-gray-300">
                                @foreach ($perawat as $i => $p)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700 
                                               hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                                    >
                                        <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->nama }}</td>
                                        <td class="px-3 sm:px-4 py-2 text-gray-600 dark:text-gray-400">{{ $p->no_nira ?? '' }}</td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->poli->nama }}</td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->no_telp }}</td>
                                        <td class="px-3 sm:px-4 py-2">
                                            @if ($p->status === 1)
                                                <span
                                                    class="inline-flex items-center justify-center min-w-[70px] h-6 
                                                           bg-green-100 dark:bg-green-900/40 
                                                           text-green-700 dark:text-green-400 
                                                           rounded-full text-[11px] font-medium"
                                                >
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center min-w-[70px] h-6 
                                                           bg-red-100 dark:bg-red-900/40 
                                                           text-red-700 dark:text-red-400 
                                                           rounded-full text-[11px] font-medium"
                                                >
                                                    Non-Aktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-3 sm:px-4 py-2 text-center">
                                            <div class="flex justify-center gap-1 sm:gap-2">
                                                <button
                                                    @click="viewModal = true; $nextTick(() => loadPerawatDetail({{ $p->id }}))"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all"
                                                >
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <a href="{{ route('admin.master-perawat.edit', $p->id) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs transition-all inline-block"
                                                >
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <form action="{{ route('admin.master-perawat.destroy', $p->id) }}" method="POST" class="form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs transition-all"
                                                    >
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

                    <!-- View Modal -->
                    <div
                        x-show="viewModal"
                        class="fixed inset-0 bg-black bg-opacity-60 dark:bg-opacity-80 
                               flex items-center justify-center z-50 p-4"
                        style="display: none;"
                    >
                        <div @click.away="viewModal = false"
                             class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                                    rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col">

                            <!-- Header -->
                            <div class="flex items-center justify-between p-6 pb-4 border-b 
                                        border-blue-300 dark:border-blue-600 
                                        bg-blue-50 dark:bg-gray-800">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    Detail Perawat
                                </h2>
                                <button @click="viewModal = false" class="text-gray-400 hover:text-gray-300">
                                    <i class="fa-solid fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="overflow-y-auto p-6 space-y-5 text-gray-800 dark:text-gray-200">
                                <p><strong>Nama:</strong> <span id="nama"></span></p>
                                <p><strong>Jenis Kelamin:</strong> <span id="jenis_kelamin"></span></p>
                                <p><strong>Tempat Lahir:</strong> <span id="tempat_lahir"></span></p>
                                <p><strong>Tanggal Lahir:</strong> <span id="tgl_lahir"></span></p>
                                <p><strong>Email:</strong> <span id="email"></span></p>
                                <p><strong>No. Telp:</strong> <span id="no_telp"></span></p>
                                <p><strong>STR:</strong> <span id="no_str"></span></p>
                                <p><strong>SIP:</strong> <span id="no_sip"></span></p>
                                <p><strong>NIRA:</strong> <span id="no_nira"></span></p>
                                <p><strong>Poli:</strong> <span id="poli"></span></p>
                                <p><strong>Alamat:</strong> <span id="alamat"></span></p>
                                <p id="update_at"></p>
                            </div>

                            <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-right">
                                <button
                                    @click="viewModal = false"
                                    class="px-6 py-2 bg-gray-300 dark:bg-gray-700 
                                           text-gray-800 dark:text-gray-200 rounded-lg">
                                    Tutup
                                </button>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
