<?php

class M_dashboard extends CI_Model {

    private $company;

    public function __construct(){
        parent::__construct();
        $this->company = $this->session->user['id_company'];
    }

    function count($table) {
        return $this->db->count_all($table);
    }

    function standard_active() {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
        if(!empty($this->company)){
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

}
