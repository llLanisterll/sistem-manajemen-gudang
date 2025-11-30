<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                {{-- Icon Header --}}
                @if($transaction->type == 'in')
                    <span class="bg-green-100 text-green-600 p-2 rounded-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg></span>
                @else
                    <span class="bg-red-100 text-red-600 p-2 rounded-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg></span>
                @endif
                {{ __('Detail Transaksi') }} <span class="text-gray-400 font-normal ml-1">#{{ $transaction->transaction_number }}</span>
            </h2>

            {{-- Tombol Kembali --}}
            @php
                $backRoute = Auth::user()->role === 'manager'
                    ? route('manager.transactions.index')
                    : route('staff.transactions.index');
                if(Auth::user()->role === 'admin') $backRoute = route('manager.transactions.index');
            @endphp
            <a href="{{ $backRoute }}" class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Section --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: INFO UTAMA (2/3 Lebar) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- CARD 1: STATUS & JUDUL --}}
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 relative">
                        {{-- Aksen Warna di Kiri --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $transaction->type == 'in' ? 'bg-green-500' : 'bg-red-500' }}"></div>

                        <div class="p-6 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-4">
                            {{-- Status Visual (Centered) --}}
                            <div class="flex flex-col w-full md:w-auto">
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-2">Status Transaksi</p>
                                @php
                                    $statusClass = match($transaction->status) {
                                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'verified', 'approved' => 'bg-green-50 text-green-700 border-green-200',
                                        'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-50 text-gray-700'
                                    };
                                    $statusIcon = match($transaction->status) {
                                        'pending' => '⏳',
                                        'verified', 'approved' => '✅',
                                        'rejected' => '❌',
                                        default => '⚪'
                                    };
                                    $statusLabel = match($transaction->status) {
                                        'pending' => 'MENUNGGU PERSETUJUAN',
                                        'verified' => 'TERVERIFIKASI (MASUK)',
                                        'approved' => 'DISETUJUI (KELUAR)',
                                        'rejected' => 'DITOLAK',
                                        default => strtoupper($transaction->status)
                                    };
                                @endphp
                                <h1 class="text-xl md:text-2xl font-extrabold uppercase px-6 py-3 rounded-xl border {{ $statusClass }} flex items-center justify-center gap-2 shadow-sm">
                                    <span>{{ $statusIcon }}</span> {{ $statusLabel }}
                                </h1>
                            </div>

                            <div class="text-center md:text-right border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 w-full md:w-auto">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Transaksi</p>
                                <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i WIB') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: TABEL PRODUK --}}
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Rincian Barang
                            </h3>
                            <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-2 py-1 rounded">{{ $transaction->details->count() }} Item</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($transaction->details as $detail)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 mr-3">
                                                    @if($detail->product->image)
                                                        <img src="{{ asset('storage/' . $detail->product->image) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="flex items-center justify-center h-full text-[10px] text-gray-400 text-center">No Pic</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-800 text-sm block">{{ $detail->product->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $detail->product->category->name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-mono text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded border">
                                                {{ $detail->product->sku }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-lg font-bold {{ $transaction->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $detail->quantity }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-1">{{ $detail->product->unit }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- CARD 3: CATATAN --}}
                    @if($transaction->notes)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Catatan / Keterangan
                        </h4>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-gray-600 text-sm italic">
                            "{{ $transaction->notes }}"
                        </div>
                    </div>
                    @endif

                </div>

                {{-- KOLOM KANAN: SIDEBAR INFO & ACTION (1/3 Lebar) --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- ACTION PANEL (Manager Only) --}}
                    @if(Auth::user()->role === 'manager' && $transaction->status === 'pending')
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-indigo-100 p-6 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>

                            <h4 class="text-lg font-bold text-gray-800 mb-2">Tindakan Diperlukan</h4>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                                Transaksi ini menunggu persetujuan Anda. Pastikan data barang dan jumlah sudah sesuai sebelum menyetujui.
                            </p>

                            <div class="space-y-3">
                                {{-- Tombol Approve (PERBAIKAN WARNA) --}}
                                <form action="{{ route('manager.transactions.updateStatus', $transaction->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $transaction->type == 'in' ? 'verified' : 'approved' }}">

                                    {{-- Menggunakan BG Hijau Muda & Teks Hijau Tua agar kontras --}}
                                    <button class="w-full py-3 bg-green-100 hover:bg-green-200 text-green-800 border border-green-200 text-sm font-bold rounded-xl shadow-sm transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui Transaksi
                                    </button>
                                </form>

                                {{-- Tombol Reject --}}
                                <form action="{{ route('manager.transactions.updateStatus', $transaction->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="w-full py-3 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 text-sm font-bold rounded-xl shadow-sm transition flex justify-center items-center gap-2" onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- INFO PIHAK TERKAIT --}}
                    <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">
                            {{ $transaction->type == 'in' ? 'Supplier' : 'Customer' }}
                        </h4>

                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full {{ $transaction->type == 'in' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center font-bold text-xl shadow-sm">
                                {{ substr($transaction->type == 'in' ? ($transaction->supplier->name ?? 'S') : ($transaction->customer_name ?? 'C'), 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 leading-tight text-lg">
                                    {{ $transaction->type == 'in' ? ($transaction->supplier->name ?? 'Supplier Hapus') : $transaction->customer_name }}
                                </p>
                                <p class="text-xs text-gray-500 font-medium">
                                    {{ $transaction->type == 'in' ? 'Penyedia Barang' : 'Penerima Barang' }}
                                </p>
                            </div>
                        </div>

                        @if($transaction->type == 'in' && $transaction->supplier)
                            <div class="space-y-3 text-sm text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="flex gap-2 items-center"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $transaction->supplier->email }}</p>
                                <p class="flex gap-2 items-start"><svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{Str::limit($transaction->supplier->address ?? '-', 30) }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- INFO PEMBUAT --}}
                    <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">
                            Dibuat Oleh
                        </h4>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold shadow-sm">
                                {{ substr($transaction->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $transaction->user->name }}</p>
                                <p class="text-xs text-blue-600 font-bold uppercase bg-blue-50 px-2 py-0.5 rounded-full inline-block mt-0.5">{{ $transaction->user->role }}</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
