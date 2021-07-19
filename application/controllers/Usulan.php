<?php

class Usulan extends MY_Controller{
    protected $module = 'usulan';
    function index() {
        if($this->db->session->user['role']=='ketua'){
            
        }
        $usulan = $this->db->get('usulan')->result();
        $this->data['usulan'] = $usulan;
        $this->subModule = 'read';
        $this->render('index');
    }
}
