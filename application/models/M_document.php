<?php

class M_document extends CI_Model {

    private $table = 'document';

    function search() {
        $this->db->select('d.*, pc.fullname, COUNT(ds.id) AS distribusi');
        $this->db->join('personil pc', 'pc.id = d.creator', 'LEFT');
        $this->db->join('pasal p', 'd.id_pasal = p.id');
        $this->db->join('standard s', 's.id = p.id_standard');
        $this->db->join('distribusi ds', 'd.id = ds.id_document', 'LEFT');
        if (isset($this->session->user['id_company'])) {
            $company = $this->session->user['id_company'];
        } else if ($this->input->get('perusahaan')) {
            $company = $this->input->get('perusahaan');
        }
        if (isset($company)) {
            $this->db->where('d.id_company', $company);
            if ($this->input->get('creator')) {
                $this->db->join('unit_kerja ukc', 'ukc.id = pc.id_unit_kerja');
                $this->db->join('company cc', 'cc.id = ukc.id_company');
                $this->db->where('cc.id', $company);
                $cr = explode('_', $this->input->get('creator'));
                if ($cr[0] == 'uk') {
                    $this->db->where('ukc.id', $cr[1]);
                } else if ($cr[0] == 'p') {
                    $this->db->where('pc.id', $cr[1]);
                }
            }
            if ($this->input->get('penerima')) {
                $this->db->join('personil pds', 'pds.id = ds.id_personil');
                $this->db->join('unit_kerja ukds', 'ukds.id = pds.id_unit_kerja');
                $cr = explode('_', $this->input->get('penerima'));
                if ($cr[0] == 'uk') {
                    $this->db->where('ukds.id', $cr[1]);
                } else if ($cr[0] == 'p') {
                    $this->db->where('pds.id', $cr[1]);
                }
            }
        }
        if ($this->input->get('standar')) {
            $this->db->where('s.id', $this->input->get('standar'));
            if ($this->input->get('pasal')) {
                $this->db->where('d.id_pasal', $this->input->get('pasal'));
            }
        }

        if ($this->input->get('judul')) {
            $this->db->like('d.judul', $this->input->get('judul'));
        }
        if ($this->input->get('nomor')) {
            $this->db->like('d.nomor', $this->input->get('nomor'));
        }
        if ($this->input->get('level')) {
            $this->db->where('d.jenis', $this->input->get('level'));
        }
        if ($this->input->get('klasifikasi')) {
            $this->db->where('d.klasifikasi', $this->input->get('klasifikasi'));
        }
        $this->db->group_by('d.id');
        return $this->db->get($this->table . ' d')->result_array();
    }

    function get($id) {//detail dokumen
        $this->db->select('d.*, u.username AS pembuat, d2.judul AS dokumen_terkait');
        $this->db->where('d.id', $id);
        $this->db->join('users u', 'u.id = d.creator', 'LEFT');
        $this->db->join($this->table . ' d2', 'd.contoh = d2.id', 'LEFT');
        return $this->db->get($this->table . ' d')->row_array();
    }

    function standar() {
        $this->db->select('s.id, s.name');
        $this->db->join('pasal p', 's.id = p.id_standard');
        $this->db->join($this->table . ' d', 'd.id_pasal = p.id');
        $this->db->group_by('s.id');
        return $this->db->get('standard s')->result_array();
    }

    function pasal($standar) {
        $this->db->where('p.id_standard', $standar);
        return $this->db->get('pasal p')->result_array();
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

    function creator($perusahaan) {
        $this->db->select('p.id_unit_kerja, uk.name AS unit_kerja, p.id, p.fullname');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
        $this->db->where('uk.id_company', $perusahaan);
        $this->db->order_by('p.id_unit_kerja');
        return $this->db->get('personil p')->result_array();
    }

}
