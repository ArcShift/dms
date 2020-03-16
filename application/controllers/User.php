<?php

class User extends MY_Controller {

    protected $module = "user";

    function __construct() {
        parent::__construct();
        $this->load->model("m_user", "model");
        $this->load->library('form_validation');
        $this->data['role'] = $this->model->role();
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render("read");
    }

    function create() {
        $this->subTitle = 'Create';
        if ($this->input->post('tambah')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[users.name]');
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
        $this->subTitle = 'Delete';
        $post = $this->input->post();
        if ($post['initHapus']) {
            $this->data['data'] = $this->model->detail($post['initHapus']);
            $this->render('delete');
        } else if ($post['hapus']) {
            if ($this->model->delete($post['id'])) {
                $this->session->set_flashdata('msgSuccess', 'Data berhasil dihapus');
            } else {
                $this->session->set_flashdata('msgError', $this->db->error()['message']);
            }
            redirect($this->module);
        } else {
            redirect($this->module);
        }
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $this->data['data'] = $this->model->detail($this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            if ($this->input->post('nama')==$result['name']){
                $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[user.name]');
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
                "id"=> $this->input->post('id'),
                "name" => $this->input->post('nama'),
                "id_role"=> $this->input->post('role')
            ); 
                    
        } else {
            redirect($this->module);
        }
        $this->render('edit');
    }
    function updatePass() {
        
    }
    

}
