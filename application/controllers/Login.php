<?php

class Login extends MY_Core {

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

    function lupa_password() {
        $data = [];
        if ($this->input->post('kirim')) {
            $row = $this->db->get_where('users', ['email' => $this->input->post('email')])->row();
            if (empty($row)) {
                $data['msgError'] = 'Email tidak ditemukan';
            } else {
                $this->load->helper('main');
                $token = randomString(20);
                $this->db->set('token', $token);
                $this->db->where('id', $row->id);
                $this->db->update('users');
                $this->notif_mail($row->email, 'Reset Password', '<a href="' . site_url('login/reset_password/' . $token) . '">' . site_url('login/reset_password/' . $token) . '</a>');
                $data['msgSuccess'] = 'Link Pembaharuan password dikirim ke email';
            }
        }
        $this->load->view('login/lupa_pass', $data);
    }

    function reset_password($token) {
        $row = $this->db->get_where('users', ['token' => $token])->row();
        if (empty($row)) {
            $this->data['msgError'] = 'Token tidak valid';
            $this->data['invalidToken'] = true;
        } else if ($this->input->post('simpan')) {
            if ($this->input->post('pass_baru') !== $this->input->post('pass_ulang')) {
                $this->data['msgError'] = 'Password tidak sama';
            } else {
                $this->db->set('pass', md5($this->input->post('pass_baru')));
                $this->db->set('token', NULL);
                $this->db->where('id', $row->id);
                $this->db->update('users');
                $this->session->set_flashdata('msgSuccess', 'Password berhasil diubah');
                redirect($this->module);
            }
        }
        $this->render('login/reset_pass');
    }

}
