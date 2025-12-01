<x-app-layout>
    @vite(['resources/js/pages/admin/data-pasien.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Master Data > Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700">

                <!-- Search dan Tambah Pasien -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                    <!-- Search -->
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        <input
                            type="text"
                            id="tableSearch"
                            placeholder="Cari nama pasien, alamat, atau No.Telp..."
                            class="w-full border border-gray-300 dark:border-gray-600
                                   bg-white dark:bg-slate-700
                                   text-gray-800 dark:text-white
                                   rounded-lg pl-10 pr-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>

                    <!-- Tambah Pasien -->
                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-pasien.create') }}"
                           class="w-full sm:w-auto
                                  bg-[#4C4CFF] hover:bg-[#3A63FF] dark:bg-[#2F80FF] dark:hover:bg-[#1F6EFF]
                                  text-white
                                  px-4 py-2 text-sm rounded-lg font-medium
                                  flex items-center justify-center gap-2
                                  shadow-md transition">
                            <i class="fa-solid fa-plus"></i> Tambah Pasien
                        </a>
                    </div>
                </div>

                <!-- Tabel -->
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
                                    <th class="px-3 sm:px-4 py-3">Jenis kelamin</th>
                                    <th class="px-3 sm:px-4 py-3">Alamat</th>
                                    <th class="px-3 sm:px-4 py-3">No. Telp</th>
                                    <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700 dark:text-gray-300">
                                @foreach ($pasien as $i => $p)
                                    <tr class="border-b border-gray-200 dark:border-gray-700
                                               hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                                        <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->nama ?? '' }}</td>
                                        <td class="px-3 sm:px-4 py-2">
                                            {{ \Carbon\Carbon::parse($p->tgl_lahir)->age ?? '-' }} tahun
                                        </td>
                                        <td class="px-3 sm:px-4 py-2">
                                            {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->alamat ?? '' }}</td>
                                        <td class="px-3 sm:px-4 py-2">{{ $p->no_telp ?? '' }}</td>

                                        <td class="px-3 sm:px-4 py-2 text-center">
                                            <div class="flex justify-center gap-1 sm:gap-2">

                                                <!-- View -->
                                                <button
                                                    @click="viewModal = true; $nextTick(() => loadPasienDetail({{ $p->id }}))"
                                                    class="bg-blue-500 hover:bg-blue-600
                                                           dark:bg-blue-600 dark:hover:bg-blue-500
                                                           text-white p-2 rounded-lg text-xs
                                                           transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Edit -->
                                                <a href="{{ route('admin.master-pasien.edit', $p->id) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600
                                                          dark:bg-yellow-600 dark:hover:bg-yellow-500
                                                          text-white p-2 rounded-lg text-xs
                                                          transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('admin.master-pasien.destroy', $p->id) }}"
                                                      method="POST" class="form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600
                                                                   dark:bg-red-600 dark:hover:bg-red-500
                                                                   text-white p-2 px-2.5 rounded-lg text-xs
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

                    <!-- View Modal -->
                    <div x-show="viewModal"
                         x-transition
                         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
                         style="display: none;">

                        <div @click.away="viewModal = false"
                             class="bg-white dark:bg-gray-900
                                    text-gray-800 dark:text-gray-200
                                    rounded-2xl shadow-2xl
                                    w-full max-w-3xl max-h-[90vh]
                                    overflow-hidden flex flex-col">

                            <!-- Header -->
                            <div class="p-6 border-b-2 border-blue-500 bg-gradient-to-r
                                        from-blue-50 to-blue-100
                                        dark:from-gray-800 dark:to-gray-900">

                                <h2 class="text-2xl font-bold flex items-center gap-2">
                                    <i class="fa-solid fa-user-doctor text-blue-500"></i>
                                    Detail Pasien
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Informasi lengkap data Pasien
                                </p>
                            </div>

                            <!-- Content -->
                            <div class="overflow-y-auto p-6 space-y-5">

                                <!-- Identitas -->
                                <div class="bg-blue-50 dark:bg-gray-800 p-5 rounded-xl border-l-4 border-blue-500">
                                    <h3 class="text-lg font-bold mb-4">Identitas Pribadi</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Nama</p>
                                            <p class="font-semibold" id="nama"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Jenis Kelamin</p>
                                            <p class="font-semibold" id="jenis_kelamin"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Tempat Lahir</p>
                                            <p class="font-semibold" id="tempat_lahir"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Tanggal Lahir</p>
                                            <p class="font-semibold" id="tgl_lahir"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kontak -->
                                <div class="bg-green-50 dark:bg-gray-800 p-5 rounded-xl border-l-4 border-green-500">
                                    <h3 class="text-lg font-bold mb-4">Informasi Kontak</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="font-semibold" id="email"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">No.Telp</p>
                                            <p class="font-semibold" id="no_telp"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Asuransi -->
                                <div class="bg-purple-50 dark:bg-gray-800 p-5 rounded-xl border-l-4 border-purple-500">
                                    <h3 class="text-lg font-bold mb-4">Asuransi</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">No BPJS</p>
                                            <p class="font-semibold" id="no_bpjs"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Jenis Pasien</p>
                                            <p class="font-semibold" id="jenis_pasien"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="bg-red-50 dark:bg-gray-800 p-5 rounded-xl border-l-4 border-red-500">
                                    <h3 class="text-lg font-bold mb-4">Alamat</h3>
                                    <p class="font-semibold" id="alamat"></p>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex justify-end gap-3">
                                <button @click="viewModal = false"
                                        class="px-6 py-2 bg-gray-300 dark:bg-gray-700 rounded-lg">
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
