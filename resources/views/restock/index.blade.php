<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Restock Orders (PO)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Purchase Orders</h3>
                    @if(Auth::user()->role === 'manager')
                        <a href="{{ route('manager.restock.create') }}" class="bg-blue-600 px-4 py-2 rounded font-bold hover:bg-blue-700">
                            + Buat Order Baru
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No. PO</th>
                                <th class="py-3 px-6 text-left">
                                    {{ Auth::user()->role === 'manager' ? 'Supplier' : 'Manager' }}
                                </th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($orders as $order)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 font-bold">{{ $order->po_number }}</td>
                                <td class="py-3 px-6">
                                    {{ Auth::user()->role === 'manager' ? $order->supplier->name : $order->manager->name }}
                                </td>
                                <td class="py-3 px-6">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                        {{ $order->status === 'pending' ? 'bg-yellow-200 text-yellow-700' : '' }}
                                        {{ $order->status === 'confirmed' ? 'bg-blue-200 text-blue-700' : '' }}
                                        {{ $order->status === 'received' ? 'bg-green-200 text-green-700' : '' }}
                                        {{ $order->status === 'rejected' ? 'bg-red-200 text-red-700' : '' }}
                                    ">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $prefix = Auth::user()->role === 'manager' ? 'manager' : 'supplier';
                                    @endphp
                                    <a href="{{ route($prefix.'.restock.show', $order->id) }}" class="text-blue-500 font-bold hover:underline">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
