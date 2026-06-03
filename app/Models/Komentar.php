<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $primaryKey = 'id_komentar';
    
    protected $fillable = [
        'id_berita',
        'parent_id',
        'nama',
        'email',
        'komentar',
        'is_approved'
    ];
    
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita', 'id');
    }
    
    public function replies()
    {
        return $this->hasMany(Komentar::class, 'parent_id', 'id_komentar');
    }
    
    public function parent()
    {
        return $this->belongsTo(Komentar::class, 'parent_id', 'id_komentar');
    }
}