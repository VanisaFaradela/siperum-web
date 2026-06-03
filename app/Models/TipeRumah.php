<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class TipeRumah extends Model
{
    // Nama tabel di database
    protected $table = 'tipe_rumah';
    
    // Primary key tabel
    protected $primaryKey = 'id_tipe';
    
    // Tipe primary key
    protected $keyType = 'int';
    
    // Auto increment
    public $incrementing = true;
    
    protected $fillable = [
        'cluster_id',
        'nama_tipe',
        'slug',
        'luas_bangunan',
        'luas_tanah',
        'kamar_tidur',
        'kamar_mandi',
        'parkiran',
        'harga',
        'harga_promo',
        'deskripsi',
        'foto_denah',
        'foto_rumah',
        'total_unit',
        'unit_terjual',
        'unit_tersedia',
        'status',
        'blok',
        'nomor_unit',
        'status_unit'
    ];
    
    use HasImageUrl;

    protected $casts = [
        'foto_rumah' => 'array',
    ];
    
    // Relasi ke Cluster
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'cluster_id');
    }
    
    // Accessor untuk foto_tampak_depan (ambil gambar pertama dari array)
    public function getFotoTampakDepanAttribute()
    {
        $foto = $this->foto_rumah;
        if (is_array($foto) && !empty($foto)) {
            return $foto[0];
        }
        return null;
    }

    public function getFotoRumahUrlsAttribute()
    {
        $fotos = $this->foto_rumah;

        // If stored as JSON string (possibly double-encoded), try to decode
        if (is_string($fotos)) {
            $decoded = json_decode($fotos, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $fotos = $decoded;
            }
        }

        if (!is_array($fotos)) {
            return [];
        }

        // Normalize nested arrays and strings
        $flat = [];
        foreach ($fotos as $item) {
            if (is_array($item) && count($item) > 0) {
                // take scalar items inside
                foreach ($item as $sub) {
                    if (is_scalar($sub) && trim((string) $sub) !== '') $flat[] = $sub;
                }
            } elseif (is_scalar($item) && trim((string) $item) !== '') {
                $flat[] = $item;
            }
        }

        return array_values(array_filter(array_map([self::class, 'resolveImageUrl'], $flat)));
    }

    public function getFotoRumahUrlAttribute()
    {
        return $this->foto_rumah_urls[0] ?? null;
    }

    public function getFotoDenahUrlAttribute()
    {
        return self::resolveImageUrl($this->foto_denah);
    }
    
    // Accessor untuk denah
    public function getDenahAttribute()
    {
        return $this->foto_denah;
    }
}