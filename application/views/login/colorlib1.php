<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->config->item('app_short_name') . ' - ' . $this->config->item('app_name') ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v18/vendor/bootstrap/css/bootstrap.min.css">
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
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/daterangepicker/moment.min.js"></script>
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/daterangepicker/daterangepicker.js"></script>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/vendor/countdowntime/countdowntime.js"></script>
        <!--===============================================================================================-->
    </head>
    <body style="background-color: #666666;">	
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" method="post">
                        <span class="login100-form-title p-b-43">
                            <?php echo $this->config->item('app_name') ?>
                        </span>
                        <?php if ($this->input->post('login')) { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Login Gagal</h4>
                                Username/ password salah
                            </div>
                        <?php } ?>
                        <div class="wrap-input100 validate-input">
                            <input id="inputUser" class="input100 has-val" type="text" name="user" value="<?php echo $this->input->post('user') ?>">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Username</span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100 has-val" type="password" name="pass">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" name="login" value="l">
                                Login
                            </button>
                        </div>
                    </form>
                    <div class="login100-more" style="background-image: url('https://colorlib.com/etc/lf/Login_v18/images/bg-01.jpg');">
                    </div>
                </div>
            </div>
        </div>
        <!--===============================================================================================-->
        <script src="https://colorlib.com/etc/lf/Login_v18/js/main.js"></script>
        <script>
            $('#inputUser').click();
        </script>
    </body>
</html>