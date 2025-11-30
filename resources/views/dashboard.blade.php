<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- WELCOME MESSAGE (Semua Role) --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 mb-8 border border-gray-100 relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full opacity-10 blur-3xl"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-800 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500 mt-2 text-lg">Selamat datang kembali di panel <span class="font-bold uppercase text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $role }}</span>.</p>
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-sm text-gray-400 uppercase font-bold tracking-wider">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- CONTENT BASED ON ROLE --}}

            {{-- 1. ADMIN DASHBOARD --}}
            @if($role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Users</h4>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $data['total_users'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Produk</h4>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $data['total_products'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Kategori</h4>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $data['total_categories'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Admin: Recent Products --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-lg mb-6 text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Produk Terbaru Ditambahkan
                    </h3>
                    <div class="space-y-4">
                        @foreach($data['recent_products'] as $p)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center border border-gray-200">
                                        @if($p->image)
                                            <img src="{{ asset('storage/' . $p->image) }}" class="h-full w-full object-cover rounded-lg">
                                        @else
                                            <span class="text-xs text-gray-400">IMG</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $p->name }}</p>
                                        <p class="text-xs text-gray-500 font-mono">{{ $p->sku }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $p->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>


            {{-- 2. MANAGER DASHBOARD --}}
            @elseif($role === 'manager')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Total Item Fisik</h4>
                        <p class="text-3xl font-black text-gray-800">{{ $data['total_stock'] }} <span class="text-sm font-medium text-gray-400">Unit</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 bg-red-50/30">
                        <h4 class="text-red-500 text-xs font-bold uppercase tracking-wider mb-2">Stok Menipis</h4>
                        <p class="text-3xl font-black text-red-600">{{ $data['low_stock_count'] }} <span class="text-sm font-medium text-red-400">Item</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-yellow-100 bg-yellow-50/30">
                        <h4 class="text-yellow-600 text-xs font-bold uppercase tracking-wider mb-2">Perlu Approval</h4>
                        <p class="text-3xl font-black text-yellow-600">{{ $data['pending_transactions'] }} <span class="text-sm font-medium text-yellow-500">Trx</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">PO Pending</h4>
                        <p class="text-3xl font-black text-indigo-600">{{ $data['pending_restocks'] }} <span class="text-sm font-medium text-gray-400">Order</span></p>
                    </div>
                </div>

                {{-- Manager: Low Stock Alert Table --}}
                @if($data['low_stock_count'] > 0)
                <div class="bg-white border border-red-100 rounded-2xl p-6 shadow-sm mb-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">Peringatan: Stok Produk Rendah!</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-red-50 text-red-800 uppercase text-xs font-bold">
                                <tr>
                                    <th class="p-4 rounded-l-xl">Produk</th>
                                    <th class="p-4 text-center">Min. Stok</th>
                                    <th class="p-4 text-center">Stok Saat Ini</th>
                                    <th class="p-4 rounded-r-xl text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                @foreach($data['low_stock_items'] as $item)
                                <tr class="hover:bg-red-50/50 transition">
                                    <td class="p-4 font-bold text-gray-700">{{ $item->name }}</td>
                                    <td class="p-4 text-center text-gray-500">{{ $item->min_stock }}</td>
                                    <td class="p-4 text-center font-extrabold text-red-600">{{ $item->current_stock }}</td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('manager.restock.create') }}" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200 transition">
                                            Restock Now &rarr;
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif


            {{-- 3. STAFF DASHBOARD (DESAIN BARU) --}}
            @elseif($role === 'staff')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: STATISTIK & ACTION --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Stats Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Card 1 --}}
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 relative overflow-hidden group hover:shadow-md transition">
                                <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                                <div class="relative z-10">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Transaksi Hari Ini</h4>
                                    </div>
                                    <p class="text-4xl font-black text-gray-800 mt-2">{{ $data['my_transactions_today'] }} <span class="text-sm font-medium text-gray-400">Item</span></p>
                                </div>
                            </div>

                            {{-- Card 2 --}}
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 relative overflow-hidden group hover:shadow-md transition">
                                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
                                <div class="relative z-10">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Kontribusi</h4>
                                    </div>
                                    <p class="text-4xl font-black text-gray-800 mt-2">{{ $data['my_total_transactions'] }} <span class="text-sm font-medium text-gray-400">Trx</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Action (CTA) --}}
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 shadow-xl shadow-blue-500/30 flex flex-col md:flex-row justify-between items-center gap-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Catat Barang Baru?</h3>
                                <p class="text-blue-100">Segera catat barang masuk atau keluar untuk menjaga akurasi stok gudang.</p>
                            </div>
                            <a href="{{ route('staff.transactions.create') }}" class="px-6 py-3 bg-white text-blue-700 font-bold rounded-xl shadow-sm hover:bg-blue-50 hover:shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Buat Transaksi
                            </a>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: RECENT ACTIVITY --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 p-6 h-full">
                            <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Aktivitas Terakhir
                            </h3>

                            <div class="space-y-4">
                                @forelse($data['recent_transactions'] as $t)
                                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                        <div class="mt-1">
                                            @if($t->type == 'in')
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                </span>
                                            @else
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <p class="text-sm font-bold text-gray-800">{{ $t->transaction_number }}</p>
                                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $t->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600' }}">
                                                    {{ $t->status }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ $t->type == 'in' ? 'Barang Masuk' : 'Barang Keluar' }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 mt-1">{{ $t->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-sm text-gray-400">Belum ada aktivitas.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                                <a href="{{ route('staff.transactions.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                    Lihat Semua Riwayat &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            {{-- 4. SUPPLIER DASHBOARD --}}
            @elseif($role === 'supplier')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-yellow-100 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4"></div>
                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Pesanan Baru (Pending)</h4>
                        <p class="text-4xl font-black text-yellow-600 mt-2 relative z-10">{{ $data['new_orders'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Sedang Proses</h4>
                        <p class="text-4xl font-black text-blue-600 mt-2">{{ $data['in_progress'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100">
                        <h4 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Selesai Dikirim</h4>
                        <p class="text-4xl font-black text-green-600 mt-2">{{ $data['completed'] }}</p>
                    </div>
                </div>

                @if($data['new_orders'] > 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-2xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center">
                             <div class="bg-yellow-100 p-3 rounded-full mr-4 text-yellow-600">
                                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                             </div>
                             <div>
                                 <h3 class="text-lg font-bold text-yellow-800">Perhatian Diperlukan</h3>
                                 <p class="text-yellow-700">Anda memiliki <span class="font-bold">{{ $data['new_orders'] }} pesanan baru</span> yang perlu dikonfirmasi.</p>
                             </div>
                        </div>
                        <a href="{{ route('supplier.restock.index') }}" class="bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-yellow-600 shadow-lg shadow-yellow-500/30 transition transform hover:-translate-y-0.5">
                            Lihat Pesanan
                        </a>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
