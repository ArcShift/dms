<?php

class Akun extends MY_User {

    function index() {
        $this->load->library('form_validation');
        $this->load->model('m_account', 'model');
        if ($this->input->post('edit')) {
            $result = $this->model->detail($this->session->user['id']);
            if ($this->input->post('username') != $result['username']) {
                $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            }
            $this->form_validation->set_rules('email', 'E-Mail', 'valid_email');
//            $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
            if ($this->form_validation->run() != FALSE) {
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
        } elseif ($this->input->post('edit_foto')) {
            $config['upload_path'] = './upload/profile_photo';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100000;
            $config['max_width'] = 2000;
            $config['max_height'] = 2000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                if ($this->model->update_foto()) {
                    $this->data['msgSuccess'] = 'Foto berhasil diubah';
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            } else {
                $this->data['msgError'] = $this->upload->display_errors();
            }
        }
        $this->data['data'] = $this->model->get();
        $this->render('akun');
    }
    function logout() {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
