<table class="table table-bordered border-secondary table-sm align-middle">
    <thead class="table-light text-center">
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Tgl. Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangs as $index => $barang)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td class="text-center">{{ $barang->kategori->nama_kategori }}</td>
                <td>{{ $barang->lokasi->nama_lokasi }}</td>
                <td class="text-center">
                    {{ $barang->kondisiBarang->sum('jumlah') }} {{ $barang->satuan }}
                </td>
                <td>
                    @foreach($barang->kondisiBarang as $kondisi)
                        • {{ $kondisi->jumlah }} {{ str_replace('_', ' ', ucfirst($kondisi->kondisi)) }}<br>
                    @endforeach
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->format('d-m-Y') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
