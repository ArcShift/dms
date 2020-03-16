<?php
    print_r($data);
?>
<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-header">
            <h5>Edit Data</h5>
        </div>
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id']?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Nama" required="" value="<?php echo $data['name'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select class="form-control <?php echo form_error('role') != "" ? "is-invalid" : "" ?>" name="role" required="">
                    <option value="">-- Role --</option>
                    <?php foreach ($role as $r) { ?>
                        <option value="<?php echo $r['id'] ?>" <?php echo $r['id'] == $data['id_role'] ? 'selected' : ''; ?>><?php echo $r['name'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('role'); ?>
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