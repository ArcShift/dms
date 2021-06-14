<?php

class M_project extends CI_Model {

    private $table = 'project';

    function get() {
        $this->db->where('id_company', $this->session->activeCompany['id']);
        return $this->db->get($this->table)->result();
    }

}
