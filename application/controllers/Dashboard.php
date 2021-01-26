<?php

class Dashboard extends MY_Controller {

    protected $module = "dashboard";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_dashboard', 'model');
    }

//    public function detail() {
//        if (empty($this->session->user['id_company'])) {
//            $users = $this->model->count('users');
//        } else {
//            $users = $this->model->count_user_company();
//        }
//        $this->data['box'] = array(
//            array('company' => 'N', 'name' => 'company', 'title' => 'Perusahaan', 'color' => 'mixed-hopes', 'icon' => 'building', 'value' => $this->model->count('company')),
//            array('company' => 'Y', 'name' => 'user', 'title' => 'Pengguna', 'color' => 'night-fade', 'icon' => 'building', 'value' => $users),
//            array('company' => 'Y', 'name' => 'personil', 'title' => 'Personil', 'color' => 'happy-itmeo', 'icon' => 'building', 'value' => $this->model->count('personil')),
//            array('company' => 'N', 'name' => 'unit_kerja', 'title' => 'Unit Kerja', 'color' => 'malibu-beach', 'icon' => 'building', 'value' => $this->model->count('unit_kerja')),
//            array('company' => 'N', 'name' => 'standard', 'title' => 'Standar', 'color' => 'sunny-morning', 'icon' => 'building', 'value' => $this->model->count('standard')),
//            array('company' => 'Y', 'name' => 'standard_aktif', 'title' => 'Standar Aktif', 'color' => 'arielle-smile', 'icon' => 'building', 'value' => $this->model->standard_active()),
//            array('company' => 'N', 'name' => 'program_selesai', 'title' => 'Program Selesai', 'color' => 'grow-early', 'icon' => 'building', 'value' => '-'),
//            array('company' => 'Y', 'name' => 'terlambat', 'title' => 'Terlambat', 'subtitle' => 'Dokumen Belum Diupload', 'color' => 'warm-flame', 'icon' => 'building', 'value' => $this->model->terlambat()),
//            array('company' => 'Y', 'name' => 'diterapkan', 'title' => 'Diterapkan', 'subtitle' => 'Dokumen Sudah Diupload', 'color' => 'happy-green', 'icon' => 'building', 'value' => '-'),
////            array('company' => 'N', 'name' => 'income', 'title' => 'Pemasukan', 'color' => 'happy-itmeo', 'icon' => 'building', 'value' => 'Rp. -'),
////            array('company' => 'Y', 'name' => 'progress', 'title' => 'Progress', 'subtitle' => 'Pemenuhan Total', 'color' => 'malibu-beach', 'icon' => 'building', 'value' => '- %'),
//                //==
//        );
//        $company = $this->db->get('company')->result_array();
//        foreach ($company as $k => $c) {
//            $company[$k]['standard'] = $this->model->company_standard($c['id']);
//        }
//        $this->data['company'] = $company;
//        $this->render('read');
//    }

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
            }
        }
        $this->render('detail');
    }

//    function standard() {
//        $this->db->where('id', $this->input->get('company'));
//        $company = $this->db->get('company')->row_array();
//        $this->session->set_userdata('activeCompany', $company);
//        $this->db->select('s.*');
//        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
//        $this->db->where('cs.id_company', $this->input->get('company'));
//        $result = $this->db->get('standard s')->result_array();
//        echo json_encode($result);
//    }
//
//    function set_standard() {
//        $this->db->where($this->input->get('standard'));
//        $standard = $this->db->get('standard')->row_array();
//        $this->session->set_userdata('activeStandard', $standard);
//        redirect('dashboard');
//    }
//
//    function grafik() {
//        echo json_encode($this->model->grafik_pasal());
//    }

}
