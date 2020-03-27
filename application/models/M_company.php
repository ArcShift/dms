<?php

class M_company extends CI_Model {

    private $table = 'company';

    function read() {
        $this->db->select('c.*, COUNT(u.id) AS count');
        $this->db->join('unit_kerja u', 'u.id_company= c.id', 'LEFT');
        $this->db->group_by('c.id');
        return $this->db->get($this->table. ' c')->result_array();
    }

    function create() {
        $this->db->set('name', $this->input->post('nama'));
        return $this->db->insert($this->table);
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    function update() {
        $input= $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('name', $input['nama']);
        return $this->db->update($this->table);
    }

}
