<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id', // Pastikan ini pakai 'u'
        'user_id', 
        'jumlah', 
        'prioritas', 
        'status', 
        'keterangan', 
        'tgl_estimasi'
    ];

    public function produk()
    {
        // REVISI: Samakan foreign key-nya dengan yang ada di fillable & migration
        return $this->belongsTo(Product::class, 'produk_id'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}