<?php

class Akses_pasal extends MY_Controller {

    protected $module = "akses_pasal";

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['menuStandard'] = 'standard';
        if ($this->input->post()) {
            $this->db->where('id_pasal', $this->input->post('pasal'));
            $this->db->where('id_company', $this->session->activeCompany['id']);
            $acc = $this->db->get('pasal_access')->row_array();
            $this->db->set('status', $this->input->post('status'));
            $this->db->set('desc', $this->input->post('desc'));
            if (empty($acc)) {
                $this->db->set('id_pasal', $this->input->post('pasal'));
                $this->db->set('id_company', $this->session->activeCompany['id']);
                $this->db->insert('pasal_access');
            } else {
                $this->db->where('id_pasal', $this->input->post('pasal'));
                $this->db->where('id_company', $this->session->activeCompany['id']);
                $this->db->update('pasal_access');
            }
        }
        $this->load->model('m_pasal');
        $this->db->select('p.*, pa.status, pa.desc');
        $this->db->join('pasal_access pa', 'pa.id_pasal = p.id AND pa.id_company = ' . $this->session->activeCompany['id'], 'LEFT');
//        $this->db->where('p.parent', null);
        $this->db->where('p.id_standard', $this->session->activeStandard['id']);
        $this->db->order_by('p.id');
        $this->data['data'] = $this->db->get('pasal p')->result_array();
        $data = $this->m_pasal->get(null, null, false);
        foreach ($data as $k => $d) {
            $this->db->select('pa.status, pa.desc');
            $this->db->join('pasal_access pa', 'pa.id_pasal = p.id AND pa.id_company = ' . $this->session->activeCompany['id'], 'LEFT');
            $d2 = $this->db->get_where('pasal p', ['p.id' => $d['id']])->row();
            $data[$k]['status']= $d2->status;
            $data[$k]['desc']= $d2->desc;
        }
        $this->data['data'] = $data;
        $this->render('read');
    }

}
