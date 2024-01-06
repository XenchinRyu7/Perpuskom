<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once '../model/db_connect.php';

    $bookId = $_POST['book_id'];
    $isFavorite = ($_POST['is_favorite'] == 'ya') ? 'tidak' : 'ya';
    $userId = $_POST['user_id'];

    $updateQuery = "INSERT INTO favorite_books (ID_Buku, ID_Mahasiswa, isfavorite) 
                    VALUES ($bookId, $userId, '$isFavorite')
                    ON DUPLICATE KEY UPDATE isfavorite = VALUES(isfavorite)";
    $conn->query($updateQuery);

    $updateBukuQuery = "UPDATE buku SET is_favorite = '$isFavorite' WHERE ID_Buku = $bookId";
    $conn->query($updateBukuQuery);

    if ($isFavorite == 'ya') {
      $_SESSION['success_message'] = 'Menambahkan ke favorite.';
    } else {
      $_SESSION['error_message'] = 'Menghapus favorite';
    }

}
?>
