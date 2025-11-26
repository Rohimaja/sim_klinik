<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('images/logo1.png')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer src="//unpkg.com/alpinejs"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'system';
            const html = document.documentElement;

            if (theme === 'dark') {
                html.classList.add('dark');
            } else if (theme === 'light') {
                html.classList.remove('dark');
            } else {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        })();
    </script>

</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false, profileOpen: false }">
        @include('layouts.navigation')

        <div class="lg:ml-64">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- CDN jQuery + DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css"> --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- File CSS & JS DataTables -->
    <link rel="stylesheet" href="{{ asset('css/tabel.css') }}">
    <script src="{{ asset('js/tabel.js') }}"></script>

    <script>
        document.addEventListener('submit', function (e) {
            if (e.target.classList.contains('form-hapus')) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }

            if (e.target.classList.contains('form-validasi')) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pastikan data sudah sesuai!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, simpan!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }
        });

                @if (session('status') && session('message'))
                    window.addEventListener('pageshow', function (event) {
                        if (!event.persisted) {
                            Swal.fire({
                                icon: '{{ session('status') }}',
                                title: '{{ ucfirst(session('status')) }}',
                                text: '{{ session('message') }}',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            });
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                        }
                    });
                @endif
    </script>
        @stack('scripts')
</body>
</html>
