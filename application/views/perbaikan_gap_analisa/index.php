<?php
$unit = [];
?>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Pertanyaan</th>
                    <th>Unit</th>
                    <th>Saran Perbaikan</th>
                    <th>Bukti Perbaikan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $v) { ?>
                    <tr>
                        <td rowspan="<?= $v['row'] ?>"><?= $v['name'] ?></td>
                    </tr>
                    <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                        <tr>
                            <td rowspan="<?= $v2['row'] ?>"><?= $v2['kuesioner'] ?></td>
                        </tr>
                        <?php
                        foreach ($v2['unit'] as $k3 => $v3) {
                            array_push($unit, $v3);
                            switch ($v3['status']) {
                                case 100: {
                                        $stt = 'OK';
                                        $color = 'success';
                                    } break;
                                case 0: {
                                        $stt = 'NOK';
                                        $color = 'danger';
                                    } break;
                                default: {
                                        $stt = $v3['status'] . '%';
                                        $color = 'warning';
                                    } break;
                            }
                            ?>
                            <tr>
                                <td><?= $v3['unit_kerja'] ?></td>
                                <td style="white-space: pre-wrap"><?= $v3['saran_perbaikan'] ?></td>
                                <td>
                                    <?php if ($v3['type'] == 'FILE') { ?>
                                        <a class="btn btn-outline-primary fa fa-download" href="<?= base_url('upload/gap_analisa/' . $v3['path']) ?>"></a>
                                    <?php } elseif ($v3['type'] == 'URL') { ?>
                                        <a class="btn btn-outline-primary fa fa-eye" href="<?= $v3['path'] ?>"></a>
                                    <?php } ?>
                                </td>
                                <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= count($unit) - 1 ?>)"></button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hasil Gap Analisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Unit</label>
                        <input class="input-id" name="id" hidden="">
                        <input class="form-control input-unit" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Saran Perbaikan</label>
                        <textarea class="form-control input-saran" disabled=""></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio1" name="type" value="file" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio1">File</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio2" name="type" value="url" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio2">Url</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-file" type="file" name="userfile">
                        <input class="form-control input-url" type="url" name="url">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-outline-primary" name="edit" value="ok">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var unit = <?= json_encode($unit) ?>;
    function edit(idx) {
        var m = $('#modalEdit');
        var u = unit[idx];
        $('.radio-bukti').prop('checked', false);
        $('.input-file,.input-url').hide();
        $('.input-file,.input-url').prop('required', false);
        m.modal('show');
        m.find('.input-unit').val(u.unit_kerja);
        m.find('.input-id').val(u.id);
        m.find('.input-saran').val(u.saran_perbaikan);
        console.log(u);
    }
    $('.radio-bukti').change(function () {
        var type = $(this).val();
        var m = $('#modalEdit');
        if (type == 'file') {
            m.find('.input-file').show();
            m.find('.input-file').prop('required', true);
            m.find('.input-url').hide();
            m.find('.input-url').prop('required', false);
        } else if (type == 'url') {
            m.find('.input-file').hide();
            m.find('.input-file').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        }
        console.log($(this).val());
    });
</script>