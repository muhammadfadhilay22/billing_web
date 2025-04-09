<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Kategori; // pastikan model Kategori di-import

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
        $kategori = Kategori::all(); // ambil semua kategori
        return view('administrator.harga.create', compact('produk', 'kategori'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_harga' => 'required|exists:tb_hargaproduk,id_harga',
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
}
