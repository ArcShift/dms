<?php

class M_tugas extends CI_Model{

    function get($id = null) {
        if (empty($id)) {
            //filter by standard & company
            $data = $this->db->get('tugas')->result();
            foreach ($data as $k => $d) {
                $data[$k]->pelaksana = $this->getPelaksana($d->id);
            }
        } else {
            $data = $this->db->get_where('tugas', ['id', $id])->row_array();
            $data['pelaksana'] = $this->getPelaksana($id);
        }
        return $data;
    }

    function editPelaksana($id_tugas, $arrayPelaksana) {
        $add = [];
        if (!empty($arrayPelaksana)) {
            $this->db->where('id_tugas', $id_tugas);
            $result = $this->db->get('personil_task')->result_array();
            $db = [];
            foreach ($result as $r) {
                array_push($db, $r['id_position_personil']);
            }
            $remove = array_diff($db, $arrayPelaksana);
            $add = array_diff($arrayPelaksana, $db);
            foreach ($remove as $r) {
                $this->db->where('id_tugas', $id_tugas);
                $this->db->where('id_position_personil', $r);
                $this->db->delete('personil_task');
            }
            foreach ($add as $a) {
                $this->db->set('id_tugas', $id_tugas);
                $this->db->set('id_position_personil', $a);
                $this->db->insert('personil_task');
            }
        } else {//remove all data
            $this->db->where('id_tugas', $id_tugas);
            $this->db->delete('personil_task');
        }
        return $add;
    }
    private function getPelaksana($id) {
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->where('pt.id_tugas', $id);
        $data = $this->db->get('personil_task pt')->result_array();
        return $data;
    }

}