<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorHp extends Model
{
    use HasFactory;

    protected $table = 'tb_nomorhp';
    protected $primaryKey = 'id_costumer';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_costumer', 'nohp'];

    public function costumer()
    {
        return $this->belongsTo(Costumer::class, 'id_costumer', 'id_costumer');
    }
}
