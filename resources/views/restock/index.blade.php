<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'manager' ? __('Daftar Restock Orders (PO)') : __('Pesanan Masuk (PO)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-full text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-400 hover:text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                {{-- Header Card --}}
                <div class="px-6 py-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </span>
                            {{ Auth::user()->role === 'manager' ? 'Permintaan Pembelian (PO)' : 'Daftar Pesanan Masuk' }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 ml-11">
                            {{ Auth::user()->role === 'manager' ? 'Kelola pembelian barang ke supplier.' : 'Daftar pesanan baru yang perlu diproses.' }}
                        </p>
                    </div>

                    {{-- Tombol Buat Baru (Hanya Manager) --}}
                    @if(Auth::user()->role === 'manager')
                        <a href="{{ route('manager.restock.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-yellow-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-yellow-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat PO Baru
                        </a>
                    @endif
                </div>

                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. PO</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">{{ Auth::user()->role === 'manager' ? 'Supplier Tujuan' : 'Dari Manager' }}</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Estimasi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                <tr class="group hover:bg-yellow-50/40 transition-colors duration-200">

                                    {{-- No. PO --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $order->po_number }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $order->details->count() }} Item</div>
                                    </td>

                                    {{-- Pihak Terkait --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                                {{ substr(Auth::user()->role === 'manager' ? ($order->supplier->name ?? 'N/A') : ($order->manager->name ?? 'N/A'), 0, 1) }}
                                            </div>
                                            {{ Auth::user()->role === 'manager' ? ($order->supplier->name ?? 'N/A') : ($order->manager->name ?? 'N/A') }}
                                        </div>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Est: {{ $order->expected_delivery_date ? \Carbon\Carbon::parse($order->expected_delivery_date)->format('d M') : 'TBA' }}
                                        </div>
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClass = match($order->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                                'confirmed' => 'bg-indigo-100 text-indigo-700 border border-indigo-200',
                                                'in_transit' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                                'received' => 'bg-green-100 text-green-700 border border-green-200',
                                                'rejected' => 'bg-red-100 text-red-700 border border-red-200',
                                                default => 'bg-gray-100 text-gray-700 border border-gray-200'
                                            };
                                            $statusLabel = match($order->status) {
                                                'pending' => 'MENUNGGU',
                                                'confirmed' => 'DIKONFIRMASI',
                                                'in_transit' => 'DIKIRIM',
                                                'received' => 'DITERIMA',
                                                'rejected' => 'DITOLAK',
                                                default => strtoupper($order->status)
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-[10px] font-extrabold uppercase tracking-wide rounded-full {{ $statusClass }} shadow-sm">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Rating --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($order->rating)
                                            <div class="flex items-center justify-center gap-1 bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100 w-fit mx-auto">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                <span class="text-xs font-bold text-gray-700">{{ $order->rating }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-300 text-lg">•</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @php
                                            $prefix = Auth::user()->role === 'manager' ? 'manager' : 'supplier';
                                        @endphp
                                        <a href="{{ route($prefix . '.restock.show', $order->id) }}" class="inline-flex items-center px-4 py-1.5 text-xs font-bold text-gray-700 bg-white rounded-xl hover:bg-yellow-50 hover:text-yellow-700 transition-all duration-200 border border-gray-200 hover:border-yellow-300 shadow-sm hover:shadow group" title="Lihat Detail">
                                            Detail
                                            <svg class="w-3 h-3 ml-1 text-gray-400 group-hover:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $orders->links() }}
                    </div>

                @else
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-16 bg-white">
                        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-sm">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Tidak Ada Pesanan</h3>
                        @if(Auth::user()->role === 'manager')
                            <p class="text-gray-500 mt-2 max-w-sm mx-auto text-sm">Mulai buat PO pertama Anda untuk mengisi inventori.</p>
                            <a href="{{ route('manager.restock.create') }}" class="mt-6 inline-flex items-center px-5 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-semibold text-sm transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5">
                                Buat PO Baru
                            </a>
                        @else
                            <p class="text-gray-500 mt-2 max-w-sm mx-auto text-sm">Belum ada pesanan masuk dari Manager saat ini.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
