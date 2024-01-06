<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../model/db_connect.php';

    $id = $_POST["id_admin"];
    $nama = $_POST["nama"];
    $username = $_POST["username"];

    $update_query = "UPDATE admin SET Nama='$nama', username='$username' WHERE ID_Admin = $id";

    if ($conn->query($update_query) === TRUE) {
        $_SESSION['success_message'] = 'Berhasil Mengubah Profile.';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Gagal Mengubah Profile.';
        header("Location: admin_dashboard.php");
    }

    $conn->close();
}
?>