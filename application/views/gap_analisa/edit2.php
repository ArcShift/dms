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
                <?php foreach ($status as $k => $v) { ?>
                    <tr>
                        <td><?= $v['unit_kerja'] ?></td>
                        <td><?= $v['status'] ?></td>
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
<!--MODAL TAMBAH-->
<div class="modal fade" id="modalAdd">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="unit_kerja" required="">
                            <option value="">~ Unit Kerja ~</option>
                            <?php foreach ($unit_kerja as $uk) { ?>
                                <option value="<?= $uk['id'] ?>"><?= $uk['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" max="100" min="0" class="form-control" name="status" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pertanyaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="input-id" name="id" required="" hidden="">
                        <textarea class="form-control input-pertanyaan" required="" name="pertanyaan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" name="edit" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Pertanyaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="input-id" name="id" required="" hidden="">
                        <textarea class="form-control input-pertanyaan" required="" readonly=""></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var pertanyaan = <?= json_encode($pertanyaan) ?>;
    $('#btnAdd').click(function () {
        $('#modalAdd').modal('show');
    });
    function hapus(idx) {
        var m = $('#modalHapus');
        m.modal('show');
        m.find('.input-id').val(pertanyaan[idx].id);
        m.find('.input-pertanyaan').val(pertanyaan[idx].kuesioner);
    }
    function edit(idx) {
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.input-id').val(pertanyaan[idx].id);
        m.find('.input-pertanyaan').val(pertanyaan[idx].kuesioner);
    }
</script>
<?php
// print_r($pertanyaan) ?>