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
            if ($admin = $this->model->login($this->input->post('user'), md5($this->input->post('password')))) {
                $this->session->set_userdata('admin', $admin);
//                if (!empty($this->session->activeCompany)) {
//                    $this->load->model('M_dashboard', 'm_dashboard');
//                    $this->session->set_userdata('activeStandard', $this->m_dashboard->getDefaultStandard($this->session->activeCompany['id']));
//                }
                redirect('admin/dashboard');
            }else{
                die($this->db->last_query());
            }
        }
        $this->load->view('login/colorlib1');
    }

}
