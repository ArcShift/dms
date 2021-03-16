<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_setting
 *
 * @author kaafi
 */
class M_setting extends CI_Model {

    function set($key, $val) {
        $result = $this->db->get_where('setting', ['key' => $key])->row_array();
        $this->db->set('value', $val);
        if (empty($result)) {
            $this->db->set('key', $key);
            $this->db->insert('setting');
        } else {
            $this->db->where('key', $key);
            $this->db->update('setting');
        }
    }

    function get($key) {
        $result = $this->db->get_where('setting', ['key' => $key])->row_array();
        if (empty($result)) {
            return null;
        } else {
            return $result['value'];
        }
    }

}
