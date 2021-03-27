<?php

class Bukti_pasal extends MY_Controller {
    protected $module = "bukti_pasal";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal', 'model');
    }

    function index() {
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['pasal'] = $this->model->get();
        $this->render('index');
    }
}

