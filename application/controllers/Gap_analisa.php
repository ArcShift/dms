<?php

class Gap_analisa extends MY_Controller {

    protected $module = 'gap_analisa';

    function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
    }

    function index() {
        if ($this->input->post('edit')) {
            $this->session->set_userdata('idData', $this->input->post('edit'));
            redirect($this->module . '/edit');
        }
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->data['data'] = $this->m_pasal->get();
        $this->render('index');
    }

    function edit() {
        if($this->input->post('save')){
            $this->db->set('kuesioner', $this->input->post('pertanyaan'));
            $this->db->set('id_pasal', $this->session->idData);
            $this->db->insert('kuesioner');
        }elseif($this->input->post('edit')){
            $this->db->set('kuesioner', $this->input->post('pertanyaan'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('kuesioner');
        }elseif($this->input->post('hapus')){
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('kuesioner');
        }
        $this->data['pasal'] = $this->m_pasal->get($this->session->idData);
        $this->data['pertanyaan'] = $this->db->get_where('kuesioner', ['id_pasal'=>$this->session->idData])->result_array();
        $this->subTitle = 'Edit';
        $this->render('edit');
    }

}
