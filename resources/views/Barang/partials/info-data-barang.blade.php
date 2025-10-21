<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 30%;">Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $barang->kategori->nama_kategori }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $barang->lokasi->nama_lokasi }}</td>
        </tr>
        <tr>
            <th>Total Jumlah</th>
            <td>{{ $barang->kondisiBarang->sum('jumlah') }} {{ $barang->satuan }}</td>
        </tr>
        <tr>
            <th>Rincian Kondisi</th>
            <td>
                @forelse($barang->kondisiBarang as $kondisi)
                    <div class="mb-1">
                        <span class="badge bg-{{ $kondisi->kondisi === 'baik' ? 'success' : ($kondisi->kondisi === 'rusak_ringan' ? 'warning' : 'danger') }}">
                            {{ $kondisi->jumlah }} {{ $barang->satuan }} {{ str_replace('_', ' ', ucfirst($kondisi->kondisi)) }}
                        </span>
                    </div>
                @empty
                    <span class="text-muted">Belum ada data kondisi</span>
                @endforelse
            </td>
        </tr>
        <tr>
            <th>Tanggal Pengadaan</th>
            <td>{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Terakhir Diperbarui</th>
            <td>{{ $barang->updated_at->translatedFormat('d F Y, H:i') }}</td>
        </tr>
    </tbody>
</table>
