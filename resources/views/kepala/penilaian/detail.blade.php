@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Detail Penilaian</h1>

    <div class="flex items-center space-x-6 mb-6">
        <!-- Foto Profil -->
        <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden">
            <img src="{{ asset('storage/images/foto_profil/' . $penilaian->karyawan->user->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
        </div>

        <!-- Nama, Total Skor, Keterangan -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $penilaian->karyawan->user->nama }}</h2>
            <div class="mt-2">
                <div class="text-xl font-bold text-gray-800">Total Skor: {{ $penilaian->total_skor }}</div>

                <!-- Conditional Keterangan dengan warna -->
                @if ($penilaian->total_skor >= 8)
                    <div class="text-md mt-2 text-green-500">Sangat Baik</div>
                @elseif ($penilaian->total_skor >= 7)
                    <div class="text-md mt-2 text-yellow-500">Baik</div>
                @elseif ($penilaian->total_skor >= 5)
                    <div class="text-md mt-2 text-orange-500">Cukup</div>
                @else
                    <div class="text-md mt-2 text-red-500">Perlu Peningkatan</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Penilaian -->
    <div class="mb-6">
        <h3 class="font-semibold text-lg text-gray-800">Penilai :
            {{ $penilaian->penilai->nama }}
        </h3>
        <table class="w-full table-auto border border-gray-300 mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Kategori</th>
                    <th class="border px-4 py-2">Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaian->detailPenilaians as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $detail->kategori->nama_kategori }}</td>
                        <td class="border px-4 py-2">{{ $detail->skor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-6 w-full justify-start flex">
        <a href="{{ route('penilai.penilaian.index') }}" class=" text-gray-900"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>
@endsection
