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
        } else if ($this->input->post('upload')) {
            $this->session->set_userdata('idData', $this->input->post('upload'));
            redirect($this->module . '/upload_bukti');
        } else if ($this->input->post('edit2')) {
            $this->m_kuesioner->update();
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
                    foreach ($status as $k3 => $s) {
                        $this->db->select('bga.*, d.judul, d.type_doc');
                        $this->db->join('document d', 'd.id = bga.id_document', 'LEFT');
                        $status[$k3]['implementasi'] = $this->db->get_where('bukti_gap_analisa bga', ['bga.id_kuesioner_detail' => $s['id']])->result_array();
                    }
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

    function edit() {
        if ($this->input->post('save')) {
            $this->db->set('kuesioner', $this->input->post('pertanyaan'));
            $this->db->set('id_pasal', $this->session->idData);
            $this->db->set('id_gap_analisa', $this->session->gapAnalisa['id']);
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
        $this->data['pertanyaan'] = $this->db->get_where('kuesioner', ['id_pasal' => $this->session->idData, 'id_gap_analisa' => $this->session->gapAnalisa['id']])->result_array();
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

    function detail_pertanyaan() {
//        $this->db->select('ks.*, p.bukti, p.long_desc, k.id_pasal');
        $this->db->select('ks.*, k.id_pasal, k.kuesioner');
        $this->db->join('kuesioner k', 'k.id = ks.id_kuesioner');
        $this->db->join('pasal p', 'p.id = k.id_pasal');
        $data = $this->db->get_where('kuesioner_status ks', ['ks.id' => $this->input->get('id')])->row_array();
        $data['pasal'] = $this->db->get_where('pasal', ['id' => $data['id_pasal']])->row();
        echo json_encode($data);
    }

    function upload_bukti() {
        if ($this->input->post('tambah')) {
            $this->db->set('id_kuesioner_detail', $this->session->idData);
            $type = $this->input->post('type');
            $this->db->set('type', strtoupper($type));
            if ($type == 'file') {
                $config['upload_path'] = './upload/gap_analisa';
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
            $this->db->insert('bukti_gap_analisa');
        } elseif ($this->input->post('hapus')) {
            $data = $this->db->get_where('bukti_gap_analisa', ['id' => $this->input->post('id')])->row();
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('bukti_gap_analisa');
            if ($data->type == 'FILE' & file_exists('upload/gap_analisa/' . $data->path)) {//delete old file
                unlink('upload/gap_analisa/' . $data->path);
            }
        }
        $this->subTitle = 'Upload Bukti';
        $this->subModule = 'edit';
        if ($this->role == 'anggota') {
            $this->db->join('distribution ds', 'ds.id_document = d.id');
            $this->db->join('position_personil pp', 'pp.id = ds.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->user['id']);
        } else {
            $this->db->where('d.id_company', $this->session->activeCompany['id']);
        }
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
        $this->data['document'] = $this->db->get('document d')->result_array();
        $this->data['unit'] = $this->db->get_where('kuesioner_status', ['id' => $this->session->idData])->result_array();
        $this->db->select('bga.*, d.judul, d.type_doc');
        $this->db->join('document d', 'd.id = bga.id_document', 'LEFT');
        $this->data['uploads'] = $this->db->get_where('bukti_gap_analisa bga', ['bga.id_kuesioner_detail' => $this->session->idData])->result_array();
        $this->render('upload_bukti');
    }

}
