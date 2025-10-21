<x-main-layout :title-page="__('Lokasi')">
    <div class="card">
        {{-- Toolbar --}}
        <div class="card-body d-flex justify-content-between align-items-center">
            <p class="text-muted mb-0">Kelola dan pantau lokasi penyimpanan barang inventaris</p>
            <a href="{{ route('lokasi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Lokasi
            </a>
        </div>

        {{-- Notifikasi --}}
        <x-notif-alert class="mt-2" />

        {{-- List Lokasi --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                    <thead class="table-primary text-center">
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Nama Lokasi</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lokasis as $index => $lokasi)
                        <tr>
                            {{-- No --}}
                            <td class="text-center">
                                <span class="badge bg-primary">
                                    {{ $lokasis->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Nama Lokasi --}}
                            <td class="fw-semibold text-dark">
                                {{ $lokasi->nama_lokasi }}
                            </td>

                            {{-- Aksi --}}
                            <td class="text-end">
                                <div class="btn-group">
                                    {{-- Show --}}
                                    <a href="{{ route('lokasi.show', $lokasi->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-file-text"></i>
                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="btn btn-warning btn-sm ms-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ms-1">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Belum ada data lokasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-body">
            {{ $lokasis->links() }}
        </div>
    </div>
</x-main-layout>