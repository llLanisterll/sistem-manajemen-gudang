<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Inventori') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-full text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-400 hover:text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                {{-- HEADER & TOOLBAR --}}
                <div class="px-6 py-6 border-b border-gray-100 bg-gray-50/50 flex flex-col lg:flex-row justify-between items-center gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </span>
                            Daftar Produk
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 ml-11">Total item aktif: <span class="font-bold text-indigo-600">{{ $products->total() }}</span></p>
                    </div>

                    {{-- Filter, Search & Add Button --}}
                    <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto items-center">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full">

                            {{-- Filter Kategori --}}
                            <div class="relative">
                                <select name="category_id" class="appearance-none w-full md:w-48 pl-10 pr-8 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm py-2.5 bg-white shadow-sm cursor-pointer hover:border-indigo-300 transition-colors" onchange="this.form.submit()">
                                    <option value="">📂 Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                </div>
                            </div>

                            {{-- Search Input --}}
                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-10 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 shadow-sm transition-shadow hover:shadow-md"
                                    placeholder="Cari SKU atau Nama...">
                            </div>
                        </form>

                        {{-- Tombol Tambah --}}
                        <a href="{{ route('admin.products.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah
                        </a>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                @if($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk Info</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga (IDR)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Stok</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas (QR)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($products as $product)
                                <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">

                                    {{-- Info Produk --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-14 w-14 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow">
                                                @if($product->image)
                                                    <img class="h-14 w-14 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs text-center font-medium bg-gray-50">No<br>Img</div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ Str::limit($product->name, 25) }}</div>
                                                <div class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded-md inline-block mt-1 border border-gray-200">
                                                    {{ $product->sku }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>

                                    {{-- Harga --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm font-bold text-gray-900">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">Beli: {{ number_format($product->buy_price, 0, ',', '.') }}</div>
                                    </td>

                                    {{-- Stok (Logic Warna) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($product->current_stock <= $product->min_stock)
                                            <div class="inline-flex flex-col items-center">
                                                <span class="px-3 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full border border-red-200 flex items-center gap-1 animate-pulse shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    {{ $product->current_stock }} {{ $product->unit }}
                                                </span>
                                                <span class="text-[10px] text-red-500 font-semibold mt-1">Stok Menipis!</span>
                                            </div>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full border border-green-200 shadow-sm">
                                                {{ $product->current_stock }} {{ $product->unit }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- QR Code (Pop-up Modal) --}}
                                    <td class="px-6 py-4 whitespace-nowrap" x-data="{ open: false }">
                                        {{-- Kartu QR (Klik untuk Buka) --}}
                                        <div @click="open = true" class="flex items-center gap-3 p-2 bg-white border border-gray-200 rounded-lg shadow-sm w-fit mx-auto group hover:border-indigo-300 hover:shadow-md transition-all cursor-pointer" title="Klik untuk memperbesar">
                                            <div class="bg-gray-50 p-1 rounded border group-hover:bg-white">
                                                {!! QrCode::size(35)->color(50, 50, 50)->generate($product->sku) !!}
                                            </div>
                                            <div class="text-left">
                                                <div class="text-[10px] text-gray-400 font-bold uppercase">Scan Me</div>
                                                <div class="text-xs font-mono font-bold text-gray-800">{{ $product->sku }}</div>
                                            </div>
                                        </div>

                                        {{-- Modal QR Code --}}
                                        <div x-show="open"
                                             class="fixed inset-0 z-50 overflow-y-auto"
                                             style="display: none;">
                                            {{-- Backdrop --}}
                                            <div class="fixed inset-0 bg-gray-900/75 transition-opacity" @click="open = false"></div>

                                            {{-- Modal Content --}}
                                            <div class="flex min-h-full items-center justify-center p-4 text-center">
                                                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-sm" @click.away="open = false">
                                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                        <div class="flex flex-col items-center">
                                                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $product->name }}</h3>
                                                            <div class="p-4 bg-white border-2 border-gray-100 rounded-xl shadow-inner mb-4">
                                                                {!! QrCode::size(200)->generate($product->sku) !!}
                                                            </div>
                                                            <p class="text-sm text-gray-500 font-mono bg-gray-100 px-3 py-1 rounded-full mb-6">{{ $product->sku }}</p>

                                                            <div class="mt-6 flex w-full gap-3">
                                                                {{-- Tombol Tutup --}}
                                                                <button @click="open = false" type="button" class="flex-1 inline-flex justify-center items-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                                                    Tutup
                                                                </button>

                                                                {{-- Tombol Cetak Label --}}
                                                                <a href="{{ route('admin.products.printBarcode', $product->id) }}" target="_blank" class="flex-1 inline-flex justify-center items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                                    Cetak Label
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Aksi (Tanpa Tombol QR) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 border border-yellow-200 transition shadow-sm" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-200 transition shadow-sm" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $products->withQueryString()->links() }}
                    </div>

                @else
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-16">
                        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-sm">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Belum ada produk</h3>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto">Mulai tambahkan produk pertama Anda untuk mengisi inventori gudang.</p>
                        <a href="{{ route('admin.products.create') }}" class="mt-6 inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold text-sm transition-all shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5">
                            Tambah Produk Sekarang &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
