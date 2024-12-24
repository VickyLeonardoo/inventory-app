<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- Favicon -->
         <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('custom/favicon/favicon-32x32.png') }}">
         <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('custom/favicon/favicon-16x16.png') }}">
         <link rel="apple-touch-icon" href="{{ asset('custom/favicon/apple-touch-icon.png') }}">
         <link rel="manifest" href="{{ asset('custom/favicon/site.webmanifest') }}">
 

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                 style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d');">
                <div class="absolute inset-0 bg-gray-900/50"></div> <!-- Semi-transparent dark overlay -->
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-white" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-lg relative z-10 border border-gray-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>