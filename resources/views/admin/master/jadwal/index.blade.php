<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Jadwal Tenaga Klinik') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Filter dan Search -->
                <div class="mb-4 space-y-3">
                    <!-- Baris 1: Filter Role, Poli, dan Tanggal -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Filter Role -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Role</label>
                            <select id="filterRole"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                                <option value="">Semua Role</option>
                                <option value="Dokter">Dokter</option>
                                <option value="Perawat">Perawat</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>

                        <!-- Filter Poli -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Poli/Area</label>
                            <select id="filterPoli"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                                <option value="">Semua Poli/Area</option>
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                                <option value="Poli KIA">Poli KIA</option>
                                <option value="Pendaftaran">Pendaftaran</option>
                                <option value="Rekam Medis">Rekam Medis</option>
                                <option value="Farmasi">Farmasi</option>
                            </select>
                        </div>

                        <!-- Filter Hari -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Hari</label>
                            <select id="filterHari"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                                <option value="">Semua Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Baris 2: Search dan Tombol Tambah -->
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                        <div class="w-full sm:w-1/2 relative">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Nama Tenaga</label>
                            <i class="fas fa-search absolute left-3 bottom-3 text-gray-400"></i>
                            <input type="text" id="tableSearch" placeholder="Cari nama tenaga klinik..."
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        </div>

                        <div class="w-full sm:w-auto">
                            <a href="{{ route('admin.master-jadwal.create') }}"
                                class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md hover:bg-[#5a28d4] transition-all">
                                <i class="fa-solid fa-plus"></i> Tambah Jadwal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="overflow-x-auto">
                    <table id="dataTable"
                        class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
                            <tr>
                                <th class="px-3 sm:px-4 py-3">No</th>
                                <th class="px-3 sm:px-4 py-3">Nama Tenaga</th>
                                <th class="px-3 sm:px-4 py-3">Role</th>
                                <th class="px-3 sm:px-4 py-3">Poli/Area</th>
                                <th class="px-3 sm:px-4 py-3">Jam Mulai</th>
                                <th class="px-3 sm:px-4 py-3">Jam Selesai</th>
                                <th class="px-3 sm:px-4 py-3">Hari</th>
                                <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            {{-- @php
                                $jadwal = [
                                    ['nama' => 'dr. Aditya Pratama', 'role' => 'Dokter', 'poli' => 'Poli Umum', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'hari' => 'Senin'],
                                    ['nama' => 'dr. Aditya Pratama', 'role' => 'Dokter', 'poli' => 'Poli Umum', 'jam_mulai' => '13:00', 'jam_selesai' => '16:00', 'hari' => 'Selasa'],
                                    ['nama' => 'dr. Siti Nurhaliza', 'role' => 'Dokter', 'poli' => 'Poli Gigi', 'jam_mulai' => '08:00', 'jam_selesai' => '14:00', 'hari' => 'Rabu'],
                                    ['nama' => 'dr. Budi Santoso', 'role' => 'Dokter', 'poli' => 'Poli Anak', 'jam_mulai' => '09:00', 'jam_selesai' => '15:00', 'hari' => 'Kamis'],
                                    ['nama' => 'Rani Wijaya', 'role' => 'Perawat', 'poli' => 'Poli Gigi', 'jam_mulai' => '08:00', 'jam_selesai' => '14:00', 'hari' => 'Senin'],
                                    ['nama' => 'Dewi Kusuma', 'role' => 'Perawat', 'poli' => 'Poli Umum', 'jam_mulai' => '07:00', 'jam_selesai' => '15:00', 'hari' => 'Selasa'],
                                    ['nama' => 'Ahmad Fauzi', 'role' => 'Perawat', 'poli' => 'Poli Anak', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00', 'hari' => 'Rabu'],
                                    ['nama' => 'Sinta Marlina', 'role' => 'Petugas', 'poli' => 'Rekam Medis', 'jam_mulai' => '07:30', 'jam_selesai' => '15:30', 'hari' => 'Senin'],
                                    ['nama' => 'Rudi Hermawan', 'role' => 'Petugas', 'poli' => 'Pendaftaran', 'jam_mulai' => '07:00', 'jam_selesai' => '14:00', 'hari' => 'Selasa'],
                                    ['nama' => 'Lisa Permata', 'role' => 'Petugas', 'poli' => 'Farmasi', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00', 'hari' => 'Kamis'],
                                ];
                            @endphp --}}

                            @foreach ($jadwal as $i => $j)
                                <tr class="border-b hover:bg-gray-50 transition"
                                    data-nama="{{ strtolower($j['nama']) }}" data-role="{{ $j['role'] }}"
                                    data-poli="{{ $j['poli'] }}" data-hari="{{ $j['hari'] }}">
                                    <td class="px-3 sm:px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 sm:px-4 py-2 font-medium">{{ $j['nama'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $j['role'] == 'Dokter' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $j['role'] == 'Perawat' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $j['role'] == 'Petugas' ? 'bg-purple-100 text-purple-700' : '' }}">
                                            {{ $j['role'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j['poli'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j['jam_mulai'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j['jam_selesai'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $j['hari'] }}</span>
                                    </td>

                                    <td class="px-3 sm:px-4 py-2 text-center" x-data="{ deleteModal: false }">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.master-jadwal.edit', $j->id) }}"
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
                                        <div x-show="deleteModal" x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
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
                                                        <i
                                                            class="fa-solid fa-triangle-exclamation text-red-500 text-4xl"></i>
                                                    </div>
                                                </div>

                                                <!-- Header -->
                                                <h2 class="text-2xl font-bold mb-3 text-red-600 text-center">Konfirmasi
                                                    Hapus</h2>

                                                <!-- Content -->
                                                <p class="text-gray-600 text-center mb-6">
                                                    Apakah Anda yakin ingin menghapus jadwal ini?<br>
                                                    <strong class="text-gray-800">{{ $j['nama'] }} -
                                                        {{ $j['hari'] }}</strong>
                                                </p>
                                                <p
                                                    class="text-sm text-gray-500 text-center mb-6 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
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

    @vite(['resources/js/masterData/jadwal/jadwal.js'])

</x-app-layout>
