<?php

class M_company extends CI_Model {

    private $table = 'company';

    function get() {
        $role = $this->session->userdata('user')['role'];
        if ($role == 'pic' || $role == 'anggota') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get($this->table)->result_array();
    }

    function read() {
        $this->db->select('c.*, COUNT(DISTINCT(u.id)) AS count, COUNT(DISTINCT(cs.id)) AS standard, r.name AS city');
        $this->db->join('unit_kerja u', 'u.id_company= c.id', 'LEFT');
        $this->db->join('company_standard cs', 'cs.id_company= c.id', 'LEFT');
        $this->db->join('regency r', 'r.id = c.id_regency', 'LEFT');
        if ($this->session->userdata['user']['role'] == 'pic') {
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
        $this->db->group_by('c.id');
        return $this->db->get($this->table . ' c')->result_array();
    }

    function create() {
        $this->db->set('name', $this->input->post('nama'));
        $this->db->set('id_regency', $this->input->post('kota'));
        return $this->db->insert($this->table);
    }

    function detail($id) {
        $this->db->select('c.*, r.name AS kota, p.name AS province, COUNT(DISTINCT uk.id) AS unit_kerja, COUNT(DISTINCT prs.id) AS personil,  COUNT(DISTINCT cs.id) AS standard,  COUNT(DISTINCT d.id) AS document');
        $this->db->join('regency r', 'r.id = c.id_regency', 'LEFT');
        $this->db->join('province p', 'p.id = r.id_province', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id_company = c.id', 'LEFT');
        $this->db->join('personil prs', 'prs.id_company = c.id', 'LEFT');
        $this->db->join('company_standard cs', 'cs.id_company = c.id', 'LEFT');
        $this->db->join('document d', 'd.id_company = c.id', 'LEFT');
        $this->db->group_by('c.id');
        $this->db->where('c.id', $id);
        return $this->db->get($this->table. ' c')->row_array();
    }

    function update() {
        $input = $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('name', $input['nama']);
        $this->db->set('id_regency', $input['kota']);
        return $this->db->update($this->table);
    }

}
