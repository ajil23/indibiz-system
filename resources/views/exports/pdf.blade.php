<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF - Data Penawaran</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Data Penawaran</h2>
    <p>Tanggal Export: {{ now()->format('d-m-Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Alamat</th>
                <th>Tanggal Kunjungan</th>
                <th>PIC</th>
                <th>Nomor HP</th>
                <th>Bukti Kunjungan</th>
                <th>Keterangan</th>
                <th>Feedback</th>
                <th>Sales</th>
                <th>Kategori Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $penawaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $penawaran->nama_lokasi }}</td>
                <td>{{ $penawaran->alamat }}</td>
                <td>{{ $penawaran->tanggal_kunjungan }}</td>
                <td>{{ $penawaran->pic }}</td>
                <td>{{ $penawaran->nomor_hp }}</td>
                <td>
                    @if($penawaran->bukti_kunjungan)
                        <a href="{{ public_path('storage/' . $penawaran->bukti_kunjungan) }}" target="_blank">Lihat</a>
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>{{ $penawaran->keterangan }}</td>
                <td>{{ $penawaran->feedback }}</td>
                <td>{{ $penawaran->user ? $penawaran->user->name : '-' }}</td>
                <td>{{ $penawaran->kategori_lokasi ? $penawaran->kategori_lokasi->nama_sektor : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
