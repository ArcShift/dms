<?php print_r($data) ?>
<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-header">
            <h5>Edit Data</h5>
        </div>
        <div class="card-body">
            <input hidden="" name="id" required="" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Nama" required="" value="<?php echo $data['name'] ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi">               
                    <option value="">-- Provinsi --</option>
                    <?php foreach ($province as $p) { ?>
                        <option value="<?php echo $p['id'] ?>" <?php echo $p['id'] == $data['province'] ? 'selected' : ''; ?>><?php echo $p['name'] ?></option>
                    <?php } ?>
                </select>
                <div class="error invalid-feedback">
                    <?php echo form_error('provinsi'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Kota</label>
                <select class="form-control" id="kota" name="kota"></select>
                <div class="error invalid-feedback">
                    <?php echo form_error('kota'); ?>
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
    var kota = '<?php echo $data['kota'] ?>';
    $('#provinsi').change(function () {
    var selected = '';
        $.post('<?php echo site_url($module . '/kota') ?>', {'id': $(this).val()}, function (data) {
            $('#kota').html('');
            $('#kota').append('<option value="">-- Kota --</option>');
            var data = JSON.parse(data);
            for (let i = 0; i < data.length; i++) {
                $('#kota').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                if (kota == data[i].name) {
                    selected = data[i].id;
                }
            }
            console.log(selected);
            if (selected != '') {
                $("#kota").val(selected);
            }
        });
    });
    $('#provinsi').change();
</script>