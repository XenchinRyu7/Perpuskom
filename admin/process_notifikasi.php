<?php
session_start();
require_once '../model/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_notifikasi = $_POST['id_notifikasi'];
    $action = $_POST['action'];

    if ($action == 'terima') {
        $update_query = "UPDATE notifikasi SET StatusNotifikasi = 'Diterima' WHERE ID_Notifikasi = $id_notifikasi";
        $conn->query($update_query);

        $insert_query = "INSERT INTO peminjaman (ID_Mahasiswa, Nama_mhs, ID_Buku, Judul_buku, TanggalPinjam, StatusPeminjaman)
                        SELECT n.ID_Mahasiswa, m.Nama, n.ID_Buku, b.Judul, NOW(), 'Dipinjam'
                        FROM notifikasi n
                        JOIN mahasiswa m ON n.ID_Mahasiswa = m.ID_Mahasiswa
                        JOIN buku b ON n.ID_Buku = b.ID_Buku
                        WHERE n.ID_Notifikasi = $id_notifikasi";

        $conn->query($insert_query);
        $_SESSION['success_message'] = 'Peminjaman di Terima.';
    } elseif ($action == 'tolak') {
        $rejected_info_query = "SELECT n.ID_Mahasiswa, n.ID_Buku, b.Judul
                                FROM notifikasi n
                                JOIN buku b ON n.ID_Buku = b.ID_Buku
                                WHERE n.ID_Notifikasi = $id_notifikasi";
        $rejected_info_result = $conn->query($rejected_info_query);
        $rejected_info = $rejected_info_result->fetch_assoc();

        $update_query = "UPDATE notifikasi SET StatusNotifikasi = 'Ditolak' WHERE ID_Notifikasi = $id_notifikasi";
        $conn->query($update_query);

        $return_books_query = "UPDATE buku SET JumlahBuku = JumlahBuku + 1 WHERE ID_Buku = {$rejected_info['ID_Buku']}";
        $conn->query($return_books_query);
        $_SESSION['error_message'] = 'Peminjaman di Tolak.';
    }

    $conn->close();
    header("Location: table_peminjaman.php");
}
?>