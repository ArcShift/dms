<?php

class M_login extends CI_Model {

    public function login() {
        $this->db->select('u.*, r.name AS role');
        $this->db->where('u.name', $this->input->post('user'));
        $this->db->where('u.pass', md5($this->input->post('pass')));
        $this->db->join('role r', 'r.id=u.id_role');
        $result = $this->db->get('users u');
        if ($result->num_rows()) {
            $result = $result->row_array();
            $this->session->set_userdata('user', $result);
            return true;
        } else {
            return false;
        }
    }

}
