<?php

class Perbaikan_gap_analisa extends MY_Controller {

    protected $module = 'perbaikan_gap_analisa';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_gap_analisa', 'model');
    }

    function index() {
        if ($this->input->post('edit')) {
            if ($this->input->post('type') == 'file') {
                $config['upload_path'] = './upload/gap_analisa';
                $config['allowed_types'] = '*';
                $config['max_size'] = 100000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('userfile')) {
                    $this->model->update_perbaikan($this->upload->data()['file_name']);
                } else {
                    $this->data['msgError'] = $this->upload->display_errors();
                }
            } else {
                $this->model->update_perbaikan($this->input->post('url'));
            }
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
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $p) {
            $n = 1;
            $pertanyaan = $this->db->get_where('kuesioner', ['id_pasal' => $p['id'], 'id_gap_analisa' => $this->session->gapAnalisa['id']])->result_array();
            foreach ($pertanyaan as $k2 => $p2) {
                $status = $this->model->getUnit($p2['id']);
                $pertanyaan[$k2]['unit'] = $status;
                $n2 = count($status) + 1;
                $pertanyaan[$k2]['row'] = $n2;
                $n += $n2;
            }
            $pasal[$k]['pertanyaan'] = $pertanyaan;
            $pasal[$k]['row'] = $n;
        }
        $this->data['data'] = $pasal;
        $this->render('index');
    }

    function switch_gap_analisa() {
        $gap = $this->model->get($this->input->get('id'));
        $this->session->set_userdata('gapAnalisa', $gap);
        echo 'success';
    }

}
