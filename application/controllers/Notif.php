<?php

class Notif extends MY_Controller {

    protected $module = "notif";
    function __construct() {
        parent::__construct();
        $this->load->model('m_notif', 'model');
    }
    
    function index() {
        if($this->input->post('read_dist')){
            $this->db->set('notif', 'READ');
            $this->db->where('id', $this->input->post('read_dist'));
            $this->db->update('distribution');
        }
        $this->data['distribution']= $this->model->distribution();
        $this->render('read');
    }

}
