<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    // Kolom yang boleh diisi massal
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'jumlah',
        'satuan',
        'tanggal_pengadaan',
        'gambar',
        'sumber_dana',
    ];

    // Kolom yang tidak boleh diisi massal
    protected $guarded = ['id'];

    // Cast tipe data untuk tanggal
    protected $casts = [
        'tanggal_pengadaan' => 'date',
    ];

    /** =======================
     *  Relasi
     *  ======================= */

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

    // Relasi Barang ke Barang lain (one-to-many), misal sub-barang
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }

    // Relasi Barang ke KondisiBarang (one-to-many)
    public function kondisiBarang(): HasMany
    {
        return $this->hasMany(KondisiBarang::class);
    }

    // Relasi Barang ke Peminjaman (one-to-many)
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    // ✅ Relasi Barang ke Pemeliharaan (one-to-many)
    public function pemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class);
    }

    /** =======================
     *  Accessor / Helper
     *  ======================= */

    // Menghitung total jumlah dari semua kondisi barang
    public function getTotalJumlahAttribute()
    {
        return $this->kondisiBarang->sum('jumlah');
    }
}
