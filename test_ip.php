

<?php
// Kredensial database
$servername = "151.106.119.252";
$username = "cbnb9676_cbnbandung_user";
$password = "Arkan@199003";
$dbname = "cbnb9676_test_ip";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan alamat IP pengunjung
$ip_address = $_SERVER['REMOTE_ADDR'];

// Persiapan statement untuk memasukkan data
$stmt = $conn->prepare("INSERT INTO ip_log (ip_address) VALUES (?)");
$stmt->bind_param("s", $ip_address);

// Menjalankan statement
if ($stmt->execute()) {
    echo "IP address logged successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>

