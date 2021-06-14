<?php

class Tugas extends MY_Controller {

    protected $module = 'tugas';

    function index() {
        if ($this->input->post('newTugas')) {
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            $this->db->set('form_terkait', $this->input->post('form_terkait'));
            $this->db->set('id_project', $this->input->post('proyek'));
            $this->db->insert('tugas');
            $id = $this->db->insert_id();
            foreach ($this->input->post('personil') as $k => $p) {
                $this->db->set('id_tugas', $id);
                $this->db->set('id_position_personil', $p);
                $this->db->insert('personil_task');
            }
            $this->db->set('id_tugas', $id);
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->insert('jadwal');
        }
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->load->model('m_document');
        $this->data['dokumen'] = $this->m_document->dokumen_tugas();
        $this->data['form_terkait'] = $this->m_document->form_terkait();
        $this->load->model('m_project');
        $this->data['project'] = $this->m_project->get();
        $this->load->model('m_personil');
        $this->data['personil'] = $this->m_personil->position_personil();
        $this->db->select('j.*, pr.nama AS project, t.nama AS tugas');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('project pr', 'pr.id = t.id_project', 'LEFT');
        $this->db->where('d.id_company', $this->session->activeCompany['id']);
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
        $this->db->order_by('j.id', 'DESC');
        $jadwal = $this->db->get('jadwal j')->result();
        foreach ($jadwal as $k => $j) {
            $j->pelaksana = $this->m_personil->position_personil($j->id_tugas);
            $jadwal[$k] = $j;
        }
        $this->data['data'] = $jadwal;
        $this->render('index');
    }

}
