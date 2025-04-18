@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Penilaian untuk {{ $jurnal->karyawan->user->nama }}</h1>

    <form action="{{ route('penilai.penilaian.store', $jurnal->id_jurnal) }}" method="POST">
        @csrf
        <input type="hidden" name="id_karyawan" value="{{ $jurnal->karyawan->id_karyawan }}">
        {{-- <input type="hidden" name="id_jurnal" value="{{ $jurnal->id_jurnal }}"> --}}
        {{-- @dd($jurnal->id_jurnal) --}}

        @foreach ($kategoris as $kategori)
            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ $kategori->nama_kategori }}</label>
                <input type="number" name="kategori_penilaian[{{ $kategori->id_kategori }}]" min="0" max="100"
            class="w-full border rounded px-3 py-2" required>

        @endforeach



        <div class="mb-4">
            <label for="catatan" class="block font-medium text-gray-700">Catatan</label>
            <textarea name="catatan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Simpan Penilaian
            </button>
        </div>
    </form>
</div>
@endsection
