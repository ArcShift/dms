<?php

class Notif extends MY_Controller {

    protected $module = "notif";
    function __construct() {
        parent::__construct();
        $this->load->model('m_notif', 'model');
    }
    
    function index() {
        if($this->input->post('read_all')){
            $this->model->read_all();
        }
        $this->data['notif3'] = $this->model->get(30);
        $this->render('read');
    }

}
