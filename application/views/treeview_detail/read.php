<?php
$role = $this->session->userdata['user']['role'];
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-group">
            <label>Perusahaan</label>
            <select id="perusahaan" class="form-control" name="perusahaan" required="">
                <option value="">-- Perusahaan --</option>
                <?php foreach ($company as $c) { ?>
                    <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Standar</label>
            <select id="standar" class="form-control" name="perusahaan" required=""></select>
        </div>
        <div class="main-card mb-3 card">
            <div id="container" class="card-body">
            </div>
        </div>
    </div>
</div>
<script>
    var idPerusahaan;
    $('#perusahaan').change(function (s) {
        if ($(this).val()) {
            $.post('<?php echo site_url($module); ?>/standard', {'id': $(this).val()}, function (data) {
                var d = JSON.parse(data);
                $('#standar').html('');
                $('#standar').append('<option value="">-- Standar --</option>');
                for (var i = 0; i < d.length; i++) {
                    $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                }
            });
            idPerusahaan = $(this).val();
        }
    });
    $('#standar').change(function (s) {
        console.log(idPerusahaan);
        if ($(this).val()) {
            $('#root span').text($('#standar option:selected').text());
            $.get('<?php echo site_url($module);  ?>/tabs', {'idPerusahaan':idPerusahaan,'idStandar': $(this).val()}, function (data) {
                $('#container').html(data);
            });
        }
    });
</script>
