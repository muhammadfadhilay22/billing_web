<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'tb_pesanan'; // Nama tabel di database
    protected $primaryKey = 'id_pesanan'; // Primary Key
    public $incrementing = false; // Karena ID berbentuk VARCHAR
    public $timestamps = false; // Jika tidak menggunakan timestamps

    protected $fillable = [
        'id_pesanan',
        'id_costumer',
        'id_sales',
        'id_user',
        'no_invoice'
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'id_costumer', 'id_costumer');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
