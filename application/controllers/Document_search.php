<?php

class Document_search extends MY_Controller {

    protected $module = "document_search";

    function __construct() {
        parent::__construct();
        $this->load->model("m_document", "model");
//        $this->load->library('form_validation');
//        $this->data['role'] = $this->model->role();
    }

    function index() {
//        $this->subTitle = 'List';
        $this->data['data'] = $this->model->search();
        $this->data['creator'] = $this->model->creator();
        $this->data['standar'] = $this->model->standar();
        $this->data['distribusi'] = $this->model->distribusi();
        $this->render('search');
    }

    function detail($id) {
        $this->subTitle = 'detail';
        $this->data['data']= $this->model->get($id);
        $this->render('detail');
    }

}