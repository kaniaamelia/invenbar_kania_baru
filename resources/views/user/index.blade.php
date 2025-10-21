<x-main-layout :title-page="__('User')">
    <div class="card">
        {{-- Toolbar --}}
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-0">Kelola dan pantau data pengguna sistem</p>
            </div>
            <div>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah User
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        <x-notif-alert class="mt-2" />

        {{-- List User --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $users->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </td>
                            <td>
                                <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                            </td>
                            <td class="text-center">
                                @php
                                    $role = $user->getRoleNames()->first();
                                @endphp

                                @if($role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($role == 'petugas')
                                    <span class="badge bg-info">Petugas Inventaris</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Ada Role</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm ms-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Belum ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-body">
            {{ $users->links() }}
        </div>
    </div>
</x-main-layout>
