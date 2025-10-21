<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    // Tampilkan daftar peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with('barang')->latest()->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $barangs = Barang::all();
        return view('peminjaman.create', compact('barangs'));
    }

   public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('barang'); // pastikan relasi barang dimuat
        return view('peminjaman.show', compact('peminjaman'));
    }


// Simpan data peminjaman baru
public function store(Request $request)
{
    $request->validate([
        'barang_id'       => 'required|exists:barangs,id',
        'peminjam'        => 'required|string|max:255',
        'telepon'         => 'nullable|string|max:20', // validasi telepon
        'jumlah'          => 'required|integer|min:1',
        'tanggal_pinjam'  => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
    ]);

    $barang = Barang::findOrFail($request->barang_id);

    $stokBaik = $barang->kondisiBarang()->where('kondisi', 'baik')->first();

    if (!$stokBaik || $stokBaik->jumlah < $request->jumlah) {
        return back()->with('error', "Kondisi Barang tidak cocok dengan kriteria peminjaman !");
    }

    try {
        \DB::beginTransaction();

        // Kurangi stok
        $stokBaik->decrement('jumlah', $request->jumlah);

        // Simpan peminjaman termasuk telepon
        Peminjaman::create($request->only([
            'barang_id',
            'peminjam',
            'telepon', // ← tambahkan ini
            'jumlah',
            'tanggal_pinjam',
            'tanggal_kembali',
        ]) + [
            'status' => 'dipinjam',
        ]);

        \DB::commit();

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dicatat.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan saat memproses peminjaman: ' . $e->getMessage());
    }
}

// Update data peminjaman
public function update(Request $request, Peminjaman $peminjaman)
{
    $request->validate([
        'barang_id'       => 'required|exists:barangs,id',
        'peminjam'        => 'required|string|max:255',
        'telepon'         => 'nullable|string|max:20', // validasi telepon
        'jumlah'          => 'required|integer|min:1',
        'tanggal_pinjam'  => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
    ]);

    try {
        $peminjaman->update($request->only([
            'barang_id',
            'peminjam',
            'telepon', // ← tambahkan ini
            'jumlah',
            'tanggal_pinjam',
            'tanggal_kembali'
        ]));

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil diperbarui.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat memperbarui peminjaman: ' . $e->getMessage());
    }
}



    // Update status menjadi dikembalikan
   public function updateStatus(Peminjaman $peminjaman)
{
    try {
        \DB::beginTransaction();

        // Pastikan status belum dikembalikan sebelumnya
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('info', 'Barang ini sudah dikembalikan sebelumnya.');
        }

        // Ambil barang terkait
        $barang = $peminjaman->barang;

        // Ambil stok kondisi "baik"
        $stokBaik = $barang->kondisiBarang()->where('kondisi', 'baik')->first();

        // Jika belum ada kondisi baik, buat baru
        if (!$stokBaik) {
            $stokBaik = $barang->kondisiBarang()->create([
                'kondisi' => 'baik',
                'jumlah'  => 0
            ]);
        }

        // Tambahkan kembali jumlah yang dipinjam
        $stokBaik->increment('jumlah', $peminjaman->jumlah);

        // Update status peminjaman
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        \DB::commit();

        return back()->with('success', 'Barang berhasil dikembalikan dan stok diperbarui.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan saat mengembalikan barang: ' . $e->getMessage());
    }
}


    // Cetak laporan peminjaman
    public function cetakLaporan()
    {
        $peminjaman = Peminjaman::with(['barang' => function($query) {
            $query->with(['kategori', 'lokasi']);
        }])->get();

        $data = [
            'title'      => 'Laporan Data Peminjaman',
            'date'       => date('d F Y'),
            'peminjaman' => $peminjaman
        ];

        $pdf = Pdf::loadView('peminjaman.laporan', $data);
        return $pdf->stream('laporan-peminjaman.pdf');
    }

    // Form edit peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        $barangs = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    // Update data peminjaman
   

    // Hapus data peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        try {
            $peminjaman->delete();
            return redirect()->route('peminjaman.index')
                             ->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus peminjaman: ' . $e->getMessage());
        }
    }
}
