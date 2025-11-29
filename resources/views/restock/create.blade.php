<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Permintaan Restock (PO)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('manager.restock.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Pilih Supplier</label>
                            <select name="supplier_id" class="w-full border rounded px-3 py-2" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Estimasi Tgl Pengiriman</label>
                            <input type="date" name="expected_delivery_date" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Catatan</label>
                        <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <h3 class="font-bold mb-2">Daftar Produk yang Dipesan</h3>
                        <table class="w-full" id="po-table">
                            <thead class="bg-gray-100 text-left">
                                <tr>
                                    <th class="p-2">Produk</th>
                                    <th class="p-2 w-32">Qty Request</th>
                                    <th class="p-2 w-20"></th>
                                </tr>
                            </thead>
                            <tbody id="po-list">
                                <tr>
                                    <td class="p-2">
                                        <select name="products[]" class="w-full border rounded px-2 py-1" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }} (Current: {{ $p->current_stock }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="number" name="quantities[]" class="w-full border rounded px-2 py-1" min="1" value="10" required>
                                    </td>
                                    <td class="p-2">
                                        <button type="button" class="text-red-500 font-bold" onclick="removeRow(this)">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="mt-2 text-sm text-blue-600 font-bold hover:underline" onclick="addRow()">+ Tambah Produk Lain</button>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('manager.restock.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-bold">Batal</a>
                        <button type="submit" class="bg-blue-600 px-4 py-2 rounded font-bold">Buat PO</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function addRow() {
            const list = document.getElementById('po-list');
            const row = list.rows[0].cloneNode(true);
            row.querySelector('select').value = '';
            row.querySelector('input').value = 10;
            list.appendChild(row);
        }
        function removeRow(btn) {
            const row = btn.parentNode.parentNode;
            if(document.getElementById('po-list').rows.length > 1) row.remove();
        }
    </script>
</x-app-layout>
