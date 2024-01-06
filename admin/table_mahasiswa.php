<?php
session_start();
require_once '../model/db_connect.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM mahasiswa";
$result = $conn->query($query);

$query_count_notifications = "SELECT COUNT(*) AS total FROM notifikasi WHERE StatusNotifikasi = 'Belum Dilihat'";
$result_count_notifications = $conn->query($query_count_notifications);
$row_count_notifications = $result_count_notifications->fetch_assoc();
$total_notifications = $row_count_notifications['total'];


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

    <title>Admin - Table Mahasiswa</title>

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

            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Database
            </div>

            <li class="nav-item active">
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

            <!-- Main Content -->
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
                                    <?php echo $total_notifications; ?>
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

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablemhs" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Angkatan</th>
                                            <th>No Telp</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo ($row['Nama']); ?>
                                                </td>
                                                <td>
                                                    <?php echo ($row['NIM']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Kelas']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Jurusan']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['TahunAngkatan']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['NoTelp']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['email']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Alamat']; ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal_<?php echo $row['ID_Mahasiswa']; ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i> Edit</button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editModal_<?php echo $row['ID_Mahasiswa']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="modalLabel_<?php echo $row['ID_Mahasiswa']; ?>">Ubah
                                                                Data</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="edit_mhs.php">
                                                                <input type="hidden" name="id_mahasiswa"
                                                                    value="<?php echo $row['ID_Mahasiswa']; ?>">

                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label">Nama:</label>
                                                                    <input type="text" class="form-control" id="nama"
                                                                        name="nama" value="<?php echo $row['Nama']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nim" class="form-label">NIM:</label>
                                                                    <input type="text" class="form-control" id="nim"
                                                                        name="nim" value="<?php echo $row['NIM']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="kelas" class="form-label">Kelas:</label>
                                                                    <select class="form-select" id="kelas" name="kelas">
                                                                        <option value="01" <?php echo ($row['Kelas'] == '01') ? 'selected' : ''; ?>>01</option>
                                                                        <option value="02" <?php echo ($row['Kelas'] == '02') ? 'selected' : ''; ?>>02</option>
                                                                        <option value="03" <?php echo ($row['Kelas'] == '03') ? 'selected' : ''; ?>>03</option>
                                                                        <option value="04" <?php echo ($row['Kelas'] == '04') ? 'selected' : ''; ?>>04</option>
                                                                        <option value="05" <?php echo ($row['Kelas'] == '05') ? 'selected' : ''; ?>>05</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="jurusan" class="form-label">Jurusan:</label>
                                                                    <select class="form-select" id="jurusan" name="jurusan">
                                                                        <option value="SI" <?php echo ($row['Jurusan'] == 'SI') ? 'selected' : ''; ?>>SI
                                                                        </option>
                                                                        <option value="TI" <?php echo ($row['Jurusan'] == 'TI') ? 'selected' : ''; ?>>TI
                                                                        </option>
                                                                        <option value="MI" <?php echo ($row['Jurusan'] == 'MI') ? 'selected' : ''; ?>>MI
                                                                        </option>
                                                                        <option value="DKV" <?php echo ($row['Jurusan'] == 'DKV') ? 'selected' : ''; ?>>
                                                                            DKV</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="angkatan"
                                                                        class="form-label">Angkatan:</label>
                                                                    <input type="text" class="form-control" id="angkatan"
                                                                        name="angkatan"
                                                                        value="<?php echo $row['TahunAngkatan']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="no_telp" class="form-label">No Telp:</label>
                                                                    <input type="text" class="form-control" id="no_telp"
                                                                        name="no_telp"
                                                                        value="<?php echo $row['NoTelp']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Email:</label>
                                                                    <input type="email" class="form-control" id="email"
                                                                        name="email" value="<?php echo $row['email']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="alamat" class="form-label">Alamat:</label>
                                                                    <textarea class="form-control" id="alamat"
                                                                        name="alamat"><?php echo $row['Alamat']; ?></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Ubah
                                                                        Data</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
            $('#tablemhs').DataTable();
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