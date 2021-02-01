<?php

class Dashboard extends MY_Controller {

    protected $module = "dashboard";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_dashboard', 'model');
    }

    function index() {
        if ($this->input->get('company')) {//select company
            $this->db->where('id', $this->input->get('company'));
            $activeCompany = $this->db->get('company')->row_array();
            $this->session->set_userdata('activeCompany', $activeCompany);
            $this->session->set_userdata('activeStandard', $this->model->getDefaultStandard($this->input->get('company')));
            redirect();
        } else if ($this->input->get('standard')) {//select standard
            $this->db->where('id', $this->input->get('standard'));
            $activeStandard = $this->db->get('standard')->row_array();
            $this->session->set_userdata('activeStandard', $activeStandard);
            redirect();
        }
        $company = $this->session->activeCompany;
        $standard = $this->session->activeStandard;
        $periode_tugas = 'hari';
        if ($this->input->get('periode_tugas')) {
            $periode_tugas = $this->input->get('periode_tugas');
        }
        $this->data['periode_tugas']= $periode_tugas;
        if (!empty($company)) {
            $this->data['companies'] = $this->db->get('company')->result_array();
            $this->data['company_standard'] = $this->model->company_standard($company['id']);
            if (!empty($standard)) {
                $this->load->model('M_treeview_detail', 'm_treeview');
                $pemenuhan = $this->m_treeview->getPemenuhan($company['id'], $standard['id']);
                $parentPemenuhan = [];
                $pemenuhanDoc = [];
                foreach ($pemenuhan as $k => $p) {
                    if ($p['parent'] == null) {
                        array_push($parentPemenuhan, $p);
                    }
                }
                $this->data['pemenuhan'] = json_encode($parentPemenuhan);
                $this->load->model('M_implementasi', 'm_imp');
                $this->data['progressImp'] = json_encode($this->m_imp->progress($company['id'], $standard['id']));
                $this->data['distribusi'] = $this->model->distribusi($company['id'], $standard['id']);
//                $this->data['taskPersonil']= 
                $this->db->where('uk.id_company', $company['id']);
                $this->data['countUnitKerja']= $this->db->count_all_results('unit_kerja uk');
                $this->db->where('uk.id_company', $company['id']);
                $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
                $this->data['countPersonil']= $this->db->count_all_results('personil p');
                $this->data['listTugas']= $this->model->listTugas($company['id'], $standard['id'], $periode_tugas);
            }
            $this->db->where('id_company', $company['id']);
        }
        $this->render('detail');
    }

}
