<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Nama" required="" value="<?php echo $data['name'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-primary pull-right" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>
<script>
    $("#jenis").val("<?php echo $data['jenis']?>");
</script>