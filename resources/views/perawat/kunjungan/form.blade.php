<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Skrining Pasien') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">


                @if ($errors->any())
                    <div class="alert alert-danger text-red-600 dark:text-red-400">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Info Pasien -->
                <div class="p-6 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">No. RM</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $kunjungan->pasien->no_rm ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Nama Pasien</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $kunjungan->pasien->nama ?? '-' }}
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Umur</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $umur ?? '-' }}
                                Tahun
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Jenis Kelamin</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $kunjungan->pasien->jenis_kelamin === 'L' ? 'Laki-laki' : ($kunjungan->pasien->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form
                    action="{{ isset($skrining) ? route('perawat.kunjungan.update', $skrining->id) : route('perawat.kunjungan.store') }}"
                    method="POST" class="p-6 space-y-6">
                    @csrf
                    @if (isset($skrining))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                    <!-- Tanda Vital -->
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
                                    <input type="number" name="sistol" id="sistol" placeholder="Sistol"
                                        value="{{ old('sistol', $sistol ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">/</span>
                                    <input type="number" name="diastolik" id="diastolik" placeholder="Diastolik"
                                        value="{{ old('diastolik', $diastolik ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">mmHg</span>
                                    <span class="text-red-600 text-sm" id="tensi_error">
                                        @error('tensi')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Suhu -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Suhu Tubuh <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="suhu" id="suhu" step="0.1"
                                        value="{{ old('suhu', $skrining->suhu ?? '') }}" placeholder="36.5"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                        required>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">°C</span>
                                    <span class="text-red-600 text-sm" id="suhu_error">
                                        @error('suhu')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Berat Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Berat Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="berat_badan" id="berat_badan" step="0.1"
                                        value="{{ old('berat_badan', $skrining->berat_badan ?? '') }}" placeholder="70"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">kg</span>
                                    <span class="text-red-600 text-sm" id="berat_badan_error">
                                        @error('berat_badan')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Tinggi Badan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tinggi Badan
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="tinggi_badan" id="tinggi_badan"
                                        value="{{ old('tinggi_badan', $skrining->tinggi_badan ?? '') }}"
                                        placeholder="170"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">cm</span>
                                    <span class="text-red-600 text-sm" id="tinggi_badan_error">
                                        @error('tinggi_badan')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Keluhan -->
                            <div class="md:col-span-1">
                                <label id="keluhan"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Keluhan Pasien <span class="text-red-500">*</span>
                                </label>
                                <textarea name="keluhan_utama" id="keluhan" rows="2"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="Contoh: Demam, batuk sejak 3 hari, sesak napas ringan">{{ old('keluhan', $skrining->keluhan_utama ?? '') }}</textarea>
                                <span class="text-red-600 text-sm" id="keluhan_error">
                                    @error('keluhan')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-between border-t pt-6 gap-3">

                        <a href="{{ route('perawat.kunjungan.index') }}"
                            class="px-6 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 text-center font-medium transition-colors">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </a>

                        <div class="flex gap-3">
                            <button type="reset"
                                class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-md font-medium transition-colors">
                                <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                            </button>

                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md font-medium transition-colors">
                                <i class="fa-solid fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
