<?php

class Notifikasi_email extends MY_Controller {

    protected $module = 'notifikasi_email';

    function index() {
        if ($this->input->post('notif_email')) {
            $this->db->set('notif_email', $this->input->post('notif_email'));
            $this->db->where('id', $this->session->user['id']);
            $this->db->update('users');
        }
        $this->data['data'] = $this->db->get_where('users', ['id' => $this->session->user['id']])->row_array();
        $this->render('read');
    }

    function switch_status() {
        $this->db->where('id', $this->session->user['id']);
        $result = $this->db->get('users')->row_array();
        $this->db->set('notif_email', $result['notif_email'] == 'ENABLE' ? 'DISABLE' : 'ENABLE');
        $this->db->where('id', $this->session->user['id']);
        $this->db->update('users');
        echo 'success';
    }

}
