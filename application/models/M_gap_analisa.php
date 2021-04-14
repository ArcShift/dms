<?php

class M_gap_analisa extends CI_Model {

    function getUnit($id) {
        $this->db->select('ks.*, uk.name AS unit_kerja');
        $this->db->join('unit_kerja uk', 'uk.id = ks.id_unit_kerja');
        $this->db->where('ks.id_kuesioner', $id);
        return $this->db->get('kuesioner_status ks')->result_array();
    }

    function update_hasil() {
        $this->db->set('hasil', $this->input->post('hasil'));
        $this->db->set('saran_perbaikan', $this->input->post('saran'));
        $this->db->set('target', $this->input->post('target'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kuesioner_status');
    }

}
