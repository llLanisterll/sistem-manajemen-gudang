<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- WELCOME MESSAGE --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-b-2 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600">Anda login sebagai <span class="font-bold uppercase text-blue-600">{{ $role }}</span>.</p>
            </div>

            {{-- CONTENT BASED ON ROLE --}}

            {{-- 1. ADMIN DASHBOARD --}}
            @if($role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Users</h4>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['total_users'] }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Produk</h4>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['total_products'] }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Kategori</h4>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['total_categories'] }}</p>
                    </div>
                </div>

                {{-- Admin: Recent Products --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Produk Terbaru Ditambahkan</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($data['recent_products'] as $p)
                            <li class="py-3 flex justify-between">
                                <span class="text-gray-700 font-medium">{{ $p->name }}</span>
                                <span class="text-sm text-gray-500">{{ $p->created_at->format('d M Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>


            {{-- 2. MANAGER DASHBOARD --}}
            @elseif($role === 'manager')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-600">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Item Fisik</h4>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['total_stock'] }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Stok Menipis</h4>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ $data['low_stock_count'] }} <span class="text-sm font-normal text-gray-500">Item</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Perlu Approval</h4>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $data['pending_transactions'] }} <span class="text-sm font-normal text-gray-500">Trx</span></p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">PO Pending</h4>
                        <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $data['pending_restocks'] }} <span class="text-sm font-normal text-gray-500">Order</span></p>
                    </div>
                </div>

                {{-- Manager: Low Stock Alert Table --}}
                @if($data['low_stock_count'] > 0)
                <div class="bg-white border border-red-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                             {{-- Icon Alert --}}
                             <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="font-bold text-red-700 text-lg">Peringatan: Stok Produk Rendah!</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-red-50 text-red-800">
                                <tr>
                                    <th class="p-3 rounded-tl-lg">Produk</th>
                                    <th class="p-3">Min. Stok</th>
                                    <th class="p-3">Stok Saat Ini</th>
                                    <th class="p-3 rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['low_stock_items'] as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-3 font-medium text-gray-700">{{ $item->name }}</td>
                                    <td class="p-3 text-gray-600">{{ $item->min_stock }}</td>
                                    <td class="p-3 font-bold text-red-600">{{ $item->current_stock }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('manager.restock.create') }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">Restock &rarr;</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif


            {{-- 3. STAFF DASHBOARD --}}
            @elseif($role === 'staff')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Transaksi Hari Ini (Anda)</h4>
                        <p class="text-4xl font-bold text-gray-800 mt-2">{{ $data['my_transactions_today'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-gray-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Transaksi Dibuat</h4>
                        <p class="text-4xl font-bold text-gray-800 mt-2">{{ $data['my_total_transactions'] }}</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Aktivitas Terakhir Anda</h3>
                    @forelse($data['recent_transactions'] as $t)
                        <div class="border-b border-gray-100 py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded">
                            <div>
                                <span class="font-medium {{ $t->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $t->transaction_number }}
                                </span>
                                <span class="text-gray-600 ml-2 text-sm">({{ $t->type == 'in' ? 'Masuk' : 'Keluar' }})</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $t->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 italic">Belum ada aktivitas.</p>
                    @endforelse

                    <div class="mt-6">
                        <a href="{{ route('staff.transactions.create') }}" class="block w-full text-center bg-blue-600 px-4 py-2 rounded font-bold hover:bg-blue-700 transition">
                            + Buat Transaksi Baru
                        </a>
                    </div>
                </div>


            {{-- 4. SUPPLIER DASHBOARD --}}
            @elseif($role === 'supplier')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Pesanan Baru (Pending)</h4>
                        <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $data['new_orders'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Sedang Proses</h4>
                        <p class="text-4xl font-bold text-blue-600 mt-2">{{ $data['in_progress'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Selesai Dikirim</h4>
                        <p class="text-4xl font-bold text-green-600 mt-2">{{ $data['completed'] }}</p>
                    </div>
                </div>

                @if($data['new_orders'] > 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm mb-6 flex justify-between items-center">
                        <div class="flex items-center">
                             {{-- Icon Warning --}}
                             <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="text-yellow-800 font-medium">Anda memiliki {{ $data['new_orders'] }} pesanan baru yang perlu dikonfirmasi.</span>
                        </div>
                        <a href="{{ route('supplier.restock.index') }}" class="bg-yellow-500 px-4 py-2 rounded text-sm font-bold hover:bg-yellow-600">Lihat Pesanan</a>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
