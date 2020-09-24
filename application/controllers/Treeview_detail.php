<?php

class Treeview_detail extends MY_Controller {

    protected $module = 'treeview_detail';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    function index() {
        $this->load->model('m_company');
        $this->data['company'] = $this->m_company->get();
        $this->render('read');
    }

    function standard() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->standard());
    }

    function anggota() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->member());
    }

    function personil() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->personil());
    }

    function pasal() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->pasal());
    }

    function unit_kerja() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->unit_kerja());
    }

    function create_dokumen() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pasal', 'Pasal', 'required');
        $this->form_validation->set_rules('nomor', 'Nomor', 'required');
        $result['status'] = 'error';
        if ($this->form_validation->run()) {
            $step = true;
            if ($this->input->post('type_dokumen') == 'FILE') {
                $config['upload_path'] = './upload/dokumen';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('dokumen')) {
                    $result['message'] = $this->upload->display_errors();
                    $step = false;
                }
            }
            if ($step) {
                if ($this->model->create_document()) {
                    $result['status'] = 'success';
                } else {
                    $result['message'] = $this->db->error()['message'];
                }
            }
        } else {
            $result['message'] = validation_errors();
        }
        echo json_encode($result);
    }

    function get_dokumen() {
        echo json_encode($this->model->read_document());
    }

    function get_distribusi() {
        echo json_encode($this->model->read_distribusi());
    }

    function set_distribusi() {
        if ($this->model->insert_distribusi()) {
            echo 'success';
        } else {
            echo 'error';
        }
        print_r($this->input->post());
    }

    function set_jadwal() {
        if ($this->model->create_jadwal()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    function upload_bukti() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        //TODO: form validation
        $step = true;
        if ($this->input->post('type_dokumen') == 'FILE') {
            $config['upload_path'] = './upload/implementasi';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('dokumen')) {
                $result['message'] = $this->upload->display_errors();
                $step = false;
            }
        }
        if ($step) {
            if ($this->model->upload_bukti()) {
                $result['status'] = 'success';
            } else {
                $result['message'] = $this->db->error()['message'];
            }
        }
        echo json_encode($result);
    }

    function upload_bukti_penerapan() {
        $config['upload_path'] = "./upload/penerapan";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("doc")) {
            if ($this->model->upload_bukti_penerapan()) {
                $status['status'] = 'success';
                $status['message'] = 'data berhasil diupload';
            } else {
                $status['status'] = 'error';
                $status['message'] = $this->db->error()['message'];
            }
            $data = array('upload_data' => $this->upload->data());
            $data1 = array(
                'menu_id' => $this->input->post('selectmenuid'),
                'submenu_id' => $this->input->post('selectsubmenu'),
                'imagetitle' => $this->input->post('imagetitle'),
                'imgpath' => $data['upload_data']['file_name']
            );
        } else {
            $status['status'] = 'error';
            $status['message'] = $this->upload->display_errors();
        }
        echo json_encode($status);
    }

}
