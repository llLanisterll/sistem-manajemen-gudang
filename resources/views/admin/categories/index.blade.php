<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Tombol Tambah --}}
                <div class="flex justify-between mb-6">
                    <h3 class="text-lg font-bold">Daftar Kategori</h3>
                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                        + Tambah Kategori
                    </a>
                </div>

                {{-- Alert Pesan Sukses/Gagal --}}
                @if ($message = Session::get('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ $message }}
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ $message }}
                    </div>
                @endif

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Gambar</th>
                                <th class="py-3 px-6 text-left">Nama</th>
                                <th class="py-3 px-6 text-left">Deskripsi</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($categories as $category)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" class="w-12 h-12 object-cover rounded border">
                                    @else
                                        <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left font-medium">{{ $category->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $category->description }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
