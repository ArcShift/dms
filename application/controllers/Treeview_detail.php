<?php

class Treeview_detail extends MY_Controller {

    protected $module = 'treeview_detail';

    function __construct() {
        parent::__construct();
        $this->load->model('m_treeview_detail', 'model');
    }

    private function ajax_request() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    function index() {
        $this->load->model('m_company');
        $this->data['company'] = $this->m_company->get();
        $this->render('read');
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
        if ($this->model->insert_distribusi()) {
            echo 'success';
        } else {
            echo 'error';
        }
        print_r($this->input->post());
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

    function tugas() {
        if ($this->model->tugas()) {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
            $result['message'] = $this->db->error()['message'];
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
        if ($this->model->insertSchedule()) {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
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
        echo json_encode($this->model->getPemenuhan());
    }
    function get_pemenuhan_test() {
        $result = $this->model->getPemenuhan();
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
            . '<td>' .$k. '</td>'
            . '<td>' .$r['sort_index']. '</td>'
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
