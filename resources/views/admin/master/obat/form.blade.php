<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Form Tambah Obat') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-pills text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Tambah Data Obat Baru</h3>
                            <p class="text-blue-100 text-sm">Lengkapi semua informasi obat dengan benar</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form
                    action="{{ isset($obat) ? route('admin.master-obat.update', $obat->id) : route('admin.master-obat.store') }}"
                    method="POST" class="p-6 space-y-6">
                    @csrf
                    @if (isset($obat))
                        @method('PUT')
                    @endif

                    <!-- Informasi Obat -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-capsules text-purple-500"></i>
                            Informasi Obat
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Obat -->
                            <div>
                                <label for="nama"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Obat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama"
                                    value="{{ old('nama', $obat->nama ?? '') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Paracetamol 500mg">
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('nama')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label for="jenis_obat"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Obat <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_obat" id="jenis_obat" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="" hidden-selected>Pilih Jenis Obat</option>
                                    <option value="Tablet"
                                        {{ old('jenis_obat', $obat->jenis_obat ?? '') == 'Tablet' ? 'selected' : '' }}>
                                        Tablet</option>
                                    <option value="Kapsul"
                                        {{ old('jenis_obat', $obat->jenis_obat ?? '') == 'Kapsul' ? 'selected' : '' }}>
                                        Kapsul</option>
                                    <option value="Botol"
                                        {{ old('jenis_obat', $obat->jenis_obat ?? '') == 'Botol' ? 'selected' : '' }}>
                                        Botol</option>
                                    <option value="Sirup"
                                        {{ old('jenis_obat', $obat->jenis_obat ?? '') == 'Sirup' ? 'selected' : '' }}>
                                        Sirup</option>
                                    <option value="Salep"
                                        {{ old('jenis_obat', $obat->jenis_obat ?? '') == 'Salep' ? 'selected' : '' }}>
                                        Salep</option>
                                </select>
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('jenis_obat')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stok"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stok" id="stok"
                                    value="{{ old('stok', $obat->stok ?? '') }}" min="0" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: 100">
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('stok')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Harga -->
                            <div>
                                <label for="harga"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Harga per Satuan (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="harga" id="harga"
                                    value="{{ old('harga', $obat->harga ?? '') }}" min="0" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: 2000">
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('harga')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label for="keterangan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keterangan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Melayani pemeriksaan umum dan keluhan ringan">{{ $obat->keterangan ?? '' }}</textarea>
                                <span class="text-red-600 text-sm" id="keterangan_error">
                                    @error('keterangan')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Obat -->
                    <div class="border-l-4 border-teal-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-teal-500"></i>
                            Status Obat
                        </h4>

                        <div class="bg-teal-50 p-4 rounded-lg">
                            <label for="status" class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" name="status" id="status" value="1"
                                    {{ old('status', $obat->status ?? 0) == 1 ? 'checked' : '' }}
                                    class="w-5 h-5 text-teal-500 rounded focus:ring-teal-500">
                                <span class="text-gray-700 font-semibold">
                                    Tandai sebagai "Tersedia" (Obat dapat diresepkan)
                                </span>
                            </label>
                            <span class="text-red-600 text-sm" id="nama_error">
                                @error('status')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 gap-3 sm:gap-0">

                        <!-- Tombol Kembali -->
                        <a href="{{ route('admin.master-obat.index') }}"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300 font-medium text-center">
                            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                        </a>

                        <!-- Tombol Reset & Simpan -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <button type="reset"
                                class="w-full sm:w-auto px-6 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg">
                                <i class="fa-solid fa-save mr-2"></i>Simpan Data
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
