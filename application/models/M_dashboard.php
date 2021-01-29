<?php

class M_dashboard extends CI_Model {

    private $company;

    public function __construct() {
        parent::__construct();
        $this->company = $this->session->user['id_company'];
    }

    function count($table) {
        return $this->db->count_all($table);
    }

    function standard_active() {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
        if (!empty($this->company)) {
            $this->db->where('cs.id_company = ' . $this->company);
        }
        $this->db->group_by('s.id');
        return $this->db->count_all_results('standard s');
    }

    function count_user_company() {
        $this->db->join('personil p', 'p.id = u.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja AND uk.id_company = ' . $this->company);
        return $this->db->count_all_results('users u');
    }

    function company_standard($c) {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $c);
        return $this->db->get('standard s')->result_array();
    }

    function getDefaultStandard($company) {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $company);
        return $this->db->get('standard s')->row_array();
    }

    function distribusi($company, $standard) {
        $this->db->select('uk.*, COUNT(d.id) AS doc, COUNT(j.id) AS imp');
        $this->db->join('company c', 'c.id = uk.id_company AND c.id = ' . $company);
        $this->db->join('personil p', 'p.id_unit_kerja = uk.id', 'LEFT');
        $this->db->join('distribusi ds', 'ds.id_personil = p.id', 'LEFT');
        $this->db->join('document d', 'd.id = ds.id_document', 'LEFT');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal AND ps.id_standard = ' . $standard);
        $this->db->join('tugas t', 't.id_document = d.id', 'LEFT');
        $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
        $this->db->group_by('uk.id');
        return $this->db->get('unit_kerja uk')->result_array();
    }

    function listTugas($company, $standard) {
        $this->db->select('p.fullname AS name, uk.name AS unit_kerja, t.nama AS tugas, ps.name AS pasal, j.tanggal, j.upload_date');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('penerima_tugas pt', 'pt.id_tugas = t.id');
        $this->db->join('personil p', 'p.id = pt.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja AND uk.id_company = ' . $company);
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
        $this->db->join('pasal ps', 'ps.id = dp.id_pasal');
        return $this->db->get('jadwal j')->result_array();
    }

}
