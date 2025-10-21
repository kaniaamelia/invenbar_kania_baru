<x-main-layout :title-page="__('Pemeliharaan Barang')">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Pemeliharaan Barang</h2>
            
            <div class="d-flex gap-2">

                {{-- Tombol Tambah Pemeliharaan Baru --}}
                <a href="{{ route('pemeliharaan.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Pemeliharaan Barang
                </a>

                {{-- Tombol Laporan PDF --}}
                <a href="{{ route('pemeliharaan.laporan.pdf') }}" target="_blank" class="btn btn-success shadow-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Laporan PDF
                </a>

            </div>
        </div>

        <x-notif-alert />

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Tanggal</th>
                                <th>Status Pemeliharaan</th>
                                <th>Jenis Pemeliharaan</th>
                                <th>Keterangan</th>
                                <th>Biaya Operasional</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemeliharaan as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->barang->nama_barang }}</strong><br>
                                        <small class="text-muted">{{ $item->barang->kode_barang }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($item->status === 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td> Rp {{ number_format($item->biaya_operasional, 0, ',', '.') }}</td>

                                    {{-- Tombol Aksi --}}
                                    <td class="text-center" style="width: 18%;">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('pemeliharaan.edit', $item->id) }}" 
                                               class="btn btn-warning btn-sm text-white" 
                                               title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('pemeliharaan.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            {{-- Tombol Selesai --}}
                                            @if ($item->status !== 'Selesai')
                                                <form action="{{ route('pemeliharaan.selesaikan', $item->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Konfirmasi pemeliharaan selesai?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Tandai Selesai">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled title="Sudah Selesai">
                                                    <i class="bi bi-check2-all"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-tools fs-1 mb-3 d-block"></i>
                                        <span class="d-block fs-5 mb-3">Belum ada data pemeliharaan barang.</span>
                                        <a href="{{ route('pemeliharaan.create') }}" 
                                           class="btn btn-primary btn-sm shadow-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-main-layout>
