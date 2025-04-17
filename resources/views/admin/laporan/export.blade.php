<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan {{ $laporan->karyawan->user->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h2, h3 { margin-bottom: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Karyawan</h2>
        <p><strong>Nama:</strong> {{ $laporan->karyawan->user->nama }}</p>
        <p><strong>Periode:</strong> {{ ucfirst($laporan->periode) }} ({{ $start->format('F Y') }} - {{ $end->format('F Y') }})</p>
        <p><strong>Jenis:</strong> {{ $laporan->jenis }}</p>
    </div>

    <h3>Data Penilaian</h3>
    @foreach ($penilaians as $penilaian)
        <p><strong>Tanggal:</strong> {{ $penilaian->tanggal_penilaian->format('d-m-Y') }} | <strong>Penilai:</strong> {{ $penilaian->penilai->nama }}</p>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaian->detailPenilaians as $detail)
                    <tr>
                        <td>{{ $detail->kategori->nama_kategori }}</td>
                        <td>{{ $detail->skor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <h3>Jurnal Aktivitas</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnals as $jurnal)
                <tr>
                    <td>{{ $jurnal->tanggal->format('d-m-Y') }}</td>
                    <td>{{ $jurnal->aktivitas }}</td>
                    <td>{{ $jurnal->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
