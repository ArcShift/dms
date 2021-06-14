<div class="card">
    <div class="card-body">
        <button class="btn btn-outline-primary float-right mb-3" id="createProject">Buat Proyek Baru</button>
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Deskripsi</th>
                    <th>Tugas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d) { ?>
                    <tr>
                        <td><?= $d->nama ?></td>
                        <td><?= $d->deskripsi ?></td>
                        <td><span class="badge badge-danger">0</span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL DELETE TUGAS-->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Project Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input class="form-control" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <textarea class="form-control" name="desc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary" name="create" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#createProject').click(function () {
        var m = $('#modalCreate');
        m.modal('show');
    });
</script>