<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

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

                        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
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
                                <th class="py-3 px-6 text-center">Identitas Produk (QR)</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse ($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                {{-- Kolom 1: Info Produk --}}
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded border object-cover">
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

                                {{-- Kolom 2: Kategori --}}
                                <td class="py-3 px-6 text-left">
                                    <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs">
                                        {{ $product->category->name }}
                                    </span>
                                </td>

                                {{-- Kolom 3: Harga --}}
                                <td class="py-3 px-6 text-right">
                                    <div class="font-medium">Jual: Rp {{ number_format($product->sell_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400">Beli: Rp {{ number_format($product->buy_price, 0, ',', '.') }}</div>
                                </td>

                                {{-- Kolom 4: Stok --}}
                                <td class="py-3 px-6 text-center">
                                    <span class="font-bold {{ $product->current_stock <= $product->min_stock ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->current_stock }} {{ $product->unit }}
                                    </span>
                                    @if($product->current_stock <= $product->min_stock)
                                        <div class="text-[10px] text-red-500 font-bold">Stok Rendah!</div>
                                    @endif
                                </td>

                                {{-- Kolom 5: QR Code (MODERN CARD STYLE) --}}
                                <td class="py-3 px-6">
                                    <div class="flex items-center gap-4 p-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 w-fit mx-auto group">

                                        {{-- Kiri: QR Code --}}
                                        <div class="bg-gray-50 p-1.5 rounded-lg border border-gray-100 group-hover:bg-blue-50 transition-colors">
                                            {!! QrCode::size(55)->color(30, 41, 59)->generate($product->sku) !!}
                                        </div>

                                        {{-- Kanan: Info --}}
                                        <div class="flex flex-col justify-center text-left">
                                            <span class="font-bold text-gray-800 text-sm leading-tight mb-1">
                                                {{ Str::limit($product->name, 15) }}
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 border border-gray-200 tracking-wider">
                                                    SKU
                                                </span>
                                                <span class="text-xs text-gray-500 font-mono tracking-wide">
                                                    {{ $product->sku }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 6: Aksi --}}
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center gap-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        {{-- Print QR --}}
                                        <a href="{{ route('admin.products.printBarcode', $product->id) }}" target="_blank" class="text-gray-500 hover:text-gray-900" title="Print Label">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-400">Belum ada data produk.</td>
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
