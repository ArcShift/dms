<?php

class M_admin extends CI_Model {

    function get($id = null) {
        
    }

    function login($username, $pass) {
        $this->db->where('username',$username);
        $this->db->where('pass',$pass);
        return $this->db->get_where('admin',)->row_array();
    }

}
