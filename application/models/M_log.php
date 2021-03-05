<?php

class M_log extends CI_Model {

    function get() {
        $this->db->select('l.*, u.username, r.title, p.fullname');
        $this->db->join('users u', 'u.id = l.id_user');
        $this->db->join('role r', 'r.id = u.id_role');
        $this->db->join('personil p', 'p.id = u.id_personil', 'LEFT');
        $this->db->order_by('l.created_at', 'DESC');
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
        $result = $this->db->get_where('unit_kerja', ['id'=>$id_unit_kerja])->row_array();
        $this->db->set('desc', '<b>' . $this->session->user['fullname'] . '</b> membuat unit kerja <b>'.$result['name'] .'</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>');
        $this->db->set('type', 'C_UK');
        $this->db->set('target', $id_unit_kerja);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

}
