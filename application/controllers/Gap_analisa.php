<?php

class Gap_analisa extends MY_Controller {

    protected $module = 'gap_analisa';

    function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_kuesioner', 'model');
    }

    function index() {
        if ($this->input->post('edit')) {
            $this->session->set_userdata('idData', $this->input->post('edit'));
            redirect($this->module . '/edit');
        } else if ($this->input->post('detail')) {
            $this->session->set_userdata('idData', $this->input->post('detail'));
            redirect($this->module . '/detail');
        }
        $pasal = $this->m_pasal->get();
        $this->subModule = 'read';
        if ($this->role == 'admin') {
            foreach ($pasal as $k => $p) {//admin
                $n = 1;
                $pertanyaan = $this->db->get_where('kuesioner', ['id_pasal' => $p['id']])->result_array();
                foreach ($pertanyaan as $k2 => $p2) {
                    $status = $this->model->getStatus($p2['id']);
                    $pertanyaan[$k2]['status'] = $status;
                    $n2 = count($status) + 1;
                    $pertanyaan[$k2]['row'] = $n2;
                    $n += $n2;
                }
                $pasal[$k]['pertanyaan'] = $pertanyaan;
                $pasal[$k]['row'] = $n;
            }
            $this->data['data'] = $pasal;
            $this->render('index0');
        } else {
            foreach ($pasal as $k => $v) {//pic
                $counts = $this->model->counts($v['id']);
                $pasal[$k]['pertanyaan'] = $counts['pertanyaan'];
                $pasal[$k]['unit'] = $counts['unit'];
                $pasal[$k]['status'] = round($counts['status']);
            }
            $this->data['data'] = $pasal;
            $this->render('index3');
        }
//        $this->render('index3');
    }

    function detail() {
        if ($this->input->post('tambah')) {
            $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
            $this->db->set('id_kuesioner', $this->input->post('id'));
            $this->db->set('status', $this->input->post('status'));
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
        $stats = [];
        $this->data['pasal'] = $this->m_pasal->get($this->session->idData);
        $que = $this->db->get_where('kuesioner', ['id_pasal' => $this->session->idData])->result_array();
        $sum = 0;
        foreach ($que as $k => $v) {
            $stat = $this->model->getStatus($v['id']);
            $que[$k]['detail'] = $stat;
//            $que[$k]['average'] = $this->model->getAverage($v['id']);
            $stats = array_merge($stats, $stat);
            foreach ($stat as $k2 => $v2) {
                $sum+= $v2['status'];
            }
        }
        $this->data['average'] = $sum/ count($stats);
        $this->data['pertanyaan'] = $que;
        $this->data['status'] = $stats;
        $this->data['unit_kerja'] = $this->db->get_where('unit_kerja', ['id_company' => $this->session->activeCompany['id']])->result_array();
        $this->render('detail');
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
        $this->data['status'] = $this->model->getStatus($this->session->idData);
        $this->data['unit_kerja'] = $this->db->get_where('unit_kerja', ['id_company' => $this->session->activeCompany['id']])->result_array();
        $this->render('edit2');
    }

}
