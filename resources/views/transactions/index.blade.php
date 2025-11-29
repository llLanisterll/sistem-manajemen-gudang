<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- HEADER & TOMBOL ACTION --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold">Riwayat Transaksi</h3>

                    <div class="flex gap-2">
                        {{-- TOMBOL EXPORT: Muncul Khusus Admin & Manager --}}
                        @if(in_array(Auth::user()->role, ['admin', 'manager']))
                            @php
                                // Pilih rute export sesuai role yang sedang login
                                $exportRoute = Auth::user()->role === 'admin'
                                    ? route('admin.transactions.export')
                                    : route('manager.transactions.export');
                            @endphp

                            <a href="{{ $exportRoute }}" class="bg-green-600 hover:bg-green-700 font-bold py-2 px-4 rounded flex items-center shadow">
                                {{-- Icon Download --}}
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Export Laporan
                            </a>
                        @endif

                        {{-- TOMBOL BUAT BARU: Muncul Khusus Staff --}}
                        @if(Auth::user()->role === 'staff')
                            <a href="{{ route('staff.transactions.create') }}" class="bg-blue-600 hover:bg-blue-700 font-bold py-2 px-4 rounded shadow">
                                + Buat Transaksi Baru
                            </a>
                        @endif
                    </div>
                </div>

                {{-- PESAN ALERT --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No. Transaksi</th>
                                <th class="py-3 px-6 text-left">Tipe</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Tujuan/Asal</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($transactions as $trx)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left font-bold">{{ $trx->transaction_number }}</td>
                                <td class="py-3 px-6 text-left">
                                    <span class="{{ $trx->type == 'in' ? 'text-green-600 bg-green-200' : 'text-red-600 bg-red-200' }} py-1 px-3 rounded-full text-xs font-bold uppercase">
                                        {{ $trx->type == 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left">{{ $trx->date }}</td>
                                <td class="py-3 px-6 text-left">
                                    {{ $trx->type == 'in' ? ($trx->supplier->name ?? 'Supplier Hapus') : $trx->customer_name }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $statusClass = match($trx->status) {
                                            'pending' => 'bg-yellow-200 text-yellow-700',
                                            'verified', 'approved' => 'bg-green-200 text-green-700',
                                            'rejected' => 'bg-red-200 text-red-700',
                                            default => 'bg-gray-200'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs font-bold uppercase">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        // Logic agar Admin juga bisa klik detail (menggunakan route manager)
                                        $prefix = Auth::user()->role === 'staff' ? 'staff' : 'manager';
                                    @endphp
                                    <a href="{{ route($prefix . '.transactions.show', $trx->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $transactions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
