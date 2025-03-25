<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelaporan Kendaraan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="title">Laporan Pelaporan Kendaraan</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pengemudi</th>
                <th>TNKB</th>
                <th>Tanggal Penggunaan</th>
                <th>Lokasi Tujuan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Jumlah Odo</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $item->pengemudi }}</td>
                    <td>{{ $item->tnkb->nomor_polisi ?? '-' }}</td>
                    <td>{{ $item->tanggal_penggunaan }}</td>
                    <td class="text-left">{{ $item->lokasi_tujuan }}</td>
                    <td>{{ $item->waktu_mulai }}</td>
                    <td>{{ $item->waktu_selesai }}</td>
                    <td>{{ $item->jumlah_odo }}</td>
                    <td class="text-left">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
