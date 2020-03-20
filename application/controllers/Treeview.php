<?php

class Treeview extends MY_Controller {

    protected $module = 'treeview';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview', 'model');
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        if ($this->input->post('add')) {
            if ($this->model->create()) {
                $this->session->set_flashdata('msgSuccess', 'Data berhasil dibuat');
                redirect($this->module);
            } else {
                $this->session->set_flashdata('msgError', $this->db->error()['message']);
            }
        }
        $this->subTitle = 'create';
        $this->render('create');
    }

    function detail() {
        $this->session->set_userdata('treeview', $this->input->post('detail'));
        redirect('treeview_detail');
    }

    function delete() {
        $this->subTitle = 'Delete';
        if ($this->input->post('initHapus')) {
            $this->data['data'] = $this->model->detail($this->input->post('initHapus'));
            $this->render('delete');
        } else if ($this->input->post('hapus')) {
            if ($this->model->delete($this->input->post('id'))) {
                $this->session->set_flashdata('msgSuccess', 'Data berhasil dihapus');
            } else {
                $this->session->set_flashdata('msgError', $this->db->error()['message']);
            }
            redirect($this->module);
        } else {
            redirect($this->module);
        }
    }

}
