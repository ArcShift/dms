<?php

class Company extends MY_Controller {

    protected $module = "company";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company", "model");
        $this->load->library('form_validation');
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        if ($this->input->post('tambah')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->create()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil dibuat');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            } else {
                $this->session->set_flashdata('msgError', 'validation error');
            }
        }
        $this->render('create');
    }

    function delete() {
        $this->subTitle = 'Delete';
        if ($this->input->post('initHapus')) {
            $this->data['data'] = $this->model->detail($this->input->post('initHapus'));
            $this->render('delete');
        } else if ($this->input->post('hapus')) {
            if ($this->model->delete($this->input->post('id'))) {
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
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->update()) {
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

}
