@extends('layouts.app')

@section('title', 'Data karyawan')

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
        <a href="{{ route('admin.karyawan.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center text-center">
            <i class="fas fa-plus"></i>
            <span class="ml-2">Tambah karyawan</span>
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="karyawanTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Foto</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Divisi</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal Masuk</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="karyawanTableBody">
                @foreach ($karyawans as $index => $user)
                <tr class="karyawan-row" data-date="{{ $user->karyawan->tgl_masuk }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 name">
                        <img src="{{ $user->karyawan->foto_profil ? asset('storage/images/foto_profil/' . $user->karyawan->foto_profil) : asset('default-avatar.png') }}" alt="{{ $user->nama }}"
                            class="w-10 h-10 rounded-full">
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 name">{{ $user->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 email">
                        {{ $user->karyawan->divisi->nama_divisi ? $user->karyawan->divisi->nama_divisi : 'Tidak ada divisi' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 capitalize">{{ $user->karyawan->tgl_masuk }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 overflow-visible" x-data="{ open: false,  dropUp: false }">
                        <button
                            @click="
                                const rect = $el.getBoundingClientRect();
                                dropUp = window.innerHeight - rect.bottom < 200; // jika kurang dari 200px ke bawah, naik
                                open = !open;
                            "
                            class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded flex items-center gap-1">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md z-10">
                            <a href="{{ route('admin.karyawan.edit', $user->id_user) }}" class="block px-4 py-2 border-b border-gray-100 hover:bg-blue-100 text-blue-600">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.karyawan.detail', $user->karyawan) }}" class="block px-4 py-2 border-b border-gray-100 hover:bg-yellow-100 text-yellow-600">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                            <form action="{{ route('admin.karyawan.destroy', $user->id_user) }}" method="POST" class="block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="cursor-pointer w-full text-left px-4 py-2 hover:bg-red-100 text-red-600 delete-button">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
                @if($karyawans->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data admin.karyawan.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="w-full flex justify-end mt-2">
            {{ $karyawans->links() }}
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
