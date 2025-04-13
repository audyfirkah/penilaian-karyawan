@extends('layouts.app')

@section('title', 'Kategori Penilaian')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Data Kategori Penilaian</h1>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" id="searchInput" placeholder="Cari kategori..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <!-- Add Kategori Button -->
        <a href="{{ route('admin.kategori-penilaian.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center text-center">
            <i class="fas fa-plus"></i>
            <span class="ml-2">Tambah Kategori</span>
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="kategoriTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bobot</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200" id="kategoriTableBody">
                @foreach ($kategoris as $index => $kategori)
                <tr class="kategori-row">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $kategori->bobot }}%</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $kategori->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm space-x-2 flex items-center gap-2">
                        <a href="{{ route('admin.kategori-penilaian.edit', $kategori->id_kategori) }}"  class="inline-flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">
                            <i class="fas fa-edit mr-1"></i>
                        </a>
                        <form action="{{ route('admin.kategori-penilaian.destroy', $kategori->id_kategori) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-button inline-flex items-center bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition">
                                <i class="fas fa-trash mr-1"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($kategoris->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data kategori penilaian.</td>
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

        document.querySelectorAll("tbody tr").forEach(row => {
            const kategoriName = row.children[1]?.textContent.toLowerCase();
            const show = !search || kategoriName.includes(search);
            row.style.display = show ? '' : 'none';
        });
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('resetFilter').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        filterTable();
    });
</script>
@endsection
