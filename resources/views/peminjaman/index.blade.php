<x-main-layout :title-page="__('Peminjaman')">
    <div class="card border-0 shadow-sm">
        {{-- Toolbar --}}
        <div class="card-body border-bottom bg-light">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="mb-1 fw-bold text-dark">Data Peminjaman</h5>
                    <p class="text-muted mb-0 small">Kelola dan pantau peminjaman barang inventaris</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('peminjaman.laporan') }}" 
                       class="btn btn-success btn-sm shadow-sm" 
                       target="_blank">
                        <i class="bi bi-file-pdf me-1"></i> Cetak Laporan
                    </a>
                    <a href="{{ route('peminjaman.create') }}"
                       class="btn btn-primary btn-sm shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Peminjaman
                    </a>
                </div>
            </div>
        </div>

        {{-- Notifikasi --}}
        <x-notif-alert class="mx-3 mt-3" />

        {{-- List Peminjaman - Card Style --}}
        <div class="card-body p-4">
            <div class="table-header-custom mb-3">
                <div class="header-col" style="width: 5%;">#</div>
                <div class="header-col" style="width: 20%;">Barang</div>
                <div class="header-col" style="width: 15%;">Peminjam</div>
                <div class="header-col text-center" style="width: 8%;">Jumlah</div>
                <div class="header-col" style="width: 12%;">Tgl Pinjam</div>
                <div class="header-col" style="width: 12%;">Tgl Kembali</div>
                <div class="header-col text-center" style="width: 10%;">Status</div>
                <div class="header-col text-center" style="width: 18%;">Aksi</div>
            </div>

            @forelse ($peminjaman as $index => $p)
                <div class="peminjaman-card mb-3">
                    <div class="peminjaman-row">
                        
                        {{-- No --}}
                        <div class="peminjaman-col" style="width: 5%;" data-label="#">
                            <div class="badge-number-custom">
                                {{ $peminjaman->firstItem() + $index }}
                            </div>
                        </div>

                        {{-- Barang --}}
                        <div class="peminjaman-col" style="width: 20%;" data-label="Barang">
                            <div>
                                <div class="fw-semibold text-dark">{{ $p->barang->nama_barang }}</div>
                                <small class="text-muted">Kode: {{ $p->barang->kode_barang ?? '-' }}</small>
                            </div>
                        </div>

                        {{-- Peminjam --}}
                        <div class="peminjaman-col" style="width: 15%;" data-label="Peminjam">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle text-primary me-2 fs-5"></i>
                                <span class="text-dark">{{ $p->peminjam }}</span>
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        <div class="peminjaman-col text-center" style="width: 8%;" data-label="Jumlah">
                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">{{ $p->jumlah }}</span>
                        </div>

                        {{-- Tanggal Pinjam --}}
                        <div class="peminjaman-col" style="width: 12%;" data-label="Tgl Pinjam">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                <span class="small">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                            </div>
                        </div>

                        {{-- Tanggal Kembali --}}
                        <div class="peminjaman-col" style="width: 12%;" data-label="Tgl Kembali">
                            @if($p->tanggal_kembali)
                                <div class="d-flex align-items-center text-success">
                                    <i class="bi bi-calendar-check-fill me-2"></i>
                                    <span class="small">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-clock-history me-2"></i>
                                    <span class="small fst-italic">Belum kembali</span>
                                </div>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="peminjaman-col text-center" style="width: 10%;" data-label="Status">
                            @if($p->status == 'dipinjam')
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Dipinjam
                                </span>
                            @else
                                <span class="badge bg-success px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Kembali
                                </span>
                            @endif
                        </div>

                        {{-- Aksi --}}
                        <div class="peminjaman-col text-center" style="width: 18%;" data-label="Aksi">
                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                @if($p->status == 'dipinjam')
                                    {{-- Tombol Kembalikan --}}
                                    <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Konfirmasi pengembalian barang?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Kembalikan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="{{ route('peminjaman.show', $p->id) }}" 
                                class="btn btn-info btn-sm text-white" 
                                title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-6 text-muted opacity-50 d-block mb-3"></i>
                    <h5 class="text-muted fw-semibold mb-2">Belum Ada Data</h5>
                    <p class="text-muted mb-0 small">Data peminjaman belum tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($peminjaman->hasPages())
            <div class="card-body border-top pt-3">
                {{ $peminjaman->links() }}
            </div>
        @endif
    </div>
</x-main-layout>

<style>
    /* Header Custom */
    .table-header-custom {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
    }

    .header-col {
        padding: 0 0.75rem;
        font-weight: 600;
        color: white;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* Peminjaman Card */
    .peminjaman-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .peminjaman-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    /* Peminjaman Row */
    .peminjaman-row {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
    }

    /* Peminjaman Col */
    .peminjaman-col {
        padding: 0 0.75rem;
        display: flex;
        align-items: center;
    }

    /* Badge Number Custom */
    .badge-number-custom {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }

    /* Button Styles */
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Badge Styles */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .table-header-custom {
            display: none;
        }

        .peminjaman-row {
            flex-direction: column;
            align-items: stretch;
            padding: 1.5rem;
        }

        .peminjaman-col {
            width: 100% !important;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f5;
            justify-content: flex-start;
        }

        .peminjaman-col:last-child {
            border-bottom: none;
        }

        .peminjaman-col::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6c757d;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
        }

        .peminjaman-col[data-label="#"]::before {
            display: none;
        }

        .badge-number-custom {
            margin: 0 auto 0.5rem;
        }

        .peminjaman-col.text-center {
            justify-content: flex-start !important;
        }

        .d-flex.gap-1 {
            justify-content: flex-start !important;
        }
    }

    /* Card Toolbar Responsive */
    @media (max-width: 576px) {
        .card-body.border-bottom .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .d-flex.gap-2 {
            width: 100%;
        }

        .d-flex.gap-2 a {
            flex: 1;
        }
    }
</style>