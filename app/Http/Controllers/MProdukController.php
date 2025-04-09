<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class MProdukController extends Controller
{
    public function index()
{
    $produk = Produk::with(['kategori', 'harga'])->paginate(10);
    return view('administrator.mproduk.index', compact('produk'));
}

}
