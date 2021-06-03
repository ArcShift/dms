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
        } else if ($this->input->get('periode_tugas')) {//select standard
            $this->session->set_userdata('periode_tugas', $this->input->get('periode_tugas'));
            $periode_tugas = $this->input->get('periode_tugas');
            redirect();
        }
        $periode_tugas = isset($this->session->periode_tugas) ? $this->session->periode_tugas : 'hari';
        $company = $this->session->activeCompany;
        $standard = $this->session->activeStandard;
        $this->data['periode_tugas'] = $periode_tugas;
        $this->data['menuStandard'] = 'standard';
        if (!empty($company)) {
            $this->data['companies'] = $this->db->get('company')->result_array();
//            $this->data['company_standard'] = $this->model->company_standard($company['id']);
            $this->load->model('m_unit_kerja');
            $this->data['unit_kerja'] = $this->m_unit_kerja->get();
            if (!empty($standard)) {
                $this->load->model('M_implementasi', 'm_imp');
                $this->data['progressImp'] = json_encode($this->m_imp->progress($company['id'], $standard['id']));
                $this->data['distribusi2'] = $this->model->distribusi2($company['id'], $standard['id']);
                $this->db->where('uk.id_company', $company['id']);
                $this->data['countUnitKerja'] = $this->db->count_all_results('unit_kerja uk');
                $this->db->where('id_company', $company['id']);
                $this->data['countPersonil'] = $this->db->count_all_results('personil');
                $this->data['listTugas'] = $this->model->listTugas($company['id'], $standard['id'], $periode_tugas);
            }
        }
        $this->render('read');
    }

    function switch_company() {
        if (empty($this->session->user['id_company'])) {
            if ($this->input->get('company')) {
                $this->db->where('id', $this->input->get('company'));
                $activeCompany = $this->db->get('company')->row_array();
                $this->session->set_userdata('activeCompany', $activeCompany);
                $this->session->set_userdata('activeStandard', $this->model->getDefaultStandard($this->input->get('company')));
                echo 'success';
            }
        }
    }

    function switch_standard() {
        if ($this->input->get('standard')) {
            $this->db->select('s.*, cs.id AS id_company_standard');
            $this->db->join('company_standard cs', 'cs.id_standard = s.id');
            $this->db->where('cs.id', $this->input->get('standard'));
            $activeStandard = $this->db->get('standard s')->row_array();
            $this->session->set_userdata('activeStandard', $activeStandard);
            echo 'success';
        }
    }

    function get_pemenuhan() {
        $this->load->model('M_treeview_detail', 'm_treeview');
        $pemenuhan = $this->model->getPemenuhan($this->session->activeCompany['id'], $this->session->activeStandard['id'], $this->input->get('unit_kerja'), $this->input->get('personil'));
        $parentPemenuhan = [];
        $pemenuhanDoc = [];
        foreach ($pemenuhan as $k => $p) {
            if ($p['parent'] == null) {
                if ($this->input->get('unit_kerja') | $this->input->get('personil')) {
                    if ($p['pemenuhanDoc'] != 0) {
                        array_push($parentPemenuhan, $p);
                    }
                } else {
                    array_push($parentPemenuhan, $p);
                }
            }
        }
        echo json_encode($parentPemenuhan);
//        echo json_encode($pemenuhan);
    }

    function get_personil() {
        $this->db->select('pp.id, p.fullname');
        $this->db->join('position_personil pp', 'pp.id_personil = p.id AND pp.id_unit_kerja =' . $this->input->get('unit_kerja'));
        $personil = $this->db->get('personil p')->result();
        echo json_encode($personil);
    }

}
