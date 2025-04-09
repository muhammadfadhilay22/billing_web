<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('administrator.roles.index', compact('users'));
    }

    public function getPermissions($id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);
        $permissions = $user->roles->flatMap->permissions->pluck('name')->unique()->toArray();

        return response()->json([
            'permissions' => $permissions
        ]);
    }
}
