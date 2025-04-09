<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    use HasFactory;

    protected $table = 'tb_stokbarang';
    protected $primaryKey = 'id_stok';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_stok',
        'id_produk',
        'stpusat',
        'stsemarang',
        'stsurabaya',
        'stbekasi',
        'stmakassar',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
