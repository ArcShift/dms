<?php

class Document_search extends MY_Controller {

    protected $module = "document_search";

    function __construct() {
        parent::__construct();
        $this->load->model("m_document", "model");
    }

    function index() {
//        $this->subTitle = 'List';
        $this->data['data'] = $this->model->search();
        $this->data['creator'] = $this->model->creator();
        $this->data['perusahaan'] = $this->model->perusahaan();
        $this->data['standar'] = $this->model->standar();
        $this->data['unit_kerja_distribusi'] = $this->model->unit_kerja_distribusi();
        $this->data['distribusi'] = $this->model->distribusi($this->input->get('unit_kerja_distribusi'));
        $this->render('search');
    }

    function detail($id) {
        $this->subTitle = 'detail';
        $this->data['data']= $this->model->get($id);
        $this->render('detail');
    }

}
