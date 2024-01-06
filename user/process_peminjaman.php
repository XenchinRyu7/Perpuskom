<?php
session_start();
require_once '../model/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_buku = $_POST['id_buku'];
    $id_mahasiswa = $_POST['id_mahasiswa'];

    try {
        $conn->begin_transaction();

        $query_check_availability = "SELECT JumlahBuku FROM buku WHERE ID_Buku = $id_buku FOR UPDATE";
        $result_check_availability = $conn->query($query_check_availability);

        if ($result_check_availability->num_rows > 0) {
            $row_availability = $result_check_availability->fetch_assoc();
            if ($row_availability['JumlahBuku'] > 0) {
                $query_update_buku = "UPDATE buku SET JumlahBuku = JumlahBuku - 1 WHERE ID_Buku = $id_buku";
                $conn->query($query_update_buku);

                $query_insert_notification = "INSERT INTO notifikasi (ID_Buku, ID_Mahasiswa, StatusNotifikasi) VALUES ($id_buku, '$id_mahasiswa', 'Belum Dilihat')";
                $conn->query($query_insert_notification);

                $conn->commit();
                $_SESSION['success_message'] = 'Berhasil Mengajukan Peminjaman.';
                header("Location: mhs_dashboard.php");
                exit();
            }
        }

        if (!$result_check_availability) {
            var_dump($conn->error);
        }

        $conn->rollback();

        header("Location: mhs_dashboard.php");
        $_SESSION['error_message'] = 'Maaf, Buku Tidak Tersedia.';
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: mhs_dashboard.php");
        $_SESSION['error_message'] = 'Maaf, Terjadi Kesalahan.';
        exit();
    }
}
?>