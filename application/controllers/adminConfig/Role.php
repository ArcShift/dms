<?php

class Role extends MY_Controller {

    protected $title = "User Role";

    public function __construct() {
        parent::__construct();
        $this->load->model("m_role", "model");
    }

    public function index() {
        $this->data['data1'] = $this->model->read();
        if ($this->input->post()) {
           $this->model->create(); 
        }
        $this->render('user/role');
    }

    public function create() {
        
    }

    public function update() {
        echo "update user";
    }

    public function delete() {
        echo "delete user";
    }

}
