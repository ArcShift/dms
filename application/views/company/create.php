<div class="main-card mb-3 card">
    <form class="form-horizontal" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control <?php echo form_error('nama') != "" ? "is-invalid" : "" ?>" name="nama" placeholder="Nama" required="" value="<?php echo $this->input->post('nama') ?>">
                <div class="error invalid-feedback">
                    <?php echo form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi">               
                    <option value="">-- Provinsi --</option>
                    <?php foreach ($province as $p) { ?>
                        <option value="<?php echo $p['id'] ?>" <?php echo $p['id'] == $this->input->post('provinsi') ? 'selected' : ''; ?>><?php echo $p['name'] ?></option>
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
            <button class="btn btn-primary pull-right" name="tambah" value="ok">Simpan</button>
        </div>
    </form>
</div>
<script>
    $('#provinsi').change(function () {
        console.log('change');
        $.post('<?php echo site_url($module . '/kota') ?>', {'id': $(this).val()}, function (data) {
            $('#kota').html('');
            $('#kota').append('<option value="">-- Kota --</option>');
            var data = JSON.parse(data);
            for (let i = 0; i < data.length; i++) {
                $('#kota').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');

            }
//                console.log(JSON.parse(data));
        });
//        }
    });
</script>