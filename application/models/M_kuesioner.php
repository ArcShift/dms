<?php

class M_kuesioner extends CI_Model {
    function getStatus($id) {
        $this->db->select('ks.*, uk.name AS unit_kerja');
        $this->db->join('unit_kerja uk', 'uk.id = ks.id_unit_kerja');
        $this->db->where('ks.id_kuesioner', $id);
        return $this->db->get('kuesioner_status ks')->result_array();
    }
}
