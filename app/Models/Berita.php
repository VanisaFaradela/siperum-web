<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'kategori',
        'penulis',
        'status',
        'jenis',
        'tanggal_mulai_promo',
        'tanggal_berakhir_promo',
        'popup',
        'views',
        'published_at'
    ];
    
    protected $casts = [
        'views' => 'integer',
    ];
    
    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class, 'id_perumahan', 'id_perumahan');
    }
    
    
    // Scope untuk berita yang sudah dipublish (menggunakan created_at sebagai pengganti published_at)
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    // Accessor untuk isi_berita
    public function getIsiBeritaAttribute()
    {
        return $this->konten;
    }
    
    // Accessor untuk tanggal_publikasi (menggunakan created_at)
    public function getTanggalPublikasiAttribute()
    {
        return $this->created_at;
    }
    
    // Accessor untuk published_at (fallback ke created_at)
    public function getPublishedAtAttribute()
    {
        return $this->created_at;
    }

    use HasImageUrl;

    // Accessor untuk gambar_url
    public function getGambarUrlAttribute()
    {
        return self::resolveImageUrl($this->gambar);
    }

    // Scope untuk mengambil promo aktif
    public function scopePromoAktif($query)
    {
        return $query->where('status', 'published')
            ->where('jenis', 'promo')
            ->where('popup', 'ya')
            ->where(function($q) {
                $q->whereNull('tanggal_mulai_promo')
                  ->orWhere('tanggal_mulai_promo', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('tanggal_berakhir_promo')
                  ->orWhere('tanggal_berakhir_promo', '>=', now());
            });
    }
}