<?php

class M_pasal extends CI_Model {

    private $table = 'pasal';

    function treeview() {
        $this->db->where('id', $this->session->userdata('treeview'));
        return $this->db->get('standard')->row_array();
    }

    function reads() {
        $this->db->where('id_standard', $this->session->userdata('treeview'));
        return $this->db->get($this->table)->result_array();
    }

    function create() {
        $input = $this->input->post();
        if (!empty($input['id'])) {
        $p = $this->db->get('pasal')->row_array();
            $this->db->set('parent', $input['id']);
//        $this->db->set('sort_index', ???);
        }
        $this->db->set('name', $input['nama']);
        $this->db->set('id_standard', $this->session->userdata('treeview'));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        $this->db->insert($this->table);
    }

    function update() {
        $this->db->set('name', $this->input->post('nama'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table);
    }

    function delete() {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete($this->table);
    }
    function update_desc() {
        $this->db->set('sort_desc', $this->input->post('sort-desc'));
        $this->db->set('long_desc', $this->input->post('long-desc'));
        $this->db->set('subtitle', $this->input->post('subtitle'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->table);
    }

}
