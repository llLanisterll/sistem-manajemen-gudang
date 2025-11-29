<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-700 via-indigo-800 to-gray-900">
            {{-- Logo Area --}}
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="bg-white p-3 rounded-xl shadow-lg">
                        <x-application-logo class="w-16 h-16 fill-current text-blue-600" />
                    </div>
                    <span class="text-white font-bold text-2xl tracking-wide">GudangPro</span>
                </a>
            </div>

            {{-- Form Card --}}
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20">
                {{ $slot }}
            </div>

            <div class="mt-8 text-white/50 text-sm">
                &copy; {{ date('Y') }} Sistem Manajemen Gudang.
            </div>
        </div>
    </body>
</html>
