<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/avatar/simi_logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <!-- 🔥 Background Gambar di Belakang Box Login -->
        <div class="flex flex-col items-center min-h-screen pt-6 bg-fixed bg-center bg-no-repeat bg-cover sm:justify-center sm:pt-0"
             style="background-image: url('{{ asset('assets/img/layout/dashboard.jpg') }}');">

            <!-- 🖼️ Box Login dengan Warna Gray dan Logo di Dalamnya -->
            <div class="w-full px-6 py-8 mt-6 text-center bg-gray-300 shadow-lg sm:max-w-md sm:rounded-lg">
                <!-- Logo di Dalam Box -->
                <img src="{{ asset('assets/img/avatar/simi_logo.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-4">

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
