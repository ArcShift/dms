<?php

class Notifikasi extends MY_User {

    function index() {
        $this->load->model('m_notif', 'model');
        if ($this->input->post('read_all')) {
            $this->model->read_all();
        }
        if ($this->input->post('switch')) {
            $this->model->switch($this->input->post('switch'));
        }
        $this->data['notif3'] = $this->model->get(30);
        $this->render('notifikasi');
    }

}
