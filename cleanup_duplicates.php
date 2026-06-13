<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_rental_mobil';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== Membersihkan Duplikat Email ===" . PHP_EOL;

// Cari email yang duplikat
$result = $conn->query('SELECT email, COUNT(*) as count FROM users GROUP BY email HAVING count > 1');
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Duplikat ditemukan: " . $row['email'] . " (" . $row['count'] . " kali)" . PHP_EOL;

        // Ambil semua user dengan email duplikat
        $emails = $conn->query("SELECT id_user, email FROM users WHERE email = '" . $conn->real_escape_string($row['email']) . "' ORDER BY created_at ASC");
        $users = [];
        while ($user = $emails->fetch_assoc()) {
            $users[] = $user;
        }

        // Hapus yang lebih tua, pertahankan yang terbaru
        for ($i = 0; $i < count($users) - 1; $i++) {
            echo "  - Menghapus ID: " . $users[$i]['id_user'] . PHP_EOL;
            $conn->query("DELETE FROM users WHERE id_user = '" . $conn->real_escape_string($users[$i]['id_user']) . "'");
        }
        echo "  - Mempertahankan ID: " . $users[count($users) - 1]['id_user'] . PHP_EOL;
    }
} else {
    echo "Tidak ada duplikat email ditemukan." . PHP_EOL;
}

echo PHP_EOL . "=== Data User Setelah Pembersihan ===" . PHP_EOL;
$result = $conn->query('SELECT id_user, email FROM users ORDER BY email');
while ($row = $result->fetch_assoc()) {
    echo 'ID: ' . $row['id_user'] . ', Email: ' . $row['email'] . PHP_EOL;
}

$conn->close();
