<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$perumahan = App\Models\Perumahan::first();
$tipeRumah = App\Models\TipeRumah::with('perumahan')->limit(4)->get();
$promo = App\Models\Promo::active()->limit(3)->get();
$page = App\Models\Page::where('slug', 'tentang-kami')->first();
$berita = App\Models\Berita::where('status', 'published')->where(function($query) { $query->whereNull('jenis')->orWhere('jenis', '!=', 'promo'); })->orderBy('created_at', 'desc')->limit(3)->get();
$galeri = App\Models\Galeri::where('status', 'aktif')->orderBy('urutan', 'asc')->limit(8)->get();
$kategoriGaleri = Illuminate\Support\Facades\DB::table('galeri')->where('status', 'aktif')->whereNotNull('kategori')->distinct()->pluck('kategori');
$promoBerita = App\Models\Berita::where('status', 'published')->where('jenis', 'promo')->first();
$view = view('home', compact('perumahan', 'page', 'tipeRumah', 'berita', 'galeri', 'promoBerita'));
echo $view->render();
