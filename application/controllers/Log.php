<?php

class Log extends MY_Controller {

    protected $module = "log";

    function __construct() {
        parent::__construct();
        $this->load->model('m_log', 'model');
    }

    function index() {
        $this->data['log'] = $this->model->get();
        $this->render('read');
    }

}
