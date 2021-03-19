<?php

class Cron extends CI_Controller {

    function index() {
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
