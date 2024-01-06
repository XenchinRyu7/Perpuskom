<?php
session_start();
require_once '../model/db_connect.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM buku";
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

    <title>Admin - Table Buku</title>
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

            <li class="nav-item">
                <a class="nav-link" href="table_mahasiswa.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Table Mahasiswa</span></a>
            </li>

            <li class="nav-item active">
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Buku</h6>
                            <button type="button" class="btn btn-success float-right" data-bs-toggle="modal"
                                data-bs-target="#tambahDataModal">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Tambah Data</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablebuku" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Penulis</th>
                                            <th>Genre</th>
                                            <th>Tahun Terbit</th>
                                            <th>Ketersediaan</th>
                                            <th>Jumlah Buku</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo ($row['Judul']); ?>
                                                </td>
                                                <td>
                                                    <?php echo ($row['Penulis']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['genre']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['TahunTerbit']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Ketersediaan']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['JumlahBuku']; ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal_<?php echo $row['ID_Buku']; ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i> Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal_<?php echo $row['ID_Buku']; ?>"><i
                                                            class="fa-solid fa-trash"></i> Hapus</button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editModal_<?php echo $row['ID_Buku']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form method="POST" action="proses_edit_buku.php"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="modalLabel_<?php echo $row['ID_Buku']; ?>">Edit Buku
                                                                </h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="ID_Buku" id="id_Buku"
                                                                    value="<?php echo $row['ID_Buku']; ?>">

                                                                <div class="form-group">
                                                                    <label for="judul">Judul:</label>
                                                                    <input type="text" class="form-control" id="judul"
                                                                        value="<?php echo ($row['Judul']); ?>" name="judul"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="penulis">Penulis:</label>
                                                                    <input type="text" class="form-control" id="penulis"
                                                                        value="<?php echo ($row['Penulis']); ?>"
                                                                        name="penulis" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="genre">Genre:</label>
                                                                    <select class="form-control" id="genre" name="genre"
                                                                        required>
                                                                        <option value="Romansa" <?php echo ($row['genre'] == 'Romansa') ? 'selected' : ''; ?>>Romansa</option>
                                                                        <option value="Misteri" <?php echo ($row['genre'] == 'Misteri') ? 'selected' : ''; ?>>Misteri</option>
                                                                        <option value="Sains Fiksi" <?php echo ($row['genre'] == 'Sains Fiksi') ? 'selected' : ''; ?>>Sains Fiksi</option>
                                                                        <option value="Sejarah" <?php echo ($row['genre'] == 'Sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                                                                        <option value="Biografi" <?php echo ($row['genre'] == 'Biografi') ? 'selected' : ''; ?>>Biografi</option>
                                                                        <option value="Puisi" <?php echo ($row['genre'] == 'Puisi') ? 'selected' : ''; ?>>
                                                                            Pusi</option>
                                                                        <option value="Drama" <?php echo ($row['genre'] == 'Drama') ? 'selected' : ''; ?>>
                                                                            Drama</option>
                                                                        <option value="Horor" <?php echo ($row['genre'] == 'Horor') ? 'selected' : ''; ?>>
                                                                            Horor</option>
                                                                        <option value="Anak-anak" <?php echo ($row['genre'] == 'Anak-anak') ? 'selected' : ''; ?>>Anak-anak</option>
                                                                        <option value="Remaja" <?php echo ($row['genre'] == 'Remaja') ? 'selected' : ''; ?>>
                                                                            Remaja</option>
                                                                        <option value="Fiksi Sejarah" <?php echo ($row['genre'] == 'Fiksi Sejarah') ? 'selected' : ''; ?>>Fiksi Sejarah</option>
                                                                        <option value="Fiksi Ilmiah" <?php echo ($row['genre'] == 'Fiksi Ilmiah') ? 'selected' : ''; ?>>Fiksi Ilmiah</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tahunTerbit">Tahun Terbit:</label>
                                                                    <input type="text" class="form-control" id="tahunTerbit"
                                                                        value="<?php echo $row['TahunTerbit']; ?>"
                                                                        name="tahunTerbit" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ketersediaan">Ketersediaan:</label>
                                                                    <select class="form-control" id="ketersediaan"
                                                                        name="ketersediaan" required>
                                                                        <option value="Tersedia" <?php echo ($row['Ketersediaan'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                                                        <option value="Dipinjam" <?php echo ($row['Ketersediaan'] == 'Dipinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="gambar">Gambar:</label>
                                                                    <input type="file" class="form-control" id="gambar"
                                                                        name="gambar" accept="image/*">
                                                                    <?php if (!empty($row['gambar'])): ?>
                                                                        <img src="<?php echo $row['gambar']; ?>"
                                                                            alt="Gambar saat ini"
                                                                            style="max-width: 100%; max-height: 250px; margin-top: 10px;">
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Jumlah Buku:</label>
                                                                    <input type="text" class="form-control" id="jumlahbuku"
                                                                        value="<?php echo $row['JumlahBuku']; ?>"
                                                                        name="jumlahbuku" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="hapusModal_<?php echo $row['ID_Buku']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="modalLabel_<?php echo $row['ID_Buku']; ?>">Hapus
                                                                Data
                                                                Buku</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php if ($row['Ketersediaan'] == 'Tersedia'): ?>
                                                                <p>Anda yakin ingin menghapus buku dengan judul "
                                                                    <?php echo $row['Judul']; ?>"?
                                                                </p>
                                                                <form method="post" action="delete_buku.php">
                                                                    <input type="hidden" name="id_buku_hapus"
                                                                        value="<?php echo $row['ID_Buku']; ?>">
                                                                    <button type="submit" class="btn btn-danger">Ya,
                                                                        Hapus</button>
                                                                </form>
                                                            <?php else: ?>
                                                                <p>Buku dengan judul "
                                                                    <?php echo $row['Judul']; ?>" sedang dipinjam dan tidak
                                                                    dapat dihapus.
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Tambah Data -->
                                            <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="modalLabel_tambahData">
                                                                Tambah
                                                                Data Buku</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="add_buku.php"
                                                                enctype="multipart/form-data" id="formTambahData">
                                                                <div class="form-group">
                                                                    <label for="judul">Judul:</label>
                                                                    <input type="text" class="form-control" id="judul"
                                                                        name="judul" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="penulis">Penulis:</label>
                                                                    <input type="text" class="form-control" id="penulis"
                                                                        name="penulis" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="genre">Genre:</label>
                                                                    <select class="form-control" id="genre" name="genre"
                                                                        required>
                                                                        <option value="Romansa">Romansa</option>
                                                                        <option value="Misteri">Misteri</option>
                                                                        <option value="Misteri">Sains Fiksi</option>
                                                                        <option value="Misteri">Sejarah</option>
                                                                        <option value="Misteri">Biografi</option>
                                                                        <option value="Misteri">Pusi</option>
                                                                        <option value="Misteri">Drama</option>
                                                                        <option value="Misteri">Horor</option>
                                                                        <option value="Misteri">Anak-anak</option>
                                                                        <option value="Misteri">Remaja</option>
                                                                        <option value="Misteri">Fiksi Sejarah</option>
                                                                        <option value="Misteri">Fiksi Ilmiah</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tahunTerbit">Tahun Terbit:</label>
                                                                    <input type="text" class="form-control" id="tahunTerbit"
                                                                        name="tahunTerbit">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ketersediaan">Ketersediaan:</label>
                                                                    <select class="form-control" id="ketersediaan"
                                                                        name="ketersediaan" required>
                                                                        <option value="Tersedia">Tersedia</option>
                                                                        <option value="Dipinjam">Dipinjam</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="gambar">Gambar:</label>
                                                                    <input type="file" class="form-control" id="gambar"
                                                                        name="gambar" accept="image/*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Jumlah Buku:</label>
                                                                    <input type="text" class="form-control" id="jumlahbuku"
                                                                        name="jumlahbuku" required>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">Tambah
                                                                    Data
                                                                    Buku</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
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
            $('#tablebuku').DataTable();
            $('#tablenotif').DataTable();
        });

        document.getElementById('formTambahData').addEventListener('submit', function (e) {
            var fileInput = document.getElementById('gambar');
            var fileName = fileInput.value.trim();

            if (fileName !== '') {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

                if (!allowedExtensions.test(fileName)) {
                    alert('File yang diunggah harus berupa gambar dengan ekstensi: .jpg, .jpeg, .png, atau .gif');
                    e.preventDefault();
                }
            }
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