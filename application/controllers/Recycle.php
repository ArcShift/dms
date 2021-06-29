<?php

class Recycle extends MY_Controller {

    protected $module = "recycle";

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->subModule = 'read';
        $data = [//name,folder, table, field
            ['name' => 'Implementasi', 'folder' => 'implementasi', 'table' => 'jadwal', 'field' => 'path'],
            ['name' => 'Dokumen', 'folder' => 'dokumen', 'table' => 'document', 'field' => 'file'],
            ['name' => 'Foto Profil', 'folder' => 'profile_photo', 'table' => 'users', 'field' => 'photo'],
            ['name' => 'Gap Analisa', 'folder' => 'gap_analisa', 'table' => 'bukti_gap_analisa', 'field' => 'path'],
            ['name' => 'Perbaikan Gap Analisa', 'folder' => 'rev_gap_analisa', 'table' => 'bukti_perbaikan_gap_analisa', 'field' => 'path'],
            ['name' => 'Timeline: Training Awareness', 'folder' => 'training_awareness', 'table' => 'company_standard', 'field' => 'training_awareness_path'],
            ['name' => 'Timeline: Training Internal', 'folder' => 'training_internal', 'table' => 'company_standard', 'field' => 'training_internal_path'],
            ['name' => 'Timeline: Submit Dokumen', 'folder' => 'submit_dokumen', 'table' => 'company_standard', 'field' => 'submit_dokumen_path'],
            ['name' => 'Timeline: Pentest', 'folder' => 'pentest', 'table' => 'company_standard', 'field' => 'pentest_path'],
            ['name' => 'Timeline: BCP', 'folder' => 'bcp', 'table' => 'company_standard', 'field' => 'bcp_path'],
            ['name' => 'Timeline: Jadwal Audit Stage 1', 'folder' => 'jadwal_audit', 'table' => 'company_standard', 'field' => 'jadwal_audit_path'],
            ['name' => 'Timeline: Audit Plan Stage 1', 'folder' => 'audit_plan', 'table' => 'company_standard', 'field' => 'audit_plan_path'],
            ['name' => 'Timeline: Foto Audit Stage 1', 'folder' => 'foto_audit', 'table' => 'company_standard', 'field' => 'foto_audit_path'],
            ['name' => 'Timeline: Temuan Audit Stage 1', 'folder' => 'temuan_audit', 'table' => 'company_standard', 'field' => 'temuan_audit_path'],
            ['name' => 'Timeline: Hasil Perbaikan Audit Stage 1', 'folder' => 'hasil_perbaikan_audit', 'table' => 'company_standard', 'field' => 'hasil_perbaikan_audit_path'],
            ['name' => 'Timeline: Jadwal Audit Stage 2', 'folder' => 'jadwal_audit2', 'table' => 'company_standard', 'field' => 'jadwal_audit2_path'],
            ['name' => 'Timeline: Audit Plan Stage 2', 'folder' => 'audit_plan2', 'table' => 'company_standard', 'field' => 'audit_plan2_path'],
            ['name' => 'Timeline: Foto Audit Stage 2', 'folder' => 'foto_audit2', 'table' => 'company_standard', 'field' => 'foto_audit2_path'],
            ['name' => 'Timeline: Temuan Audit Stage 2', 'folder' => 'temuan_audit2', 'table' => 'company_standard', 'field' => 'temuan_audit2_path'],
            ['name' => 'Timeline: Hasil Perbaikan Audit Stage 2', 'folder' => 'hasil_perbaikan_audit2', 'table' => 'company_standard', 'field' => 'hasil_perbaikan_audit2_path'],
//            ['name' => '', 'folder' => '', 'table' => '', 'field' => ''],
//            ['name' => '', 'folder' => '', 'table' => '', 'field' => ''],
//            ['name' => '', 'folder' => '', 'table' => '', 'field' => ''],
//            ['name' => '', 'folder' => '', 'table' => '', 'field' => ''],
//            ['name' => '', 'folder' => '', 'table' => '', 'field' => ''],
        ];
        foreach ($data as $k => $d) {
            $files = array_diff(scandir(FCPATH . 'upload/' . $d['folder']), array('..', '.'));
            $d['files'] = count($files);
            $trash = [];
            foreach ($files as $k2 => $f) {
                $this->db->where($d['field'], $f);
                $result = $this->db->count_all_results($d['table']);
                if (!$result) {
                    array_push($trash, $f);
                }
            }
            $d['trashs'] = $trash;
            $d['trash'] = count($trash);
            $data[$k] = $d;
        }
        if ($this->input->post('delete') != null) {
            $trash = $data[$this->input->post('delete')]['trashs'];
            foreach ($trash as $k => $t) {
                unlink(FCPATH . 'upload/' . $data[$this->input->post('delete')]['folder'] . '/' . $t);
            }
            $this->session->set_flashdata('msgSuccess', 'File berhasil dihapus');
            redirect($this->module);
        }
        $this->data['data'] = $data;
        $this->render('index');
    }

}
