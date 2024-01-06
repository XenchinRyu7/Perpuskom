<?php
session_start();
require_once '../model/db_connect.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM peminjaman";
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

    <title>Admin - Table Peminjaman</title>

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
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

            <li class="nav-item active">
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
                        <form method="post">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman</h6>
                                <button type="button" class="btn btn-primary" onclick="exportToPDF()">Cetak Laporan PDF
                                    <i class="fas fa-file-pdf fa-sm text-white-50"></i></button>
                                <button type="button" class="btn btn-success" onclick="exportToExcel()">Cetak Laporan
                                    Excel <i class="fas fa-file-excel fa-sm text-white-50"></i></button>
                            </div>
                        </form>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablepeminjaman" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Mahasiswa Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status Peminjaman</th>
                                            <th>Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo ($row['Nama_mhs']); ?>
                                                </td>
                                                <td>
                                                    <?php echo ($row['Judul_buku']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['TanggalPinjam']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['TanggalKembali']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['StatusPeminjaman']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['StatusPeminjaman'] == 'Dipinjam') {
                                                        ?>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editModal_<?php echo $row['ID_Peminjaman']; ?>">Selesaikan
                                                            Peminjaman <i class="fa-solid fa-hourglass-end"></i></button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p>Selesai</p>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editModal_<?php echo $row['ID_Peminjaman']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="modalLabel_<?php echo $row['ID_Peminjaman']; ?>">
                                                                Data Peminjaman</h1>
                                                        </div>
                                                        <form action="updateDataPeminjaman.php" method="post">
                                                            <div class="modal-body">

                                                                <h5 class="card-title">Nama Mahasiswa Peminjam:
                                                                    <?php echo $row['Nama_mhs']; ?>
                                                                </h5>
                                                                <p class="card-text">Judul Buku:
                                                                    <?php echo $row['Judul_buku']; ?>
                                                                </p>
                                                                <p class="card-text">Tanggal Peminjaman:
                                                                    <?php echo $row['TanggalPinjam']; ?>
                                                                </p>
                                                                <p class="card-text">Tanggal Kembali: <span>
                                                                        <?php echo $row['TanggalKembali']; ?>
                                                                    </span></p>
                                                                <p class="card-text">Status Peminjaman: <span>
                                                                        <?php echo $row['StatusPeminjaman']; ?>
                                                                    </span></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id_peminjaman"
                                                                    value="<?php echo $row['ID_Peminjaman']; ?>">
                                                                <input type="hidden" name="judulbuku"
                                                                    value="<?php echo $row['Judul_buku']; ?>">
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="selesaikan_peminjaman">Selesaikan
                                                                    Peminjaman</button>
                                                            </div>
                                                        </form>
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
        function exportToPDF() {
            var doc = new jsPDF({ putOnlyUsedFonts: true, orientation: "landscape" });
            var data = [];
            var headers = [];

            // Ambil header tabel
            $("#dataTable th").each(function () {
                headers.push($(this).text());
            });

            // Ambil data tabel
            $("#dataTable tbody tr").each(function () {
                var row = [];
                $(this).find("td").each(function () {
                    row.push($(this).text());
                });
                data.push(row);
            });

            doc.autoTable({
                head: [headers],
                body: data,
            });

            doc.save('laporan_peminjaman.pdf');
        }

        function exportToExcel() {
            var table = document.getElementById('dataTable');
            var data = [];
            for (var i = 1; i < table.rows.length; i++) {
                var row = [];
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    row.push(table.rows[i].cells[j].innerText);
                }
                data.push(row);
            }

            var ws = XLSX.utils.aoa_to_sheet([['Nama Mahasiswa Peminjam', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status Peminjaman']].concat(data));
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Data Peminjaman');
            XLSX.writeFile(wb, 'laporan_peminjaman.xlsx');
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#tablepeminjaman').DataTable();
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