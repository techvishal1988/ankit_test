<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

        $dbname = $this->session->userdata("dbname_ses");
        if (trim($dbname)) {
            $this->db->query("Use $dbname");
        }
        date_default_timezone_set('Asia/Calcutta');
    }

    public function is_valid_user($emailid, $pass, $company_id, $is_need_to_chk_pwd=1)
	   {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role,login_user.is_manager,login_user.manage_hr_only");
        $this->db->from("login_user");
      		if($is_need_to_chk_pwd == 2)
      		{
      			$this->db->where("email = '$emailid' AND login_user.status =1 AND login_user.incorrect_attempts < 3 AND login_user.company_Id = '$company_id'");
      		}
      		else
      		{
              	$this->db->where("email = '$emailid' AND pass = '$pass' AND login_user.status =1 AND login_user.incorrect_attempts < 3 AND login_user.company_Id = '$company_id'");
      		}
        $result = $this->db->get()->row_array();
        if ($result) {
            return $result;
        }
    }

    public function is_valid_sso_user($emailid, $company_id) {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role,login_user.is_manager,login_user.manage_hr_only");
        $this->db->from("login_user");
        $this->db->where("email = '$emailid' and login_user.status =1 and login_user.incorrect_attempts < 3 and login_user.company_Id = '$company_id'");
        //$this->db->where("role <= 10");
        $result = $this->db->get()->row_array();
        if ($result) {
            return $result;
        }
    }


    public function check_account_is_verified($uid, $emailid) {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role,login_user.is_manager,login_user.manage_hr_only");
        $this->db->from("login_user");
        $this->db->where("email = '$emailid' and id = '$uid' and login_user.status =0 and pass =''");
        $result = $this->db->get()->row_array();
        if ($result) {
            return $result;
        }
    }

    public function change_password($condition_arr, $setData) {
        $this->db->where($condition_arr);
        $this->db->update('login_user', $setData);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_staff_list() {
        $this->db->select("id, email, name, role, desig, status");
        return $this->db->from("login_user")->get()->result_array();
    }

    public function get_dashboard_statics() {
        $this->db->select("count(id) as performance_cycle, (select count(*) from login_user where role=2) as hr_admin_user, (select count(*) from login_user where role=3) as hr_user, (select count(*) from login_user where role=4) as managers,");
        return $this->db->from("performance_cycle")->get()->row_array();
    }

    public function get_employees_by_uploaded_id_list($upload_id) {
        $this->db->select("login_user.*, tuple.row_num");
        $this->db->from("tuple");
        $this->db->join("login_user", "tuple.user_id = login_user.id");
        $this->db->where("data_upload_id = '$upload_id'");
        return $this->db->get()->result_array();
    }

    public function get_user_dtl($condition_arr) {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.desig");
        $this->db->from("login_user");
        $this->db->where($condition_arr);
        return $this->db->get()->row_array();
    }

    public function insert_notifications($data) {
        $this->db->insert("notifications", $data);
        return $this->db->insert_id();
    }

    public function get_notifications($condition_arr) {
        $this->db->select("*");
        $this->db->from("notifications");
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->order_by("createdon", "desc");
        return $this->db->get()->result_array();
    }

    public function update_notifications($condition_arr, $setData) {
        $this->db->where($condition_arr);
        $this->db->update('notifications', $setData);
    }

    public function get_table_row($table, $fields, $condition_arr) {
        $this->db->select($fields);
        $this->db->from($table);
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }

    public function check_login_attempt($email, $check_attemp = '') {

        if (empty($check_attemp)) {
            $token = '';
            $this->db->set('incorrect_attempts', 'incorrect_attempts+1', FALSE);
            // $this->db->where(array('email'=>$email,'incorrect_attempts < ' => 3));
            $this->db->where(array('email' => $email));
            $this->db->update('login_user');
            $row_affected = $this->db->affected_rows();
            if ($row_affected) {
                $this->db->select('incorrect_attempts');
                $res = $this->db->get_where('login_user', array('email' => $email))->row();
                if ($res->incorrect_attempts == 3) {
                    $new_web_token = HLP_generate_web_token();
                    $this->db->where('email', $email);
                    $this->db->update('login_user', array('web_token' => $new_web_token));
                }
            }
            return false;
        } else {
            $this->db->select('incorrect_attempts,web_token,email,id,name');
            $res = $this->db->get_where('login_user', array('email' => $email))->row();
            return $res;
        }
    }

    public function generate_token_request($email) {
        $new_web_token = HLP_generate_web_token();
        $this->db->where('email', $email);
        $this->db->update('login_user', array('web_token' => $new_web_token));
    }

    public function reset_login_attempt($email) {
        $this->db->set('incorrect_attempts', 0);
        $this->db->where('email', $email);
        $this->db->update('login_user');
        return;
    }

    public function check_reset_token($token, $emailid) {

        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role,login_user.is_manager,login_user.manage_hr_only");
        $this->db->from("login_user");
        $this->db->where("email = '$emailid' and login_user.status = 1 and incorrect_attempts >= 3 and web_token = '$token'");
        $result = $this->db->get()->row_array();
        if ($result) {
            return $result;
        }
    }

    public function get_unblockeduserinfo($uid, $uemail) {
        return $this->db->get_where('login_user', array('email' => $uemail, 'id' => $uid))->row();
    }

    public function checked_blocked_user_info($uid, $emailid) {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role,login_user.is_manager,login_user.manage_hr_only");
        $this->db->from("login_user");
        $this->db->where("email = '$emailid' and id = '$uid'");
        $result = $this->db->get()->row_array();
        if ($result) {
            return $result;
        }
    }

    //** user logged functions **//
    public function logged_user_details($data) {
        $this->db->insert("user_logged_dtls", $data);
        return $this->db->insert_id();
    }

    public function log_update_details($user_id) {
        $this->db->select("id");
        $this->db->from("user_logged_dtls");
        $this->db->where('user_id', $user_id);
        $this->db->where('updatedon', '0000-00-00 00:00:00');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $result = $this->db->get()->row_array();
        $this->db->where('id', $result['id']);
        $this->db->update('user_logged_dtls', array('updatedon' => date('Y-m-d h:i:s')));
    }

}
