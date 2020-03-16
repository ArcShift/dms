<?php

class M_user extends CI_Model {

    private $table = 'users';

    function role() {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('role')->result_array();
    }

    function create() {
        $this->db->set('name', $this->input->post('nama'));
        $this->db->set('id_role', $this->input->post('role'));
        $this->db->set('pass', md5($this->input->post('pass')));
        return $this->db->insert($this->table);
    }

    function read() {
        $this->db->select('u.id, u.name, u.id_role, r.name AS role');
        $this->db->join('role r', 'r.id = u.id_role');
        return $this->db->get($this->table . ' u')->result_array();
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    function updateData() {
        $input = $this->input->post();
        $this->db->where('id', $input['id']);
        $this->db->set('name', $input['nama']);
        $this->db->set('id_role', $input['role']);
        return $this->db->update($this->table);
    }

    public function checkPass() {
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('pass', md5($this->input->post('pass')));
        $result = $this->db->get('user');
        if ($result->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function gantiPassword() {
        $this->db->set("pass", md5($this->input->post("newPass")));
        $this->db->where("id", $this->input->post("id"));
        return $this->db->update("user");
    }

    public function updateData1() {
        $this->db->set("nama", $this->input->post("nama"));
        $this->db->where("id", $this->input->post("id"));
        return $this->db->update("user");
    }

}
