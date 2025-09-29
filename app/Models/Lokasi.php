<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    protected $fillable = [
        'nama_lokasi'
    ];

    // Relasi Lokasi ke Barang (one-to-many)
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }
}