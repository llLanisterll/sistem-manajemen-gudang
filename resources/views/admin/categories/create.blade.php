<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI --}}
                    <div class="md:col-span-1 space-y-4">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-purple-100 text-purple-600 p-2 rounded-lg shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </span>
                                Info Kategori
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Buat kategori baru untuk mengelompokkan produk.
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="md:col-span-2">
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-8 space-y-6">

                                {{-- Nama Kategori (FIXED PADDING) --}}
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                        </div>
                                        {{-- PL-12 DITAMBAHKAN --}}
                                        <input type="text" name="name" id="name" class="block w-full pl-12 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 py-3 text-gray-700 font-medium shadow-sm" placeholder="Contoh: Elektronik" required>
                                    </div>
                                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                    <textarea id="description" name="description" rows="4" class="w-full border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 p-3 text-gray-700 shadow-sm"></textarea>
                                </div>

                                {{-- Upload --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Sampul</label>
                                    <input id="image" name="image" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                </div>
                            </div>

                            {{-- Footer Actions --}}
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 transition shadow-sm">
                                    Batal
                                </a>
                                {{-- TOMBOL FIX WARNA --}}
                                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-purple-600 rounded-xl hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 shadow-lg shadow-purple-500/30 transition transform hover:-translate-y-0.5">
                                    Simpan Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
