<?php

class User extends MY_Controller {

    protected $module = "user";

    function __construct() {
        parent::__construct();
        $this->load->model("m_user", "model");
        $this->load->library('form_validation');
        $this->data['roles'] = $this->model->role();
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render("read");
    }

    function create() {
        $this->data['menuStandard'] = true;
        $this->subTitle = 'Create';
        $this->data['freePersonil'] = $this->model->freePersonil();
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
            $result = $this->model->detail($this->input->post('id'));
                if ($this->input->post('username') != $result['username']) {
                    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
                }
                $this->form_validation->set_rules('role', 'Role', 'required');
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
                    "username" => $this->input->post('username'),
                    "id_role" => $this->input->post('role')
                );
            } elseif ($this->input->post('editPass')) {
            $this->data['data'] = $this->model->detail($this->input->post('id'));
            $this->form_validation->set_rules('newPass', 'Password', 'required');
            $this->form_validation->set_rules('ulangi_pass', 'Username', 'required|matches[newPass]');
                if ($this->form_validation->run()) {
                    if ($this->model->gantiPassword()) {
                        $this->session->set_flashdata('msgSuccess', 'Password berhasil diubah');
                        redirect($this->module);
                    } else {
                        $this->session->set_flashdata('msgError', $this->db->error()['message']);
                    }
                }
            } else {
                redirect($this->module);
            }
        $this->render('edit');
    }

    function updatePass() {
        
    }

}
