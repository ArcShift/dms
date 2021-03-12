<?php

class M_log extends CI_Model {

    function get() {
        $this->db->select('l.*, u.username, r.title, p.fullname');
        $this->db->join('users u', 'u.id = l.id_user');
        $this->db->join('role r', 'r.id = u.id_role');
        $this->db->join('personil p', 'p.id = u.id_personil', 'LEFT');
        $this->db->order_by('l.created_at', 'DESC');
        if($this->session->user['role']=='anggota'){
            $this->db->where('u.id', $this->session->user['id']);
        }else if($this->session->user['role']=='pic'){
            $this->db->where('p.id_company', $this->session->activeCompany['id']);
        }
        return $this->db->get('log l')->result_array();
    }

    function update_company() {
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> mengubah data perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'U_COMP');
        $this->db->set('target', $this->session->activeCompany['id']);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

    function create_unit_kerja($id_unit_kerja) {
        $result = $this->db->get_where('unit_kerja', ['id' => $id_unit_kerja])->row_array();
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> membuat unit kerja <b>' . $result['name'] . '</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'C_UK');
        $this->db->set('target', $id_unit_kerja);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

    function update_unit_kerja($id) {
        $result = $this->db->get_where('unit_kerja', ['id' => $id])->row_array();
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> mengubah data unit kerja <b>' . $result['name'] . '</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'U_UK');
        $this->db->set('target', $id);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

    function delete_unit_kerja($message) {
        $this->db->set('desc', $message);
        $this->db->set('type', 'D_UK');
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

    function create_personil($id) {
        $result = $this->db->get_where('personil', ['id' => $id])->row_array();
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> menambahkan data personil <b>' . $result['fullname'] . '</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'C_PRS');
        $this->db->set('target', $id);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

    function update_personil($id) {
        $result = $this->db->get_where('personil', ['id' => $id])->row_array();
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> mengubah data personil <b>' . $result['fullname'] . '</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'U_PRS');
        $this->db->set('target', $id);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }
    function delete_personil($message) {
        $this->db->set('desc', $message);
        $this->db->set('type', 'D_UK');
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

}
