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
                $this->session->set_userdata('activeStandards', $this->db->get('standard')->row_array());
                if (!empty($this->session->activeCompany)) {
                    $this->load->model('M_dashboard', 'm_dashboard');
                    $this->session->set_userdata('activeStandard', $this->m_dashboard->getDefaultStandard($this->session->activeCompany['id']));
                }
                switch ($this->session->user['role']) {
                    case 'anggota':
                        redirect('users');
                        break;
                    default:
                        redirect('dashboard');
                        break;
                }
            }
        }
//        $this->load->view('login/admin-lte');
        $this->load->view('login/colorlib1');
    }

}
