<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_rental_mobil';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== Struktur Table Users ===" . PHP_EOL;
$result = $conn->query('DESCRIBE users');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Key'] . PHP_EOL;
}

echo PHP_EOL . "=== Constraints ===" . PHP_EOL;
$result = $conn->query("SELECT CONSTRAINT_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME='users' AND TABLE_SCHEMA='db_rental_mobil'");
while ($row = $result->fetch_assoc()) {
    echo $row['CONSTRAINT_NAME'] . ': ' . $row['COLUMN_NAME'] . PHP_EOL;
}
