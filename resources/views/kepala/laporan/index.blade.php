@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-6xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Laporan Karyawan</h1>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between w-full gap-4 mb-6">
        <div class="flex items-center gap-2 w-full">
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select id="periodeFilter" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Semua Periode</option>
                <option value="bulanan">Bulanan</option>
                <option value="semesteran">Semesteran</option>
                <option value="tahunan">Tahunan</option>
            </select>
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <div class="flex w-full justify-end">
            <a href="{{ route('kepala.laporan.list') }}" class="bg-green-500 text-white hover:bg-green-700 p-2 mr-3 rounded">+ Tambah</a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="laporanTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama Karyawan</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Jenis</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="laporanTableBody">
                @foreach ($laporans as $index => $laporan)
                <tr class="laporan-row" data-created="{{ $laporan->created_at }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $laporan->karyawan->user->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 capitalize">{{ $laporan->periode }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $laporan->jenis }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('laporan.export', $laporan->id_laporan) }}" target="_blank"
                        class="inline-flex items-center bg-indigo-100 text-indigo-600 px-3 py-1 rounded hover:bg-indigo-200 transition">
                            <i class="fas fa-file-export mr-1"></i> Generate
                        </a>

                    </td>
                </tr>
                @endforeach
                @if($laporans->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data laporan.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>

<script>
// Filter fungsi
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const date = document.getElementById('dateFilter').value;
    const periode = document.getElementById('periodeFilter').value.toLowerCase();

    document.querySelectorAll("tbody tr").forEach(row => {
        const name = row.children[1]?.textContent.toLowerCase();
        const email = row.children[2]?.textContent.toLowerCase();
        const periodeData = row.children[2]?.textContent.toLowerCase();
        const show = (!search || name.includes(search) || email.includes(search)) &&
                     (!periode || periodeData === periode) &&
                     (!date || row.dataset.date === date);
        row.style.display = show ? '' : 'none';
    });
}

// Event listeners
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('dateFilter').addEventListener('change', filterTable);
document.getElementById('periodeFilter').addEventListener('change', filterTable);
document.getElementById('resetFilter').addEventListener('click', () => {
    document.getElementById('searchInput').value = '';
    document.getElementById('dateFilter').value = '';
    document.getElementById('periodeFilter').value = '';
    filterTable();
});
</script>
@endsection
