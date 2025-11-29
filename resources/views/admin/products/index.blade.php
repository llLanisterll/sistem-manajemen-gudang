<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg overflow-hidden sm:rounded-lg p-6">

                {{-- Header & Filter --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold">Daftar Produk</h3>

                    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
                            <select name="category_id" class="border rounded px-3 py-2 text-sm" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="text" name="search" placeholder="Cari SKU / Nama..." value="{{ request('search') }}"
                                class="border rounded px-3 py-2 text-sm">

                            <button type="submit" class="bg-gray-500 text-white px-3 py-2 rounded text-sm hover:bg-gray-600">
                                Cari
                            </button>
                        </form>

                        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 font-bold py-2 px-4 rounded text-center">
                            + Tambah Produk
                        </a>
                    </div>
                </div>

                {{-- Alert --}}
                @if ($message = Session::get('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ $message }}
                    </div>
                @endif

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Info Produk</th>
                                <th class="py-3 px-6 text-left">Kategori</th>
                                <th class="py-3 px-6 text-right">Harga</th>
                                <th class="py-3 px-6 text-center">Stok</th>
                                <th>QRCode</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse ($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded border">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center text-xs">No Pic</div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold block">{{ $product->name }}</span>
                                            <span class="text-xs text-gray-500">SKU: {{ $product->sku }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-right">
                                    <div class="font-medium">Jual: Rp {{ number_format($product->sell_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400">Beli: Rp {{ number_format($product->buy_price, 0, ',', '.') }}</div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="font-bold {{ $product->current_stock <= $product->min_stock ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->current_stock }} {{ $product->unit }}
                                    </span>
                                    @if($product->current_stock <= $product->min_stock)
                                        <div class="text-[10px] text-red-500 font-bold">Stok Rendah!</div>
                                    @endif
                                </td>
                                <td>
                                    {!! QrCode::size(60)->generate($product->sku) !!}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                        {{-- Tombol Print QR --}}
                                        <a href="{{ route('admin.products.printBarcode', $product->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900 mr-2" title="Print QR Code">
                                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm12 0h-6v6h6V6zm-6 12H6v-6h6v6z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada data produk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
