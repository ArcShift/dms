<div class="main-card mb-3 card">
    <form method="post">
        <div class="card-body">
            <input hidden="" name="id_company" required="" value="<?= $data['id_company'] ?>">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control <?php echo form_error('fullname') != "" ? "is-invalid" : "" ?>" name="fullname" placeholder="Nama Lengkap" required="" value="<?php echo $data['fullname'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('fullname'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary" name="edit" value="<?= $data['id'] ?>">Simpan</button>
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
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
<!--                        <th class="text-center">Pembuat<br>Dokumen</th>
                        <th class="text-center">Distribusi</th>-->
                        <th class="pl-5">Tugas Unit</th>
                        <th class="pl-5">Tugas Personil</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data['unit_kerja'] as $k => $uk) {
                        $countDocument = count($this->db->get_where('document', ['pembuat' => $uk['id_position_personil']])->result_array());
                        $countDistribusi = count($this->db->get_where('distribution', ['id_position_personil' => $uk['id_position_personil']])->result_array());
                        if ($countDocument == 0 & $countDistribusi == 0) {
                            $data['unit_kerja'][$k]['saveDelete'] = true;
                        } else {
                            $data['unit_kerja'][$k]['saveDelete'] = false;
                        }
                        ?>
                        <tr class="table-secondary">
                            <td><?= $uk['name'] ?></td>
                            <!--<td class="text-center"><span class="badge badge-secondary"><?= $countDocument ?></span></td>-->
                            <!--<td class="text-center"><span class="badge badge-secondary"><?= $countDistribusi ?></span></td>-->
                            <td></td>
                            <td></td>
                            <!--<td></td>-->
                            <td class="text-center">
                                <?php if (!empty($uk['tugas_unit'])) { ?>
                                    <button class="btn btn-outline-primary fa fa-edit" value="<?= $uk['id_position_personil'] ?>" name="jobdesk" title="Edit Tugas Personil"></button>
                                <?php }else{ ?>
                                    <button class="btn btn-outline-primary fa fa-edit" value="<?= $uk['id'] ?>" name="tugasUnit" title="Edit Tugas Unit"></button>
                                <?php } ?>
                                <span class="btn btn-outline-danger fa fa-trash" onclick="initDelete(<?= $k ?>)" title="Hapus Unit Kerja pada Personil"></span>
                            </td>
                        </tr>
                        <?php foreach ($uk['tugas_unit'] as $k2 => $tu) { ?>
                            <tr>
                                <td></td>
                                <td>                           
                                    <?= $tu['name'] ?>
                                </td>
                            </tr>

                            <?php foreach ($tu['jobdesk_personil'] as $k3 => $jp) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><?= $jp['desc'] ?></td>
                                </tr>
                            <?php } ?>

                        <?php } ?>
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
                                <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
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
    function initDelete(index) {
        var uk = unitKerja[index];
        var m = $('#modalDelete').modal('show');
        m.find('.input-nama').val(uk.name);
        m.find('.input-delete').val(uk.id_position_personil);
        if (uk.saveDelete) {
            m.find('.div-warning').hide();
        } else {
            m.find('.div-warning').show();
        }
    }
    var unitKerja = <?= json_encode($data['unit_kerja']) ?>
</script>