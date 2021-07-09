<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dms {

    function notif_mail($penerima, $judul, $message) {
        $CI = & get_instance();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = 'knightarcher1@gmail.com';
        $config['smtp_pass'] = '3ep5c98Hyys3NmF';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $CI->load->library('email');
        $CI->email->initialize($config);
        $CI->email->from('darkwarrior0236@gmail.com', 'EMA: Easy Management');
        $CI->email->to($penerima);
        $CI->email->subject($judul);
        $CI->email->message($message);
        return $CI->email->send();
//        echo $this->email->print_debugger();
    }

}
