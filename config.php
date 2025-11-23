<?php
// config.php - koneksi database (XAMPP default user=root tanpa password)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "xor_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
