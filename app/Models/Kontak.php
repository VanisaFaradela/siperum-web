<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $primaryKey = 'id_kontak';
    
    protected $fillable = [
        'nama_pengunjung', 'email', 'nomor_hp', 'pesan',
        'tanggal_kirim', 'status', 'dibaca_pada', 'balasan', 'dibalas_pada'
    ];
    
    protected $casts = [
        'tanggal_kirim' => 'date',
        'dibaca_pada' => 'datetime',
        'dibalas_pada' => 'datetime',
    ];
    
    public function getRouteKeyName()
    {
        return 'id_kontak';
    }
    
    // Accessor untuk nama (konsisten dengan form)
    public function getNamaAttribute()
    {
        return $this->nama_pengunjung;
    }
    
    // Accessor untuk nomor_hp
    public function getNomorHpAttribute()
    {
        return $this->nomor_hp;
    }
    
    // Accessor untuk tanggal_kirim
    public function getTanggalKirimAttribute()
    {
        return $this->tanggal_kirim ?? $this->created_at;
    }
}