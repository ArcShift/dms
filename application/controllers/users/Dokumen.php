<?php

class Dokumen extends MY_User{
    function index() {
        $this->db->select('d.id');
        $this->db->join('distribution ds', 'ds.id_document = d.id');
        $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id='.$this->session->user['id']);
        $docs = $this->db->get('document d')->result_array();
        $this->load->model('m_document');
        foreach ($docs as $k => $d) {
            $docs[$k]= $this->m_document->get($d['id']);
        }
        $this->data['docs']= $docs;
        $this->render('dokumen');
    }
}
