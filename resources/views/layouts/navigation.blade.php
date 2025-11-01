<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64  bg-[linear-gradient(to_bottom,#7134FC_0%,#2088FF_100%)] dark:bg-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0" :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    <div class="flex flex-col h-full">
        <!-- Logo & Close Button -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-white/10">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                <span class="text-white text-xl font-semibold tracking-wide">MEDI-GO</span>
            </a>

            <!-- Tombol close untuk mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200 p-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>


        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto" x-data="{ openMaster: false, openLaporan: false }">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg transition 
                {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                <i class="fa-solid fa-house text-base w-5 text-center mr-3"></i>
                <span class="font-medium leading-none">Dashboard</span>
            </a>

            <!-- Master Data Dropdown -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center w-full px-4 py-3 text-white hover:bg-white/10 rounded-lg transition">
                    <i class="fa-solid fa-database text-base w-5 text-center mr-3"></i>
                    <span class="flex-1 text-left font-medium leading-none">Master Data</span>
                    <i :class="open ? 
                        'fa-solid fa-chevron-down text-sm transform rotate-180 transition-transform duration-300' : 
                        'fa-solid fa-chevron-down text-sm transform transition-transform duration-300'">
                    </i>
                </button>

                <!-- Isi Dropdown -->
                <div x-show="open" x-transition
                    class="ml-8 mt-2 pl-4 border-l border-white/20 space-y-2">
                    <a href="{{ route('dokter.index') }}" class="block text-white hover:text-gray-200">Dokter</a>
                    <a href="{{ route('perawat.index') }}" class="block text-white hover:text-gray-200">Perawat</a>
                    <a href="{{ route('petugas.index') }}" class="block text-white hover:text-gray-200">Petugas</a>
                    <a href="{{ route('pasien.index') }}" class="block text-white hover:text-gray-200">Pasien</a>
                    <a href="{{ route('poli.index') }}" class="block text-white hover:text-gray-200">Poli</a>
                    <a href="{{ route('obat.index') }}" class="block text-white hover:text-gray-200">Obat</a>
                    <a href="{{ route('tindakan.index') }}" class="block text-white hover:text-gray-200">Tindakan</a>
                    <a href="{{ route('jadwal.index') }}" class="block text-white hover:text-gray-200">Jadwal Tenaga Klinik</a>
                </div>
            </div>

            <!-- Laporan Dropdown -->
            <div x-data="{ open: false }" class="mt-2">
                <button @click="open = !open"
                    class="flex items-center w-full px-4 py-3 text-white hover:bg-white/10 rounded-lg transition">
                    <i class="fa-solid fa-file-lines text-base w-5 text-center mr-3"></i>
                    <span class="flex-1 text-left font-medium leading-none">Laporan</span>
                    <i :class="open ? 
                        'fa-solid fa-chevron-down text-sm transform rotate-180 transition-transform duration-300' : 
                        'fa-solid fa-chevron-down text-sm transform transition-transform duration-300'">
                    </i>
                </button>

                <!-- Isi Dropdown -->
                <div x-show="open" x-transition
                    class="ml-8 mt-2 pl-4 border-l border-white/20 space-y-2">
                    <a href="{{ route('laporan.kunjungan') }}" class="block text-white hover:text-gray-200">Kunjungan Pasien</a>
                    <a href="{{ route('laporan.pendapatan') }}" class="block text-white hover:text-gray-200">Pendapatan Harian</a>
                    <a href="{{ route('laporan.stokobat') }}" class="block text-white hover:text-gray-200">Stok Obat</a>
                </div>
            </div>
        </nav>



        <!-- User Profile Dropdown (Bottom) -->
        <div class="border-t border-white/10 relative">
            <!-- Dropup Menu -->
            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute bottom-full left-0 right-0 mb-2 mx-4 bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden" style="display: none;">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm font-medium">{{ __('Profile') }}</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition border-t border-gray-200 dark:border-gray-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm font-medium">{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>

            <!-- User Info Button -->
            <button @click="profileOpen = !profileOpen" class="w-full px-4 py-4 flex items-center hover:bg-white/10 transition">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold mr-3 flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/70 truncate">{{ Auth::user()->email }}</div>
                </div>
                <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black/50 z-40" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>

<!-- Top Bar for Mobile (with hamburger) -->
<div class="lg:hidden bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 py-3">
        <button @click="sidebarOpen = true" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 p-2">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="w-10"></div> <!-- Spacer for centering -->
    </div>
</div>