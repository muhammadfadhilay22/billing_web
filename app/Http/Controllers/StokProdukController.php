<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokProduk;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StokProdukController extends Controller
{
    public function index()
    {
        $stokProduk = StokProduk::with(['produk.kategori'])->paginate(10);
        return view('administrator.stok.index', compact('stokProduk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('administrator.stok.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:tb_produk,id_produk',

        ]);

        try {
            DB::beginTransaction();

            StokProduk::create([
                'id_stok' => 'STK-' . strtoupper(Str::random(8)),
                'id_produk' => $request->id_produk,

                'stpusat' => 0,
                'stsemarang' => 0,
                'stsurabaya' => 0,
                'stbekasi' => 0,
                'stmakassar' => 0,
            ]);

            DB::commit();

            return redirect()->route('stok.index')->with('success', 'Stok berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan stok: ' . $e->getMessage());
            return back()->with('error', 'Gagal simpan stok: ' . $e->getMessage());
        }
    }

    public function getProdukByKategori(Request $request)
    {
        if (!$request->filled('kategori_id')) {
            return response()->json([]);
        }

        try {
            $produk = Produk::where('id_kategori', $request->kategori_id)
                ->select('id_produk', 'nama_produk')
                ->get();

            return response()->json($produk);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil produk berdasarkan kategori: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil produk.'], 500);
        }
    }

    public function edit($id)
    {
        $stok = StokProduk::with('produk.kategori')->where('id_stok', $id)->firstOrFail();
        $kategori = Kategori::all();

        return view('administrator.stok.edit', compact('stok', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_produk' => 'required|exists:tb_produk,id_produk',

        ]);

        try {
            $stok = StokProduk::where('id_stok', $id)->firstOrFail();

            $stok->update([
                'id_produk' => $request->id_produk,

            ]);

            return redirect()->route('stok.index')->with('success', 'Stok produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate stok produk: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengupdate stok.');
        }
    }

    public function destroy($id)
    {
        try {
            $stok = StokProduk::where('id_stok', $id)->firstOrFail();
            $stok->delete();

            return redirect()->route('stok.index')->with('success', 'Stok produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus stok produk: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus stok.');
        }
    }

    public function tambah(Request $request, $id)
    {
        $request->validate([
            'stpusat' => 'required|integer|min:1',
        ]);

        $stok = DB::table('tb_stokbarang')->where('id_stok', $id)->first();

        if (!$stok) {
            return back()->with('error', 'Data stok tidak ditemukan.');
        }

        DB::transaction(function () use ($stok, $request, $id) {
            DB::table('tb_stokbarang')
                ->where('id_stok', $id)
                ->update([

                    'stpusat' => $stok->stpusat + $request->stpusat,
                ]);
        });

        return back()->with('success', 'Stok berhasil ditambahkan.');
    }

    public function mutasi(Request $request, $id)
    {
        $lokasi = ['pusat', 'semarang', 'surabaya', 'bekasi', 'makassar'];

        $request->validate([
            'asal' => ['required', Rule::in($lokasi)],
            'tujuan' => ['required', Rule::in($lokasi), 'different:asal'],
            'jumlah' => 'required|integer|min:1',
        ]);

        $stok = DB::table('tb_stokbarang')->where('id_stok', $id)->first();

        if (!$stok) {
            return back()->with('error', 'Data stok tidak ditemukan.');
        }

        $asalField = 'st' . $request->asal;
        $tujuanField = 'st' . $request->tujuan;

        if ($stok->$asalField < $request->jumlah) {
            return back()->with('error', 'Stok asal tidak mencukupi.');
        }

        DB::transaction(function () use ($stok, $request, $id, $asalField, $tujuanField) {
            // Kurangi dari asal, tambahkan ke tujuan
            DB::table('tb_stokbarang')
                ->where('id_stok', $id)
                ->update([
                    $asalField => $stok->$asalField - $request->jumlah,
                    $tujuanField => $stok->$tujuanField + $request->jumlah,
                ]);
        });

        return back()->with('success', 'Mutasi stok berhasil.');
    }
}
