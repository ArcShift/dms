<?php

class MY_Controller extends CI_Controller {

    protected $module = null;
    protected $subModule = null;
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
        $this->load->model("m_setting");
        $this->role = $this->session->userdata['user']['role'];
        date_default_timezone_set('Asia/Jakarta');
    }

    protected function render($view, $includeModule = true, $blank = false) {
        $this->load->model('m_notif', 'm_notif');
        $this->data['count_unread'] = $this->m_notif->count_unread();
        $this->data['notif'] = $this->m_notif->get(10);
        foreach ($this->session->userdata('module') as $k => $m) {
            if ($m['name'] == $this->module) {
                $this->activeModule = $m;
            }
        }
        if(empty($this->subModule)){
            $this->subModule = $view;
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
        switch ($this->subModule) {
            case 'edit':$this->access = 'update';
                break;
            case 'detail':$this->access = 'read';
                break;
            default:
                break;
        }
        empty($this->access) ? $this->access = $this->subModule : null;
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
        $config['smtp_host'] = $this->m_setting->get('smtp_host');
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $this->m_setting->get('smtp_user');
        $config['smtp_pass'] = $this->m_setting->get('smtp_pass');
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; //text or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $this->load->library('email');
        $this->email->initialize($config);
//        $this->email->from('darkwarrior0236@gmail.com', 'DMS Delta');
        $this->email->from($this->m_setting->get('smtp_user'), 'DMS Delta');
//        $this->email->to($penerima);
        $this->email->to($penerima);
        $this->email->subject($judul);
        $this->email->message($message);
        $this->email->send();
        if (strlen($this->email->print_debugger()) < 20) {
            return true;
        } else {
            return $this->email->print_debugger();
        }
    }

}
