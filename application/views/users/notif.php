<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<style>
    .toggle, .toggle-group, .toggle-handle { 
        border-radius: 20px;
    }
</style>
<br>
<br>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                Pengaturan Notifikasi Email
            </div>
            <div class="card-body">
                Ijinkan Notifikasi melalui Email
                <span class="pull-right">
                    <input id="switchStatus" type="checkbox" data-width="50" <?= $data['notif_email'] == 'ENABLE' ? 'checked' : '' ?> data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-size="mini">
                </span>
            </div>
        </div>
    </div>
</div>
<script>
    $('#switchStatus').change(function () {
        $.post('<?= site_url('users/notif/switch_status') ?>', null, function (data) {
        }).fail(function () {
            alert('gagal mengubah status');
            $('#switchStatus').prop("checked", !$('#switchStatus').prop("checked"));
        });
    });
</script>