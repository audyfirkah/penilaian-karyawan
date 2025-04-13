@extends('layouts.app')

@section('title', 'Edit Divisi')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Divisi</h1>

    <form action="{{ route('admin.divisi.update', $divisi->id_divisi) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_divisi" class="block text-gray-700 font-medium mb-1">Nama Divisi</label>
            <input type="text" name="nama_divisi" id="nama_divisi" value="{{ old('nama_divisi', $divisi->nama_divisi) }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label for="deskripsi" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-4 py-2 border rounded">{{ old('deskripsi', $divisi->deskripsi) }}</textarea>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.divisi.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
