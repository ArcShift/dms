<?php

class M_dashboard extends CI_Model {

    function count($table) {
        return $this->db->count_all($table);
    }

    function count_user() {
        return $this->db->count_all('users');
    }

    //PEMASUKAN
    function count_standard() {
        return $this->db->count_all('users');
    }

}
