<form method="post" action="<?php echo site_url($module . '\form2_edit') ?>">
    <div class="modal-header">
        <h4 class="modal-title">Dokumen Perusahaan: <?php echo $data['name'] ?><span class="item-name"></span></h4>
        <button class="close" type="button" aria-label="Close" onclick="closeForm()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input class="d-none" name="idPerusahaan" value="<?php echo $this->input->post('idPerusahaan') ?>">
        <input class="d-none" name="idPasal" value="<?php echo $this->input->post('idPasal') ?>">
        <input class="d-none" name="idStandar" value="<?php echo $data['id_standard'] ?>">
        <div class="form-group">
            <label>Catatan</label>
            <br>
            <div class="mb-2 mr-2 badge badge-primary">
                <?php echo $data['description'] ?>
            </div>
        </div>
        <div class="form-group">
            <label>Anggota</label>
            <div>
                <?php // foreach ($member as $k => $m) { ?>
                    <?php // if (!empty($m['member'])) { ?>
                        <!--<div class="mb-2 mr-2 badge badge-primary">-->
                            <?php // echo $m['username'] ?>
                        <!--</div>-->
                    <?php // } ?>
                <?php // } ?>
            </div>
        </div>
        <div class="form-group">
            <label>Dokumen & form terisi</label>
            <br>
            <div class="mb-2 mr-2 badge badge-primary">
                download
            </div>
        </div>
        <div class="form-group">
            <label>Jadwal</label>
            <br>
            <div class="mb-2 mr-2 badge badge-primary">
                Jadwal
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-transition btn-outline-warning" onclick="closeForm()">Tutup</button>
        <button type="submit" class="btn btn-transition btn-outline-info" name="initEdit" value="ok">Edit</button>
    </div>
</form>
