<?php

class Tugas extends MY_User {

    private function ajax_request() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    function index() {
        $this->load->model('m_log');
        if ($this->input->post('upload')) {
            $step = true;
            $this->load->model('m_implementasi', 'model');
            if ($this->input->post('type_dokumen') == 'file') {
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
                if ($this->model->upload($path)) {
                    $this->data['msgSuccess'] = 'Data berhasil disimpan';
                } else {
                    $this->data['msgError'] = $this->db->error()['message'];
                }
            }
        } else if ($this->input->post('newTugas')) {
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('id_project', $this->input->post('proyek'));
            $this->db->set('sifat', $this->input->post('sifat'));
            $this->db->set('asal', 'MANDIRI');
            if ($this->input->post('form_terkait'))
                $this->db->set('form_terkait', $this->input->post('form_terkait'));
            $this->db->insert('tugas');
            $id = $this->db->insert_id();
            $this->db->set('id_tugas', $id);
            $this->db->set('id_position_personil', $this->input->post('jabatan'));
            $this->db->insert('personil_task');
            $this->db->set('id_tugas', $id);
            $this->db->set('tanggal', $this->input->post('jadwal'));
            if ($this->input->post('type_dokumen')) {
                $type = $this->input->post('type_dokumen');
                $this->db->set('doc_type', $type);
                if ($type == 'file') {
                    $config['upload_path'] = './upload/implementasi';
                    $config['allowed_types'] = '*';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('dokumen')) {
                        $this->data['msgError'] = $this->upload->display_errors();
                    } else {
                        $this->db->set('path', $this->upload->data()['file_name']);
                        $this->db->set('upload_date', 'NOW()', false);
                    }
                } else {
                    $this->db->set('path', $this->input->post('url'));
                    $this->db->set('upload_date', 'NOW()', false);
                }
            }
            $this->db->insert('jadwal');
            $this->m_log->create_tugas($id);
        } else if ($this->input->post('delete')) {
            $this->db->where('id_tugas', $this->input->post('id'));
            $jd = $this->db->get('jadwal')->row();
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('personil_task');
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('jadwal');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('tugas');
            if($jd->doc_type == 'FILE'& file_exists('upload/implementasi/' . $jd->path)){
                unlink('upload/implementasi/' . $jd->path);
            }
            $this->data['msgSuccess'] = 'Berhasil menghapus data';
            $this->m_log->delete_tugas($this->input->post('id'));
        } else if ($this->input->post('edit')) {
            $jd = $this->db->get_where('jadwal', ['id' => $this->input->post('id')])->row();
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            $this->db->set('id_project', $this->input->post('proyek'));
            $this->db->where('id', $jd->id_tugas);
            $this->db->update('tugas');
            $this->db->set('id_position_personil', $this->input->post('jabatan'));
            $this->db->where('id_tugas', $jd->id_tugas);
            $this->db->update('personil_task');
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->where('id_tugas', $jd->id_tugas);
            $this->db->update('jadwal');
            $this->m_log->update_tugas($jd->id_tugas);
        }
        $this->db->select('j.*, t.nama AS tugas, t.id_project, t.form_terkait AS id_form, pro.nama AS project, t.sifat, t.id_document, t.asal, pp.id AS jabatan, CONCAT(p2.fullname, " - ", uk2.name) AS pembuat, u2.photo');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('personil_task pt', 'pt.id_tugas = t.id');
        $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
        $this->db->join('personil p', 'p.id = pp.id_personil');
        $this->db->join('users u', 'u.id_personil = p.id AND u.id=' . $this->session->user['id']);
        $this->db->join('project pro', 'pro.id = t.id_project', 'LEFT');
        $this->db->join('position_personil pp2', 'pp2.id = t.pembuat', 'LEFT');//get pembuat
        $this->db->join('personil p2', 'p2.id = pp2.id_personil', 'LEFT');
        $this->db->join('unit_kerja uk2', 'uk2.id = pp2.id_unit_kerja', 'LEFT');
        $this->db->join('users u2', 'u2.id_personil = p2.id', 'LEFT');
        $this->db->order_by('j.tanggal', 'DESC');
        $data = $this->db->get('jadwal j')->result();
        foreach ($data as $k => $d) {
            if (!empty($d->tanggal) & !empty($d->upload_date)) {
                $d1 = new DateTime(date('Y-m-d', strtotime($d->upload_date)));
                $d2 = new DateTime($d->tanggal);
                if ($d1->diff($d2)->invert) {
                    $d->deadline = 'terlambat';
                } else {
                    $d->deadline = 'selesai';
                }
            } else {
                $d->deadline = 'menunggu';
            }
            $this->db->select('pp.id, CONCAT(p.fullname," - ", uk.name) AS fullname, u.photo');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
            $this->db->join('users u', 'u.id_personil = p.id', 'LEFT');
            $d->pelaksana = $this->db->get_where('personil_task pt', ['pt.id_tugas' => $d->id_tugas])->result();
            $d->form_terkait = $this->db->get_where('document', ['id' => $d->id_form])->row();
            $this->load->model('m_document');
            $d->dokumen = $this->m_document->get($d->id_document);
            $data[$k] = $d;
        }
        $this->data['data'] = $data;
        $this->db->select('uk.*, pp.id AS jabatan');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil=' . $this->session->user['id_personil']);
        $this->data['unit_kerja'] = $this->db->get('unit_kerja uk')->result();
        $this->data['proyek'] = $this->db->get_where('project', ['id_company' => $this->session->activeCompany['id']])->result();
        $this->render('tugas');
    }

    function upload_bukti() {
        $this->ajax_request();
        $step = true;
        $this->load->model('m_implementasi', 'model');
        if ($this->input->post('type_dokumen') == 'FILE') {
            $config['upload_path'] = './upload/implementasi';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('dokumen')) {
                $result['status'] = 'error';
                $result['message'] = $this->upload->display_errors();
                $step = false;
            }
            $path = $this->upload->data()['file_name'];
        } else {
            $path = $this->input->post('url');
        }
        if ($step) {
            if ($this->model->upload($path)) {
                $result['status'] = 'success';
            } else {
                $result['message'] = $this->db->error()['message'];
            }
        }
        echo json_encode($result);
    }

}
