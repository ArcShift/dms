<?php

class M_implementasi extends CI_Model {

    function progress($company) {
        $progress = [
            ['status' => 'all', 'where' => 'j.id IS NOT NULL'],
            ['status' => 'Terlambat', 'where' => 'j.upload_date > j.tanggal OR (DATE(j.tanggal)>CURDATE() AND j.upload_date IS NULL)'],
            ['status' => 'Hari Ini', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) = CURDATE()'],
            ['status' => 'Besok', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) = CURDATE() + INTERVAL 1 DAY'],
            ['status' => 'Selesai', 'where' => 'j.upload_date <= j.tanggal'],
            ['status' => 'Mendatang', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) > CURDATE() + INTERVAL 1 DAY'],
        ];
        foreach ($progress as $k => $p) {
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->join('document d', 'd.id = t.id_document AND d.id_company = ' . $company);
            $this->db->where($p['where'], null, false);
            $progress[$k]['count'] = $this->db->count_all_results('jadwal j');
            $progress[$k]['query'] = $this->db->last_query();
            $progress[$k]['percent'] = $progress[$k]['count']/$progress[0]['count']*100;
        }
        return $progress;
    }

}
