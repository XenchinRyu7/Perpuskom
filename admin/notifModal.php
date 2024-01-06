<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Permintaan Peminjaman</h1>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tablenotif" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Mahasiswa Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Aksi</th>
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
                                        <?php echo $tanggal_notifikasi; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_mahasiswa_notification['Nama']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_buku_notification['Judul']; ?>
                                    </td>
                                    <td>
                                        <form method="post" action="process_notifikasi.php">
                                            <input type="hidden" name="id_notifikasi" value="<?php echo $id_notifikasi; ?>">
                                            <button type="submit" name="action" value="terima"
                                                class="btn btn-success">Terima</button>
                                            <button type="submit" name="action" value="tolak"
                                                class="btn btn-danger">Tolak</button>
                                        </form>
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