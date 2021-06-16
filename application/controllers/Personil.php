<?php

class Personil extends MY_Controller {

    protected $module = "personil";

    function __construct() {
        parent::__construct();
        $this->load->model('m_personil', 'model');
        $this->load->model('m_log');
        $this->data['company'] = $this->model->company();
        $this->load->library('form_validation');
    }

    function index() {
        $this->data['menuStandard'] = true;
        $this->subTitle = 'List';
        $this->data['data'] = $this->model->read();
        $this->render('read');
    }

    function create() {
        $this->subTitle = 'Create';
        if ($this->input->post('buat')) {
            if ($id = $this->model->create()) {
                $this->m_log->create_personil($id);
                $this->session->set_userdata('idData', $id);
                redirect($this->module);
            } else {
                //SHOW ERROR
            }
        }
        $this->data['data'] = $this->model->read();
        $this->render('create');
    }

    function edit() {
        $this->subTitle = 'Edit';
        if ($this->input->post('initEdit')) {
            $this->session->set_userdata('idData', $this->input->post('initEdit'));
        } elseif ($this->input->post('edit')) {
            $result = $this->model->detail($this->input->post('edit'));
            $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
            if ($this->form_validation->run()) {
                if ($this->model->updateData()) {
                    $this->m_log->update_personil($result['id']);
                    $this->session->set_flashdata('msgSuccess', 'Data berhasil diedit');
                    redirect($this->module);
                } else {
                    $this->session->set_flashdata('msgError', $this->db->error()['message']);
                }
            } else {
                die(validation_errors());
            }
        } elseif ($this->input->post('delete')) {
            $this->model->delete_unit_kerja();
        } elseif ($this->input->post('add')) {
            $this->model->add_unit_kerja();
        } elseif ($this->input->post('jobdesk')) {
            $this->session->set_userdata('idData', $this->input->post('jobdesk'));
            redirect($this->module . '/jobdesk');
        }
        $this->data['data'] = $this->model->detail($this->session->idData);
        $this->render('edit');
    }

    function delete() {
        $this->subTitle = 'Hapus';
        if ($this->input->post('initHapus')) {
            $this->session->set_userdata('delete', $this->input->post('initHapus'));
        } else if ($this->input->post('hapus')) {
            $data = $this->model->detail($this->session->delete);
            foreach ($data['unit_kerja'] as $uk) {
                $this->db->set('pembuat', 'NULL', false);
                $this->db->where('pembuat', $uk['id_position_personil']);
                $this->db->update('document');
                $this->db->where('id_position_personil', $uk['id_position_personil']);
                $this->db->delete('distribution');
                $this->db->where('id_position_personil', $uk['id_position_personil']);
                $this->db->delete('personil_task');
            }
            $this->db->where('id_personil', $this->input->post('id'));
            $this->db->delete('position_personil');
            $this->db->where('id_personil', $this->input->post('id'));
            $this->db->delete('users');
            $result = $this->db->get_where('personil', ['id' => $this->input->post('id')])->row_array();
            $message = '<b>' . $this->session->user['fullname'] . '</b> menghapus data personil <b>' . $result['fullname'] . '</b> pada perusahaan <b>' . $this->session->activeCompany['name'] . '</b>';
            $this->db->where('id', $this->input->post('id'));
            if ($this->db->delete('personil')) {
                $this->m_log->delete_personil($message);
                $this->session->set_flashdata('msgSuccess', 'Data berhasil dihapus');
                redirect($this->module);
            }
        }
        $id = $this->session->delete;
        $this->data['data'] = $this->model->detail($id);
        $this->render('delete');
    }

    function unit_kerja() {
        echo json_encode($this->model->unit_kerja($this->input->post('id')));
    }

    function jobdesk() {
        $this->subModule = 'edit';
        $this->subTitle = 'Jobdesk';
        $this->db->select('p.fullname, uk.name AS unit_kerja, pp.id_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->where('pp.id', $this->session->idData);
        $header = $this->db->get('position_personil pp')->row();
        $this->data['header'] = $header;
        if ($this->input->post('add')) {
            $this->db->set('desc', $this->input->post('jp'));
            $this->db->set('id_personil', $header->id_personil);
            $this->db->set('id_jobdesk', $this->input->post('id_ju'));
            $this->db->insert('personil_jobdesk');
        } elseif ($this->input->post('edit')) {
//            $edit = $this->db->get_where('personil_jobdesk pj', ['id_personil' => $header->id_personil, 'id_jobdesk' => $this->input->post('id_ju')])->row();
//            $this->db->set('desc', $this->input->post('jp'));
//            if (empty($edit)) {
//                $this->db->set('id_personil', $header->id_personil);
//                $this->db->set('id_jobdesk', $this->input->post('id_ju'));
//                $this->db->insert('personil_jobdesk');
//            } else {
//                $this->db->where('id_personil', $header->id_personil);
//                $this->db->where('id_jobdesk', $this->input->post('id_ju'));
//                $this->db->update('personil_jobdesk');
//            }
        } else if ($this->input->get('back')) {
            $this->session->set_userdata('idData', $header->id_personil);
            redirect($this->module . '/edit');
        }
        $this->db->select('jd.id AS id_jobdesk, jd.name AS jobdesk');
        $this->db->join('unit_kerja uk', 'uk.id = jd.id_unit_kerja');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id=' . $this->session->idData);
//        $this->db->join('personil_jobdesk pj', 'pj.id_jobdesk = jd.id AND pj.id_personil = pp.id_personil', 'LEFT');
        $data = $this->db->get('jobdesk jd')->result();
        foreach ($data as $k => $d) {
            $data[$k]->jobdesk_personil = $this->db->get_where('personil_jobdesk', ['id_jobdesk' => $d->id_jobdesk, 'id_personil' => $header->id_personil])->result();
        }
        $this->data['data'] = $data;
        $this->render('jobdesk');
    }

}
