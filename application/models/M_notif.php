<?php

class M_notif extends CI_Model {

    function distribution($count = false) {
        $this->db->select('d.judul, ds.created_at, ds.notif, ds.id AS id_distribution, s.name AS standard');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal');
        $this->db->join('standard s', 's.id = ps.id_standard');
        $this->db->join('distribution ds', 'ds.id_document = d.id');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        $this->db->group_by('d.id');
        $this->db->order_by('ds.notif', 'DESC');
        $result = $this->db->get('document d')->result_array();
        foreach ($result as $k => $v) {
            $result[$k]['created_at'] = $this->time_elapsed_string($v['created_at']);
        }
        return $result;
    }

    function tugas() {
        $this->db->select('t.nama, pt.created_at, s.name AS standard');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal');
        $this->db->join('standard s', 's.id = ps.id_standard');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        $result = $this->db->get('tugas t')->result_array();
        foreach ($result as $k => $v) {
            $result[$k]['created_at'] = $this->time_elapsed_string($v['created_at']);
        }
        return $result;
    }

    function jadwal() {
        $this->db->select('t.nama AS tugas, j.tanggal, j.created_at, s.name AS standard');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal');
        $this->db->join('standard s', 's.id = ps.id_standard');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        $result = $this->db->get('jadwal j')->result_array();
        foreach ($result as $k => $v) {
            $result[$k]['created_at'] = $this->time_elapsed_string($v['created_at']);
        }
        return $result;
    }

    function deadline() {
        $this->db->select('t.nama AS tugas, s.name AS standard');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal');
        $this->db->join('standard s', 's.id = ps.id_standard');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        $this->db->where('DATEDIFF(j.tanggal, CURDATE()) = 1');
        return $this->db->get('jadwal j')->result_array();
    }

    function count_each() {
        $data = [];
        $data['distribution'] = $this->distribution(true);
        $data['all'] = $data['distribution'];
        return $data;
    }

    function notif2($limit = null) {
        $id = $this->session->user['id'];
        $sql = "(SELECT d.id, d.judul AS `name`, `ds`.`created_at` AS time, `s`.`name` AS `standard`, 'DIS' AS type, NULL AS more FROM `document` `d` JOIN `pasal` `ps` ON `ps`.`id` = `d`.`id_pasal` JOIN `standard` `s` ON `s`.`id` = `ps`.`id_standard` JOIN `distribution` `ds` ON `ds`.`id_document` = `d`.`id` JOIN `position_personil` `pp` ON `pp`.`id` = `ds`.`id_position_personil` JOIN `personil` `p` ON `p`.`id` = `pp`.`id_personil` JOIN `users` `u` ON `u`.`id_personil` = `p`.`id` AND `u`.`id` = " . $id . " GROUP BY `d`.`id` ORDER BY `ds`.`notif` DESC)UNION";
        $sql .= "(SELECT t.id, `t`.`nama` AS name, `pt`.`created_at` AS time, `s`.`name` AS `standard`, 'TGS' AS type, NULL AS more FROM `tugas` `t` JOIN `document` `d` ON `d`.`id` = `t`.`id_document` JOIN `pasal` `ps` ON `ps`.`id` = `d`.`id_pasal` JOIN `standard` `s` ON `s`.`id` = `ps`.`id_standard` JOIN `personil_task` `pt` ON `pt`.`id_tugas` = `t`.`id` JOIN `position_personil` `pp` ON `pp`.`id` = `pt`.`id_position_personil` JOIN `personil` `p` ON `p`.`id` = `pp`.`id_personil` JOIN `users` `u` ON `u`.`id_personil` = `p`.`id` AND `u`.`id` = " . $id . ")UNION";
        $sql .= "(SELECT t.id, `t`.`nama` AS `name`, `j`.`created_at` AS time, `s`.`name` AS `standard`,'JDW' AS type, `j`.`tanggal` AS more FROM `jadwal` `j` JOIN `tugas` `t` ON `t`.`id` = `j`.`id_tugas` JOIN `document` `d` ON `d`.`id` = `t`.`id_document` JOIN `pasal` `ps` ON `ps`.`id` = `d`.`id_pasal` JOIN `standard` `s` ON `s`.`id` = `ps`.`id_standard` JOIN `personil_task` `pt` ON `pt`.`id_tugas` = `t`.`id` JOIN `position_personil` `pp` ON `pp`.`id` = `pt`.`id_position_personil` JOIN `personil` `p` ON `p`.`id` = `pp`.`id_personil` JOIN `users` `u` ON `u`.`id_personil` = `p`.`id` AND `u`.`id` =" . $id . ")UNION";
        $sql .= "(SELECT t.id, `t`.`nama` AS name, NOW() AS time, `s`.`name` AS `standard`, 'DED' AS type, `j`.`tanggal` AS more FROM `jadwal` `j` JOIN `tugas` `t` ON `t`.`id` = `j`.`id_tugas` JOIN `document` `d` ON `d`.`id` = `t`.`id_document` JOIN `pasal` `ps` ON `ps`.`id` = `d`.`id_pasal` JOIN `standard` `s` ON `s`.`id` = `ps`.`id_standard` JOIN `personil_task` `pt` ON `pt`.`id_tugas` = `t`.`id` JOIN `position_personil` `pp` ON `pp`.`id` = `pt`.`id_position_personil` JOIN `personil` `p` ON `p`.`id` = `pp`.`id_personil` JOIN `users` `u` ON `u`.`id_personil` = `p`.`id` AND `u`.`id` =" . $id . " WHERE DATEDIFF(j.tanggal, CURDATE()) = 1)";
        $sql .= "ORDER BY time DESC ";
        if (!empty($limit)) {
            $sql .= "LIMIT " . $limit;
        }
        $result = $this->db->query($sql)->result_array();
        foreach ($result as $k => $r) {
            switch ($r['type']) {
                case 'DIS':
                    $msg = "Anda telah terdaftar sebagai penerima dokumen untuk dokumen dengan judul <b>" . $r['name'] . "</b> di standar <b>" . $r['standard'] . "</b>";
                    break;
                case 'TGS':
                    $msg = "Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>" . $r['name'] . "</b> di Standar <b>" . $r['standard'] . "</b>";
                    break;
                case 'JDW':
                    $msg = "Jadwal pelaksanaan tugas <b>" . $r['name'] . "</b> untuk standar <b>" . $r['standard'] . "</b> telah ditetapkan pada tanggal <b>" . $r['more'] . "</b>";
                    break;
                case 'DED':
                    $msg = "Besok adalah hari terakhir untuk upload bukti implementasi untuk tugas <b>" . $r['name'] . "</b> di standar <b>" . $r['standard'] . "</b>, pastikan untuk upload tepat waktu";
                    break;
                default: $msg = '--';
                    break;
            }
            $result[$k]['message'] = $msg;
            $result[$k]['ago'] = $this->time_elapsed_string($r['time']);
        }
        return $result;
    }

    private function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
//        $now->add(new DateInterval('PT6H'));//todo fix timezone
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}
