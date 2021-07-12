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
        $this->data['perusahaan'] = $this->model->perusahaan();
        $this->data['data'] = $this->model->search();
        $this->data['last'] = $this->db->last_query();
        $this->render('read');
    }

    function detail($id) {
        $this->subTitle = 'detail';
        $this->data['data'] = $this->model->get($id);
        $this->access = 'read';
        $this->render('detail');
    }

    function personil() {
        $this->db->personil();
    }

    function company() {//AJAX
//        $data = $this->model->creator($this->input->get('id'));
        $data = $this->model->personil($this->input->get('id'));
        $id_uk = null;
        $sort = [];
        for ($i = 0; $i < count($data); $i++) {
            $d = $data[$i];
            if ($id_uk != $d['id_unit_kerja']) {
                $id_uk = $d['id_unit_kerja'];
                array_push($sort, ['type' => 'uk', 'id' => $id_uk, 'name' => $d['unit_kerja']]);
                $i--;
            } else {
                array_push($sort, ['type' => 'p', 'id' => $d['id'], 'name' => $d['fullname']]);
            }
        }
        echo json_encode($sort);
    }

    function get_pasal() {//AJAX
        $this->load->model('m_pasal');
        $data = $this->m_pasal->get(null, $this->input->get('id'));//TODO: fix pasal sort order
        echo json_encode($data);
    }

}
