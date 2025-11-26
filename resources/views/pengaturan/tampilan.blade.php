<x-app-layout>
    <div class="py-8 max-w-6xl mx-auto px-4">
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-6 h-6 text-black dark:text-white" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="1.8" 
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 12.8A9 9 0 1111.2 3a7 7 0 109.8 9.8z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Pengaturan Tampilan</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Atur Tampilan anda dan pengaturan Tampilan</p>
        </div>

        <!-- Menu Tabs -->
        <div class="mb-8">
            <div class="flex gap-2 border-b border-gray-200 dark:border-gray-700">
                @include('pengaturan.menu')
            </div>
        </div>

        <div class="flex">
            <!-- Content Area -->
            <div class="flex-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
                    <h3 class="text-lg font-bold mb-1 text-gray-900 dark:text-white">Pengaturan Penampiian</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-8">Perbarui pengaturan tampilan akun Anda</p>

                    <form class="space-y-8" id="themeForm">
                        <!-- Mode Tampilan -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Mode Tampilan</h4>
                            <div class="flex gap-3 flex-wrap">
                                <!-- Light Mode -->
                                <label class="relative">
                                    <input type="radio" name="theme" value="light" class="sr-only peer" id="theme-light">
                                    <div class="px-6 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-full cursor-pointer transition-all 
                                        peer-checked:border-[#7134FC] 
                                        peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.12)_0%,rgba(32,136,255,0.12)_100%)] 
                                        dark:peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.25)_0%,rgba(32,136,255,0.25)_100%)] 
                                        peer-checked:text-[#7134FC]">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" 
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 3v2m0 14v2
                                                    m9-9h-2M5 12H3
                                                    m15.364-6.364l-1.414 1.414
                                                    M7.05 16.95l-1.414 1.414
                                                    m11.314 0l-1.414-1.414
                                                    M7.05 7.05L5.636 5.636
                                                    M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Light</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Dark Mode -->
                                <label class="relative">
                                    <input type="radio" name="theme" value="dark" class="sr-only peer" id="theme-dark">
                                    <div class="px-6 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-full cursor-pointer transition-all 
                                        peer-checked:border-[#7134FC] 
                                        peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.12)_0%,rgba(32,136,255,0.12)_100%)] 
                                        dark:peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.25)_0%,rgba(32,136,255,0.25)_100%)] 
                                        peer-checked:text-[#7134FC]">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" 
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 12.79A9 9 0 1111.21 3 
                                                    7 7 0 0021 12.79z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dark</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- System Mode -->
                                <label class="relative">
                                    <input type="radio" name="theme" value="system" class="sr-only peer" id="theme-system" checked>
                                    <div class="px-6 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-full cursor-pointer transition-all 
                                        peer-checked:border-[#7134FC] 
                                        peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.12)_0%,rgba(32,136,255,0.12)_100%)] 
                                        dark:peer-checked:bg-[linear-gradient(180deg,rgba(113,52,252,0.25)_0%,rgba(32,136,255,0.25)_100%)] 
                                        peer-checked:text-[#7134FC]">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" 
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 6v10a2 2 0 002 2h12a2 2 0 002-2V6
                                                    M9 22h6" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">System</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    const savedTheme = localStorage.getItem('theme') || 'system';
    document.getElementById(`theme-${savedTheme}`).checked = true;

    applyTheme(savedTheme); // ⬅️ PENTING

    document.getElementById('themeForm').addEventListener('change', function(e) {
        if (e.target.name === 'theme') {
            const theme = e.target.value;
            localStorage.setItem('theme', theme);
            applyTheme(theme);
        }
    });

    function applyTheme(theme) {
        const html = document.documentElement;
        
        if (theme === 'dark') {
            html.classList.add('dark');
        } 
        else if (theme === 'light') {
            html.classList.remove('dark');
        } 
        else {
            // system
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }
    }

    // Tambahan penting: realtime kalau user ubah sistem OS
    window
      .matchMedia('(prefers-color-scheme: dark)')
      .addEventListener('change', e => {
          if(localStorage.getItem('theme') === 'system') {
              applyTheme('system');
          }
      });
</script>

</x-app-layout>