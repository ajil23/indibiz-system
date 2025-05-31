<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Penolakan</title>
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
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penolakan</h2>
        <p>Tanggal: {{ \Carbon\Carbon::parse($penolakan->tanggal_kunjungan)->format('d F Y') }}</p>
    </div>

    <table>
        <tr>
            <th>Nama Lokasi</th>
            <td>{{ $penolakan->nama_lokasi }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $penolakan->alamat }}</td>
        </tr>
        <tr>
            <th>Tanggal Kunjungan</th>
            <td>{{ \Carbon\Carbon::parse($penolakan->tanggal_kunjungan)->format('d F Y H:i') }}</td>
        </tr>
        <tr>
            <th>Catatan Penolakan</th>
            <td>{{ $penolakan->catatan_penolakan }}</td>
        </tr>
        <tr>
            <th>Sales</th>
            <td>{{ $penolakan->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Produk</th>
            <td>{{ $penolakan->jenis_produk->nama_produk ?? '-' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name ?? 'Sistem' }}</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

</body>
</html>