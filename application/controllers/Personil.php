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
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
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
        } elseif ($this->input->post('delete')) {
            $this->model->delete_unit_kerja();
        } elseif ($this->input->post('add')) {
            $this->model->add_unit_kerja();
        }
        $this->data['data'] = $this->model->detail($this->session->idData);
        $this->render('edit');
    }

    function delete() {
        $this->subTitle = 'Hapus';
        if ($this->input->post('initHapus')) {
            $this->session->set_userdata('delete', $this->input->post('initHapus'));
        } else if ($this->input->post('hapus')) {
            $data = $this->model->detail($this->session->delete);
            foreach ($data['unit_kerja'] as $uk){
                $this->db->set('pembuat', 'NULL', false);
                $this->db->where('pembuat', $uk['id_position_personil']);
                $this->db->update('document');
                $this->db->where('id_position_personil', $uk['id_position_personil']);
                $this->db->delete('distribution');
                $this->db->where('id_position_personil', $uk['id_position_personil']);
                $this->db->delete('personil_task');
            }
            $this->db->where('id_personil', $this->input->post('id'));
            $this->db->delete('position_personil');
            $this->db->where('id_personil', $this->input->post('id'));
            $this->db->delete('user');
            $this->db->where('id', $this->input->post('id'));
            if ($this->db->delete('personil')) {
                redirect($this->module);
            }
        }
        $id = $this->session->delete;
        $this->data['data'] = $this->model->detail($id);

        $this->render('delete');
    }

    function unit_kerja() {
        echo json_encode($this->model->unit_kerja($this->input->post('id')));
    }

}
