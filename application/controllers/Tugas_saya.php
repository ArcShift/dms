<?php

class Tugas_saya extends MY_Controller {

    protected $module = 'tugas_saya';

    function index() {
        $this->subModule = 'read';
        $this->load->model('m_document');
        $this->db->select('s.*');
        $this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $this->session->activeCompany['id']);
        $this->data['standard'] = $this->db->get('standard s')->result();
        $this->data['dokumen'] = $this->m_document->dokumen_tugas(); //remove later
        $this->data['form_terkait'] = $this->m_document->form_terkait();
        $this->db->select('uk.*, pp.id AS jabatan');
        $this->db->join('position_personil pp', 'pp.id_unit_kerja = uk.id AND pp.id_personil=' . $this->session->user['id_personil']);
        $this->data['unit_kerja'] = $this->db->get('unit_kerja uk')->result();
        $this->render('index');
    }

    function get() {
        $this->db->select('j.*, t.nama AS tugas, p.nama AS project, t.id_document, t.form_terkait, t.sifat, u.photo, CONCAT(p2.fullname, " - ", uk.name) AS pembuat, pp2.id_personil,'
                . 'pp.id_personil AS masuk, pp2.id_personil AS keluar');
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
            if ($t->id_personil == $this->session->user['id_personil']) {
                $t->filter = true;
            } else {
                $t->filter = false;
            }
            $this->db->select('pp.id, CONCAT(p.fullname," - ", uk.name) AS fullname, u.photo');
            $this->db->join('position_personil pp', 'pp.id = pt.id_position_personil');
            $this->db->join('personil p', 'p.id = pp.id_personil');
            $this->db->join('unit_kerja uk', 'uk.id = pp.id_unit_kerja');
            $this->db->join('users u', 'u.id_personil = p.id', 'LEFT');
            $t->pelaksana = $this->db->get_where('personil_task pt', ['pt.id_tugas' => $t->id_tugas])->result();
            $t->alur = '';
            if ($t->masuk == $this->session->user['id_personil']) {
                $t->alur .= 'tugas_masuk ';
            }
            if($t->keluar == $this->session->user['id_personil']){
                $t->alur .= 'tugas_keluar ';
            }
            $data[$k] = $t;
        }
        echo json_encode($data);
    }

    function set() {
        $this->load->model('m_notif');
        $this->load->model('m_log');
        $msg = [];
        $msg['status'] = 'success';
        if ($this->input->post('mode') == 'create') {
            if ($this->input->post('dokumen')) {
                $this->db->set('id_document', $this->input->post('dokumen'));
            }
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
                //NOTIF EMAIL
                $this->db->select('u.*, p.fullname');
                $this->db->join('position_personil pp', 'pp.id_personil = p.id AND pp.id = ' . $p);
                $this->db->join('users u', 'u.id_personil = p.id');
                $user = $this->db->get('personil p')->row_array();
                if (!empty($user)) {
                    $this->db->select('t.nama AS tugas, s.name AS standard');
                    $this->db->join('document d', 'd.id = t.id_document', 'LEFT');
                    $this->db->join('document_pasal dp', 'dp.id_document = d.id', 'LEFT');
                    $this->db->join('pasal p', 'p.id = dp.id_pasal', 'LEFT');
                    $this->db->join('standard s', 's.id = p.id_standard', 'LEFT');
                    $this->db->where('t.id', $id);
                    $r = $this->db->get('tugas t')->row_array();
                    $msg2 = "Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>" . $r['tugas'] . "</b> di Standar <b>" . $r['standard'] . "</b>";
                    if (!empty($user['email']) & $user['notif_email'] == 'ENABLE') {//cek apakah user memiliki email
                        $statusEmail = parent::notif_mail($user['email'], $user['fullname'] . ' menerima tugas', $msg2);
                        if ($statusEmail !== true) {
                            $result['status'] = 'error';
                            $result['message'] = 'Gagal mengirim notifikasi email';
                            $result['message2'] = $statusEmail;
                        }
                    }
                }
                $this->m_notif->set2($p, 'TASK', $id, 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>' . $this->input->post('nama') . '</b> di Standar <b>' . $this->session->activeStandard['name'] . '</b>');
            }
            $this->db->set('id_tugas', $id);
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->insert('jadwal');
            $this->m_log->create_tugas($id);
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
                $this->m_notif->set2($p, 'TASK', $this->input->post('id_tugas'), 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>' . $this->input->post('nama') . '</b> di Standar <b>' . $this->session->activeStandard['name'] . '</b>');
                //NOTIF EMAIL
                $this->db->select('u.*, p.fullname');
                $this->db->join('position_personil pp', 'pp.id_personil = p.id AND pp.id = ' . $p);
                $this->db->join('users u', 'u.id_personil = p.id');
                $user = $this->db->get('personil p')->row_array();
                if (!empty($user)) {
                    $this->db->select('t.nama AS tugas, s.name AS standard');
                    $this->db->join('document d', 'd.id = t.id_document');
                    $this->db->join('document_pasal dp', 'dp.id_document = d.id');
                    $this->db->join('pasal p', 'p.id = dp.id_pasal');
                    $this->db->join('standard s', 's.id = p.id_standard');
                    $this->db->where('t.id', $this->input->post('id_tugas'));
                    $r = $this->db->get('tugas t')->row_array();
                    $msg2 = "Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>" . $r['tugas'] . "</b> di Standar <b>" . $r['standard'] . "</b>";
                    if (!empty($user['email']) & $user['notif_email'] == 'ENABLE') {//cek apakah user memiliki email
                        $statusEmail = parent::notif_mail($user['email'], $user['fullname'] . ' menerima tugas', $msg2);
                        if ($statusEmail !== true) {
                            $result['status'] = 'error';
                            $result['message'] = 'Gagal mengirim notifikasi email';
                            $result['message2'] = $statusEmail;
                        }
                    }
                }
            }
            $this->m_log->update_tugas($this->input->post('id_tugas'));
        } elseif ($this->input->post('mode') == 'delete') {
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('personil_task');
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('jadwal');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('tugas');
            $this->data['msgSuccess'] = 'Berhasil Menghapus Data';
            $this->m_log->delete_tugas($this->input->post('id'));
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

    function get_dokumen() {
        $this->db->where('jenis <> 4');
        $this->db->where('id_standard', $this->input->get('standard'));
        $doc = $this->db->get('document')->result();
        echo json_encode($doc);
    }

    function get_pelaksana() {
        $this->load->model('m_position_personil');
        if ($this->session->user['role'] === 'pic') {
            if ($this->input->get('id')) {
                $data = $this->m_position_personil->get_by_document($this->input->get('id_dokumen'));
            } else {
                $data = $this->m_position_personil->get_by_company();
            }
        } elseif ($this->session->user['role'] === 'ketua') {
            $data = $this->m_position_personil->get_by_distribution_ketua($this->input->get('pp'), $this->input->get('id_dokumen'));
//            if ($this->input->get('id')) {
//                $data = $this->m_position_personil->get_by_document($this->input->get('id'));
//            } else {
//                $data = $this->m_position_personil->get_by_company();
//            }
        }
        echo json_encode($data);
    }

}
