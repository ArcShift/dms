<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Role</label>
                <select id="role" class="form-control <?php echo form_error('role') != "" ? "is-invalid" : "" ?>" name="role" required="">
                    <option value="">-- Role --</option>
                    <?php foreach ($roles as $r) { ?>
                        <option value="<?php echo $r['id'] ?>" <?php echo $r['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $r['title'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('role'); ?>
                </div>
            </div>
            <div class="form-group  input-set-corp d-none">
                <label>Personil</label>
                <select class="form-control <?php echo form_error('company') != "" ? "is-invalid" : "" ?>" name="personil">
                    <option value="">-- Personil --</option>
                    <?php foreach ($freePersonil as $p) { ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $this->input->post('personil') ? 'selected' : ''; ?>><?= $p['fullname'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('role'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Username" required="" value="<?php echo $this->input->post('nama') ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control <?php echo form_error('pass') != "" ? "is-invalid" : "" ?>" type="password" name="pass" placeholder="Password" required="">
                <div class="error invalid-feedback">
                    <?php echo form_error('pass'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Ulangi Password</label>
                <input class="form-control <?php echo form_error('ulangi_pass') != "" ? "is-invalid" : "" ?>" type="password" name="ulangi_pass" placeholder="Ulangi Password" required="">
                <div class="error invalid-feedback">
                    <?php echo form_error('ulangi_pass'); ?>
                </div>
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-primary pull-right" name="tambah" value="ok">Simpan</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#role').change();
    });
    $('#role').change(function () {
        var v = $(this).val();
        if (v == 2 || v == 4 || v == 5) {//pic - anggota - ketua
            $('.input-set-corp').removeClass('d-none');
            $('.input-set-corp').children('select').attr("required", "");
        } else {
            $('.input-set-corp').addClass('d-none');
            $('.input-set-corp').children('select').removeAttr('required');
        }
    });
</script>