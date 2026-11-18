<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: monospace;
            width: 280px;
            margin: 10px auto;
            font-size: 13px;
        }
        h3, p {
            text-align: center;
            margin: 4px 0;
        }
        table {
            width: 100%;
        }
        .total {
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>
<body onload="window.print()">
    <h3>STRUK PARKIR</h3>
    <p>--------------------------------</p>

    <table>
        <tr><td>No</td><td>: {{ $transaksi->id_transaksi }}</td></tr>
        <tr><td>Plat</td><td>: {{ $transaksi->kendaraan->plat_nomor }}</td></tr>
        <tr><td>Jenis</td><td>: {{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</td></tr>
        <tr><td>Area</td><td>: {{ $transaksi->area->nama_area }}</td></tr>
        <tr><td>Masuk</td><td>: {{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Keluar</td><td>: {{ $transaksi->waktu_keluar->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Durasi</td><td>: {{ $transaksi->durasi_jam }} jam</td></tr>
        <tr><td>Tarif/jam</td><td>: Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</td></tr>
    </table>

    <p>--------------------------------</p>
    <p class="total">TOTAL: Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</p>
    <p>Terima kasih</p>
</body>
</html>