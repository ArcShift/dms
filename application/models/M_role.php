<?php

class M_role extends CI_Model {

    private $table = "role";

    public function read() {
        $this->db->order_by('id');
        return $this->db->get($this->table)->result_array();
    }

    public function create() {
        $this->db->set('nama', $this->input->post("nama"));
        if ($this->db->insert($this->table)) {
            return 'success';
        } else {
            return $this->db->_error_message();
        }
    }

    public function update() {
        $this->db->set('nama', $this->input->post("nama"));
        $this->db->where('id', $this->input->post("id"));
        if ($this->db->update($this->table)) {
            return 'success';
        } else {
            return $this->db->_error_message();
        }
    }

    function module() {
        $result = $this->db->get('module')->result_array();
        foreach ($result as $r) {
            $data[$r['id']] = $r;
        }
        return $data;
    }

    function role() {
        $result = $this->db->get('role')->result_array();
        foreach ($result as $r) {
            $data[$r['id']] = $r;
        }
        return $data;
    }

    function set($module, $role, $crud, $status) {
        $this->db->where('module', $module);
        $this->db->where('role', $role);
        if (empty($this->db->get('access')->row_array())) {
            $this->db->set('module', $module);
            $this->db->set('role', $role);
            $this->db->set($crud, $status);
            return $this->db->insert('access');
        } else {
            $this->db->set($crud, $status);
            $this->db->where('module', $module);
            $this->db->where('role', $role);
            return $this->db->update('access');
        }
    }

    function access() {
        $arr = array();
        $crud = array('create', 'read', 'update', 'delete');
        $result = $this->db->get('access')->result_array();
        foreach ($result as $r) {
            foreach ($crud as $c) {
                if ($r['acc_' . $c]) {
                    $arr[$r['module']][$r['role']]['acc_' . $c] = TRUE; ///contious
                }
            }
        }
        return $arr;
    }

    function user_access($id) {
        $this->db->select('a.*,m.nama');
        $this->db->join('user u', 'u.idUserType=a.role');
        $this->db->join('role r', 'a.role=r.id');
        $this->db->join('module m', 'm.id=a.module');
        $this->db->where('u.id', $id);
        $result = $this->db->get('access a')->result_array();
        $data = array();
        $crud = array('create', 'read', 'update', 'delete');
        foreach ($result as $r) {
            $data[$r['nama']] = array();
            foreach ($crud as $c) {
                if ($r['acc_' . $c]) {
                    $data[$r['nama']][$c] = TRUE;
                }
            }
        }
        return $data;
    }

}
