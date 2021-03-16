<?php

class M_account extends CI_Model {

    private $table = 'users';

    function get() {
        $this->db->select('u.username, u.email, p.fullname, u.photo, r.title AS role, u.id_role, c.name AS perusahaan, u.id_personil');
        $this->db->where('u.id', $this->session->userdata('user')['id']);
        $this->db->join('role r', 'r.id=u.id_role');
        $this->db->join('personil p', 'p.id=u.id_personil', 'LEFT');
        $this->db->join('company c', 'c.id=p.id_company', 'LEFT');
        $data = $this->db->get($this->table . ' u')->row_array();
        if (!empty($data['id_personil'])) {
            $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil = ' . $data['id_personil']);
            $data['unit_kerja'] = $this->db->get('unit_kerja uk')->result_array();
        }
        return $data;
    }

    function edit() {
        $this->db->set('username', $this->input->post('username'));
        $this->db->set('email', $this->input->post('email'));
//        $this->db->set('fullname', $this->input->post('namaLengkap'));
        $this->db->where('id', $this->session->user['id']);
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

    function update_foto() {
        $this->db->set('photo', $this->upload->data()['file_name']);
        $this->db->where('id', $this->session->userdata('user')['id']);
        return $this->db->update($this->table);
    }

    function detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

}
