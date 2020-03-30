<?php

class User extends MY_Controller {

    protected $module = "user";

    function __construct() {
        parent::__construct();
        $this->load->model("m_user", "model");
        $this->load->library('form_validation');
        $this->data['role'] = $this->model->role();
        $this->data['company'] = $this->model->company();
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render("read");
    }

    function create() {
        $this->subTitle = 'Create';
        if ($this->input->post('tambah')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[users.username]');
            //TODO: if role ... => company & role unrequired
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('pass', 'Password', 'required');
            $this->form_validation->set_rules('ulangi_pass', 'Ulangi Password', 'required|matches[pass]'); //repeat
            if ($this->form_validation->run()) {
                if ($this->model->create()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil dibuat');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            }
        }
        $this->render('create');
    }

    function delete() {
        $config['table'] = 'users';
        $config['field'] = 'username';
        parent::hapus($config);
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $this->data['data'] = $this->model->detail($this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            if ($this->input->post('nama') == $result['name']) {
                $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[user.username]');
            }
                $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
//            $this->form_validation->set_rules('role', 'Role', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->updateData()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            }
            $this->data['data'] = array(
                "id" => $this->input->post('id'),
                "name" => $this->input->post('nama'),
                "id_role" => $this->input->post('role')
            );
        } else {
            redirect($this->module);
        }
        $this->render('edit');
    }

    function unit_kerja() {
        echo json_encode($this->model->unit_kerja());
    }

    function updatePass() {
        
    }

}
