<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_cycle_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		$dbname = $this->session->userdata("dbname_ses");
		if(trim($dbname))
		{
			$this->db->query("Use $dbname");
		}
    }

	public function insert_performance_cycle($data)
	{
		$this->db->insert("performance_cycle",$data);
		return $this->db->insert_id();//($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	public function update_performance_cycle_dtls($condition, $data)
    {
        $this->db->where($condition);
        $this->db->update('performance_cycle',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

	public function get_performance_cycles($condition_arr)
	{
		$this->db->select("performance_cycle.*, (select count(*) from hr_parameter where hr_parameter.performance_cycle_id = performance_cycle.id and hr_parameter.status != ".CV_STATUS_RULE_DELETED.") as salary_rules_count, (select count(*) from hr_parameter_bonus where hr_parameter_bonus.performance_cycle_id = performance_cycle.id and hr_parameter_bonus.status != ".CV_STATUS_RULE_DELETED.") as bonus_rules_count, (select count(*) from lti_rules where lti_rules.performance_cycle_id = performance_cycle.id and lti_rules.status != ".CV_STATUS_RULE_DELETED.") as lti_rules_count, (select count(*) from rnr_rules where rnr_rules.performance_cycle_id = performance_cycle.id and rnr_rules.status != ".CV_STATUS_RULE_DELETED.") as rnr_rules_count, (SELECT COUNT(*) FROM sip_hr_parameter WHERE sip_hr_parameter.performance_cycle_id = performance_cycle.id AND sip_hr_parameter.status != ".CV_STATUS_RULE_DELETED.") AS sip_rules_count");
		$this->db->from("performance_cycle");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("performance_cycle.id asc");
		return $this->db->get()->result_array();
	}

	public function get_performance_cycle_dtls($condition_arr)
	{
		$this->db->select("performance_cycle.*, (select count(*) from hr_parameter where hr_parameter.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as salary_rules_count, (select count(*) from hr_parameter_bonus where hr_parameter_bonus.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as bonus_rules_count, (select count(*) from lti_rules where lti_rules.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as lti_rules_count, (select count(*) from rnr_rules where rnr_rules.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as rnr_rules_count, (SELECT COUNT(*) FROM sip_hr_parameter WHERE sip_hr_parameter.performance_cycle_id = performance_cycle.id AND status != ".CV_STATUS_RULE_DELETED.") AS sip_rules_count");
		$this->db->from("performance_cycle");
		return $this->db->where($condition_arr)->get()->row_array();
	}

	public function get_performance_cycle_dtls_sip_NIU($condition_arr)
	{
		$this->db->select("performance_cycle.*, (select count(*) from hr_parameter where hr_parameter.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as salary_rules_count, (select count(*) from sip_hr_parameter where sip_hr_parameter.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as bonus_rules_count, (select count(*) from lti_rules where lti_rules.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as lti_rules_count, (select count(*) from rnr_rules where rnr_rules.performance_cycle_id = performance_cycle.id and status != ".CV_STATUS_RULE_DELETED.") as rnr_rules_count");
		$this->db->from("performance_cycle");
		return $this->db->where($condition_arr)->get()->row_array();
	}

	public function get_salary_rules_list($condition_arr, $order_by = "")
	{
		$this->db->select("hr_parameter.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (SELECT ".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.id = hr_parameter.createdby) AS created_by_name, (SELECT COUNT(*) FROM salary_rule_users_dtls WHERE salary_rule_users_dtls.rule_id = hr_parameter.id) AS rule_tot_emp_cnt");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		return $this->db->get()->result_array();
	}

	public function get_bonus_rules_list($condition_arr)
	{
		$this->db->select("hr_parameter_bonus.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = hr_parameter_bonus.createdby) AS created_by_name, (SELECT COUNT(*) FROM bonus_rule_users_dtls WHERE bonus_rule_users_dtls.rule_id = hr_parameter_bonus.id) AS rule_tot_emp_cnt, performance_cycle.type");
		$this->db->from("hr_parameter_bonus");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

  public function get_sip_rules_list($condition_arr)
	{
		$this->db->select("sip_hr_parameter.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = sip_hr_parameter.createdby) AS created_by_name, (SELECT COUNT(*) FROM sip_rule_users_dtls WHERE sip_rule_users_dtls.rule_id = sip_hr_parameter.id) AS rule_tot_emp_cnt, performance_cycle.type");
		$this->db->from("sip_hr_parameter");
		$this->db->join("performance_cycle", "performance_cycle.id = sip_hr_parameter.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	public function get_lti_rules_list($condition_arr)
	{
		$this->db->select("lti_rules.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = lti_rules.createdby) as created_by_name");
		$this->db->from("lti_rules");
		$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	public function get_rnr_rules_list($condition_arr)
	{
		$this->db->select("rnr_rules.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = rnr_rules.createdby) as created_by_name, (SELECt COUNT(*) FROM proposed_rnr_dtls prd WHERE prd.rule_id = rnr_rules.id) AS proposed_usr_cnts");
		$this->db->from("rnr_rules");
		$this->db->join("performance_cycle", "performance_cycle.id = rnr_rules.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	public function get_user_rights_dtls_NIU()
	{
		$this->db->select("user_rights.*");
        $this->db->from("user_rights");
		$this->db->where(array("status"=>1, "user_id"=>$this->session->userdata('userid_ses')));
		return $this->db->get()->row_array();
	}

	public function get_table($table, $fields, $condition_arr, $order_by = "id")
	{
		$this->db->select($fields);
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->result_array();
	}


	###################### Kingjuliean Work #################

		public function sentEmailToApprovers($id,$approver)
		{

			if(empty($approver))
			{
				$approver=$this->session->userdata('email_ses');
			}

			return $this->db->query("SELECT esd.approver_1,lu.name,lu.id FROM `employee_salary_details` as esd JOIN login_user as lu on lu.email=esd.approver_1 where esd.rule_id='".$id."' and esd.approver_1!='".$this->session->userdata('email_ses')."' group by esd.approver_1")->result();
		}

		public function reminderEmailToApprovers($id)
		{

			return $this->db->query("SELECT lu.approver_1,lu.name FROM salary_rule_users_dtls as srud JOIN login_user as lu on srud.user_id=lu.id where srud.rule_id='".$id."' and srud.status<5 group by approver_1")->result();

		}




	################################################

}
