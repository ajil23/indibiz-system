<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Lokasi Usaha</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Produk</th>
                <th>Sales</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_pelanggan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->lokasi_usaha }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->nomor_hp }}</td>
                <td>{{ $item->jenis_produk->nama ?? '-' }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Ditandatangani oleh,</p>
        <p>_____________________</p>
    </div>
</body>
</html>
