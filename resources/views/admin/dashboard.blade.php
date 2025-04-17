@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Total Laporan</h2>
            <p class="text-2xl text-orange-600 mt-2">{{ $jumlahLaporan }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Total Penilaian</h2>
            <p class="text-2xl text-red-600 mt-2">{{ $jumlahPenilaian }}</p>
        </div>
    </div>

    <!-- Filter Bulan -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <label for="filterMonth" class="text-gray-700 font-semibold mr-2">Pilih Bulan:</label>
            <input type="month" id="filterMonth" value="{{ request('bulan') }}" class="border px-2 py-1 rounded-md focus:ring focus:ring-blue-300">
        </div>
        <div>
            <a href="{{ route('admin.export.jurnal', ['bulan' => request('bulan')]) }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow">
                Export PDF
            </a>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Statistik Jurnal per Divisi</h2>
        <canvas id="jurnalChart"></canvas>
    </div>

    <!-- Tabel Jurnal Belum Disetujui -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Jumlah Jurnal Terisi per Divisi
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Karyawan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Divisi</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Aktivitas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
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
                            <td class="px-4 py-2 text-sm">
                                {{ $jurnal->aktivitas }}
                                @if ($jurnal->lampiran)
                                    <br>
                                    <a href="{{ asset('storage/' . $jurnal->lampiran) }}" class="text-blue-500 underline text-xs" target="_blank">Lihat Lampiran</a>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <span class="
                                    px-2 py-1 rounded text-white text-xs
                                    @if($jurnal->status == 'approved') bg-green-600
                                    @elseif($jurnal->status == 'pending') bg-yellow-500
                                    @else bg-red-600 @endif
                                ">
                                    {{ ucfirst($jurnal->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <div class="mt-2 flex gap-1">
                                    <form action="{{ route('admin.jurnal.approve', $jurnal->id_jurnal) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded">Approve</button>
                                    </form>
                                    <button onclick="openModal({{ $jurnal->id_jurnal }})" class="text-sm bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">Revisi</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-2 text-gray-500">Semua jurnal telah disetujui</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $jurnals->links() }}
        </div>
    </div>
</div>



<!-- Modal Revisi -->
<div id="modalRevisi" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Catatan Revisi</h2>
        <form id="formRevisi" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Kirim Revisi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('jurnalChart').getContext('2d');
    const jurnalChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($jurnalByDivisi->pluck('divisi')) !!},
            datasets: [
                {
                    label: 'Approved',
                    data: {!! json_encode($jurnalByDivisi->pluck('approved')) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                },
                {
                    label: 'Pending',
                    data: {!! json_encode($jurnalByDivisi->pluck('pending')) !!},
                    backgroundColor: 'rgba(251, 191, 36, 0.7)',
                },
                {
                    label: 'Revisi',
                    data: {!! json_encode($jurnalByDivisi->pluck('revisi')) !!},
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Jumlah Jurnal Berdasarkan Status per Divisi'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Filter Bulan
    document.getElementById('filterMonth').addEventListener('change', function () {
        const month = this.value;
        window.location.href = `?bulan=${month}`;
    });
</script>

<script>
    function openModal(jurnalId) {
        const modal = document.getElementById('modalRevisi');
        const form = document.getElementById('formRevisi');
        form.action = '{{ route("admin.jurnal.revisi", ":id") }}'.replace(':id', jurnalId);

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('modalRevisi');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
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
@endsection
