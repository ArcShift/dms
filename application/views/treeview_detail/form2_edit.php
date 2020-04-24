<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="main-card card">
        <div class="card-header">
            <h4 class="modal-title"><?php echo $data['name'] ?><span class="item-name"></span></h4>
        </div>
        <div class="card-body">
            <input class="d-none" name="idPerusahaan" value="<?php echo $this->input->post('idPerusahaan') ?>">
            <input class="d-none" name="idPasal" value="<?php echo $this->input->post('idPasal') ?>">
            <input class="d-none" name="idStandar" value="<?php echo $data['id_standard'] ?>">
            <input class="d-none" name="idForm" value="<?php echo $data['id_form'] ?>">
            <div class="row form-group">
                <label class="col-sm-3">Deskripsi</label>
                <div class="col-sm-9">
                    <input class="form-control" name="deskripsi" value="<?php echo $data['description'] ?>">
                </div>
            </div>
            <div class="row form-group">
                <label class="col-sm-3">Dokumen Perusahaan</label>                    
                <div class="col-sm-9">
                    <input class="form-control" type="file" name="doc">
                </div>
            </div>
            <label>Implementasi & Distribusi</label>
            <div class="row">
                <div class="form-group col-sm-5">
                    <input name="jadwal" class="form-control" type="date">
                </div>
                <div class="form-group col-sm-5">
                    <select class="form-control" name="anggota">
                        <option>-- Anggota --</option>
                        <?php foreach ($member as $k => $m) { ?>
                            <option value="<?php echo $m['id'] ?>" <?php echo empty($m['member']) ? '' : 'selected' ?>><?php echo $m['username'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <button type="submit" class="btn btn-primary fa fa-plus" name="tambah" value="ok"></button>
                </div>
            </div>
            <div>
                <?php foreach ($schedule as $k => $s) { ?>
                <div class="row">
                    <div class="col-sm-5"><?php echo $s['date']?></div>
                    <div class="col-sm-5"><?php echo $s['username']?></div>
                    <div class="col-sm-2">
                        <button class="btn btn-danger fa fa-trash" name="hapus" value="<?php echo $s['id']?>"></button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-right d-block">
            <button type="submit" name="batal" value="ok" formaction="<?php echo site_url($module) ?>" class="mr-2 btn btn-transition btn-outline-warning">Batal</button>
            <button type="submit" name="simpan" value="ok" class="btn btn-transition btn-outline-info">Simpan</button>
        </div>
    </div>
</form>
<script>
    $('#tambah').click(function () {
        console.log($('#jadwal').val());
        console.log($('#anggota').val());
    });
</script>
