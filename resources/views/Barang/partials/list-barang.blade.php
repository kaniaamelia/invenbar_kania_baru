<x-table-list>
    <x-slot name="header">
        <div class="table-header">
            <div class="header-item" style="width: 5%;">#</div>
            <div class="header-item" style="width: 10%;">Kode</div>
            <div class="header-item" style="width: 18%;">Nama Barang</div>
            <div class="header-item" style="width: 12%;">Kategori</div>
            <div class="header-item" style="width: 15%;">Lokasi</div>
            <div class="header-item" style="width: 12%;">Sumber Dana</div>
            <div class="header-item" style="width: 13%;">Kondisi</div>
            <div class="header-item" style="width: 8%;">Jumlah</div>
            <div class="header-item" style="width: 7%;">Aksi</div>
        </div>
    </x-slot>

    @forelse ($barangs as $index => $barang)
        <div class="table-card">
            <div class="table-row">
                
                {{-- Nomor --}}
                <div class="table-cell" style="width: 5%;" data-label="#">
                    <div class="badge-number">{{ $barangs->firstItem() + $index }}</div>
                </div>

                {{-- Kode Barang --}}
                <div class="table-cell" style="width: 10%;" data-label="Kode">
                    <span class="fw-semibold text-dark">{{ $barang->kode_barang }}</span>
                </div>

                {{-- Nama Barang --}}
                <div class="table-cell" style="width: 18%;" data-label="Nama Barang">
                    <span class="fw-semibold text-dark">{{ $barang->nama_barang }}</span>
                </div>

                {{-- Kategori --}}
                <div class="table-cell" style="width: 12%;" data-label="Kategori">
                    <span class="badge bg-light text-dark px-3 py-2">
                        {{ $barang->kategori->nama_kategori }}
                    </span>
                </div>

                {{-- Lokasi --}}
                <div class="table-cell" style="width: 15%;" data-label="Lokasi">
                    <span class="text-muted">{{ $barang->lokasi->nama_lokasi }}</span>
                </div>

                {{-- Sumber Dana --}}
                <div class="table-cell" style="width: 12%;" data-label="Sumber Dana">
                    <span class="text-muted">{{ $barang->sumber_dana ?? '-' }}</span>
                </div>

                {{-- Kondisi --}}
                <div class="table-cell" style="width: 13%;" data-label="Kondisi">
                    <div class="kondisi-wrapper">
                        @foreach($barang->kondisiBarang->sortBy(fn($item) => ['baik'=>1,'rusak_ringan'=>2,'rusak_berat'=>3][$item->kondisi] ?? 99) as $kondisi)
                            <span class="badge rounded-pill kondisi-badge
                                {{ $kondisi->kondisi === 'baik' ? 'bg-success' : 
                                   ($kondisi->kondisi === 'rusak_ringan' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $kondisi->jumlah }} {{ str_replace('_', ' ', ucfirst($kondisi->kondisi)) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="table-cell" style="width: 8%;" data-label="Jumlah">
                    <div class="text-center">
                        <div class="fw-bold text-primary fs-5">{{ $barang->kondisiBarang->sum('jumlah') }}</div>
                        <div class="small text-muted">{{ $barang->satuan }}</div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
<div class="table-cell aksi-cell" style="width: 7%;" data-label="Aksi">
    <div class="action-buttons">
        @can('manage barang')
            <x-tombol-aksi href="{{ route('barang.show', $barang->id) }}" type="show" iconOnly="true" />
            <x-tombol-aksi href="{{ route('barang.edit', $barang->id) }}" type="edit" iconOnly="true" />
        @endcan

        @can('delete barang')
            <x-tombol-aksi href="{{ route('barang.destroy', $barang->id) }}" type="delete" iconOnly="true" />
        @endcan
    </div>
</div>

            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                 class="text-muted opacity-50 mb-3" viewBox="0 0 16 16">
                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z"/>
            </svg>
            <h5 class="text-muted fw-semibold mb-2">Tidak Ada Data</h5>
            <p class="text-muted mb-0 small">Data barang belum tersedia.</p>
        </div>
    @endforelse
</x-table-list>

<style>
    .table-header {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #e9ecef;
        background-color: #f8f9fa;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0.5rem;
    }

    .header-item {
        padding: 0 1rem;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.25s ease;
    }

    .table-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: #dee2e6;
    }

    .table-row {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
    }

    .table-cell {
        padding: 0 1rem;
        display: flex;
        align-items: center;
    }

    .badge-number {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, #007bff, #0056d2);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 3px 8px rgba(0, 123, 255, 0.25);
    }

    .kondisi-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .kondisi-badge {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    /* ✅ Tambahan: Jarak kanan aksi agar tidak mepet */
    .aksi-cell {
        display: flex;
        justify-content: center;
        padding-right: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .table-header {
            display: none;
        }

        .table-row {
            flex-direction: column;
            align-items: stretch;
            padding: 1.5rem;
        }

        .table-cell {
            width: 100% !important;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f5;
        }

        .table-cell:last-child {
            border-bottom: none;
        }

        .table-cell::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6c757d;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .table-cell[data-label="#"]::before {
            display: none;
        }

        .badge-number {
            margin: 0 auto 0.5rem;
        }

        .action-buttons {
            justify-content: flex-start;
            margin-top: 0.5rem;
        }

        .kondisi-wrapper {
            align-items: flex-start;
        }
    }
</style>
