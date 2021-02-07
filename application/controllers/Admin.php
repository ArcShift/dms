<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author kaafi
 */
class Admin extends CI_Controller {
    function index() {
        if ($this->session->has_userdata('admin')) {
            redirect('admin/dashboard');
        }else{
            redirect('admin/login');
        }
    }
}
