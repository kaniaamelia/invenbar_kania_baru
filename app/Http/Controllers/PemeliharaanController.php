<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemeliharaanController extends Controller
{
    /**
     * Tampilkan semua data pemeliharaan
     */
    public function index()
    {
        $pemeliharaan = Pemeliharaan::with('barang')->latest()->get();
        return view('pemeliharaan.index', compact('pemeliharaan'));
    }

    /**
     * Tampilkan form tambah pemeliharaan
     */
    public function create()
    {
        $barang = Barang::all();
        $statusOptions = ['Pemeriksaan', 'Pembersihan', 'Perbaikan'];
        $jenisOptions = ['Rutin', 'Darurat', 'Perbaikan'];
        return view('pemeliharaan.create', compact('barang', 'statusOptions', 'jenisOptions'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Pemeriksaan,Pembersihan,Perbaikan',
            'jenis' => 'required|in:Rutin,Darurat,Perbaikan',
            'biaya_operasional' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Pemeliharaan::create([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'jenis' => $request->jenis,
            'biaya_operasional' => $request->biaya_operasional ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pemeliharaan.index')
                         ->with('success', 'Data pemeliharaan berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu pemeliharaan
     */
    public function show(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->load('barang');
        return view('pemeliharaan.show', compact('pemeliharaan'));
    }

    /**
     * Form edit
     */
    public function edit(Pemeliharaan $pemeliharaan)
    {
        $barang = Barang::all();
        $statusOptions = ['Pemeriksaan', 'Pembersihan', 'Perbaikan'];
        $jenisOptions = ['Rutin', 'Darurat', 'Perbaikan'];
        return view('pemeliharaan.edit', compact('pemeliharaan', 'barang', 'statusOptions', 'jenisOptions'));
    }

    /**
     * Update data
     */
    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Pemeriksaan,Pembersihan,Perbaikan,Selesai',
            'jenis' => 'required|in:Rutin,Darurat,Perbaikan',
            'biaya_operasional' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $pemeliharaan->update([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'jenis' => $request->jenis,
            'biaya_operasional' => $request->biaya_operasional ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pemeliharaan.index')
                         ->with('success', 'Data pemeliharaan berhasil diperbarui.');
    }

    /**
     * Tandai pemeliharaan sebagai selesai
     */
    public function selesaikan(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->update(['status' => 'Selesai']);

        return redirect()->route('pemeliharaan.index')
                         ->with('success', 'Pemeliharaan telah diselesaikan.');
    }

    /**
     * Hapus data
     */
    public function destroy(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->delete();

        return redirect()->route('pemeliharaan.index')
                         ->with('success', 'Data pemeliharaan berhasil dihapus.');
    }

    /**
     * Laporan PDF - semua pemeliharaan
     */
    public function laporanPdf()
    {
        // Ambil semua data termasuk biaya_operasional
        $pemeliharaan = Pemeliharaan::with('barang.kategori', 'barang.lokasi')
            ->select('id', 'barang_id', 'tanggal', 'status', 'jenis', 'biaya_operasional')
            ->get();

        $title = "Laporan Pemeliharaan Barang";
        $date = date('d/m/Y');

        $pdf = Pdf::loadView('pemeliharaan.laporan', compact('pemeliharaan', 'title', 'date'));
        return $pdf->stream('laporan-pemeliharaan.pdf');
    }
}
