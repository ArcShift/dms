<?php

class Unit_kerja extends MY_Controller {

    protected $module = "unit_kerja";

    function __construct() {
        parent::__construct();
        $this->load->model('m_unit_kerja', 'model');
        $this->data['company'] = $this->model->company();
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        $this->subTitle = 'Create';
        if ($this->input->post('buat')) {
            if ($this->model->create()) {
                redirect($this->module);
            } else {
                //SHOW ERROR
            }
        }
        $this->data['data'] = $this->model->read();
        $this->render('create');
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $this->data['data'] = $this->model->detail($this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
//            if ($this->input->post('nama') == $result['username']) {
//                $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[user.username]');
//            }
//                $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
////            $this->form_validation->set_rules('role', 'Role', 'required');
//            if ($this->form_validation->run()) {
//                if ($this->model->updateData()) {
//                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
//                    redirect($this->module);
//                } else {
//                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
//                }
//            }
//            $this->data['data'] = array(
//                "id" => $this->input->post('id'),
//                "name" => $this->input->post('nama'),
//                "id_role" => $this->input->post('role')
//            );
        } else {
            redirect($this->module);
        }
        $this->render('edit');
    }

    function delete() {
        $config['table'] = 'unit_kerja';
        parent::hapus($config);
    }

}
