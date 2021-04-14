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
                    <th>Hasil Gap Analisa</th>
                    <th>Saran Perbaikan</th>
                    <th>Target</th>
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
                            ?>
                            <tr>
                                <td><?= $v3['unit_kerja'] ?></td>
                                <td style="white-space: pre-wrap"><?= $v3['hasil'] ?></td>
                                <td style="white-space: pre-wrap"><?= $v3['saran_perbaikan'] ?></td>
                                <td><?= empty($v3['target'])?'':date('d M Y', strtotime($v3['target'])) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= count($unit)-1 ?>)"></button>
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
            <form method="post">
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
                        <label>Hasil Gap Analisa</label>
                        <textarea class="form-control input-hasil" name="hasil"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Saran Perbaikan</label>
                        <textarea class="form-control input-saran" name="saran"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Target</label>
                        <input class="form-control input-target" name="target" type="date">
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
        m.modal('show');
        m.find('.input-unit').val(u.unit_kerja);
        m.find('.input-id').val(u.id);
        m.find('.input-hasil').val(u.hasil);
        m.find('.input-saran').val(u.saran_perbaikan);
        m.find('.input-target').val(u.target);
        console.log(u);
    }
</script>