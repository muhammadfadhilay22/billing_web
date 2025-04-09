<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Costumer;
use App\Models\User;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        $pesanan = Pesanan::with(['customer', 'user'])->paginate(10);
        return view('administrator.pesanan.index', compact('pesanan'));
    }

    // Menampilkan form tambah pesanan
    public function create()
    {
        $customers = Costumer::all();
        $users = User::all();
        $produk = Produk::all(); // Pastikan ini ada
        return view('administrator.pesanan.create', compact('customers', 'produk', 'users'));
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'no_invoice'  => 'required|string|max:20',
            'id_costumer' => 'required|exists:tb_customer,id_costumer',

            'id_user'     => 'nullable|exists:tb_user,id_user',
        ]);

        $pesanan = Pesanan::create([
            'no_invoice' => $request->no_invoice,
            'id_costumer' => $request->id_costumer,
            'id_user' => $request->id_user
        ]);

        foreach ($request->id_produk as $index => $id_produk) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $id_produk,
                'jumlah' => $request->jumlah[$index],
                'subtotal' => Produk::find($id_produk)->harga * $request->jumlah[$index]
            ]);
        }

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    // Menampilkan form edit pesanan
    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $costumers = Costumer::all();
        $users = User::all();
        return view('administrator.pesanan.edit', compact('pesanan', 'customers', 'users'));
    }

    // Memperbarui pesanan
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_invoice'  => 'required|string|max:20',
            'id_costumer' => 'required|exists:tb_customer,id_costumer',

            'id_user'     => 'nullable|exists:tb_user,id_user',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'no_invoice'  => $request->no_invoice,
            'id_costumer' => $request->id_costumer,

            'id_user'     => $request->id_user,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        Pesanan::findOrFail($id)->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function cetakInvoice($id)
    {
        $pesanan = Pesanan::with(['customer', 'sales', 'produk'])->findOrFail($id);

        return view('pesanan.cetak_invoice', compact('pesanan'));
    }
}
