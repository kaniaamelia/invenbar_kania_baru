@csrf
<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input 
            label="Kode Barang" 
            name="kode_barang" 
            :value="$barang->kode_barang" 
        />
    </div>
    <div class="col-md-6">
        <x-form-input 
            label="Nama Barang" 
            name="nama_barang" 
            :value="$barang->nama_barang" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-select 
            label="Kategori" 
            name="kategori_id" 
            :value="$barang->kategori_id" 
            :option-data="$kategori" 
            option-label="nama_kategori" 
            option-value="id" 
        />
    </div>
    <div class="col-md-6">
        <x-form-select 
            label="Lokasi" 
            name="lokasi_id" 
            :value="$barang->lokasi_id" 
            :option-data="$lokasi" 
            option-label="nama_lokasi" 
            option-value="id" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-select 
            label="Sumber Dana" 
            name="sumber_dana" 
            :value="$barang->sumber_dana"
            :option-data="[
                ['value' => 'Pemerintah', 'label' => 'Pemerintah'],
                ['value' => 'Donatur', 'label' => 'Donatur'],
                ['value' => 'Swadaya', 'label' => 'Swadaya']
            ]"
            option-label="label"
            option-value="value"
        />
    </div>
    <div class="col-md-6">
        <x-form-input 
            label="Satuan" 
            name="satuan" 
            :value="$barang->satuan" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        @php
            $tanggal = $barang->tanggal_pengadaan 
                ? date('Y-m-d', strtotime($barang->tanggal_pengadaan)) 
                : null;
        @endphp
        <x-form-input 
            label="Tanggal Pengadaan" 
            name="tanggal_pengadaan" 
            type="date" 
            :value="$tanggal" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <x-form-input 
            label="Jumlah Barang Kondisi Baik" 
            name="kondisi_baik" 
            type="number" 
            min="0"
            :value="old('kondisi_baik', 0)" 
        />
    </div>
    <div class="col-md-4">
        <x-form-input 
            label="Jumlah Barang Rusak Ringan" 
            name="kondisi_rusak_ringan" 
            type="number" 
            min="0"
            :value="old('kondisi_rusak_ringan', 0)" 
        />
    </div>
    <div class="col-md-4">
        <x-form-input 
            label="Jumlah Barang Rusak Berat" 
            name="kondisi_rusak_berat" 
            type="number" 
            min="0"
            :value="old('kondisi_rusak_berat', 0)" 
        />
    </div>
</div>

<div class="mb-3">
    <x-form-input 
        label="Gambar Barang" 
        name="gambar" 
        type="file" 
    />
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? __('Update') : __('Simpan') }}
    </x-primary-button>
    <x-tombol-kembali :href="route('barang.index')" />
</div>
