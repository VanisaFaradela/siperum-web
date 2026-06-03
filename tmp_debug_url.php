<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Page;

$b = Berita::orderBy('created_at','desc')->first();
$g = Galeri::orderBy('created_at','desc')->first();
print_r(['berita' => $b->gambar, 'url' => $b->gambar_url]);
print_r(['galeri' => $g->foto, 'url' => $g->gambar_url]);
$p = Page::first();
print_r(['page' => $p->featured_image, 'url' => $p->featured_image_url]);
