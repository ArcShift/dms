<?php

class Dashboard extends MY_Controller {
    protected $module="dashboard";

    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->render('dashboard', FALSE);
    }
}
