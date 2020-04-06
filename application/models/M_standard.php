<?php

class M_standard extends CI_Model {

    private $table = 'standard';

    function create() {
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        return $this->db->insert($this->table);
    }

    function read() {
        $this->db->select('s.*, count(DISTINCT(p.id)) AS detail,count(DISTINCT(cs.id)) AS used, u.username AS user');
        $this->db->join('users u', 'u.id = s.created_by');
        $this->db->join('pasal p', 's.id = p.id_standard', 'LEFT');
        $this->db->join('company_standard cs', 's.id = cs.id_standard', 'LEFT');
        $this->db->group_by('s.id');    
        return $this->db->get($this->table. ' s')->result_array();
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

}
