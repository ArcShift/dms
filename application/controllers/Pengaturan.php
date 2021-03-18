<?php

class Pengaturan extends MY_Controller {

    protected $module = 'pengaturan';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_setting', 'model');
    }

    function index() {
        if ($this->input->post('update_smtp')) {
            if ($this->input->post('smtp_host')) {
                $this->model->set('smtp_host', $this->input->post('smtp_host'));
            }
            if ($this->input->post('smtp_user')) {
                $this->model->set('smtp_user', $this->input->post('smtp_user'));
            }
            if ($this->input->post('smtp_pass')) {
                $this->model->set('smtp_pass', $this->input->post('smtp_pass'));
            }
            $this->data['msgSuccess'] = 'Data berhasil diubah';
        } else if ($this->input->post('test_smtp')) {
            $sendMail = parent::notif_mail($this->input->post('penerima'), 'dms', 'test email');
            if ($sendMail !== true) {
                $this->data['msgError'] = $sendMail;
            } else {
                $this->data['msgSuccess'] = 'Berhasil mengirim email';
            }
        }
        $this->render('read');
    }

}
