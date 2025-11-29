<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- HEADER AREA --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold">Riwayat Transaksi</h3>

                    <div class="flex gap-2">
                        {{-- TOMBOL EXPORT (Admin & Manager) --}}
                        @if(in_array(Auth::user()->role, ['admin', 'manager']))
                            @php
                                $exportRoute = Auth::user()->role === 'admin'
                                    ? route('admin.transactions.export')
                                    : route('manager.transactions.export');
                            @endphp

                            <a href="{{ $exportRoute }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center shadow transition transform hover:-translate-y-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Export Laporan
                            </a>
                        @endif

                        {{-- TOMBOL BUAT TRANSAKSI (Staff) --}}
                        @if(Auth::user()->role === 'staff')
                            <a href="{{ route('staff.transactions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition transform hover:-translate-y-1">
                                + Buat Transaksi Baru
                            </a>
                        @endif
                    </div>
                </div>

                {{-- TAB NAVIGATION (TAB LOGIC) --}}
                <div class="flex border-b border-gray-200 mb-6">
                    <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}"
                       class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                       {{ !request('type') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        📋 Semua Transaksi
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['type' => 'in']) }}"
                       class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                       {{ request('type') == 'in' ? 'border-green-500 text-green-600 bg-green-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        ⬇️ Barang Masuk
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['type' => 'out']) }}"
                       class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                       {{ request('type') == 'out' ? 'border-red-500 text-red-600 bg-red-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        ⬆️ Barang Keluar
                    </a>
                </div>

                {{-- ALERT MESSAGES --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal font-bold">
                                <th class="py-3 px-6 text-left">No. Transaksi</th>
                                <th class="py-3 px-6 text-left">Tipe</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Tujuan/Asal</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse ($transactions as $trx)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-6 text-left font-bold text-gray-700">
                                    {{ $trx->transaction_number }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="{{ $trx->type == 'in' ? 'text-green-700 bg-green-100 border border-green-200' : 'text-red-700 bg-red-100 border border-red-200' }} py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                        {{ $trx->type == 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $trx->type == 'in' ? ($trx->supplier->name ?? 'Supplier Hapus') : $trx->customer_name }}
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $statusClass = match($trx->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                            'verified', 'approved' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                            'rejected' => 'bg-red-100 text-red-700 border border-red-200',
                                            default => 'bg-gray-100 text-gray-700 border border-gray-200'
                                        };

                                        $statusIcon = match($trx->status) {
                                            'pending' => '⏳',
                                            'verified', 'approved' => '✅',
                                            'rejected' => '❌',
                                            default => '⚪'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide flex items-center justify-center gap-1 w-fit mx-auto">
                                        <span>{{ $statusIcon }}</span> {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        // Logic agar Admin juga bisa klik detail (menggunakan route manager sebagai fallback)
                                        $prefix = Auth::user()->role === 'staff' ? 'staff' : 'manager';

                                        // Admin pakai route manager.transactions.show
                                        if(Auth::user()->role === 'admin') $prefix = 'manager';
                                    @endphp
                                    <a href="{{ route($prefix . '.transactions.show', $trx->id) }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline flex items-center justify-center gap-1">
                                        Detail <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        <p>Belum ada data transaksi.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
