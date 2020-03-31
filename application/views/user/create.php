<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Role</label>
                <select id="role" class="form-control <?php echo form_error('role') != "" ? "is-invalid" : "" ?>" name="role" required="">
                    <option value="">-- Role --</option>
                    <?php foreach ($role as $r) { ?>
                        <option value="<?php echo $r['id'] ?>" <?php echo $r['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $r['title'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('role'); ?>
                </div>
            </div>
            <div class="form-group  input-set-corp d-none">
                <label>Perusahaan</label>
                <select id="perusahaan" class="form-control <?php echo form_error('company') != "" ? "is-invalid" : "" ?>" name="company">
                    <option value="">-- Perusahaan --</option>
                    <?php foreach ($company as $r) { ?>
                        <option value="<?php echo $r['id'] ?>" <?php echo $r['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $r['name'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('role'); ?>
                </div>
            </div>
            <div class="form-group  input-set-corp d-none">
                <label>Unit Kerja</label>
                <select id="unitKerja" class="form-control <?php echo form_error('company') != "" ? "is-invalid" : "" ?>" name="unit_kerja">
                    <option value="">-- Unit Kerja --</option>
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
                <label>Nama Lengkap</label>
                <input class="form-control <?php echo form_error('namaLengkap') != "" ? "is-invalid" : "" ?>" name="namaLengkap" placeholder="Nama Lengkap" required="" value="<?php echo $this->input->post('namaLengkap') ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('namaLengkap'); ?>
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
    $('#role').change(function () {
        var v = $(this).val();
        if (v == 2 || v == 4) {//pic - anggota
            $('.input-set-corp').removeClass('d-none');
            $('.input-set-corp').children('select').attr("required", "");
        } else {
            $('.input-set-corp').addClass('d-none');
            $('.input-set-corp').children('select').removeAttr('required');
        }
    });
    $('#perusahaan').change(function () {
//        if ($(this).val()) {
            $.post('<?php echo site_url($module . '/unit_kerja') ?>', {'id': $(this).val()}, function (data) {
                $('#unitKerja').html('');
                $('#unitKerja').append('<option value="">-- Unit Kerja --</option>');
                var data = JSON.parse(data);
                for (let i = 0; i < data.length; i++) {
                $('#unitKerja').append('<option value="'+data[i].id +'">'+data[i].name+'</option>');
                    
                }
//                console.log(JSON.parse(data));
            });
//        }
    });
</script>