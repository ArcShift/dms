<?php $n = 0 ?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module) ?>">Kembali</a>
        <h4><?= $pasal['fullname'] ?></h4>
        <span class="badge badge-secondary">Pertanyaan: <?= count($pertanyaan) ?></span>
        <span class="badge badge-secondary">Status: <?= count($status) ?></span>
        <span class="badge badge-secondary">Nilai rata-rata: <?= round($average) ?>%</span>
        <div style="border: 0.5px solid gray; padding: 8px; border-radius: 10px; margin: 20px 0px 20px 0px">
            <b>Bukti Pasal</b>
            <p style=" white-space: pre-wrap"><?= $pasal['bukti'] ?></p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Status</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pertanyaan as $k => $v) { ?>
                    <tr class="table-success">
                        <td colspan="2"><b><?= $v['kuesioner'] ?></b></td>
                       <!--<td><b><?= $v['average'] ?></b></td>-->
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-plus" onclick="tambah(<?= $v['id'] ?>)"></button>
                        </td>
                    </tr>
                    <?php
                    foreach ($v['detail'] as $k2 => $v2) {
                        switch ($v2['status']) {
                            case 100: {
                                    $stt = 'OK';
                                    $color = 'success';
                                } break;
                            case 0: {
                                    $stt = 'NOK';
                                    $color = 'danger';
                                } break;
                            default: {
                                    $stt = $v2['status'] . '%';
                                    $color = 'warning';
                                } break;
                        }
                        ?>
                        <tr>
                            <td><?= $v2['unit_kerja'] ?></td>
                            <td>
                                <span class="badge badge-<?= $color ?>"><?= $stt ?></span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= $n ?>)"></button>
                                <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="hapus(<?= $n ?>)"></button>
                            </td>
                        </tr>
                        <?php
                        $n++;
                    }
                    ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL-->
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
                    <div class="form-group">
                        <select class="form-control select-unit-kerja" name="unit_kerja" required="">
                            <option value="">~ Unit Kerja ~</option>
                            <?php foreach ($unit_kerja as $uk) { ?>
                                <option value="<?= $uk['id'] ?>"><?= $uk['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="input-id" name="id" hidden="">
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
    function tambah(idx) {
        console.log(idx);
        var m = $('#modalStatus');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'tambah');
        m.find('#btnSubmit').html('Tambah');
        m.find('.modal-title').html('Tambah Status');
        m.find('.input-id').val(idx);
    }
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
<?php
// print_r($pertanyaan) ?>