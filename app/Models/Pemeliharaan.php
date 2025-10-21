<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaan';

    protected $fillable = [
    'barang_id',
    'tanggal',
    'status',
    'jenis',
    'keterangan',
    'biaya_operasional', // ✅ tambahkan ini
];


    // Cast field tanggal menjadi datetime
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
