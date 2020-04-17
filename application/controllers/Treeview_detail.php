<?php

class Treeview_detail extends MY_Controller {

    protected $module = 'treeview_detail';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    function index() {
        $this->load->model('m_company');
        $this->data['company'] = $this->m_company->get();
        $this->render('read');
    }
    
    function tabs() {
        $id= $this->input->get('idStandar');
        if(empty($id)){
            die('NO ACCESS');
        }
        $this->data['data'] = $this->model->reads($id);
        $this->render('tab', TRUE, TRUE);
    }

    function standard() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->standard());
    }
    function form2() {
        $this->data['member'] = $this->model->member();        
        $this->render('form2', TRUE, TRUE);
    }
    
//    function get() {
//        if (!$this->input->is_ajax_request()) {
//            redirect('404');
//        }
//        echo json_encode($this->model->reads($this->input->post('id')));
//    }
}
