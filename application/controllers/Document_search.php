<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Document_search
 *
 * @author Jelajah Tekno Indone
 */
class Document_search extends MY_Controller {
    protected $module = "document_search";
    
    function __construct() {
        parent::__construct();
        $this->load->model("m_document", "model");
//        $this->load->library('form_validation');
//        $this->data['role'] = $this->model->role();
    }
    function index() {
//        $this->subTitle = 'List';
        $this->data['data']= $this->model->search();
        $this->data['creator']= $this->model->creator();
        $this->render('index');
    }

}
