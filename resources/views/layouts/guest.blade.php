<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100">

            {{-- Logo Area --}}
            <div class="mb-6 flex flex-col items-center">
                <a href="/" class="flex flex-col items-center gap-2 group">
                    <div class="bg-white p-3 rounded-2xl shadow-lg border border-white/50 group-hover:scale-110 transition duration-300">
                        <x-application-logo class="w-12 h-12 fill-current text-blue-600" />
                    </div>
                    <span class="text-2xl font-extrabold text-slate-800 tracking-tight group-hover:text-blue-600 transition">GudangPro</span>
                </a>
            </div>

            {{-- Form Container --}}
            <div class="w-full sm:max-w-md mt-4 px-8 py-10 bg-white shadow-2xl shadow-blue-200/50 overflow-hidden sm:rounded-3xl border border-white/60 relative">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100 rounded-full blur-2xl opacity-50 -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-20 h-20 bg-purple-100 rounded-full blur-2xl opacity-50 -ml-10 -mb-10"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <div class="mt-8 text-sm text-slate-500">
                &copy; {{ date('Y') }} GudangPro Systems.
            </div>
        </div>
    </body>
</html>
