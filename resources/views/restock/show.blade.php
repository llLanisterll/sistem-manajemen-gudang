<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            PO Detail: {{ $restockOrder->po_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- STATUS & ACTION AREA --}}
                <div class="flex justify-between items-center border-b pb-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Status Pesanan</p>
                        <h1 class="text-3xl font-bold uppercase {{ $restockOrder->status == 'pending' ? 'text-yellow-600' : 'text-blue-600' }}">
                            {{ $restockOrder->status }}
                        </h1>
                    </div>

                    <div class="flex gap-2">
                        @php $role = Auth::user()->role; @endphp

                        {{-- AKSI UNTUK SUPPLIER --}}
                        @if($role === 'supplier' && $restockOrder->status === 'pending')
                            <form action="{{ route('supplier.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">Tolak Pesanan</button>
                            </form>
                            <form action="{{ route('supplier.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button class="bg-green-600 px-4 py-2 rounded hover:bg-green-700">Terima & Proses</button>
                            </form>

                        {{-- AKSI UNTUK MANAGER --}}
                        @elseif($role === 'manager')
                            @if($restockOrder->status === 'confirmed')
                                <form action="{{ route('manager.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="in_transit">
                                    <button class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">Tandai Sedang Dikirim</button>
                                </form>
                            @elseif($restockOrder->status === 'in_transit')
                                <form action="{{ route('manager.restock.updateStatus', $restockOrder->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="received">
                                    <button class="bg-green-600 px-4 py-2 rounded hover:bg-green-700">Tandai Barang Diterima</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="font-bold">Informasi Pesanan</p>
                        <p>Pembuat: {{ $restockOrder->manager->name }}</p>
                        <p>Tanggal: {{ $restockOrder->created_at->format('d M Y') }}</p>
                        <p>Estimasi: {{ $restockOrder->expected_delivery_date ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold">Supplier Tujuan</p>
                        <p>{{ $restockOrder->supplier->name }}</p>
                        <p>{{ $restockOrder->supplier->email }}</p>
                        <p>{{ $restockOrder->supplier->address ?? 'Alamat tidak tersedia' }}</p>
                    </div>
                </div>

                <h3 class="font-bold mb-2">Item Produk</h3>
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left">Produk</th>
                            <th class="p-2 text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($restockOrder->details as $detail)
                        <tr class="border-t">
                            <td class="p-2">{{ $detail->product->name }} (SKU: {{ $detail->product->sku }})</td>
                            <td class="p-2 text-center font-bold">{{ $detail->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($restockOrder->status === 'received' && $role === 'manager')
                    <div class="mt-6 bg-blue-50 p-4 rounded border border-blue-200">
                        <p class="text-blue-800 font-bold">⚠ Barang sudah diterima.</p>
                        <p class="text-sm text-blue-600">Jangan lupa minta Staff Gudang untuk menginput <b>Incoming Transaction</b> agar stok di sistem bertambah.</p>
                    </div>
                @endif

                {{-- RATING SECTION --}}
                @if($restockOrder->status === 'received')
                    <div class="mt-6 border-t pt-6">
                        <h3 class="font-bold text-lg mb-2">Penilaian Supplier</h3>

                        {{-- KONDISI 1: SUDAH ADA RATING --}}
                        @if($restockOrder->rating)
                            <div class="flex items-center p-4 bg-yellow-50 rounded border border-yellow-200">
                                <span class="text-gray-700 mr-3 font-bold">Rating Diberikan:</span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-8 h-8 {{ $i <= $restockOrder->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 font-bold text-yellow-600 text-xl">({{ $restockOrder->rating }}/5)</span>
                            </div>

                        {{-- KONDISI 2: BELUM ADA RATING (Hanya Manager yg bisa isi) --}}
                        @elseif(Auth::user()->role === 'manager')
                            <div class="bg-gray-50 p-6 rounded border">
                                <p class="mb-4 text-gray-600">Bagaimana kinerja supplier untuk pesanan ini?</p>
                                <form action="{{ route('manager.restock.rate', $restockOrder->id) }}" method="POST" class="flex items-center gap-4">
                                    @csrf
                                    <select name="rating" class="border rounded px-4 py-2 text-lg">
                                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                        <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                        <option value="3">⭐⭐⭐ (Cukup)</option>
                                        <option value="2">⭐⭐ (Kurang)</option>
                                        <option value="1">⭐ (Buruk)</option>
                                    </select>
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 font-bold py-2 px-6 rounded shadow">
                                        Kirim Rating
                                    </button>
                                </form>
                            </div>

                        {{-- KONDISI 3: SUPPLIER MELIHAT (Belum dirating) --}}
                        @else
                            <p class="text-gray-400 italic">Belum ada penilaian.</p>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
