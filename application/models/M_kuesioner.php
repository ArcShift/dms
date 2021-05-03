<?php

class M_kuesioner extends CI_Model {

    function get() {
        $this->db->where('id_gap_analisa', $this->session->gapAnalisa['id']);
        return $this->db->get('kuesioner')->result_array();
    }

    function getStatus($id) {
        $this->db->select('ks.*, uk.name AS unit_kerja');
        $this->db->join('unit_kerja uk', 'uk.id = ks.id_unit_kerja');
        $this->db->where('ks.id_kuesioner', $id);
        return $this->db->get('kuesioner_status ks')->result_array();
    }

    function counts($id) {
        $this->db->select('p.id, COUNT(DISTINCT k.id) AS pertanyaan, COUNT(DISTINCT ks.id) AS unit, , AVG(ks.status) AS status');
        $this->db->join('kuesioner k', 'k.id_pasal = p.id', 'LEFT');
        $this->db->join('kuesioner_status ks', 'ks.id_kuesioner = k.id', 'LEFT');
        $this->db->where('p.id', $id);
        return $this->db->get('pasal p')->row_array();
    }

    function getAverage($id) {
        $que = $this->getStatus($id);
        $sum = 0;
        foreach ($que as $v) {
            $sum += $v['status'];
        }
        return round($sum / $this->counts($que));
    }

    function update() {
        $this->db->set('hasil', $this->input->post('hasil'));
        $this->db->set('saran_perbaikan', $this->input->post('saran'));
        $this->db->set('status', $this->input->post('status'));
        $this->db->set('status_perbaikan', $this->input->post('status'));
        $this->db->set('target', $this->input->post('target'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('kuesioner_status');
    }

}
