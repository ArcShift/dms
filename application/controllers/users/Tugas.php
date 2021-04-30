<?php

class Tugas extends MY_User {

    function index() {
        $this->db->select('j.*, t.nama AS tugas, t.form_terkait');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id='.$this->session->user['id']);
        $data = $this->db->get('jadwal j')->result();
        foreach ($data as $k => $d) {
            $d->form_terkait = $this->db->get_where('document',['id', $d->form_terkait])->result();
            if (!empty($d->tanggal) & !empty($d->upload_date)) {
                $d1 = new DateTime(date('Y-m-d', strtotime($d->upload_date)));
                $d2 = new DateTime($d->tanggal);
                if ($d1->diff($d2)->invert) {
                    $d->deadline = 'terlambat';
                } else {
                    $d->deadline = 'selesai';
                }
            } else {
                $d->deadline = '-';
            }
            $data[$k] = $d;
        }
        $this->data['data'] = $data;
        $this->render('tugas');
    }

}
