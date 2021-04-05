<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->config->item('short_app_name') . ' - ' . $this->config->item('app_name') ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <!--<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/bootstrap/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/select2/select2.min.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/css/util.css">
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/css/main.css">

        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/animsition/js/animsition.min.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/bootstrap/js/popper.js"></script>
        <!--<script src="https://colorlib.com/etc/lf/Login_v18/vendor/bootstrap/js/bootstrap.min.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/daterangepicker/moment.min.js"></script>
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/daterangepicker/daterangepicker.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/countdowntime/countdowntime.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/js/main.js"></script>
    </head>
    <body style="background-color: #666666;">	
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" method="post" style="padding-top: 0px">
                        <?php if ($this->config->item('loginLogo')) { ?>
                            <img src="<?= base_url('assets/images/' . $this->config->item('loginLogo')) ?>" style="width: 100%">
                        <?php } else { ?>
                            <span class="login100-form-title p-b-43" style="padding-top: 200px">
                                <?php echo $this->config->item('app_name') ?>
                            </span>
                        <?php } ?>
                        <?php if ($this->input->post('login')) { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Login Gagal</h4>
                                Username/ password salah
                            </div>
                        <?php } ?>
                        <label>Username</label>
                        <div class="input-group">
                            <input class="form-control" name="user" value="<?php echo $this->input->post('user') ?>" required="">
                        </div>
                        <br>
                        <label>Password</label>
                        <div class="input-group">
                            <input class="form-control" type="password" id="input-pass" name="pass" required="">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success fa fa-eye" onclick="myFunction()" type="button"></button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" name="login" value="l">
                                Login
                            </button>
                        </div>
                    </form>
                    <div class="login100-more" style="background-image: url('<?= base_url('assets/images/login-ema.jpg') ?>');">
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        function myFunction() {
            var x = document.getElementById("input-pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</html>