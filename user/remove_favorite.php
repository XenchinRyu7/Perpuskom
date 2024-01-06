<?php
session_start();
require_once '../model/db_connect.php';

if (!isset($_SESSION['mahasiswa_username'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['book_id'];

    $mahasiswaId = $_SESSION['mahasiswa_id'];

    $queryRemoveFavorite = "DELETE FROM favorite_books WHERE ID_Mahasiswa = $mahasiswaId AND ID_Buku = $bookId";
    $resultRemoveFavorite = $conn->query($queryRemoveFavorite);
    
    if ($resultRemoveFavorite) {
        $_SESSION['error_message'] = 'Menghapus favorite';
        header("Location: mhs_dashboard.php");
    } else {
      header("Location: mhs_dashboard.php");
    }
}
?>
