<?php
session_start();

if (!isset($_SESSION['mahasiswa_username'])) {
  header("Location: ../index.php");
  exit();
}

require_once '../model/db_connect.php';

function limitText($text, $maxLength = 20)
{
  if (strlen($text) > $maxLength) {
    $text = substr($text, 0, $maxLength) . '...';
  }
  return $text;
}

$id_mahasiswa = $_SESSION['mahasiswa_id'];

$query_count_notifications = "SELECT COUNT(*) AS total FROM notifikasi WHERE ID_Mahasiswa = $id_mahasiswa";
$result_count_notifications = $conn->query($query_count_notifications);
$row_count_notifications = $result_count_notifications->fetch_assoc();
$total_notifications = $row_count_notifications['total'];

$query_notifications = "SELECT * FROM notifikasi WHERE ID_Mahasiswa = $id_mahasiswa";
$result_notifications = $conn->query($query_notifications);

$queryMahasiswa = "SELECT * FROM mahasiswa WHERE ID_Mahasiswa = $id_mahasiswa";
$resultMahasiswa = $conn->query($queryMahasiswa);

$rowMahasiswa = $resultMahasiswa->fetch_assoc();
$mahasiswaId = $rowMahasiswa['ID_Mahasiswa'];

$queryHistoryBook = "SELECT * FROM peminjaman WHERE ID_Mahasiswa = $id_mahasiswa";
$resultHistoryBook = $conn->query($queryHistoryBook);

$query = "SELECT buku.*, IFNULL(favorite_books.isfavorite, 'tidak') AS is_favorite
          FROM buku
          LEFT JOIN favorite_books ON buku.ID_Buku = favorite_books.ID_Buku AND favorite_books.ID_Mahasiswa = $id_mahasiswa";
$result = $conn->query($query);

include("../assets/view/resources_user.php");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Mahasiswa</title>
</head>

<body>
  <div class="header">
    <nav class="navbar navbar-expand-lg bg-white shadow fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">PerpusKom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <form class="d-flex m-3 m-md-0" role="search" id="searchForm">
              <input class="form-control me-3" type="search" placeholder="Cari" aria-label="Cari" name="query"
                id="searchQuery">
              <button class="btn btn-outline-success" type="button" onclick="performSearch()">Cari</button>
            </form>
          </ul>
          <ul class="d-flex justify-content-end align-items-center mb-2 mb-lg-0">
            <li class="nav-item dropdown me-3" style="list-style: none;">
              <a class="nav-link" href="#" id="favoriteDropdown" role="button" data-bs-toggle="modal"
                data-bs-target="#favoriteModal">
                <i class="fas fa-heart"></i>
              </a>
            </li>

            <li class="nav-item dropdown me-3" style="list-style: none;">
              <a class="nav-link" href="#" id="alertsDropdown" role="button" data-bs-toggle="modal"
                data-bs-target="#notifModal">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge text-bg-info badge-counter position-absolute top-0 start-100 translate-middle"
                  style="width: 20px; height: 20px;">
                  <?php echo $total_notifications; ?>
                </span>
              </a>
            </li>


            <li class="nav-item dropdown me-3" style="list-style: none;">
              <a class="nav-link" href="#" id="historyDropdown" role="button" data-bs-toggle="modal"
                data-bs-target="#historyModal">
                <i class="fa-solid fa-clock-rotate-left"></i>
              </a>
            </li>

            <li class="nav-item dropdown me-3" style="list-style: none;">
              <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="d-none d-lg-inline text-gray-600 small">
                  <?php echo $_SESSION['mahasiswa_username']; ?>
                </span>
                <img class="img-profile rounded-circle" src="../assets/images/account.svg" width="40px" height="40px">
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal<?php echo $mahasiswaId; ?>"><i
                      class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i
                      class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
  </div>
  </nav>
  </div>

  <div class="content">
    <div class="row row-cols-1 row-cols-md-6 g-4" id="searchResults">
      <?php
      while ($row = $result->fetch_assoc()) {
        $bookId = $row['ID_Buku'];
        $isFavorite = $row['is_favorite'];
        ?>
        <div class="col">
          <div class="card" style="height: 300px">
            <div class="card-body" style="padding: 10px">
              <img src="../assets/images/<?php echo basename($row['gambar']); ?>" alt="Buku Thumbnail"
                style="width: 200px; height: 200px;">
              <h5 class="card-title">
                <?php echo limitText($row['Judul']); ?>
              </h5>
              <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#exampleModal_<?php echo $row['ID_Buku']; ?>">
                  Cek Info
                </button>
                <div class="favorite-icon" data-bookid="<?php echo $bookId; ?>"
                  data-isfavorite="<?php echo $isFavorite; ?>" data-userid="<?php echo $mahasiswaId; ?>"
                  onclick="toggleFavorite(this)">
                  <i class="fa <?php echo ($isFavorite == 'ya') ? 'fa-heart text-danger' : 'fa-regular fa-heart'; ?>"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>

    <?php
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
      ?>
      <div class="modal fade" id="exampleModal_<?php echo $row['ID_Buku']; ?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalLabel_<?php echo $row['ID_Buku']; ?>">Ajukan Peminjaman</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="process_peminjaman.php" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="card-title">
                      <?php echo ($row['Judul']); ?>
                    </h5>
                    <p class="card-text">Penulis:
                      <?php echo ($row['Penulis']); ?>
                    </p>
                    <p class="card-text">Genre:
                      <?php echo $row['genre']; ?>
                    </p>
                    <p class="card-text">Tahun Terbit:
                      <?php echo $row['TahunTerbit']; ?>
                    </p>
                    <p class="card-text">Jumlah Buku:
                      <?php echo $row['JumlahBuku']; ?>
                    </p>
                    <p class="card-text">Status Buku: <span>
                        <?php echo $row['Ketersediaan']; ?>
                      </span></p>
                    <input type="hidden" name="id_buku" value="<?php echo $row['ID_Buku']; ?>">
                    <input type="hidden" name="id_mahasiswa" value="<?php echo $_SESSION['mahasiswa_id']; ?>">
                    <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                  </div>
                  <div class="col-md-6">
                    <img src="../assets/images/<?php echo basename($row['gambar']); ?>" alt="Buku Thumbnail"
                      style="width: 200px; height: 250px;">
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <?php
    }

    ?>
  </div>

  <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel">Permintaan Peminjaman</h1>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="tablepermintaan" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>Tanggal Pengajuan</th>
                  <th>Judul Buku</th>
                  <th>Status Pengajuan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row_notification = $result_notifications->fetch_assoc()) {
                  $id_notifikasi = $row_notification['ID_Notifikasi'];
                  $id_buku_notification = $row_notification['ID_Buku'];
                  $id_mahasiswa_notification = $row_notification['ID_Mahasiswa'];
                  $tanggal_notifikasi = $row_notification['TanggalNotifikasi'];

                  $query_buku_notification = "SELECT * FROM buku WHERE ID_Buku = $id_buku_notification";
                  $result_buku_notification = $conn->query($query_buku_notification);
                  $row_buku_notification = $result_buku_notification->fetch_assoc();

                  $query_mahasiswa_notification = "SELECT * FROM mahasiswa WHERE ID_Mahasiswa = $id_mahasiswa_notification";
                  $result_mahasiswa_notification = $conn->query($query_mahasiswa_notification);
                  $row_mahasiswa_notification = $result_mahasiswa_notification->fetch_assoc();
                  ?>
                  <tr>
                    <td>
                      <?php echo date("d F Y H:i:s", strtotime($tanggal_notifikasi)); ?>
                    </td>
                    <td>
                      <?php echo $row_buku_notification['Judul']; ?>
                    </td>
                    <td>
                      <?php echo $row_notification['StatusNotifikasi']; ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="favoriteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabelFavorite">Buku Favorit</h1>
        </div>
        <div class="modal-body">
          <div class="row row-cols-1 row-cols-md-6">
            <?php
            $queryFavoriteBooks = "SELECT buku.*, favorite_books.isfavorite
                                          FROM buku
                                          LEFT JOIN favorite_books ON buku.ID_Buku = favorite_books.ID_Buku
                                          WHERE favorite_books.ID_Mahasiswa = $id_mahasiswa AND favorite_books.isfavorite = 'ya'";
            $resultFavoriteBooks = $conn->query($queryFavoriteBooks);

            while ($rowFavoriteBook = $resultFavoriteBooks->fetch_assoc()) {
              ?>
              <div class="col m-3">
                <div class="card" style="height: 300px; width: 200px;">
                  <div class="card-body" style="padding: 10px">
                    <img src="../assets/images/<?php echo basename($rowFavoriteBook['gambar']); ?>" alt="Buku Thumbnail"
                      style="width: 200px; height: 200px;">
                    <h5 class="card-title">
                      <?php echo limitText($rowFavoriteBook['Judul']); ?>
                    </h5>
                    <div class="d-flex justify-content-between align-items-center">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal_<?php echo $rowFavoriteBook['ID_Buku']; ?>">
                        Info
                      </button>
                      <form action="remove_favorite.php" method="post">
                        <input type="hidden" name="book_id" value="<?php echo $rowFavoriteBook['ID_Buku']; ?>">
                        <button type="submit" class="btn btn-danger">
                          Hapus
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabelFavorite">History Meminjam Buku</h1>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="tablehistory" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>Judul Buku</th>
                  <th>Tanggal Meminjam</th>
                  <th>Tanggal Kembali</th>
                  <th>Status Buku</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row_history_book = $resultHistoryBook->fetch_assoc()) {
                  $judulBuku = $row_history_book['Judul_buku'];
                  $tanggalPinjam = $row_history_book['TanggalPinjam'];
                  $tanggalKembali = $row_history_book['TanggalKembali'];
                  $status = $row_history_book['StatusPeminjaman'];
                  ?>
                  <tr>
                    <td>
                      <?php echo $judulBuku; ?>
                    </td>
                    <td>
                      <?php echo $tanggalPinjam; ?>
                    </td>
                    <td>
                      <?php echo $tanggalKembali ?>
                    </td>
                    <td>
                      <?php echo $status ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout Akun?</h5>
        </div>
        <div class="modal-body">Klik Logout jika siap untuk logout</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editProfileModal<?php echo $mahasiswaId ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        </div>
        <div class="modal-body">
          <form method="post" action="editProfile.php">
            <input type="hidden" name="id_mahasiswa" value="<?php echo $rowMahasiswa['ID_Mahasiswa']; ?>">

            <div class="mb-3">
              <label for="nama" class="form-label">Nama:</label>
              <input type="text" class="form-control" id="nama" name="nama"
                value="<?php echo $rowMahasiswa['Nama']; ?>">
            </div>

            <div class="mb-3">
              <label for="nim" class="form-label">NIM:</label>
              <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $rowMahasiswa['NIM']; ?>">
            </div>

            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas:</label>
              <select class="form-select" id="kelas" name="kelas">
                <option value="01" <?php echo ($rowMahasiswa['Kelas'] == '01') ? 'selected' : ''; ?>>01</option>
                <option value="02" <?php echo ($rowMahasiswa['Kelas'] == '02') ? 'selected' : ''; ?>>02</option>
                <option value="03" <?php echo ($rowMahasiswa['Kelas'] == '03') ? 'selected' : ''; ?>>03</option>
                <option value="04" <?php echo ($rowMahasiswa['Kelas'] == '04') ? 'selected' : ''; ?>>04</option>
                <option value="05" <?php echo ($rowMahasiswa['Kelas'] == '05') ? 'selected' : ''; ?>>05</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="jurusan" class="form-label">Jurusan:</label>
              <select class="form-select" id="jurusan" name="jurusan">
                <option value="SI" <?php echo ($rowMahasiswa['Jurusan'] == 'SI') ? 'selected' : ''; ?>>SI</option>
                <option value="TI" <?php echo ($rowMahasiswa['Jurusan'] == 'TI') ? 'selected' : ''; ?>>TI</option>
                <option value="MI" <?php echo ($rowMahasiswa['Jurusan'] == 'MI') ? 'selected' : ''; ?>>MI</option>
                <option value="DKV" <?php echo ($rowMahasiswa['Jurusan'] == 'DKV') ? 'selected' : ''; ?>>DKV</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="angkatan" class="form-label">Angkatan:</label>
              <input type="text" class="form-control" id="angkatan" name="angkatan"
                value="<?php echo $rowMahasiswa['TahunAngkatan']; ?>">
            </div>

            <div class="mb-3">
              <label for="no_telp" class="form-label">No Telp:</label>
              <input type="text" class="form-control" id="no_telp" name="no_telp"
                value="<?php echo $rowMahasiswa['NoTelp']; ?>">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email"
                value="<?php echo $rowMahasiswa['email']; ?>">
            </div>

            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat:</label>
              <textarea class="form-control" id="alamat" name="alamat"><?php echo $rowMahasiswa['Alamat']; ?></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Ubah
                Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="position-fixed bottom-0 end-0 m-3" style="z-index: 5">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Notification</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <!-- from server -->
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#tablepermintaan').DataTable();
      $('#tablehistory').DataTable();
    });

    function performSearch() {
      var query = document.getElementById('searchQuery').value;

      var xhr = new XMLHttpRequest();

      xhr.open('GET', 'search.php?query=' + encodeURIComponent(query), true);

      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById('searchResults').innerHTML = xhr.responseText;
        }
      };

      xhr.send();
    }

    function toggleFavorite(element) {
      var bookId = element.getAttribute('data-bookid');
      var isFavorite = element.getAttribute('data-isfavorite');
      var userId = element.getAttribute('data-userid');

      var heartIcon = element.querySelector('i.fa');
      if (isFavorite === 'ya') {
        heartIcon.classList.remove('text-danger');
        element.setAttribute('data-isfavorite', 'tidak');
      } else {
        heartIcon.classList.add('text-danger');
        element.setAttribute('data-isfavorite', 'ya');
      }

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'update_favorite.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          console.log(xhr.responseText);
        }
      };
      xhr.send('book_id=' + bookId + '&is_favorite=' + isFavorite + '&user_id=' + userId);
    }

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