<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::paginate(10);
        return view('administrator.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('administrator.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:tb_kategori,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        // Buat ID Kategori dengan format "KTG-001"
        $lastKategori = Kategori::orderBy('id_kategori', 'desc')->first();
        if ($lastKategori) {
            $lastNumber = (int) substr($lastKategori->id_kategori, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $newId = 'KTG-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Kategori::create([
            'id_kategori'   => $newId,
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id); // atau TbKategori tergantung modelmu
        return view('administrator.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($id); // id_kategori diambil secara manual

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
