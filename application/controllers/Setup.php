<?php

class Setup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_setup', 'model');
    }

    public function index() {
        //SETUP DEFAULT ACCESS ROLE
    }

    function core_table() {
        if ($this->model->core_table()) {
            die('success');
        } else {
            die('ERROR: ' . $this->db->error()['message']);
        }
    }

    function access() {
        if ($this->model->access()) {
            die('success');
        } else {
            die('ERROR: ' . $this->db->error()['message']);
        }
    }

}
