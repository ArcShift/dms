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

    function terlambat() {
//        $this->db->where('(date < CURDATE() AND file IS NULL) OR (file IS NOT NULL AND date < upload_date)');
//        return $this->db->count_all_results('schedule');
        return 0;
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

//
//    function grafik_pasal() {
//        $this->db->where('p.id_standard', $this->input->get('standard'));
//        $result = $this->db->get('pasal p')->result_array();
//        foreach ($result as $k => $r) {
//            //DOKUMEN
//            $this->db->join('document d', 'd.id = dp.id_document AND d.id_company = ' . $this->input->get('company'));
//            $this->db->where('dp.id_pasal', $r['id']);
//            $result[$k]['doc'] = $this->db->count_all_results('document_pasal dp');
//            //HARAPAN
//            $this->db->where('id_company', $this->input->get('company'));
//            $this->db->where('id_pasal', $r['id']);
//            $row = $this->db->get('hope')->row_array();
//            if (empty($row)) {
//                $result[$k]['harapan'] = 70;
//            } else {
//                $result[$k]['harapan'] = $row['persentase'];
//            }
//            //IMPLEMENTASI
//            
////            $result[$k]['implementasi'] = $this->db->count_all_results('jadwal j');
//        }
//        return $result;
//    }

    function getDefaultStandard($company) {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $company);
        return $this->db->get('standard s')->row_array();
    }

}
