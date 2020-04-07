<?php

class M_treeview_detail extends CI_Model {

    private $table = 'pasal';

    function treeview() {
        $this->db->where('id', $this->session->userdata('treeview'));
        return $this->db->get('standard')->row_array();
    }

    function standard() {
        $this->db->select('s.id, s.name');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company=' . $this->input->post('id'));
        return $this->db->get('standard s')->result_array();
    }

    function detail() {
        
    }

    function reads() {
        $this->db->where('id_standard', $this->session->userdata('treeview'));
        return $this->db->get($this->table)->result_array();
    }

    function create() {
        $input = $this->input->post();
        $this->db->set('name', $input['nama']);
        $this->db->set('id_standard', $this->session->userdata('treeview'));   
        $this->db->set('created_by', $this->session->userdata('user')['id']);
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

    function update_desc() {
        $this->db->set('description', $this->input->post('desc'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->table);
    }

    function update_file1() {
        $this->db->set('file', $this->upload->data()['file_name']);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table);
    }

}
