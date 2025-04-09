<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->paginate(10);
        return view('administrator.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('administrator.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'nama_produk' => 'required|string|max:50',
            'satuan' => 'required|string|max:10',
            'berat' => 'required|numeric|min:0.01',
        ]);

        // Generate ID Produk
        $lastProduk = Produk::latest('id_produk')->first();
        if ($lastProduk) {
            $lastNumber = (int) substr($lastProduk->id_produk, 2);
            $newIdProduk = 'P-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newIdProduk = 'P-001';
        }

        // Simpan produk ke tb_produk
        Produk::create([
            'id_produk' => $newIdProduk,
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'satuan' => $request->satuan,
            'berat' => $request->berat,
        ]);

        // Tambahkan entri stok awal ke tb_stokbarang
        DB::table('tb_stokbarang')->insert([
            'id_stok' => uniqid('ST-'),
            'id_produk' => $newIdProduk,
            'stpusat' => 0,
            'stsemarang' => 0,
            'stsurabaya' => 0,
            'stbekasi' => 0,
            'stmakassar' => 0,
        ]);

        // Tambahkan entri harga awal ke tb_hrgbarang
        DB::table('tb_hrgbarang')->insert([
            'id_harga' => uniqid('HRG-'),
            'id_produk' => $newIdProduk,
            'hrg_smg' => 0,
            'hrg_sby' => 0,
            'hrg_mks' => 0,
            'hrg_bks' => 0,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan, stok awal dan harga awal telah dibuat!');
    }

    public function edit($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        $kategori = Kategori::all();
        return view('administrator.produk.edit', compact('produk', 'kategori'));
    }

    public function getProdukByKategori($kategori_id)
    {
        $produk = Produk::where('id_kategori', $kategori_id)
            ->get(['id_produk', 'nama_produk']);

        return response()->json($produk, 200);
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::where('id_produk', $id)->firstOrFail();
            $produk->delete();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus produk: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }
}
