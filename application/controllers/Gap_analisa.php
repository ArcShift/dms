<?php

class Gap_analisa extends MY_Controller {

    protected $module = 'gap_analisa';

    function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
    }

    function index() {
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->data['data'] = $this->m_pasal->get();
        $this->render('index');
    }

}
