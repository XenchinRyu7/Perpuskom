<?php
session_start();
require_once '../model/db_connect.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$query_count_notifications = "SELECT COUNT(*) AS total FROM notifikasi WHERE StatusNotifikasi = 'Belum Dilihat'";
$result_count_notifications = $conn->query($query_count_notifications);
$row_count_notifications = $result_count_notifications->fetch_assoc();
$total_notifications_nosee = $row_count_notifications['total'];

$query_count_all_peminjaman = "SELECT COUNT(*) AS totalPeminjaman FROM peminjaman";
$result_count_all_peminjaman = $conn->query($query_count_all_peminjaman);
$row_count_all_peminjaman = $result_count_all_peminjaman->fetch_assoc();
$total_peminjaman = $row_count_all_peminjaman["totalPeminjaman"];

$query_count_all_mahasiswa = "SELECT COUNT(*) AS totalMahasiswa FROM mahasiswa";
$result_count_all_mahasiswa = $conn->query($query_count_all_mahasiswa);
$row_count_all_mahasiswa = $result_count_all_mahasiswa->fetch_assoc();
$total_mahasiswa = $row_count_all_mahasiswa["totalMahasiswa"];

$query_count_all_buku = "SELECT COUNT(*) AS totalBuku FROM buku";
$result_count_all_buku = $conn->query($query_count_all_buku);
$row_count_all_buku = $result_count_all_buku->fetch_assoc();
$total_buku = $row_count_all_buku["totalBuku"];

$query_notifications = "SELECT * FROM notifikasi WHERE StatusNotifikasi = 'Belum Dilihat'";
$result_notifications = $conn->query($query_notifications);

$id_admin = $_SESSION['admin_id'];
$queryAdmin = "SELECT * FROM admin WHERE ID_Admin = $id_admin";
$resultAdmin = $conn->query($queryAdmin);

$rowAdmin = $resultAdmin->fetch_assoc();
$adminId = $rowAdmin['ID_Admin'];

include('editAdminModal.php');
include('logoutModal.php');
include('notifModal.php');
include('../assets/view/resources_admin.php');
include('toast.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-brands fa-battle-net"></i>
                </div>
                <div class="sidebar-brand-text mx-3">FKOM<sup>Libz</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Database
            </div>

            <li class="nav-item">
                <a class="nav-link" href="table_mahasiswa.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table Mahasiswa</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="table_buku.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table Buku</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="table_peminjaman.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table Peminjaman</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-bs-toggle="modal" data-bs-target="#notifModal">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">
                                    <?php echo $total_notifications_nosee; ?>
                                </span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['admin_username']; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../assets/images/account.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModalAdmin<?php echo $adminId ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Mahasiswa</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_mahasiswa ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Peminjaman</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_peminjaman ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-bookmark"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Buku
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php echo $total_buku ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Saeful Rohman Project</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
        $(document).ready(function () {
            $('#tablenotif').DataTable();
        });

        function showToast(message, isError = true) {
            var toastEl = document.getElementById('liveToast');
            var toastInstance = new bootstrap.Toast(toastEl);

            if (isError) {
                toastEl.classList.add('bg-danger', 'text-light');
                toastEl.classList.remove('bg-success', 'text-dark');
            } else {
                toastEl.classList.add('bg-success', 'text-light');
                toastEl.classList.remove('bg-danger', 'text-dark');
            }

            document.querySelector('.toast-body').innerHTML = message;
            toastInstance.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "showToast('{$_SESSION['error_message']}', true);";
                unset($_SESSION['error_message']);
            }

            if (isset($_SESSION['success_message'])) {
                echo "showToast('{$_SESSION['success_message']}', false);";
                unset($_SESSION['success_message']);
            }
            ?>
        });
    </script>
</body>

</html>