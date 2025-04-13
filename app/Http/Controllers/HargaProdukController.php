<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaProduk;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;

class HargaProdukController extends Controller
{
    public function index()
    {
        $hargaProduk = HargaProduk::with('produk.kategori')->paginate(10);
        return view('administrator.harga.index', compact('hargaProduk'));
    }

    public function create()
    {
        $produk = Produk::all();
        $kategori = Kategori::all();
        return view('administrator.harga.create', compact('produk', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:tb_produk,id_produk|unique:tb_hrgbarang,id_produk',
            'hrg_smg' => 'required|numeric|min:0',
            'hrg_sby' => 'required|numeric|min:0',
            'hrg_mks' => 'required|numeric|min:0',
            'hrg_bks' => 'required|numeric|min:0',
        ]);

        HargaProduk::create([
            'id_harga' => 'HRG-' . Str::uuid(),
            'id_produk' => $request->id_produk,
            'hrg_smg' => $request->hrg_smg,
            'hrg_sby' => $request->hrg_sby,
            'hrg_mks' => $request->hrg_mks,
            'hrg_bks' => $request->hrg_bks,
        ]);

        return redirect()->route('harga.index')->with('success', 'Harga produk berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_harga' => 'required|exists:tb_hrgbarang,id_harga',
            'hrg_smg' => 'required|numeric|min:0',
            'hrg_sby' => 'required|numeric|min:0',
            'hrg_mks' => 'required|numeric|min:0',
            'hrg_bks' => 'required|numeric|min:0',
        ]);

        $harga = HargaProduk::findOrFail($request->id_harga);
        $harga->update([
            'hrg_smg' => $request->hrg_smg,
            'hrg_sby' => $request->hrg_sby,
            'hrg_mks' => $request->hrg_mks,
            'hrg_bks' => $request->hrg_bks,
        ]);

        return redirect()->back()->with('success', 'Harga produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $harga = HargaProduk::findOrFail($id);
        $harga->delete();
        return redirect()->route('harga.index')->with('success', 'Harga produk berhasil dihapus.');
    }
}
