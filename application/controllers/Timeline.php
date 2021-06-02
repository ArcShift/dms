<?php

class Timeline extends MY_Controller {

    protected $module = 'timeline';

    function index() {
        $this->data['menuStandard']= 'standard';
        $this->subModule = 'read';
        $this->render('index');
    }

}
