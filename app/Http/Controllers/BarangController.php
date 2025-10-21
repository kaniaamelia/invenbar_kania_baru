<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BarangController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage barang', except: ['destroy']),
            new Middleware('permission:delete barang', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $barangs = Barang::with(['kategori', 'lokasi', 'kondisiBarang'])
            ->when($search, function ($query, $search) {
                $query->where('nama_barang', 'like', '%' . $search . '%')
                      ->orWhere('kode_barang', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $barang = new Barang();

        return view('barang.create', compact('barang', 'kategori', 'lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'satuan'               => 'required|string|max:20',
            'tanggal_pengadaan'    => 'required|date',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kondisi_baik'         => 'required|integer|min:0',
            'kondisi_rusak_ringan' => 'required|integer|min:0',
            'kondisi_rusak_berat'  => 'required|integer|min:0',
            'sumber_dana'          => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store(null, 'gambar-barang');
        }

        DB::transaction(function () use ($validated) {
            $barang = Barang::create([
                'kode_barang' => $validated['kode_barang'],
                'nama_barang' => $validated['nama_barang'],
                'kategori_id' => $validated['kategori_id'],
                'lokasi_id'   => $validated['lokasi_id'],
                'satuan'      => $validated['satuan'],
                'tanggal_pengadaan' => $validated['tanggal_pengadaan'],
                'gambar'      => $validated['gambar'] ?? null,
                'sumber_dana' => $validated['sumber_dana'] ?? null, // ✅ Tambahkan ini
            ]);

            // Simpan kondisi barang
            if ($validated['kondisi_baik'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'baik',
                    'jumlah'  => $validated['kondisi_baik']
                ]);
            }

            if ($validated['kondisi_rusak_ringan'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'rusak_ringan',
                    'jumlah'  => $validated['kondisi_rusak_ringan']
                ]);
            }

            if ($validated['kondisi_rusak_berat'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'rusak_berat',
                    'jumlah'  => $validated['kondisi_rusak_berat']
                ]);
            }
        });

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi', 'kondisiBarang']);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'          => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'          => 'required|string|max:150',
            'kategori_id'          => 'required|exists:kategoris,id',
            'lokasi_id'            => 'required|exists:lokasis,id',
            'satuan'               => 'required|string|max:20',
            'tanggal_pengadaan'    => 'required|date',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kondisi_baik'         => 'required|integer|min:0',
            'kondisi_rusak_ringan' => 'required|integer|min:0',
            'kondisi_rusak_berat'  => 'required|integer|min:0',
            'sumber_dana'          => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated, $request, $barang) {
            if ($request->hasFile('gambar')) {
                if ($barang->gambar) {
                    Storage::disk('gambar-barang')->delete($barang->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store(null, 'gambar-barang');
            }

            $barang->update([
                'kode_barang' => $validated['kode_barang'],
                'nama_barang' => $validated['nama_barang'],
                'kategori_id' => $validated['kategori_id'],
                'lokasi_id'   => $validated['lokasi_id'],
                'satuan'      => $validated['satuan'],
                'tanggal_pengadaan' => $validated['tanggal_pengadaan'],
                'gambar'      => $validated['gambar'] ?? $barang->gambar,
                'sumber_dana' => $validated['sumber_dana'] ?? null, // ✅ Tambahkan ini juga
            ]);

            // Reset kondisi lama
            $barang->kondisiBarang()->delete();

            // Simpan kondisi baru
            if ($validated['kondisi_baik'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'baik',
                    'jumlah'  => $validated['kondisi_baik']
                ]);
            }

            if ($validated['kondisi_rusak_ringan'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'rusak_ringan',
                    'jumlah'  => $validated['kondisi_rusak_ringan']
                ]);
            }

            if ($validated['kondisi_rusak_berat'] > 0) {
                $barang->kondisiBarang()->create([
                    'kondisi' => 'rusak_berat',
                    'jumlah'  => $validated['kondisi_rusak_berat']
                ]);
            }
        });

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('gambar-barang')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }

    public function cetakLaporan()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->get();

        $data = [
            'title'   => 'Laporan Data Barang Inventaris',
            'date'    => date('d F Y'),
            'barangs' => $barangs,
        ];

        $pdf = Pdf::loadView('barang.laporan', $data);

        return $pdf->stream('laporan-inventaris-barang.pdf');
    }
}
