<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$models = [
    'Perumahan' => App\Models\Perumahan::first(),
    'Berita' => App\Models\Berita::first(),
    'Galeri' => App\Models\Galeri::first(),
    'Page' => App\Models\Page::first(),
    'Promo' => App\Models\Promo::first(),
    'TipeRumah' => App\Models\TipeRumah::first(),
];
foreach ($models as $name => $model) {
    echo "=== $name ===\n";
    if (!$model) {
        echo "null\n\n";
        continue;
    }
    $attrs = $model->getAttributes();
    foreach ($attrs as $attr => $value) {
        if (stripos($attr, 'gambar') !== false || stripos($attr, 'foto') !== false || stripos($attr, 'image') !== false) {
            echo "$attr => $value\n";
        }
    }
    echo "\n";
}
