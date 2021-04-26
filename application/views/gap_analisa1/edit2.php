<div class="card">
    <div class="card-body">
        <button class="btn btn-outline-primary pull-right m-1" id="btnAdd">Tambah</button>
        <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module) ?>">Kembali</a>
        <h4><?= $pertanyaan['kuesioner'] ?></h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Unit Kerja</th>
                    <th>Status</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($status as $k => $v) {
                    switch ($v['status']) {
                        case 100: {
                                $stt = 'OK';
                                $color = 'success';
                            } break;
                        case 0: {
                                $stt = 'NOK';
                                $color = 'danger';
                            } break;
                        default: {
                                $stt = $v['status'] . '%';
                                $color = 'warning';
                            } break;
                    }
                    ?>
                    <tr>
                        <td><?= $v['unit_kerja'] ?></td>
                        <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= $k ?>)"></button>
                            <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="hapus(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL STATUS-->
<div class="modal fade" id="modalStatus">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="number" class="input-id" name="id" hidden="">
                    <div class="form-group">
                        <label><b>Unit Kerja</b></label>
                        <select class="form-control select-unit-kerja" name="unit_kerja" required="">
                            <option value="">~ Unit Kerja ~</option>
                            <?php foreach ($unit_kerja as $uk) { ?>
                                <option value="<?= $uk['id'] ?>"><?= $uk['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Status</b></label>
                        <select class="form-control input-status" name="status" required="">
                            <option value="">~ status ~</option>
                            <option value="100">OK</option>
                            <option value="75">75%</option>
                            <option value="50">50%</option>
                            <option value="25">25%</option>
                            <option value="0">NOK</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var stat = <?php echo json_encode($status) ?>;
    $('#btnAdd').click(function () {
        var m = $('#modalStatus');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'tambah');
        m.find('#btnSubmit').html('Tambah');
        m.find('.modal-title').html('Tambah Status');
    });
    function edit(idx) {
        var m = $('#modalStatus');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'edit');
        m.find('#btnSubmit').html('Edit');
        m.find('.modal-title').html('Edit Status');
        m.find('.select-unit-kerja').val(stat[idx].id_unit_kerja);
        m.find('.input-status').val(stat[idx].status);
        m.find('.input-id').val(stat[idx].id);
    }
    function hapus(idx) {
        var m = $('#modalStatus');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'hapus');
        m.find('#btnSubmit').html('Hapus');
        m.find('.modal-title').html('Hapus Status');
        m.find('.select-unit-kerja').val(stat[idx].id_unit_kerja);
        m.find('.input-status').val(stat[idx].status);
        m.find('.input-id').val(stat[idx].id);
    }
</script>