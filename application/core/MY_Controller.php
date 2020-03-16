<?php

class MY_Controller extends CI_Controller {

    protected $module = null;
    protected $title = null;
    protected $subTitle = null;
    protected $data = array();
    protected $activeModule = null;

    public function __construct() {
        parent::__construct();
        if (!$this->session->has_userdata('user')) {
            redirect('login');
        }
        $this->load->model("m_module", "base_model");
    }

//    protected function render($view, $module=true) {
//        $this->data['title'] = $this->title;
//        $this->data['view'] = $view;
//        $this->data['modules'] = $this->session->userdata('menu');
//        $this->load->view('container/admin', $this->data);
//    }
    
    protected function render($view, $includeModule = true) {
        $this->data['modules'] = $this->session->userdata('menu');
        foreach ($this->data['modules'] as $k => $m) {
            if($m['name']==$this->module){
                $this->activeModule= $m;
            }
        }
//        $this->data['user'] = $this->user;
//        die($this->activeModule);
        $this->data['activeModule'] = $this->activeModule;
        $this->data['module'] = $this->module;
        $this->data['subTitle'] = $this->subTitle;
        if ($includeModule) {
            $this->data['view'] = $this->module . '/' . $view;
        } else {
            $this->data['view'] = $view;
        }
        $this->load->view('template/container', $this->data);
    }
    protected function load_module($id) {
        $this->data['module']= $this->session->userdata('menu')[$id];
    }
}
