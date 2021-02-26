<?php

class M_unit_kerja extends CI_Model {

    private $table = 'unit_kerja';

    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function read() {
        $this->db->select('u.id, u.name, c.name AS company, COUNT(p.id) AS personil');
        $this->db->join('company c', 'u.id_company=c.id');
        $this->db->join('personil p', 'p.id_unit_kerja=u.id', 'LEFT');
        if ($this->session->userdata['user']['role'] == 'pic') {
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
        $this->db->group_by('u.id');
        return $this->db->get($this->table . ' u')->result_array();
    }

    function create() {
        $this->db->set('id_company', $this->input->post('perusahaan'));
        $this->db->set('name', $this->input->post('nama'));
        return $this->db->insert($this->table);
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }
    function update() {
        $this->db->set('name', $this->input->post('nama'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('unit_kerja');
    }
    function jobdesk($id) {
        $this->db->where('id_unit_kerja', $id);
        return $this->db->get('jobdesk')->result_array();
    }

}
