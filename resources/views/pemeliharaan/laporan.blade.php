<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* ✅ Font aman untuk DomPDF */
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
            vertical-align: middle;
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

        /* ===== Badge warna status ===== */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #212529; }
        .bg-danger { background-color: #dc3545; }

        /* ===== Lebar kolom agar proporsional ===== */
        th:nth-child(1) { width: 5%; }   /* No */
        th:nth-child(2) { width: 10%; }  /* Kode Barang */
        th:nth-child(3) { width: 20%; }  /* Nama Barang */
        th:nth-child(4) { width: 12%; }  /* Kategori */
        th:nth-child(5) { width: 15%; }  /* Lokasi */
        th:nth-child(6) { width: 10%; }  /* Status */
        th:nth-child(7) { width: 13%; }  /* Jenis Pemeliharaan */
        th:nth-child(8) { width: 13%; }  /* Biaya Operasional */
        th:nth-child(9) { width: 13%; }  /* Tanggal */

        /* ===== Footer ===== */
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            page-break-inside: avoid;
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

        @page {
            margin: 30px;
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
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Jenis Pemeliharaan</th>
                <th>Biaya Operasional (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pemeliharaan as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $item->barang->kode_barang }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td style="text-align: center;">{{ $item->barang->kategori->nama_kategori }}</td>
                    <td style="text-align: center;">{{ $item->barang->lokasi->nama_lokasi }}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                    </td>
                    <td style="text-align: center;">
                        @if($item->status === 'Selesai')
                            <span class="badge bg-success">{{ $item->status }}</span>
                        @elseif($item->status === 'Pembersihan')
                            <span class="badge bg-warning">{{ $item->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->jenis }}</td>
                    <td style="text-align: right;">
                        @if($item->biaya_operasional)
                            Rp {{ number_format($item->biaya_operasional, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:15px;">Tidak ada data pemeliharaan barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        </div>
    </div>
</body>
</html>
