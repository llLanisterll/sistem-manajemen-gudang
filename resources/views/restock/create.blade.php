<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Permintaan Restock (PO)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('manager.restock.store') }}" method="POST">
                @csrf

                {{-- CARD 1: INFO PESANAN & SUPPLIER --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        {{-- Header Icon Biru --}}
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2-4h10a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6a2 2 0 012-2z"></path></svg>
                            </span>
                            Detail Purchase Order (PO)
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Pilih Supplier --}}
                            <div>
                                <label for="supplier_id" class="block text-sm font-bold text-gray-700 mb-2">Pilih Supplier <span class="text-red-500">*</span></label>
                                {{-- Focus Ring Biru --}}
                                <select name="supplier_id" id="supplier_id" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-2.5 shadow-sm" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Estimasi Tgl Pengiriman --}}
                            <div>
                                <label for="expected_delivery_date" class="block text-sm font-bold text-gray-700 mb-2">Estimasi Tgl Pengiriman</label>
                                {{-- Focus Ring Biru --}}
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 py-2.5 shadow-sm">
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">Catatan (Opsional)</label>
                            {{-- Focus Ring Biru --}}
                            <textarea name="notes" id="notes" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 p-3 shadow-sm" rows="3" placeholder="Contoh: Harap kirimkan dengan prioritas..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: DAFTAR PRODUK --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        {{-- Header Icon Biru --}}
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </span>
                            Produk yang Diperlukan
                        </h3>
                        {{-- Tombol Tambah Produk Biru --}}
                        <button type="button" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition" onclick="addRow()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div class="p-6">
                        <table class="w-full" id="po-table">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                    <th class="pb-3 pl-2 w-7/12">Produk</th>
                                    <th class="pb-3 w-3/12">Qty Request</th>
                                    <th class="pb-3 w-2/12 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="po-list" class="divide-y divide-gray-50">
                                {{-- Baris Pertama (Template) --}}
                                <tr class="group">
                                    <td class="py-3 pr-4">
                                        {{-- Focus Ring Indigo/Ungu (Dibiarkan untuk variasi warna produk) --}}
                                        <select name="products[]" class="w-full border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 shadow-sm" required>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }} (Stok Saat Ini: {{ $p->current_stock }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="relative">
                                            {{-- Focus Ring Indigo/Ungu (Dibiarkan) --}}
                                            <input type="number" name="quantities[]" class="w-full border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 shadow-sm text-center font-bold" min="1" value="10" required>
                                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-xs text-gray-400">Pcs</div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <button type="button" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" onclick="removeRow(this)" title="Hapus Baris">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- CARD 3: FOOTER ACTIONS --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 flex justify-end">
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 w-full">
                        <a href="{{ route('manager.restock.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm transform">
                            Batal
                        </a>
                        <div class="text-sm font-semibold  bg-purple-600 rounded-xl  hover:bg-purple-500 text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition shadow-lg shadow-purple-500/30 transform hover:-translate-y-0.5">
                            <button type="submit" class="px-6 py-2 ">
                                Simpan Kategori
                            </button>
                         </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- Javascript Logic (Dipertahankan) --}}
    <script>
        function addRow() {
            const list = document.getElementById('po-list');
            // Clone baris pertama sebagai template
            const row = list.rows[0].cloneNode(true);

            // Reset values di baris baru
            row.querySelector('select').value = '';
            row.querySelector('input[type="number"]').value = 10;

            list.appendChild(row);
        }

        function removeRow(btn) {
            const row = btn.parentNode.parentNode;
            const table = document.getElementById('po-list');
            if(table.rows.length > 1) {
                row.remove();
            } else {
                alert("Minimal satu produk harus ada dalam pesanan.");
            }
        }
    </script>
</x-app-layout>
