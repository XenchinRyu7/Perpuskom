<?php
session_start();

session_unset();

session_destroy();

if (isset($_COOKIE['remember_me_admin'])) {
    setcookie('remember_me_admin', '', time() - 3600, '/');
}

if (isset($_COOKIE['remember_me_mahasiswa'])) {
    setcookie('remember_me_mahasiswa', '', time() - 3600, '/');
}

header("Location: index.php");
?>
