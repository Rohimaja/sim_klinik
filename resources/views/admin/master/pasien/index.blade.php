<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Pasien') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Search dan Tambah Pasien -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="tableSearch" placeholder="Cari nama pasien, alamat, atau No.Telp..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>


                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-pasien.create') }}"
                            class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah Pasien
                        </a>
                    </div>
                </div>

                <!-- Tabel Pasien -->
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
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
                        <tbody class="text-gray-700">
                            @foreach ($pasien as $i => $p)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->user->nama ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2 text-gray-600">    {{ \Carbon\Carbon::parse($p->tgl_lahir)->age ?? '-' }} tahun</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->alamat ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p->no_telp ?? '' }}</td>

                                    <td class="px-3 sm:px-4 py-2 text-center" x-data="{ viewModal: false, deleteModal: false }">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            <!-- View Button -->
                                            <button @click="viewModal = true"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.master-pasien.edit', $p->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <button @click="deleteModal = true"
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- View Modal -->
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
                                                class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col">

                                                <!-- Header Fixed -->
                                                <div class="flex items-center justify-between p-6 pb-4 border-b-2 border-blue-500 bg-gradient-to-r from-blue-50 to-blue-100">
                                                    <div>
                                                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                                            <i class="fa-solid fa-user-doctor text-blue-500"></i>
                                                            Detail Pasien
                                                        </h2>
                                                        <p class="text-sm text-gray-600 mt-1">Informasi lengkap data Pasien</p>
                                                    </div>
                                                    <button @click="viewModal = false"
                                                            class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                                                        <i class="fa-solid fa-times text-2xl"></i>
                                                    </button>
                                                </div>

                                                <!-- Content Scrollable -->
                                                <div class="overflow-y-auto p-6 space-y-5">

                                                    <!-- Identitas Pribadi -->
                                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-xl border-l-4 border-blue-500">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                            <i class="fa-solid fa-id-card text-blue-500"></i>
                                                            Identitas Pribadi
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Nama Lengkap</p>
                                                                <p class="text-base font-semibold text-gray-800">Dr. Ahmad Fauzi, Sp.PD</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Jenis Kelamin</p>
                                                                <p class="text-base font-semibold text-gray-800">
                                                                    <i class="fa-solid fa-mars text-blue-500 mr-1"></i>Laki-laki
                                                                    {{-- <i class="fa-solid fa-venus text-pink-500 mr-1"></i>Perempuan --}}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Tempat Lahir</p>
                                                                <p class="text-base font-semibold text-gray-800">Surabaya</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Tanggal Lahir</p>
                                                                <p class="text-base font-semibold text-gray-800">15 Maret 1985 (39 tahun)</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Kontak -->
                                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-l-4 border-green-500">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                            <i class="fa-solid fa-address-book text-green-500"></i>
                                                            Informasi Kontak
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">
                                                                    <i class="fa-solid fa-envelope mr-1"></i>Email
                                                                </p>
                                                                <p class="text-base font-semibold text-gray-800">ahmad.fauzi@hospital.com</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">
                                                                    <i class="fa-solid fa-phone mr-1"></i>No. Telepon
                                                                </p>
                                                                <p class="text-base font-semibold text-gray-800">+62 812-3456-7890</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Alamat -->
                                                    <div class="bg-gradient-to-br from-red-50 to-pink-50 p-5 rounded-xl border-l-4 border-red-500">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                            <i class="fa-solid fa-location-dot text-red-500"></i>
                                                            Alamat Lengkap
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Provinsi</p>
                                                                <p class="text-base font-semibold text-gray-800">Jawa Timur</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Kota/Kabupaten</p>
                                                                <p class="text-base font-semibold text-gray-800">Kota Surabaya</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Kecamatan</p>
                                                                <p class="text-base font-semibold text-gray-800">Gubeng</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Kelurahan</p>
                                                                <p class="text-base font-semibold text-gray-800">Airlangga</p>
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Alamat Detail</p>
                                                                <p class="text-base font-semibold text-gray-800">Jl. Airlangga No. 45, RT 003 RW 005, Kode Pos 60286</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Footer Fixed -->
                                                <div class="p-6 pt-4 border-t bg-gray-50 flex justify-end gap-3">
                                                    <button @click="viewModal = false"
                                                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 font-medium">
                                                        <i class="fa-solid fa-times mr-2"></i>Tutup
                                                    </button>
                                                    <a href="#"
                                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg font-medium">
                                                        <i class="fa-solid fa-print mr-2"></i>Cetak Detail
                                                    </a>
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
