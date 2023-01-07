<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empgraph_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if (trim($dbname)) {
            $this->db->query("Use $dbname");
        }
        date_default_timezone_set('Asia/Calcutta');
    }

    public function getData($table) {
        $this->db->order_by('Esg_id', 'DESC');
        return $this->db->get($table)->result_array();
    }

    public function saveBatch($table, $data) {
        $this->db->insert_batch($table, $data);
        return $this->db->insert_id();
    }

    public function get_data($table, $condition) {
        return $this->db->get_where($table, $condition)->result_array();
    }

    public function get_data_order($table, $condition) {
        $this->db->order_by('survey_id', 'DESC');
        return $this->db->get_where($table, $condition)->result_array();
    }

    public function savedata($table, $data) {
        $res = $this->db->insert($table, $data);
        if ($res) {
            return $this->db->insert_id();
            ;
        } else {
            return false;
        }
    }

    public function updatedata($table, $data, $condition) {
        $this->db->where($condition);
        $res = $this->db->update($table, $data);
        if ($res) {
            return $this->db->insert_id();
            ;
        } else {
            return false;
        }
    }

    public function deletedata($table, $condition) {
        $this->db->where($condition);
        $res = $this->db->delete($table);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function get_graph_emp_list() {


        $query = $this->db->query("SELECT `esg_id`, `user_id` FROM emp_salary_graph_txt_dtls WHERE `esg_id` IN (SELECT MAX(`esg_id`) FROM emp_salary_graph_txt_dtls GROUP BY `user_id`)");
        return $query->result_array();
    }

    public function get_graph_emp_dtls($userid) {
        $this->db->select("*");
        $this->db->from("emp_salary_graph_txt_dtls");
        $this->db->where("user_id", $userid);
        $this->db->order_by('esg_id', 'desc');
        $this->db->limit(1);
        return $this->db->get()->row_array();
        //echo $this->db->last_query();
    }

}
