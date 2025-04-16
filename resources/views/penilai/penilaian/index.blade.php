@extends('layouts.app')
@section('title', 'Penilaian')
@section('content')


<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Data karyawan</h1>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <!-- Add karyawan Button -->
        <a href="{{ route('penilai.penilaian.list') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center text-center">
            <i class="fas fa-plus"></i>
            <span class="ml-2">Tambah Penilaian</span>
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="karyawanTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">tanggal penilaian</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama penilai</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="karyawanTableBody">
                @foreach ($penilaians as $index => $data)
                <tr class="penilaian-row" data-date="{{ $data->created_at }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 capitalize">{{ \Carbon\Carbon::parse($data->tanggal_penilaian)->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 name">{{ $data->karyawan->user->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 name">{{ $data->penilai->nama }}</td>
                   <td class="px-6 py-4 text-sm space-x-2 flex items-center gap-2">
                        <a href="{{ route('penilai.penilaian.detail', $data->id_penilaian) }}" class="cursor-pointer inline-flex items-center bg-yellow-100 text-yellow-600 px-3 py-1 rounded hover:bg-yellow-200 transition">
                            <i class="fas fa-eye mr-1"></i>
                        </a>
                        {{-- <a href="{{ route('penilai.penilaian.edit', $data->id_penilaian) }}" class="cursor-pointer inline-flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">
                            <i class="fas fa-edit mr-1"></i>
                        </a>
                        <form action="{{ route('penilai.penilaian.destroy', $data->id_penilaian) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="cursor-pointer delete-button inline-flex items-center bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition">
                                <i class="fas fa-trash mr-1"></i>
                            </button>
                        </form> --}}
                    </td>
                </tr>
                @endforeach
                @if($penilaians->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data penilai.penilaian.</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{-- <div class="w-full flex justify-end mt-2">
            {{ $penilaians->links() }}
        </div> --}}
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
</script>

<script>
    // Filter fungsi
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const date = document.getElementById('dateFilter').value;

        document.querySelectorAll("tbody tr").forEach(row => {
            const name = row.children[1]?.textContent.toLowerCase();
            const email = row.children[2]?.textContent.toLowerCase();
            const show = (!search || name.includes(search) || email.includes(search)) &&
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
