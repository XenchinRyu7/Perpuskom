<?php
session_start();
require_once '../model/db_connect.php';

function redirectToTableWithMessage($message, $location = "table_buku.php") {
    $_SESSION['error_message'] = $message;
    header("Location: $location");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $genre = $_POST['genre'];
    $tahunTerbit = isset($_POST['tahunTerbit']) ? $_POST['tahunTerbit'] : NULL;
    $ketersediaan = $_POST['ketersediaan'];
    $jumlahbuku = $_POST['jumlahbuku'];

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "../assets/images/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $fileName;

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false || file_exists($targetFile) || $_FILES["gambar"]["size"] > 500000 || !move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            redirectToTableWithMessage('Error uploading image file or image file already exists.');
        }

        $gambarPath = $targetFile;
    } else {
        $gambarPath = NULL;
    }

    if (empty($tahunTerbit)) {
        $tahunTerbit = NULL;
    }

    $sql = "INSERT INTO buku (judul, penulis, genre, tahunTerbit, ketersediaan, gambar, JumlahBuku) VALUES ('$judul', '$penulis', '$genre', '$tahunTerbit', '$ketersediaan', '$gambarPath', '$jumlahbuku')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = 'Berhasil Menambahkan Buku';
        header('Location: table_buku.php');
    } else {
        redirectToTableWithMessage('Gagal Menambahkan Buku');
    }
}

$conn->close();
?>