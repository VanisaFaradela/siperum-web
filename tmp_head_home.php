<?php
$url='http://127.0.0.1:8000/';
$h=@get_headers($url,1);
if($h===false){echo "FAILED\n";exit(1);}foreach($h as $k=>$v){if(is_numeric($k)) echo $v.PHP_EOL; else echo "$k: ".(is_array($v)?implode('; ',$v):$v).PHP_EOL;}