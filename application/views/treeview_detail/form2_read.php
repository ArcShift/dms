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
            <label>Dokumen & form terisi</label>
            <br>
            <?php if (!empty($data['file'])) { ?>
                <a href="<?php echo base_url('upload/form2/' . $data['file']) ?>">
                    <span class="mb-2 mr-2 badge badge-primary">
                        download
                    </span>
                </a>
                <span><?php echo $data['file'] ?></span>
            <?php } else { ?>
                <span class="mb-2 mr-2 badge badge-primary">-</span>
            <?php } ?>
        </div>
        <div class="form-group">
            <label>Jadwal</label>
            <br>
            <div>
                <?php foreach ($schedule as $s) { ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="mb-2 mr-2 badge badge-primary">
                                <?php echo $s['date'] ?>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <span class="mb-2 mr-2 badge badge-primary">
                                <?php echo $s['username'] ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-transition btn-outline-warning" onclick="closeForm()">Tutup</button>
        <button type="submit" class="btn btn-transition btn-outline-info" name="initEdit" value="ok">Edit</button>
    </div>
</form>
