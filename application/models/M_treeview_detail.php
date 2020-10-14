<?php

class M_treeview_detail extends CI_Model {

    private $table = 'pasal';

    function standard() {
        $this->db->select('s.id, s.name');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company=' . $this->input->post('id'));
        return $this->db->get('standard s')->result_array();
    }

    function detail() {
        $input = $this->input->post();
        $this->db->select('p.*, f.description');
        $this->db->where('p.id', $input['idPasal']);
        $this->db->join('form2 f', 'f.id_pasal= p.id AND f.id_company=' . $input['idPerusahaan'], 'LEFT');
        return $this->db->get($this->table . ' p')->row_array();
    }

    function member() {
        $this->db->select('u.id, u.username, CONCAT(u.username, " - ", uk.name) AS fullname');
//        $this->db->select('p.id, p.fullname AS name, CONCAT(p.fullname, " - ", uk.name) AS fullname');
        $this->db->join('personil p', 'p.id=u.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id=p.id_unit_kerja');
//        $this->db->join('role r', 'r.id=u.id_role AND r.name = "anggota"');
//        $this->db->join('schedule s', 's.id_user=u.id AND m.id_pasal=' . $input['idPasal'], 'LEFT');
        $this->db->where('uk.id_company', $this->input->post('perusahaan'));
        return $this->db->get('users u')->result_array();
    }

    function personil() {
        $this->db->select('p.id, p.id_unit_kerja, CONCAT(p.fullname, " - ", uk.name) AS fullname');
        $this->db->join('unit_kerja uk', 'uk.id=p.id_unit_kerja');
        $this->db->where('uk.id_company', $this->input->post('perusahaan'));
        return $this->db->get('personil p')->result_array();
    }

    function unit_kerja() {
        $this->db->select('uk.id, uk.name');
        $this->db->where('uk.id_company', $this->input->post('perusahaan'));
        return $this->db->get('unit_kerja uk')->result_array();
    }

    function pasal() {
        $this->db->select('p.*, COUNT(p2.id) AS child, COUNT(d.id) AS doc');
        $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
        $this->db->join('document d', 'd.id_pasal = p.id', 'LEFT');
        $this->db->where('p.id_standard', $this->input->get('standar'));
        $this->db->group_by('p.id');
        return $this->db->get('pasal p')->result_array();
    }

    function create_document() {
        $this->db->set('id_pasal', $this->input->post('pasal'));
        $this->db->set('nomor', $this->input->post('nomor'));
        $this->db->set('judul', $this->input->post('judul'));
        $this->db->set('creator', $this->input->post('creator'));
        $this->db->set('jenis', $this->input->post('jenis'));
        $this->db->set('klasifikasi', $this->input->post('klasifikasi'));
        $this->db->set('deskripsi', $this->input->post('deskripsi'));
        $this->db->set('versi', $this->input->post('versi'));
        if (!empty($this->input->post('dokumen_terkait'))) {
            $this->db->set('contoh', $this->input->post('dokumen_terkait'));
        }
        if ($this->input->post('id')) {
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('document');
        } else {
            $type = $this->input->post('type_dokumen');
            $this->db->set('type_doc', $type);
            if ($type == 'FILE') {
                $this->db->set('file', $this->upload->data()['file_name']);
            } else if ($type == 'URL') {
                $this->db->set('url', $this->input->post('url'));
            }
            return $this->db->insert('document');
        }
    }

    function read_document() {
        $this->db->select("d.*, GROUP_CONCAT(ds.id) AS distribusi, GROUP_CONCAT(pld.id) AS personil_distribusi_id, GROUP_CONCAT(CONCAT(pld.fullname,' - ', ukd.name)) AS user_distribusi");
        $this->db->join('pasal p', 'p.id = d.id_pasal');
        $this->db->join('users u', 'u.id = d.creator');
        $this->db->join('personil pl', 'pl.id = u.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pl.id_unit_kerja');
        $this->db->join('distribusi ds', 'd.id = ds.id_document', 'LEFT');
        $this->db->join('personil pld', 'pld.id = ds.id_personil', 'LEFT');
        $this->db->join('unit_kerja ukd', 'ukd.id = pld.id_unit_kerja', 'LEFT');
        $this->db->where('uk.id_company = ' . $this->input->post('perusahaan'));
        $this->db->where('p.id_standard = ' . $this->input->post('standar'));
        $this->db->order_by('p.id');
        $this->db->group_by('d.id');
        $result = $this->db->get('document d')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['distribusi'] = explode(',', $result[$i]['distribusi']);
            $result[$i]['user_distribusi'] = explode(',', $result[$i]['user_distribusi']);
            $result[$i]['personil_distribusi_id'] = explode(',', $result[$i]['personil_distribusi_id']);
        }
        return $result;
    }

    function delete_document() {
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->get('document')->row_array();
        $this->db->where('id', $this->input->post('id'));
        if ($this->db->delete('document') & !empty($result['file'])) {
            unlink(FCPATH . 'upload\\dokumen\\' . $result['file']);
            return true;
        }
        return false;
    }

    function read_distribusi() {
        $this->db->select('ds.*');
        $this->db->join('document dc', 'dc.id = ds.id_document');
        $this->db->join('pasal p', 'p.id = dc.id_pasal');
        $this->db->join('personil ps', 'ps.id = ds.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = ps.id_unit_kerja', 'LEFT');
        $this->db->where('uk.id_company = ' . $this->input->post('perusahaan'));
        $this->db->where('p.id_standard = ' . $this->input->post('standar'));
        return $this->db->get('distribusi ds')->result_array();
    }

    function insert_distribusi() {
        $in = $this->input->post();
        foreach ($in['personil'] as $p) {
            $this->db->where('id_document', $in['dokumen']);
            $this->db->where('id_personil', $p);
            $count = $this->db->count_all_results('distribusi');
            if ($count == 0) {
                $this->db->set('id_document', $in['dokumen']);
                $this->db->set('id_personil', $p);
                if (!$this->db->insert('distribusi')) {
                    return false;
                }
            }
        }
        return true;
    }

    function delete_distribusi() {
        $this->db->where('id', $this->input->post('id'));
        return $this->db->delete('distribusi');
    }

    function reads_schedule() {
        $this->db->select("s.id, s.date, s.upload_date, u.username AS name, uk.name AS division, s.file, p.id AS id_pasal");
        $this->db->join('form2 f', 'f.id = s.id_form2');
        $this->db->join('pasal p', 'p.id = f.id_pasal');
        $this->db->join('standard st', 'st.id = p.id_standard AND st.id = ' . $this->input->post('idStandar'));
        $this->db->join('users u', 'u.id = s.id_user');
        $this->db->join('unit_kerja uk', 'uk.id = u.id_unit_kerja');
        $this->db->join('company c', 'c.id = uk.id_company AND c.id = ' . $this->input->post('idPerusahaan'));
        $this->db->order_by('p.id, s.date');
        $result = $this->db->get('schedule s')->result_array();
        $idPasal = 0;
        foreach ($result as $k => $r) {
            if ($r['date'] < date('Y-m-d')) {
                $result[$k]['deadline'] = true;
            } else {
                $result[$k]['deadline'] = false;
            }
//            $this->db->select('SUM(CASE WHEN s.date < CURDATE() AND s.file IS NULL THEN 1 ELSE 0 END) AS terlambat'); //UNFIX
//            $this->db->select('SUM(CASE WHEN s.file IS NOT NULL AND s.date < s.upload_date THEN 1 ELSE 0 END) AS terlambat2'); //UNFIX
            if (!empty($r['file']) & !empty($r['date']) & $r['date'] >= $r['upload_date']) {
                $result[$k]['status'] = 'selesai';
            } else if (empty($r['upload_date']) & $r['date'] >= date('Y-m-d')) {
                $result[$k]['status'] = '-';
            } else {
                $result[$k]['status'] = 'terlambat';
            }
            //PASAL FULLNAME
            if ($idPasal != $r['id_pasal']) {
                $idPasal = $r['id_pasal'];
                $result[$k]['pasal'] = $this->pasal_fullname($r['id_pasal']);
            } else {
                $result[$k]['pasal'] = '';
            }
        }
        return $result;
    }

    function getJadwal() {
        $this->db->select('j.*, p.fullname');
        $this->db->join('distribusi d','d.id= j.id_distribusi', 'LEFT');
        $this->db->join('personil p','p.id= d.id_personil', 'LEFT');
        return $this->db->get('jadwal j')->result_array();
    }

    function create_jadwal() {
        $data = [];
        $data['repeat'] = $this->input->post('ulangi');
        $data['desc'] = $this->input->post('desc');
        if ($dist = $this->input->post('dist')) {
            foreach ($dist as $d) {
                $data['id_distribusi'] = $d;
                $this->create_jadwal_data($data);
            }
        } else {
            $data['id_document'] = $this->input->post('dokumen_id');
            $this->create_jadwal_data($data);
        }
        return true;
    }

    private function create_jadwal_data($data) {
        if ($this->input->post('ulangi') == 'YA') {
            $day = array('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu');
            foreach ($day as $d) {
                $dy = 'TIDAK';
                if ($this->input->post('hari')) {
                    if (in_array(strtoupper($d), $this->input->post('hari'))) {
                        $dy = 'YA';
                    }
                }
                $data[$d] = $dy;
            }
            $data['date'] = $this->input->post('tanggal')[0];
            $data['date_end'] = $this->input->post('tanggal_selesai');
            $this->db->insert('jadwal', $data);
        } else if ($this->input->post('ulangi') == 'TIDAK') {
            foreach ($this->input->post('tanggal') as $tgl) {
                $data['date'] = $tgl;
                $this->db->insert('jadwal', $data);
            }
        }
        return true;
    }

    function upload_bukti() {
        $this->db->set('id_distribusi', $this->input->post('id'));
        $type = $this->input->post('type_dokumen');
        $this->db->set('type_doc', $type);
        if ($type == 'FILE') {
            $url = $this->upload->data()['file_name'];
            $this->db->set('url', $this->upload->data()['file_name']);
        } else if ($type == 'URL') {
            $this->db->set('url', $this->input->post('url'));
        }
        return $this->db->insert('upload_bukti');
    }

}
