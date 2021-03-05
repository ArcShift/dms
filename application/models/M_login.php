<?php

class M_login extends CI_Model {

    function login() {
        $this->db->select('u.*, r.name AS role, r.title, p.id_company, c.name AS perusahaan, p.fullname');
        $this->db->where('u.username', $this->input->post('user'));
        $this->db->where('u.pass', md5($this->input->post('pass')));
        $this->db->join('role r', 'r.id=u.id_role');
        $this->db->join('personil p', 'p.id = u.id_personil', 'LEFT');
        $this->db->join('company c', 'c.id = p.id_company', 'LEFT');
        $result = $this->db->get('users u');
        if ($result->num_rows()) {
            $result = $result->row_array();
            $this->session->set_userdata('user', $result);
            $this->db->where('id', $result['id_company']);
            $company = $this->db->get('company')->row_array();
            $this->session->set_userdata('company', $company); //REMOVE LATER
            if (!empty($result['id_company'])) {
                $this->db->where('id', $result['id_company']);
            }
            $company = $this->db->get('company')->row_array();
            $this->session->set_userdata('activeCompany', $company);
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
