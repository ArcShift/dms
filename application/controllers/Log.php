<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author kaafi
 */
class Log extends MY_Controller {

    protected $module = "log";

    function __construct() {
        parent::__construct();
        $this->load->model('m_log', 'model');
    }

    function index() {
        $this->data['menuStandard'] = true;
        $this->data['log'] = $this->model->get();
        $this->render('read');
    }

}
