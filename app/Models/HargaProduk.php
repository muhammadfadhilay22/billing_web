<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class HargaProduk extends Model
{
    protected $table = 'tb_hrgbarang';
    protected $primaryKey = 'id_harga';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_harga',
        'id_produk',
        'hrg_smg',
        'hrg_sby',
        'hrg_mks',
        'hrg_bks',
    ];

    /**
     * Relasi ke produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
