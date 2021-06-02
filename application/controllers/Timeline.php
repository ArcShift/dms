<?php

class Timeline extends MY_Controller {

    protected $module = 'timeline';

    function index() {
        $this->data['menuStandard'] = 'standard';
        $this->subModule = 'read';
        $this->data['gapAnalisa'] = $this->db->get_where('gap_analisa', ['id_company' => $this->session->activeCompany['id'], 'id_standard' => $this->session->activeStandard['id']])->result();
//        print_r($this->data['gapAnalisa']);
//        die();
        $this->render('index');
    }

    function set_gap() {
        $timeline = $this->db->get_where('timeline', ['id_company_standard' => $this->session->activeStandard['id_company_standard']])->result();
        $this->db->set('id_gap_analisa', $this->input->post('gap'));
        if (empty($timeline)) {
            $this->db->set('id_company_standard', $this->session->activeStandard['id_company_standard']);
            $this->db->insert('timeline');
        } else {
            $this->db->where('id_company_standard', $this->session->activeStandard['id_company_standard']);
            $this->db->update('timeline');
        }
    }

    function get_timeline() {
        $this->db->select('t.*, ga.judul AS gap_analisa,');
        $this->db->join('gap_analisa ga', 'ga.id = t.id_gap_analisa', 'LEFT');
        $timeline = $this->db->get_where('timeline t', ['t.id_company_standard' => $this->session->activeStandard['id_company_standard']])->row();
        $this->db->select_avg('ks.status');
        $this->db->join('kuesioner k', 'k.id = ks.id_kuesioner AND k.id_gap_analisa =' . $timeline->id_gap_analisa);
        $status = $this->db->get('kuesioner_status ks')->row();
        $timeline->statusGap = empty($status) ? 0 : round($status->status);
        echo json_encode($timeline);
    }

}
