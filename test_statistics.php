<?php
require 'vendor/autoload.php';
require 'app/Config/Constants.php';

$config = new \Config\Database();
$db = $config->connect();

echo "=== Cek Database Connection ===" . PHP_EOL;
$tables = $db->listTables();
echo 'Available tables: ' . implode(', ', $tables) . PHP_EOL;

if (in_array('mobil', $tables)) {
    echo PHP_EOL . "=== Cek Tabel Mobil ===" . PHP_EOL;
    $result = $db->table('mobil')->countAllResults();
    echo 'Total mobil di database: ' . $result . PHP_EOL;

    $tersedia = $db->table('mobil')->where('status_mobil', 'tersedia')->countAllResults();
    echo 'Mobil tersedia: ' . $tersedia . PHP_EOL;

    $disewa = $db->table('mobil')->where('status_mobil', 'disewa')->countAllResults();
    echo 'Mobil disewa: ' . $disewa . PHP_EOL;

    $perawatan = $db->table('mobil')->where('status_mobil', 'perawatan')->countAllResults();
    echo 'Mobil perawatan: ' . $perawatan . PHP_EOL;
} else {
    echo 'Tabel mobil tidak ditemukan!' . PHP_EOL;
}
