<?php

class Cron extends CI_Controller {

    function index() {
        //send notif by deadline jadwal
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
        $this->db->get('jadwal j')->result_array();
        
        $this->db->join('personil_position pp', '');
        $this->db->where('DATEDIFF(j.tanggal, CURDATE()) = 1');
        $user = $this->db->get('users u')->result_array();
        die($this->db->last_query());
        
        
        
        
        $this->load->model('m_setting');
        $penerima = 'ma.kaafi@yahoo.co.id';
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
//        $this->email->from('darkwarrior0236@gmail.com', 'DMS Delta');
        $this->email->from($this->m_setting->get('smtp_user'), 'DMS Delta');
//        $this->email->to($penerima);
        $this->email->to($penerima);
        $this->email->subject($judul);
        $this->email->message($message);
        $this->email->send();
        if (strlen($this->email->print_debugger()) < 20) {
            return true;
        } else {
            return $this->email->print_debugger();
        }
    }

}
