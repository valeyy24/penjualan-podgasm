<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'nama_barang', 
        'slug', // Tambahkan ini
        'harga_jual', 
        'stok_aktual', 
        'tgl_expired', 
        'tgl_cukai',
        'nilai_ss',
        'is_promo',
        'diskon_persen',
        'gambar'
    ];

    // 🔗 Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 💰 Harga setelah diskon
    public function getHargaDiskonAttribute()
    {
        if ($this->is_promo) {
            return $this->harga_jual - ($this->harga_jual * ($this->diskon_persen / 100));
        }

        return $this->harga_jual;
    }

    // 🖼️ Ambil URL gambar (biar blade lebih bersih)
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return null; // atau bisa kasih default image
    }
}