<div class="card">
    <div class="card-body">
        <button class="btn btn-outline-primary float-right mb-3" id="createProject">Buat Proyek Baru</button>
        <table class="table">
            <thead>
                <tr>
                    <th>Proyek</th>
                    <th>Deskripsi</th>
                    <th>Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $d) { ?>
                    <tr>
                        <td><?= $d->nama ?></td>
                        <td><?= $d->deskripsi ?></td>
                        <td><span class="badge badge-<?= $d->tugas == 0 ? 'danger' : 'primary' ?>"><?= $d->tugas ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEdit(<?= $k ?>)"></button>
                            <?php if ($d->tugas == 0) { ?>
                                <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="initHapus(<?= $k ?>)"></button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL CREATE-->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input class="form-control input-nama" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <textarea class="form-control input-desc" name="desc"></textarea>
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
<!--MODAL DELETE-->
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Proyek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input class="form-control input-nama" disabled="">
                        <input class="form-control input-id" name="id" required="" hidden="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var data = <?= json_encode($data) ?>;
    $('#createProject').click(function () {
        var m = $('#modalCreate');
        m.modal('show');
        m.find('.modal-title').html('Buat Proyek Baru');
        m.find('form').trigger('reset');
    });
    function initHapus(idx) {
        var d = data[idx];
        var m = $('#modalHapus');
        m.modal('show');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').val(d.id);
    }
    function initEdit(idx) {
        var m = $('#modalCreate');
        var d = data[idx];
        m.modal('show');
        m.find('.modal-title').html('Edit Proyek');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').val(d.id);
        m.find('.input-desc').val(d.deskripsi);
    }
</script>