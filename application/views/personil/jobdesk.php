<div class="card">
    <div class="card-body">
        <form>
            <button class="btn btn-outline-primary float-right" name="back" value="ok">Kembali</button>
        </form>
        <h4>
        <?= $header->fullname ?> -
        <?= $header->unit_kerja ?>
        </h4>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Jobdesk Unit</th>
                    <th>Jobdesk Personil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $d) { ?>
                    <tr>
                        <td><?= $d->jobdesk ?></td>
                        <td><?= $d->desc ?></td>
                        <td>
                            <button class="btn btn-outline-primary fa fa-edit" onclick="initEdit(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <form method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jobdesk Personil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Jobdesk Unit</b></label>
                        <input class="form-control input-id-ju" name="id_ju" hidden="">
                        <input class="form-control input-ju" disabled="">
                    </div>
                    <div class="form-group">
                        <label><b>Jobdesk Personil</b></label>
                        <input class="form-control input-desc" name="jp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary" name="edit" value="ok">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var data = <?= json_encode($data) ?>;
    function initEdit(idx) {
        var d = data[idx];
        console.log(d);
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.input-id-ju').val(d.id_jobdesk);
        m.find('.input-ju').val(d.jobdesk);
        m.find('.input-desc').val(d.desc);
    }
</script>
