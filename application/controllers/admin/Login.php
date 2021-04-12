<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_admin', 'model');
    }

    public function index() {
        if ($this->session->has_userdata('admin')) {
            redirect('admin/dashboard');
        } else if ($this->input->post('login')) {
            if ($this->model->login()) {
                $this->session->set_userdata('module', $this->model->access());
                if (!empty($this->session->activeCompany)) {
                    $this->load->model('M_dashboard', 'm_dashboard');
                    $this->session->set_userdata('activeStandard', $this->m_dashboard->getDefaultStandard($this->session->activeCompany['id']));
                }
                redirect('admin/dashboard');
            }
        }
        $this->load->view('login/colorlib1');
    }

}
