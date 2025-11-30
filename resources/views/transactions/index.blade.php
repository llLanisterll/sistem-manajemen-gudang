<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                {{-- HEADER & TOOLBAR --}}
                <div class="px-6 py-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </span>
                            Riwayat Transaksi
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 ml-11">Monitoring keluar masuk barang secara real-time.</p>
                    </div>

                    {{-- TOMBOL ACTION --}}
                    <div class="flex gap-3">
                        {{-- TOMBOL EXPORT (Admin & Manager) --}}
                        @if(in_array(Auth::user()->role, ['admin', 'manager']))
                            @php
                                $exportRoute = Auth::user()->role === 'admin'
                                    ? route('admin.transactions.export')
                                    : route('manager.transactions.export');
                            @endphp

                            <a href="{{ $exportRoute }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-green-500/30 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Export Laporan
                            </a>
                        @endif

                        {{-- TOMBOL BUAT TRANSAKSI (Staff) --}}
                        @if(Auth::user()->role === 'staff')
                            <a href="{{ route('staff.transactions.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Buat Transaksi
                            </a>
                        @endif
                    </div>
                </div>

                {{-- TAB NAVIGATION (FILTER) --}}
                <div class="px-6 border-b border-gray-200">
                    <div class="flex">
                        <a href="{{ request()->fullUrlWithQuery(['type' => null, 'page' => 1]) }}"
                           class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                           {{ !request('type') ? 'border-blue-600 text-blue-600 bg-blue-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                            📋 Semua Transaksi
                        </a>

                        <a href="{{ request()->fullUrlWithQuery(['type' => 'in', 'page' => 1]) }}"
                           class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                           {{ request('type') == 'in' ? 'border-green-500 text-green-600 bg-green-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                            ⬇️ Barang Masuk
                        </a>

                        <a href="{{ request()->fullUrlWithQuery(['type' => 'out', 'page' => 1]) }}"
                           class="py-2 px-4 font-medium text-sm border-b-2 transition-colors duration-300
                           {{ request('type') == 'out' ? 'border-red-500 text-red-600 bg-red-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                            ⬆️ Barang Keluar
                        </a>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
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
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($transactions as $trx)
                            <tr class="border-b border-gray-200 hover:bg-blue-50/30 transition-colors">
                                <td class="py-3 px-6 text-left font-bold text-gray-700">
                                    {{ $trx->transaction_number }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="{{ $trx->type == 'in' ? 'text-green-700 bg-green-100 border border-green-200' : 'text-red-700 bg-red-100 border border-red-200' }} py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide shadow-sm">
                                        {{ $trx->type == 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $trx->user->name }}</div>
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
                                    <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide flex items-center justify-center gap-1 w-fit mx-auto shadow-sm">
                                        <span>{{ $statusIcon }}</span> {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $prefix = Auth::user()->role === 'staff' ? 'staff' : 'manager';
                                        if(Auth::user()->role === 'admin') $prefix = 'manager';
                                    @endphp
                                    <a href="{{ route($prefix . '.transactions.show', $trx->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-gray-700 bg-white rounded-lg hover:bg-blue-100 border border-gray-300 shadow-sm hover:shadow-md transition-all duration-200" title="Lihat Detail & Ambil Aksi">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 bg-white">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-gray-500">Belum ada transaksi {{ request('type') == 'in' ? 'Barang Masuk' : (request('type') == 'out' ? 'Barang Keluar' : 'tercatat') }}.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
