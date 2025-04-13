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

    protected $table = 'tb_user'; // Nama tabel sesuai dengan DB
    protected $primaryKey = 'id_user'; // Primary key custom
    public $incrementing = false;
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
     * Otomatis hash password saat diset
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    /**
     * Override getAuthIdentifierName untuk Spatie permission compatibility
     */
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }
}
