<?php

class Management_hope extends MY_Controller {

    protected $module = "management_hope";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_management_hope', 'model');
    }

    public function index() {
        $this->render('read');
    }

}
