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
                        <input class="form-control" name="smtp_host" placeholder="Host" value="<?= $CI->model->get('smtp_host') ?>">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="smtp_user" placeholder="Username" value="<?= $CI->model->get('smtp_user') ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="smtp_pass" placeholder="Password" value="<?= $CI->model->get('smtp_pass') ?>">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-outline-primary" id="btnSendMail">Test</button>
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
<!--MODAL TEST EMAIL-->
<div class="modal fade" id="modalSendMail">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Test Kirim Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Alamat Penerima</label>
                        <input class="form-control" name="penerima" type="email" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" name="test_smtp" value="ok">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#btnSendMail').click(function () {
        var m = $('#modalSendMail');
        m.modal('show');
    });
</script>