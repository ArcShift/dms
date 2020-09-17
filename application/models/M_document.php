<?php

class M_document extends CI_Model {

    private $table = 'document';

    function search() {
        $this->db->select('d.*, u.username, COUNT(ds.id) AS distribusi');
        $this->db->join('users u', 'u.id = d.creator', 'LEFT');
        $this->db->join('pasal p', 'd.id_pasal = p.id');
        $this->db->join('standard s', 's.id = p.id_standard');
        $this->db->join('distribusi ds', 'd.id = ds.id_document', 'LEFT');
        if ($this->input->get('creator')) {
            $this->db->where('u.id', $this->input->get('creator'));
        }
        if ($this->input->get('standar')) {
            $this->db->where('s.id', $this->input->get('standar'));
        }
        if ($this->input->get('judul')) {
            $this->db->like('d.judul', $this->input->get('judul'));
        }
        if ($this->input->get('distribusi')) {
            $this->db->where('ds.id_users', $this->input->get('distribusi'));
        }
        $this->db->group_by('d.id');
        return $this->db->get($this->table . ' d')->result_array();
    }

    function creator() {
        $this->db->select('u.id, u.username');
        $this->db->join($this->table . ' d', 'd.creator = u.id');
        $this->db->group_by('u.id');
        return $this->db->get('users u')->result_array();
    }
    function standar() {
        $this->db->select('s.id, s.name');
        $this->db->join('pasal p', 's.id = p.id_standard');
        $this->db->join($this->table . ' d', 'd.id_pasal = p.id');
        $this->db->group_by('s.id');
        return $this->db->get('standard s')->result_array();
    }
    function distribusi() {
        $this->db->select('u.id, u.username');
        $this->db->join('distribusi d', 'u.id = d.id_users');
        $this->db->group_by('u.id');
        return $this->db->get('users u')->result_array();
    }

}
