<?php

class Aktifitas extends MY_User{
    function index() {
        $this->load->model('m_log', 'model');
        $this->data['data'] = $this->model->get();
        $this->render('aktifitas');
    }
}
