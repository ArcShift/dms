<?php

class Unit_kerja extends MY_Controller {

    protected $module = "unit_kerja";

    function __construct() {
        parent::__construct();
        $this->load->model('m_unit_kerja', 'model');
        $this->data['company'] = $this->model->company();
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        $this->subTitle = 'Create';
        if ($this->input->post('buat')) {
            if ($this->model->create()) {
                redirect($this->module);
            } else {
                //SHOW ERROR
            }
        }
        $this->data['data'] = $this->model->read();
        $this->render('create');
    }

    function delete() {
        $config['table'] = 'unit_kerja';
        parent::hapus($config);
    }

}
