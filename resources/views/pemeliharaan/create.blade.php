<x-main-layout :title-page="__('Tambah Pemeliharaan Barang')">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h4 class="fw-bold mb-4">Tambah Data Pemeliharaan Barang</h4>

            <form action="{{ route('pemeliharaan.store') }}" method="POST">
                @csrf

                {{-- Pilih Barang --}}
                <div class="mb-3">
                    <label for="barang_id" class="form-label fw-semibold">Pilih Barang</label>
                    <select name="barang_id" id="barang_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_barang }} ({{ $item->kode_barang }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Pemeliharaan --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal Pemeliharaan</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="form-control" required>
                </div>

                {{-- Status Pemeliharaan --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Pemeliharaan</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Pilih Status Pemeliharaan --</option>
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Pemeliharaan --}}
                <div class="mb-3">
                    <label for="jenis" class="form-label fw-semibold">Kategori Pemeliharaan</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($jenisOptions as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Tuliskan keterangan pemeliharaan...">{{ old('keterangan') }}</textarea>
                </div>

                {{-- ✅ Biaya Operasional --}}
                <div class="mb-3">
                    <label for="biaya_operasional" class="form-label fw-semibold">Biaya Operasional (Rp)</label>
                    <input type="number" name="biaya_operasional" id="biaya_operasional" 
                           value="{{ old('biaya_operasional') }}" 
                           class="form-control" 
                           placeholder="Contoh: 250000">
                    <small class="text-muted">Isi dengan total biaya operasional selama pemeliharaan.</small>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>
