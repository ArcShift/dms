<?php
if (isset($msgSuccess)) {
    $alertType = 'success';
    $alert_message = $msgSuccess;
    $is_alert = true;
} elseif (isset($msgError)) {
    $alertType = 'danger';
    $alert_message = $msgError;
    $is_alert = true;
}
?>
<div class="row mt-5">
    <div class="col-sm-2 col-md-3"></div>
    <div class="col-sm-8 col-md-6">
        <?php if (isset($is_alert)) { ?>
            <div class="alert alert-<?php echo $alertType ?> alert-dismissible fade show" role="alert">
                <button type="button" class="close" onclick="closeAlert(this)"><span aria-hidden="true">×</span></button>
                <?php echo $alert_message ?>
            </div>
        <?php } ?>
        <?php if (!isset($invalidToken)) { ?>
            <div class="card border-primary">
                <form method="post">
                    <div class="card-header">
                        <h5 class="card-title">Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Masukkan password baru</label>
                            <input class="form-control" name="pass_baru" type="password" required="">
                        </div>
                        <div class="form-group">
                            <label>Ulangi password</label>
                            <input class="form-control" name="pass_ulang" type="password" required="">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-outline-primary" name="simpan" value="ok">Konfirmasi</button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>