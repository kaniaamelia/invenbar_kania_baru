<x-main-layout :title-page="'Detail Lokasi - ' . $lokasi->nama_lokasi">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{ $lokasi->nama_lokasi }}
                </h5>
                <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <x-notif-alert />
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <h6 class="text-muted">Informasi Lokasi</h6>
                        <p class="mb-1"><strong>Nama Lokasi:</strong> {{ $lokasi->nama_lokasi }}</p>
                        <p class="mb-1"><strong>Total Barang:</strong> {{ $barangs->total() }} item</p>
                        <p class="mb-0"><strong>Dibuat:</strong> {{ $lokasi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <h6 class="mb-3">
                <i class="fas fa-boxes me-2"></i>
                Daftar Barang di Lokasi Ini
            </h6>

            @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Kondisi</th>
                                <th>Tanggal Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $index => $barang)
                                <tr>
                                    <td>{{ $barangs->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $barang->kode_barang }}</span>
                                    </td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ $barang->jumlah }}</td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td>
                                        @if($barang->kondisi == 'Baik')
                                            <span class="badge bg-success">{{ $barang->kondisi }}</span>
                                        @elseif($barang->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning">{{ $barang->kondisi }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $barang->kondisi }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $barang->tanggal_pengadaan->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $barangs->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada barang yang terdaftar di lokasi ini.
                </div>
            @endif
        </div>
    </div>
</x-main-layout>