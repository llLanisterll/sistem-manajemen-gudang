<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                {{-- Icon Header --}}
                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                {{ __('Detail PO') }} <span class="text-gray-400 font-normal ml-1">#{{ $restockOrder->po_number }}</span>
            </h2>

            {{-- Tombol Kembali --}}
            @php
                $prefix = Auth::user()->role === 'manager' ? 'manager' : 'supplier';
            @endphp
            <a href="{{ route($prefix . '.restock.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
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
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: INFO UTAMA (2/3 Lebar) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- CARD 1: STATUS & JUDUL --}}
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 relative">
                        {{-- Aksen Warna di Kiri --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>

                        <div class="p-6 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-4">
                            {{-- Status Visual --}}
                            <div class="flex flex-col w-full md:w-auto">
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-2">Status Pesanan</p>
                                @php
                                    $statusClass = match($restockOrder->status) {
                                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'confirmed' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'in_transit' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'received' => 'bg-green-50 text-green-700 border-green-200',
                                        'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-50 text-gray-700'
                                    };
                                    $statusIcon = match($restockOrder->status) {
                                        'pending' => '⏳',
                                        'confirmed' => '👍',
                                        'in_transit' => '🚚',
                                        'received' => '📦',
                                        'rejected' => '❌',
                                        default => '⚪'
                                    };
                                    $statusLabel = match($restockOrder->status) {
                                        'pending' => 'MENUNGGU KONFIRMASI',
                                        'confirmed' => 'DIKONFIRMASI SUPPLIER',
                                        'in_transit' => 'SEDANG DIKIRIM',
                                        'received' => 'DITERIMA DI GUDANG',
                                        'rejected' => 'DITOLAK',
                                        default => strtoupper($restockOrder->status)
                                    };
                                @endphp
                                <h1 class="text-xl font-extrabold uppercase px-6 py-3 rounded-xl border {{ $statusClass }} flex items-center justify-center gap-2 shadow-sm">
                                    <span>{{ $statusIcon }}</span> {{ $statusLabel }}
                                </h1>
                            </div>

                            <div class="text-center md:text-right border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 w-full md:w-auto">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Order</p>
                                <p class="text-lg font-bold text-gray-800">{{ $restockOrder->created_at->format('d F Y') }}</p>
                                <p class="text-xs text-gray-500">Est. Kirim: <span class="font-bold text-blue-600">{{ $restockOrder->expected_delivery_date ?? 'TBA' }}</span></p>
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
                            <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $restockOrder->details->count() }} Item</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Qty Request</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($restockOrder->details as $detail)
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
                                            <span class="text-lg font-bold text-blue-600">
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

                    {{-- CARD 3: CATATAN & RATING --}}
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">

                        {{-- Catatan --}}
                        <div class="mb-6">
                            <h4 class="text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                Catatan Pesanan
                            </h4>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-gray-600 text-sm italic">
                                "{{ $restockOrder->notes ?? 'Tidak ada catatan tambahan.' }}"
                            </div>
                        </div>

                        {{-- RATING SECTION --}}
                        @if($restockOrder->status === 'received')
                            <div class="pt-4 border-t border-gray-100">
                                <h3 class="font-bold text-lg mb-4 text-gray-800">Penilaian Supplier</h3>

                                {{-- KONDISI 1: SUDAH ADA RATING --}}
                                @if($restockOrder->rating)
                                    <div class="flex items-center p-4 bg-blue-50 rounded-xl border border-blue-200 shadow-sm">
                                        <span class="text-gray-700 mr-4 font-bold text-sm uppercase tracking-wide">Rating:</span>
                                        <div class="flex gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-6 h-6 {{ $i <= $restockOrder->rating ? 'text-blue-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-auto font-bold text-blue-700 text-lg">({{ $restockOrder->rating }}/5)</span>
                                    </div>

                                {{-- KONDISI 2: BELUM ADA RATING (Hanya Manager) --}}
                                @elseif(Auth::user()->role === 'manager')
                                    <div class="p-6 bg-white border border-blue-100 rounded-xl shadow-sm">
                                        <p class="mb-4 text-gray-600 font-medium text-sm">Bagaimana performa supplier untuk pesanan ini?</p>
                                        <form action="{{ route('manager.restock.rate', $restockOrder->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                                            @csrf
                                            <select name="rating" class="w-full sm:w-auto border-gray-300 rounded-xl px-4 py-2.5 text-base focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                                <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                                <option value="2">⭐⭐ (Kurang)</option>
                                                <option value="1">⭐ (Buruk)</option>
                                            </select>
                                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                                                Kirim Penilaian
                                            </button>
                                        </form>
                                    </div>

                                {{-- KONDISI 3: SUPPLIER (Belum dinilai) --}}
                                @else
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-center text-gray-400 italic text-sm">
                                        Belum ada penilaian dari Manager.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>

                {{-- KOLOM KANAN: SIDEBAR INFO & ACTION (1/3 Lebar) --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- ACTION PANEL (Manager & Supplier) --}}
                    @php $role = Auth::user()->role; @endphp
                    @if(
                        ($role === 'manager' && in_array($restockOrder->status, ['confirmed', 'in_transit'])) ||
                        ($role === 'supplier' && $restockOrder->status === 'pending')
                    )
                        <div class="bg-white shadow-xl sm:rounded-2xl border border-indigo-100 p-6 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>

                            <h4 class="text-lg font-bold text-gray-800 mb-2">Tindakan Diperlukan</h4>
                            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                                Silakan proses status pesanan ini ke tahap selanjutnya.
                            </p>

                            <div class="space-y-3">
                                {{-- SUPPLIER ACTIONS --}}
                                @if($role === 'supplier' && $restockOrder->status === 'pending')
                                    <form action="{{ route('supplier.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button class="w-full py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                            ✅ Terima Pesanan
                                        </button>
                                    </form>
                                    <form action="{{ route('supplier.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="w-full py-3 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 text-sm font-bold rounded-xl shadow-sm transition flex justify-center items-center gap-2" onclick="return confirm('Yakin ingin menolak pesanan ini?')">
                                            ❌ Tolak Pesanan
                                        </button>
                                    </form>

                                {{-- MANAGER ACTIONS --}}
                                @elseif($role === 'manager')
                                    @if($restockOrder->status === 'confirmed')
                                        <form action="{{ route('manager.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="in_transit">
                                            <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                                🚚 Tandai Sedang Dikirim
                                            </button>
                                        </form>
                                    @elseif($restockOrder->status === 'in_transit')
                                        <form action="{{ route('manager.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="received">
                                            <button class="w-full py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2" onclick="return confirm('Barang diterima fisik? Stok belum bertambah otomatis.');">
                                                📦 Tandai Barang Diterima
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- INFO PIHAK TERKAIT --}}
                    <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">
                            {{ Auth::user()->role === 'manager' ? 'Informasi Supplier' : 'Dipesan Oleh' }}
                        </h4>

                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl shadow-sm">
                                {{ substr(Auth::user()->role === 'manager' ? $restockOrder->supplier->name : $restockOrder->manager->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 leading-tight text-lg">
                                    {{ Auth::user()->role === 'manager' ? $restockOrder->supplier->name : $restockOrder->manager->name }}
                                </p>
                                <p class="text-xs text-gray-500 font-medium">
                                    {{ Auth::user()->role === 'manager' ? 'Partner Supplier' : 'Warehouse Manager' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            @php $targetUser = Auth::user()->role === 'manager' ? $restockOrder->supplier : $restockOrder->manager; @endphp
                            <p class="flex gap-2 items-center"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $targetUser->email }}</p>
                            @if(Auth::user()->role === 'manager')
                                <p class="flex gap-2 items-start"><svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ Str::limit($targetUser->address ?? 'Alamat tidak tersedia', 30) }}</p>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
