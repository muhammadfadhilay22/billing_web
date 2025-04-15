<?php

namespace App\Http\Controllers;

use App\Models\TbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = TbUser::with('roles')->get();
        return view('administrator.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name'); // untuk select form
        return view('administrator.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namauser' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|confirmed',
            'nohp' => 'required|string|max:13',
            'cabang' => 'required|string',
            'alamat' => 'required|string',
            'role' => 'required|exists:roles,name',
        ]);

        // Menentukan awalan ID berdasarkan role
        $rolePrefix = $this->getRolePrefix($request->role);
        $userId = $rolePrefix . $this->generateUserId($rolePrefix);

        $user = TbUser::create([
            'id_user' => $userId,
            'namauser' => $request->namauser,
            'username' => $request->username,
            'password' => $request->password, // pastikan hash via mutator
            'nohp' => $request->nohp,
            'cabang' => $request->cabang,
            'alamat' => $request->alamat,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = TbUser::findOrFail($id);
        $roles = Role::pluck('name', 'name');
        $userRole = $user->roles->pluck('name')->first();

        return view('administrator.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $user = TbUser::findOrFail($id);

        $request->validate([
            'namauser' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_user,username,' . $id . ',id_user',
            'password' => 'nullable|confirmed|min:6',
            'nohp' => 'required|string|max:13',
            'cabang' => 'required|string',
            'alamat' => 'required|string',
            'role' => 'required|exists:roles,name',
        ]);

        $data = $request->only(['namauser', 'username', 'nohp', 'cabang', 'alamat']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        // Menyesuaikan role dan ID user jika role berubah
        if ($user->roles->pluck('name')->first() != $request->role) {
            $newRolePrefix = $this->getRolePrefix($request->role);
            $user->id_user = $newRolePrefix . $this->generateUserId($newRolePrefix);
            $user->save();
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = TbUser::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function permissions($id)
    {
        $user = TbUser::with(['roles', 'permissions'])->findOrFail($id);
        return view('administrator.users.permissions', compact('user'));
    }

    public function assignRoleToUser($userId, $roleName)
    {
        // Cari user berdasarkan ID
        $user = TbUser::find($userId);

        if ($user) {
            // Menetapkan role ke user
            $user->assignRole($roleName);

            return response()->json(['message' => 'Role assigned successfully.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }

    /**
     * Menentukan prefix berdasarkan role
     */
    private function getRolePrefix($role)
    {
        switch ($role) {
            case 'Master':
                return 'MAG-';
            case 'Admin':
                return 'AG-';
            case 'Logistik':
                return 'LG-';
            case 'Packing':
                return 'PG-';
            default:
                return 'GL-';
        }
    }

    /**
     * Menghasilkan nomor urut berdasarkan prefix
     */
    private function generateUserId($prefix)
    {
        $latestUser = TbUser::where('id_user', 'like', $prefix . '%')
            ->orderBy('id_user', 'desc')
            ->first();

        if ($latestUser) {
            $latestNumber = (int) substr($latestUser->id_user, -3);
            return str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return '001'; // jika tidak ada user sebelumnya
    }
}
