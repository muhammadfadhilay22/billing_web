<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = DB::table('tb_supplier')->get();
        return view('administrator.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('administrator.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:50',
            'alamat' => 'required|string',
            'nohp'   => ['required', 'string', 'max:13', 'regex:/^(08|62)[0-9]{8,11}$/']
        ]);

        // Ambil ID terakhir dari database
        $lastSupplier = DB::table('tb_supplier')->orderBy('id_supplier', 'desc')->first();

        // Ambil nomor terakhir dan tambahkan 1
        if ($lastSupplier) {
            $lastNumber = (int) substr($lastSupplier->id_supplier, 4); // Ambil angka setelah "SGL-"
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format ID menjadi "SGL-XXX"
        $newId = 'SGL-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Insert data ke database
        DB::table('tb_supplier')->insert([
            'id_supplier' => $newId,
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'nohp'        => $request->nohp
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }
}
