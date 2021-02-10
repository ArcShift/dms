<?php

class Personil extends MY_Controller {

    protected $module = "personil";

    function __construct() {
        parent::__construct();
        $this->load->model('m_personil', 'model');
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
            $this->data['data'] = $this->model->detail($this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
//            $this->form_validation->set_rules('id_unit_kerja', 'Unit Kerja', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->updateData()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            } else {
                die(validation_errors());
            }
            $this->data['data'] = $this->input->post();
        } elseif ($this->input->post('delete')) {
            $this->model->delete_unit_kerja();
            $this->data['data'] = $this->model->detail($this->input->post('id_personil'));
        } elseif ($this->input->post('add')) {
                $this->model->add_unit_kerja();
//            $this->data['data'] = $this->model->detail($this->input->post('id_personil'));
        } 
//        else {
//            redirect($this->module);
//        }
        $this->data['data'] = $this->model->detail($this->session->idData);
//            die($this->db->last_query());
//            die(print_r($this->data['data']));
//        $this->data['uk'] = $this->model->unit_kerja($this->data['data']['id_company']);
//        die(print_r($this->data['data']));
//        die(print_r($this->data['uk']));
        $this->render('edit');
    }

    function delete() {
        $config['table'] = 'personil';
        $config['field'] = 'fullname';
        parent::hapus($config);
    }

    function unit_kerja() {
        echo json_encode($this->model->unit_kerja($this->input->post('id')));
    }

}
