@extends('layouts.app')

@section('title', 'Edit Kategori Penilaian')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-2">Edit Kategori Penilaian</h1>
    <p class="text-sm text-red-600 mb-6"><i class="fas fa-info-circle"></i> Semua field wajib diisi sebelum menyimpan perubahan.</p>

    <form action="{{ route('admin.kategori-penilaian.update', $kategori->id_kategori) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_kategori" class="block text-gray-700 font-medium mb-1">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="w-full px-4 py-2 border rounded @error('nama_kategori') border-red-500 @enderror">
            @error('nama_kategori')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="bobot" class="block text-gray-700 font-medium mb-1">Bobot (%)</label>
            <input type="number" name="bobot" id="bobot" value="{{ old('bobot', $kategori->bobot) }}" class="w-full px-4 py-2 border rounded @error('bobot') border-red-500 @enderror" step="0.01" min="0" max="100">
            @error('bobot')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-4 py-2 border rounded @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.kategori-penilaian.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Update Kategori
            </button>
        </div>
    </form>
</div>
@endsection
