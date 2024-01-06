<?php
session_start();
require_once '../model/db_connect.php';

if (isset($_POST['selesaikan_peminjaman'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $judulBuku = $_POST['judulbuku'];
    
    $updateQuery = "UPDATE peminjaman SET TanggalKembali=CURRENT_TIMESTAMP, StatusPeminjaman='Dikembalikan' WHERE ID_Peminjaman=$id_peminjaman";
    $result = $conn->query($updateQuery);

    $selectQuery = "SELECT ID_Buku FROM buku WHERE Judul='" . $judulBuku . "'";
    $selectResult = $conn->query($selectQuery);
    $buku = $selectResult->fetch_assoc();

    $updateBukuQuery = "UPDATE buku SET JumlahBuku = JumlahBuku + 1 WHERE ID_Buku=" . $buku['ID_Buku'];
    $resultBuku = $conn->query($updateBukuQuery);
    
    $conn->close();
    $_SESSION['success_message'] = 'Buku di kembalikan.';
    header('Location: table_peminjaman.php');
}

?>