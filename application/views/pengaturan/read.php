<?php
$CI = & get_instance();
$CI->load->model('setting', 'model');
?>
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#tabSmtp" class="nav-link">SMTP</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active col-sm-6" id="tabSmtp" role="tabpanel">
                <form method="post">
                    <div class="form-group">
                        <label>Host</label>
                        <input class="form-control" name="host" placeholder="Host" value="<?= $CI->model->get('host') ?>">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" placeholder="Username" value="<?= $CI->model->get('username') ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" placeholder="Password" value="<?= $CI->model->get('password') ?>">
                    </div>
                    <div class="text-right">
                        <!--<button class="btn btn-outline-primary">Test</button>-->
                        <button class="btn btn-outline-primary" name="update_smtp" value="ok">Simpan</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab2" role="tabpanel">
                22
            </div>
        </div>
    </div>
</div>