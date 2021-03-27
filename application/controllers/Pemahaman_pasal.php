<?php

class Pemahaman_pasal extends MY_Controller {

    protected $module = "pemahaman_pasal";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal', 'model');
    }

    function index() {
        if ($this->input->get('edit')) {
            $this->session->set_userdata('idData', $this->input->get('edit'));
            redirect($this->module . '/edit');
        }
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['pasal'] = $this->model->get();
        $this->render('index');
    }

    function document() {
        $result = $this->model->getDocument($this->input->get('id'));
        echo json_encode($result);
    }

    function edit() {
        if ($this->input->post('edit')) {
            if ($this->model->update2()) {
                $this->data['msgSuccess'] = 'Data berhasil diubah';
            }
        }
        $this->subTitle = 'Edit';
        $this->data['pasal'] = $this->model->detail($this->session->idData);
        $this->render('edit');
    }

}
