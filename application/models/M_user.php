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

    function create() {
        $this->db->set('username', $this->input->post('nama'));
        $this->db->set('id_role', $this->input->post('role'));
        if ($this->input->post('personil')) {
            $this->db->set('id_personil', $this->input->post('personil'));
        }
        $this->db->set('pass', md5($this->input->post('pass')));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        return $this->db->insert($this->table);
    }

    function read() {
        $this->db->select('u.id, u.username, p.fullname, u.id_role, r.title AS role, p.id_unit_kerja, uk.name AS unit_kerja, c.name AS company');
        $this->db->join('role r', 'r.id = u.id_role');
        $this->db->join('personil p', 'p.id = u.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja', 'LEFT');
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
        $this->db->set('username', $input['username']);
        $this->db->set('id_role', $input['role']);
        return $this->db->update($this->table);
    }

    public function checkPass() {
        $this->db->where('id', $this->input->post('id'));
        $this->db->where('pass', md5($this->input->post('pass')));
        $result = $this->db->get($this->table);
        if ($result->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function gantiPassword() {
        $this->db->set("pass", md5($this->input->post("newPass")));
        $this->db->where("id", $this->input->post("id"));
        return $this->db->update($this->table);
    }

    public function updateData1() {
        $this->db->set("nama", $this->input->post("nama"));
        $this->db->where("id", $this->input->post("id"));
        return $this->db->update("user");
    }

    function freePersonil() {
        $this->db->select('p.id, p.fullname');
        $this->db->where('u.id IS NULL');
        $this->db->join($this->table . ' u', 'u.id_personil=p.id', 'LEFT');
        return $this->db->get('personil p')->result_array();
    }

}
