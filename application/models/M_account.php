<?php

class M_account extends CI_Model {

    private $table = 'users';

    function get() {
        $this->db->select('u.name, r.name AS role');
        $this->db->where('u.id', $this->session->userdata('user')['id']);
        $this->db->join('role r', 'r.id=u.id_role');
        return $this->db->get($this->table . ' u')->row_array();
    }

    function edit() {
        $this->db->set('name', $this->input->post('name'));
        $this->db->where('id', $this->session->userdata('user')['id']);
        return $this->db->update($this->table);
    }

    function change_pass() {
        $this->db->set('pass', md5($this->input->post('new_pass')));
        $this->db->where('id', $this->session->userdata('user')['id']);
        return $this->db->update($this->table);
    }

    public function checkPass() {
        $this->db->where('id', $this->session->userdata('user')['id']);
        $this->db->where('pass', md5($this->input->post('old_pass')));
        $result = $this->db->get($this->table);
        if ($result->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

}
