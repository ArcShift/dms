<?php

class MY_Controller extends CI_Controller {

    protected $module = null;
    protected $title = null;
    protected $subTitle = null;
    protected $data = array();
    protected $activeModule = null;
    protected $access = null;
    public $role = null;

    public function __construct() {
        parent::__construct();
        if (!$this->session->has_userdata('user')) {
            redirect('login');
        }
        $this->load->model("base_model", "b_model");
        $this->load->model("m_setting", "m_setting");
        $this->role = $this->session->userdata['user']['role'];
    }

    protected function render($view, $includeModule = true, $blank = false) {
        $this->load->model('m_notif', 'm_notif');
        $this->data['notif'] = $this->m_notif->notif2(10);
        foreach ($this->session->userdata('module') as $k => $m) {
            if ($m['name'] == $this->module) {
                $this->activeModule = $m;
            }
        }
        $this->data['module'] = $this->module;
        $this->data['activeModule'] = $this->activeModule;
        $this->data['subTitle'] = $this->subTitle;
        $this->data['role'] = $this->role;
        if (isset($this->data['menuStandard'])) {
            if (empty($this->session->user['id_company'])) {
                $this->data['companies'] = $this->db->get('company')->result_array();
            }
        }
        switch ($view) {
            case 'edit':$this->access = 'update';
                break;
            case 'detail':$this->access = 'read';
                break;
            default:
                break;
        }
        empty($this->access) ? $this->access = $view : null;
        if (empty($this->activeModule['acc_' . $this->access])) {
            $this->data['view'] = 'template/no_access';
            $this->load->view('template/container', $this->data);
        } else {
            if ($includeModule) {
                $this->data['view'] = $this->module . '/' . $view;
            } else {
                $this->data['view'] = $view;
            }
            if ($blank) {
                $this->load->view($this->data['view'], $this->data);
            } else {
                $this->load->view('template/container', $this->data);
            }
        }
    }

    function hapus($config) {
        if ($this->input->post('initHapus')) {
            $config['id'] = $this->input->post('initHapus');
            if (isset($config['field'])) {
                $config['name'] = $this->model->detail($config['id'])[$config['field']];
            } else {
                $config['name'] = $this->model->detail($config['id'])['name'];
            }
            $this->session->set_userdata('delete', $config);
        } else if ($this->input->post('hapus')) {
            if ($this->b_model->delete()) {
                $this->session->set_flashdata('msgSuccess', 'Data berhasil dihapus');
            } else {
                $this->session->set_flashdata('msgError', $this->db->error()['message']);
            }
            redirect($this->module);
        } else {
            redirect($this->module);
        }
        $this->subTitle = 'Delete';
        $this->access = 'delete';
        $this->render('template/delete', FALSE);
    }

    function notif_mail($penerima, $judul, $message) {
        // load from setting
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = 'knightarcher1@gmail.com';
        $config['smtp_pass'] = '3ep5c98Hyys3NmF';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('darkwarrior0236@gmail.com', 'DMS Delta');
//        $this->email->to($penerima);
        $this->email->to('ma.kaafi@yahoo.co.id');
        $this->email->subject($judul);
        $this->email->message($message);
        $this->email->send();
        if (empty($this->email->print_debugger())) {
            die('debug');
            return true;
        } else {
            return $this->email->print_debugger();
        }
    }

}
