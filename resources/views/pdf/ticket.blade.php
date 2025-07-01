<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bali OM Tour E-Ticket</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            page-break-inside: avoid;
            border: 2px solid #ccc;
        }

        .header-center {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo {
            height: 50px;
            margin-bottom: 5px;
        }

        .header-title {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 4px;
        }

        .info {
            font-size: 13px;
            margin-top: 2px;
        }

        .ticket-number {
            text-align: right;
            font-weight: bold;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        hr {
            border: none;
            border-top: 2px solid #888;
            margin-top: -2px;
            margin-bottom: 15px;
        }

        .field-table {
            width: 100%;
            border-spacing: 0 8px;
            margin-bottom: 10px;
        }

        .field-table td {
            vertical-align: top;
        }

        .field {
            border-bottom: 1px solid #666;
            display: inline-block;
            height: 16px;
        }

        .w-60 {
            width: 60px;
        }

        .w-100 {
            width: 100px;
        }

        .w-150 {
            width: 150px;
        }

        .w-200 {
            width: 200px;
        }

        .w-300 {
            width: 300px;
        }

        .w-350 {
            width: 350px;
        }

        .w-450 {
            width: 450px;
        }

        .w-700 {
            width: 700px;
        }

        fieldset {
            border: 1px solid #aaa;
            padding: 10px;
            margin-top: 15px;
            page-break-inside: avoid;
        }

        legend {
            font-weight: bold;
            padding: 0 6px;
        }

        .checkbox-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px;
        }

        .checkbox-grid label {
            width: 48%;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 30px auto 8px;
        }

        .footer-note {
            font-size: 10px;
            color: red;
            font-style: italic;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        @php
            $path = public_path('assets/img/baliomtour.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            // Hitung total + additional_charge dan balance
            $totalRaw = $transaksi->total_transaksi ?? 0;
            $additional = $transaksi->additional_charge ?? 0;
            $deposit = $transaksi->deposit ?? 0;
            $totalWithAdd = $totalRaw;
            $balance = max($totalWithAdd - $deposit, 0);
        @endphp

        <div class="header-center">
            <img src="{{ $base64 }}" alt="Logo Bali Om" class="logo">
            <div class="info">Tourist Information and Travel Agent</div>
            <div class="info">Jl. Bisma no. 3 Ubud • +62 81936976234 / +62 82237397076</div>
        </div>

        <div class="ticket-number">
            No. <span class="field w-100">#E-{{ $transaksi->transaksi_id }}</span>
        </div>
        <hr>

        <table class="field-table">
            <tr>
                <td>Name:
                    <span class="field w-350">
                        {{ $transaksi->pemesanan->pelanggan->nama_pemesan ?? '-' }}
                    </span>
                </td>
                <td>Phone No.:
                    <span class="field w-200">
                        {{ $transaksi->pemesanan->pelanggan->nomor_whatsapp ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Pax:
                    <span class="field w-60">
                        {{ $transaksi->jumlah_peserta }}
                    </span>
                </td>
                <td>Provider:
                    <span class="field w-300">
                        {{ $transaksi->pemesanan->mobil->nama_kendaraan ?? '-' }} /
                        {{ $transaksi->pemesanan->mobil->sopir->nama_sopir ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Activity:
                    <span class="field w-700">
                        {{ $transaksi->paketWisata->judul ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Date Activity:
                    <span class="field w-200">
                        {{ $transaksi->pemesanan->tanggal_keberangkatan ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Total Transaction:
                    <span class="field w-100">
                        {{ $totalWithAdd }}
                    </span>
                </td>
                <td>Deposit:
                    <span class="field w-100">
                        {{ $deposit }}
                    </span>
                    | Balance:
                    <span class="field w-100">
                        {{ $balance }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Accommodation:
                    <span class="field w-150">
                        {{ $transaksi->pemesanan->pelanggan->alamat ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Pick up time:
                    <span class="field w-150">
                        {{ $transaksi->pemesanan->jam_mulai ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Other:
                    <span class="field w-700">
                        {{ $transaksi->paketWisata->tempat ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Note:
                    <span class="field w-700">
                        {{ $transaksi->note ?? '-' }}
                    </span>
                </td>
            </tr>
        </table>

        <fieldset>
            <legend>Include</legend>
            <div class="checkbox-grid">
                @php $include = $transaksi->includeModel; @endphp
                <label>
                    <input type="checkbox" {{ $include?->bensin ? 'checked' : '' }}>
                    Bensin
                </label>
                <label>
                    <input type="checkbox" {{ $include?->parkir ? 'checked' : '' }}>
                    Parkir
                </label>
                <label>
                    <input type="checkbox" {{ $include?->sopir ? 'checked' : '' }}>
                    Supir
                </label>
                <label>
                    <input type="checkbox" {{ $include?->makan_siang ? 'checked' : '' }}>
                    Makan Siang
                </label>
                <label>
                    <input type="checkbox" {{ $include?->makan_malam ? 'checked' : '' }}>
                    Makan Malam
                </label>
                <label>
                    <input type="checkbox" {{ $include?->tiket_masuk ? 'checked' : '' }}>
                    Tiket Masuk
                </label>
            </div>
        </fieldset>

        <table style="width: 100%; margin-top: 50px; text-align: center;">
            <tr>
                <td style="width: 50%;">
                    <div class="signature-line"></div>
                    <p>Customer</p>
                </td>
                <td style="width: 50%;">
                    <div class="signature-line"></div>
                    <p>Bali Om Tourist Information</p>
                </td>
            </tr>
        </table>

        <div class="footer-note">Cancellation fee 50% from the full amount</div>
    </div>
</body>

</html>
