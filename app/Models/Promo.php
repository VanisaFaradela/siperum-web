<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasImageUrl;

    protected $table = 'promo';
    protected $primaryKey = 'id_promo';

    protected $fillable = [
        'id_perumahan',
        'judul_promo',
        'badge',
        'deskripsi',
        'harga_awal',
        'harga_promo',
        'diskon_persen',
        'gambar',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'stok',
        'syarat_ketentuan',
    ];

    protected $casts = [
        'harga_awal' => 'integer',
        'harga_promo' => 'integer',
        'diskon_persen' => 'integer',
        'stok' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class, 'id_perumahan', 'id_perumahan');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('tanggal_mulai')
                      ->orWhere('tanggal_mulai', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('tanggal_berakhir')
                      ->orWhere('tanggal_berakhir', '>=', now());
            });
    }

    public function getGambarUrlAttribute()
    {
        return self::resolveImageUrl($this->gambar, 'promo');
    }
}
