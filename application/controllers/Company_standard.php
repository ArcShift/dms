<?php

class Company_standard extends MY_Controller {

    protected $module = "company_standard";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company_standard", "model");
//        $this->load->library('form_validation');
    }
    function index() {
        $this->render('read');
    }

}
