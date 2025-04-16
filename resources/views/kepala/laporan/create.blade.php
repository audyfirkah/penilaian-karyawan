@extends('layouts.app')

@section('title', 'Tambah Laporan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Laporan Karyawan</h1>

    <form action="{{ route('kepala.laporan.store', $karyawan->id_karyawan) }}" method="POST" class="space-y-5">
        @csrf


        <div>
            <label for="periode" class="block text-gray-700 font-medium mb-1">Periode</label>
            <select name="periode" id="periode" class="w-full px-4 py-2 border rounded @error('periode') border-red-500 @enderror">
                <option value="">-- Pilih Periode --</option>
                <option value="bulanan" {{ old('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="semester" {{ old('periode') == 'semester' ? 'selected' : '' }}>Semester</option>
                <option value="tahunan" {{ old('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>
            @error('periode')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jenis" class="block text-gray-700 font-medium mb-1">Jenis Laporan</label>
            <input type="text" name="jenis" id="jenis" value="{{ old('jenis') }}" class="w-full px-4 py-2 border rounded @error('jenis') border-red-500 @enderror">
            @error('jenis')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('kepala.laporan.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan Laporan
            </button>
        </div>
    </form>
</div>
@endsection
