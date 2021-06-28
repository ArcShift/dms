<?php

class Pemenuhan extends MY_Controller {

    protected $module = 'pemenuhan';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    private function ajax_request() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    function index() {
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->data['pemenuhan'] = $this->model->getPemenuhan($this->session->activeCompany['id'], $this->session->activeStandard['id']);
        $this->load->model('m_pasal');
        $pemenuhan = $this->m_pasal->get();
        foreach ($pemenuhan as $k => $p) {
            $this->db->select('COUNT(j.id) AS imp, SUM(IF(j.path IS NULL, 0, 1)) AS selesai');
            $this->db->join('tugas t', 't.id = j.id_tugas');
            $this->db->join('pasal_tugas pt', 'pt.id_tugas = t.id');
            $this->db->join('document_pasal dp', 'dp.id = pt.id_document_pasal');
            $this->db->join('document d', 'd.id = dp.id_document');
            $this->db->join('pasal p', 'p.id = dp.id_pasal AND p.id='.$p['id']);
            $this->db->group_by('p.id');
            $this->db->where('d.id_company', $this->session->activeCompany['id']);
            $this->db->where('d.id_standard', $this->session->activeStandard['id']);
            $imp = $this->db->get('jadwal j')->row_array();
            $p['imp'] = empty($imp)?'0':$imp['imp'];
            $p['imp_selesai'] = empty($imp)?'0':$imp['selesai'];       
            $p['imp_percent'] = empty($imp['imp'])? 0: $imp['selesai']/ $imp['imp'];
//            $this->db->join('')
            $doc = $this->db->get('document d')->row_array();
            $pemenuhan[$k] = $p; 
        }
        $this->data['pemenuhan2'] = $pemenuhan;
        $this->render('index');
    }
    function pasal() {
        $this->session->set_userdata('md_standard', $this->input->get('standar'));
        $this->ajax_request();
        echo json_encode($this->model->pasal());
    }
    function get_pemenuhan() {
        echo json_encode($this->model->getPemenuhan($this->input->get('company'), $this->input->get('standard')));
    }

    function get_pemenuhan_test() {
        $result = $this->model->getPemenuhan($this->input->get('company'), $this->input->get('standard'));
        echo '<table border="1"><thead><tr>'
        . '<td>Index</td>'
        . '<td>sortIndex</td>'
        . '<td>Pasal</td>'
        . '<td>child</td>'
        . '<td>indexParent</td>'
        . '<td>indexChild</td>'
        . '<td>Doc</td>'
        . '<td>pemenuhan Doc</td>'
        . '<td>listDoc</td>'
        . '<td>tugas</td>'
        . '<td>Jadwal</td>'
        . '<td>Jadwals</td>'
        . '<td>Jadwal OK</td>'
        . '</tr></thead><tbody>';
        foreach ($result as $k => $r) {
            echo '<tr>'
            . '<td>' . $k . '</td>'
            . '<td>' . $r['sort_index'] . '</td>'
            . '<td>' . $r['name'] . '</td>'
            . '<td>' . $r['child'] . '</td>'
            . '<td>' . $r['indexParent'] . '</td>'
            . '<td>' . implode(',', $r['indexChild']) . '</td>'
            . '<td>' . $r['doc'] . '</td>'
            . '<td>' . $r['pemenuhanDoc'] . '%</td>'
            . '<td>' . $r['docs'] . '</td>'
            . '<td>' . $r['tugas'] . '</td>'
            . '<td>' . $r['jadwal'] . '</td>'
            . '<td>' . $r['jadwals'] . '</td>'
            . '<td>' . $r['jadwal_ok'] . '</td>'
            . '<td>' . $r['pemenuhanImp'] . '%</td>'
            . '</tr>';
        }
        echo '</tbody></table>';
    }

}
