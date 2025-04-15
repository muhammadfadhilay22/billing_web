<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Costumer;
use App\Models\User;
use App\Models\Produk;
use App\Models\DetailPesanan;

class StsPesananController extends Controller
{
    public function index()
    {
        $stspesanan = Pesanan::with(['customer', 'user'])->paginate(10);
        return view('administrator.stspesanan.index', compact('stspesanan'));
    }

    public function create()
    {
        $customers = Costumer::all();
        $users = User::all();
        $produk = Produk::all();
        return view('administrator.stspesanan.create', compact('customers', 'produk', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_invoice'  => 'required|string|max:20',
            'id_costumer' => 'required|exists:tb_customer,id_costumer',
            'id_user'     => 'nullable|exists:tb_user,id_user',
        ]);

        $stspesanan = Pesanan::create([
            'no_invoice' => $request->no_invoice,
            'id_costumer' => $request->id_costumer,
            'id_user' => $request->id_user
        ]);

        foreach ($request->id_produk as $index => $id_produk) {
            DetailPesanan::create([
                'id_pesanan' => $stspesanan->id_pesanan,
                'id_produk' => $id_produk,
                'jumlah' => $request->jumlah[$index],
                'subtotal' => Produk::find($id_produk)->harga * $request->jumlah[$index]
            ]);
        }

        return redirect()->route('stspesanan.index')->with('success', 'Status pesanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stspesanan = Pesanan::findOrFail($id);
        $customers = Costumer::all();
        $users = User::all();
        return view('administrator.stspesanan.edit', compact('stspesanan', 'customers', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_invoice'  => 'required|string|max:20',
            'id_costumer' => 'required|exists:tb_customer,id_costumer',
            'id_user'     => 'nullable|exists:tb_user,id_user',
        ]);

        $stspesanan = Pesanan::findOrFail($id);
        $stspesanan->update([
            'no_invoice'  => $request->no_invoice,
            'id_costumer' => $request->id_costumer,
            'id_user'     => $request->id_user,
        ]);

        return redirect()->route('stspesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pesanan::findOrFail($id)->delete();
        return redirect()->route('stspesanan.index')->with('success', 'Status pesanan berhasil dihapus.');
    }

    public function cetakInvoice($id)
    {
        $stspesanan = Pesanan::with(['customer', 'user', 'produk'])->findOrFail($id);
        return view('administrator.stspesanan.cetak_invoice', compact('stspesanan'));
    }
}
