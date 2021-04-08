<?php

class M_kuesioner extends CI_Model {

    function getStatus($id) {
        $this->db->select('ks.*, uk.name AS unit_kerja');
        $this->db->join('unit_kerja uk', 'uk.id = ks.id_unit_kerja');
        $this->db->where('ks.id_kuesioner', $id);
        return $this->db->get('kuesioner_status ks')->result_array();
    }

    function counts($id) {
        $this->db->select('p.id, COUNT(DISTINCT k.id) AS pertanyaan, COUNT(DISTINCT ks.id) AS unit, , AVG(DISTINCT ks.status) AS status');
        $this->db->join('kuesioner k', 'k.id_pasal = p.id', 'LEFT');
        $this->db->join('kuesioner_status ks', 'ks.id_kuesioner = k.id', 'LEFT');
        $this->db->where('p.id', $id);
        return $this->db->get('pasal p')->row_array();
    }

}
