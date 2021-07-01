<?php

class Project2 extends MY_Controller {

    protected $module = 'project2';

    public function __construct() {
        parent::__construct();
        $this->load->model('m_position_personil');
        $this->load->model('m_log');
    }

    function index() {
        if ($this->input->post('idData')) {
            $this->session->set_userdata('idData', $this->input->post('idData'));
            redirect($this->module . '/tugas');
        }
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'company';
        $this->subModule = 'read';
        $this->db->select('p.*, COUNT(t.id) AS tugas');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->group_by('p.id');
        $this->data['data'] = $this->db->get_where('project p', ['p.id_company' => $this->session->activeCompany['id']])->result();
        $this->render('index');
    }

    function get() {
        $this->db->select('p.*, COUNT(t.id) AS tugas, COUNT(j.id) AS jadwal, SUM(IF(j.upload_date IS NOT NULL, 1, 0)) AS selesai');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->join('jadwal j', 'j.id_tugas = t.id', 'LEFT');
        $this->db->group_by('p.id');
        $data = $this->db->get_where('project p', ['p.id_company' => $this->session->activeCompany['id']])->result();
        foreach ($data as $k => $d) {
            $data[$k]->pelaksana = $this->m_position_personil->get_pelaksana_project($d->id);
        }
        echo json_encode($data);
    }

    function set() {//
        $idData = null;
        if ($this->input->post('mode') == 'create') {
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->insert('project');
            $idData = $this->db->insert_id();
            $this->m_log->create_project($idData);
            $this->session->idData = $idData;
        } elseif ($this->input->post('mode') == 'hapus') {
            $result = $this->db->get_where('project', ['id' => $this->input->post('id')])->row();
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('project');
            $this->m_log->delete_project($result->nama);
        } elseif ($this->input->post('mode') == 'edit') {
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('project');
            $this->m_log->update_project($this->input->post('id'));
        }
        echo json_encode(['status' => 'success', 'idData' => $idData]);
    }

    function tugas() {
        if (empty($this->session->idData)) {
            redirect($this->module);
        }
        $project = $this->db->get_where('project', ['id' => $this->session->idData])->row();
        if (empty($project)) {
            redirect($this->module);
        }
        $this->subModule = 'read';
        $this->subTitle = 'List Tugas';
        $this->data['project'] = $project;
        $this->load->model('m_document');
        $this->data['dokumen'] = $this->m_document->dokumen_tugas();
        $this->data['form_terkait'] = $this->m_document->form_terkait();
        $this->load->model('m_personil');
        $this->data['personil'] = $this->m_personil->position_personil();
        $this->render('tugas');
    }

    function get_tugas() {
        $this->db->select('j.*, t.nama AS tugas, t.id_document, t.form_terkait, t.sifat, t.pembuat');
        $this->db->join('tugas t', 't.id = j.id_tugas AND t.id_project = ' . $this->session->idData);
        $this->db->order_by('j.id', 'DESC');
        $tugas = $this->db->get('jadwal j')->result();
        foreach ($tugas as $k => $t) {
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
            $tugas[$k] = $t;
        }
        echo json_encode($tugas);
    }

    function get_personil_dokumen() {
        $personil = $this->m_position_personil->get_by_document($this->input->get('id'));
        echo json_encode($personil);
    }

    function set_tugas() {
        $this->load->model('m_notif');
        $msg = [];
        $msg['status'] = 'success';
        if ($this->input->post('mode') == 'create') {
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            if ($this->input->post('form_terkait')) {
                $this->db->set('pembuat', $this->input->post('form_terkait'));
            }
            if ($this->input->post('form_terkait')) {
                $this->db->set('form_terkait', $this->input->post('form_terkait'));
            }
            $this->db->set('id_project', $this->session->idData);
            $this->db->insert('tugas');
            $id = $this->db->insert_id();
            $this->m_log->create_tugas($id);
            foreach ($this->input->post('personil') as $k => $p) {
                $this->db->set('id_tugas', $id);
                $this->db->set('id_position_personil', $p);
                $this->db->insert('personil_task');
                $this->m_notif->set2($p, 'TASK', $id, 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>'.$this->input->post('nama').'</b> di Standar <b>'.$this->session->activeStandard['name'].'</b>');
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
            }
            $this->db->set('id_tugas', $id);
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->insert('jadwal'); 
        } elseif ($this->input->post('mode') == 'edit') {
            $this->db->set('id_document', $this->input->post('dokumen'));
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('sifat', $this->input->post('sifat'));
            if ($this->input->post('pembuat')) {
                $this->db->set('pembuat', $this->input->post('pembuat'));
            }
            if ($this->input->post('proyek')) {
                $this->db->set('id_project', $this->input->post('proyek'));
            }
            $this->db->where('id', $this->input->post('id_tugas'));
            $this->db->update('tugas');
            $this->m_log->update_tugas($this->input->post('id_tugas'));
            $this->load->model('m_tugas');
            $pelaksana = $this->m_tugas->editPelaksana($this->input->post('id_tugas'), $this->input->post('personil'));
            foreach ($pelaksana as $k => $p) {
                $this->m_notif->set2($p, 'TASK', $this->input->post('id_tugas'), 'Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>'.$this->input->post('nama').'</b> di Standar <b>'.$this->session->activeStandard['name'].'</b>');
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
            $this->db->set('tanggal', $this->input->post('jadwal'));
            $this->db->where('id', $this->input->post('id_jadwal'));
            $this->db->update('jadwal');
        } elseif ($this->input->post('mode') == 'delete') {
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('personil_task');
            $this->db->where('id_tugas', $this->input->post('id'));
            $this->db->delete('jadwal');
            $result = $this->db->get_where('tugas', ['id' => $this->input->post('id')])->row();
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('tugas');
            $this->m_log->delete_tugas($result->nama);
            $this->data['msgSuccess'] = 'Berhasil Menghapus Data';
        } elseif ($this->input->post('upload')) {
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
