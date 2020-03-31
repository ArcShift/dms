<?php

class M_setup extends CI_Model {

    function core_table() {
        $role = array(
            array('id' => '1', 'name' => 'admin', 'title' => 'Admin'),
            array('id' => '2', 'name' => 'pic', 'title' => 'PIC'),
            array('id' => '3', 'name' => 'konsultan', 'title' => 'Konsultan'),
            array('id' => '4', 'name' => 'anggota', 'title' => 'Anggota')
        );
        $module = array(
            array('id' => '4', 'name' => 'account', 'on_menu' => 'NO', 'icon' => 'user', 'title' => 'Akun'),
            array('id' => '5', 'name' => 'dashboard', 'on_menu' => 'NO', 'icon' => 'home'),
            array('id' => '6', 'name' => 'company', 'on_menu' => 'YES', 'icon' => 'building', 'title' => 'Perusahaan'),
            array('id' => '7', 'name' => 'unit_kerja', 'on_menu' => 'YES', 'icon' => 'id-badge', 'title' => 'Unit Kerja'),
            array('id' => '8', 'name' => 'user', 'on_menu' => 'YES', 'icon' => 'users'),
            array('id' => '9', 'name' => 'treeview', 'on_menu' => 'YES', 'icon' => 'briefcase', 'title' => 'Standar'),
            array('id' => '10', 'name' => 'treeview_detail', 'on_menu' => 'NO', 'icon' => 'list-alt', 'title' => 'Pasal'),
            array('id' => '100', 'name' => 'role', 'on_menu' => 'NO', 'icon' => 'universal-access'),
        );
        $user = array(
            array('id_role' => '1', 'username' => 'admin', 'fullname' => 'Super Admin', 'pass' => MD5('1234')),
        );
        $this->db->trans_begin();
        foreach ($role as $r) {
            $this->db->insert('role', $r);
        }
        foreach ($module as $m) {
            $this->db->insert('module', $m);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            foreach ($user as $u) {
                if ($this->db->insert('users', $u)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

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

}