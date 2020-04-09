<?php

class Company_standard extends MY_Controller {

    protected $module = "company_standard";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company_standard", "model");
        $this->load->model("m_company");
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
        } else {
            redirect($this->module);
        }
        $this->data['company'] = $this->m_company->detail($comp);
        $this->data['data'] = $this->model->standard($comp);
        $this->render('edit');
    }

}
