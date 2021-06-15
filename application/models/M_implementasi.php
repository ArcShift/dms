<?php

class M_implementasi extends CI_Model {

    function progress($company, $standard) {
        $progress = [
            ['status' => 'all', 'where' => 'j.id IS NOT NULL'],
            ['status' => 'Terlambat', 'where' => 'j.upload_date > j.tanggal OR (DATE(j.tanggal)<CURDATE() AND j.upload_date IS NULL)'],
            ['status' => 'Hari Ini', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) = CURDATE()'],
            ['status' => 'Besok', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) = CURDATE() + INTERVAL 1 DAY'],
            ['status' => 'Selesai', 'where' => 'j.upload_date <= j.tanggal'],
            ['status' => 'Mendatang', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) > CURDATE() + INTERVAL 1 DAY'],
        ];
        foreach ($progress as $k => $p) {
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->join('document d', 'd.id = t.id_document AND d.id_company = ' . $company);
            $this->db->join('pasal p', 'p.id = d.id_pasal AND p.id_standard = ' . $standard); //TODO: modiv to id standard
            if ($this->session->user['role'] == 'anggota') {
                $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
                $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
                $this->db->where('pp.id_personil', $this->session->user['id_personil']);
            }
            $this->db->where($p['where'], null, false);
            $progress[$k]['count'] = $this->db->count_all_results('jadwal j');
            if ($progress[0]['count'] == 0) {
                $progress[$k]['percent'] = 0;
            } else {
                $progress[$k]['percent'] = round($progress[$k]['count'] / $progress[0]['count'] * 100);
            }
            $progress[$k]['where'] = null;
        }
        return $progress;
    }

    function get() {
        $this->db->select('j.*, t.nama AS tugas, t.sifat, dt.judul AS form_terkait, t.id_document');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document AND d.id_standard = ' . $this->session->activeStandard['id']);
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        $this->db->join('document dt', 'dt.id = t.form_terkait', 'LEFT');
        $this->db->order_by('j.tanggal', 'DESC');
        $data = $this->db->get('jadwal j')->result_array();
        foreach ($data as $k => $d) {
            if (!empty($d['tanggal']) & !empty($d['upload_date'])) {
                $d1 = new DateTime(date('Y-m-d', strtotime($d['upload_date'])));
                $d2 = new DateTime($d['tanggal']);
                if ($d1->diff($d2)->invert) {
                    $data[$k]['deadline'] = 'terlambat';
                } else {
                    $data[$k]['deadline'] = 'selesai';
                }
            } else {
                $data[$k]['deadline'] = '-';
            }
            $this->db->select('CONCAT(p.fullname, " - ", uk.name) AS fullname');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
            $this->db->where('pt.id_tugas', $d['id_tugas']);
            $data[$k]['personil'] = $this->db->get('personil_task pt')->result_array();
        }
        return $data;
    }

    function upload($path) {
        $this->db->where('id', $this->input->post('id'));
        $j = $this->db->get('jadwal')->row_array();
        $type = $this->input->post('type_dokumen');
        $this->db->set('doc_type', $type);
        $this->db->set('path', $path);
        if (empty($j['upload_date'])) {
            $this->db->set('upload_date', date('Y-m-d'));
        }
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jadwal');
        $this->db->join('jadwal j', 'j.id_tugas = t.id');
        $this->db->where('j.id', $j['id']);
        $t = $this->db->get('tugas t')->row_array();
        if ($j['doc_type'] == 'FILE' & !empty($j['path']) & file_exists('upload/implementasi/' . $j['path'])) {//delete old file
            unlink('upload/implementasi/' . $j['path']);
        }
        $this->setLog('U_IMP', $j['id']);
        return true;
    }

    private function setLog($type, $target, $message = null) {
        $desc = $message;
        if ($type == 'C_DOC' | $type == 'U_DOC') {
            $this->db->select('p.name, d.judul');
            $this->db->join('document_pasal dp', 'dp.id_document = d.id');
            $this->db->join('pasal p', 'p.id = dp.id_pasal');
            $this->db->where('d.id', $target);
            $result = $this->db->get('document d')->row_array();
            if ($type == 'C_DOC') {
                $text = 'menambahkan';
            } else {
                $text = 'mengubah';
            }
            $desc = '<b>' . $this->session->user['fullname'] . '</b> telah ' . $text . ' dokumen <b>'
                    . $result['judul'] . '</b> pada <b>'
                    . $result['name'] . '</b> di Standar <b>'
                    . $this->session->activeStandard['name'] . '</b>';
        } elseif ($type == 'U_IMP') {
            $this->db->select('t.nama AS tugas');
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->where('j.id', $target);
            $result = $this->db->get('jadwal j')->row_array();
            $desc = '<b>' . $this->session->user['fullname'] . '</b> telah menambahkan bukti implementasi pada tugas <b>'
                    . $result['tugas'] . '</b> di Standar <b>'
                    . $this->session->activeStandard['name'] . '</b>';
        }
        $this->db->set('desc', $desc);
        $this->db->set('type', $type);
        $this->db->set('target', $target);
        $this->db->set('id_user', $this->session->user['id']);
        $this->db->insert('log');
    }

}
