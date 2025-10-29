<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script defer src="//unpkg.com/alpinejs" ></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex justify-center items-center min-h-screen px-4 sm:px-6">
        <div class="flex flex-col md:flex-row w-full max-w-3xl bg-white dark:bg-gray-800 shadow-lg overflow-hidden rounded-2xl">
            
            <div class="w-full md:w-1/2 p-8 sm:p-10 flex flex-col justify-center">
                {{ $slot }}
            </div>

            <div class="hidden md:flex w-1/2 bg-[linear-gradient(to_right,#2088FF_0%,#7134FC_100%)] items-center justify-center">
                <img src="/images/logoWhite.png" alt="Login Illustration" class="w-1/2 max-w-md ml-4">
            </div>
        </div>
    </div>
</body>


</html>
