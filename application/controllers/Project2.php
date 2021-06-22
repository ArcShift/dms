<?php

class Project2 extends MY_Controller {

    protected $module = 'project2';

    function index() {
        if ($this->input->post('idData')) {
            $this->session->set_userdata('idData', $this->input->post('idData'));
            redirect($this->module . '/tugas');
        }
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'company';
        $this->subModule = 'read';
        $this->db->select('p.*, COUNT(t.id) AS tugas');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->group_by('p.id');
        $this->data['data'] = $this->db->get_where('project p', ['p.id_company' => $this->session->activeCompany['id']])->result();
        $this->render('index');
    }

    function tugas() {
        if (empty($this->session->idData)) {
            redirect($this->module);
        }
        $project = $this->db->get_where('project', ['id' => $this->session->idData])->row();
        if (empty($project)) {
            redirect($this->module);
        }
        $this->data['project'] = $project;
        $this->data['tugas'] = $this->db->get_where('tugas', ['id_project' => $this->session->idData])->result();
        $this->subModule = 'read';
        $this->render('tugas');
    }

    function get() {
        $this->db->select('p.*, COUNT(t.id) AS tugas');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->group_by('p.id');
        $data = $this->db->get_where('project p', ['p.id_company' => $this->session->activeCompany['id']])->result();
        echo json_encode($data);
    }

    function set() {//
        if ($this->input->post('mode') == 'create') {
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->insert('project');
        } elseif ($this->input->post('mode') == 'hapus') {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('project');
        } elseif ($this->input->post('mode') == 'edit') {
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('project');
        }
        echo json_encode(['status' => 'success']);
    }

}
