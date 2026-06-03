<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$paths = [
    'uploads/berita/1778658876_download.jfif',
    'uploads/galeri/1778658664_pexels-rasul70-30426247.jpg',
    'uploads/pages/1778929061_cover.jpg',
    'uploads/tipe-rumah/1778939585_denah_pexels-raufik-35018312.jpg',
];
foreach ($paths as $path) {
    echo $path . ' => public: ' . (file_exists(public_path($path)) ? 'ok' : 'missing') . ' | storage: ' . (file_exists(public_path('storage/' . $path)) ? 'ok' : 'missing') . PHP_EOL;
}
