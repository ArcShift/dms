<?php

class Manajemen_dokumen extends MY_Controller {

    protected $module = 'manajemen_dokumen';

    function __construct() {
        parent::__construct();
    }

    function index() {
        echo 'manajemen';
    }
    function dokumen_tabel() {
        $this->load->view($this->module.'/document_table');
    }

}
