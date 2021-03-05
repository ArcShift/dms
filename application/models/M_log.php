<?php

class M_log extends CI_Model {

    function get() {
        $this->db->select('l.*, u.username, r.title, p.fullname');
        $this->db->join('users u', 'u.id = l.id_user');
        $this->db->join('role r', 'r.id = u.id_role');
        $this->db->join('personil p', 'p.id = u.id_personil', 'LEFT');
        $this->db->order_by('l.created_at', 'DESC');
        return $this->db->get('log l')->result_array();
    }
    function set(){
        
    }
}
