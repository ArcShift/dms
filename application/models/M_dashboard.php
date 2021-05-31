<?php

use Illuminate\Support\Facades\DB;

class M_dashboard extends CI_Model {

    private $company;

    public function __construct() {
        parent::__construct();
        $this->company = $this->session->user['id_company'];
    }

    function count($table) {
        return $this->db->count_all($table);
    }

    function standard_active() {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id');
        if (!empty($this->company)) {
            $this->db->where('cs.id_company = ' . $this->company);
        }
        $this->db->group_by('s.id');
        return $this->db->count_all_results('standard s');
    }

    function company_standard($c) {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $c);
        return $this->db->get('standard s')->result_array();
    }

    function getDefaultStandard($company) {
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $company);
        return $this->db->get('standard s')->row_array();
    }

    function getPemenuhan($company, $standard, $unit_kerja = null, $personil= null) {
        $this->db->select('p.id, p.parent, p.name, h.persentase AS hope');
        $this->db->join('hope h', 'h.id_pasal = p.id', 'LEFT');
        $this->db->where('p.id_standard', $standard);
        $pasal = $this->db->get('pasal p')->result_array();
        foreach ($pasal as $k => $p) {
            $p['indexChild'] = [];
            if ($p['parent'] == null) {
                $p['indexParent'] = null;
            }
            foreach ($pasal as $k2 => $p2) {
                if ($p['id'] === $p2['parent']) {
                    $pasal[$k2]['indexParent'] = $k;
                    array_push($p['indexChild'], $k2);
                }
            }
            if (empty($pasal[$k]['hope'])) {
                $pasal[$k]['hope'] == 70;
            }
            //GET count DOC
            $this->db->join('document_pasal dp', 'dp.id_document = d.id AND dp.id_pasal = ' . $p['id']);
            $this->db->join('distribution ds', 'ds.id_document = d.id');
            if (!empty($unit_kerja)) {
                $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil AND pp.id_unit_kerja = ' . $unit_kerja);
            }elseif(!empty($personil)){
                $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil AND pp.id = ' . $personil);
            }
            $data = $this->db->get('document d')->result();
            $p['doc'] = count($data);
//            $p['que'] = $this->db->last_query();
//            GET COUNT IMP
            $this->db->select('COUNT(j.id) AS jd, SUM(IF(j.path IS NULL, 0, 1)) AS complete');
            $this->db->join('tugas t', 't.id = j.id_tugas');
            if (!empty($unit_kerja)) {
                $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
                $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil AND pp.id_unit_kerja = ' . $unit_kerja);
            }
            $this->db->join('document d', 'd.id = t.id_document');
            $this->db->join('document_pasal dp', 'dp.id_document = d.id AND dp.id_pasal = ' . $p['id']);
            $this->db->group_by('dp.id_pasal');
            $data = $this->db->get('jadwal j')->row();
            $p['jadwal'] = empty($data) ? '0' : $data->jd;
            $p['jadwal_ok'] = empty($data) ? '0' : $data->complete;
            $pasal[$k] = $p;
        }
        $this->pasal = $pasal;
        foreach ($pasal as $k => $p) {
            if ($p['parent'] == null) {
                $this->persentasePemenuhan2($k);
            }
        }
        return $this->pasal;
//        $this->db->select('p.id, p.name, p.parent, COUNT(p2.id) AS child,h.persentase AS hope, COUNT(DISTINCT d.id) AS doc, GROUP_CONCAT(DISTINCT d.id) AS docs, COUNT(DISTINCT t.id) AS tugas, COUNT(DISTINCT j.id) AS jadwal,  GROUP_CONCAT(DISTINCT j.id) AS jadwals, SUM(IF(j.upload_date <= j.tanggal AND j.upload_date IS NOT NULL,1,0)) AS jadwal_ok');
//        $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
//        $this->db->join('pasal_access pa', 'pa.id_pasal = p.id AND pa.id_company = ' . $company, 'LEFT');
//        $this->db->join('document_pasal dp', 'dp.id_pasal = p.id', 'LEFT');
//        $this->db->join('document d', 'd.id = dp.id_document AND d.id_company = ' . $company, 'LEFT');
//        $this->db->join('tugas t', 't.id_document = d.id', 'LEFT');
//        $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
//        $this->db->join('hope h', 'h.id_pasal = p.id', 'LEFT');
//        $this->db->where('p.id_standard', $standard);
//        $this->db->where('pa.status IS NULL');
//        $this->db->or_where('pa.status', 'ENABLE');
//        $this->db->order_by('p.id');
//        $this->db->group_by('p.id, p.parent, h.persentase');
//        $pasal = $this->db->get('pasal p')->result_array();
//        foreach ($pasal as $k => $p) {
//            $pasal[$k]['indexChild'] = [];
//            if ($pasal[$k]['parent'] == null) {
//                $pasal[$k]['indexParent'] = null;
//            }
//            foreach ($pasal as $k2 => $p2) {
//                if ($p['id'] === $p2['parent']) {
//                    $pasal[$k2]['indexParent'] = $k;
//                    array_push($pasal[$k]['indexChild'], $k2);
//                }
//            }
//            if (empty($pasal[$k]['hope'])) {
//                $pasal[$k]['hope'] == 70;
//            }
//        }
//        $this->pasal = $pasal;
//        foreach ($this->pasal as $k => $p) {
//            if ($p['parent'] == null) {
//                $this->persentasePemenuhan($k);
//            }
//        }
//        return $this->pasal;
    }

    private function persentasePemenuhan2($index) {
        $p = $this->pasal[$index];
        $pemenuhanDoc = 0;
        $pemenuhanImp = 0;
        $impStatus = false;
        if (!empty($p['indexChild'])) {
            foreach ($p['indexChild'] as $k => $c) {
                $this->persentasePemenuhan2($c);
                $pemenuhanDoc += $this->pasal[$c]['pemenuhanDoc'];
                $pemenuhanImp += $this->pasal[$c]['pemenuhanImp'];
                if ($this->pasal[$c]['impStatus']) {
                    $impStatus = true;
                }
            }
            $pemenuhanDoc = round($pemenuhanDoc / count($p['indexChild']), 2);
            $pemenuhanImp = round($pemenuhanImp / count($p['indexChild']), 2);
            $this->pasal[$index]['doc'] = '';
        } else {
            if ($p['doc'] != 0) {
                $pemenuhanDoc = 100;
                if ($p['jadwal'] != 0) {
                    $impStatus = true;
                }
            }
            if ($p['jadwal_ok'] != 0) {
                $pemenuhanImp = round($p['jadwal_ok'] * 100 / $p['jadwal'], 2);
            }
        }
        $this->pasal[$index]['pemenuhanDoc'] = $pemenuhanDoc;
        $this->pasal[$index]['pemenuhanImp'] = 0;
        $this->pasal[$index]['pemenuhanImp'] = $pemenuhanImp;
        $this->pasal[$index]['impStatus'] = $impStatus;
    }

    private function persentasePemenuhan($index) {
        $p = $this->pasal[$index];
        $pemenuhanDoc = 0;
        $pemenuhanImp = 0;
        $impStatus = false;
        if (!empty($p['indexChild'])) {
            foreach ($p['indexChild'] as $k => $c) {
                $this->persentasePemenuhan($c);
                $pemenuhanDoc += $this->pasal[$c]['pemenuhanDoc'];
                $pemenuhanImp += $this->pasal[$c]['pemenuhanImp'];
                if ($this->pasal[$c]['impStatus']) {
                    $impStatus = true;
                }
            }
            $pemenuhanDoc = round($pemenuhanDoc / count($p['indexChild']), 2);
            $pemenuhanImp = round($pemenuhanImp / count($p['indexChild']), 2);
            $this->pasal[$index]['doc'] = '';
        } else {
            if ($p['doc'] != 0) {
                $pemenuhanDoc = 100;
                if ($p['jadwal'] != 0) {
                    $impStatus = true;
                }
            }
            if ($p['jadwal_ok'] != 0) {
                $pemenuhanImp = round($p['jadwal_ok'] * 100 / $p['jadwal'], 2);
            }
        }
        $this->pasal[$index]['pemenuhanDoc'] = $pemenuhanDoc;
        $this->pasal[$index]['pemenuhanImp'] = $pemenuhanImp;
        $this->pasal[$index]['impStatus'] = $impStatus;
    }

    function distribusi2($company, $standard) {
        $unitKerja = $this->db->where('id_company', $company)->get('unit_kerja')->result_array();
        foreach ($unitKerja as $k => $uk) {
            $this->db->select('COUNT(DISTINCT d.id) AS doc, COUNT(DISTINCT j.id) AS imp');
            $this->db->join('tugas t', 't.id_document = d.id', 'LEFT');
            $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
            $this->db->join('distribution ds', 'ds.id_document = d.id');
            $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil', 'LEFT');
            $this->db->join('pasal p', 'p.id = d.id_pasal', 'LEFT');
            $this->db->where('d.id_company', $company);
            $this->db->where('pp.id_unit_kerja', $uk['id']);
            $this->db->where('p.id_standard', $standard);
            $doc = $this->db->get('document d')->row_array();
            $unitKerja[$k]['doc'] = $doc['doc'];
//            $unitKerja[$k]['imp'] = $doc['imp'];
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil AND pp.id_unit_kerja = ' . $uk['id']);
            $this->db->join('document d', 'd.id = t.id_document');
            $this->db->join('pasal p', 'p.id = d.id_pasal AND p.id_standard = ' . $standard);
            $unitKerja[$k]['imp'] = $this->db->count_all_results('jadwal j');
        }
        return $unitKerja;
    }

    function listTugas($company, $standard, $periode_tugas) {
        $this->db->select('p.fullname AS name, u.photo, uk.name AS unit_kerja, t.nama AS tugas, ps.name AS pasal, j.tanggal, j.upload_date, j.id AS id_jadwal, d.judul, t.id AS id_tugas, t.sifat, d.file, d.url');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja AND uk.id_company = ' . $company);
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
        $this->db->join('pasal ps', 'ps.id = dp.id_pasal AND ps.id_standard = ' . $standard);
        if ($this->session->user['role'] == 'anggota') {
            $this->db->where('p.id', $this->session->user['id_personil']);
        }
        switch ($periode_tugas) {
            case 'hari':
                $this->db->where('tanggal', date('Y-m-d'));
                break;
            case 'minggu':
                $this->db->where('tanggal >=', date('Y-m-d'));
                $this->db->where('tanggal <=', date('Y-m-d', strtotime('+7 days')));
                break;
            case 'bulan':
                $this->db->where('MONTH(tanggal)', date('m'));
                $this->db->where('YEAR(tanggal)', date('Y'));
                break;
        }
        $this->db->group_by('j.id, p.fullname, u.photo, uk.name, t.nama, ps.name, j.tanggal, j.upload_date, d.judul, t.id, t.sifat, d.file, d.url');
        $jadwal = $this->db->get('jadwal j')->result_array();
        foreach ($jadwal as $k => $j) {
            $this->db->select('p.fullname AS nama, uk.name AS unit_kerja');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
            $this->db->where('id_tugas', $j['id_tugas']);
            $jadwal[$k]['pelaksana'] = $this->db->get('personil_task pt')->result_array();
        }
        return $jadwal;
    }

}
