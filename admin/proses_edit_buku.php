<?php
session_start();

function redirectToTableWithMessage($message)
{
    $_SESSION['error_message'] = $message;
    header("Location: table_buku.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../model/db_connect.php';

    $id_buku = $_POST["ID_Buku"];
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $genre = $_POST["genre"];
    $tahunTerbit = $_POST["tahunTerbit"];
    $ketersediaan = $_POST["ketersediaan"];
    $jumlahbuku = $_POST["jumlahbuku"];

    $gambar = null;

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "../images/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $fileName;

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            redirectToTableWithMessage('Maaf, Hanya gambar yang diperbolehkan');
        } elseif (file_exists($targetFile)) {
            redirectToTableWithMessage('Maaf, file gambar sudah ada, mohon ganti kembali nama filenya!');
        } elseif ($_FILES["gambar"]["size"] > 500000) {
            redirectToTableWithMessage('Maaf, gambarnya terlalu besar');
        } elseif (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            redirectToTableWithMessage('Maaf, ada kesalahan dalam mengunggah file!');
        } else {
            $gambar = $targetFile;
        }
    }

    $update_query = $conn->prepare("UPDATE buku SET Judul=?, Penulis=?, genre=?, TahunTerbit=?, Ketersediaan=?, gambar=?, JumlahBuku=? WHERE ID_Buku=?");
    $update_query->bind_param("ssssssii", $judul, $penulis, $genre, $tahunTerbit, $ketersediaan, $gambar, $jumlahbuku, $id_buku);

    if ($update_query->execute()) {
        $_SESSION['success_message'] = 'Berhasil Mengubah Data Buku';
    } else {
        $_SESSION['error_message'] = 'Gagal mengubah Data Buku';
    }

    $update_query->close();
    $conn->close();

    header("Location: table_buku.php");
    exit();
}
?>