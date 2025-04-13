@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Data Penilaian</h1>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" id="searchInput" placeholder="Cari nama karyawan atau penilai..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <!-- Tambah Penilaian -->
        <a href="{{ route('admin.penilaian.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center text-center">
            <i class="fas fa-plus"></i>
            <span class="ml-2">Tambah Penilaian</span>
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="penilaianTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penilai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="penilaianTableBody">
                @foreach ($penilaians as $index => $penilaian)
                <tr class="penilaian-row" data-date="{{ $penilaian->tanggal_penilaian }}">
                    <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->karyawan->user->nama }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->penilai->nama }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->tanggal_penilaian }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->periode }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->total_skor }}</td>
                    <td class="px-6 py-4 text-sm">{{ $penilaian->keterangan }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.penilaian.show', $penilaian->id_penilaian) }}" class="text-yellow-600 hover:underline mr-2"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.penilaian.edit', $penilaian->id_penilaian) }}" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.penilaian.destroy', $penilaian->id_penilaian) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-600 hover:underline delete-button"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($penilaians->isEmpty())
                <tr>
                    <td colspan="8" class="text-center px-6 py-4 text-gray-500">Belum ada data penilaian.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="w-full flex justify-end mt-2">
            {{ $penilaians->links() }}
        </div>
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

    // Delete button
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Filter fungsi
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const date = document.getElementById('dateFilter').value;

        document.querySelectorAll(".penilaian-row").forEach(row => {
            const karyawan = row.children[1]?.textContent.toLowerCase();
            const penilai = row.children[2]?.textContent.toLowerCase();
            const show = (!search || karyawan.includes(search) || penilai.includes(search)) &&
                         (!date || row.dataset.date === date);
            row.style.display = show ? '' : 'none';
        });
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('dateFilter').addEventListener('change', filterTable);
    document.getElementById('resetFilter').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('dateFilter').value = '';
        filterTable();
    });
</script>
@endsection
