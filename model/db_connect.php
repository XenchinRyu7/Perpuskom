<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_perpuskom";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    echo "<script>alert('Isi username dan password. Silakan coba lagi.');</script>";
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>