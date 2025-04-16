@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Kepala Sekolah</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Total Laporan</h2>
            <p class="text-2xl text-orange-600 mt-2">{{ $jumlahLaporan }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Total Penilaian</h2>
            <p class="text-2xl text-red-600 mt-2">{{ $jumlahPenilaian }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-4">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Data Penilaian karyawan</h1>

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
                    <td class="px-6 py-4 text-sm space-x-2 flex items-center gap-2">
                            <a href="{{ route('penilai.penilaian.create', $user->karyawan->id_karyawan) }}" class="block rounded p-2 bg-green-100 hover:bg-green-300 text-green-600">
                                <i class="fas fa-star mr-1"></i> Nilai
                            </a>
                            {{-- <a href="{{ route('penilai.karyawan.detail', $user->karyawan) }}" class="block rounded p-2 bg-yellow-100 hover:bg-yellow-300 text-yellow-600">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a> --}}
                    </td>

                </tr>
                @endforeach
                @if($karyawans->isEmpty())
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada data penilai.karyawan.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="w-full flex justify-end mt-2">
            {{ $karyawans->links() }}
        </div>
    </div>
</div>

</div>
@endsection

@section('scripts')

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
