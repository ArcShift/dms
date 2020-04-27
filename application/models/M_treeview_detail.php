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

    function detail() {
        $input = $this->input->post();
        $this->db->select('p.*, f.description');
        $this->db->where('p.id', $input['idPasal']);
        $this->db->join('form2 f', 'f.id_pasal= p.id AND f.id_company=' . $input['idPerusahaan'], 'LEFT');
        return $this->db->get($this->table . ' p')->row_array();
    }

    function member() {
        $input = $this->input->post();
        $this->db->select('u.id, u.username');
        $this->db->join('unit_kerja uk', 'uk.id=u.id_unit_kerja');
//        $this->db->join('schedule s', 's.id_user=u.id AND m.id_pasal=' . $input['idPasal'], 'LEFT');
        $this->db->where('uk.id_company', $input['idPerusahaan']);
        return $this->db->get('users u')->result_array();
    }

    function reads() {
        $input = $this->input->post();
        $this->db->select('p.*, f.description, f.id AS id_form');
        if (isset($input['idPasal'])) {
            $this->db->where('p.id', $input['idPasal']);
        }
        $this->db->join('form2 f', 'f.id_pasal= p.id AND f.id_company=' . $input['idPerusahaan'], 'LEFT');
        $this->db->where('p.id_standard', $input['idStandar']);
        $result = $this->db->get($this->table . ' p');
        if (isset($input['idPasal'])) {
            return $result->row_array();
        } else {
            return $result->result_array();
        }
    }

    function add_schedule() {
        $in = $this->input->post();
        if (isset($in['idForm'])) {
            $this->db->set('id_form2', $in['idForm']);
        } else {
            $this->db->set('id_pasal', $in['idPasal']);
            $this->db->set('id_company', $in['idPerusahaan']);
            $this->db->set('description', $in['deskripsi']);
            if ($this->db->insert('form2')) {
                $idForm = $this->db->insert_id();
            } else {
                return FALSE;
            }
            $this->db->set('id_form2', $idForm);
        }
        $this->db->set('date', $in['jadwal']);
        $this->db->set('id_user', $in['anggota']);
        return $this->db->insert('schedule');
    }

    function read_schedule() {
        $this->db->select('s.id, s.date ,u.username');
        $this->db->join('form2 f', 'f.id = s.id_form2 AND f.id_pasal = ' . $this->input->post('idPasal') . ' AND f.id_company = ' . $this->input->post('idPerusahaan'));
        $this->db->join('users u', 'u.id= s.id_user');
        $this->db->order_by('s.id');
        return $this->db->get('schedule s')->result_array();
    }
    function reads_schedule() {
        $this->db->get('schedule s');
//        die($this->db->last_query());
    }

    function delete_schedule() {
        $this->db->where('id', $this->input->post('hapus'));
        return $this->db->delete('schedule');
    }

    function form2_save() {
        $mod = false;
        $in = $this->input->post();
        $this->db->where('id_pasal', $in['idPasal']);
        $this->db->where('id_company', $in['idPerusahaan']);
        $count = $this->db->count_all_results('form2');
        if (!empty($in['deskripsi'])) {
            $this->db->set('description', $in['deskripsi']);
            $mod = true;
        }
        if ($this->upload->data('file_name')) {
            $this->db->set('file', $this->upload->data('file_name'));
            $mod = true;
        }
        if ($mod) {
            if ($count) {
                $this->db->where('id_pasal', $in['idPasal']);
                $this->db->where('id_company', $in['idPerusahaan']);
                return $this->db->update('form2');
            } else {
                $this->db->set('id_pasal', $in['idPasal']);
                $this->db->set('id_company', $in['idPerusahaan']);
                return $this->db->insert('form2');
            }
        }
    }

}
