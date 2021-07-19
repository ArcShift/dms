<?php

class Usulan extends MY_Controller {

    protected $module = 'usulan';

    function index() {
        if ($this->input->post('approval')) {
            if ($this->session->user['role'] == 'ketua') {
                $this->db->set('ketua_approve', $this->input->post('status'));
                $this->db->set('ketua_feedback', $this->input->post('feedback'));
                $this->db->set('ketua_tgl_approve', 'NOW()', false);
            } elseif ($this->session->user['role'] == 'pic') {
                $this->db->set('pic_approve', $this->input->post('status'));
                $this->db->set('pic_feedback', $this->input->post('feedback'));
                $this->db->set('pic_tgl_approve', 'NOW()', false);
            }
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('usulan');
        }
        $this->db->select('u.*, s.name AS standar, d.judul AS dokumen, d2.judul AS form');
        $this->db->join('company_standard cs', 'cs.id = u.id_company_standard', 'LEFT');
        $this->db->join('standard s', 's.id = cs.id_standard', 'LEFT');
        $this->db->join('document d', 'd.id = u.id_document', 'LEFT');
        $this->db->join('document d2', 'd.id = u.form_terkait', 'LEFT');
        if ($this->session->user['role'] == 'ketua') {
//            $this->db->where('u.pic_approve', null);
        }
        $usulan = $this->db->get('usulan u')->result();
        $keys = ['standar', 'dokumen', 'form'];
        foreach ($usulan as $k => $u) {
            foreach ($keys as $ky) {
                if (empty($usulan[$k]->{$ky})) {
                    $usulan[$k]->{$ky} = '-';
                }
            }
        }
        $this->data['usulan'] = $usulan;
        $this->subModule = 'read';
        $this->render('index');
    }

}
