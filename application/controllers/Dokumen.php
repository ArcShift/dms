<?php

class Dokumen extends MY_Controller {

    protected $module = "dokumen";

    function __construct() {
        parent::__construct();
//        $this->load->model("m_company", "model");
        $this->load->model("m_pasal");
    }

    function index() {
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $v) {
            $this->db->join('document_pasal dp', 'dp.id_document = d.id');
            $this->db->join('pasal p', 'p.id = dp.id_pasal');
            $this->db->where('p.id', $v['id']);
            $pasal[$k]['document'] = $this->db->get('document d')->result_array();
        }
        $this->data['pasal'] = $pasal;
        $this->render('index');
    }

    function get() {
        $this->load->model("m_document");
        echo json_encode($this->m_document->get_by_standard($this->session->activeCompany['id'], $this->session->activeStandard['id']));
    }

}
