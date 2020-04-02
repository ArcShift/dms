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
            array('id' => '4', 'name' => 'account', 'icon' => 'user', 'title' => 'Akun'),
            array('id' => '5', 'name' => 'dashboard', 'icon' => 'home'),
            array('id' => '6', 'name' => 'company', 'on_menu' => 'YES', 'icon' => 'building', 'title' => 'Perusahaan', 'parent'=> 'user_management'),
            array('id' => '7', 'name' => 'unit_kerja', 'on_menu' => 'YES', 'icon' => 'id-badge', 'title' => 'Unit Kerja', 'parent'=> 'user_management'),
            array('id' => '8', 'name' => 'user', 'on_menu' => 'YES', 'icon' => 'users', 'parent'=> 'user_management', 'title' => 'Akun'),
            array('id' => '9', 'name' => 'standard', 'on_menu' => 'YES', 'icon' => 'list-alt', 'title' => 'Daftar Standar', 'parent'=> 'standard'),
            array('id' => '10', 'name' => 'company_standard', 'on_menu' => 'YES', 'icon' => 'list-ul', 'title' => 'Standar Perusahaan','parent'=> 'standard'),
            array('id' => '11', 'name' => 'pasal', 'on_menu' => 'YES', 'icon' => 'list-ul', 'title' => 'Pasal','parent'=> 'standard'),
            array('id' => '12', 'name' => 'treeview_detail', 'on_menu' => 'YES', 'icon' => 'newspaper-o', 'title' => 'Manajemen Standar Perusahaan','parent'=> 'user_data', ),
            array('id' => '100', 'name' => 'role', 'icon' => 'universal-access'),
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
