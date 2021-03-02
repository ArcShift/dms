<?php

class M_log extends CI_Model {

    function get() {
        $this->db->select('l.*, u.username');
        $this->db->join('users u', 'u.id = l.id_user');
        return $this->db->get('log l')->result_array();
    }

}
