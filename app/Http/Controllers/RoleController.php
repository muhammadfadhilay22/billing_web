<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions')->get(); // Load roles & permissions
        return view('administrator.role_permission', compact('users'));
    }

    public function getUserAccess($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        // Ambil permissions yang terkait dengan user melalui role
        $permissions = Permission::all()->pluck('name')->toArray();

        // Ambil permissions yang dimiliki user
        $userPermissions = $user->getPermissionNames()->toArray(); // Menggunakan Spatie's getPermissionNames

        return response()->json([
            'menus' => $permissions,  // Menampilkan daftar permissions sebagai menu
            'access' => $userPermissions // Menampilkan permissions yang sudah dimiliki user
        ]);
    }

    public function saveUserAccess(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $menus = $request->input('menus', []);

        // Pastikan user memiliki role sebelum mengupdate akses
        if ($user->roles->isEmpty()) {
            return response()->json(['error' => 'User tidak memiliki role'], 400);
        }

        // Update permissions langsung ke user tanpa melalui role
        $user->syncPermissions($menus);

        return response()->json([
            'message' => 'Akses berhasil diperbarui!'
        ]);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $allPermissions = Permission::all();
        return view('administrator.roles.show', compact('role', 'allPermissions'));
    }
}
