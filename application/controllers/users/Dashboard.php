<?php

class Dashboard extends MY_User {

    function index() {
        $this->load->model('m_dashboard', 'model');
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
        $this->data['menuStandard'] = true;
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
                $this->data['distribusi2'] = $this->model->distribusi2($company['id'], $standard['id']);
                $this->db->where('uk.id_company', $company['id']);
                $this->data['countUnitKerja'] = $this->db->count_all_results('unit_kerja uk');
                $this->db->where('id_company', $company['id']);
                $this->data['countPersonil'] = $this->db->count_all_results('personil');
                $this->data['listTugas'] = $this->model->listTugas($company['id'], $standard['id'], $periode_tugas);
                $this->load->model('m_jadwal');
                $this->data['listJadwal'] = $this->m_jadwal->jadwal_saya();
            }
        }
        $this->render('dashboard');
    }

    function switch_standard() {
        if ($this->input->get('standard')) {
            $this->db->select('s.*');
            $this->db->join('company_standard cs', 'cs.id_standard = s.id');
            $this->db->where('cs.id', $this->input->get('standard'));
            $activeStandard = $this->db->get('standard s')->row_array();
            $this->session->set_userdata('activeStandard', $activeStandard);
            echo 'success';
        }
    }

}
