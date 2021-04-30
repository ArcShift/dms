<?php

class Pasals extends MY_User {

    function index() {
        $this->load->model('m_pasal');
        $this->data['menuStandard'] = true;
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $p) {
            $this->db->select('d.*');
            $this->db->join('document_pasal dp','dp.id_document = d.id AND dp.id_pasal='.$p['id']);
            $pasal[$k]['dokumen'] = $this->db->get('document d')->result_array();
        }
        $this->data['pasal'] = $pasal;
        $this->render('pasals');
    }

}
