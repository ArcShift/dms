<?php

class Usulan extends MY_User {

    function index() {
        if ($this->input->post('create')) {
            $this->db->set('created_by', $this->input->post('jabatan'));
            $this->db->set('nama', $this->input->post('usulan'));
            $this->db->set('created_at', NOW());
            if ($this->input->post('standar')) {
                $this->db->set('id_company_standard', $this->input->post('standar'));
            }
            if ($this->input->post('dokumen')) {
                $this->db->set('id_document', $this->input->post('dokumen'));
            }
            if ($this->input->post('form')) {
                $this->db->set('form_terkait', $this->input->post('form'));
            }
            $this->db->insert('usulan');
        }
        $this->db->select('u.*, s.name AS standar, d.judul AS dokumen, d2.judul AS form');
        $this->db->join('company_standard cs', 'cs.id = u.id_company_standard', 'LEFT');
        $this->db->join('standard s', 's.id = cs.id_standard', 'LEFT');
        $this->db->join('document d', 'd.id = u.id_document', 'LEFT');
        $this->db->join('document d2', 'd.id = u.form_terkait', 'LEFT');
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
        $this->load->model('m_personil');
        $this->load->model('m_company_standard');
        $this->data['unit_kerja'] = $this->m_personil->get_unit_kerja();
        $this->data['standard'] = $this->m_company_standard->get();
        $this->render('usulan');
    }

    function get_dokumen() {
        $data = [];
        $this->load->model('m_document');
        $data['dokumen'] = $this->m_document->dokumen_saya($this->input->get('standard'));
        $data['qDoc'] = $this->db->last_query();
        $data['form_terkait'] = $this->m_document->form_terkait($this->input->get('standard'));
        $data['qForm'] = $this->db->last_query();
        echo json_encode($data);
    }

}
