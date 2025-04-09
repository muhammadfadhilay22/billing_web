<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TbUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Menampilkan daftar user



    public function index()
    {
        // Memuat data pengguna dan relasi roles
        $users = TbUser::with('roles')->get();
        return view('administrator.users.index', compact('users'));
    }


    // Menampilkan form tambah user
    public function create()
    {
        return view('administrator.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namauser' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|string|min:6|confirmed',
            'nohp' => 'required|string|max:13',
            'cabang' => 'required|string|max:20',
            'alamat' => 'required|string',
            'role' => 'required|string|in:Admin,Sales,Kepala Gudang,Packing,Logistik,User Monitoring',
        ]);

        try {
            $user = TbUser::create([
                'id_user' => 'USR' . time(),
                'namauser' => $request->namauser,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nohp' => $request->nohp,
                'cabang' => $request->cabang,
                'alamat' => $request->alamat,
                'role' => $request->role, // Pastikan role dikirim
            ]);


            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // Menampilkan form edit user
    public function edit($id)
    {
        $user = TbUser::findOrFail($id);
        return view('administrator.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'namauser' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:tb_user,username,' . $id . ',id_user',
            'nohp' => 'required|string|max:13',
            'cabang' => 'required|string|max:20',
            'alamat' => 'required|string',
            'role' => 'required|string|max:10',
        ]);

        try {
            $user = TbUser::findOrFail($id);
            $user->update([
                'namauser' => $request->namauser,
                'username' => $request->username,
                'nohp' => $request->nohp,
                'cabang' => $request->cabang,
                'alamat' => $request->alamat,
                'role' => $request->role,
            ]);
            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus user
    public function destroy($id)
    {
        try {
            TbUser::destroy($id);
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
