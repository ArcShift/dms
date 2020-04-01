<?php

class M_standard extends CI_Model {

    private $table = 'treeview';

    function create() {
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        return $this->db->insert($this->table);
    }

    function read() {
        $this->db->select('t.*, count(d.id) AS detail, u.username AS user');
        $this->db->join('users u', 'u.id = t.created_by');
        $this->db->join('treeview_detail d', 't.id = d.id_treeview', 'LEFT');
        $this->db->group_by('t.id');
        return $this->db->get($this->table. ' t')->result_array();
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
