<?php

class M_document extends CI_Model {

    private $table = 'document';

    function search() {
        $this->db->select('d.*, pc.fullname, COUNT(ds.id) AS distribusi');
        $this->db->join('position_personil ppc', 'ppc.id = d.pembuat', 'LEFT');
        $this->db->join('personil pc', 'pc.id = ppc.id_personil', 'LEFT');
        $this->db->join('pasal p', 'd.id_pasal = p.id');
        $this->db->join('standard s', 's.id = p.id_standard');
        $this->db->join('distribution ds', 'ds.id_document = d.id', 'LEFT');
        if (isset($this->session->user['id_company'])) {
            $company = $this->session->user['id_company'];
        } else if ($this->input->get('perusahaan')) {
            $company = $this->input->get('perusahaan');
        }
        if (isset($company)) {
            $this->db->where('d.id_company', $company);
            if ($this->input->get('creator')) {
                $this->db->join('unit_kerja ukc', 'ukc.id = ppc.id_unit_kerja');
                $cr = explode('_', $this->input->get('creator'));
                if ($cr[0] == 'uk') {
                    $this->db->where('ukc.id', $cr[1]);
                } else if ($cr[0] == 'p') {
                    $this->db->where('ppc.id_personil', $cr[1]);
                }
            }
            if ($this->input->get('penerima')) {
                $this->db->join('position_personil ppds', 'ppds.id = ds.id_position_personil');
                $cr = explode('_', $this->input->get('penerima'));
                if ($cr[0] == 'uk') {
                    $this->db->join('unit_kerja ukds', 'ukds.id = ppds.id_unit_kerja');
                    $this->db->where('ukds.id', $cr[1]);
                } else if ($cr[0] == 'p') {
                    $this->db->join('personil pds', 'pds.id = ppds.id_personil');
                    $this->db->where('pds.id', $cr[1]);
                }
            }
            if ($this->session->user['role'] == 'anggota') {
                $this->db->join('position_personil ppds', 'ppds.id = ds.id_position_personil');
                $this->db->join('personil pds', 'pds.id = ppds.id_personil');
                $this->db->join('users uds', 'uds.id_personil = pds.id AND uds.id = ' . $this->session->user['id']);
            }
        }
        if ($this->input->get('pasal')) {
            $this->db->join('document_pasal dp', 'dp.id_document = d.id  AND dp.id_pasal = ' . $this->input->get('pasal'));
        } elseif ($this->input->get('standar')) {
            $this->db->where('s.id', $this->input->get('standar'));
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
        $this->db->select('d.*, p.fullname AS pembuat, d2.judul AS dokumen_terkait, 1 AS pasal');
        $this->db->where('d.id', $id);
        $this->db->join('position_personil pp', 'pp.id = d.pembuat', 'LEFT');
        $this->db->join('personil p', 'p.id = pp.id_personil', 'LEFT');
        $this->db->join($this->table . ' d2', 'd.contoh = d2.id', 'LEFT');
        $result = $this->db->get($this->table . ' d')->row_array();
        $this->db->select('p.*');
        $this->db->join('document_pasal dp', 'dp.id_pasal = p.id');
        $this->db->join('document d', 'd.id = dp.id_document');
        $this->db->where('d.id', $id);
        $pasal = $this->db->get('pasal p')->result_array();
        foreach ($pasal as $k => $v) {
            $pasal[$k]['fullname'] = $this->getPasalName($v['id']);
        }
        $result['pasal'] = $pasal;
        $this->db->select('p.fullname AS personil, uk.name AS unit_kerja');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->where('ds.id_document', $id);
        $result['dist'] = $this->db->get('distribution ds')->result_array();
        return $result;
    }

    function getPasalName($id) {
        $pasal = $this->db->get_where('pasal', ['id' => $id])->row_array();
        $name = '';
        if (!empty($pasal['parent'])) {
            $name = $this->getPasalName($pasal['parent']) . ' - ';
        }
        $name .= $pasal['name'];
        return $name;
    }

    function standar() {
        $this->db->select('s.id, s.name');
        if ($this->session->user['id_company']) {
            $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company=' . $this->session->user['id_company']);
        }
        return $this->db->get('standard s')->result_array();
    }

    function perusahaan() {
        return $this->db->get('company c')->result_array();
    }

    function creator($perusahaan) {
        $this->db->select('p.id_unit_kerja, uk.name AS unit_kerja, p.id, p.fullname');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
        $this->db->where('uk.id_company', $perusahaan);
        $this->db->order_by('p.id_unit_kerja');
        return $this->db->get('personil p')->result_array();
    }

    function personil($company) {
        $this->db->select('pp.id_unit_kerja, uk.name AS unit_kerja, pp.id_personil,p.id, p.fullname');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->where('p.id_company', $company);
        return $this->db->get('position_personil pp')->result_array();
    }

    function get_by_standard($company, $standard) {
        $this->db->where('id_company', $company);
        $this->db->where('id_standard', $standard);
        return $this->db->get('document')->result_array();
    }   

    function dokumen_saya(){
        $this->db->select('d.*');
        $this->db->join('distribution ds', 'ds.id_document = d.id');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil AND pp.id_personil='.$this->session->user['id_personil']);
        $this->db->group_by('d.id');
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
        return $this->db->get('document d')->result();
    }
    function dokumen_tugas() {
        $this->db->where('id_company', $this->session->activeCompany['id']);
        $this->db->where('id_standard', $this->session->activeStandard['id']);
        $this->db->where('jenis <>', 4);
        return $this->db->get('document')->result();
    }
    function form_terkait() {
        $this->db->where('id_standard', $this->session->activeStandard['id']);
        $this->db->where('id_company', $this->session->activeCompany['id']);
        $this->db->where('jenis', 4);
        return $this->db->get('document')->result();
    }
}
