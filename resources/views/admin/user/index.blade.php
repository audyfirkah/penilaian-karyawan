@extends('layouts.app')

@section('title', 'Data User')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Data User</h1>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <!-- Search -->
        <div class="flex items-center gap-2">
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select id="roleFilter" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="kepala sekolah">Kepala Sekolah</option>
                <option value="karyawan">Karyawan</option>
                <option value="penilai">Penilai</option>
            </select>
            <button id="resetFilter" class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 transition flex items-center text-center">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <!-- Add User Button -->
        <a href="{{ route('admin.user.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center text-center">
            <i class="fas fa-plus"></i>
            <span class="ml-2">Tambah User</span>
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden" id="userTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="userTableBody">
                @foreach ($users as $index => $user)
                <tr class="user-row" data-created="{{ $user->created_at }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 name">{{ $user->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 email">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 capitalize">{{ $user->role }}</td>
                    <td class="px-6 py-4 text-sm space-x-2 flex items-center gap-2">
                        <a href="{{ route('admin.user.edit', $user->id_user) }}" class="cursor-pointer inline-flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">
                            <i class="fas fa-edit mr-1"></i>
                        </a>
                        <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="cursor-pointer delete-button inline-flex items-center bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition">
                                <i class="fas fa-trash mr-1"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
                @if($users->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data admin.user.</td>
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
        const date = document.getElementById('dateFilter').value;
        const role = document.getElementById('roleFilter').value.toLowerCase();

        document.querySelectorAll("tbody tr").forEach(row => {
            const name = row.children[1]?.textContent.toLowerCase();
            const email = row.children[2]?.textContent.toLowerCase();
            const userRole = row.children[3]?.textContent.toLowerCase();
            const show = (!search || name.includes(search) || email.includes(search)) &&
                         (!role || userRole === role) &&
                         (!date || row.dataset.date === date);
            row.style.display = show ? '' : 'none';
        });
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('dateFilter').addEventListener('change', filterTable);
    document.getElementById('roleFilter').addEventListener('change', filterTable);
    document.getElementById('resetFilter').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('dateFilter').value = '';
        document.getElementById('roleFilter').value = '';
        filterTable();
    });


</script>


@endsection
