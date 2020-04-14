<?php

class M_setup extends CI_Model {

    function access() {
        $result = $this->db->get('module')->result_array();
        $this->db->trans_begin();
        foreach ($result as $r) {
            $data = array('role' => '1', 'module' => $r['id'], 'acc_read' => '1', 'acc_create' => '1', 'acc_update' => '1', 'acc_delete' => '1');
            $this->db->insert('access', $data);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function setup($table, $file = null) {
        if (empty($file)) {
            $file = $table;
        }
        if ($this->db->count_all($table) == 0) {
            if ($this->db->query(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/dms/assets/db/' . $file . '.sql'))) {
                echo 'data ' . $table . ' imported';
            } else {
                die('ERROR ' . $table . ': ' . $this->db->error()['message']);
            }
        } else {
            echo 'data ' . $table . ' already exist';
        }
        echo '<br/>';
    }

}
