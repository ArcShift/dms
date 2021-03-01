<?php

class M_log extends CI_Model {
    
    function get() {
        $this->db->select('l.*');
        return $this->db->get('log l')->result_array();
    }
}