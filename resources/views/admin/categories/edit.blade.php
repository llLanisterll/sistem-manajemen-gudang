<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: INFO --}}
                    <div class="md:col-span-1 space-y-6">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-purple-100 text-purple-600 p-2 rounded-lg shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </span>
                                Detail Kategori
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Perbarui nama dan deskripsi kategori.
                            </p>
                        </div>

                        {{-- Preview Gambar --}}
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Gambar Saat Ini</label>
                            <div class="relative rounded-xl overflow-hidden bg-gray-50 border border-gray-200 aspect-video flex items-center justify-center">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-gray-400 text-xs">Tidak ada gambar</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM --}}
                    <div class="md:col-span-2">
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-8 space-y-6">

                                {{-- Nama Kategori (FIXED PADDING) --}}
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        </div>
                                        {{-- PL-12 DITAMBAHKAN AGAR TIDAK TERTIMPA --}}
                                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="block w-full pl-12 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 py-3 text-gray-700 font-medium shadow-sm" required>
                                    </div>
                                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                                    <textarea id="description" name="description" rows="4" class="w-full border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 p-3 text-gray-700 shadow-sm">{{ old('description', $category->description) }}</textarea>
                                </div>

                                {{-- Upload --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Gambar</label>
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
                                    Update Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
