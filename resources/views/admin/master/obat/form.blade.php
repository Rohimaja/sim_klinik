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
                <form action="#" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Informasi Obat -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-capsules text-purple-500"></i>
                            Informasi Obat
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Obat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Obat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_obat" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Paracetamol 500mg">
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Analgesik / Antipiretik">Analgesik / Antipiretik</option>
                                    <option value="Antibiotik">Antibiotik</option>
                                    <option value="Antihistamin">Antihistamin</option>
                                    <option value="Anti-Inflamasi">Anti-Inflamasi</option>
                                    <option value="Antasida / PPI">Antasida / PPI</option>
                                    <option value="Antidiabetes">Antidiabetes</option>
                                    <option value="Antihipertensi">Antihipertensi</option>
                                    <option value="Bronkodilator">Bronkodilator</option>
                                    <option value="Penurun Kolesterol">Penurun Kolesterol</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <select name="satuan" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Satuan</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Sirup">Sirup</option>
                                    <option value="Salep">Salep</option>
                                    <option value="Ampul">Ampul</option>
                                </select>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stok" min="0" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Contoh: 100">
                            </div>

                            <!-- Harga -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Harga per Satuan (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="harga" min="0" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Contoh: 2000">
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
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="status" value="tersedia" checked
                                      class="w-5 h-5 text-teal-500 rounded focus:ring-teal-500">
                                <span class="text-gray-700 font-semibold">
                                    <i class="fa-solid fa-check-circle text-teal-500 mr-1"></i>
                                    Tandai sebagai "Tersedia" (Obat dapat diresepkan)
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 gap-3 sm:gap-0">

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
