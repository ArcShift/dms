<?php

class Company_standard extends MY_Controller {

    protected $module = "company_standard";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company_standard", "model");
        $this->load->model("m_company");
//        $this->load->library('form_validation');
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->company();
        $this->render('read');
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $comp = $this->input->post('initEdit');
        } elseif ($this->input->post('toggle')) {
            $comp = $this->input->post('perusahaan');
            if ($this->model->toggle()) {
                
            } else {
                $this->session->set_flashdata('msgError', $this->db->error()['message']);
            }
//            $result = $this->model->detail($this->input->post('edit'));
//            $this->form_validation->set_rules('nama', 'Nama', 'required');
//            if ($this->form_validation->run()) {
//                if ($this->model->update()) {
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
        $this->data['company'] = $this->m_company->detail($comp);
        $this->data['data'] = $this->model->standard($comp);
        $this->render('edit');
    }

}
