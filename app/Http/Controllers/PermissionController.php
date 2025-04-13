<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('administrator.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('administrator.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil ditambahkan.');
    }

    public function edit(Permission $permission)
    {
        return view('administrator.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus.');
    }

    public function assignPermission(Request $request, $roleId)
    {
        $request->validate([
            'permission_name' => 'required|string',
        ]);

        // Temukan role berdasarkan ID
        $role = Role::findOrFail($roleId);

        // Buat permission jika belum ada
        $permission = Permission::firstOrCreate(['name' => $request->permission_name]);

        // Cek apakah role sudah memiliki permission
        if ($role->hasPermissionTo($permission->name)) {
            return redirect()->back()->with('info', 'Role sudah memiliki permission ini.');
        }

        // Berikan permission ke role
        $role->givePermissionTo($permission);

        return redirect()->back()->with('success', 'Permission berhasil diberikan ke role.');
    }
}
