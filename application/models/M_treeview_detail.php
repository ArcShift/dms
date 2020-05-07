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
        $this->db->join('role r', 'r.id=u.id_role AND r.name = "anggota"');
//        $this->db->join('schedule s', 's.id_user=u.id AND m.id_pasal=' . $input['idPasal'], 'LEFT');
        $this->db->where('uk.id_company', $input['idPerusahaan']);
        return $this->db->get('users u')->result_array();
    }

    function reads_pemenuhan() {
        $this->db->select('p.name, COUNT(s.id) AS total');
        $this->db->select('SUM(CASE WHEN s.date < CURDATE() AND s.file IS NULL THEN 1 ELSE 0 END) AS terlambat'); //UNFIX
        $this->db->select('SUM(CASE WHEN s.file IS NOT NULL AND s.date < s.upload_date THEN 1 ELSE 0 END) AS terlambat2'); //UNFIX
        $this->db->select('SUM(CASE WHEN s.upload_date IS NULL AND s.date >= CURDATE() THEN 1 ELSE 0 END) AS unfinised');
        $this->db->select('SUM(CASE WHEN s.file IS NOT NULL AND s.date >= s.upload_date THEN 1 ELSE 0 END) AS finish');
        $this->db->join('form2 f', 'f.id_pasal = p.id AND f.id_company = ' . $this->input->post('idPerusahaan'));
        $this->db->join('schedule s', 's.id_form2 = f.id');
        $this->db->group_by('p.id');
        $this->db->where('p.id_standard', $this->input->post('idStandar'));
        $result = $this->db->get('pasal p')->result_array();
        foreach ($result as $k => $r) {
            $r['terlambat'] += $r['terlambat2'];
            unset($r['terlambat2']);
            $r['p_finish'] = number_format($r['finish'] / $r['total'] * 100, 0);
            $r['p_terlambat'] = number_format($r['terlambat'] / $r['total'] * 100, 0);
            $result[$k] = $r;
        }
        return $result;
    }

    function reads() {
        $input = $this->input->post();
        $this->db->select('p.*, f.description, f.id AS id_form, p2.id AS child, f.file');
        if (isset($input['idPasal'])) {
            $this->db->where('p.id', $input['idPasal']);
        }
        $this->db->join('pasal p2', 'p2.parent= p.id', 'LEFT');
        $this->db->join('form2 f', 'f.id_pasal= p.id AND f.id_company=' . $input['idPerusahaan'], 'LEFT');
        $this->db->where('p.id_standard', $input['idStandar']);
        $this->db->group_by('p.id');
        $result = $this->db->get($this->table . ' p');
        if (isset($input['idPasal'])) {
            return $result->row_array();
        } else {
            return $result->result_array();
        }
    }

    function read_schedule() {
        $this->db->select('s.id, s.date ,u.username, s.file');
        $this->db->join('form2 f', 'f.id = s.id_form2 AND f.id_pasal = ' . $this->input->post('idPasal') . ' AND f.id_company = ' . $this->input->post('idPerusahaan'));
        $this->db->join('users u', 'u.id= s.id_user');
        $this->db->order_by('s.id');
        return $this->db->get('schedule s')->result_array();
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
                die('error: ');
                return FALSE;
            }
            $this->db->set('id_form2', $idForm);
        }
        $this->db->set('date', $in['jadwal']);
        $this->db->set('id_user', $in['anggota']);
        return $this->db->insert('schedule');
    }

    function reads_schedule() {
        $this->db->select("s.id, s.date, s.upload_date, u.username AS name, uk.name AS division, s.file, p.id AS id_pasal");
        $this->db->join('form2 f', 'f.id = s.id_form2');
        $this->db->join('pasal p', 'p.id = f.id_pasal');
        $this->db->join('standard st', 'st.id = p.id_standard AND st.id = ' . $this->input->post('idStandar'));
        $this->db->join('users u', 'u.id = s.id_user');
        $this->db->join('unit_kerja uk', 'uk.id = u.id_unit_kerja');
        $this->db->join('company c', 'c.id = uk.id_company AND c.id = ' . $this->input->post('idPerusahaan'));
        $this->db->order_by('p.id, s.date');
        $result = $this->db->get('schedule s')->result_array();
        $idPasal = 0;
        foreach ($result as $k => $r) {
            if ($r['date'] < date('Y-m-d')) {
                $result[$k]['deadline'] = true;
            } else {
                $result[$k]['deadline'] = false;
            }
//            $this->db->select('SUM(CASE WHEN s.date < CURDATE() AND s.file IS NULL THEN 1 ELSE 0 END) AS terlambat'); //UNFIX
//            $this->db->select('SUM(CASE WHEN s.file IS NOT NULL AND s.date < s.upload_date THEN 1 ELSE 0 END) AS terlambat2'); //UNFIX
            if (!empty($r['file']) & !empty($r['date']) & $r['date'] >= $r['upload_date']) {
                $result[$k]['status'] = 'selesai';
            }else if(empty ($r['upload_date']) & $r['date'] >= date('Y-m-d')){
                $result[$k]['status'] = '-';
            }else{
                $result[$k]['status'] = 'terlambat';    
            }
            //PASAL FULLNAME
            if ($idPasal != $r['id_pasal']) {
                $idPasal = $r['id_pasal'];
                $result[$k]['pasal'] = $this->pasal_fullname($r['id_pasal']);
            } else {
                $result[$k]['pasal'] = '';
            }
        }
        return $result;
    }

    private function pasal_fullname($id) {
        $fullname = '';
        $parent_exist = true;
        while ($parent_exist) {
            $this->db->select('id, name, parent');
            $this->db->where('id', $id);
            $r = $this->db->get('pasal')->row_array();
            $fullname = $r['name'] . ' - ' . $fullname;
            if (empty($r['parent'])) {
                $parent_exist = false;
            } else {
                $id = $r['parent'];
            }
        }
        return substr($fullname, 0, -3);
    }

    function delete_schedule() {
        $this->db->where('id', $this->input->post('hapus'));
        return $this->db->delete('schedule');
    }

    function upload_bukti_penerapan() {
        $this->db->set('file', $this->upload->data()['file_name']);
        $this->db->set('upload_date', date("Y-m-d", time()));
        $this->db->where('id', $this->input->post('jadwal'));
        return $this->db->update('schedule');
    }

    function form2_save() {
        $mod = false;
        $in = $this->input->post();
        if (!empty($in['deskripsi'])) {
            $this->db->set('description', $in['deskripsi']);
            $mod = true;
        }
        if ($this->upload->data('file_name')) {
            $this->db->set('file', $this->upload->data('file_name'));
            $mod = true;
        }
        if ($mod) {
            $this->db->where('id_pasal', $in['idPasal']);
            $this->db->where('id_company', $in['idPerusahaan']);
            $count = $this->db->count_all_results('form2');
            if ($count) {
                $this->db->where('id_pasal', $in['idPasal']);
                $this->db->where('id_company', $in['idPerusahaan']);
                return $this->db->update('form2');
            } else {
                $this->db->set('id_pasal', $in['idPasal']);
                $this->db->set('id_company', $in['idPerusahaan']);
                return $this->db->insert('form2');
            }
        } else {
            //TODO: error msg: tdk ada data yg disimpan
        }
    }

    function form2_upload() {
        
    }

}
