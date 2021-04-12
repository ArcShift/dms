<?php

class Panduan extends MY_Controller {

    protected $module = 'panduan';

    function index() {
        $this->subModule= 'read';
        $this->render('index');
    }

}
