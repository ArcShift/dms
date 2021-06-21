<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tugas_saya
 *
 * @author kaafi
 */
class Tugas_saya extends MY_Controller {

    protected $module = 'tugas_saya';

    function index() {
        $this->subModule = 'read';
        $this->render('index');
    }

}
