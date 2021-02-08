<?php

class M_personil extends CI_Model {

    private $table = 'personil';

    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function unit_kerja($id_company) {
        $this->db->select('id, name');
        $this->db->where('id_company', $id_company);
        return $this->db->get('unit_kerja')->result_array();
    }

    function read() {
        $this->db->select('p.id, p.fullname, u.username, p.id_unit_kerja, uk.name AS unit_kerja, c.name AS company');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja', 'LEFT');
        $this->db->join('company c', 'c.id = p.id_company', 'LEFT');
        $this->db->join('users u', 'p.id = u.id_personil', 'LEFT');
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
        $this->db->group_by('p.id');
        $result = $this->db->get($this->table . ' p')->result_array();
        foreach ($result as $k => $r) {
            $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil = ' . $r['id']);
            $result[$k]['unit_kerja'] = $this->db->get('unit_kerja uk')->result_array();
        }
        return $result;
    }

    function create() {
        $this->db->set('fullname', $this->input->post('nama'));
        $this->db->set('id_company', $this->input->post('perusahaan'));
        $this->db->insert($this->table);
        $id = $this->db->insert_id();
        foreach ($this->input->post('unit_kerja') as $uk) {
            $this->db->set('id_personil', $id);
            $this->db->set('id_unit_kerja', $uk);
            $this->db->insert('position_personil');
        }
        return true;
    }

    function updateData() {
        $input = $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('fullname', $input['fullname']);
        $this->db->set('id_unit_kerja', $input['id_unit_kerja']);
        return $this->db->update($this->table);
    }

    function detail($id) {
        $this->db->select('p.*, uk.id_company');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
        $this->db->where('p.id', $id);
        return $this->db->get($this->table . ' p')->row_array();
    }

}
