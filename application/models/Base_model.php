<?php

class Base_model extends CI_Model {

    function delete() {
        $data= $this->session->userdata('delete');
        $this->db->where('id', $data['id']);
        return $this->db->delete($data['table']);
    }
}
