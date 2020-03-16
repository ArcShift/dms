<?php

class M_module extends CI_Model {

    public function create() {
        $data = array(
            "nama" => $this->input->post("nama")
        );
        if($this->input->post("induk")){
            $data['parent']=$this->input->post("induk");
        }
        if ($this->db->insert("modul", $data)) {
            $this->session->set_userdata('menu', $this->model->read());
            return 'success';
        } else {
            return $this->db->_error_message();
        }
    }

    public function read() {
//        $this->db->select("id, name");
        $this->db->order_by('id', 'ASC');
        return $this->db->get("module")->result_array();
    }

    public function update() {
        
    }

    public function delete() {
        $this->db->where("id", $this->input->post("id"));
        if ($this->db->delete("modul")) {
            $this->session->set_userdata('menu', $this->model->read());
            return 'success';
        } else {
            return $this->db->_error_message();
        }
    }

    public function structure() {
        $result = $this->db->get("modul m")->result_array();
    }

    public function sort() {
        
    }

}
