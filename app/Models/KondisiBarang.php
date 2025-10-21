<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KondisiBarang extends Model
{

     protected $fillable = [
        'barang_id',
        'kondisi',
        'jumlah'
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }}   
   
