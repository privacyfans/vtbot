<?php
// Mendefinisikan parameter koneksi ke database
$servername = "151.106.119.252"; // Host server, biasanya localhost
$username = "cbnb9676_cbnbandung_user"; // Username untuk akses database
$password = "Arkan@199003"; // Password untuk akses database
$dbname = "cbnb9676_cbnbandung"; // Nama database yang akan digunakan

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
