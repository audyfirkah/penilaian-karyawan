@extends('layouts.app')
@section('title', 'Penilaian')
@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">

    <!-- Table -->

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" id="searchInput" placeholder="Cari ..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Jurnal Siap Dinilai</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Karyawan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Divisi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Aktivitas</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Lampiran</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jurnals as $index => $jurnal)
                    <tr>
                        <td class="px-4 py-2 text-sm">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-sm">{{ $jurnal->karyawan->user->nama ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $jurnal->karyawan->divisi->nama_divisi ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 text-sm">{{ $jurnal->aktivitas }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if ($jurnal->lampiran)
                                <a href="{{ asset('storage/' . $jurnal->lampiran) }}" class="text-blue-500 underline text-xs" target="_blank">Lihat Lampiran</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="mt-2 flex gap-1">
                                <a href="{{ route('penilai.penilaian.create', $jurnal->id_jurnal) }}" class="text-sm bg-green-100 hover:bg-green-200 text-green-600 px-2 py-1 rounded">Approve</a>
                                <button onclick="openRevisiModal({{ $jurnal->id_jurnal }})" class="text-sm bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">Revisi</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2 text-gray-500">Semua jurnal telah disetujui</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $jurnals->links() }}
    </div>
</div>

<!-- Modal Revisi -->
<div id="revisiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Kirim Jurnal ke Revisi</h2>
        <form id="revisiForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_jurnal" id="revisiJurnalId">
            <div class="mb-4">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Revisi</label>
                <textarea name="catatan" id="catatan" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRevisiModal()" class="bg-gray-300 text-gray-800 px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Kirim Revisi</button>
            </div>
        </form>
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

    function openRevisiModal(jurnalId) {
        document.getElementById('revisiJurnalId').value = jurnalId;
        document.getElementById('revisiForm').action = `/penilai/penilaian/${jurnalId}/revisi`;
        document.getElementById('revisiModal').classList.remove('hidden');
    }

    function closeRevisiModal() {
        document.getElementById('revisiModal').classList.add('hidden');
    }

    // Filter Table
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const date = document.getElementById('dateFilter').value;

        document.querySelectorAll("tbody tr").forEach(row => {
            const name = row.children[1]?.textContent.toLowerCase();
            const divisi = row.children[2]?.textContent.toLowerCase();
            const show = (!search || name.includes(search) || divisi.includes(search)) &&
                         (!date || row.dataset.date === date);
            row.style.display = show ? '' : 'none';
        });
    }

    // Event listeners
    document.getElementById('searchInput')?.addEventListener('input', filterTable);
    document.getElementById('dateFilter')?.addEventListener('change', filterTable);
    document.getElementById('resetFilter')?.addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('dateFilter').value = '';
        filterTable();
    });
</script>
@endsection
