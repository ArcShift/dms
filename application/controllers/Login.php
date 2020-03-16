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
                $this->load->model('m_module');
                $this->session->set_userdata('menu', $this->m_module->read());
                redirect('dashboard');
            }
        }
        $this->load->view('login');
    }

    public function logout() {
        $this->session->unset_userdata('user');
        redirect('login');
    }

}
