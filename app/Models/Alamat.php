<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'tb_alamat';
    protected $primaryKey = 'id_costumer';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_costumer', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'jalan'];

    public function costumer()
    {
        return $this->belongsTo(Costumer::class, 'id_costumer');
    }
}
