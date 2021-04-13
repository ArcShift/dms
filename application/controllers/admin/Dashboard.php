<?php

class Dashboard extends MY_Admin {
    public function __construct() {
        parent::__construct();
    }
    function index() {
        $this->render('dashboard');
    }

}
