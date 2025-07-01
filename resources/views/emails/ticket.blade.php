<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Informasi Transaksi - Bali Om Tours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .card {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 700px;
            margin: 0 auto;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            height: 60px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #2d6a4f;
        }

        .info-table {
            width: 100%;
            margin-bottom: 24px;
        }

        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
        }

        .checkbox-group label {
            display: block;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <div class="title">Pengiriman E-Ticket </div>
            <p>Terima kasih telah melakukan pemesanan di <strong>Bali Om Tours</strong>.</p>
        </div>

        <table class="info-table">
            <tr>
                <td><strong>Nama Pemesan:</strong></td>
                <td>{{ $transaksi->pelanggan->nama_pemesan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Paket Wisata:</strong></td>
                <td>{{ $transaksi->paketWisata->judul ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Keberangkatan:</strong></td>
                <td>{{ \Carbon\Carbon::parse($transaksi->pemesanan->tanggal_keberangkatan)->format('d M Y') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td><strong>Jumlah Peserta:</strong></td>
                <td>{{ $transaksi->jumlah_peserta }}</td>
            </tr>
            <tr>
                <td><strong>Jenis Pembayaran:</strong></td>
                <td>{{ ucfirst($transaksi->jenis_transaksi) }}</td>
            </tr>
            <tr>
                <td><strong>Deposit:</strong></td>
                <td>Rp {{ number_format($transaksi->deposit, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Balance:</strong></td>
                <td>Rp {{ number_format($transaksi->balance, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td><strong>Owe to Bali OM Tours:</strong></td>
                <td>Rp {{ number_format($transaksi->owe_to_me, 0, ',', '.') }}</td>
            </tr>
        </table>

        <fieldset>
            <legend>Include</legend>
            @php $include = $transaksi->includeModel; @endphp
            <div class="checkbox-group">
                <label>Bensin: {{ $include?->bensin ? '✓' : '✗' }}</label>
                <label>Parkir: {{ $include?->parkir ? '✓' : '✗' }}</label>
                <label>Supir: {{ $include?->sopir ? '✓' : '✗' }}</label>
                <label>Makan Siang: {{ $include?->makan_siang ? '✓' : '✗' }}</label>
                <label>Makan Malam: {{ $include?->makan_malam ? '✓' : '✗' }}</label>
                <label>Tiket Masuk: {{ $include?->tiket_masuk ? '✓' : '✗' }}</label>
            </div>
        </fieldset>
        <div class="footer">
            Email ini dikirim secara otomatis dari sistem Bali Om Tour. Jangan balas email ini.
        </div>
    </div>
</body>

</html>
