<?php

class Module extends MY_Controller {

    protected $title = "Module Control";

    public function __construct() {
        parent::__construct();
        $this->load->model("m_module", "model");
    }

    public function index() {
        $this->data['data1'] = $this->model->read();
        $this->render('module');
    }

    public function create() {
        echo $this->model->create();
    }

    public function delete() {
        echo $this->model->delete();
    }

    public function getList() {
        echo json_encode($this->model->read());
    }

}
