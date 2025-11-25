<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data > Form Tambah Jadwal') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

                <!-- Header Form -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <i class="fa-solid fa-calendar-days text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Tambah Jadwal Tenaga Klinik Baru</h3>
                            <p class="text-blue-100 text-sm">Lengkapi semua informasi jadwal dengan benar</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form
                    action="{{ isset($jadwal) ? route('admin.master-jadwal.update', $jadwal->id) : route('admin.master-jadwal.store') }}"
                    method="POST" class="p-6 space-y-6">
                    @csrf
                    @if (isset($jadwal))
                        @method('PUT')
                    @endif

                    <!-- Informasi Tenaga Klinik -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user-doctor text-purple-500"></i>
                            Informasi Tenaga Klinik
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Tenaga -->
                            <div>
                                <label id="dokter_id"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Dokter <span class="text-red-500">*</span>
                                </label>
                                <select name="dokter_id" id="dokter_id" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="" hidden selected>Pilih Dokter</option>
                                    @foreach ($dokter as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('dokter_id', $jadwal->dokter_id ?? '') == $d->id ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-red-600 text-sm" id="dokter_id_error">
                                    @error('dokter_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Hari <span class="text-red-500">*</span>
                                </label>
                                <select name="hari" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="" hidden selected>Pilih Hari</option>
                                    <option value="Senin"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Senin' ? 'selected' : '' }}>Senin
                                    </option>
                                    <option value="Selasa"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Selasa' ? 'selected' : '' }}>Selasa
                                    </option>
                                    <option value="Rabu"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Kamis' ? 'selected' : '' }}>Kamis
                                    </option>
                                    <option value="Jumat"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Jumat' ? 'selected' : '' }}>Jumat
                                    </option>
                                    <option value="Sabtu"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Sabtu' ? 'selected' : '' }}>Sabtu
                                    </option>
                                    <option value="Minggu"
                                        {{ old('hari', $jadwal->hari ?? '') == 'Minggu' ? 'selected' : '' }}>Minggu
                                    </option>
                                </select>
                                <span class="text-red-600 text-sm" id="hari_error">
                                    @error('hari')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Poli/Area Kerja -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Poli / Area Kerja <span class="text-red-500">*</span>
                                </label>
                                <select name="poli_id" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option value="" hidden selected>Pilih Poli</option>
                                    @foreach ($poli as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('poli_id', $jadwal->poli_id ?? '') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-red-600 text-sm" id="poli_id_error">
                                    @error('poli_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Waktu -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clock text-blue-500"></i>
                            Informasi Waktu
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Jam Mulai -->
                            <div>
                                <label id="jam_mulai"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_mulai" name="jam_mulai"
                                    value="{{ old('jam_mulai', $jadwal->jam_mulai ?? '') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <span class="text-red-600 text-sm" id="jam_mulai_error">
                                    @error('jam_mulai')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label id="jam_akhir"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_akhir" id="jam_akhir"
                                    value="{{ old('jam_akhir', $jadwal->jam_akhir ?? '') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <span class="text-red-600 text-sm" id="jam_akhir_error">
                                    @error('jam_akhir')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label id="keterangan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: Jadwal khusus untuk pasien BPJS atau catatan tambahan lainnya">{{ old('keterangan', $jadwal->keterangan ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="keterangan_error">
                                    @error('keterangan')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-gray-200 gap-3 sm:gap-0">

                        <!-- Tombol Kembali -->
                        <a href="{{ route('admin.master-jadwal.index') }}"
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

    @vite(['resources/js/masterData/jadwal/form_jadwal.js'])
</x-app-layout>
