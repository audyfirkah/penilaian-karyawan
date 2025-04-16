@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 ">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Karyawan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Jumlah Jurnal</h2>
            <p class="text-2xl text-orange-600 mt-2">{{ $jumlahJurnal }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-7xl mx-auto space-y-6 my-4">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Data Jurnal</h1>
    </div>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex gap-2 w-full">
            <input type="text" id="searchInput" placeholder="Cari aktivitas..." class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="flex w-full justify-end">
            <a href="{{ route('karyawan.jurnal.create', Auth::user()->karyawan->id_karyawan) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="jurnalTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aktivitas</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Lampiran</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="jurnalTableBody">
                @forelse ($jurnals as $index => $jurnal)
                <tr data-date="{{ $jurnal->tanggal }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $jurnal->aktivitas }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if ($jurnal->lampiran)
                        <a href="{{ asset('storage/lampiran_jurnal/' . $jurnal->lampiran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                        @else
                        <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 space-x-2">
                        <a href="{{ route('karyawan.jurnal.edit', $jurnal->id_jurnal) }}" class="inline-flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('karyawan.jurnal.destroy', $jurnal->id_jurnal) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="inline-flex items-center bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data jurnal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
