<?php

class M_position_personil extends CI_Model {

    function get($id = NULL) {
        $this->db->select('pp.*, CONCAT(p.fullname, " - ", uk.name) AS personil, u.photo');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->join('users u', 'u.id_personil = p.id', 'LEFT');
        $this->db->group_by('pp.id');
        return $this->db->get('position_personil pp')->result();
    }

    function get_by_document($id_document) {
        $this->db->select('pp.*, CONCAT(p.fullname, " - ", uk.name) AS personil');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        return $this->db->get_where('distribution ds', ['ds.id_document' => $id_document])->result();
    }

    function get_by_company() {
        $this->db->select('pp.*, CONCAT(p.fullname, " - ", uk.name) AS personil');
        $this->db->join('personil p', 'p.id = pp.id_personil AND p.id_company = ' . $this->session->activeCompany['id']);
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        return $this->db->get('position_personil pp')->result();
    }

    function get_pelaksana_project($id_project) {
        $this->db->join('personil_task pt', 'pt.id_position_personil = pp.id');
        $this->db->join('tugas t', 't.id = pt.id_tugas AND t.id_project='.$id_project);
        return $this->get();
    }

    function get_by_distribution_ketua($id_pp_ketua, $id_document = null) {
        $pp = $this->db->get_where('position_personil', ['id'=> $id_pp_ketua])->row();
//        die(print_r($pp));
        $this->db->select('pp.*, CONCAT(p.fullname, " - ", uk.name) AS personil');
        if(!empty($id_document)){
            $this->db->join('distribution ds', 'ds.id_position_personil = pp.id AND ds.id_document = '.$id_document);
        }
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id_role = 4');
        return $this->db->get_where('position_personil pp', ['pp.id_unit_kerja'=>$pp->id_unit_kerja])->result();
    }

}
