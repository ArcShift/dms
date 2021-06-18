<?php

class Project_tugas extends MY_Controller {

    protected $module = 'project_tugas';

    function index() {
        $this->subModule = 'read';
        $this->render('index');
    }

    function get_project() {
        $this->db->select('p.*, COUNT(t.id) AS tugas');
        $this->db->join('tugas t', 't.id_project = p.id', 'LEFT');
        $this->db->group_by('p.id');
        $data = $this->db->get_where('project p', ['p.id_company' => $this->session->activeCompany['id']])->result();
        echo json_encode($data);
    }

    function set_project() {
        $resp['status'] = 'success';
        if ($this->input->post('mode') == 'create') {
            $this->db->set('id_company', $this->session->activeCompany['id']);
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->insert('project');
        } elseif ($this->input->post('mode') == 'hapus') {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('project');
            $resp['message'] = 'Berhasil Menghapus data';
        } elseif ($this->input->post('mode') == 'edit') {
            $this->db->set('nama', $this->input->post('name'));
            $this->db->set('deskripsi', $this->input->post('desc'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('project');
        }
        echo json_encode($resp);
    }

    function get_tugas() {
        $this->load->model('m_personil');
        $this->db->select('j.*, pr.nama AS project, t.nama AS tugas, t.id_document, t.form_terkait, t.sifat, t.id_project');
        $this->db->join('tugas t', 't.id = j.id_tugas');
        $this->db->join('document d', 'd.id = t.id_document');
        $this->db->join('project pr', 'pr.id = t.id_project', 'LEFT');
        $this->db->where('d.id_company', $this->session->activeCompany['id']);
        $this->db->where('d.id_standard', $this->session->activeStandard['id']);
        $this->db->order_by('j.id', 'DESC');
        $jadwal = $this->db->get('jadwal j')->result();
        foreach ($jadwal as $k => $j) {
            $j->pelaksana = $this->m_personil->position_personil($j->id_tugas);
            if (!empty($j->tanggal) & !empty($j->upload_date)) {
                $d1 = new DateTime(date('Y-m-d', strtotime($j->upload_date)));
                $d2 = new DateTime($j->tanggal);
                if ($d1->diff($d2)->invert) {
                    $j->deadline = '<span class="badge badge-danger">terlambat</span>';
                } else {
                    $j->deadline = '<span class="badge badge-success">selesai</span>';
                }
            } else {
                $j->deadline = '<span class="badge badge-primary">menunggu</span>';
            }
            $jadwal[$k] = $j;
        }
        echo json_encode($jadwal);
    }

}
