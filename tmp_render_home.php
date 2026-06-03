<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$controller = new App\Http\Controllers\HomeController();
$response = $controller->index();
if (is_string($response)) {
    echo $response;
} elseif (method_exists($response, 'getContent')) {
    echo $response->getContent();
} else {
    echo 'NO CONTENT';
}
