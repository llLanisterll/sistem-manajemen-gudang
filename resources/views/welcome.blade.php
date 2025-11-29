<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GudangPro - Sistem Manajemen Gudang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-slate-800">

    {{-- NAVBAR (Sticky & Clean) --}}
    <nav class="fixed w-full z-50 top-0 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg font-bold shadow-lg shadow-blue-600/20">WMS</div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">GudangPro</span>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-slate-600 hover:text-blue-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION (Layout Kiri-Kanan yang Stabil) --}}
    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                {{-- Kiri: Teks --}}
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold uppercase tracking-wider mb-6">
                        🚀 Versi Terbaru 2.0
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                        Manajemen Gudang <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Tanpa Ribet.</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Pantau stok barang masuk & keluar, kelola supplier, dan cetak barcode dalam satu aplikasi terintegrasi. Dirancang untuk kecepatan dan akurasi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-xl shadow-blue-600/20">
                            Mulai Gratis
                        </a>
                        <a href="#fitur" class="px-8 py-4 text-base font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl hover:bg-white transition">
                            Lihat Fitur
                        </a>
                    </div>

                    {{-- Stats Kecil --}}
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-8 text-sm font-medium text-slate-500 border-t border-slate-100 pt-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Real-time Tracking
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Multi-User Support
                        </div>
                    </div>
                </div>

                {{-- Kanan: Gambar Dashboard (Menggunakan Gambar Asli agar tidak Hancur) --}}
                <div class="relative">
                    {{-- Background Blob --}}
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full blur-3xl opacity-50 -z-10 transform translate-x-10 -translate-y-10"></div>

                    {{-- Image Container --}}
                    <div class="relative rounded-2xl shadow-2xl border border-slate-200 bg-white p-2">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2670&auto=format&fit=crop"
                             alt="Dashboard Preview"
                             class="rounded-xl w-full h-auto object-cover">

                        {{-- Floating Card 1 --}}
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl border border-slate-100 hidden md:block">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 p-2 rounded-lg text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Status Stok</p>
                                    <p class="font-bold text-slate-800">Aman Terkendali</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FEATURES SECTION (Grid Rapi) --}}
    <section id="fitur" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm mb-3">Fitur Utama</h2>
                <h3 class="text-3xl font-extrabold text-slate-900">Solusi Lengkap Gudang Anda</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Stok Opname</h4>
                    <p class="text-slate-500">Catat barang masuk dan keluar dengan mudah. Sistem akan otomatis menghitung sisa stok secara akurat.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm12 0h-6v6h6V6zm-6 12H6v-6h6v6z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">QR Code & Barcode</h4>
                    <p class="text-slate-500">Setiap produk memiliki identitas unik. Cetak label QR Code untuk mempercepat proses scanning.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Laporan Lengkap</h4>
                    <p class="text-slate-500">Export data transaksi ke Excel/CSV. Analisis performa gudang Anda dengan data yang transparan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="bg-slate-900 text-white p-1.5 rounded font-bold text-sm">W</div>
                <span class="font-bold text-slate-900">GudangPro</span>
            </div>
            <p class="text-slate-500 text-sm">© {{ date('Y') }} GudangPro Systems. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
