<?php

class M_document extends CI_Model {

    private $table = 'document';

    function search() {
        $this->db->select('d.*, u.username');
        $this->db->join('users u', 'u.id = d.creator', 'LEFT');
        if($this->input->get('creator')){
            $this->db->where('u.id',$this->input->get('creator'));
        }
        if($this->input->get('judul')){
            $this->db->like('d.judul', $this->input->get('judul'));
        }
        return $this->db->get($this->table. ' d')->result_array();
    }
    function creator() {
        $this->db->select('u.id, u.username');
        $this->db->join($this->table. ' d', 'd.creator = u.id');
        $this->db->group_by('u.id');
        return $this->db->get('users u')->result_array();
    }

}
