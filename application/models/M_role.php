<?php

class M_role extends CI_Model {

    public function read() {
        return $this->db->get('userType')->result_array();
    }

    public function create() {
        $data = array(
            "nama" => $this->input->post("nama")
        );
        if ($this->db->insert("modul", $data)) {
            return 'success';
        } else {
            return $this->db->_error_message();
        }
    }

}
