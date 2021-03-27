<?php

class Pemahaman_pasal extends MY_Controller {

    protected $module = "pemahaman_pasal";

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal', 'model');
    }

    function index() {
        if ($this->input->get('detail')) {
            $this->session->set_userdata('idData', $this->input->get('detail'));
            redirect($this->module.'/detail');
        }
        if ($this->input->get('edit')) {
            $this->session->set_userdata('idData', $this->input->get('edit'));
            redirect($this->module.'/edit');
        }
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['pasal'] = $this->model->get();
        $this->render('index');
    }

    function detail() {
        $this->subModule = 'read';
        $this->subTitle = 'Detail';
        $this->data['pasal']= $this->model->detail($this->session->idData);
        $this->render('detail');
    }

    function document() {
        $result = $this->model->getDocument($this->input->get('id'));
        echo json_encode($result);
    }
    function edit() {
    if($this->input->post('edit')){
        if($this->model->update2()){
            $this->session->set_flashdata('msgSuccess', 'Data berhasil diubah');
            redirect($this->module);
        }
    }    
    $this->subTitle= 'Edit';
    $this->data['pasal']= $this->model->detail($this->session->idData);
    $this->render('edit');
//        if (!$this->input->is_ajax_request()) {
//            redirect('404');
//        }
//        $this->db->where('id', $this->input->post('id'));
//        $this->db->set('long_desc', 'desc');
//        $this->db->update('pasal');
////        print_r($this->input->post());
    }
}
