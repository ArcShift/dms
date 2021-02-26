<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Nama" required="" value="<?php echo $data['name'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary pull-right" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <span class="btn btn-outline-primary pull-right" onclick="add()">Tambah</span>
        <h5>Tugas Unit</h5>
    </div>
</div>
<!--MODAL ADD-->
<div class="modal fade" id="modalAdd">
    <form method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" name="tugas">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary" name="add" value="ok">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--MODAL DELETE-->
<div class="modal fade" id="modalDelete">
    <form method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="input-id-personil" name="id_personil" value="<?= $data['id'] ?>" hidden="">
                        <input class="input-nama form-control" readonly="">
                    </div>
                    <div class="div-warning text-danger">
                        Personil dengan Unit kerja ini sudah terkait dengan dokumen / distribusi. Anda yakin ingin menghapusnya?
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger input-delete" name="delete" value="ok">Hapus</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function add() {
        $('#modalAdd').modal('show');
    }
</script>