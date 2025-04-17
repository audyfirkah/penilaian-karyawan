@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container mx-auto px-4 space-y-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Karyawan</h1>

    {{-- Cards Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Total Jurnal</h2>
            <p class="text-2xl font-semibold text-blue-600">{{ $jumlahJurnal }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Approved</h2>
            <p class="text-2xl font-semibold text-green-600">{{ $jurnalApproved }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Pending</h2>
            <p class="text-2xl font-semibold text-yellow-500">{{ $jurnalPending }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Revisi</h2>
            <p class="text-2xl font-semibold text-red-500">{{ $jurnalRevisi }}</p>
        </div>
    </div>

    {{-- Tabel Jurnal --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Riwayat Jurnal</h2>
            <a href="{{ route('karyawan.jurnal.create', auth()->user()->karyawan->id_karyawan) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Jurnal
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm text-gray-700">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Aktivitas</th>
                        <th class="px-4 py-2">Lampiran</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($jurnals as $jurnal)
                    <tr>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $jurnal->aktivitas }}</td>
                        <td class="px-4 py-2">
                            @if($jurnal->lampiran)
                                <a href="{{ asset('storage/lampiran_jurnal/'.$jurnal->lampiran) }}" class="text-blue-600 hover:underline" target="_blank">Lihat</a>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $statusClass = match($jurnal->status) {
                                    'approved' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'revisi' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs rounded {{ $statusClass }}">{{ ucfirst($jurnal->status) }}</span>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('karyawan.jurnal.edit', $jurnal->id_jurnal) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('karyawan.jurnal.destroy', $jurnal->id_jurnal) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus jurnal ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data jurnal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jurnals->links() }}
        </div>
    </div>
</div>
@endsection
