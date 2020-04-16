<?php

class Treeview_detail extends MY_Controller {

    protected $module = 'treeview_detail';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    function index() {//replace
        $this->load->model('m_company');
        $this->data['company'] = $this->m_company->get();
        $this->render('read');
    }
    function s() {
        $this->load->model('m_company');
        $this->data['company'] = $this->m_company->get();
        $this->render('read2');
    }

    function tabs() {
        $id= $this->input->get('id');
        if(empty($id)){
            die('NO ACCESS');
        }
        $data = $this->model->reads($id);
        foreach ($data as $k => $d) {
            $data2[$d['id']] = $d;
        }
        $this->data['data'] = $data;
        $this->render('tabs', TRUE, TRUE);
    }

    function standard() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->standard());
    }

    function get() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->reads($this->input->post('id')));
    }

    function pemenuhan($param) {
        $this->data['tab'] = 'pemenuhan';
        $this->render('tab');
    }

    function fulfillment() {
        $this->render('pemenuhan');
    }

    function pasal() {
        if (!$this->session->userdata('treeview')) {
            redirect('standard');
        }
        $this->subTitle = 'Detail';
        $this->data['treeview'] = $this->model->treeview();
        if ($this->input->post()) {
            $this->load->library('form_validation');
            if ($this->input->post('add')) {
                $this->model->create();
            } else if ($this->input->post('modify')) {
                $this->model->update();
            } else if ($this->input->post('remove')) {
                $this->model->delete();
            }
        }
        $this->data['list'] = json_encode($this->model->reads());
        $this->data['tab'] = 'pasal';
        $this->render('tab');
    }

    function schedule() {
        $this->data['tab'] = 'jadwal';
        $this->render('tab');
    }

    function implementation() {
        $this->data['tab'] = 'penerapan';
        $this->render('tab');
    }

}
