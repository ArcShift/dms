<?php

class Pengaturan extends MY_Controller {

    protected $module = 'pengaturan';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_setting', 'model');
    }

    function index() {
        if ($this->input->post('update_smtp')) {
            if ($this->input->post('host')) {
                $this->model->set('host', $this->input->post('host'));
            }
            if ($this->input->post('username')) {
                $this->model->set('username', $this->input->post('username'));
            }
            if ($this->input->post('password')) {
                $this->model->set('password', $this->input->post('password'));
            }
            $this->data['msgSuccess'] = 'Data berhasil diubah';
        }
        $this->render('read');
    }

}