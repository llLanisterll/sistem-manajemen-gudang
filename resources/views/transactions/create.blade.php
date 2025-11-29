<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('staff.transactions.store') }}" method="POST">
                    @csrf

                    {{-- Header Form --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold mb-2">Tipe Transaksi</label>
                            <select name="type" id="type" class="w-full border rounded px-3 py-2" onchange="toggleType()">
                                <option value="in">Barang Masuk (Dari Supplier)</option>
                                <option value="out">Barang Keluar (Ke Customer)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Tanggal</label>
                            <input type="date" name="date" class="w-full border rounded px-3 py-2" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- Conditional Fields --}}
                    <div id="supplier-field" class="mb-6">
                        <label class="block text-sm font-bold mb-2">Pilih Supplier</label>
                        <select name="supplier_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="customer-field" class="mb-6 hidden">
                        <label class="block text-sm font-bold mb-2">Nama Customer / Tujuan</label>
                        <input type="text" name="customer_name" class="w-full border rounded px-3 py-2" placeholder="Nama Customer">
                    </div>

                    {{-- Product List (Dynamic) --}}
                    <div class="mb-6 border-t pt-4">
                        <h3 class="text-lg font-bold mb-2">Daftar Produk</h3>
                        <table class="w-full" id="product-table">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="p-2">Produk</th>
                                    <th class="p-2 w-32">Qty</th>
                                    <th class="p-2 w-20">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="product-list">
                                {{-- Baris Pertama Default --}}
                                <tr>
                                    <td class="p-2">
                                        <select name="products[]" class="w-full border rounded px-2 py-1" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($allProducts as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->current_stock }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="number" name="quantities[]" class="w-full border rounded px-2 py-1" min="1" value="1" required>
                                    </td>
                                    <td class="p-2">
                                        <button type="button" class="bg-red-500 px-2 py-1 rounded" onclick="removeRow(this)">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="mt-2 bg-green-500 px-3 py-1 rounded text-sm" onclick="addRow()">+ Tambah Baris Produk</button>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2">Catatan</label>
                        <textarea name="notes" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('staff.transactions.index') }}" class="bg-gray-500 px-4 py-2 rounded font-bold">Batal</a>
                        <button type="submit" class="bg-blue-600 px-4 py-2 rounded font-bold">Simpan Transaksi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Javascript Sederhana --}}
    <script>
        function toggleType() {
            const type = document.getElementById('type').value;
            if (type === 'in') {
                document.getElementById('supplier-field').classList.remove('hidden');
                document.getElementById('customer-field').classList.add('hidden');
            } else {
                document.getElementById('supplier-field').classList.add('hidden');
                document.getElementById('customer-field').classList.remove('hidden');
            }
        }

        function addRow() {
            const table = document.getElementById('product-list');
            const row = table.rows[0].cloneNode(true);
            // Reset values
            row.querySelector('select').value = '';
            row.querySelector('input').value = 1;
            table.appendChild(row);
        }

        function removeRow(btn) {
            const row = btn.parentNode.parentNode;
            const table = document.getElementById('product-list');
            if(table.rows.length > 1) {
                row.parentNode.removeChild(row);
            } else {
                alert("Minimal satu produk harus ada.");
            }
        }
    </script>
</x-app-layout>
