<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;

    protected $table = 'tb_costumer';
    protected $primaryKey = 'id_costumer';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Karena tidak ada created_at & updated_at

    protected $fillable = ['id_costumer', 'nama', 'username', 'password', 'stspajak'];

    // Relasi ke tabel tb_alamat
    public function alamat()
    {
        return $this->hasOne(Alamat::class, 'id_costumer', 'id_costumer');
    }

    // Relasi ke tabel tb_nomorhp
    public function nomorhp()
    {
        return $this->hasOne(NomorHp::class, 'id_costumer', 'id_costumer');
    }
}
