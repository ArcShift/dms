<div class="card">
    <form method="post">        
        <div class="card-header">
            <h6>Ubah Data</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Username</label>
                <input class="form-control <?php echo form_error('name') != "" ? "is-invalid" : "" ?>" name="name" placeholder="Username" required="" value="<?php echo $data['username'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('name'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label> 
                <input class="form-control <?php echo form_error('namaLengkap') != "" ? "is-invalid" : "" ?>" name="namaLengkap" placeholder="Nama lengkap" required="" value="<?php echo $data['fullname'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('name'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input class="form-control"  disabled="" value="<?php echo $data['role'] ?>">
            </div>
        </div>
        <div class="d-block card-footer text-right">
            <button class="btn btn-primary" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>
<br/>
<div class="card">
    <form method="post">        
        <div class="card-header">
            <h6>Ubah Password</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Password Lama</label>
                <input class="form-control <?php echo form_error('old_pass') != "" ? "is-invalid" : "" ?>" type="password" name="old_pass" placeholder="Password Lama" required="">
                <div class="error invalid-feedback">
                    <?php echo form_error('old_pass'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input class="form-control <?php echo form_error('new_pass') != "" ? "is-invalid" : "" ?>" type="password" name="new_pass" placeholder="Password Baru" required="">
                <div class="error invalid-feedback">
                    <?php echo form_error('new_pass'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Ulangi Password</label>
                <input class="form-control <?php echo form_error('re_pass') != "" ? "is-invalid" : "" ?>" type="password" name="re_pass" placeholder="Ulangi Password" required="">
                <div class="error invalid-feedback">
                    <?php echo form_error('re_pass'); ?>
                </div>
            </div>
        </div>
        <div class="d-block card-footer text-right">
            <button class="btn btn-primary" name="edit_pass" value="ok">Simpan</button>
        </div>
    </form>
</div>