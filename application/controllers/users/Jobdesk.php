<?php

class Jobdesk extends MY_User {

    function index() {
        $this->db->select('uk.*');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil=' . $this->session->user['id_personil']);
        $this->data['unit_kerja'] = $this->db->get('unit_kerja uk')->result();
        $this->render('jobdesk');
    }

    function get_data() {
        $data = $this->db->get_where('jobdesk',['id_unit_kerja'=>$this->input->get('id')])->result();
        echo json_encode($data);
    }

}
