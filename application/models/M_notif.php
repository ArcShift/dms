<?php

class M_notif extends CI_Model {
    private $table = 'notification';

    private function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function set($id_personil, $type, $id_target, $pesan) {
        $this->db->set('penerima', $id_personil);
        $this->db->set('type', $type);
        $this->db->set('target', $id_target);
        $this->db->set('pesan', $pesan);
        $this->db->insert('notification');
    }

    function get($limit, $status = null) {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
        $result = $this->db->get_where('notification', ['penerima' => $this->session->user['id']])->result_array();
        foreach ($result as $k => $v) {
            $result[$k]['ago'] = $this->time_elapsed_string($v['waktu']);
        }
        return $result;
    }

    function read_all() {
        $this->db->set('status', 'READ');
        $this->db->where('penerima', $this->session->user['id']);
        $this->db->update('notification');
    }

    function switch($id) {
        $data = $this->db->get_where('notification', ['id' => $id])->row_array();
        $sw = $data['status'] == 'READ' ? 'UNREAD' : 'READ';
        $this->db->where('id', $id);
        $this->db->set('status', $sw);
        $this->db->update('notification');
    }
    function count_unread() {
        $this->db->where('status', 'UNREAD');
        $this->db->where('penerima', $this->session->user['id']);
        return $this->db->count_all_results($this->table);
    }
}
