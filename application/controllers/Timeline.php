<?php

class Timeline extends MY_Controller {

    protected $module = 'timeline';

    function index() {
        $this->subModule = 'read';
        if ($this->session->user['role'] == 'admin') {
            $this->data['menuStandard'] = 'standardOnly';
            $this->load->model('m_pasal');
            $this->data['pasal'] = $this->m_pasal->getByStandard($this->session->activeStandards['id']);
            $this->render('indexAdmin');
        } else {//pic
            $this->data['menuStandard'] = 'standard';
            $standard = $this->db->get_where('standard', ['id' => $this->session->activeStandard['id']])->row_array();
            $pasals = ['analisa_resiko', 'audit_internal', 'tinjauan_manajemen'];
            foreach ($pasals as $k => $p) {
                if (!empty($standard['pasal_' . $p])) {
                    $standard['pasal_name_' . $p] = $this->db->get_where('pasal', ['id' => $standard['pasal_' . $p]])->row_array()['name'];
                    $pemenuhan = $this->getPemenuhanByPasal($standard['pasal_' . $p]);
                    $standard['status_pasal_' . $p] = round(($pemenuhan['doc'] + $pemenuhan['imp'])/2);
                }
                    $standard['status_pasal_' . $p] = '0';
            }
            $this->data['standard'] = $standard;
            $this->data['gapAnalisa'] = $this->db->get_where('gap_analisa', ['id_company' => $this->session->activeCompany['id'], 'id_standard' => $this->session->activeStandard['id']])->result();
            $this->render('index');
        }
    }

    function set_gap() {
        $this->db->set('id_gap_analisa', $this->input->post('gap'));
        $this->db->where('id', $this->session->activeStandard['id_company_standard']);
        $this->db->update('company_standard');
    }

    function get_timeline() {
        $this->db->select('cs.*, ga.judul AS gap_analisa,');
        $this->db->join('gap_analisa ga', 'ga.id = cs.id_gap_analisa', 'LEFT');
        $timeline = $this->db->get_where('company_standard cs', ['cs.id' => $this->session->activeStandard['id_company_standard']])->row();
        if (!empty($timeline->id_gap_analisa)) {
            $this->db->select_avg('ks.status');
            $this->db->join('kuesioner k', 'k.id = ks.id_kuesioner AND k.id_gap_analisa =' . $timeline->id_gap_analisa);
            $status = $this->db->get('kuesioner_status ks')->row();
            $timeline->statusGap = empty($status) ? 0 : round($status->status);
        } else {
            $timeline->statusGap = 0;
        }
        $timeline->statusDistribusi = $this->status_distribusi();
        echo json_encode($timeline);
    }

    function upload1() {
//        $timeline = $this->db->get_where('timeline', ['id_company_standard' => $this->session->activeStandard['id_company_standard']])->result();
        $this->data['status'] = 'success';
        $header = $this->input->post('header');
        if (!empty($header)) {
            $type = $this->input->post('type');
            $this->db->set($header . '_type', $type);
            $path = null;
            if ($type == 'file' | $type == 'foto') {
                $config['upload_path'] = './upload/' . $header;
                $config['allowed_types'] = '*';
                $config['max_size'] = 100000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload($type)) {
                    $path = $this->upload->data()['file_name'];
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = $this->upload->display_errors();
                }
            } else if ($type == 'url') {
                $path = $this->input->post('url');
            }
            if ($this->data['status'] == 'success') {
                $this->db->set($header . '_path', $path);
                $this->db->where('id', $this->session->activeStandard['id_company_standard']);
                $this->db->update('company_standard');
            }
            echo json_encode($this->data);
        }
    }

    private function status_distribusi() {
        $this->db->select('p.*');
        $this->db->join('position_personil pp', 'pp.id_personil = p.id');
        $this->db->join('distribution ds', 'ds.id_position_personil = pp.id');
        $this->db->where('p.id_company', $this->session->activeCompany['id']);
        $this->db->group_by('p.id');
        $this->db->from('personil p');
        $cDist = $this->db->count_all_results();
        $this->db->where('p.id_company', $this->session->activeCompany['id']);
        $cPers = $this->db->count_all_results('personil p');
        return round($cDist / $cPers * 100);
    }

    function get_for_admin() {
        $this->db->where('id', $this->session->activeStandards['id']);
        $data = $this->db->get('standard')->row();
        echo json_encode($data);
    }

    function edit() {
        $data = [];
        if (!empty($this->input->post('header'))) {
            $this->db->set('desc_' . $this->input->post('header'), $this->input->post('asal_data'));
            if ($this->input->post('set_pasal') == 2 & !empty($this->input->post('pasal'))) {
                $this->db->set('pasal_' . $this->input->post('header'), $this->input->post('pasal'));
            }
            $this->db->where('id', $this->session->activeStandards['id']);
            $this->db->update('standard');
            $data['message'] = 'success';
            die(json_encode($data));
        }
    }

    private function getPemenuhanByPasal($id_pasal) {
        $child = $this->db->get_where('pasal p', ['p.parent' => $id_pasal])->result();
        $doc = 0;
        $imp = 0;
        if (empty($child)) {//tidak memiliki anak
            $docs = $this->db->get_where('document_pasal', ['id_pasal' => $id_pasal])->result();
            if (empty($docs)) {
                
            } else {
                foreach ($docs as $k => $d) {
                    $imp += $this->getPemenuhanImplementasiByDocument($d->id_document);
                }
                $imp = round($imp / count($docs));
                $doc = 100;
            }
        } else {//memiliki anak
            $sumDoc = 0;
            $sumImp = 0;
            foreach ($child as $k => $c) {
                $data = $this->getPemenuhanByPasal($c->id);
                $sumDoc += $data['doc'];
                $sumImp += $data['imp'];
            }
            $doc = floor($sumDoc / count($child));
            $imp = floor($sumImp / count($child));
        }
        return ['doc' => $doc, 'imp' => $imp];
    }

    private function getPemenuhanImplementasiByDocument($id_document) {
        $this->db->select('COUNT(j.id) AS total, SUM(IF(j.path IS NULL, 0, 1)) AS complete');
        $this->db->join('tugas t', 't.id_document = d.id');
        $this->db->join('jadwal j', 'j.id_tugas = t.id');
        $this->db->group_by('d.id');
        $data = $this->db->get('document d')->row();
        return floor($data->complete / $data->total * 100);
    }

}
