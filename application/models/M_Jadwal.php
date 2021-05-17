<?php

class M_Jadwal extends CI_Model {

    function jadwal_saya() {
//        $this->db->select('j.*, t.nama AS tugas, t.form_terkait, t.sifat, t.id_document');
        $this->db->select('j.*');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document AND d.id_standard=' . $this->session->activeStandard['id']);
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id=' . $this->session->user['id']);
        $jadwal = $this->db->get('jadwal j')->result();
        foreach ($jadwal as $k => $j) {
            $jadwal[$k]->tugas = $this->db->get_where('tugas', ['id' => $j->id_tugas])->row();
            $this->db->select('p.fullname, uk.name AS unit_kerja');
            $this->db->join('personil_task pt', 'pt.id_position_personil = pp.id AND pt.id_tugas='.$jadwal[$k]->tugas->id);
            $this->db->join('personil p','p.id = pp.id_personil');
            $this->db->join('unit_kerja uk','uk.id = pp.id_unit_kerja');
            $jadwal[$k]->tugas->pelaksana = $this->db->get('position_personil pp')->result();
        }
        return $jadwal;
    }

}
