@php
    use Carbon\Carbon;
@endphp

<x-main-layout :title-page="__('Edit Peminjaman')">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Edit Data Peminjaman</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                {{-- Barang --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror">
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" 
                                {{ old('barang_id', $peminjaman->barang_id) == $barang->id ? 'selected' : '' }}>
                                {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Peminjam --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Peminjam</label>
                    <input type="text" name="peminjam"
                        class="form-control @error('peminjam') is-invalid @enderror"
                        placeholder="Masukkan nama peminjam"
                        value="{{ old('peminjam', $peminjaman->peminjam) }}">
                    @error('peminjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" name="telepon"
                        class="form-control @error('telepon') is-invalid @enderror"
                        placeholder="Contoh: 081234567890"
                        value="{{ old('telepon', $peminjaman->telepon) }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah, Tanggal Pinjam, Tanggal Kembali --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" name="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah', $peminjaman->jumlah) }}" min="1">
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam"
                            class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                            value="{{ old('tanggal_pinjam', Carbon::parse($peminjaman->tanggal_pinjam)->format('Y-m-d')) }}">
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali"
                            class="form-control @error('tanggal_kembali') is-invalid @enderror"
                            value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali ? Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d') : '') }}">
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>
