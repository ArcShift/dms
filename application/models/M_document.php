<?php

class M_document extends CI_Model {

    private $table = 'document';

    function search() {
        $this->db->select('d.*, uc.username, COUNT(ds.id) AS distribusi');
        $this->db->join('users uc', 'uc.id = d.creator', 'LEFT');
        $this->db->join('pasal p', 'd.id_pasal = p.id');
        $this->db->join('standard s', 's.id = p.id_standard');
        $this->db->join('distribusi ds', 'd.id = ds.id_document', 'LEFT');
        if ($this->input->get('perusahaan')) {
            $this->db->join('personil pc', 'pc.id = uc.id_personil');
            $this->db->join('unit_kerja ukc', 'ukc.id = pc.id_unit_kerja');
            $this->db->join('company cc', 'cc.id = ukc.id_company');
            $this->db->where('cc.id', $this->input->get('perusahaan'));
        }
        if ($this->input->get('creator')) {
            $this->db->where('uc.id', $this->input->get('creator'));
        }
        if ($this->input->get('standar')) {
            $this->db->where('s.id', $this->input->get('standar'));
        }
        if ($this->input->get('judul')) {
            $this->db->like('d.judul', $this->input->get('judul'));
        }
        if ($this->input->get('unit_kerja_distribusi')) {
//            $this->db->join('users uds', 'uds.id = ds.id_users');
//            $this->db->join('personil pds', 'pds.id = uds.id_personil');
            $this->db->join('personil pds', 'pds.id = ds.id_personil');
            $this->db->join('unit_kerja ukds', 'ukds.id = pds.id_unit_kerja');
            $this->db->where('ukds.id', $this->input->get('unit_kerja_distribusi'));
        }
        if ($this->input->get('distribusi')) {
            $this->db->where('ds.id_users', $this->input->get('distribusi'));
        }
        $this->db->group_by('d.id');
        return $this->db->get($this->table . ' d')->result_array();
    }

    function get($id) {
        $this->db->select('d.*, u.username AS pembuat, d2.judul AS dokumen_terkait');
        $this->db->where('d.id', $id);
        $this->db->join('users u', 'u.id = d.creator', 'LEFT');
        $this->db->join($this->table . ' d2', 'd.contoh = d2.id', 'LEFT');
        return $this->db->get($this->table . ' d')->row_array();
    }

    function perusahaan() {
        $this->db->select('c.id, c.name');
        $this->db->join('unit_kerja uk', 'uk.id_company = c.id');
        $this->db->join('personil p', 'p.id_unit_kerja = uk.id');
        $this->db->join('users u', 'u.id_personil = p.id');
        $this->db->join($this->table . ' d', 'd.creator = u.id');
        $this->db->group_by('c.id');
        return $this->db->get('company c')->result_array();
    }

    function creator() {
        $this->db->select('u.id, u.username');
        $this->db->join($this->table . ' d', 'd.creator = u.id');
        if ($this->input->get('perusahaan')) {
            $this->db->join('personil p', 'u.id_personil = p.id');
            $this->db->join('unit_kerja uk', 'p.id_unit_kerja = uk.id AND uk.id_company='.$this->input->get('perusahaan'));
        }
        $this->db->group_by('u.id');
        return $this->db->get('users u')->result_array();
    }

    function standar() {
        $this->db->select('s.id, s.name');
        $this->db->join('pasal p', 's.id = p.id_standard');
        $this->db->join($this->table . ' d', 'd.id_pasal = p.id');
        $this->db->group_by('s.id');
        return $this->db->get('standard s')->result_array();
    }

    function distribusi($unit_kerja = null) {
        $this->db->select('p.id, p.fullname');
        $this->db->join('distribusi d', 'p.id = d.id_personil');
        $this->db->group_by('p.id');
        if (!empty($unit_kerja)) {
            $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
            $this->db->where('uk.id', $unit_kerja);
        }
        return $this->db->get('personil p')->result_array();
    }

    function unit_kerja_distribusi() {
        $this->db->select('uk.id, uk.name');
        $this->db->join('personil p', 'p.id_unit_kerja = uk.id');
        $this->db->join('distribusi d', 'd.id_personil = p.id');
        $this->db->group_by('uk.id');
        return $this->db->get('unit_kerja uk')->result_array();
    }

}
