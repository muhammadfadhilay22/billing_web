<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'tb_kategori'; // Sesuaikan dengan tabel di database
    protected $primaryKey = 'id_kategori';
    public $incrementing = false; // Non-auto increment karena pakai format KTG-001
    public $timestamps = false; // Tidak menggunakan timestamps

    protected $fillable = ['id_kategori', 'nama_kategori', 'deskripsi'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
