<x-main-layout :title-page="__('Tambah Peminjaman')">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Form Tambah Peminjaman</h5>

            {{-- Notifikasi error dari validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Notifikasi error stok --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                {{-- Barang --}}
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Pilih Barang</label>
                    <select name="barang_id" id="barang_id" class="form-select" required>
                        <option value="">-- pilih barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Peminjam --}}
                <div class="mb-3">
                    <label for="peminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" id="peminjam" name="peminjam" class="form-control"
                           value="{{ old('peminjam') }}" required>
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" id="telepon" name="telepon" class="form-control"
                           value="{{ old('telepon') }}" placeholder="Contoh: 081234567890">
                </div>

                {{-- Jumlah --}}
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control"
                           value="{{ old('jumlah', 1) }}" min="1" required>
                </div>

                {{-- Tanggal Pinjam --}}
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control"
                           value="{{ old('tanggal_pinjam') }}" required>
                </div>

                {{-- Tanggal Kembali --}}
                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control"
                           value="{{ old('tanggal_kembali') }}" required>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>
