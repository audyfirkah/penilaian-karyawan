@extends('layouts.app')

@section('title', 'Tambah Jurnal')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Jurnal</h1>

    <form action="{{ route('karyawan.jurnal.store', Auth::user()->karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Tanggal -->
        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            @error('tanggal')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Aktivitas -->
        <div class="mb-4">
            <label for="aktivitas" class="block text-sm font-medium text-gray-700">Aktivitas</label>
            <textarea name="aktivitas" id="aktivitas" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">{{ old('aktivitas') }}</textarea>
            @error('aktivitas')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Lampiran -->
        <div class="mb-6">
            <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran (Opsional)</label>
            <input type="file" name="lampiran" id="lampiran" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('lampiran')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="flex items-center justify-between">
            <a href="{{ route('karyawan.jurnal.show', Auth::user()->karyawan->id_karyawan) }}" class="text-gray-600 hover:underline"><i class="fas fa-arrow-left"></i> Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-1"></i> Simpan Jurnal
            </button>
        </div>
    </form>
</div>
@endsection
