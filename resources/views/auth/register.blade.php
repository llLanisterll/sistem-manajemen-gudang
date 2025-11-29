<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Bergabung dengan GudangPro 🚀</h2>
        <p class="text-slate-500 text-sm mt-1">Buat akun baru untuk mulai mengelola.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="role" :value="__('Daftar Sebagai')" class="text-slate-600 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{-- Icon Role --}}
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <select id="role" name="role" class="block mt-1 w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 bg-slate-50 text-slate-700 cursor-pointer" required>
                    <option value="" disabled selected>-- Pilih Peran --</option>
                    <option value="supplier">Supplier (Pemasok)</option>
                    <option value="staff">Staff Gudang</option>
                    <option value="manager">Warehouse Manager</option>
                </select>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-600 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{-- Icon User --}}
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="name" class="block mt-1 w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 bg-slate-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Perusahaan / Pribadi" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-slate-600 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{-- Icon Email --}}
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="block mt-1 w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 bg-slate-50" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="text-slate-600 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{-- Icon Lock --}}
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block mt-1 w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 bg-slate-50"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-600 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{-- Icon Check --}}
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="block mt-1 w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 bg-slate-50"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 text-base rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 shadow-lg shadow-blue-600/30 transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>

            <div class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">Masuk disini</a>
            </div>
        </div>
    </form>
</x-guest-layout>
