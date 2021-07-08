<?php

class Company extends MY_Controller {

    protected $module = "company";

    function __construct() {
        parent::__construct();
        $this->load->model("m_company", "model");
        $this->load->model("m_place");
        $this->load->library('form_validation');
        $this->data['province'] = $this->m_place->province();
    }

    function index() {
        if ($this->session->user['role'] != 'admin') {
            redirect($this->module . '/detail');
        }
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        if ($this->input->post('tambah')) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->create()) {
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil dibuat');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            } else {
                $this->session->set_flashdata('msgError', 'validation error');
            }
        }
        $this->render('create');
    }

    function kota() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        echo json_encode($this->m_place->city());
    }

    function delete() {
        $config['table'] = 'company';
        parent::hapus($config);
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $this->session->set_userdata('idData', $this->input->post('initEdit'));
            $this->data['data'] = $this->model->detail($this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
//            $result = $this->model->detail($this->input->post('edit'));
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('akun', 'Akun', 'required|integer');
            if ($this->form_validation->run()) {
                if ($this->model->update()) {
                    $this->load->model('m_log');
                    $this->m_log->update_company();
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
//                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            }
            $this->data['data'] = array(
                "id" => $this->input->post('id'),
                "name" => $this->input->post('nama'),
                "id_role" => $this->input->post('role')
            );
        }
        if ($this->role == 'admin') {
            $this->data['data'] = $this->model->detail($this->session->idData);
        } else {
            $this->data['data'] = $this->model->detail($this->session->activeCompany['id']);
        }
        $this->render('edit');
    }

    function detail() {
        if ($this->input->post('initDetail')) {
            $this->session->set_userdata('idData', $this->input->post('initDetail'));
        }
        if ($this->role == 'admin') {
            $company = $this->model->detail($this->session->idData);
        } else {
            $company = $this->model->detail($this->session->activeCompany['id']);
        }
        if (!empty($company)) {
            $this->data['data'] = $company;
            $this->db->join('personil p', 'p.id = u.id_personil AND p.id_company='. $company['id']);
            $this->data['pic'] = count($this->db->get_where('users u', ['u.id_role'=> '2'])->result());
            $this->db->join('personil p', 'p.id = u.id_personil AND p.id_company='. $company['id']);
            $this->data['akun'] = count($this->db->get_where('users u', ['u.id_role!='=> '2'])->result());
            $this->data['unit_kerja'] = $this->db->get_where('unit_kerja', ['id_company'=> $company['id']])->result_array();
            $this->data['personil'] = $this->db->get_where('personil', ['id_company'=> $company['id']])->result_array();
            $this->db->join('company_standard cs', 'cs.id_standard = s.id');
            $this->data['standard'] = $this->db->get_where('standard s', ['cs.id_company'=> $company['id']])->result_array();
        }else{
            echo 'NO DATA';
        }
        $this->subModule = 'read';
        $this->subTitle = 'Detail';
        $this->render('detail');
    }

}
