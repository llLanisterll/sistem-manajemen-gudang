<nav x-data="{ open: false }" class="fixed w-full z-50 top-0 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <div class="flex-shrink-0 flex items-center gap-2">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white p-2 rounded-lg font-bold shadow-lg shadow-blue-500/20 transform hover:scale-105 transition duration-300">WMS</div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">GudangPro</span>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#fitur" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition hover:underline underline-offset-4 decoration-2 decoration-blue-500">Fitur</a>
                <a href="#solusi" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition hover:underline underline-offset-4 decoration-2 decoration-blue-500">Solusi</a>
                <a href="#kontak" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition hover:underline underline-offset-4 decoration-2 decoration-blue-500">Kontak</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-900 rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 transform hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-blue-600 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 transform hover:-translate-y-0.5 hover:shadow-blue-600/40">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>

            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-b border-slate-100 shadow-lg absolute w-full left-0 top-20">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="#fitur" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition">Fitur</a>
            <a href="#solusi" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition">Solusi</a>
            <a href="#kontak" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition">Kontak</a>

            <div class="border-t border-slate-100 my-2 pt-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full text-center px-5 py-3 text-base font-semibold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-md">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-5 py-3 mt-2 text-base font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-md">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
