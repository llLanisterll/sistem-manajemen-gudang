<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Kolom Kiri: Info Dasar --}}
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Dasar</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Nama Produk *</label>
                                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">SKU (Kode Unik) *</label>
                                <input type="text" name="sku" class="w-full border rounded px-3 py-2" required placeholder="Contoh: EL-001">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Kategori *</label>
                                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Detail Stok & Harga --}}
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Stok & Harga</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Harga Beli</label>
                                    <input type="number" name="buy_price" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Harga Jual</label>
                                    <input type="number" name="sell_price" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Stok Saat Ini</label>
                                    <input type="number" name="current_stock" class="w-full border rounded px-3 py-2" required min="0">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Stok Minimum (Alert)</label>
                                    <input type="number" name="min_stock" class="w-full border rounded px-3 py-2" required min="0" value="10">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Satuan (Unit)</label>
                                    <input type="text" name="unit" class="w-full border rounded px-3 py-2" required placeholder="Pcs/Box/Kg" value="Pcs">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold mb-2">Lokasi Rak</label>
                                    <input type="text" name="rack_location" class="w-full border rounded px-3 py-2" placeholder="Contoh: A-01">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Gambar Produk</label>
                                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-2">
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 font-bold">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700 font-bold">Simpan Produk</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
