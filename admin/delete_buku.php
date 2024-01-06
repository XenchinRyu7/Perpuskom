<?php
session_start();
require_once '../model/db_connect.php';

function redirectToTableWithMessage($message) {
    $_SESSION['error_message'] = $message;
    header("Location: table_buku.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku_hapus = $_POST['id_buku_hapus'];

    $cekNotifikasiQuery = "SELECT COUNT(*) as notif_count FROM notifikasi WHERE ID_Buku = '$id_buku_hapus'";
    $resultNotifikasi = $conn->query($cekNotifikasiQuery);

    if ($resultNotifikasi === FALSE) {
        redirectToTableWithMessage('Gagal memeriksa notifikasi.');
    }

    $rowNotifikasi = $resultNotifikasi->fetch_assoc();
    $notifCount = $rowNotifikasi['notif_count'];

    if ($notifCount > 0) {
        redirectToTableWithMessage('Buku memiliki notifikasi terkait dan tidak dapat dihapus.');
    }

    $ketersediaanQuery = "SELECT Ketersediaan, gambar FROM buku WHERE ID_Buku = '$id_buku_hapus'";
    $result = $conn->query($ketersediaanQuery);

    if ($result === FALSE) {
        redirectToTableWithMessage('Gagal mengambil informasi buku.');
    }

    $row = $result->fetch_assoc();
    $ketersediaan = $row['Ketersediaan'];

    $gambarPath = $row['gambar'];

    if (file_exists($gambarPath)) {
        unlink($gambarPath);
    }

    if ($ketersediaan == 'Dipinjam') {
        redirectToTableWithMessage('Buku sedang dipinjam dan tidak dapat dihapus.');
    }

    $deleteQuery = "DELETE FROM buku WHERE ID_Buku = '$id_buku_hapus'";
    if ($conn->query($deleteQuery) === TRUE) {
        $_SESSION['success_message'] = 'Berhasil Menghapus Buku.';
    } else {
        redirectToTableWithMessage('Gagal Menghapus Buku.');
    }

    header("Location: table_buku.php");
    exit();
}

$conn->close();
?>
