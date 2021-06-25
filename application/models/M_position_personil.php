<?php

class M_position_personil extends CI_Model{

    function get_by_document($id_document) {
        $this->db->select('pp.*, CONCAT(p.fullname, " - ", uk.name) AS personil');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        return $this->db->get_where('distribution ds',['ds.id_document'=>$id_document])->result();
    }

}
