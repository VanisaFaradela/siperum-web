<?php
// Sync entire uploads folder (recursively) from another project into this project's public/uploads
// Usage: php sync_all_uploads.php "C:\\laragon\\www\\perumahan\\public\\uploads"

$cwd = dirname(__DIR__);

$defaultCandidates = [
    $cwd . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'perumahan' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads',
    'C:\\laragon\\www\\perumahan\\public\\uploads',
];

$src = $argv[1] ?? null;
if (!$src) {
    foreach ($defaultCandidates as $c) {
        if (is_dir($c)) { $src = $c; break; }
    }
}

if (!$src) {
    echo "Source uploads folder not provided and default candidates not found.\n";
    echo "Usage: php sync_all_uploads.php \"C:\\path\\to\\perumahan\\public\\uploads\"\n";
    exit(1);
}

$src = rtrim($src, "\/\\");
$dst = $cwd . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads';

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

function rr_copy($src, $dst) {
    $dir = opendir($src);
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    while(false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $s = $src . DIRECTORY_SEPARATOR . $file;
            $d = $dst . DIRECTORY_SEPARATOR . $file;
            if (is_dir($s)) {
                rr_copy($s, $d);
            } else {
                if (!file_exists($d) || filemtime($s) > filemtime($d)) {
                    copy($s, $d);
                    touch($d, filemtime($s));
                }
            }
        }
    }
    closedir($dir);
}

echo "Syncing uploads from: $src\n";
rr_copy($src, $dst);
echo "Sync complete. Files copied to: $dst\n";
echo "Refresh your pages to load the copied assets.\n";
