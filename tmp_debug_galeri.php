<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
foreach (App\Models\Galeri::orderBy('id_galeri', 'desc')->limit(5)->get() as $g) {
    echo $g->id_galeri . ' => ' . $g->gambar . PHP_EOL;
}

echo 'CHECK PATHS'.PHP_EOL;
$checks = ['uploads/galeri/1779023578_OIP.png','uploads/galeri/1778658725_download (4).jfif'];
foreach ($checks as $p) {
    echo $p . ' => public:' . (file_exists(__DIR__ . '/public/' . $p) ? 'ok' : 'missing');
    echo '; storage:' . (file_exists(__DIR__ . '/storage/app/public/' . $p) ? 'ok' : 'missing') . PHP_EOL;
}
