<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$items = [
    'Berita' => App\Models\Berita::first(),
    'Galeri' => App\Models\Galeri::first(),
    'Page' => App\Models\Page::first(),
    'TipeRumah' => App\Models\TipeRumah::first(),
    'Perumahan' => App\Models\Perumahan::first(),
];
foreach ($items as $name => $model) {
    echo "=== $name ===\n";
    if (!$model) { echo "null\n\n"; continue; }
    if ($name === 'Berita') echo 'gambar_url => ' . $model->gambar_url . PHP_EOL;
    if ($name === 'Galeri') echo 'gambar_url => ' . $model->gambar_url . PHP_EOL;
    if ($name === 'Page') echo 'featured_image_url => ' . $model->featured_image_url . PHP_EOL;
    if ($name === 'TipeRumah') {
        echo 'foto_denah_url => ' . $model->foto_denah_url . PHP_EOL;
        echo 'foto_rumah_url => ' . $model->foto_rumah_url . PHP_EOL;
        echo 'foto_rumah_urls => ' . json_encode($model->foto_rumah_urls) . PHP_EOL;
    }
    if ($name === 'Perumahan') {
        echo 'logo_url => ' . $model->logo_url . PHP_EOL;
        echo 'foto_utama_url => ' . $model->foto_utama_url . PHP_EOL;
    }
    echo PHP_EOL;
}
