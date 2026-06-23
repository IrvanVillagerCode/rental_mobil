<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_rental_mobil';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result1 = $conn->query("DESCRIBE users");
echo "USERS TABLE SCHEMA:\n";
while ($row = $result1->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

$result2 = $conn->query("DESCRIBE penyewaan");
echo "\nPENYEWAAN TABLE SCHEMA:\n";
while ($row = $result2->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
$conn->close();
