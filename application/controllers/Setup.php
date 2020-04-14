<?php

class Setup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_setup', 'model');
    }

    public function index() {
        $this->model->setup('role');
        $this->model->setup('module');
        $this->model->setup('users');
//        $this->model->setup('access');
        $this->model->setup('province');
        $this->model->setup('regency');
    }

    function access() {
        if ($this->model->access()) {
            die('success');
        } else {
            die('ERROR: ' . $this->db->error()['message']);
        }
    }

}
