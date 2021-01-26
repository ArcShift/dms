<?php

class M_implementasi extends CI_Model {

    function progress($company) {
        $progress = [
            ['status' => 'all', 'where' => 'j.id IS NOT NULL'],
            ['status' => 'late', 'where' => 'j.upload_date > j.tanggal'],
            ['status' => 'today', 'where' => 'j.upload_date IS NULL AND DATE(j.tanggal) = CURDATE()'],
            ['status' => 'tomorrow', 'where' => 'j.upload_date IS NULL AND j.tanggal IN (CURDATE(), CURDATE() + INTERVAL 1 DAY)'],
            ['status' => 'finish', 'where' => '1'],
            ['status' => 'later', 'where' => '1'],
        ];
        foreach ($progress as $k => $p) {
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->join('document d', 'd.id = t.id_document AND d.id_company = ' . $company);
            $this->db->where($p['where'], null, false);
            $progress[$k]['count'] = $this->db->count_all_results('jadwal j');
            $progress[$k]['query'] = $this->db->last_query();
        }
        return $progress;
    }

}
