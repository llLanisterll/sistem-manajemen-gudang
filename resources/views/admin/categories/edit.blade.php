<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $category->description }}</textarea>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Saat Ini</label>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-32 h-32 object-cover rounded mb-2 border">
                        @else
                            <p class="text-gray-400 text-sm italic">Belum ada gambar.</p>
                        @endif

                        <label class="block text-gray-700 text-sm font-bold mb-2 mt-2">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900 font-bold py-2 px-4 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Kategori
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
