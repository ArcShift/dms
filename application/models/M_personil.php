<?php

class M_personil extends CI_Model {

    private $table = 'personil';

    function company() {
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('id', $this->session->userdata['user']['id_company']);
        }
        return $this->db->get('company')->result_array();
    }

    function unit_kerja($id_company) {
        $this->db->select('id, name');
        $this->db->where('id_company', $id_company);
        return $this->db->get('unit_kerja')->result_array();
    }

    function get() {
        return $this->db->get_where('personil',['id_company'=>$this->session->activeCompany['id']])->result_array();
    }

    function read() {
        $this->db->select('p.id, p.fullname, u.username, c.name AS company');
        $this->db->join('company c', 'c.id = p.id_company', 'LEFT');
        $this->db->join('users u', 'p.id = u.id_personil', 'LEFT');
        if ($this->session->userdata('user')['role'] == 'pic') {
            $this->db->where('c.id', $this->session->userdata['user']['id_company']);
        }
        $this->db->group_by('p.id');
        $result = $this->db->get($this->table . ' p')->result_array();
        foreach ($result as $k => $r) {
            $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil = ' . $r['id']);
            $result[$k]['unit_kerja'] = $this->db->get('unit_kerja uk')->result_array();
        }
        return $result;
    }

    function create() {
        $this->db->set('fullname', $this->input->post('nama'));
        $this->db->set('id_company', $this->input->post('perusahaan'));
        $this->db->insert($this->table);
        $id = $this->db->insert_id();
        foreach ($this->input->post('unit_kerja') as $v) {
            $this->db->set('id_unit_kerja', $v);
            $this->db->set('id_personil', $id);
            $this->db->insert('position_personil');
        }
        return $id;
    }

    function updateData() {
        $this->db->where('id', $this->input->post('edit'));
        $this->db->set('fullname', $this->input->post('fullname'));
        return $this->db->update($this->table);
    }

    function detail($id) {
        $this->db->where('p.id', $id);
        $r = $this->db->get($this->table . ' p')->row_array();
        $this->db->select('uk.*, pp.id AS id_position_personil');
        $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
        $this->db->where('pp.id_personil', $id);
        $r['unit_kerja'] = $this->db->get('position_personil pp')->result_array();
        $this->db->select('uk.*');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil = ' . $id, 'LEFT');
        $this->db->where('uk.id_company', $r['id_company']);
        $this->db->where('pp.id IS NULL');
        $r['excluded_unit_kerja'] = $this->db->get('unit_kerja uk')->result_array();
        $this->db->select('d.*');
        $this->db->join('position_personil pp', 'pp.id = d.id_position_personil AND pp.id_personil = ' . $id);
        $r['dist'] = $this->db->get('distribution d')->result_array();
        $this->db->join('position_personil pp', 'pp.id = d.pembuat AND pp.id_personil = ' . $id);
        $r['creator'] = $this->db->get('document d')->result_array();
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil AND pp.id_personil = ' . $id);
        $r['task'] = $this->db->get('personil_task pt')->result_array();
        return $r;
    }

    function delete_unit_kerja() {
        $this->db->where('id_position_personil', $this->input->post('delete'));
        $this->db->delete('personil_task');
        $this->db->where('id_position_personil', $this->input->post('delete'));
        $this->db->delete('distribution');
        $this->db->set('pembuat', null);
        $this->db->where('pembuat', $this->input->post('delete'));
        $this->db->update('document');
        $this->db->where('id', $this->input->post('delete'));
        $this->db->delete('position_personil');
    }

    function add_unit_kerja() {
        $this->db->set('id_personil', $this->session->idData);
        $this->db->set('id_unit_kerja', $this->input->post('unit_kerja'));
        $this->db->insert('position_personil');
    }

}
