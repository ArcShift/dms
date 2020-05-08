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

    function tabs() {
        if (empty($this->input->post('idStandar'))) {
            die('NO ACCESS');
        }
        $this->data['data'] = $this->model->reads();
//        die($this->db->last_query());
        $this->data['schedule'] = $this->model->reads_schedule();
        $pasal = 0;
//        foreach ($this->data['schedule'] as $k => $s) {
//            if ($pasal != $s['id_pasal']) {
//                $pasal= $s['id_pasal'];
//                $p = array();
//            }
//            
//        }
        $this->data['pemenuhan'] = $this->model->reads_pemenuhan();
//        $this->data['pemenuhan'] = $this->db->last_query();
//        die($this->db->last_query());
        $this->render('tab', TRUE, TRUE);
    }

    function standard() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->model->standard());
    }

    function form2() {
        $this->data['data'] = $this->model->reads();
        $this->data['schedule'] = $this->model->read_schedule();
        $this->render('form2_read', TRUE, TRUE);
    }

    function form2_edit2() {
        $this->load->library('form_validation');
        if ($this->input->post('simpan')) {
            $step = true;
            $config['upload_path'] = './upload/form2';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if ($_FILES['dokumen']['name']) {
                if (!$this->upload->do_upload('dokumen')) {
                    $step = false;
                    $this->data['msgError'] = $this->upload->display_errors();
                }
            }
            if ($step) {
                if ($this->model->form2_save()) {
                    $this->data['msgSuccess'] = 'Data berhasil diubah';
//                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diubah');
//                    redirect($this->module);
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            }
        } elseif ($this->input->post('tambah')) {
            if ($this->input->post('idForm')) {
                $this->form_validation->set_rules('jadwal', 'Jadwal', 'required');
                $this->form_validation->set_rules('anggota', 'Anggota', 'required');
                if ($this->form_validation->run()) {
                    if ($this->model->add_schedule()) {
                        $this->data['msgSuccess'] = 'Jadwal berhasil ditambahkan';
                    } else {
                        $this->data['msgError'] = $this->db->error()['message'];
                    }
                } else {
                    $this->data['msgError'] = validation_errors();
                }
            } else {
                $this->data['msgError'] = 'Form belum disimpan';
            }
        } elseif ($this->input->post('hapus')) {
            if ($this->model->delete_schedule()) {
                $this->data['msgSuccess'] = 'Jadwal berhasil dihapus';
            } else {
                $this->data['msgError'] = $this->db->error()['message'];
            }
        }
        $this->data['member'] = $this->model->member();
        $this->data['schedule'] = $this->model->read_schedule();
        $this->data['data'] = $this->model->reads();
        $this->render('form2_edit2', TRUE, TRUE);
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
