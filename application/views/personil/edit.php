<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-header">
            <h5>Edit Data</h5>
        </div>
        <div class="card-body">
            <!--<input hidden="" name="id" required="" value="<?php // $data['id']     ?>">-->
            <input hidden="" name="id_company" required="" value="<?= $data['id_company'] ?>">
            <div class="form-group">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control <?php echo form_error('fullname') != "" ? "is-invalid" : "" ?>" name="fullname" placeholder="Nama Lengkap" required="" value="<?php echo $data['fullname'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('fullname'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary pull-right" name="edit" value="<?= $data['id'] ?>">Simpan</button>
        </div>
    </form>
</div>
<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <?php if (!empty($data['excluded_unit_kerja'])) { ?>
                <span class="btn btn-outline-primary pull-right" onclick="add()">Tambah</span>
            <?php } ?>
            <h5>Unit Kerja</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th class="text-center">Pembuat<br>Dokumen</th>
                        <th class="text-center">Distribusi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['unit_kerja'] as $k => $uk) { ?>
                        <tr>
                            <td><?= $uk['name'] ?></td>
                            <td class="text-center"><span class="badge badge-secondary"><?= count($this->db->get_where('document', ['pembuat' => $uk['id_position_personil']])->result_array()) ?></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><?= count($this->db->get_where('distribution', ['id_position_personil' => $uk['id_position_personil']])->result_array()) ?></span></td>
                            <td class="text-center">
                                <span class="btn btn-outline-danger fa fa-trash" onclick="initDelete(<?= $k ?>)" title="Hapus"></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="d-block text-right card-footer">
        </div>
    </form>
</div>
<!--MODAL ADD-->
<div class="modal fade" id="modalAdd">
    <form method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="unit_kerja">
                            <?php foreach ($data['excluded_unit_kerja'] as $k => $v) { ?>
                            <option value="<?= $v['id']?>"><?= $v['name'] ?></option>
                            <?php } ?>
                        </select>
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
                        <input class="input-nama form-control">
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
    function initDelete(index) {
        var uk = unitKerja[index];
        var m = $('#modalDelete').modal('show');
        m.find('.input-nama').val(uk.name);
        m.find('.input-delete').val(uk.id_position_personil);
    }
    var unitKerja = <?= json_encode($data['unit_kerja']) ?>
</script>