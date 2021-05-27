<?php

class Jobdesk extends MY_User {

    function index() {
        $this->db->select('uk.*');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil=' . $this->session->user['id_personil']);
        $this->data['unit_kerja'] = $this->db->get('unit_kerja uk')->result();
        $this->render('jobdesk');
    }

    function get_data() {
        $this->db->select('jd.name AS jobdesk_unit, pj.desc AS jobdesk_personil, pj.id_jobdesk');
        $this->db->join('personil_jobdesk pj', 'pj.id_jobdesk = jd.id', 'LEFT');
        $this->db->order_by('jd.id');
        $data = $this->db->get_where('jobdesk jd',['id_unit_kerja'=>$this->input->get('id')])->result();
        echo json_encode($data);
    }

}
