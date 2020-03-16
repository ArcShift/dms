<?php

class M_treeview extends CI_Model {

    private $table = 'treeview';

    function create() {
        $this->db->set('name', $this->input->post('name'));
        $this->db->set('created_by', $this->session->userdata('userId'));
        return $this->db->insert($this->table);
    }

    function read() {
        return $this->db->get($this->table)->result_array();
    }

}
