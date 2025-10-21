<x-main-layout :title-page="__('Kategori')">
    <div class="card">
        {{-- Toolbar --}}
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-0">Kelola dan pantau kategori barang inventaris</p>
            </div>
            <div>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        <x-notif-alert class="mt-2" />

        {{-- List Kategori --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                    <thead class="table-primary text-center">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama Kategori</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $index => $kategori)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $kategoris->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $kategori->nama_kategori }}</div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm ms-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-body">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-main-layout>