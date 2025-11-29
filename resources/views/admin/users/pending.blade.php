<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Sukses Modern --}}
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
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </span>
                            Permintaan Akses Supplier
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 ml-11">Setujui atau tolak pendaftaran supplier baru.</p>
                    </div>
                    <div class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border shadow-sm">
                        Total Pending: <span class="font-bold text-blue-600">{{ $pendingSuppliers->count() }}</span>
                    </div>
                </div>

                @if($pendingSuppliers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User Profile</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($pendingSuppliers as $user)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                    {{-- Kolom Profile --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                {{-- Avatar Placeholder (Inisial) --}}
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full inline-block mt-1">
                                                    Supplier
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Kontak --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            {{ $user->email }}
                                        </div>
                                    </td>

                                    {{-- Kolom Tanggal --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            {{ $user->created_at->diffForHumans() }}
                                        </span>
                                        <div class="text-xs text-gray-400 mt-1 ml-1">
                                            {{ $user->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center gap-3">
                                            {{-- Tombol Approve --}}
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="group bg-white border border-green-200 text-green-600 hover:bg-green-500 hover:text-white hover:border-green-500 px-4 py-2 rounded-lg font-bold transition-all duration-300 shadow-sm flex items-center gap-2" title="Setujui Akun">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    <span>Approve</span>
                                                </button>
                                            </form>

                                            {{-- Tombol Reject --}}
                                            <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak dan menghapus pendaftaran ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group bg-white border border-red-200 text-red-600 hover:bg-red-500 hover:text-white hover:border-red-500 px-4 py-2 rounded-lg font-bold transition-all duration-300 shadow-sm flex items-center gap-2" title="Tolak Akun">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    <span>Reject</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- EMPTY STATE KEREN --}}
                    <div class="text-center py-16 bg-white">
                        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Semua Beres! 🎉</h3>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto">Tidak ada permintaan pendaftaran supplier baru saat ini. Semua akun telah diproses.</p>
                        <a href="{{ route('admin.dashboard') }}" class="mt-6 inline-block text-blue-600 font-bold hover:underline">
                            &larr; Kembali ke Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
