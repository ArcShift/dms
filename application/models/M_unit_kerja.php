<?php

class M_unit_kerja extends CI_Model {
    private $table= 'unit_kerja';
    
    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function read() {
        $this->db->select('u.id, u.name, u.jenis, c.name AS company');
        $this->db->join('company c', 'u.id_company=c.id');
        if($this->session->userdata['user']['role']=='pic'){
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get($this->table. ' u')->result_array();
    }

    function create() {
        $this->db->set('id_company',$this->input->post('perusahaan'));
        $this->db->set('name',$this->input->post('nama'));
        $this->db->set('jenis',$this->input->post('jenis'));
        return $this->db->insert($this->table);
    }
    function detail($id) {
        $this->db->where('id',$id);
        return $this->db->get($this->table)->row_array();
    }

}
