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
                $id = $this->db->insert_id();
                $this->session->set_userdata('idData', $id);
                $this->load->model('m_log');
                $this->m_log->create_unit_kerja($id);
                redirect($this->module . '/edit');
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
        } elseif ($this->input->post('add')) {
            $this->db->set('id_unit_kerja', $this->session->idData);
            $this->db->set('name', $this->input->post('tugas'));
            $this->db->insert('jobdesk');
        } elseif ($this->input->post('editJD')) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->set('name', $this->input->post('nama'));
            $this->db->update('jobdesk');
        } elseif ($this->input->post('delete')) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('jobdesk');
        }
        if (isset($this->session->idData)) {
            $id = $this->session->idData;
        } else {
            redirect($this->module);
        }
        $this->data['data'] = $this->model->detail($id);
        $this->data['jobdesk'] = $this->model->jobdesk($id);
        $this->render('edit');
    }

    function delete() {
        $config['table'] = 'unit_kerja';
        parent::hapus($config);
    }

}
