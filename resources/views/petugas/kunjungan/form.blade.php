<x-app-layout>
    @vite(['resources/js/pages/petugas/kunjungan.js'])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kunjungan Pasien') }}
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
                    action="{{ $mode == 'edit' ? route('petugas.kunjungan.update', $kunjungan->id) : route('petugas.kunjungan.store') }}"
                    method="POST" class="p-6 space-y-6">

                    @csrf
                    @if ($mode == 'edit')
                        @method('PUT')
                        <input type="hidden" id="edit_id" value="{{ $kunjungan->id }}">
                    @endif

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
                                    <input type="text" name="nik" id="nik"
                                        value="{{ old('nik', $pasien->nik ?? '') }}" required
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
                                    <input type="text" name="nama" id="nama"
                                        value="{{ old('nama', $pasien->nama ?? '') }}" required
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
                                <input type="text" id="tempat_lahir" name="tempat_lahir" required
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
                                            required checked
                                            {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-500 focus:ring-blue-500">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            <i class="fa-solid fa-mars text-blue-500"></i> Laki-laki
                                        </span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="P"
                                            required
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
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" required
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
                                    <input type="tel" name="no_telp" id="no_telp" required
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
                                    <input type="email" id="email" name="email" required
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
                                    <select name="jenis_pasien" id="jenis_pasien" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                        <option value="" hidden selected>Pilih Jenis Pasien</option>
                                        <option value="Umum"
                                            {{ old('jenis_pasien', $pasien->jenis_pasien ?? '') == 'Umum' ? 'selected' : '' }}>
                                            Umum</option>
                                        <option value="BPJS"
                                            {{ old('jenis_pasien', $pasien->jenis_pasien ?? '') == 'BPJS' ? 'selected' : '' }}>
                                            BPJS</option>
                                        <option value="Lainnya"
                                            {{ old('jenis_pasien', $pasien->jenis_pasien ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
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
                                    <input type="text" name="no_bpjs" id="no_bpjs"
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
                                <textarea name="alamat" id="alamat" required rows="3"
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

                    <!-- Kunjungan Pasien -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-stethoscope text-purple-500"></i>
                            Data Kunjungan Pasien
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Poli Tujuan -->
                            <div>
                                <label for="poli_id"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Poli Tujuan <span class="text-red-500">*</span>
                                </label>
                                <select name="poli_id" id="poli_id"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                    <option value="" hidden selected>-- Pilih Poli --</option>
                                    @foreach ($poli as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('poli_id', $kunjungan->poli_id ?? '') == $p->id ? 'selected' : '' }}>
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

                            <!-- Tanggal Kunjungan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Kunjungan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>
                                    <input type="date" name="tgl_kunjungan" id="tgl_kunjungan" required
                                        value="{{ old('tgl_kunjungan', $kunjungan->tgl_kunjungan ?? '') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <span class="text-red-600 text-sm" id="tgl_kunjungan">
                                        @error('tgl_kunjungan')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Dokter Tujuan -->
                            <div>
                                <label for="dokter_id"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Dokter <span class="text-red-500">*</span>
                                </label>
                                <select name="dokter_id" id="dokter_id"
                                    data-old="{{ old('dokter_id', $kunjungan->dokter_id ?? '') }}"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                    <option value="" hidden selected>-- Pilih Dokter --</option>
                                    {{-- @foreach ($dokter as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('dokter_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                <span class="text-red-600 text-sm" id="dokter_id_error">
                                    @error('dokter_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div>
                                <label for="jam"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Kunjungan <span class="text-red-500">*</span>
                                </label>
                                <select name="jam" id="jam"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                    <option value="" hidden selected>-- Pilih Jam Kunjungan --</option>
                                </select>

                                <input type="hidden" name="jam_awal" id="jam_awal">
                                <input type="hidden" name="jam_akhir" id="jam_akhir">
                                <span class="text-red-600 text-sm" id="jam_error">
                                    @error('jam')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>


                            <!-- Keluhan -->
                            <div class="md:col-span-2">
                                <label id="keluhan_awal"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keluhan Pasien <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keluhan_awal" id="keluhan_awal" rows="3"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-purple-500"
                                    placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan">{{ old('keluhan_awal', $kunjungan->keluhan_awal ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="keluhan_awal">
                                    @error('keluhan_awal')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-between border-t pt-6 gap-3">

                        <a href="{{ route('petugas.kunjungan.index') }}"
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
