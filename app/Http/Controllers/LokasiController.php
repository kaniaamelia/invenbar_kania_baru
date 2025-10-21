<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LokasiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view lokasi', only: ['index', 'show']),
            new Middleware('permission:manage lokasi', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $lokasis = Lokasi::when($search, function ($query, $search) {
                $query->where('nama_lokasi', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        $lokasi = new Lokasi();
        return view('lokasi.create', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100|unique:lokasis,nama_lokasi',
        ]);

        Lokasi::create($validated);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    public function show(Lokasi $lokasi)
    {
        // Load barang dengan relasi kategori untuk menampilkan nama kategori
        $barangs = $lokasi->barang()
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('lokasi.show', compact('lokasi', 'barangs'));
    }

    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100|unique:lokasis,nama_lokasi,' . $lokasi->id,
        ]);

        $lokasi->update($validated);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }
    
    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->barang()->exists()) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $lokasi->delete();

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }

    // Tambahan: Ambil barang berdasarkan lokasi (untuk AJAX)
    public function getBarang($lokasiId)
    {
        $lokasi = Lokasi::find($lokasiId);

        if (!$lokasi) {
            return response()->json(['error' => 'Lokasi tidak ditemukan.'], 404);
        }

        $barang = $lokasi->barang()->with('kategori')->get();

        return response()->json($barang);
    }
}
