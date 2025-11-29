<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Kolom Kiri --}}
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Dasar</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Nama Produk *</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-3 py-2" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">SKU (Kode Unik) *</label>
                                <input type="text" name="sku" value="{{ $product->sku }}" class="w-full border rounded px-3 py-2" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Kategori *</label>
                                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Stok & Harga</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Harga Beli</label>
                                    <input type="number" name="buy_price" value="{{ $product->buy_price }}" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Harga Jual</label>
                                    <input type="number" name="sell_price" value="{{ $product->sell_price }}" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Stok Saat Ini</label>
                                    <input type="number" name="current_stock" value="{{ $product->current_stock }}" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Stok Minimum</label>
                                    <input type="number" name="min_stock" value="{{ $product->min_stock }}" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Satuan (Unit)</label>
                                    <input type="text" name="unit" value="{{ $product->unit }}" class="w-full border rounded px-3 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Lokasi Rak</label>
                                    <input type="text" name="rack_location" value="{{ $product->rack_location }}" class="w-full border rounded px-3 py-2">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Gambar</label>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded mb-2">
                                @endif
                                <input type="file" name="image" class="block w-full text-sm text-gray-500">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-2">
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 font-bold">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700 font-bold">Update Produk</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
