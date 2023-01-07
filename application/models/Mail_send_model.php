<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail_send_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if (trim($dbname)) {
            $this->db->query("Use $dbname");
        }
        date_default_timezone_set('Asia/Calcutta');
    }


    public function insert_dump_data($id = 11) {
        $db_arr['id'] = $id;
        $this->db->insert("tbl_text", $db_arr);
        return $this->db->insert_id();
    }

    public function update_mail_data($data, $where_condition) {
        $this->db->where($where_condition);
        $this->db->update('cron_mail_queue', $data);
    }

################################################################################
}
