<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../model/db_connect.php';

    $id_mahasiswa = $_POST["id_mahasiswa"];
    $nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $kelas = $_POST["kelas"];
    $jurusan = $_POST["jurusan"];
    $angkatan = $_POST["angkatan"];
    $no_telp = $_POST["no_telp"];
    $email = $_POST["email"];
    $alamat = $_POST["alamat"];

    $update_query = "UPDATE mahasiswa SET Nama='$nama', NIM='$nim', Kelas='$kelas', Jurusan='$jurusan', TahunAngkatan='$angkatan', NoTelp='$no_telp', email='$email', Alamat='$alamat' WHERE ID_Mahasiswa=$id_mahasiswa";
    
    if ($conn->query($update_query) === TRUE) {
        $_SESSION['success_message'] = 'Berhasil Mengubah Data Mahasiswa.';
        header("Location: table_mahasiswa.php");
    } else {
        $_SESSION['error_message'] = 'Gagal Mengubah Data Mahasiswa';
        header("Location: table_mahasiswa.php");
    }
    
    $conn->close();
}
?>
