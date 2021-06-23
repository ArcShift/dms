<?php

class Tugas_saya extends MY_Controller {

    protected $module = 'tugas_saya';

    function index() {
        $this->subModule = 'read';
        $this->render('index');
    }
    function get() {
        $this->db->select('j.*, t.nama AS tugas, p.nama AS project');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil AND pp.id_personil ='.$this->session->user['id_personil']);
        $this->db->join('project p', 'p.id = t.id_project', 'LEFT');
        $this->db->order_by('j.id', 'DESC');
        $data = $this->db->get('jadwal j')->result();
        foreach ($data as $k => $t) {
            if (!empty($t->tanggal) & !empty($t->upload_date)) {
                $d1 = new DateTime(date('Y-m-d', strtotime($t->upload_date)));
                $d2 = new DateTime($t->tanggal);
                if ($d1->diff($d2)->invert) {
                    $t->deadline = '<span class="badge badge-danger">terlambat</span>';
                } else {
                    $t->deadline = '<span class="badge badge-success">selesai</span>';
                }
            } else {
                $t->deadline = '<span class="badge badge-primary">menunggu</span>';
            }
            $this->db->select('pp.id, CONCAT(p.fullname," - ", uk.name) AS fullname, u.photo');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
            $this->db->join('users u', 'u.id_personil = p.id', 'LEFT');
            $t->pelaksana = $this->db->get_where('personil_task pt', ['pt.id_tugas' => $t->id_tugas])->result();
            $data[$k] = $t;
        }
        echo json_encode($data);
    }
}
