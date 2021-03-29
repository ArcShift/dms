<?php

class Company extends MY_Controller {

    protected $module = "company";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company", "model");
        $this->load->model("m_place");
        $this->load->library('form_validation');
        $this->data['province'] = $this->m_place->province();
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

    function kota() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->m_place->city());
    }

    function delete() {
        $config['table'] = 'company';
        parent::hapus($config);
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
                    $this->load->model('m_log');
                    $this->m_log->update_company();
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

    function detail() {
        
    }

}
