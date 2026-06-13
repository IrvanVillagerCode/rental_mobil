<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_rental_mobil';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== Email Duplikat ===" . PHP_EOL;
$result = $conn->query('SELECT email, COUNT(*) as count FROM users GROUP BY email HAVING count > 1');
while ($row = $result->fetch_assoc()) {
    echo 'Email: ' . $row['email'] . ', Jumlah: ' . $row['count'] . PHP_EOL;
}

echo PHP_EOL . "=== Semua User ===" . PHP_EOL;
$result = $conn->query('SELECT id_user, email FROM users ORDER BY email');
while ($row = $result->fetch_assoc()) {
    echo 'ID: ' . $row['id_user'] . ', Email: ' . $row['email'] . PHP_EOL;
}
