<?php

class M_place extends CI_Model {

    function province() {
        $this->db->order_by('name');
        return $this->db->get('province')->result_array();
    }

    function city() {
        $this->db->order_by('name');
        $this->db->where('id_province', $this->input->post('id'));
        return $this->db->get('regency')->result_array();
    }

}
