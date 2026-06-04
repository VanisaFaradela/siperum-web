<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $table = 'cluster';
    protected $primaryKey = 'id_cluster';
    protected $keyType = 'int';
    public $incrementing = true;
    
    protected $fillable = [
        'nama_cluster',
        'slug',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'luas_total',
        'total_unit',
        'unit_terjual',
        'unit_tersedia',
        'deskripsi',
        'fasilitas',
        'logo',
        'foto_utama',
        'foto_lainnya',
        'latitude',
        'longitude',
        'nama_pengembang',
        'kontak_pengembang',
        'email_pengembang',
        'website',
        'status',
        'sertifikat',
        'listrik',
        'akses_air_bersih',
        'keamanan_24jam',
        'one_gate_system',
        'tanggal_launching',
        'tanggal_serah_terima',
        'views'
    ];
    
    use HasImageUrl;

    protected $casts = [
        'foto_lainnya' => 'array',
        'akses_air_bersih' => 'boolean',
        'keamanan_24jam' => 'boolean',
        'one_gate_system' => 'boolean',
    ];
    
    // PERBAIKAN: foreign key dan local key harus SAMA-SAMA 'id_cluster'
    public function tipeRumah()
    {
        return $this->hasMany(TipeRumah::class, 'cluster_id', 'id_cluster');
        //                                          ↑ foreign key di tipe_rumah
        //                                                       ↑ local key di cluster
    }

    public function getLogoUrlAttribute()
    {
        return self::resolveImageUrl($this->logo);
    }

    public function getFotoUtamaUrlAttribute()
    {
        return self::resolveImageUrl($this->foto_utama);
    }

    public function getFotoLainnyaUrlsAttribute()
    {
        $fotos = $this->foto_lainnya;
        if (!is_array($fotos)) {
            return [];
        }
        return array_values(array_filter(array_map([self::class, 'resolveImageUrl'], $fotos)));
    }
    
    // 🔥 PERBAIKAN: Relasi ke berita, galeri, promo juga
    public function berita()
    {
        return $this->hasMany(Berita::class, 'cluster_id', 'id_cluster');
    }
    
    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'cluster_id', 'id_cluster');
    }
    
    public function promo()
    {
        return $this->hasMany(Promo::class, 'cluster_id', 'id_cluster');
    }
}