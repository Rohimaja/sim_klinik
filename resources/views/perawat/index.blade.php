<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Section -->
            <div
                class="bg-gradient-to-r from-blue-500 to-cyan-500 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold" id="clock"></div>
                        <div class="text-sm text-blue-100 mt-1">Jam Kerja: 07:00 - 15:00</div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Belum Skrining -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-orange-600 dark:text-orange-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-orange-600 bg-orange-100 dark:bg-orange-900 dark:text-orange-300 px-2 py-1 rounded">Prioritas</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Belum Skrining</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $before ?? '-' }}</p>
                    </div>
                </div>

                <!-- Sedang Skrining -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m7 8a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded">Aktif</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Sedang Skrining</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $do ?? '-' }}</p>
                    </div>
                </div>

                <!-- Selesai Skrining -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-1 rounded">Hari
                                ini</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Selesai Skrining</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $done ?? '-' }}</p>
                    </div>
                </div>

                <!-- Total Pasien -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 dark:bg-purple-900 dark:text-purple-300 px-2 py-1 rounded">Total</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Total Pasien</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $pasien }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Daftar Pasien Menunggu Skrining -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pasien Menunggu Skrining
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                    <th
                                        class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                        No. Antrian</th>
                                    <th
                                        class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                        Nama Pasien</th>
                                    <th
                                        class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                        Umur</th>
                                    <th
                                        class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                        Jenis Kelamin</th>
                                    <th
                                        class="text-center py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                        Status</th>
                                </tr>
                            </thead>
                            @foreach ($pasienToday as $i => $pt)
                                <tbody>
                                    <tr
                                        class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4"><span
                                                class="font-bold text-orange-600 dark:text-orange-400">{{ $pt->no_antrian ?? '-' }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-800 dark:text-gray-200">
                                            {{ $pt->pasien->nama ?? '-' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $pt->pasien->tgl_lahir ?? '-' }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $pt->pasien->jenis_kelamin === 'L' ? 'Laki-laki' : ($pt->pasien->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if ($pt->status == 'menunggu')
                                                <span
                                                    class="text-xs px-3 py-1 rounded-full font-medium bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300 hover:bg-orange-200 dark:hover:bg-orange-800 inline-block">
                                                    Menunggu
                                                </span>
                                            @elseif ($pt->status == 'dipanggil')
                                                <span
                                                    class="text-xs px-3 py-1 rounded-full font-medium bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 inline-block">
                                                    Sedang Skrining
                                                </span>
                                            @elseif ($pt->status == 'selesai')
                                                <span
                                                    class="text-xs px-3 py-1 rounded-full font-medium bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800 inline-block">
                                                    Selesai Skrining
                                                </span>
                                            @elseif ($pt->status == 'dibatalkan')
                                                <span
                                                    class="text-xs px-3 py-1 rounded-full font-medium bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800 inline-block">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div
                        class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan 5 dari 12 pasien yang menunggu skrining
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Sedang Skrining -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-700 dark:to-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Sedang Skrining
                            </h3>
                        </div>
                        @foreach ($skrining as $s)
                            <div class="p-6 space-y-4">
                                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg border-l-4 border-blue-600">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                {{ $s->pasien->nama ?? '-' }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">No. Antrian:
                                                {{ $s->no_antrian ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Parameter Vital -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center mb-4">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                Parameter Vital
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tekanan Darah</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">120/80</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Normal</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Suhu</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">36.5°C</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Normal</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Denyut Nadi</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">72 bpm</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Normal</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">RR</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">18 x/m</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Normal</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                document.getElementById('clock').textContent = hours + ':' + minutes + ':' + seconds;
            }

            updateClock();
            setInterval(updateClock, 1000);
        </script>
    @endpush
</x-app-layout>
