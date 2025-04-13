<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        return view('administrator.roles.index', compact('roles'));
    }


    public function getPermissions($id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);
        $permissions = $user->roles->flatMap->permissions->pluck('name')->unique()->toArray();

        return response()->json([
            'permissions' => $permissions
        ]);
    }

    public function show($id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        $allPermissions = \Spatie\Permission\Models\Permission::all();

        return view('administrator.roles.show', compact('role', 'allPermissions'));
    }
}
