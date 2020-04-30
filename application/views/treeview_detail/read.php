<?php
$role = $this->session->userdata['user']['role'];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
<script src="https://blueimp.github.io/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<!--<script src="js/jquery.iframe-transport.js"></script>-->
<script src="https://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload.js"></script>
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
    var idStandar;
    var post = null;
<?php if ($this->input->post()) { ?>
        var post = JSON.parse('<?php echo json_encode($this->input->post()) ?>');
<?php } ?>
    console.log(post);
    $('#perusahaan').change(function (s) {
        if ($(this).val()) {
            $.post('<?php echo site_url($module); ?>/standard', {'id': $(this).val()}, function (data) {
                var d = JSON.parse(data);
                $('#standar').html('');
                $('#standar').append('<option value="">-- Standar --</option>');
                for (var i = 0; i < d.length; i++) {
                    $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                }
                if (post != null) {
                    $('#standar').val(post.idStandar);
                    $('#standar').change();
                }
            });
            idPerusahaan = $(this).val();
        }
    });
    if (post != null) {
        $('#perusahaan').val(post.idPerusahaan);
        $('#perusahaan').change();
    }
    $('#standar').change(function (s) {
        idStandar = $(this).val();
        if (idStandar) {
            $('#root span').text($('#standar option:selected').text());
            getTab('pasal');
        }
    });
    function getTab(tab) {
        console.log('getTab');
        $.post('<?php echo site_url($module); ?>/tabs', {'idPerusahaan': idPerusahaan, 'idStandar': idStandar}, function (data) {
            $('#container').html(data);
            $('#tab-'+tab).addClass('active');
        });
    }
</script>
