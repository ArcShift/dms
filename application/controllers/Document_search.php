<?php

class Document_search extends MY_Controller {

    protected $module = "document_search";

    function __construct() {
        parent::__construct();
        $this->load->model("m_document", "model");
    }

    function index() {
        $this->subTitle = 'Search';
        $this->data['standar'] = $this->model->standar();
        if ($this->input->get('standar')) {
            $this->data['pasal'] = $this->model->pasal($this->input->get('standar'));
        }
        $this->data['perusahaan'] = $this->model->perusahaan();
        if ($this->input->get('perusahaan')) {
            $this->data['creator'] = $this->model->creator($this->input->get('perusahaan'));
        }
        $this->data['data'] = $this->model->search();
        $this->render('search');
    }

    function detail($id) {
        $this->subTitle = 'detail';
        $this->data['data'] = $this->model->get($id);
        $this->render('detail');
    }

}
