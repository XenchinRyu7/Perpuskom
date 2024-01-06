<div class="modal fade" id="editProfileModalAdmin<?php echo $adminId ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile Admin</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="edit_admin.php">
                    <input type="hidden" name="id_admin" value="<?php echo $adminId; ?>">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?php echo $rowAdmin['Nama']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?php echo $rowAdmin['username']; ?>">
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