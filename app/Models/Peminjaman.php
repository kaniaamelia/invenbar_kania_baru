<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // Kolom yang boleh diisi lewat mass assignment
    protected $fillable = [
    'barang_id',
    'peminjam',
    'telepon', // ← tambahkan ini
    'jumlah',
    'tanggal_pinjam',
    'tanggal_kembali',
    'status',
];


    // Relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
