<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tb_produk';
    protected $primaryKey = 'id_produk';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'id_kategori',
        'nama_produk',
        'satuan',
        'berat',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke stok produk (satu produk punya satu stok)
    public function stokProduk()
    {
        return $this->hasOne(StokProduk::class, 'id_produk', 'id_produk');
    }

    // Relasi ke harga produk
    public function harga()
    {
        return $this->hasOne(HargaProduk::class, 'id_produk', 'id_produk');
    }
}
