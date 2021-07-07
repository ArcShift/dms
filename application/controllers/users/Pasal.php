<?php

class Pasal extends MY_User {

    function index() {
        $this->load->model('m_pasal');
        $this->data['menuStandard'] = true;
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $p) {
            $this->db->select('d.*');
            $this->db->join('document_pasal dp', 'dp.id_document = d.id AND dp.id_pasal=' . $p['id']);
            $doc = $this->db->get('document d')->result_array();
            foreach ($doc as $k2 => $d) {
                $this->db->join('pasal p', 'p.id = dp.id_pasal');
                $d['pasal'] = $this->db->get_where('document_pasal dp', ['dp.id_document' => $d['id']])->result_array();
                $doc[$k2] = $d;
            }
            $pasal[$k]['dokumen'] = $doc;
        }
        $this->data['pasal'] = $pasal;
        $this->render('pasal');
    }

}
