<?php
$mysqli = new mysqli('127.0.0.1','root','','perumahan');
if ($mysqli->connect_errno) {
    echo 'CONNECT ERROR: ' . $mysqli->connect_error . PHP_EOL;
    exit(1);
}
$res = $mysqli->query('SHOW TABLES');
if (!$res) {
    echo 'QUERY ERROR: ' . $mysqli->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_array()) {
    echo $row[0] . PHP_EOL;
}
$mysqli->close();
