<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi: {{ $transaction->transaction_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Status Bar --}}
                <div class="mb-6 border-b pb-4 flex justify-between items-center">
                    <div>
                        <span class="text-sm text-gray-500">Status Saat Ini</span>
                        <br>
                        <span class="text-xl font-bold uppercase
                            {{ $transaction->status == 'pending' ? 'text-yellow-600' :
                              ($transaction->status == 'rejected' ? 'text-red-600' : 'text-green-600') }}">
                            {{ $transaction->status }}
                        </span>
                    </div>

                    {{-- TOMBOL APPROVAL MANAGER --}}
                    @if(Auth::user()->role === 'manager' && $transaction->status === 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('manager.transactions.updateStatus', $transaction->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded" onclick="return confirm('Tolak transaksi ini?')">
                                    Tolak (Reject)
                                </button>
                            </form>

                            <form action="{{ route('manager.transactions.updateStatus', $transaction->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $transaction->type == 'in' ? 'verified' : 'approved' }}">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 font-bold py-2 px-4 rounded" onclick="return confirm('Setujui transaksi ini? Stok akan otomatis diperbarui.')">
                                    Setujui (Approve)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Dibuat Oleh:</p>
                        <p class="font-bold">{{ $transaction->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal:</p>
                        <p class="font-bold">{{ $transaction->date }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tipe:</p>
                        <p class="font-bold">{{ $transaction->type == 'in' ? 'Barang Masuk (Incoming)' : 'Barang Keluar (Outgoing)' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Keterangan:</p>
                        <p class="font-bold">{{ $transaction->type == 'in' ? 'Dari Supplier: ' . ($transaction->supplier->name ?? '-') : 'Ke Customer: ' . $transaction->customer_name }}</p>
                    </div>
                </div>

                {{-- Tabel Detail Produk --}}
                <h3 class="font-bold mb-2">Detail Produk</h3>
                <table class="min-w-full border border-gray-200 mb-6">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left border">Produk</th>
                            <th class="p-2 text-center border">SKU</th>
                            <th class="p-2 text-center border">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->details as $detail)
                        <tr>
                            <td class="p-2 border">{{ $detail->product->name }}</td>
                            <td class="p-2 text-center border">{{ $detail->product->sku }}</td>
                            <td class="p-2 text-center border font-bold">{{ $detail->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Transaksi</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
