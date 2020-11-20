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
            $idx = base_convert($i+1, 10, 36);
            $idx = sprintf("%02s", strtoupper($idx));
            if($sort_index!==null){
                $idx = $sort_index.$idx;
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

}
