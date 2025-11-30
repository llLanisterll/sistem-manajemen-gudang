<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                    {{-- KOLOM KIRI: INFO SIDEBAR --}}
                    <div class="md:col-span-1 space-y-6">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </span>
                                Detail Produk
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                Lakukan perubahan pada detail produk.
                                <span class="block mt-1 font-bold text-indigo-600 text-xs bg-indigo-50 p-2 rounded border border-indigo-100">
                                    Catatan: SKU tidak dapat diubah untuk menjaga integritas data riwayat.
                                </span>
                            </p>
                        </div>

                        {{-- Current Image Preview --}}
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Gambar Saat Ini</label>
                            <div class="relative rounded-xl overflow-hidden bg-gray-50 border border-gray-200 aspect-square flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="text-gray-400 text-xs text-center">No Image</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM INPUT --}}
                    <div class="md:col-span-3">
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- SECTION 1 --}}
                                <div class="space-y-6 border-r border-gray-100 md:pr-6">
                                    <h4 class="text-md font-bold text-gray-700 border-b pb-2">Informasi Produk</h4>

                                    {{-- Nama --}}
                                    <div>
                                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required>
                                    </div>

                                    {{-- SKU (Readonly) --}}
                                    <div>
                                        <label for="sku" class="block text-sm font-bold text-gray-700 mb-2">SKU (Kode Unik)</label>
                                        <input type="text" name="sku" id="sku" value="{{ $product->sku }}" class="w-full border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed py-2.5 shadow-sm" readonly>
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                                        <select name="category_id" id="category_id" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div>
                                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                        <textarea name="description" id="description" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>

                                {{-- SECTION 2 --}}
                                <div class="space-y-6 md:pl-6">
                                    <h4 class="text-md font-bold text-gray-700 border-b pb-2">Stok & Harga</h4>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Beli</label>
                                            <input type="number" name="buy_price" value="{{ old('buy_price', $product->buy_price) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required min="0">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual</label>
                                            <input type="number" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm" required min="0">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                                            <input type="number" name="current_stock" value="{{ old('current_stock', $product->current_stock) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Min.</label>
                                            <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Unit</label>
                                            <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm text-center" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Rak</label>
                                        <input type="text" name="rack_location" value="{{ old('rack_location', $product->rack_location) }}" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Gambar</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-indigo-50 hover:border-indigo-300 transition-all cursor-pointer group relative">
                                            <div class="space-y-2 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                <div class="flex text-sm text-gray-600 justify-center">
                                                    <label for="image" class="relative cursor-pointer rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                        <span>Upload file baru</span>
                                                        <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="image-preview" class="hidden absolute inset-0 bg-white rounded-xl flex items-center justify-center z-10 p-4">
                                                <img id="preview-img" src="" class="max-w-full max-h-full rounded-xl opacity-90 object-contain">
                                                <button type="button" onclick="resetImage()" class="absolute top-4 right-4 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-md">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER ACTIONS --}}
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm transform">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30 transform hover:-translate-y-0.5">
                                    Update Produk
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            reader.onload = function() {
                previewImg.src = reader.result;
                previewContainer.classList.remove('hidden');
            }
            if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }
        function resetImage() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }
    </script>
</x-app-layout>
