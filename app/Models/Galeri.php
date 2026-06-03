<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    
    protected $fillable = [
        'id_perumahan', 'judul_galeri', 'foto', 'kategori_foto', 'kategori', 'urutan', 'status', 'tanggal_upload'
    ];
    
    use HasImageUrl;

    // Accessor untuk konsistensi dengan view
    public function getJudulAttribute()
    {
        return $this->judul_galeri;
    }
    
    public function getGambarAttribute()
    {
        return $this->foto;
    }
    
    public function getGambarUrlAttribute()
    {
        return self::resolveImageUrl($this->foto);
    }

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class, 'id_perumahan', 'id_perumahan');
    }
}