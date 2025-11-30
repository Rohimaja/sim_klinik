<x-app-layout>
    @vite(['resources/js/pages/petugas/kunjungan.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemeriksaan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

                <!-- Header -->
                <div class="bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <i class="fa-solid fa-hospital-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Tambah Pasien Baru</h3>
                            <p class="text-blue-100 text-sm">Isi data identitas pasien dengan lengkap</p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger text-red-600 dark:text-red-400">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" class="p-6 space-y-6"
                    action="{{ isset($pemeriksaan) ? route('dokter.kunjungan.update', $pemeriksaan->id) : route('dokter.kunjungan.store') }}"
                    method="POST" class="p-6 space-y-6">
                    @csrf
                    @if (isset($pemeriksaan))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="antrian_poli_id" value="{{ $antrian->id }}">

                    <!-- Identitas Pasien -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-blue-500"></i>
                            Identitas Pasien
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- <input type="hidden" id="is_edit" value="{{ isset($kunjungan) ? '1' : '0' }}">
                            <input type="hidden" id="edit_dokter_id" value="{{ $kunjungan->dokter_id ?? '' }}">
                            <input type="hidden" id="edit_jam_awal" value="{{ $kunjungan->jam_awal ?? '' }}">
                            <input type="hidden" id="edit_jam_akhir" value="{{ $kunjungan->jam_akhir ?? '' }}"> --}}
                            {{-- <input type="hidden" id="edit_dokter_id" value="{{ $kunjungan->dokter_id ?? '' }}"> --}}

                            <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">



                            <!-- Nama Pasien -->
                            <div>
                                <label for="nik"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    NIK <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" name="nik" id="nik" readonly
                                        value="{{ old('nik', $pasien->nik ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Contoh: Fauzan Riziq">
                                </div>
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('nik')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Nama Pasien -->


                            <div>
                                <label for="nama"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" name="nama" id="nama" readonly
                                        value="{{ old('nama', $pasien->nama ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Contoh: Fauzan Riziq">
                                </div>
                                <span class="text-red-600 text-sm" id="nama_error">
                                    @error('nama')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label for="tempat_lahir"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" readonly
                                    value="{{ old('tempat_lahir', $pasien->tempat_lahir ?? '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: Surabaya">
                                <span class="text-red-600 text-sm" id="tempat_lahir_error">
                                    @error('tempat_lahir')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="L"
                                            readonly checked
                                            {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-500 focus:ring-blue-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="fa-solid fa-mars text-blue-500"></i> Laki-laki
                                        </span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="P"
                                            readonly
                                            {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}
                                            class="w-4 h-4 text-pink-500 focus:ring-pink-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tgl_lahir"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" readonly
                                        value="{{ old('tgl_lahir', $pasien->tgl_lahir ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                </div>
                                <span class="text-red-600 text-sm" id="tgl_lahir_error">
                                    @error('tgl_lahir')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- No. Telepon -->
                            <div>
                                <label for="no_telp"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input type="tel" name="no_telp" id="no_telp" readonly
                                        value="{{ old('no_telp', $pasien->no_telp ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        placeholder="+62 812-3456-7890">
                                </div>
                                <span class="text-red-600 text-sm" id="no_telp_error">
                                    @error('no_telp')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email" readonly
                                        value="{{ old('email', $pasien->user->email ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        placeholder="contoh@hospital.com">
                                </div>
                                <span class="text-red-600 text-sm" id="email_error">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Section 2: Informasi Asuransi -->
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-address-book text-green-500"></i>
                            Informasi Asuransi
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label for="jenis_pasien"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Pasien <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input type="text" id="jenis_pasien" name="jenis_pasien" readonly
                                        value="{{ old('jenis_pasien', $pasien->jenis_pasien ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        placeholder="contoh@hospital.com">
                                </div>
                                <span class="text-red-600 text-sm" id="jenis_pasien_error">
                                    @error('jenis_pasien')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- No. Telepon -->
                            <div>
                                <label for="no_bpjs"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    No. BPJS <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="no_bpjs" id="no_bpjs" readonly
                                        value="{{ old('no_bpjs', $pasien->no_bpjs ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        placeholder="0001234567890">
                                </div>
                                <span class="text-red-600 text-sm" id="bo_bpjs_error">
                                    @error('no_bpjs')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>


                    <!-- Section 4: Alamat Lengkap -->
                    <div class="border-l-4 border-red-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-red-500"></i>
                            Alamat Lengkap
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Alamat Detail -->
                            <div class="md:col-span-2">
                                <label for="alamat"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Alamat Detail (Jalan, RT/RW, Kode Pos) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" readonly rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: Jl. Airlangga No. 45, RT 003 RW 005, Kode Pos 60286">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="alamat_error">
                                    @error('alamat')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-heartbeat text-blue-500"></i>
                            Tanda Vital
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Tekanan Darah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tekanan Darah <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="sistol" id="sistol" placeholder="Sistol"
                                        readonly value="{{ old('sistol', $skrining->tensi ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                    <span
                                        class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">mmHg</span>
                                </div>
                            </div>

                            <!-- Suhu -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Suhu Tubuh <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="suhu" id="suhu" step="0.1"
                                        value="{{ old('suhu', $skrining->suhu ?? '') }}" placeholder="36.5" readonly
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">°C</span>
                                </div>
                            </div>

                            <!-- Berat Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Berat Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="berat_badan" id="berat_badan" step="0.1"
                                        readonly value="{{ old('berat_badan', $skrining->berat_badan ?? '') }}"
                                        placeholder="70"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">kg</span>
                                </div>
                            </div>

                            <!-- Tinggi Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tinggi Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="tinggi_badan" id="tinggi_badan" readonly
                                        value="{{ old('tinggi_badan', $skrining->tinggi_badan ?? '') }}"
                                        placeholder="170"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">cm</span>
                                </div>
                            </div>

                            <!-- Keluhan -->
                            <div class="md:col-span-1">
                                <label id="keluhan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keluhan Pasien <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keluhan_utama" id="keluhan" rows="2" readonly
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan">{{ old('keluhan', $skrining->keluhan_utama ?? '') }}</textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Kunjungan Pasien -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-stethoscope text-purple-500"></i>
                            Data Kunjungan Pasien
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label for="tgl_periksa"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal dan Waktu Pemeriksaan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="datetime-local" name="tgl_periksa" id="tgl_periksa"
                                        value="{{ old('tgl_periksa', $pemeriksaan->tgl_periksa ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                </div>
                                <span class="text-red-600 text-sm" id="bo_bpjs_error">
                                    @error('no_bpjs')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Diagnosa -->
                            <div>
                                <label for="diagnosa"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Diagnosa Pasien <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="diagnosa" id="diagnosa" required
                                        value="{{ old('diagnosa', $pemeriksaan->diagnosa ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        placeholder="0001234567890">
                                </div>
                                <span class="text-red-600 text-sm" id="diagnosa_error">
                                    @error('diagnosa')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Tindakan -->
                            <div class="md:col-span-1">
                                <label id="tindakan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tindakan Untuk Pasien <span class="text-red-500">*</span>
                                </label>
                                <textarea name="tindakan" id="tindakan" rows="2"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500"
                                    placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan">{{ old('tindakan', $pemeriksaan->tindakan ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="tindakan_error">
                                    @error('tindakan')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <!-- Catatan -->
                            <div class="md:col-span-1">
                                <label id="catatan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Catatan Pasien <span class="text-red-500">*</span>
                                </label>
                                <textarea name="catatan" id="catatan" rows="2"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500"
                                    placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan">{{ old('catatan', $pemeriksaan->catatan ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="catatan_error">
                                    @error('catatan ')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-between border-t pt-6 gap-3">

                        <a href="{{ route('dokter.kunjungan.index') }}"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-center font-medium">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </a>

                        <div class="flex gap-3">
                            <button type="reset"
                                class="px-6 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-md">
                                <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                            </button>

                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
