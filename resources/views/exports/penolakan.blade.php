<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penolakan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penolakan</h2>
        <p>Periode: {{ now()->format('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Alamat</th>
                <th>Tanggal Kunjungan</th>
                <th>Catatan Penolakan</th>
                <th>Sales</th>
                <th>Jenis Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lokasi }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d F Y H:i') }}</td>
                    <td>{{ $item->catatan_penolakan }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->jenis_produk->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name ?? 'Sistem' }}</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

</body>
</html>
