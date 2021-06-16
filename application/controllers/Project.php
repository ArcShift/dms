<?php

class Project extends MY_Controller {

    protected $module = 'project';

    function index() {
        if($this->input->post('create')){
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->insert('project');
        }elseif($this->input->post('hapus')){
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('project');
        }
        $this->data['menuStandard']= 'company';
        $this->subModule = 'read';
        $this->db->select('p.*, COUNT(t.id) AS tugas');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->group_by('p.id');
        $this->data['data'] = $this->db->get_where('project p', ['p.id_company'=>$this->session->activeCompany['id']])->result();
        $this->render('index');
    }

}
