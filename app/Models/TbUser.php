<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class TbUser extends Authenticatable
{
    use HasFactory, HasRoles;  // Menggunakan HasRoles dengan benar

    protected $table = 'tb_user';  // Nama tabel sesuai dengan yang ada di database
    protected $primaryKey = 'id_user';  // Primary key yang sesuai
    public $incrementing = false;  // Karena id_user bukan auto-increment
    public $timestamps = false;  // Menonaktifkan timestamps jika tidak digunakan

    protected $fillable = [
        'id_user',
        'namauser',
        'username',
        'password',
        'nohp',
        'cabang',
        'alamat',
        'role',

    ];

    protected $hidden = [
        'password',
    ];

    // Relasi tambahan jika Anda perlu memuat data roles
    // Ini sudah otomatis disediakan oleh Spatie HasRoles, jadi tidak perlu menambahkannya lagi
}
