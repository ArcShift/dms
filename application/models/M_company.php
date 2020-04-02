<?php

class M_company extends CI_Model {

    private $table = 'company';
    
    function get() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get($this->table)->result_array();
    }
    function read() {
        $this->db->select('c.*, COUNT(u.id) AS count');
        $this->db->join('unit_kerja u', 'u.id_company= c.id', 'LEFT');
//        die(print_r($this->session->userdata['user']));
        if($this->session->userdata['user']['role']=='pic'){
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
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
