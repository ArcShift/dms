<?php

class Tugas_saya extends MY_Controller {

    protected $module = 'tugas_saya';

    function index() {
        $this->subModule = 'read';
        $this->load->model('m_document');
        $this->data['dokumen'] = $this->m_document->dokumen_tugas();
        $this->data['form_terkait'] = $this->m_document->form_terkait();
        $this->db->select('uk.*, pp.id AS jabatan');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil=' . $this->session->user['id_personil']);
        $this->data['unit_kerja'] = $this->db->get('unit_kerja uk')->result();
        $this->render('index');
    }

    function get() {
        $this->db->select('j.*, t.nama AS tugas, p.nama AS project, t.id_document, t.form_terkait, t.sifat, u.photo, CONCAT(p2.fullname, " - ", uk.name) AS pembuat, pp.id_personil');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id', 'LEFT');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil', 'LEFT');
        $this->db->join('project p', 'p.id = t.id_project', 'LEFT');
        $this->db->join('position_personil pp2', 'pp2.id = t.pembuat', 'LEFT');
        $this->db->join('personil p2', 'p2.id = pp2.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk', 'uk.id = pp2.id_unit_kerja', 'LEFT');
        $this->db->join('users u', 'u.id_personil = p2.id', 'LEFT');
        $this->db->order_by('j.id', 'DESC');
        $this->db->group_by('j.id');
        $this->db->where('pp2.id_personil', $this->session->user['id_personil']);
        $this->db->or_where('pp.id_personil', $this->session->user['id_personil']);
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
            if($t->id_personil == $this->session->user['id_personil']){
                $t->filter = true;
            }else{
                $t->filter = false;
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

    function set() {
        $this->load->model('m_notif');
        $msg = [];
        $msg['status'] = 'success';
        if ($this->input->post('mode') == 'create') {
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            $this->db->set('pembuat', $this->input->post('jabatan'));
            if ($this->input->post('form_terkait')) {
                $this->db->set('form_terkait', $this->input->post('form_terkait'));
            }
            $this->db->insert('tugas');
            $id = $this->db->insert_id();
            foreach ($this->input->post('pelaksana') as $k => $p) {
                $this->db->set('id_tugas', $id);
                $this->db->set('id_position_personil', $p);
                $this->db->insert('personil_task');
                $this->m_notif->set2($p, 'TASK', $id, 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>'.$this->input->post('nama').'</b> di Standar <b>'.$this->session->activeStandard['name'].'</b>');
            }
            $this->db->set('id_tugas', $id);
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->insert('jadwal');
        } elseif ($this->input->post('mode') == 'edit') {
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            if ($this->input->post('proyek')) {
                $this->db->set('id_project', $this->input->post('proyek'));
            }
            $this->db->where('id', $this->input->post('id_tugas'));
            $this->db->update('tugas');
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->where('id', $this->input->post('id_jadwal'));
            $this->db->update('jadwal');
            $this->load->model('m_tugas');
            $pelaksana = $this->m_tugas->editPelaksana($this->input->post('id_tugas'), $this->input->post('pelaksana'));
            foreach ($pelaksana as $k => $p) {
                $this->m_notif->set2($p, 'TASK', $this->input->post('id_tugas'), 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>'.$this->input->post('nama').'</b> di Standar <b>'.$this->session->activeStandard['name'].'</b>');
            }
        } elseif ($this->input->post('mode') == 'delete') {
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('personil_task');
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('jadwal');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('tugas');
            $this->data['msgSuccess'] = 'Berhasil Menghapus Data';
        } elseif ($this->input->post('mode') == 'upload') {
            $step = true;
            $this->load->model('m_implementasi');
            if (strtoupper($this->input->post('type_dokumen')) == 'FILE') {
                $config['upload_path'] = './upload/implementasi';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('dokumen')) {
                    $this->data['msgError'] = $this->upload->display_errors();
                    $step = false;
                }
                $path = $this->upload->data()['file_name'];
            } else {
                $path = $this->input->post('url');
            }
            if ($step) {
                if ($this->m_implementasi->upload($path)) {
                    $this->data['msgSuccess'] = 'Data Berhasil Diupload';
                }
            }
        }
        echo json_encode($msg);
    }

}
