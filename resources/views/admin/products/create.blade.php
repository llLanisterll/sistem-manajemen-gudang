<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                    {{-- KOLOM KIRI: INFO SIDEBAR (1/4) --}}
                    <div class="md:col-span-1 space-y-4">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </span>
                                Detail Produk
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                Pastikan semua field diisi dengan akurat, terutama SKU dan harga. SKU tidak bisa diubah setelah disimpan.
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM INPUTS (3/4) --}}
                    <div class="md:col-span-3">
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- SECTION 1: INFO DASAR & GAMBAR --}}
                                <div class="space-y-6 border-r border-gray-100 md:pr-6">
                                    <h4 class="text-md font-bold text-gray-700 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Informasi Produk
                                    </h4>

                                    {{-- Nama Produk --}}
                                    <div>
                                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required placeholder="Contoh: Laptop Gaming X10">
                                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- SKU --}}
                                    <div>
                                        <label for="sku" class="block text-sm font-bold text-gray-700 mb-2">SKU (Kode Unik) <span class="text-red-500">*</span></label>
                                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required placeholder="Contoh: EL-LPT-G10">
                                        @error('sku') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                        <select name="category_id" id="category_id" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div>
                                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                        <textarea name="description" id="description" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm" placeholder="Detail spesifikasi produk...">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                {{-- SECTION 2: STOK & HARGA --}}
                                <div class="space-y-6 md:pl-6">
                                    <h4 class="text-md font-bold text-gray-700 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2-4h10a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6a2 2 0 012-2z"></path></svg>
                                        Stok, Harga & Gambar
                                    </h4>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Harga Beli --}}
                                        <div>
                                            <label for="buy_price" class="block text-sm font-bold text-gray-700 mb-2">Harga Beli</label>
                                            <input type="number" name="buy_price" id="buy_price" value="{{ old('buy_price') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required min="0" placeholder="5000000">
                                            @error('buy_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        {{-- Harga Jual --}}
                                        <div>
                                            <label for="sell_price" class="block text-sm font-bold text-gray-700 mb-2">Harga Jual</label>
                                            <input type="number" name="sell_price" id="sell_price" value="{{ old('sell_price') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required min="0" placeholder="7500000">
                                            @error('sell_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-4">
                                        {{-- Stok Saat Ini --}}
                                        <div>
                                            <label for="current_stock" class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                                            <input type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', 0) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required min="0">
                                        </div>
                                        {{-- Stok Minimum --}}
                                        <div>
                                            <label for="min_stock" class="block text-sm font-bold text-gray-700 mb-2">Stok Min.</label>
                                            <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', 5) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required min="0">
                                        </div>
                                        {{-- Unit --}}
                                        <div>
                                            <label for="unit" class="block text-sm font-bold text-gray-700 mb-2">Unit</label>
                                            <input type="text" name="unit" id="unit" value="{{ old('unit', 'Pcs') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required placeholder="Pcs/Box">
                                        </div>
                                    </div>

                                    {{-- Lokasi Rak --}}
                                    <div>
                                        <label for="rack_location" class="block text-sm font-bold text-gray-700 mb-2">Lokasi Rak</label>
                                        <input type="text" name="rack_location" id="rack_location" value="{{ old('rack_location') }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" placeholder="Contoh: A-01 / Lantai 2">
                                    </div>

                                    {{-- Upload Gambar --}}
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Produk</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-indigo-50 hover:border-indigo-300 transition-all cursor-pointer group relative">
                                            <div class="space-y-2 text-center">
                                                <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors">
                                                    <svg class="h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <div class="flex text-sm text-gray-600 justify-center">
                                                    <label for="image" class="relative cursor-pointer rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload file</span>
                                                        <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                                    </label>
                                                    <span class="pl-1">atau drag and drop</span>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                            </div>

                                            {{-- Image Preview Container --}}
                                            <div id="image-preview" class="hidden absolute inset-0 bg-white rounded-xl flex items-center justify-center z-10 p-4">
                                                <img id="preview-img" src="" alt="Preview" class="max-w-full max-h-full rounded-xl opacity-90 object-contain">
                                                <button type="button" onclick="resetImage()" class="absolute top-4 right-4 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition shadow-md">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER ACTIONS --}}
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                                    Batal
                                </a>
                                <div class="text-sm font-semibold  bg-purple-600 rounded-xl  hover:bg-purple-500 text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition shadow-lg shadow-purple-500/30 transform hover:-translate-y-0.5">
                                    <button type="submit" class="px-6 py-2 ">
                                        Simpan Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Script untuk Preview Gambar --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');

            reader.onload = function() {
                previewImg.src = reader.result;
                previewContainer.classList.remove('hidden');
            }

            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function resetImage() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }
    </script>
</x-app-layout>
