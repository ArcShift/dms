<?php

class Role extends MY_Controller {

    protected $module = 'role'; //DEV MODE

    public function __construct() {
        parent::__construct();
        $this->load->model("m_role", "model");
    }

    public function index() {
        if ($this->input->post('set')) {
            if ($this->input->post('create')) {
                $v = $this->input->post('create');
                $crud = 'acc_create';
            } else if ($this->input->post('read')) {
                $v = $this->input->post('read');
                $crud = 'acc_read';
            } else if ($this->input->post('update')) {
                $v = $this->input->post('update');
                $crud = 'acc_update';
            } else if ($this->input->post('delete')) {
                $v = $this->input->post('delete');
                $crud = 'acc_delete';
            }
            $v = explode('_', $v);
            $this->model->set($v[0], $v[1], $crud, $v[2]); //module, role, crud, status
        }
        $this->data['mod'] = $this->model->module();
        $this->data['userRole'] = $this->model->role();
        $this->data['access']= $this->model->access();
        $this->render('reads');
    }
    function user_access($id) {
        $acc= $this->model->user_access($id);
        print_r($acc);
    }

}
