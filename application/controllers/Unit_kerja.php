<?php

class Unit_kerja extends MY_Controller {

    protected $module = "unit_kerja";

    function __construct() {
        parent::__construct();
        $this->load->model('m_unit_kerja', 'model');
        $this->data['company'] = $this->model->company();
        $this->load->library('form_validation');
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
            $this->session->set_userdata('idData', $this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->update()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            }
        }
        if (isset($this->session->idData)) {
            $id = $this->session->idData;
        } else {
            redirect($this->module);
        }
        $this->data['data'] = $this->model->detail($id);
        $this->render('edit');
    }

    function delete() {
        $config['table'] = 'unit_kerja';
        parent::hapus($config);
    }

}
