<?php

class M_management_hope extends CI_Model{
    function company() {
//        $this->
        return $this->db->get('company')->result_array();
    }
    
}
