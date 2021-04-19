<?php

class Gap_analisa1 extends MY_Controller {

    protected $module = 'gap_analisa1';

    function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_kuesioner');
        $this->load->model('m_gap_analisa', 'model');
    }

    function index() {
        if ($this->input->post('edit')) {
            $this->session->set_userdata('idData', $this->input->post('edit'));
            redirect($this->module . '/edit');
        } else if ($this->input->post('edit_pertanyaan')) {
            $this->session->set_userdata('idData', $this->input->post('edit_pertanyaan'));
            redirect($this->module . '/edit2');
        }
        $gap = $this->model->get();
        $this->data['gap_analisa'] = $gap;
        if ($this->session->has_userdata('gapAnalisa')) {
            if ($this->session->gapAnalisa['id_standard'] != $this->session->activeStandard['id']) {
                if (!empty($gap)) {
                    $this->session->set_userdata('gapAnalisa', $gap[0]);
                } else {
                    $this->session->unset_userdata('gapAnalisa');
                }
            }
        } else {
            if (!empty($gap)) {
                $this->session->set_userdata('gapAnalisa', $gap[0]);
            }
        }
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $pasal = $this->m_pasal->get();
        if ($this->session->has_userdata('gapAnalisa')) {
            foreach ($pasal as $k => $p) {
                $n = 0;
                $pertanyaan = $this->db->get_where('kuesioner', ['id_pasal' => $p['id'], 'id_gap_analisa' => $this->session->gapAnalisa['id']])->result_array();
                foreach ($pertanyaan as $k2 => $p2) {
                    $status = $this->m_kuesioner->getStatus($p2['id']);
                    $pertanyaan[$k2]['status'] = $status;
                    $n2 = count($status);
                    $pertanyaan[$k2]['row'] = $n2 == 0 ? 1 : $n2;
                    $n += $n2;
                    if ($n2 == 0)
                        $n++;
                }
                $pasal[$k]['pertanyaan'] = $pertanyaan;
                $pasal[$k]['row'] = $n == 0 ? 1 : $n;
            }
        }
        $this->data['data'] = $pasal;
        if ($this->role == 'admin') {
            $this->render('index0');
        } else {
            $this->render('index');
        }
    }

    function index2() {
        if ($this->input->post('edit')) {
            $this->session->set_userdata('idData', $this->input->post('edit'));
            redirect($this->module . '/edit');
        }
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $p) {
            $n = 1;
            $pertanyaan = $this->db->get_where('kuesioner', ['id_pasal' => $p['id']])->result_array();
            foreach ($pertanyaan as $k2 => $p2) {
                $pertanyaan[$k]['status'] = $this->m_kuesioner->getStatus($p2['id']);
                $n++;
            }
            $pasal[$k]['pertanyaan'] = $pertanyaan;
            $pasal[$k]['row'] = $n;
        }
        $this->data['data'] = $pasal;
        $this->render('index0');
    }

    function edit() {
        if ($this->input->post('save')) {
            $this->db->set('kuesioner', $this->input->post('pertanyaan'));
            $this->db->set('id_pasal', $this->session->idData);
            $this->db->insert('kuesioner');
        } elseif ($this->input->post('edit')) {
            $this->db->set('kuesioner', $this->input->post('pertanyaan'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('kuesioner');
        } elseif ($this->input->post('hapus')) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('kuesioner');
        }
        $this->data['pasal'] = $this->m_pasal->get($this->session->idData);
        $this->data['pertanyaan'] = $this->db->get_where('kuesioner', ['id_pasal' => $this->session->idData])->result_array();
        $this->subTitle = 'Edit';
        $this->render('edit');
    }

    function edit2() {
        if ($this->input->post('tambah')) {
            $this->db->set('id_kuesioner', $this->session->idData);
            $this->db->set('status', $this->input->post('status'));
            $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
            $this->db->insert('kuesioner_status');
        } elseif ($this->input->post('edit')) {
            $this->db->set('status', $this->input->post('status'));
            $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('kuesioner_status');
        } elseif ($this->input->post('hapus')) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('kuesioner_status');
        }
        $this->subModule = 'edit';
        $this->data['pertanyaan'] = $this->db->get_where('kuesioner', ['id' => $this->session->idData])->row_array();
        $this->data['status'] = $this->m_kuesioner->getStatus($this->session->idData);
        $this->data['unit_kerja'] = $this->db->get_where('unit_kerja', ['id_company' => $this->session->activeCompany['id']])->result_array();
        $this->render('edit2');
    }

    function switch_gap_analisa() {
        $gap = $this->model->get($this->input->get('id'));
        $this->session->set_userdata('gapAnalisa', $gap);
        echo 'success';
    }

}
