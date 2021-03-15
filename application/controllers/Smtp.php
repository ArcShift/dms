<?php

class Smtp extends CI_Controller {

    function index() {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('zz@yahoo.com', 'Your Name');
        $this->email->to('darkwarrior0236@gmail.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();
        echo 'success';
    }

}
