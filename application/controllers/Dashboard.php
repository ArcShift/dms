<?php

class Dashboard extends MY_Controller {

    protected $module = "dashboard";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_dashboard', 'model');
    }

    public function index() {
        if (empty($this->session->user['id_company'])) {
            $users = $this->model->count('users');
        } else {
            $users = $this->model->count_user_company();
        }
        $this->data['box'] = array(
            array('company' => 'N', 'name' => 'company', 'title' => 'Perusahaan', 'color' => 'mixed-hopes', 'icon' => 'building', 'value' => $this->model->count('company')),
            array('company' => 'Y', 'name' => 'user', 'title' => 'Pengguna', 'color' => 'night-fade', 'icon' => 'building', 'value' => $users),
            array('company' => 'Y', 'name' => 'personil', 'title' => 'Personil', 'color' => 'happy-itmeo', 'icon' => 'building', 'value' => $this->model->count('personil')),
            array('company' => 'N', 'name' => 'unit_kerja', 'title' => 'Unit Kerja', 'color' => 'malibu-beach', 'icon' => 'building', 'value' => $this->model->count('unit_kerja')),
            array('company' => 'N', 'name' => 'standard', 'title' => 'Standar', 'color' => 'sunny-morning', 'icon' => 'building', 'value' => $this->model->count('standard')),
            array('company' => 'Y', 'name' => 'standard_aktif', 'title' => 'Standar Aktif', 'color' => 'arielle-smile', 'icon' => 'building', 'value' => $this->model->standard_active()),
            array('company' => 'N', 'name' => 'program_selesai', 'title' => 'Program Selesai', 'color' => 'grow-early', 'icon' => 'building', 'value' => '-'),
            array('company' => 'Y', 'name' => 'terlambat', 'title' => 'Terlambat', 'subtitle' => 'Dokumen Belum Diupload', 'color' => 'warm-flame', 'icon' => 'building', 'value' => $this->model->terlambat()),
            array('company' => 'Y', 'name' => 'diterapkan', 'title' => 'Diterapkan', 'subtitle' => 'Dokumen Sudah Diupload', 'color' => 'happy-green', 'icon' => 'building', 'value' => '-'),
//            array('company' => 'N', 'name' => 'income', 'title' => 'Pemasukan', 'color' => 'happy-itmeo', 'icon' => 'building', 'value' => 'Rp. -'),
//            array('company' => 'Y', 'name' => 'progress', 'title' => 'Progress', 'subtitle' => 'Pemenuhan Total', 'color' => 'malibu-beach', 'icon' => 'building', 'value' => '- %'),
            //==
        );
        $company = $this->db->get('company')->result_array();
        foreach ($company as $k => $c) {
            $company[$k]['standard'] = $this->model->company_standard($c['id']);
        }
        $this->data['company'] = $company;
        $this->render('read');
    }

    function standard() {
     $this->db->select('s.*');
     $this->db->join('company_standard cs', 'cs.id_standard = s.id');
     $this->db->where('cs.id_company', $this->input->get('company'));
     $result=$this->db->get('standard s')->result_array();
     echo json_encode($result);
    }
    function grafik() {
        echo json_encode($this->model->grafik_pasal());
    }

}
