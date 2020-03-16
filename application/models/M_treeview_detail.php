<?php

class M_treeview_detail extends CI_Model {

    private $table = 'treeview_detail';
    
    function treeview() {
        $this->db->where('id', $this->session->userdata('treeview'));
        return $this->db->get('treeview')->row_array();
    }
    
    function reads() {
        $this->db->where('id_treeview', $this->session->userdata('treeview'));
        return $this->db->get($this->table)->result_array();
    }

    function create() {
        $input = $this->input->post();
        $this->db->set('name', $input['nama']);
        $this->db->set('id_treeview', $this->session->userdata('treeview'));
        $this->db->set('id_user', $this->session->userdata('user')['id']);
        if (is_numeric($input['id'])) {
            $this->db->set('parent', $input['id']);
        }
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

    function update_file() {
        $this->db->set('file', $this->upload->data()['file_name']);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table);
    }

}
