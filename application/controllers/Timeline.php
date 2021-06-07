<?php

class Timeline extends MY_Controller {

    protected $module = 'timeline';

    function index() {
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['gapAnalisa'] = $this->db->get_where('gap_analisa', ['id_company' => $this->session->activeCompany['id'], 'id_standard' => $this->session->activeStandard['id']])->result();
        $this->render('index');
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
        $this->db->where('p.id_company',$this->session->activeCompany['id']);
        $this->db->group_by('p.id');
        $this->db->from('personil p');
        $cDist = $this->db->count_all_results();
        $this->db->where('p.id_company',$this->session->activeCompany['id']);
        $cPers = $this->db->count_all_results('personil p');
        return round($cDist / $cPers *100);
    }

}
