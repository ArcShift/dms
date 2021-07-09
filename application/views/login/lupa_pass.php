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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="row mt-5">
            <div class="col-sm-2 col-md-3"></div>
            <div class="col-sm-8 col-md-6">
                <?php if (isset($is_alert)) { ?>
                    <div class="alert alert-<?php echo $alertType ?> alert-dismissible fade show" role="alert">
                        <button type="button" class="close" onclick="closeAlert(this)"><span aria-hidden="true">×</span></button>
                        <?php echo $alert_message ?>
                    </div>
                <?php } ?>
                <div class="card border-primary">
                    <form method="post">
                        <div class="card-header">
                            <h5 class="card-title">Lupa Password</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Masukkan email anda</label>
                                <input class="form-control" name="email" type="email" required="">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-outline-primary" name="kirim" value="ok">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        function closeAlert(obj) {
            $(obj).parent().addClass('d-none');
        }
    </script>
</html>
