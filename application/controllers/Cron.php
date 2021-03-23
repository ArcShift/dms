<?php

class Cron extends CI_Controller {

    function index() {
        //query
        $this->db->select('u.id, t.nama AS tugas, s.name AS standard, u.email, j.id AS id_jadwal, u.notif_email');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('pasal ps', 'ps.id = d.id_pasal');
        $this->db->join('standard s', 's.id = ps.id_standard');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id');
        $this->db->where('DATEDIFF(j.tanggal, CURDATE()) = 1');
        $data = $this->db->get('jadwal j')->result_array();
        //config mail
        $this->load->model('m_setting');
        $this->load->model('m_notif');
        $judul = 'Cron';
        $message = 'Test Cron Job';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $this->m_setting->get('smtp_host');
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $this->m_setting->get('smtp_user');
        $config['smtp_pass'] = $this->m_setting->get('smtp_pass');
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; //text or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $this->load->library('email');
        $this->email->initialize($config);
        foreach ($data as $k => $v) {
                $msg = "Besok adalah hari terakhir untuk upload bukti implementasi untuk tugas <b>" . $v['tugas'] . "</b> di standar <b>" . $v['standard'] . "</b>, pastikan untuk upload tepat waktu";
            if (!empty($v['email']) & $v['notif_email'] === 'ENABLE') {
                $this->email->from($this->m_setting->get('smtp_user'), 'DMS Delta');
                $this->email->to($v['email']);
                $this->email->subject('Deadline');
                $this->email->message($msg);
                $this->email->send();
            }
            $this->m_notif->set($v['id'], 'DEADLINE', $v['id_jadwal'], $msg);
        }
        echo 'success';
    }

}
