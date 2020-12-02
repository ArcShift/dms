<?php

class Dashboard extends MY_Controller {

    protected $module = "dashboard";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_dashboard', 'model');
    }

    public function index() {
        $this->data['box'] = array(
            array('name' => 'company', 'title' => 'Perusahaan', 'color' => 'mixed-hopes', 'value' => $this->model->count('company')),
            array('name' => 'user', 'title' => 'Pengguna', 'color' => 'night-fade', 'value' => $this->model->count('users')),
            array('name' => 'income', 'title' => 'Pemasukan', 'color' => 'happy-itmeo', 'value' => 'Rp. -'),
            array('name' => 'standard', 'title' => 'Standar', 'color' => 'sunny-morning', 'value' => $this->model->count('standard')),
            array('name' => 'standard_aktif', 'title' => 'Standar Aktif', 'color' => 'arielle-smile', 'value' => $this->model->standard_active()),
            array('name' => 'program_selesai', 'title' => 'Program Selesai', 'color' => 'grow-early', 'value' => '-'),
            array('name' => 'terlambat', 'title' => 'Terlambat','subtitle'=>'Dokumen Belum Diupload', 'color' => 'warm-flame', 'value' => $this->model->terlambat()),
            array('name' => 'diterapkan', 'title' => 'Diterapkan', 'subtitle'=>'Dokumen Sudah Diupload','color' => 'happy-green', 'value' => '-'),
            array('name' => 'progress', 'title' => 'Progress','subtitle'=>'Pemenuhan Total', 'color' => 'malibu-beach', 'value' => '- %'),
        );
        $this->render('read');
    }

}
