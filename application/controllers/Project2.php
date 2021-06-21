<?php

class Project2 extends MY_Controller {

    protected $module = 'project2';

    function index() {
        $this->subModule= 'read';
        $this->render('index');
    }
    function tugas() {
        $this->subModule= 'read';
        $this->render('tugas');
    }

}
