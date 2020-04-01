<?php

class Treeview_detail extends MY_Controller {

    protected $module = 'treeview_detail';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    function index() {
        if (!$this->session->userdata('treeview')) {
            redirect('standard');
        }
        $this->subTitle = 'Detail';
        $this->data['treeview'] = $this->model->treeview();
        if ($this->input->post()) {
            $this->load->library('form_validation');
            if ($this->input->post('add')) {
                $this->model->create();
            } else if ($this->input->post('modify')) {
                $this->model->update();
            } else if ($this->input->post('remove')) {
                $this->model->delete();
            } else if ($this->input->post('form1')) {
                if ($this->input->post('desc')) {
                    if (!$this->model->update_desc()) {
                        $this->data['msgError'] = $this->upload->display_errors();
                    }
                }
                $config['upload_path'] = './assets/';
                $config['allowed_types'] = 'docx|doc|pdf';
                $config['max_size'] = 5000;
//                $config['file_name'] = $this->input->post('nama');
                $this->load->library('upload', $config);
                if ($_FILES AND $_FILES['file']['name']) {
                    if (!$this->upload->do_upload('file')) {
                        $this->data['msgError'] = $this->upload->display_errors();
                    } else {
                        $this->model->update_file1();
                    }
                }
            } else if ($this->input->post('upload')) {
                $config['upload_path'] = './assets/';
                $config['allowed_types'] = 'docx|doc|pdf';
                $config['max_size'] = 5000;
//                $config['file_name'] = $this->input->post('nama');
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                } else {
                    $this->model->update_file();
                }
            }
//            if ($this->form_validation->run() == FALSE) {
//                $this->load->view('myform');
//            }
        }
        $this->data['list'] = json_encode($this->model->reads());
        $this->render('read');
    }

}
