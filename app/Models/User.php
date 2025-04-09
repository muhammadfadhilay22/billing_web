<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_user';

    protected $fillable = ['name', 'username', 'email', 'password'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function accessibleMenus()
    {
        return $this->roles->flatMap->menus->pluck('name')->unique();
    }
}
