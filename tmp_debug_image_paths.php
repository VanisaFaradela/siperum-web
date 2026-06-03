<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$models = [
    'Perumahan' => App\Models\Perumahan::first(),
    'Page' => App\Models\Page::first(),
    'TipeRumah' => App\Models\TipeRumah::orderBy('id_tipe','desc')->limit(3)->get(),
    'Berita' => App\Models\Berita::orderBy('created_at','desc')->limit(3)->get(),
    'Galeri' => App\Models\Galeri::orderBy('id_galeri','desc')->limit(3)->get(),
    'Promo' => App\Models\Promo::orderBy('created_at','desc')->limit(3)->get(),
];
foreach ($models as $name => $data) {
    echo "==== $name ====" . PHP_EOL;
    if ($data === null) {
        echo "(no record)" . PHP_EOL;
        continue;
    }
    if ($data instanceof Illuminate\Database\Eloquent\Collection) {
        foreach ($data as $item) {
            echo $item->getKey() . ' => ' . json_encode($item->toArray()) . PHP_EOL;
        }
    } else {
        echo json_encode($data->toArray()) . PHP_EOL;
    }
}
