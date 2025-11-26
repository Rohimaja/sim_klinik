<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Master Data > Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl 
                        p-4 sm:p-6 border border-gray-100 dark:border-gray-700">

                <!-- Search dan Tambah Jadwal -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    
                    <!-- Search -->
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        <input type="text" id="tableSearch" placeholder="Cari jadwal dokter..."
                            class="w-full border border-gray-300 dark:border-slate-600
                                   bg-white dark:bg-slate-700
                                   text-gray-600 dark:text-white
                                   rounded-lg pl-10 pr-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>

                    <!-- Button Tambah -->
                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-jadwal.create') }}"
                            class="w-full sm:w-auto
                                  bg-[#7134FC] hover:bg-indigo-600
                                  dark:bg-indigo-500 dark:hover:bg-indigo-400
                                  text-white
                                  px-4 py-2 text-sm rounded-lg font-medium
                                  flex items-center justify-center gap-2
                                  shadow-md transition">
                            <i class="fa-solid fa-plus"></i> Tambah Jadwal Dokter
                        </a>
                    </div>

                </div>

                <!-- Tabel Jadwal -->
                <div class="overflow-x-auto">
                    <table id="dataTable"
                        class="min-w-full border border-gray-200 dark:border-gray-700
                               text-xs sm:text-sm rounded-lg overflow-hidden">

                        <thead class="bg-[#7134FC] dark:bg-indigo-600 text-white text-left">
                            <tr>
                                <th class="px-3 sm:px-4 py-3">No</th>
                                <th class="px-3 sm:px-4 py-3">Nama Dokter</th>
                                <th class="px-3 sm:px-4 py-3">Poli</th>
                                <th class="px-3 sm:px-4 py-3">Jam Mulai</th>
                                <th class="px-3 sm:px-4 py-3">Jam Selesai</th>
                                <th class="px-3 sm:px-4 py-3">Hari</th>
                                <th class="px-3 sm:px-4 py-3">Keterangan</th>
                                <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700 dark:text-gray-300">
                            @foreach ($jadwal as $i => $j)
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700
                                           hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    
                                    <td class="px-3 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->dokter->nama ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->poli->nama ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->jam_mulai ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->jam_akhir ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->hari ?? '' }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $j->keterangan ?? '' }}</td>

                                    <td class="px-3 sm:px-4 py-2 text-center">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.master-jadwal.edit', $j->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600
                                                       text-white p-2 rounded-lg text-xs
                                                       transition-all duration-300
                                                       hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.master-jadwal.destroy', $j->id) }}"
                                                method="POST" class="form-hapus inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600
                                                           text-white p-2 px-2.5 rounded-lg text-xs
                                                           transition-all duration-300
                                                           hover:shadow-lg hover:scale-105">
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

            </div>

        </div>
    </div>
</x-app-layout>
