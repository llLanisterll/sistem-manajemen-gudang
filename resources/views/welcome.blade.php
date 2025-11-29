<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GudangPro - Sistem Manajemen Gudang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-slate-800">

    {{-- NAVBAR COMPONENT --}}
    <x-navbar />

    {{-- HERO SECTION --}}
    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                {{-- Kiri: Teks & Social Media --}}
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

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-10">
                        <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-xl shadow-blue-600/20">
                            Mulai Gratis
                        </a>
                        <a href="#fitur" class="px-8 py-4 text-base font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl hover:bg-white transition">
                            Lihat Fitur
                        </a>
                    </div>

                    {{-- SOCIAL MEDIA ICONS (HERO) --}}
                    <div class="flex items-center justify-center lg:justify-start gap-6 border-t border-slate-100 pt-8" id="kontak">
                        <span class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Connect with me:</span>

                        {{-- GitHub --}}
                        <a href="https://github.com/llLanisterll" target="_blank" class="text-slate-400 hover:text-slate-800 transition transform hover:scale-110">
                            <span class="sr-only">GitHub</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        </a>

                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/srhmsan/" target="_blank" class="text-slate-400 hover:text-pink-600 transition transform hover:scale-110">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.3c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/6289694923810" target="_blank" class="text-slate-400 hover:text-green-500 transition transform hover:scale-110">
                            <span class="sr-only">WhatsApp</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM16.64 15.13C16.5 15.5 15.82 15.86 15.5 15.9C15.17 15.93 14.73 15.95 12.83 15.15C10.93 14.36 9.71 12.43 9.61 12.31C9.52 12.18 8.84 11.28 8.84 10.35C8.84 9.42 9.32 8.96 9.5 8.77C9.69 8.58 9.87 8.54 10.05 8.54C10.23 8.54 10.41 8.54 10.59 8.54C10.73 8.54 10.93 8.47 11.13 8.94C11.33 9.41 11.82 10.6 11.88 10.73C11.94 10.86 12 11.04 11.91 11.21C11.82 11.39 11.75 11.46 11.62 11.61C11.49 11.75 11.37 11.77 11.22 11.96C11.08 12.13 10.92 12.3 11.09 12.59C11.26 12.88 11.85 13.84 12.72 14.61C13.85 15.62 14.76 15.94 15.09 16.09C15.42 16.24 15.61 16.22 15.8 16.01C15.99 15.8 16.64 14.88 16.88 14.54C17.12 14.2 17.36 14.25 17.68 14.36C18 14.48 19.59 15.26 19.92 15.43C20.25 15.59 20.48 15.67 20.59 15.86C20.7 16.05 20.7 16.96 20.25 18.23C20.06 18.77 19.38 19.12 18.83 19.12C18.28 19.12 17.73 19.12 17.73 19.12C17.73 19.12 17.21 19.1 16.64 18.91C16.07 18.72 15.5 18.53 15.5 18.53C12.3 17.36 10.15 14.28 10.15 14.28C10.15 14.28 8.84 12.28 8.84 10.35C8.84 8.42 9.87 7.45 9.87 7.45C10.32 6.96 10.84 6.74 11.28 6.72C11.72 6.7 12.16 6.7 12.16 6.7C12.6 6.7 13.04 6.96 13.48 7.45C13.92 7.94 14.36 8.91 14.36 8.91C14.36 8.91 14.36 8.91 14.36 8.91C14.8 9.4 14.8 9.89 14.36 10.38C13.92 10.87 13.48 11.36 13.48 11.36C13.48 11.36 13.92 12.33 14.36 12.82C14.8 13.31 15.68 13.8 15.68 13.8C15.68 13.8 16.56 13.31 17 12.82C17.44 12.33 17.88 12.33 18.32 12.82C18.76 13.31 19.64 14.28 19.64 14.28C19.64 14.28 20.08 14.77 20.08 15.26C20.08 15.75 19.64 16.24 19.2 16.73L16.64 15.13Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Kanan: Gambar Dashboard --}}
                <div class="relative">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full blur-3xl opacity-50 -z-10 transform translate-x-10 -translate-y-10"></div>
                    <div class="relative rounded-2xl shadow-2xl border border-slate-200 bg-white p-2">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2670&auto=format&fit=crop"
                             alt="Dashboard Preview"
                             class="rounded-xl w-full h-auto object-cover">
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
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

    {{-- SOLUTIONS SECTION --}}
    <section id="solusi" class="py-24 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Text Content --}}
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-900 mb-6">Optimalkan Operasional dengan Data Real-time</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                1
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Pencatatan Otomatis</h4>
                                <p class="text-slate-500">Tidak ada lagi pencatatan manual. Semua transaksi tercatat digital.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                2
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Kontrol Stok Ketat</h4>
                                <p class="text-slate-500">Notifikasi otomatis saat stok menipis, mencegah kehabisan barang.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                3
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Akses Multi-Role</h4>
                                <p class="text-slate-500">Admin, Manager, Staff, dan Supplier memiliki portal masing-masing.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-600 rounded-2xl transform rotate-3 opacity-10"></div>
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2670&auto=format&fit=crop" alt="Warehouse Operation" class="relative rounded-2xl shadow-xl border border-slate-200 w-full">
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER COMPONENT --}}
    <x-footer />

</body>
</html>
