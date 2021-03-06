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

//    function distribusiDeleted($company, $standard) {
//        $this->db->select('uk.*, COUNT(d.id) AS doc, COUNT(j.id) AS imp');
//        $this->db->join('company c', 'c.id = uk.id_company AND c.id = ' . $company);
//        $this->db->join('personil p', 'p.id_unit_kerja = uk.id', 'LEFT');
//        $this->db->join('distribusi ds', 'ds.id_personil = p.id', 'LEFT');
//        $this->db->join('document d', 'd.id = ds.id_document', 'LEFT');
//        $this->db->join('pasal ps', 'ps.id = d.id_pasal AND ps.id_standard = ' . $standard);
//        $this->db->join('tugas t', 't.id_document = d.id', 'LEFT');
//        $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
//        $this->db->group_by('uk.id');
//        return $this->db->get('unit_kerja uk')->result_array();
//    }

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
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil AND pp.id_unit_kerja = '.$uk['id']);
            $this->db->join('document d', 'd.id = t.id_document');
            $this->db->join('pasal p', 'p.id = d.id_pasal AND p.id_standard = '.$standard);
            $unitKerja[$k]['imp'] = $this->db->count_all_results('jadwal j');
        }
        return $unitKerja;
    }

//    function distribusi($id_company, $id_standard) {
//        $arrResult = [];
//        $unitKerjas = $this->db->select('*')->from('unit_kerja')->where('id_company', $id_company)->get()->result();
//        foreach ($unitKerjas as $unitKerja) {
//            $personils = $this->db->select('*')->from('personil')->where('id_unit_kerja', $unitKerja->id)->get()->result();
//            $arrDocument = [];
//            $arrTugas = [];
//            $arrFormTerkait = [];
//            $arrJadwal = [];
//            foreach ($personils as $personil) {
//                $distribusis = $this->db->select('*')->from('distribusi')->where('id_personil', $personil->id)->distinct('id_document')->get()->result();
//                foreach ($distribusis as $distribusi) {
//                    if (!in_array($distribusi->id_document, $arrDocument)) {
//                        $document = $this->db->select('*')->from('document')->where('id', $distribusi->id_document)->get()->row();
//                        $pasal = $this->db->select('*')->from('pasal')->where('id', $document->id_pasal)->get()->row();
//                        if ($pasal->id_standard == $id_standard) {
//                            $arrDocument[] = $distribusi->id_document;
//                        }
//                    }
//                }
//                $penerimaTugases = $this->db->select('*')->from('penerima_tugas')->where('id_personil', $personil->id)->get()->result();
//                foreach ($penerimaTugases as $penerimaTugas) {
//                    $tugas = $this->db->select('*')->from('tugas')->where('id', $penerimaTugas->id_tugas)->get()->row();
//                    if (!in_array($tugas->form_terkait, $arrFormTerkait)) {
//                        $document = $this->db->select('*')->from('document')->where('id', $tugas->id_document)->get()->row();
//                        $pasal = $this->db->select('*')->from('pasal')->where('id', $document->id_pasal)->get()->row();
//                        if ($pasal->id_standard == $id_standard) {
//                            $arrTugas[] = $tugas->id;
//                        }
//                    }
//                    $arrFormTerkait[] = $tugas->form_terkait;
//                    $jadwals = $this->db->select('*')->from('jadwal')->where('id_tugas', $penerimaTugas->id_tugas)->get()->result();
//                    foreach ($jadwals as $jadwal) {
//                        if (!in_array($jadwal->id, $arrJadwal)) {
//                            $arrJadwal[] = $jadwal->id;
//                        }
//                    }
//                }
//            }
//            $countDocumentAndTugas = count($arrDocument) + count($arrTugas);
//            if ($countDocumentAndTugas > 0) {
//                $arrResult[] = [
//                    'name' => $unitKerja->name,
//                    'doc' => $countDocumentAndTugas,
//                    'imp' => count($arrJadwal),
//                ];
//            }
//        }
//        return $arrResult;
//    }
//    function listTugasDeleted($company, $standard) {
//        $this->db->select('p.fullname AS name, uk.name AS unit_kerja, t.nama AS tugas, ps.name AS pasal, j.tanggal, j.upload_date');
//        $this->db->join('tugas t', 't.id = j.id_tugas');
//        $this->db->join('penerima_tugas pt', 'pt.id_tugas = t.id');
//        $this->db->join('personil p', 'p.id = pt.id_personil');
//        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja AND uk.id_company = ' . $company);
//        $this->db->join('document d', 'd.id = t.id_document');
//        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
//        $this->db->join('pasal ps', 'ps.id = dp.id_pasal');
//        return $this->db->get('jadwal j')->result_array();
//    }

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
        if ($this->role == 'anggota') {
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
            $this->db->join('position_personil pp','pp.id = pt.id_position_personil');
            $this->db->join('personil p','p.id = pp.id_personil');
            $this->db->join('unit_kerja uk','uk.id = pp.id_unit_kerja');
            $this->db->where('id_tugas', $j['id_tugas']);
            $jadwal[$k]['pelaksana'] = $this->db->get('personil_task pt')->result_array();
        }
        return $jadwal;
    }

}
