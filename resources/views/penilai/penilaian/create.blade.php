@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Nilai {{ $karyawan->user->nama }}</h1>

    <form action="{{ route('penilai.penilaian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <input type="hidden" value="{{ $penilai->id_user }}" name="id_penilai">
        <input type="hidden" value="{{ $karyawan->id_karyawan }}" name="id_karyawan">

        @foreach ($kategoris as $kategori)
            <div>
                <label for="kategori_penilaian" class="block text-gray-700 font-medium mb-1">{{ $kategori->nama_kategori }}</label>
                <input type="number" name="kategori_penilaian" id="kategori_penilaian" value="{{ old('kategori_penilaian') }}"
                    class="w-full px-4 py-2 border rounded @error('kategori_penilaian') border-red-500 @enderror">
                @error('kategori_penilaian')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endforeach




        <div class="flex justify-between items-center">
            <a href="{{ route('penilai.penilaian.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan User
            </button>
        </div>
    </form>
</div>

@endsection
