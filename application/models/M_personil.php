<?php

class M_personil extends CI_Model {

    private $table = 'personil';

    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function unit_kerja() {
        $this->db->select('id, name');
        $this->db->where('id_company', $this->input->post('id'));
        return $this->db->get('unit_kerja')->result_array();
    }

    function read() {
        $this->db->select('p.id, p.fullname, u.username, p.id_unit_kerja, uk.name AS unit_kerja, c.name AS company');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja', 'LEFT');
        $this->db->join('company c', 'c.id = uk.id_company', 'LEFT');
        $this->db->join('users u', 'p.id = u.id_personil', 'LEFT');
//        if ($this->session->userdata('user')['role'] == 'pic') {
//            $this->db->where('r.name', 'anggota');
//            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
//        }
        $this->db->group_by('p.id');
        return $this->db->get($this->table . ' p')->result_array();
    }

    function create() {
        $this->db->set('fullname', $this->input->post('nama'));
        if ($this->input->post('unit_kerja')) {
            $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
        }
        return $this->db->insert($this->table);
    }

    function updateData() {
        $input = $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('fullname', $input['fullname']);
        return $this->db->update($this->table);
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

}
