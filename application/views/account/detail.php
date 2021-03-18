<?= validation_errors(); ?>
<div class="card">
    <form method="post">
        <div class="card-header">
            <h6>Ubah Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Role</label>
                        <br>
                        <span class="badge badge-secondary"><?= $data['role'] ?></span>
                    </div>
                    <?php if ($this->session->user['role'] != 'admin') { ?>
                        <div class="form-group">
                            <label>Unit Kerja</label>
                            <br>
                            <?php foreach ($data['unit_kerja'] as $uk) { ?>
                                <span class="badge badge-secondary"><?= $uk['name'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Tugas Unit</label>
                            <br>
                            <?php foreach ($data['jobdesk'] as $j) { ?>
                                <span class="badge badge-secondary"><?= $j['name'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Perusahaan</label>
                            <br>
                            <label><b><?= $data['perusahaan'] ?></b></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control <?= form_error('username') != "" ? "is-invalid" : "" ?>" name="username" placeholder="Username" required="" value="<?= $data['username'] ?>">
                        <div class="error invalid-feedback">
                            <?= form_error('username'); ?>
                        </div>
                    </div>
                    <?php if ($this->session->user['role'] != 'admin') { ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control <?= form_error('email') != "" ? "is-invalid" : "" ?>" name="email" placeholder="user@site.com" value="<?= $data['email'] ?>">
                            <div class="error invalid-feedback">
                                <?= form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Personil</label>
                            <input class="form-control" value="<?php echo $data['fullname'] ?>" disabled="">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="d-block card-footer text-right">
            <button class="btn btn-primary" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>
<br/>
<div class="row"> 
    <div class="col-sm-6">
        <div class="card">
            <form method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h6>Upload Foto</h6>
                </div>
                <div class="card-body">
                    <img class="rounded-circle text-right" src="<?php echo base_url('upload/profile_photo/' . $data['photo']) ?>" alt="" width="100">
                    <div class="form-group">
                        <input class="form-control" name="foto" type="file" required="" accept=".gif,.jpg,.png">
                    </div>
                </div>
                <div class="d-block card-footer text-right">
                    <button class="btn btn-primary" name="edit_foto" value="ok">Simpan</button>
                </div>
            </form>
        </div>       
    </div>
    <div class="col-sm-6">
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
    </div>
</div>