<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    // Isi atribut yang boleh diisi massal
 protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'jumlah',
        'satuan',
        'kondisi',
        'tanggal_pengadaan',
        'gambar',
    ];

    // Gunakan guarded jika ingin melindungi id
    protected $guarded = ['id'];

    // Cast tipe data untuk tanggal
    protected $casts = [
        'tanggal_pengadaan' => 'date',
    ];

    // Relasi Barang ke Kategori (many-to-one)
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi Barang ke Lokasi (many-to-one)
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    // Relasi Barang ke Barang (one-to-many), misal sub-barang
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }
}
