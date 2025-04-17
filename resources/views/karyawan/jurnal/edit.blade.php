@extends('layouts.app')

@section('title', 'Edit Jurnal')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Jurnal</h1>

    <form action="{{ route('karyawan.jurnal.update', Auth::user()->karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Aktivitas -->
        <div class="mb-4">
            <label for="aktivitas" class="block text-sm font-medium text-gray-700">Aktivitas</label>
            <textarea name="aktivitas" id="aktivitas" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">{{ old('aktivitas', $jurnal->aktivitas) }}</textarea>
            @error('aktivitas')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Lampiran -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Lampiran Saat Ini</label>
            @if ($jurnal->lampiran)
                <a href="{{ asset('storage/lampiran_jurnal/' . $jurnal->lampiran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Lampiran</a>
            @else
                <p class="text-gray-500 italic">Tidak ada lampiran</p>
            @endif
        </div>

        <div class="mb-6">
            <label for="lampiran" class="block text-sm font-medium text-gray-700">Ganti Lampiran (Opsional)</label>
            <input type="file" name="lampiran" id="lampiran" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('lampiran')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="flex items-center justify-between">
            <a href="{{ route('karyawan.jurnal.show', Auth::user()->karyawan->id_karyawan) }}" class="text-gray-600 hover:underline"><i class="fas fa-arrow-left"></i> Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
