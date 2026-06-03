<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasImageUrl;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'video',
        'status',
        'meta_data',
        'order',
    ];

    public function getFeaturedImageUrlAttribute()
    {
        return self::resolveImageUrl($this->featured_image);
    }
}