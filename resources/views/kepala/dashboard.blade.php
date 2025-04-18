@extends('layouts.app')

@section('title', 'Dashboard Penilai')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard kepsek</h1>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold">Total Penilaian</h2>
            <p class="text-2xl text-blue-600">{{ $jumlahPenilaian }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold">Jumlah Kategori Penilaian</h2>
            <p class="text-2xl text-purple-600">{{ $jumlahKategori }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold">Belum Dinilai Bulan Ini</h2>
            <p class="text-2xl text-red-600">{{ $belumDinilai->count() }}</p>
        </div>
    </div>

    <!-- Tabel histori penilaian -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Histori Penilaian</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Tanggal</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Karyawan</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Penilai</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Skor</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($penilaians as $penilaian)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $penilaian->tanggal_penilaian }}</td>
                        <td class="px-6 py-4 text-sm">{{ $penilaian->karyawan->user->nama ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $penilaian->penilai->nama ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $penilaian->total_skor }}</td>
                        <td class="px-6 py-4 text-sm">{{ $penilaian->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $penilaians->links() }}
        </div>
    </div>

    <!-- Karyawan belum dinilai -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Karyawan Belum Dinilai Bulan Ini</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($belumDinilai as $karyawan)
            <div class="border p-4 rounded shadow flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $karyawan->user->nama }}</p>
                    <p class="text-sm text-gray-500">{{ $karyawan->divisi->nama_divisi ?? '-' }}</p>
                </div>
                <a href="{{ route('penilai.penilaian.create', $karyawan->id_karyawan) }}"
                   class="bg-blue-100 text-blue-600 px-3 py-2 rounded hover:bg-blue-200 transition">
                    Nilai Sekarang
                </a>
            </div>
            @empty
            <p class="text-gray-500">Semua karyawan sudah dinilai bulan ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
