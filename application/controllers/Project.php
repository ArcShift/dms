<?php

class Project extends MY_Controller {

    protected $module = 'project';

    function index() {
        if($this->input->post('create')){
            print_r($this->input->post());
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->insert('project');
        }
        $this->data['menuStandard']= 'company';
        $this->subModule = 'read';
        $this->data['data'] = $this->db->get_where('project', ['id_company'=>$this->session->activeCompany['id']])->result();
        $this->render('index');
    }

}
