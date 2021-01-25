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
        $this->db->select('p.*, COUNT(p2.id) AS child');
        $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
        $this->db->where('p.id_standard', $this->input->get('standar'));
        $this->db->group_by('p.id');
        return $this->db->get('pasal p')->result_array();
    }

    function create_document() {
        $this->db->set('id_pasal', $this->input->post('pasal'));
        $this->db->set('nomor', $this->input->post('nomor'));
        $this->db->set('judul', $this->input->post('judul'));
        if ($this->input->post('company')) {
            $this->db->set('id_company', $this->input->post('company'));
        }
        if ($this->input->post('creator')) {
            $this->db->set('creator', $this->input->post('creator'));
        } else {
            $this->db->set('creator', null);
        }
        $this->db->set('jenis', $this->input->post('jenis'));
        $this->db->set('klasifikasi', $this->input->post('klasifikasi'));
        $this->db->set('deskripsi', $this->input->post('desc'));
        $this->db->set('versi', $this->input->post('versi'));
        if (!empty($this->input->post('dokumen_terkait'))) {
            $this->db->set('contoh', $this->input->post('dokumen_terkait'));
        }
        $type = $this->input->post('type_dokumen');
        if (!empty($type)) {
            $this->db->set('type_doc', $type);
            if ($type == 'FILE' & !empty($_FILES['dokumen']['name'])) {
                $this->db->set('file', $this->upload->data()['file_name']);
            } else if ($type == 'URL' & !empty($this->input->post('url'))) {
                $this->db->set('url', $this->input->post('url'));
            }
        }
        if ($this->input->post('id')) {
            $this->db->where('id', $this->input->post('id'));
            if ($this->db->update('document')) {
                if ($this->editDokumenPasal()) {
                    return $this->editDocumentTerkait();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            if ($this->db->insert('document')) {
                $id_document = $this->db->insert_id();
                if (!empty($this->input->post('pasals'))) {
                    foreach ($this->input->post('pasals') as $k => $p) {
                        $this->db->set('id_document', $id_document);
                        $this->db->set('id_pasal', $p);
                        if (!$this->db->insert('document_pasal')) {
                            return false;
                        }
                    }
                }
            } else {
                return false;
            }
        }
        return true;
    }

    private function editDokumenPasal() {
        $document = $this->input->post('id');
        $input = $this->input->post('pasals');
        $this->db->where('id_document', $document);
        $result = $this->db->get('document_pasal')->result_array();
        $db = [];
        foreach ($result as $r) {
            array_push($db, $r['id_pasal']);
        }
        $remove = array_diff($db, $input);
        $add = array_diff($input, $db);
        $data = [];
        $data['remove'] = $remove;
        $data['add'] = $add;
        $data['current'] = array_intersect($db, $input);
        foreach ($remove as $r) {
            $this->db->where('id_document', $document);
            $this->db->where('id_pasal', $r);
            $this->db->delete('document_pasal');
        }
        foreach ($add as $a) {
            $this->db->set('id_document', $document);
            $this->db->set('id_pasal', $a);
            $this->db->insert('document_pasal');
        }
        return true;
    }

    private function editDocumentTerkait() {
        $document = $this->input->post('id');
        if (!empty($this->input->post('documents'))) {
            $input = $this->input->post('documents');
            $this->db->where('induk', $document);
            $result = $this->db->get('document_terkait')->result_array();
            $db = [];
            foreach ($result as $r) {
                array_push($db, $r['terkait']);
            }
            $remove = array_diff($db, $input);
            $add = array_diff($input, $db);
            $data = [];
            $data['remove'] = $remove;
            $data['add'] = $add;
            $data['current'] = array_intersect($db, $input);
            foreach ($remove as $r) {
                $this->db->where('induk', $document);
                $this->db->where('terkait', $r);
                $this->db->delete('document_terkait');
            }
            foreach ($add as $a) {
                $this->db->set('induk', $document);
                $this->db->set('terkait', $a);
                $this->db->insert('document_terkait');
            }
        } else {//remove all data
            $this->db->where('induk', $document);
            return $this->db->delete('document_terkait');
        }
        return true;
    }

    function read_document() {
        $this->db->select("d.*, COUNT(DISTINCT cd.id) AS child_document,GROUP_CONCAT(DISTINCT dt.terkait) AS document_terkait, GROUP_CONCAT(DISTINCT dp.id_pasal) AS dokumen_pasal, GROUP_CONCAT(DISTINCT ds.id) AS distribusi, GROUP_CONCAT(DISTINCT pld.id) AS personil_distribusi_id, GROUP_CONCAT(DISTINCT CONCAT(pld.fullname,' - ', ukd.name)) AS user_distribusi");
        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
        $this->db->join('pasal p', 'p.id = dp.id_pasal');
        $this->db->join('document cd', 'cd.contoh = d.id', 'LEFT');
        $this->db->join('users u', 'u.id = d.creator', 'LEFT');
        $this->db->join('company c', 'c.id = d.id_company', 'LEFT');
        $this->db->join('personil pl', 'pl.id = u.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = pl.id_unit_kerja', 'LEFT');
        $this->db->join('distribusi ds', 'd.id = ds.id_document', 'LEFT');
        $this->db->join('personil pld', 'pld.id = ds.id_personil', 'LEFT');
        $this->db->join('unit_kerja ukd', 'ukd.id = pld.id_unit_kerja', 'LEFT');
        $this->db->join('document_terkait dt', 'dt.induk = d.id', 'LEFT');
        $this->db->where('d.id_company = ' . $this->input->get('perusahaan'));
        $this->db->where('p.id_standard = ' . $this->input->get('standar'));
        $this->db->group_by('d.id');
        $result = $this->db->get('document d')->result_array();
        $fields = ['distribusi', 'user_distribusi', 'personil_distribusi_id', 'dokumen_pasal', 'document_terkait'];
        for ($i = 0; $i < count($result); $i++) {
            foreach ($fields as $f) {
                $result[$i][$f] = explode(',', $result[$i][$f]);
                if ($result[$i][$f][0] == '') {
                    $result[$i][$f] = [];
                }
            }
        }
        return $result;
    }

    function delete_document() {
        $id = $this->input->post('id');
        $this->db->where('id_document', $id);
        $result = $this->db->get('tugas')->result_array();
        //jadwal & penerima tugas
        foreach ($result as $k => $r) {
            $this->db->where('id_tugas', $r['id']);
            $this->db->delete('jadwal');
            $this->db->where('id_tugas', $r['id']);
            $this->db->delete('penerima_tugas');
        }
        $this->db->where('id_document', $id);
        $this->db->delete('tugas');
        $this->db->where('form_terkait', $id);
        $this->db->set('form_terkait', null);
        $this->db->update('tugas');
        //Distribusi
        $this->db->where('id_document', $id);
        $this->db->delete('distribusi');
        //Dokumen Terkait
        $this->db->where('contoh', $id);
        $this->db->set('contoh', null);
        $this->db->update('document');
        $this->db->where('induk', $id);
        $this->db->or_where('terkait', $id);
        $this->db->delete('document_terkait');
        //Dokumen Pasal & dokumen
        $this->db->where('id_document', $id);
        if ($this->db->delete('document_pasal')) {
            $this->db->where('id', $id);
            if ($this->db->delete('document') & !empty($result['file'])) {
                unlink(FCPATH . 'upload\\dokumen\\' . $result['file']);
                return true;
            }
        }
//        }
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
        foreach ($in['dist'] as $p) {
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

    function readsTugas() {
        $this->db->select('t.*, GROUP_CONCAT(DISTINCT pt.id_personil) AS personil');
        $this->db->join('document d', 'd.id = t.id_document AND d.id_company = ' . $this->input->get('perusahaan'));
        $this->db->join('pasal p', 'p.id = d.id_pasal AND p.id_standard = ' . $this->input->get('standar'));
        $this->db->join('penerima_tugas pt', 'pt.id_tugas = t.id', 'LEFT');
        $this->db->group_by('t.id');
        $result = $this->db->get('tugas t')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['personil'] = explode(',', $result[$i]['personil']);
            if ($result[$i]['personil'][0] == '') {
                $result[$i]['personil'] = [];
            }
        }
        return $result;
    }

    function tugas() {
        $this->db->set('id_document', $this->input->post('id-document'));
        $this->db->set('nama', $this->input->post('tugas'));
        $this->db->set('sifat', $this->input->post('sifat'));
        if ($this->input->post('form_terkait')) {
            $this->db->set('form_terkait', $this->input->post('form_terkait'));
        }
        if ($this->input->post('delete-id')) {//DELETE
            //DELETE pic PELAKSANA 
            $this->db->where('id_tugas', $this->input->post('delete-id'));
            if ($this->db->delete('penerima_tugas')) {
                $this->db->where('id', $this->input->post('delete-id'));
                return $this->db->delete('tugas');
            }
            return false;
        } else if ($this->input->post('id')) {//UPDATE
            $this->db->where('id', $this->input->post('id'));
            if ($this->db->update('tugas')) {
                return $this->editPenerima();
            } else {
                return false;
            }
        } else {//CREATE
            if ($this->db->insert('tugas')) {
                $id_tugas = $this->db->insert_id();
                if (!empty($this->input->post('penerima'))) {
                    foreach ($this->input->post('penerima') as $p) {
                        $this->db->set('id_tugas', $id_tugas);
                        $this->db->set('id_personil', $p);
                        if (!$this->db->insert('penerima_tugas')) {
                            return false;
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        }
    }

    private function editPenerima() {
        $id_tugas = $this->input->post('id');
        if (!empty($this->input->post('penerima'))) {
            $input = $this->input->post('penerima');
            $this->db->where('id_tugas', $id_tugas);
            $result = $this->db->get('penerima_tugas')->result_array();
            $db = [];
            foreach ($result as $r) {
                array_push($db, $r['id_personil']);
            }
            $remove = array_diff($db, $input);
            $add = array_diff($input, $db);
            foreach ($remove as $r) {
                $this->db->where('id_tugas', $id_tugas);
                $this->db->where('id_personil', $r);
                $this->db->delete('penerima_tugas');
            }
            foreach ($add as $a) {
                $this->db->set('id_tugas', $id_tugas);
                $this->db->set('id_personil', $a);
                $this->db->insert('penerima_tugas');
            }
        } else {//remove all data
            $this->db->where('id_tugas', $id_tugas);
            return $this->db->delete('penerima_tugas');
        }
        return true;
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
        return $this->db->get('jadwal')->result_array();
    }

    function getImplementasi() {
        $this->db->select("i.*, DATEDIFF(date_jadwal, upload_date)AS terlambat, GROUP_CONCAT(p.id) AS personil_id,GROUP_CONCAT(pi.id) AS personil_implementasi_id, GROUP_CONCAT(CONCAT(p.fullname,' - ',uk.name)) AS personil_name");
        $this->db->join('personil_implementasi pi', 'pi.id_implementasi = i.id', 'LEFT');
        $this->db->join('personil p', 'p.id = pi.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja', 'LEFT');
        $this->db->group_by('i.id');
        $result = $this->db->get('implementasi i')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['personil_id'] = explode(',', $result[$i]['personil_id']);
            $result[$i]['personil_name'] = explode(',', $result[$i]['personil_name']);
            $result[$i]['personil_implementasi_id'] = explode(',', $result[$i]['personil_implementasi_id']);
        }
        return $result;
    }

    function insertSchedule() {
        if ($this->input->post('ulangi') == 'YA') {
            $day = array('minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu');
            $tgl = date_create_from_format('d-m-Y', $this->input->post('tanggal')[0]);
            while ($tgl <= date_create_from_format('d-m-Y', $this->input->post('tanggal_selesai'))) {
                if (in_array(strtoupper($day[$tgl->format('w')]), $this->input->post('hari'))) {
                    $this->db->set('id_tugas', $this->input->post('id-tugas'));
                    $this->db->set('tanggal', $tgl->format('Y-m-d'));
                    $this->db->set('periode', $this->input->post('periode'));
                    $this->db->insert('jadwal');
                }
                $tgl->add(new DateInterval('P1D'));
//                $tgl = strtotime('+1 days', $tgl);
            }
        } else if ($this->input->post('ulangi') == 'TIDAK') {
            foreach ($this->input->post('tanggal') as $tgl) {
                $this->db->set('id_tugas', $this->input->post('id-tugas'));
                $this->db->set('tanggal', date("Y-m-d", strtotime($tgl)));
                $this->db->insert('jadwal');
            }
        }
        return true;
    }

    function schedule() {
        if ($this->input->post('id-delete')) {
            $this->db->where('id', $this->input->post('id-delete'));
            return $this->db->delete('jadwal');
        } else if ($this->input->post('id')) {
            $this->db->set('tanggal', date("Y-m-d", strtotime($this->input->post('tanggal'))));
            $this->db->set('periode', $this->input->post('periode'));
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('jadwal');
        }
        die('id not found');
    }

    function insert_jadwal() {//TODO: remove later
        $data = [];
        $data['repeat'] = $this->input->post('ulangi');
        $data['id_document'] = $this->input->post('dokumen_id');
        $data['start_date'] = date("Y-m-d", strtotime($this->input->post('tanggal')[0]));
        if ($this->input->post('ulangi') == 'YA') {
            $day = array('minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu');
            foreach ($day as $d) {
                $dy = 'TIDAK';
                if ($this->input->post('hari')) {
                    if (in_array(strtoupper($d), $this->input->post('hari'))) {
                        $dy = 'YA';
                    }
                }
                $data[$d] = $dy;
            }
            $data['end_date'] = date("Y-m-d", strtotime($this->input->post('tanggal_selesai')));
            $data['periode'] = $this->input->post('periode');
            $this->db->insert('jadwal', $data);
            $id = $this->db->insert_id();
            $tgl = strtotime($data['start_date']);
            while ($tgl <= strtotime($data['end_date'])) {
                if (in_array(strtoupper($day[date('w', $tgl)]), $this->input->post('hari'))) {
                    $this->insert_implementasi($id, date("Y-m-d", $tgl));
                }
                $tgl = strtotime('+1 days', $tgl);
            }
        } else if ($this->input->post('ulangi') == 'TIDAK') {
            $this->db->insert('jadwal', $data);
            $id = $this->db->insert_id();
            foreach ($this->input->post('tanggal') as $tgl) {
                $this->insert_implementasi($id, date("Y-m-d", strtotime($tgl)));
            }
        }
        return true;
    }

    private function insert_implementasi($id_jadwal, $tgl) {
        $data['desc'] = $this->input->post('desc');
        $data['date_jadwal'] = $tgl;
        $data['id_jadwal'] = $id_jadwal;
        $data['form'] = $this->input->post('form');
        $this->db->insert('implementasi', $data);
        $id = $this->db->insert_id();
        $this->insert_personil_jadwal($id);
        return true;
    }

    private function insert_personil_jadwal($id_implementasi) {
        $data = ['id_implementasi' => $id_implementasi];
        if ($dist = $this->input->post('dist')) {
            foreach ($dist as $d) {
                $data['id_personil'] = $d;
                $this->db->insert('personil_implementasi', $data);
            }
        }
        return true;
    }

    function update_jadwal() {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->set('desc', $this->input->post('desc'));
        $this->db->set('form', $this->input->post('form'));
        $this->db->set('date_jadwal', date("Y-m-d", strtotime($this->input->post('tanggal'))));
        $this->db->update('implementasi');
        foreach ($this->input->post('dist') as $dist) {
            $this->db->where('id_implementasi', $id);
            $this->db->where('id_personil', $dist);
            if (!count($this->db->get('personil_implementasi')->result_array())) {
                $this->db->set('id_implementasi', $id);
                $this->db->set('id_personil', $dist);
                $this->db->insert('personil_implementasi');
            }
        }
        return true;
    }

    function deleteJadwal() {
        $id = $this->input->post('id');
        $this->db->where('id_implementasi', $id);
        $this->db->delete('personil_implementasi');
        $this->db->where('id', $id);
        $this->db->delete('implementasi');
        return true;
    }

    function upload_bukti() {
        $this->db->where('id', $this->input->post('id'));
        $j = $this->db->get('jadwal')->row_array();
        $type = $this->input->post('type_dokumen');
        $this->db->set('doc_type', $type);
        if ($type == 'FILE') {
            $url = $this->upload->data()['file_name'];
            $this->db->set('path', $this->upload->data()['file_name']);
        } else if ($type == 'URL') {
            $this->db->set('path', $this->input->post('url'));
        }
        if (empty($j['upload_date'])) {
            $this->db->set('upload_date', date('Y-m-d'));
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('jadwal');
    }

    private $pasal = [];

    function getPemenuhan() {
        $this->db->select('p.*,COUNT(p2.id) AS child, COUNT(dp.id) AS doc, GROUP_CONCAT(DISTINCT d.id) AS docs, COUNT(DISTINCT t.id) AS tugas, COUNT(DISTINCT j.id) AS jadwal,  GROUP_CONCAT(DISTINCT j.id) AS jadwals, SUM(IF(j.upload_date <= j.tanggal AND j.upload_date IS NOT NULL,1,0)) AS jadwal_ok');
        $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
        $this->db->join('document_pasal dp', 'dp.id_pasal = p.id', 'LEFT');
        $this->db->join('document d', 'd.id = dp.id_document AND d.id_company = ' . $this->input->get('company'), 'LEFT');
        $this->db->join('tugas t', 't.id_document = d.id', 'LEFT');
        $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
        $this->db->where('p.id_standard', $this->input->get('standard'));
        $this->db->order_by('p.sort_index');
        $this->db->group_by('p.sort_index');
        $pasal = $this->db->get('pasal p')->result_array();
        foreach ($pasal as $k => $p) {
            $pasal[$k]['indexChild'] = [];
            if ($pasal[$k]['parent'] == null) {
                $pasal[$k]['indexParent'] = null;
            }
            foreach ($pasal as $k2 => $p2) {
                if ($p['id'] === $p2['parent']) {
                    $pasal[$k2]['indexParent'] = $k;
                    array_push($pasal[$k]['indexChild'], $k2);
                }
            }
        }
        $this->pasal = $pasal;
        foreach ($this->pasal as $k => $p) {
            if ($p['parent'] == null) {
                $this->persentasePemenuhan($k);
            }
        }
        return $this->pasal;
    }

    function persentasePemenuhan($index) {
        $p = $this->pasal[$index];
        $pemenuhanDoc = 0;
        $pemenuhanImp = 0;
        if (!empty($p['indexChild'])) {
            foreach ($p['indexChild'] as $k => $c) {
                $this->persentasePemenuhan($c);
                $pemenuhanDoc += $this->pasal[$c]['pemenuhanDoc'];
                $pemenuhanImp += $this->pasal[$c]['pemenuhanImp'];
            }
            $pemenuhanDoc = round($pemenuhanDoc/ count($p['indexChild']), 2); 
            $pemenuhanImp = round($pemenuhanImp/ count($p['indexChild']), 2); 
        } else {
            if ($p['doc'] != 0) {
                $pemenuhanDoc = 100;
            }
            if ($p['jadwal_ok']!=0){
                $pemenuhanImp = round($p['jadwal_ok']*100/$p['jadwal'],2);
            }
        }
        $this->pasal[$index]['pemenuhanDoc'] = $pemenuhanDoc;
        $this->pasal[$index]['pemenuhanImp'] = $pemenuhanImp;
    }

}
