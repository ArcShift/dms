<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->has_userdata('user')) {
            redirect('dashboard');
        } else if ($this->input->post('login')) {
            $this->load->model('m_login', 'model');
            if ($this->model->login()) {
                $this->session->set_userdata('module', $this->model->access());
                redirect('dashboard');
            }
        }
        $this->load->view('login');
    }

}
