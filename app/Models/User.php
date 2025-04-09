<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasFactory;

    protected $table = 'tb_user'; // Sesuaikan dengan nama tabel kamu

    protected $primaryKey = 'id_user';
    public $incrementing = false; // id_user bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'namauser',
        'alamat',
        'nohp',
        'cabang',
        'role',
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatically hash password when set
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }
}
