<?php

class Jadwal_gap_analisa extends MY_Controller {

    protected $module = 'jadwal_gap_analisa';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_personil');
        $this->load->model('m_gap_analisa', 'model');
        $this->data['personil']= $this->m_personil->get();
    }

    function index() {
        $this->data['menuStandard']= 'standard';
        if ($this->input->post('initEdit')) {
            $this->session->set_userdata('idData', $this->input->post('initEdit'));
            redirect($this->module . '/edit');
        }
        $this->subModule = 'read';
        $this->data['data'] = $this->model->get();
        $this->render('index');
    }

    function create() {
        if ($this->input->post('simpan')) {
            $this->model->create();
            $this->session->set_flashdata('msgSuccess', 'Berhasil menambahkan data');
            redirect($this->module);
        }
        $this->subTitle = 'Create';
        $this->render('create');
    }

    function edit() {
        if ($this->input->post('simpan')) {
            $this->model->edit();
            $this->model->updatePelaksana($this->session->idData);
            $this->session->set_flashdata('msgSuccess', 'Berhasil mengubah data');
            redirect($this->module);
        }
        $data = $this->model->get($this->session->idData);
        if (empty($data)) {
            $this->session->set_userdata('msgError', 'Data tidak ditemukan');
            redirect($module);
        }
        $this->data['data'] = $data;
        $this->render('edit');
    }

}
