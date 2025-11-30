<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('staff.transactions.store') }}" method="POST">
                @csrf

                {{-- CARD 1: INFORMASI DASAR --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </span>
                            Informasi Transaksi
                        </h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tipe Transaksi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Transaksi</label>
                            <div class="relative">
                                <select name="type" id="type" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm py-3 bg-gray-50 text-gray-800 font-medium transition-all" onchange="toggleType()">
                                    <option value="in">Barang Masuk (Dari Supplier)</option>
                                    <option value="out">Barang Keluar (Ke Customer)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Transaksi</label>
                            <input type="date" name="date" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm py-2.5" value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Supplier (Muncul saat Barang Masuk) --}}
                        <div id="supplier-field" class="md:col-span-2 transition-all duration-300">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Supplier</label>
                            <select name="supplier_id" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm py-2.5">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Customer (Muncul saat Barang Keluar) --}}
                        <div id="customer-field" class="md:col-span-2 hidden transition-all duration-300">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Customer / Tujuan</label>
                            <input type="text" name="customer_name" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm py-2.5" placeholder="Contoh: PT. Maju Mundur atau Bpk. Budi">
                        </div>
                    </div>
                </div>

                {{-- CARD 2: DAFTAR BARANG --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-purple-100 text-purple-600 p-1.5 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </span>
                            Item Barang
                        </h3>
                        <button type="button" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition shadow-sm" onclick="addRow()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="p-6">
                        <table class="w-full" id="product-table">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                    <th class="pb-3 pl-2 w-7/12">Produk</th>
                                    <th class="pb-3 w-3/12">Quantity</th>
                                    <th class="pb-3 w-2/12 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="product-list" class="divide-y divide-gray-100">
                                {{-- Baris Pertama (Template) --}}
                                <tr class="group">
                                    <td class="py-3 pr-4">
                                        <select name="products[]" class="w-full border-gray-200 rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm py-2 shadow-sm" required>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($allProducts as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->name }} (Stok: {{ $p->current_stock }} {{ $p->unit }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="relative">
                                            <input type="number" name="quantities[]" class="w-full border-gray-200 rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm py-2 shadow-sm text-center font-bold" min="1" value="1" required>
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

                        <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3 shadow-sm">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="text-sm text-yellow-700">
                                <strong>Catatan:</strong> Transaksi akan berstatus <span class="font-bold uppercase bg-yellow-200 px-1 rounded text-[10px]">Pending</span> sampai disetujui oleh Manager.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: CATATAN & SUBMIT --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 flex flex-col">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm py-2.5" rows="3" placeholder="Contoh: Barang diterima dalam kondisi baik..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('staff.transactions.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm transform">
                            Batal
                        </a>
                        <div class="text-sm font-semibold  bg-purple-600 rounded-xl  hover:bg-purple-500 text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition shadow-lg shadow-purple-500/30 transform hover:-translate-y-0.5">
                            <button type="submit" class="px-6 py-2 ">
                                Simpan Transaksi
                            </button>
                         </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Javascript Logic (Dipertahankan) --}}
    <script>
        function toggleType() {
            const type = document.getElementById('type').value;
            const supplierField = document.getElementById('supplier-field');
            const customerField = document.getElementById('customer-field');

            if (type === 'in') {
                supplierField.classList.remove('hidden');
                customerField.classList.add('hidden');
            } else {
                supplierField.classList.add('hidden');
                customerField.classList.remove('hidden');
            }
        }

        function addRow() {
            const table = document.getElementById('product-list');
            // Clone baris pertama sebagai template
            const row = table.rows[0].cloneNode(true);

            // Reset values di baris baru
            row.querySelector('select').value = '';
            row.querySelector('input[type="number"]').value = 1;

            table.appendChild(row);
        }

        function removeRow(btn) {
            const row = btn.parentNode.parentNode;
            const table = document.getElementById('product-list');
            if(table.rows.length > 1) {
                row.remove();
            } else {
                alert("Minimal satu produk harus ada.");
            }
        }
    </script>
</x-app-layout>
