<?php
$url = 'http://127.0.0.1:8000/';
$html = @file_get_contents($url);
if ($html === false) { echo "FAILED_TO_FETCH\n"; exit(1); }
// Show whether uploads appear
$found = preg_match_all('/uploads\/[\w\-\. \/%]+/', $html, $m);
echo "FOUND_COUNT: $found\n";
$items = array_slice(array_unique($m[0]), 0, 40);
foreach ($items as $it) echo $it . PHP_EOL;
// Also print a small snippet around first occurrence
$pos = strpos($html, 'uploads/');
if ($pos !== false) {
    echo "\nSNIPPET:\n" . substr($html, max(0,$pos-100), 300) . PHP_EOL;
}
