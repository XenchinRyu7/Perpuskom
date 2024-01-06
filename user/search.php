<?php
session_start();
require_once '../model/db_connect.php';

$query = $_GET['query'];

$query = "SELECT * FROM buku WHERE Judul LIKE '%$query%'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<div class="col">';
    echo '<div class="card" style="height: 300px">';
    echo '<div class="card-body" style="padding: 10px">';
    echo '<img src="../assets/images/' . basename($row['gambar']) . '" alt="Buku Thumbnail" style="width: 200px; height: 200px;">';
    echo '<h5 class="card-title">';
    echo $row['Judul'];
    echo '</h5>';
    echo '<div class="d-flex justify-content-between align-items-center">';
    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_' . $row['ID_Buku'] . '">';
    echo 'Cek Info';
    echo '</button>';
    echo '<div class="favorite-icon" data-bookid="' . $row['ID_Buku'] . '" data-isfavorite="' . $row['is_favorite'] . '" data-userid="' . $_SESSION['mahasiswa_id'] . '" onclick="toggleFavorite(this)">';
    echo '<i class="fa ' . (($row['is_favorite'] == 'ya') ? 'fa-heart text-danger' : 'fa-regular fa-heart') . '"></i>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>