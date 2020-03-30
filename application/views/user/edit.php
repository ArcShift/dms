<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-header">
            <h5>Edit Data</h5>
        </div>
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id']?>">
            <div class="form-group">
                <label>Username</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Username" required="" value="<?php echo $data['username'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control <?php echo form_error('namaLengkap') != "" ? "is-invalid" : "" ?>" name="namaLengkap" placeholder="Nama Lengkap" required="" value="<?php echo $data['fullname'] ?>">
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
<div class="main-card mb-3 card">
    <form method="post">        
        <div class="card-header">
            <h5>Edit Password</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Password</label>
                <input class="form-control <?php // echo form_error('pass') != "" ? "is-invalid" : "" ?>" type="password" name="pass" placeholder="Password" required="">
                <div class="error invalid-feedback">
                    <?php // echo form_error('pass'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Ulangi Password</label>
                <input class="form-control <?php // echo form_error('ulangi_pass') != "" ? "is-invalid" : "" ?>" type="password" name="ulangi_pass" placeholder="Ulangi Password" required="">
                <div class="error invalid-feedback">
                    <?php // echo form_error('ulangi_pass'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-primary pull-right" name="editPass" value="ok">Simpan</button>
        </div>
    </form>
</div>