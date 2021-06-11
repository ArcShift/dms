<?php

class Tugas extends MY_Controller {

    protected $module = 'tugas';

    function index() {
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $jadwal = $this->db->get('jadwal j')->result();
        foreach ($jadwal as $k => $j) {
            $j->tugas = $this->db->get_where('tugas', ['id'=>$j->id_tugas])->row();
            $jadwal[$k] = $j;
            $j->form_terkait = $this->db->get_where('document', ['id'=>$j->id_tugas])->row();
        }
        $this->data['data']= $jadwal;
        $this->render('index');
    }

}
