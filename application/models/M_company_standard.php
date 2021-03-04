<?php

class M_company_standard extends CI_Model {

    private $table = "company_standard";

    function company() {
        $this->db->select('c.*, COUNT(DISTINCT(cs.id)) AS count, p.fullname, u.photo, r.name AS city');
        $this->db->join('company_standard cs', 'c.id = cs.id_company', 'LEFT');
//        $this->db->join('unit_kerja uk', 'c.id = uk.id_company', 'LEFT');
        $this->db->join('personil p', 'p.id_company = c.id', 'LEFT');
        $this->db->join('users u', 'p.id = u.id_personil AND u.id_role = 2', 'LEFT');
        $this->db->join('regency r', 'r.id = c.id_regency', 'LEFT');
        if ($this->session->userdata['user']['role'] == 'pic') {
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
//        $this->db->where('u.id_role',2);
        $this->db->group_by('c.id');
        return $this->db->get('company c')->result_array();
    }

    function standard($comp) {
        $this->db->select('s.*, COUNT(cs.id) AS count');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company='.$comp, 'LEFT');
        $this->db->group_by('s.id');
        return $this->db->get('standard s')->result_array();
    }

    function toggle() {
        $company = $this->input->post('perusahaan');
        $standard = $this->input->post('toggle');
        $this->db->where('id_company', $company);
        $this->db->where('id_standard', $standard);
        if (empty($this->db->get('company_standard')->row_array())) {
            $this->db->set('id_company', $company);
            $this->db->set('id_standard', $standard);
            return $this->db->insert('company_standard');
        } else {
            $this->db->where('id_company', $company);
            $this->db->where('id_standard', $standard);
            return $this->db->delete('company_standard');
        }
    }

}
