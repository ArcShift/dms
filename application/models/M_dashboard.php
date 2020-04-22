<?php

class M_dashboard extends CI_Model {

    function count($table) {
        return $this->db->count_all($table);
    }
    function standard_active(){
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
        $this->db->group_by('s.id');
        return $this->db->count_all_results('standard s');
    }
}
