<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class DiskonProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori', 'harga'])->paginate(10);
        return view('administrator.diskon.index', compact('produk'));
    }
}
