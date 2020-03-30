<?php

class Account extends MY_Controller {

    protected $module = "account";

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_account', 'model');
    }

    function index() {
        $this->subTitle = 'Detail';
        if ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            if ($this->input->post('nama') == $result['name']) {
                $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[user.username]');
            }
            $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
            if ($this->form_validation->run() == FALSE) {
                if ($this->model->edit()) {
                    $this->data['msgSuccess'] = 'Data berhasil diubah';
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            }
        } elseif ($this->input->post('edit_pass')) {
            $this->form_validation->set_rules('old_pass', 'Password Lama', 'required|callback_check_pass');
            $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|differs[old_pass]');
            $this->form_validation->set_rules('re_pass', 'Ulange Password', 'required|matches[new_pass]');
            if ($this->form_validation->run()) {
                if ($this->model->change_pass()) {
                    $this->data['msgSuccess'] = 'Password berhasil diubah';
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            }
        }
        $this->data['data'] = $this->model->get();
        $this->render('detail');
    }

    function check_pass() {
        if ($this->model->checkPass()) {
            return true;
        } else {
            $this->form_validation->set_message('check_pass', '{field} tidak sama');
            return false;
        }
    }

    function logout() {
        $this->session->unset_userdata('user');
        redirect('login');
    }

}
