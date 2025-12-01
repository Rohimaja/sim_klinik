<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Petugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold" id="clock"></div>
                        <div class="text-sm text-blue-100 mt-1">Jam Kerja: 08:00 - 16:00</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-300 px-2 py-1 rounded">+12%</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Pasien Hari Ini</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $pasien ?? '-' }}</p>
                    </div>
                </div>

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
                                class="text-xs font-semibold text-orange-600 bg-orange-100 dark:bg-orange-900 dark:text-orange-300 px-2 py-1 rounded">3
                                menunggu</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Antrian Aktif</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">8</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-1 rounded">Hari
                                ini</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Pasien Selesai</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $done ?? '-' }}</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 dark:bg-purple-900 dark:text-purple-300 px-2 py-1 rounded">Bulan
                                ini</span>
                        </div>
                        <h4 class="text-gray-600 dark:text-gray-400 text-sm mb-1">Pasien Baru</h4>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $pasienBaru ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Antrian Aktif
                            </h3>
                            <a href="#"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">Lihat
                                Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th
                                            class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                            No. Antrian</th>
                                        <th
                                            class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                            Nama Pasien</th>
                                        <th
                                            class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                            Poli</th>
                                        <th
                                            class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                            Status</th>
                                        <th
                                            class="text-left py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                            Waktu</th>
                                    </tr>
                                </thead>
                                @foreach ($pasienToday as $i => $pt)
                                    <tbody>
                                        <tr
                                            class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="py-3 px-4"><span
                                                    class="font-bold text-blue-600 dark:text-blue-400">{{ $pt->no_antrian ?? '-' }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-gray-800 dark:text-gray-200">
                                                {{ $pt->pasien->nama ?? '-' }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $pt->poli->nama ?? '-' }}</td>
                                            <td class="py-3 px-4">
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
                                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">09:30</td>
                                        </tr>

                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Pasien Selesai Pemeriksaan
                            </h3>
                        </div>

                        <div class="space-y-4">
                            @foreach ($pasienDone as $pd)
                                <!-- Item 1 -->
                                <div
                                    class="flex items-start space-x-3 pb-4 border-b border-gray-100 dark:border-gray-700">
                                    <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $pd->pasien->nama ?? '-' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $pd->poli->nama ?? '-' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">10:30</p>
                                    </div>
                                </div>
                            @endforeach


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
