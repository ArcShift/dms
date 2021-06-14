<?php

class Tugas extends MY_Controller {

    protected $module = 'tugas';

    function index() {
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->db->select('j.*');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->where('d.id_company', $this->session->activeCompany['id']);
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
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
