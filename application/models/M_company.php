<?php

class M_company extends CI_Model {

    private $table = 'company';

    function read() {
        return $this->db->get('company')->result_array();
    }

    function create() {
        $this->db->set('name', $this->input->post('nama'));
        return $this->db->insert($this->table);
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    function update() {
        $input= $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('name', $input['nama']);
        return $this->db->update($this->table);
    }

}
