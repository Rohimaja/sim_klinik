<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Perawat') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Search dan Tambah Perawat -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="tableSearch" placeholder="Cari nama perawat, Unit, atau NIRA..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>


                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-perawat.create') }}"
                            class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah Perawat
                        </a>
                    </div>
                </div>

                <!-- Tabel Perawat -->
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
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
                        <tbody class="text-gray-700">
                            {{-- @php
                                $perawat = [
                                    ['nama'=>'Suster Rina Lestari','nira'=>'NIRA-00123','unit'=>'IGD','telp'=>'081234567001','status'=>'aktif'],
                                    ['nama'=>'Suster Dewi Anggraini','nira'=>'NIRA-00456','unit'=>'Rawat Inap', 'telp'=>'082233445566','status'=>'aktif'],
                                    ['nama'=>'Suster Ahmad Fauzi','nira'=>'NIRA-00789','unit'=>'Poli Umum', 'telp'=>'081345678912','status'=>'non-aktif'],
                                    ['nama'=>'Suster Wulandari','nira'=>'NIRA-00234','unit'=>'Poli Anak', 'telp'=>'083899977766','status'=>'aktif'],
                                    ['nama'=>'Suster Bayu Pratama','nira'=>'NIRA-00567','unit'=>'Poli Bedah', 'telp'=>'082111223344','status'=>'aktif'],
                                    ['nama'=>'Suster Laila Amira','nira'=>'NIRA-00999','unit'=>'ICU', 'telp'=>'081299887766','status'=>'aktif'],
                                ];
                            @endphp --}}

                            @foreach ($perawat as $i => $p)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 sm:px-4 py-2 flex items-center gap-3">
                                        <img src="{{ asset('storage/dokter/' . ($p['foto'] ?? 'default.jpg')) }}"
                                            class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow-sm">
                                        <span class="font-medium">{{ $p['nama'] }}</span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 text-gray-600">{{ $p['nira'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p['unit'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p['telp'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        @if ($p['status'] === 'aktif')
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
                                            <!-- View Button -->
                                            <button @click="viewModal = true"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.master-perawat.edit', $p->id) }}"
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
                                                            Detail Perawat
                                                        </h2>
                                                        <p class="text-sm text-gray-600 mt-1">Informasi lengkap data Perawat</p>
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
                                                                <p class="text-base font-semibold text-gray-800">Suster Rina Lestari</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Jenis Kelamin</p>
                                                                <p class="text-base font-semibold text-gray-800">
                                                                    {{-- <i class="fa-solid fa-mars text-blue-500 mr-1"></i>Laki-laki --}}
                                                                    <i class="fa-solid fa-venus text-pink-500 mr-1"></i>Perempuan
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
                                                                <p class="text-base font-semibold text-gray-800">SusterRinas@hospital.com</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">
                                                                    <i class="fa-solid fa-phone mr-1"></i>No. Telepon
                                                                </p>
                                                                <p class="text-base font-semibold text-gray-800">+62 812-3456-7890</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Profesional -->
                                                    <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-5 rounded-xl border-l-4 border-purple-500">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                            <i class="fa-solid fa-stethoscope text-purple-500"></i>
                                                            Informasi Profesional
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">No. STR</p>
                                                                <p class="text-base font-semibold text-gray-800">STR-123456789-2024</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">No. SIPP</p>
                                                                <p class="text-base font-semibold text-gray-800">SIP-987654321-2024</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">No. NIRA</p>
                                                                <p class="text-base font-semibold text-gray-800">NIRA-00123</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Unit / Poli Bertugas</p>
                                                                <p class="text-base font-semibold text-gray-800">Poli Penyakit Dalam</p>
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

                                                    <!-- Status -->
                                                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-5 rounded-xl border-l-4 border-teal-500">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                            <i class="fa-solid fa-circle-info text-teal-500"></i>
                                                            Status Aktif
                                                        </h3>

                                                        {{-- aktif --}}
                                                        {{-- <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Status Dokter</p>
                                                                <p class="text-base font-semibold text-gray-800">Sedang Aktif Bertugas</p>
                                                            </div>
                                                            <span class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-sm font-bold rounded-full shadow-lg flex items-center gap-2">
                                                                <i class="fa-solid fa-circle-check"></i>
                                                                Aktif
                                                            </span>
                                                        </div> --}}

                                                        {{-- tidak aktif --}}
                                                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                                                            <div>
                                                                <p class="text-xs text-gray-500 mb-1 font-medium">Status Perawat</p>
                                                                <p class="text-base font-semibold text-gray-800">Sedang Tidak Aktif Bertugas</p>
                                                            </div>
                                                            <span class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-full shadow-lg flex items-center gap-2">
                                                                <i class="fa-solid fa-times"></i>
                                                                Non-Aktif
                                                            </span>
                                                        </div>
                                                        <div class="mt-3 bg-blue-50 p-3 rounded-lg border border-blue-200">
                                                            <p class="text-xs text-blue-700">
                                                                <i class="fa-solid fa-info-circle mr-1"></i>
                                                                <strong>Terakhir diupdate:</strong> 28 Oktober 2025, 14:30 WIB
                                                            </p>
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
                                                    Apakah Anda yakin ingin menghapus perawat<br>
                                                    <strong class="text-gray-800 text-lg">Suster Rina Lestari</strong>?
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
