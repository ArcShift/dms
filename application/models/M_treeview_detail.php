<?php

class M_treeview_detail extends CI_Model {

    private $table = 'pasal';

    function treeview() {
        $this->db->where('id', $this->session->userdata('treeview'));
        return $this->db->get('standard')->row_array();
    }

    function standard() {
        $this->db->select('s.id, s.name');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company=' . $this->input->post('id'));
        return $this->db->get('standard s')->result_array();
    }

    function member() {
        $this->db->select('u.*');
        $this->db->join('unit_kerja uk', 'uk.id=u.id_unit_kerja');
        $this->db->join('company c', 'c.id=uk.id_company');
        $this->db->where('c.id', $this->input->post('idPerusahaan'));
        return $this->db->get('users u')->result_array();
    }

    function reads($id) {
        $this->db->where('id_standard', $id);
        return $this->db->get($this->table)->result_array();
    }

    function create() {
        $input = $this->input->post();
        $this->db->set('name', $input['nama']);
        $this->db->set('id_standard', $this->session->userdata('treeview'));
        $this->db->set('created_by', $this->session->userdata('user')['id']);
        if (is_numeric($input['id'])) {
            $this->db->set('parent', $input['id']);
        }
        $this->db->insert($this->table);
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
        $this->db->set('description', $this->input->post('desc'));
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->table);
    }

    function update_file1() {
        $this->db->set('file', $this->upload->data()['file_name']);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table);
    }

    function form2_submit() {
        $mod = false;
        $in = $this->input->post();
        $this->db->where('id_pasal', $in['pasal']);
        $this->db->where('id_company', $in['perusahaan']);
        $count = $this->db->count_all_results('form2');
        if (!empty($in['catatan'])) {
            $this->db->set('note', $in['catatan']);
            $mod = true;
        }
        if (!empty($in['jadwal'])) {
            $this->db->set('jadwal', $in['jadwal']);
            $mod = true;
        }
        if ($mod) {
            if ($count) {
                $this->db->where('id_pasal', $in['pasal']);
                $this->db->where('id_company', $in['perusahaan']);
                return $this->db->update('form2');
            } else {
                $this->db->set('id_pasal', $in['pasal']);
                $this->db->set('id_company', $in['perusahaan']);
                return $this->db->insert('form2');
            }
        }
    }

}
