<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-header">
            <h5>Edit Data</h5>
        </div>
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id']?>">
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
            <a class="mr-2 btn btn-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-primary pull-right" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>