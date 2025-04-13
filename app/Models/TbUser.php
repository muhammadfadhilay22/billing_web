<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class TbUser extends Authenticatable
{
    use Notifiable, HasFactory, HasRoles;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string'; // UUID
    public $timestamps = false;

    // Guard default untuk Spatie Permission
    protected $guard_name = 'web';

    protected $fillable = [
        'id_user',
        'namauser',
        'alamat',
        'nohp',
        'cabang',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mutator: mengenkripsi password jika belum di-hash
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    /**
     * Accessor: menampilkan nama role pertama user
     */
    public function getRoleNameAttribute()
    {
        return $this->roles->pluck('name')->first();
    }
}
