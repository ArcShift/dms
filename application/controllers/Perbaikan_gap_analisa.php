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
        } elseif ($this->input->post('upload')) {
            $this->session->set_userdata('idData', $this->input->post('upload'));
            redirect($this->module . '/upload_bukti');
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
        $pertanyaan = $this->db->get_where('kuesioner', ['id_gap_analisa' => $this->session->gapAnalisa['id']])->result_array();
        foreach ($pertanyaan as $k2 => $p2) {
            $status = $this->model->getUnit($p2['id']);
            foreach ($status as $k3 => $s) {
                $this->db->select('bga.*, d.judul, d.type_doc');
                $this->db->join('document d', 'd.id = bga.id_document', 'LEFT');
                $imp = $this->db->get_where('bukti_perbaikan_gap_analisa bga', ['bga.id_kuesioner_detail' => $s['id']])->result_array();
                $status[$k3]['implementasi'] = $imp;
                $status[$k3]['dl'] = 0;
                if (!empty($imp) & !empty($s['target'])) {
                    $d1 = new DateTime(date('Y-m-d', strtotime($imp[0]['created_at'])));
                    $d2 = new DateTime($s['target']);
                    $status[$k3]['dl'] = $d1->diff($d2);
                    if ($d1->diff($d2)->invert) {
                        $status[$k3]['deadline'] = 'danger';
                    } else {
                        $status[$k3]['deadline'] = 'success';
                    }
                } else {
                    $status[$k3]['deadline'] = 'secondary';
                }
            }
            $pertanyaan[$k2]['unit'] = $status;
            $n2 = count($status) + 1;
            $pertanyaan[$k2]['row'] = $n2;
        }
        $this->data['data'] = $pertanyaan;
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
        $this->db->where('ks.id', $this->input->get('id'));
        $data = $this->db->get('kuesioner_status ks')->row_array();
        echo json_encode($data);
    }

    function upload_bukti() {
        if ($this->input->post('tambah')) {
            $this->db->set('id_kuesioner_detail', $this->session->idData);
            $type = $this->input->post('type');
            $this->db->set('type', strtoupper($type));
            if ($type == 'file') {
                $config['upload_path'] = './upload/rev_gap_analisa';
                $config['allowed_types'] = '*';
                $config['max_size'] = 100000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('userfile')) {
                    $path = $this->upload->data()['file_name'];
                } else {
                    $this->data['status'] = 'error';
                    $this->data['msgError'] = $this->upload->display_errors();
                }
            } elseif ($type == 'url') {
                $path = $this->input->post('url');
            } elseif ($type == 'doc') {
                $this->db->set('id_document', $this->input->post('doc'));
            }
            if (isset($path)) {
                $this->db->set('path', $path);
            }
            $this->db->insert('bukti_perbaikan_gap_analisa');
        } elseif ($this->input->post('hapus')) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('bukti_perbaikan_gap_analisa');
        }
        $this->subModule = 'edit';
        $this->subTitle = 'Upload Bukti';
        $this->data['document'] = $this->model->getDocument();
        $this->db->select('pga.*, d.judul, d.type_doc');
        $this->db->join('document d', 'd.id = pga.id_document', 'LEFT');
        $this->db->where('pga.id_kuesioner_detail', $this->session->idData);
        $this->data['uploads'] = $this->db->get('bukti_perbaikan_gap_analisa pga')->result_array();
        $this->render('upload_bukti');
    }

}
