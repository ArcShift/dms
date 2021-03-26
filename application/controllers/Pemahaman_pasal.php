<?php

class Pemahaman_pasal extends MY_Controller {

    protected $module = "pemahaman_pasal";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal', 'model');
    }

    function index() {
        if ($this->input->get('detail')) {
            $this->session->set_userdata('idData', $this->input->get('detail'));
            redirect($this->module.'/detail');
        }
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['pasal'] = $this->model->get();
        $this->render('index');
    }

    function detail() {
        $this->subModule = 'read';
        $this->subTitle = 'Detail';
        $this->data['pasal']= $this->model->detail($this->session->idData);
        $this->render('detail');
    }

    function document() {
        $result = $this->model->getDocument($this->input->get('id'));
        echo json_encode($result);
    }

}
