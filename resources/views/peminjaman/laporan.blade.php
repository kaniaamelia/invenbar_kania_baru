<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* ✅ Gunakan font yang dikenali Dompdf */
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 30px;
            font-size: 12px;
            color: #222;
        }

        /* ===== Header ===== */
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 4px 0;
            font-size: 11px;
            color: #555;
        }

        /* ===== Table ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background-color: #f1f1f1;
            text-align: center;
            font-weight: bold;
        }

        td {
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Lebar kolom agar proporsional */
        th:nth-child(1) { width: 5%; }   /* No */
        th:nth-child(2) { width: 15%; }  /* Peminjam */
        th:nth-child(3) { width: 12%; }  /* No. Telepon */
        th:nth-child(4) { width: 22%; }  /* Barang */
        th:nth-child(5) { width: 8%; }   /* Jumlah */
        th:nth-child(6) { width: 13%; }  /* Tgl Pinjam */
        th:nth-child(7) { width: 13%; }  /* Tgl Kembali */
        th:nth-child(8) { width: 10%; }  /* Status */

        /* ===== Footer ===== */
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .footer div {
            width: 40%;
            text-align: center;
        }

        .footer p {
            margin: 4px 0;
        }

        .ttd {
            margin-top: 60px;
            text-align: center;
        }

        /* Untuk halaman PDF agar tidak terpotong */
        @page {
            margin: 30px;
        }

        /* Hindari footer menumpuk dengan tabel */
        .footer {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    {{-- ===== Header ===== --}}
    <div class="header">
        <h1>{{ strtoupper($title) }}</h1>
        <p>Tanggal Cetak: {{ $date }}</p>
    </div>

    {{-- ===== Table ===== --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>No. Telepon</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $index => $pinjam)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $pinjam->peminjam }}</td>
                    <td>{{ $pinjam->telepon ?? '-' }}</td>
                    <td>{{ $pinjam->barang->nama_barang ?? '-' }}</td>
                    <td style="text-align: center;">{{ $pinjam->jumlah }}</td>
                    <td style="text-align: center;">
                        {{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}
                    </td>
                    <td style="text-align: center;">
                        @if($pinjam->status === 'dikembalikan')
                            {{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}
                        @else
                            {{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}
                            <br><small>(Rencana)</small>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ ucfirst($pinjam->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:15px;">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        </div>
    </div>
</body>
</html>
