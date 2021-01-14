<?php

class M_pasal extends CI_Model {

    private $table = 'pasal';

    function treeview() {
        $this->db->where('id', $this->session->userdata('treeview'));
        return $this->db->get('standard')->row_array();
    }

    function reads() {
        $this->db->where('id_standard', $this->session->userdata('treeview'));
        $this->db->order_by('sort_index');
        return $this->db->get($this->table)->result_array();
    }

    function create() {
        $input = $this->input->post();
        $sortIndex = '';
        $parent = null;
        if (!empty($input['id'])) {//not super parent
            $parent = $input['id'];
            $this->db->where('id', $input['id']);
            $p = $this->db->get('pasal')->row_array();
            $sortIndex .= $p['sort_index'];
        }
        $sortIndex .= $this->getSortIndex($parent);
        $this->db->set('parent', $parent);
        $this->db->set('sort_index', $sortIndex);
        $this->db->set('name', $input['nama']);
        $this->db->set('id_standard', $this->session->userdata('treeview'));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        $this->db->insert($this->table);
    }

    private function getSortIndex($parent = null) {
        if (!empty($parent)) {
            $this->db->where('parent', $parent);
        }
        $this->db->where('id_standard', $this->session->userdata('treeview'));
        $this->db->order_by('sort_index', 'DESC');
        $result = $this->db->get('pasal')->row_array();
        if (empty($result)) {
            return '01';
        }
        $sort = substr($result['sort_index'], -2);
        $sort = base_convert($sort, 36, 10);
        $sort++;
        return sprintf("%02s", strtoupper(base_convert($sort, 10, 36)));
    }

    function update() {
        $this->db->set('name', $this->input->post('nama'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table);
    }

    function delete() {
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete($this->table);
    }

    function update_desc() {
        $this->db->set('sort_desc', $this->input->post('sort-desc'));
        $this->db->set('long_desc', $this->input->post('long-desc'));
        $this->db->set('subtitle', $this->input->post('subtitle'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->table);
    }

    function sort_up() {
        $id = $this->input->post('sortUp');
        $this->db->where('id', $id);
        $result = $this->db->get('pasal')->row_array();
        $idx = substr($result['sort_index'], -2);
        if ($idx != 1) {
            $idx = (base_convert($idx, 36, 10)) - 1;
            $idx = sprintf("%02s", strtoupper(base_convert($idx, 10, 36)));
            $idx = substr($result['sort_index'], 0, -2) . $idx;
            $this->db->where('sort_index', $idx);
            $this->db->where('id_standard', $this->session->userdata('treeview'));
            $this->db->set('sort_index', $result['sort_index']);
            $this->db->update('pasal'); //update other pasal
            $this->db->where('id', $id);
            $this->db->set('sort_index', $idx);
            $this->db->update('pasal'); //update this pasal
        } else {
            die('no_sort_up');
        }
    }

    function sort_down() {
        $id = $this->input->post('sortDown');
        $this->db->where('id', $id);
        $result = $this->db->get('pasal')->row_array();
        $this->db->where('id_standard', $this->session->userdata('treeview'));
        $this->db->where('parent', $result['parent']);
        $this->db->order_by('sort_index', 'DESC');
        $result2 = $this->db->get('pasal')->row_array();
        if ($result2['id'] != $id) {
            $idx = substr($result['sort_index'], -2);
            $idx = (base_convert($idx, 36, 10)) + 1;
            $idx = sprintf("%02s", strtoupper(base_convert($idx, 10, 36)));
            $idx = substr($result['sort_index'], 0, -2) . $idx;
            $this->db->where('id_standard', $this->session->userdata('treeview'));
            $this->db->where('sort_index', $idx);
            $this->db->set('sort_index', $result['sort_index']);
            $this->db->update('pasal'); //update other pasal
            $this->db->where('id', $id);
            $this->db->set('sort_index', $idx);
            $this->db->update('pasal'); //update this pasal
        } else {
            die('no_sort_down');
        }
    }

}
