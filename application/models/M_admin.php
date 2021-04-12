<?php

class M_admin extends CI_Model {

    function get($id = null) {
        
    }

    function login($username, $pass) {
        $admin = $this->db->get_where('admin',)->row_array();
    }

}
