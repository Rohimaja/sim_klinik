<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data > Poli') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-100">

                <!-- Search dan Tambah Poli -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div class="w-full sm:w-1/2 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="tableSearch" placeholder="Cari poli..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>

                    <div class="w-full sm:w-auto">
                        <a href="{{ route('admin.master-poli.create') }}"
                            class="w-full sm:w-auto bg-[#7134FC] text-white px-4 py-2 text-sm rounded-lg font-medium flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-solid fa-plus"></i> Tambah Poli
                        </a>
                    </div>
                </div>

                <!-- Tabel Poli -->
                <div class="overflow-x-auto">
                    <table id="dataTable"
                        class="min-w-full border border-gray-200 text-xs sm:text-sm rounded-lg overflow-hidden">
                        <thead class="bg-[#7134FC] text-white text-left">
                            <tr>
                                <th class="px-3 sm:px-4 py-3">No</th>
                                <th class="px-3 sm:px-4 py-3">Nama Poli</th>
                                <th class="px-3 sm:px-4 py-3">Keterangan</th>
                                <th class="px-3 sm:px-4 py-3">Status Poli</th>
                                <th class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($poli as $i => $p)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p['nama'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">{{ $p['keterangan'] }}</td>
                                    <td class="px-3 sm:px-4 py-2">
                                        @if ($p->status === 1)
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

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.master-poli.edit', $p->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105 inline-block">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.master-poli.destroy', $p->id) }}"
                                                method="POST" class="form-hapus inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 px-2.5 rounded-lg text-xs transition-all duration-300 hover:shadow-lg hover:scale-105">
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
