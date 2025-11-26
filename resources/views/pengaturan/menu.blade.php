<div class="space-y-3">
    <a href="{{ route('pengaturan.profile') }}"
        class="px-4 py-3 border-b-2 font-medium text-sm transition-all duration-300
        {{ request()->routeIs('pengaturan.profile') 
            ? 'border-[#7134FC] text-[#7134FC] dark:text-[#7134FC]' 
            : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
        Profil
    </a>

    <a href="{{ route('pengaturan.password') }}"
        class="px-4 py-3 border-b-2 font-medium text-sm transition-all duration-300
        {{ request()->routeIs('pengaturan.password') 
            ? 'border-[#7134FC] text-[#7134FC] dark:text-[#7134FC]' 
            : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
        Password
    </a>

    <a href="{{ route('pengaturan.tampilan') }}"
        class="px-4 py-3 border-b-2 font-medium text-sm transition-all duration-300
        {{ request()->routeIs('pengaturan.tampilan') 
            ? 'border-[#7134FC] text-[#7134FC] dark:text-[#7134FC]' 
            : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
        Tampilan
    </a>
</div>