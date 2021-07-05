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
//        $this->db->select('ga.*, COUNT(k.id) AS pertanyaan, COUNT(p.id) AS pl');
//        $this->db->join('kuesioner k', 'k.id_gap_analisa = ga.id', 'LEFT');
//        $this->db->join('pelaksana_gap_analisa p', 'p.id_gap_analisa = ga.id', 'LEFT');
//        $this->db->group_by('ga.id');
        if (empty($id)) {
            $this->db->where('ga.id_company', $this->session->activeCompany['id']);
            $this->db->where('ga.id_standard', $this->session->activeStandard['id']);
            $data = $this->db->get('gap_analisa ga')->result_array();
            foreach ($data as $k => $v) {
                $data[$k]['tim_pelaksana'] = $this->getPelaksana($v['id']);
            }
        } else {
            $this->db->where('ga.id', $id);
            $data = $this->db->get('gap_analisa ga')->row_array();
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
        $this->db->where('ks.id_gap_analisa', $this->session->gapAnalisa['id']);
        return $this->db->get('kuesioner_status ks')->result_array();
    }

    function update_hasil($path) {
        $this->db->set('imp_type', $this->input->post('type'));
        $this->db->set('imp_path', $path);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kuesioner_status');
    }

    function update_perbaikan($path) {
        $this->db->where('id', $this->input->post('id'));
        $this->db->set('type', strtoupper($this->input->post('type')));
        $this->db->set('path', $path);
        $this->db->update('kuesioner_status');
    }
    function getDocument(){
        if ($this->role == 'anggota') {
            $this->db->join('distribution ds', 'ds.id_document = d.id');
            $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        } else {
            $this->db->where('d.id_company', $this->session->activeCompany['id']);
        }
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
        return $this->db->get('document d')->result_array();
    }
}
