<?php

class M_gap_analisa extends CI_Model {

    function create() {
        $this->db->set('id_company', $this->session->activeCompany['id']);
        $this->db->set('id_standard', $this->session->activeStandard['id']);
        $this->db->set('judul', $this->input->post('judul'));
        $this->db->set('ruang_lingkup', $this->input->post('ruang_lingkup'));
        $this->db->set('pelaksana', $this->input->post('pelaksana'));
        $this->db->set('tanggal', $this->input->post('tanggal'));
        $this->db->insert('gap_analisa');
    }

    function get($id = null) {
        if (empty($id)) {
            $this->db->where('id_company', $this->session->activeCompany['id']);
            $this->db->where('id_standard', $this->session->activeStandard['id']);
            $data = $this->db->get('gap_analisa')->result_array();
            foreach ($data as $k => $v) {
                $data[$k]['tim_pelaksana'] = $this->getPelaksana($v['id']);
            }
        } else {
            $this->db->where('id', $id);
            $data = $this->db->get('gap_analisa')->row_array();
            $data['tim_pelaksana'] = $this->getPelaksana($id);
        }
        return $data;
    }

    function edit() {
        $this->db->set('judul', $this->input->post('judul'));
        $this->db->set('ruang_lingkup', $this->input->post('ruang_lingkup'));
        $this->db->set('pelaksana', $this->input->post('pelaksana'));
        $this->db->set('tanggal', $this->input->post('tanggal'));
        $this->db->where('id', $this->session->idData);
        return $this->db->update('gap_analisa');
    }

    function updatePelaksana($id) {
        if (!empty($this->input->post('tim'))) {
            $input = $this->input->post('tim');
            $this->db->where('id_gap_analisa', $id);
            $result = $this->db->get('pelaksana_gap_analisa')->result_array();
            $db = [];
            foreach ($result as $r) {
                array_push($db, $r['id_personil']);
            }
            $remove = array_diff($db, $input);
            $add = array_diff($input, $db);
            foreach ($remove as $r) {
                $this->db->where('id_gap_analisa', $id);
                $this->db->where('id_personil', $r);
                $this->db->delete('pelaksana_gap_analisa');
            }
            foreach ($add as $a) {
                $this->db->set('id_gap_analisa', $id);
                $this->db->set('id_personil', $a);
                $this->db->insert('pelaksana_gap_analisa');
            }
            return $add;
        } else {//remove all data
            $this->db->where('id_gap_analisa', $id);
            return $this->db->delete('pelaksana_gap_analisa');
        }
    }

    function getPelaksana($id) {
        $this->db->select('pga.*, p.fullname');
        $this->db->join('personil p', 'p.id = pga.id_personil');
        return $this->db->get_where('pelaksana_gap_analisa pga', ['pga.id_gap_analisa' => $id])->result_array();
    }

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

    function update_perbaikan($path) {
        $this->db->where('id', $this->input->post('id'));
        $this->db->set('type', strtoupper($this->input->post('type')));
        $this->db->set('path', $path);
        $this->db->update('kuesioner_status');
    }

}
