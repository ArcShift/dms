<?php

class M_user extends CI_Model {

    private $table = 'users';

    function role() {
        $this->db->order_by('id', 'ASC');
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('name', 'anggota');
        }
        return $this->db->get('role')->result_array();
    }

    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function unit_kerja() {
        $this->db->select('id, name');
        $this->db->where('id_company', $this->input->post('id'));
        return $this->db->get('unit_kerja')->result_array();
    }

    function create() {
        $this->db->set('username', $this->input->post('nama'));
        $this->db->set('fullname', $this->input->post('namaLengkap'));
        $this->db->set('id_role', $this->input->post('role'));
        if ($this->input->post('unit_kerja')) {
            $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
        }
        $this->db->set('pass', md5($this->input->post('pass')));
        $this->db->set('id_create', $this->session->userdata('user')['id']);
        return $this->db->insert($this->table);
    }

    function read() {
        $this->db->select('u.id, u.username, u.fullname, u.id_role, r.title AS role, u.id_unit_kerja, uk.name AS unit_kerja, c.name AS company');
        $this->db->join('role r', 'r.id = u.id_role');
        $this->db->join('unit_kerja uk', 'uk.id = u.id_unit_kerja', 'LEFT');
        $this->db->join('company c', 'c.id = uk.id_company', 'LEFT');
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('r.name', 'anggota');
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
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
        $this->db->set('username', $input['nama']);
        $this->db->set('fullname', $input['namaLengkap']);
//        $this->db->set('id_role', $input['role']);
//        $this->db->set('id_company', $input['company']);
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
