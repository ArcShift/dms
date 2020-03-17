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
        $this->load->model("base_model", "b_model");
    }

    protected function render($view, $includeModule = true) {
        foreach ($this->session->userdata('module') as $k => $m) {
            if ($m['name'] == $this->module) {
                $this->activeModule = $m;
            }
        }
        $this->data['module'] = $this->module;
        $this->data['activeModule'] = $this->activeModule;
        $this->data['subTitle'] = $this->subTitle;
        if (empty($this->activeModule)) {
            $this->data['view'] = 'template/no_access';
            $this->load->view('template/container', $this->data);
        } else {
            if ($includeModule) {
                $this->data['view'] = $this->module . '/' . $view;
            } else {
                $this->data['view'] = $view;
            }
            $this->load->view('template/container', $this->data);
        }
    }

    protected function load_module($id) {
        $this->data['module'] = $this->session->userdata('menu')[$id];
    }

}
