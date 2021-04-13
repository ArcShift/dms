<?php

class Hasil_gap_analisa extends MY_Controller {

    protected $module = 'hasil_gap_analisa';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_pasal');
        $this->load->model('m_gap_analisa', 'model');
    }

    function index() {
        $this->subModule = 'read';
        $pasal = $this->m_pasal->get();
        foreach ($pasal as $k => $p) {
            $n = 1;
            $pertanyaan = $this->db->get_where('kuesioner', ['id_pasal' => $p['id']])->result_array();
            foreach ($pertanyaan as $k2 => $p2) {
                $status = $this->model->getUnit($p2['id']);
                $pertanyaan[$k2]['unit'] = $status;
                $n2 = count($status) + 1;
                $pertanyaan[$k2]['row'] = $n2;
                $n += $n2;
//                $n ++;
            }
            $pasal[$k]['pertanyaan'] = $pertanyaan;
            $pasal[$k]['row'] = $n;
        }
        $this->data['data'] = $pasal;
        $this->render('index');
    }

}
