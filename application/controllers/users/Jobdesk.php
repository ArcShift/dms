<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jobdesk
 *
 * @author kaafi
 */
class Jobdesk extends MY_User {

    function index() {
        $this->render('jobdesk');
    }

}
