<?php

class Deskripsi_pasal extends MY_Controller{
    protected $module = "deskripsi_pasal";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal', 'model');
    }

    function index() {
        if ($this->input->get('edit')) {
            $this->session->set_userdata('idData', $this->input->get('edit'));
            redirect('pemahaman_pasal/edit');
        }
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['pasal'] = $this->model->get();
        $this->render('index');
    }
}
