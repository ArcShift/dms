<?php

class M_login extends CI_Model {

    function login() {
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

    function access() {
        $this->db->select('m.*, a.acc_read, a.acc_create, a.acc_update, a.acc_delete');
        $this->db->join('access a', 'm.id = a.module');
        $this->db->join('role r', 'r.id = a.role');
        $this->db->join('users u', 'r.id = u.id_role AND u.id = ' . $this->session->userdata('user')['id']);
        $this->db->order_by('m.id', 'ASC');
        return $this->db->get("module m")->result_array();
    }

}
