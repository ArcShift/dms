<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dev
 *
 * @author kaafi
 */
class Dev extends CI_Controller {
    function sort() {
        $standard = $this->db->get('standard')->result_array();
        foreach ($standard as $std) {
            $this->db->select('p.id, p.parent, COUNT(p2.id) AS child');
            $this->db->where('p.id_standard', $std['id']);
            $this->db->where('p.parent', null);
            $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
            $this->db->group_by('p.id');
            $pasal = $this->db->get('pasal p')->result_array();
            $this->list($pasal);
        }
    }

    function list($pasal, $sort_index = null) {
        for ($i = 0; $i < count($pasal); $i++) {
            $psl = $pasal[$i];
            $idx = base_convert($i + 1, 10, 36);
            $idx = sprintf("%02s", strtoupper($idx));
            if ($sort_index !== null) {
                $idx = $sort_index . $idx;
            }
            $this->db->where('id', $psl['id']);
            $this->db->set('sort_index', $idx);
            $this->db->update('pasal');
            print_r($psl);
            echo '<br>';
            if ($psl['child']) {
                $this->db->select('p.id, p.parent, COUNT(p2.id) AS child');
                $this->db->join('pasal p2', 'p2.parent = p.id', 'LEFT');
                $this->db->where('p.parent', $psl['id']);
                $this->db->group_by('p.id');
                $p = $this->db->get('pasal p')->result_array();
                $this->list($p, $idx);
            }
        }
    }

    function sort_child() {
        $standard = $this->db->get('standard')->result_array();
        foreach ($standard as $std) {
            $this->db->where('id_standard', $std['id']);
            $this->db->where('parent', null);
            $pasal = $this->db->get('pasal')->result_array();
            for ($i = 0; $i < count($pasal); $i++) {
                $idx = base_convert($i, 10, 36);
                $idx = sprintf("%02s", strtoupper($idx));
                $this->db->where('id', $pasal[$i]['id']);
                $this->db->set('sort_index', $idx);
                $this->db->update('pasal');
            }
        }
    }

    function migration_unit_kerja() {
        $this->db->select('p.*, uk.id_company');
        $this->db->join('unit_kerja uk', 'uk.id = p.id_unit_kerja');
        $personil = $this->db->get('personil p')->result_array();
        foreach ($personil as $p) {
            print_r($p);
            echo '<br>';
            //set perusahaan
            $this->db->set('id_company', $p['id_company']);
            $this->db->where('id', $p['id']);
            $this->db->update('personil');
            //set unit kerja
            $this->db->set('id_unit_kerja', $p['id_unit_kerja']);
            $this->db->set('id_personil', $p['id']);
            $this->db->insert('position_personil');
            //remove unit kerja
            //TODO
        }
        echo 'success';
    }

    function migration_document_creator() {
        $this->db->select('d.*, pp.id AS id_pembuat');
        $this->db->where('creator IS NOT NULL');
        $this->db->join('position_personil pp', 'pp.id_personil= d.creator');
        $this->db->group_by('d.id');
        $document = $this->db->get('document d')->result_array();
        foreach ($document as $d) {
            print_r($d);
            echo '<br>';
            $this->db->set('pembuat',$d['id_pembuat']);
            $this->db->where('id', $d['id']);
            $this->db->update('document');
        }
    }
    function migration_distribution() {
        $this->db->select('d.*, pp.id AS id_position_personil');
        $this->db->join('position_personil pp', 'pp.id_personil= d.id_personil');
        $this->db->group_by('d.id');
        $dist =$this->db->get('distribusi d')->result_array();
        echo count($dist);
        foreach ($dist as $d) {
            echo '<br>';
            print_r($d);
            $this->db->set('id_position_personil', $d['id_position_personil']);
            $this->db->set('id_document', $d['id_document']);
            $this->db->insert('distribution');
        }
    }
    function migration_penerima_tugas() {
        $this->db->select('pt.*, pp.id AS id_position_personil');
        $this->db->join('position_personil pp', 'pp.id_personil = pt.id_personil');
        $this->db->group_by('pt.id');
        $penerima = $this->db->get('penerima_tugas pt')->result_array();
        foreach ($penerima as $p) {
            echo '<br>';
            print_r($p);
            $this->db->set('id_position_personil', $p['id_position_personil']);
            $this->db->set('id_tugas', $p['id_tugas']);
            $this->db->insert('personil_task');
        }
    }
    function document_set_standard() {
        $this->db->where('id_standard IS NULL');
        $this->db->where('id_pasal IS NOT NULL');
        $document = $this->db->get('document')->result_array();
        foreach ($document as $k => $v) {
            $this->db->where('id', $v['id_pasal']);
            $pasal = $this->db->get('pasal')->row_array();
            $this->db->set('id_standard', $pasal['id_standard']);
            $this->db->where('id', $v['id']);
            $this->db->update('document');
        }
    }
    function document_set_pasal(){//if document has no pasal
        $this->db->select('d.*');
        $this->db->join('document_pasal dp', 'dp.id_document = d.id', 'LEFT');
        $this->db->where('dp.id IS NULL');
        $this->db->group_by('d.id');
        $docs = $this->db->get('document d')->result();
        foreach ($docs as $d) {
            echo $d->id.'<br>';
            $this->db->set('id_document', $d->id);
            $this->db->set('id_pasal', $d->id_pasal);
            $this->db->insert('document_pasal');
        }
    }
    function datatable_test(){
        $this->load->view('test/datatable2');
    }
    function file_test(){
        print_r(scandir('upload/implementasi'));
    }
    function migration_gap_analisa() {
        $this->db->join('kuesioner k', 'k.id = ks.id_kuesioner');
        $data = $this->db->get('kuesioner_status ks')->result();
        foreach ($data as $k => $d) {
            $this->db->set('id_gap_analisa', $d->id_gap_analisa);
            $this->db->insert('kuesioner_status');
        }
    }
}
