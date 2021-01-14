<?php

class Standard extends MY_Controller {

    protected $module = 'standard';

    function __construct() {
        parent::__construct();
        $this->load->model('m_standard', 'model');
    }

    function index() {
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        if($this->input->post('edit')){
            $this->model->update();
        }
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
        if ($this->input->post('detail')) {
            $this->session->set_userdata('treeview', $this->input->post('detail'));
        }
        $this->load->model('M_pasal', 'models');
        $this->subTitle = 'Detail';
        $this->data['treeview'] = $this->models->treeview();
        if ($this->input->post()) {
            $this->load->library('form_validation');
            if ($this->input->post('add')) {
                $this->models->create();
            } else if ($this->input->post('modify')) {
                $this->models->update();
            } else if ($this->input->post('remove')) {
                $this->models->delete();
            } else if ($this->input->post('form1')) {
                if ($this->models->update_desc()) {
                    $this->data['msgSuccess'] = 'Deskripsi berhasil diubah';
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            }elseif ($this->input->post('sortUp')) {
                $this->models->sort_up();
            }elseif ($this->input->post('sortDown')) {
                $this->models->sort_down();
            }
        }
        $this->data['list'] = json_encode($this->models->reads());
        $this->render('detail');
    }

    function delete() {
        $config['table'] = 'standard';
        parent::hapus($config);
    }

}
