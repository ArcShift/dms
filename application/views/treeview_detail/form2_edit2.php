<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />-->
<!--<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>-->
<?php // print_r($this->input->post()) ?>
<div class="main-card card">
    <div class="card-header">
        <h4 class="modal-title"><?php echo $data['name'] ?><span class="item-name"></span></h4>
    </div>
    <div class="card-body">
        <div class="alert alert-primary alert-dismissible fade show d-none" role="alert" id="form2UploadNotif">
            <button type="button" class="close" aria-label="Close" onclick="closeAlert(this)"><span aria-hidden="true">×</span></button>
            Menyimpan data
        </div>
        <input class="d-none" name="idPerusahaan" value="<?php echo $this->input->post('idPerusahaan') ?>">
        <input class="d-none" name="idPasal" value="<?php echo $this->input->post('idPasal') ?>">
        <input class="d-none" name="idStandar" value="<?php echo $data['id_standard'] ?>">
        <input class="d-none" name="idForm" value="<?php echo $data['id_form'] ?>">
        <input class="d-none" name="simpan" value="ok">
        <div class="form-group">
            <label>Deskripsi</label>
            <input class="form-control" name="deskripsi" value="<?php echo $data['description'] ?>">
        </div>
        <div class="form-group">
            <label>Dokumen Perusahaan</label>
            <div>
                <input type="file" name="dokumen" class="form-control">
                <span><?php echo $data['file'] ?></span>
            </div>
        </div>
        <label>Implementasi & Distribusi</label>
        <div class="row">
            <div class="form-group col-sm-5">
                <input name="jadwal" class="form-control" type="date">
            </div>
            <div class="form-group col-sm-5">
                <select class="form-control" name="anggota">
                    <option value="">-- Anggota --</option>
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
            <?php // foreach ($schedule as $k => $s) { ?>
            <div class="row">
                <div class="col-sm-5"><?php // echo $s['date']                        ?></div>
                <div class="col-sm-5"><?php // echo $s['username']                        ?></div>
                <div class="col-sm-2">
                    <button class="btn btn-danger fa fa-trash" name="hapus" value="<?php // echo $s['id']                        ?>"></button>
                </div>
            </div>
            <?php // } ?>
        </div>
    </div>
    <div class="card-footer text-right d-block">
        <button type="button" class="mr-2 btn btn-transition btn-outline-warning" onclick="closeForm()">Tutup</button>
        <button type="button" id="form2Simpan" class="btn btn-transition btn-outline-info">Simpan</button>
    </div>
</div>
<script>
    $('#form2Simpan').click(function () {
        $('#form2UploadNotif').removeClass('d-none');
        $(this).prop('disabled', true);
        var formData = new FormData($('#form2')[0]);
        formData.append('simpan', 'ok');
        $.ajax({
            url: '<?php echo site_url($module . '/form2_edit2') ?>',
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                $('#form2').html(data);
                console.log('success');
            }
        });
    });
</script>
