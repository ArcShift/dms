<?php

class Management_hope extends MY_Controller {

    protected $module = "management_hope";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_management_hope', 'model');
    }

    public function index() {
        $this->data['menuStandard']= 'standard';
        $this->render('read');
    }

    function standard() {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
        $this->db->where('cs.id_company', $this->input->get('company'));
        $result = $this->db->get('standard s')->result_array();
        echo json_encode($result);
    }

    function pasal() {
        $this->db->select('p.*, h.persentase');
        $this->db->join('hope h', 'h.id_pasal = p.id AND h.id_company = ' . $this->session->activeCompany['id'], 'LEFT');
        $this->db->where('p.parent', null);
        $this->db->where('p.id_standard', $this->session->activeStandard['id']);
        $result = $this->db->get('pasal p')->result_array();
        echo json_encode($result);
    }

    function edit() {
        $post = $this->input->post();
        $this->db->where('id_company', $this->session->activeCompany['id']);
        $this->db->where('id_pasal', $post['id-pasal']);
        $result = $this->db->get('hope')->result_array();
        $this->db->set('persentase', $post['persentase']);
        if (empty($result)) {//INSERT
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('id_pasal', $post['id-pasal']);
            $this->db->insert('hope');
        } else {//UPDATE
            $this->db->where('id_company', $this->session->activeCompany['id']);
            $this->db->where('id_pasal', $post['id-pasal']);
            $this->db->update('hope');
        }
        echo 'success';
    }
}
