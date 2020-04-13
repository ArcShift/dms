<?php
 class M_place extends CI_Model {
     function province() {
         return $this->db->get('provinces')->result_array();
     }
     function city() {
         $this->db->where('province_id', $this->input->post('id'));
         return $this->db->get('regencies')->result_array();
     }
}

