<div class="main-card mb-3 card">
    <form method="post">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <?php // if(!isset($this->session->user['id_company'])){ ?>
            <div class="form-group" <?= $role=='admin'?'':'hidden' ?>>
                <label>Perusahaan</label>
                <select class="form-control" name="perusahaan" id="perusahaan" required="">
                    <?php if ($this->session->userdata('user')['role'] == 'admin') { ?>
                        <option value="">-- Perusahaan --</option>
                    <?php } ?>
                    <?php foreach ($company as $c) { ?>
                        <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php // }?>
            <div class="form-group">
                <label>Unit Kerja</label>
                <select id="unitKerja" class="form-control" name="unit_kerja[]" multiple="">
                    <option value="">-- Unit Kerja --</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control" name="nama" required="" placeholder="Nama">
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" href="<?php echo site_url($module) ?>">Batal</a>
            <button class="btn btn-primary" name="buat" value="ok">Tambah</button>
        </div>
    </form>
</div>
<script>
    $('#perusahaan').change(function () {
        $.post('<?php echo site_url($module . '/unit_kerja') ?>', {'id': $(this).val()}, function (data) {
            $('#unitKerja').html('');
            $('#unitKerja').append('<option value="">-- Unit Kerja --</option>');
            var data = JSON.parse(data);
            for (let i = 0; i < data.length; i++) {
                $('#unitKerja').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        });
    });
    $('#unitKerja').select2();
    function afterReady() {
        $('#perusahaan').change();
    }
</script>