<x-main-layout :title-page="'Detail Peminjaman'">
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Detail Peminjaman</h2>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row g-4">

            {{-- Barang --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-primary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-box-seam fs-2 text-primary me-3"></i>
                        <div>
                            <h6 class="text-primary fw-semibold">Barang</h6>
                            <p class="mb-0">{{ $peminjaman->barang->nama_barang }}</p>
                            <small class="text-primary">{{ $peminjaman->barang->kode_barang }}</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peminjam --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-success bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person fs-2 text-success me-3"></i>
                        <div>
                            <h6 class="text-success fw-semibold">Peminjam</h6>
                            <p class="mb-0">{{ $peminjaman->peminjam }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Telepon --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-info bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone fs-2 text-info me-3"></i>
                        <div>
                            <h6 class="text-info fw-semibold">Telepon</h6>
                            <p class="mb-0">{{ $peminjaman->telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-warning bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-stack fs-2 text-warning me-3"></i>
                        <div>
                            <h6 class="text-warning fw-semibold">Jumlah</h6>
                            <p class="mb-0">{{ $peminjaman->jumlah }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanggal Pinjam --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-secondary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check fs-2 text-secondary me-3"></i>
                        <div>
                            <h6 class="text-secondary fw-semibold">Tanggal Pinjam</h6>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanggal Kembali --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 info-tile bg-dark bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-x fs-2 text-dark me-3"></i>
                        <div>
                            <h6 class="text-dark fw-semibold">Tanggal Kembali</h6>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-12">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 d-flex align-items-center justify-content-between"
                     style="background-color: #f8f9fa;">
                    <h6 class="text-muted fw-semibold mb-0">Status</h6>
                    @if($peminjaman->status === 'dipinjam')
                        <span class="badge bg-warning text-dark px-4 py-2 fs-6">Dipinjam</span>
                    @elseif($peminjaman->status === 'dikembalikan')
                        <span class="badge bg-success px-4 py-2 fs-6">Dikembalikan</span>
                    @else
                        <span class="badge bg-secondary px-4 py-2 fs-6">{{ ucfirst($peminjaman->status) }}</span>
                    @endif
                </div>
            </div>

        </div>

    </div>

    {{-- Tambahkan CSS hover effect --}}
    <style>
        .info-tile {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .info-tile:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
    </style>

</x-main-layout>
