<?php

class Implementasi extends MY_Controller {

    protected $module = "implementasi";

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
        $this->load->model('m_notif');
    }

    private function ajax_request() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    function index() {
        $this->subTitle = 'List';
        $this->subModule = 'read';
        $this->data['menuStandard'] = 'standard';
        $this->render('index');
    }

    function standard() {
        $this->ajax_request();
        echo json_encode($this->model->standard());
    }

    function anggota() {
        $this->ajax_request();
        echo json_encode($this->model->member());
    }

    function personil() {
        $this->ajax_request();
        echo json_encode($this->model->personil());
    }

    function pasal() {
        $this->session->set_userdata('md_standard', $this->input->get('standar'));
        $this->ajax_request();
        echo json_encode($this->model->pasal());
    }

    function unit_kerja() {
        $this->ajax_request();
        echo json_encode($this->model->unit_kerja());
    }

    function create_dokumen() {
        $this->ajax_request();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pasal', 'Pasal', 'required');
        if (!$this->input->post('pasals')) {
            $this->form_validation->set_rules('pasals', 'Pasal Lain', 'required');
        }
        $this->form_validation->set_rules('nomor', 'Nomor', 'required');
        $result['status'] = 'error';
        if ($this->form_validation->run()) {
            $step = true;
            if ($this->input->post('type_dokumen') == 'FILE' & !empty($_FILES['dokumen']['name'])) {
                $config['upload_path'] = './upload/dokumen';
                $config['allowed_types'] = '*';
                $config['max_size'] = '5000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('dokumen')) {
                    $result['message'] = $this->upload->display_errors();
                    $step = false;
                }
            }
            if ($step) {
                if ($this->model->create_document()) {
                    $result['status'] = 'success';
                } else {
                    $result['message'] = $this->db->error()['message'];
                }
            }
        } else {
            $result['message'] = validation_errors();
        }
        echo json_encode($result);
    }

    function get_dokumen() {
        $this->ajax_request();
        echo json_encode($this->model->read_document());
    }

    function hapus_dokumen() {
        $this->ajax_request();
        if ($this->model->delete_document()) {
            $result['status'] = 'success';
        }
        return $result;
    }

    function get_distribusi() {
        $this->ajax_request();
        echo json_encode($this->model->read_distribusi());
    }

    function set_distribusi() {
        $this->ajax_request();
        $penerima = $this->model->EditDistribusi();
        $result['status'] = 'success';
        $result['message'] = 'Berhasil';
        $this->db->select('d.judul AS document, s.name AS standard');
        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
        $this->db->join('pasal p', 'p.id = dp.id_pasal');
        $this->db->join('standard s', 's.id = p.id_standard');
        $this->db->where('d.id', $this->input->post('dokumen'));
        $r = $this->db->get('document d')->row_array();
        $msg = "Anda telah terdaftar sebagai penerima dokumen untuk dokumen dengan judul <b>" . $r['document'] . "</b> di standar <b>" . $r['standard'] . '</b>';
        foreach ($penerima as $p) {
            $this->db->select('u.*');
            $this->db->join('position_personil pp', 'pp.id_personil = p.id AND pp.id = ' . $p);
            $this->db->join('users u', 'u.id_personil = p.id');
            $user = $this->db->get('personil p')->row_array();
            if (!empty($user)) {
                if (!empty($user['email']) & $user['notif_email'] == 'ENABLE') {//cek apakah user memiliki email
                    $statusEmail = parent::notif_mail($user['email'], 'Distribusi Dokumen', $msg);
                    if ($statusEmail !== true) {
                        $result['status'] = 'error';
                        $result['message'] = 'Gagal mengirim notifikasi email';
                        $result['message2'] = $statusEmail;
                    }
                }
                $this->m_notif->set($user['id'], 'DIST', $this->input->post('dokumen'), $msg);
            }
        }
        echo json_encode($result);
    }

    function delete_distribusi() {
        $this->ajax_request();
        if ($this->model->delete_distribusi()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    function get_tugas() {
        echo json_encode($this->model->readsTugas());
    }

//    function tugas() {
//        if ($this->model->tugas()) {
//            $result['status'] = 'success';
//        } else {
//            $result['status'] = 'error';
//            $result['message'] = $this->db->error()['message'];
//        }
//        echo json_encode($result);
//    }

    function tugas2() {
        $result['status'] = 'success';
        if ($this->input->post('delete-id')) {//hapus tugas
            if ($this->model->tugas_delete($this->input->post('delete-id'))) {
                $result['message'] = 'Berhasil menghapus data';
            }
        } else {
            $id_tugas = $this->model->tugas();
            $penerima = $this->model->editPenerima($id_tugas);
            $result['message'] = 'Berhasil';
            foreach ($penerima as $p) {
                $this->db->select('u.*');
                $this->db->join('position_personil pp', 'pp.id_personil = p.id AND pp.id = ' . $p);
                $this->db->join('users u', 'u.id_personil = p.id');
                $user = $this->db->get('personil p')->row_array();
                if (!empty($user)) {
                    $this->db->select('t.nama AS tugas, s.name AS standard');
                    $this->db->join('document d', 'd.id = t.id_document');
                    $this->db->join('document_pasal dp', 'dp.id_document = d.id');
                    $this->db->join('pasal p', 'p.id = dp.id_pasal');
                    $this->db->join('standard s', 's.id = p.id_standard');
                    $this->db->where('t.id', $id_tugas);
                    $r = $this->db->get('tugas t')->row_array();
                    $msg = "Anda telah terdaftar sebagai pelaksana tugas untuk tugas dengan judul <b>" . $r['tugas'] . "</b> di Standar <b>" . $r['standard'] . "</b>";
                    if (!empty($user['email']) & $user['notif_email'] == 'ENABLE') {//cek apakah user memiliki email
                        $statusEmail = parent::notif_mail($personil['email'], $personil['fullname'] . ' menerima tugas', $msg);
                        if ($statusEmail !== true) {
                            $result['status'] = 'error';
                            $result['message'] = 'Gagal mengirim notifikasi email';
                            $result['message2'] = $statusEmail;
                        }
                    }
                    $this->m_notif->set($user['id'], 'TASK', $id_tugas, $msg);
                }
            }
        }
        echo json_encode($result);
    }

    function get_jadwal() {
        $this->ajax_request();
        echo json_encode($this->model->getJadwal());
    }

    function get_implementasi() {
        $this->ajax_request();
        echo json_encode($this->model->getImplementasi());
    }

    function set_jadwal() {
        $this->ajax_request();
        $this->model->insertSchedule();
        $result['status'] = 'success';
        $id_tugas = $this->input->post('id-tugas');
        $this->db->select('p.fullname, u.*');
        $this->db->join('position_personil pp', 'pp.id_personil = p.id');
        $this->db->join('personil_task pt', 'pt.id_position_personil = pp.id');
        $this->db->join('tugas t', 't.id = pt.id_tugas');
        $this->db->join('users u', 'u.id_personil = p.id');
        $this->db->where('t.id', $id_tugas);
        $user = $this->db->get('personil p')->result_array();
        $this->db->select('t.id, t.nama AS tugas, s.name AS standard');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('document_pasal dp', 'dp.id_document = d.id');
        $this->db->join('pasal p', 'p.id = dp.id_pasal');
        $this->db->join('standard s', 's.id = p.id_standard');
        $t = $this->db->get('tugas t')->row_array();
        $msg = "Jadwal pelaksanaan tugas <b>" . $t['tugas'] . "</b> untuk standar <b>" . $t['standard'] . "</b> telah ditetapkan pada tanggal <b>" . $this->input->post('tanggal')[0] . '</b>';
        foreach ($user as $u) {
            if (!empty($u['email']) & $u['notif_email'] == 'ENABLE') {//cek apakah user memiliki email
                $statusEmail = parent::notif_mail($u['email'], $u['fullname'] . ' menerima tugas', $msg);
                if ($statusEmail !== true) {
                    $result['status'] = 'error';
                    $result['message'] = 'Gagal mengirim notifikasi email';
                    $result['message2'] = $statusEmail;
                }
            }
            $this->m_notif->set($u['id'], 'SCHEDULE', $t['id'], $msg);
        }
        echo json_encode($result);
    }

    function jadwal() {
        $this->ajax_request();
        if ($this->model->schedule()) {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
        }
        echo json_encode($result);
    }

    function upload_bukti() {
        $this->ajax_request();
        //TODO: form validation
        $step = true;
        if ($this->input->post('type_dokumen') == 'FILE') {
            $config['upload_path'] = './upload/implementasi';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('dokumen')) {
                $result['message'] = $this->upload->display_errors();
                $step = false;
            }
        }
        if ($step) {
            if ($this->model->upload_bukti()) {
                $result['status'] = 'success';
            } else {
                $result['message'] = $this->db->error()['message'];
            }
        }
        echo json_encode($result);
    }

    function upload_bukti_penerapan() {
        $config['upload_path'] = "./upload/penerapan";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("doc")) {
            if ($this->model->upload_bukti_penerapan()) {
                $status['status'] = 'success';
                $status['message'] = 'data berhasil diupload';
            } else {
                $status['status'] = 'error';
                $status['message'] = $this->db->error()['message'];
            }
            $data = array('upload_data' => $this->upload->data());
            $data1 = array(
                'menu_id' => $this->input->post('selectmenuid'),
                'submenu_id' => $this->input->post('selectsubmenu'),
                'imagetitle' => $this->input->post('imagetitle'),
                'imgpath' => $data['upload_data']['file_name']
            );
        } else {
            $status['status'] = 'error';
            $status['message'] = $this->upload->display_errors();
        }
        echo json_encode($status);
    }

    function get_pemenuhan() {
        echo json_encode($this->model->getPemenuhan($this->input->get('company'), $this->input->get('standard')));
    }

    function get_pemenuhan_test() {
        $result = $this->model->getPemenuhan($this->input->get('company'), $this->input->get('standard'));
        echo '<table border="1"><thead><tr>'
        . '<td>Index</td>'
        . '<td>sortIndex</td>'
        . '<td>Pasal</td>'
        . '<td>child</td>'
        . '<td>indexParent</td>'
        . '<td>indexChild</td>'
        . '<td>Doc</td>'
        . '<td>pemenuhan Doc</td>'
        . '<td>listDoc</td>'
        . '<td>tugas</td>'
        . '<td>Jadwal</td>'
        . '<td>Jadwals</td>'
        . '<td>Jadwal OK</td>'
        . '</tr></thead><tbody>';
        foreach ($result as $k => $r) {
            echo '<tr>'
            . '<td>' . $k . '</td>'
            . '<td>' . $r['sort_index'] . '</td>'
            . '<td>' . $r['name'] . '</td>'
            . '<td>' . $r['child'] . '</td>'
            . '<td>' . $r['indexParent'] . '</td>'
            . '<td>' . implode(',', $r['indexChild']) . '</td>'
            . '<td>' . $r['doc'] . '</td>'
            . '<td>' . $r['pemenuhanDoc'] . '%</td>'
            . '<td>' . $r['docs'] . '</td>'
            . '<td>' . $r['tugas'] . '</td>'
            . '<td>' . $r['jadwal'] . '</td>'
            . '<td>' . $r['jadwals'] . '</td>'
            . '<td>' . $r['jadwal_ok'] . '</td>'
            . '<td>' . $r['pemenuhanImp'] . '%</td>'
            . '</tr>';
        }
        echo '</tbody></table>';
    }

}
