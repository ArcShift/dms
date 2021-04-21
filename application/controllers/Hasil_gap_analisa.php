<?php

class Hasil_gap_analisa extends MY_Controller {

    protected $module = 'hasil_gap_analisa';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_gap_analisa', 'model');
        $this->load->model('m_kuesioner', 'model2');
    }

    function index() {
        if ($this->input->post('edit')) {
            if ($this->input->post('type') == 'file') {
                $config['upload_path'] = './upload/imp_gap_analisa';
                $config['allowed_types'] = '*';
                $config['max_size'] = 50000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('userfile')) {
                    $this->model->update_hasil($this->upload->data()['file_name']);
                } else {
                    $this->data['msgError'] = $this->upload->display_errors();
                }
            } elseif ($this->input->post('type') == 'url') {
                $this->model->update_hasil($this->input->post('url'));
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
        if ($this->session->has_userdata('gapAnalisa')) {
            $data = $this->model2->get();
            foreach ($data as $k => $d) {
                $status = $this->model->getUnit($d['id']);
                $data[$k]['status'] = $status;
                $data[$k]['row'] = count($status) + 1;
            }
            $this->data['data'] = $data;
        }
        $this->render('index');
    }

    function switch_gap_analisa() {
        $gap = $this->model->get($this->input->get('id'));
        $this->session->set_userdata('gapAnalisa', $gap);
        echo 'success';
    }

    function detail() {
        $this->db->select('ks.*, p.name AS pasal, p.bukti AS bukti_pasal');
        $this->db->join('kuesioner k', 'k.id = ks.id_kuesioner');
        $this->db->join('pasal p', 'p.id = k.id_pasal');
        $this->db->where('ks.id',$this->input->get('id'));
        $data =$this->db->get('kuesioner_status ks')->row_array();
        echo json_encode($data);
    }

}
