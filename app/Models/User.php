<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user'; // Sesuaikan dengan nama tabel kamu

    protected $primaryKey = 'id_user';
    public $incrementing = false; // Karena id_user bukan auto increment
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
    ];
}
