<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBarang = Barang::count();
        $jumlahKategori = Kategori::count();
        $jumlahLokasi = Lokasi::count();
        $jumlahUser = User::count();
        $jumlahPeminjaman = Peminjaman::count(); // ← jumlah peminjaman
        $jumlahPemeliharaan = Pemeliharaan::count(); // ← jumlah pemeliharaan

        // Ambil rekap kondisi sekaligus
        $rekapKondisi = DB::table('kondisi_barangs')
            ->select('kondisi', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $kondisiBaik = $rekapKondisi['baik'] ?? 0;
        $kondisiRusakRingan = $rekapKondisi['rusak_ringan'] ?? 0;
        $kondisiRusakBerat = $rekapKondisi['rusak_berat'] ?? 0;

        $barangTerbaru = Barang::with(['kategori', 'lokasi'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'jumlahBarang',
            'jumlahKategori',
            'jumlahLokasi',
            'jumlahUser',
            'jumlahPeminjaman',   // ← kirim ke view
            'jumlahPemeliharaan', // ← kirim ke view
            'kondisiBaik',
            'kondisiRusakRingan',
            'kondisiRusakBerat',
            'barangTerbaru'
        ));
    }
}
