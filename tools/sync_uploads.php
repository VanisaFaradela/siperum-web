<?php
// Simple script to sync uploads/tipe-rumah from another project into this project's public/uploads/tipe-rumah
// Usage: php sync_uploads.php "C:\laragon\www\perumahan\public\uploads\tipe-rumah"

$cwd = dirname(__DIR__);

$defaultCandidates = [
    $cwd . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'perumahan' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'tipe-rumah',
    'C:\\laragon\\www\\perumahan\\public\\uploads\\tipe-rumah',
];

$src = $argv[1] ?? null;
if (!$src) {
    foreach ($defaultCandidates as $c) {
        if (is_dir($c)) { $src = $c; break; }
    }
}

if (!$src) {
    echo "Source folder not provided and default candidates not found.\n";
    echo "Usage: php sync_uploads.php " . "\"C:\\path\\to\\perumahan\\public\\uploads\\tipe-rumah\"\n";
    exit(1);
}

$src = rtrim($src, "\/\\");
$dst = $cwd . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'tipe-rumah';

if (!is_dir($src)) {
    echo "Source folder does not exist: $src\n";
    exit(1);
}

if (!is_dir($dst)) {
    if (!mkdir($dst, 0755, true)) {
        echo "Failed to create destination folder: $dst\n";
        exit(1);
    }
}

$exts = ['jpg','jpeg','png','gif','webp','svg'];
$files = [];
foreach ($exts as $ext) {
    foreach (glob($src . DIRECTORY_SEPARATOR . "*.{$ext}") as $f) $files[] = $f;
}

if (empty($files)) {
    echo "No image files found in source: $src\n";
    exit(0);
}

$copied = 0;
foreach ($files as $file) {
    $name = basename($file);
    $destFile = $dst . DIRECTORY_SEPARATOR . $name;
    if (!file_exists($destFile) || filemtime($file) > filemtime($destFile)) {
        if (!copy($file, $destFile)) {
            echo "Failed to copy: $file -> $destFile\n";
        } else {
            touch($destFile, filemtime($file));
            $copied++;
        }
    }
}

echo "Synced $copied files to $dst\n";
echo "You can now refresh the tipe detail page.\n";
