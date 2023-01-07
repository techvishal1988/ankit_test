<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Approvel_model extends CI_Model
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
		date_default_timezone_set('Asia/Calcutta');
    }

    public function create_approvel_req($upload_id,$user_id)
	{
		$approvel_stag = 1;
		$approver_id = $user_id;

		$result = $this->db->select("id")->where(array("company_Id"=>$this->session->userdata("companyid_ses"), "role"=>$this->session->userdata("role_ses"), "id !=" =>$user_id))->get("login_user")->row_array();

		if($result)
		{
			//$approver_id = $result["id"];
		}

		$this->db->insert("approvel_requests",array("upload_id"=>$upload_id,"user_id"=>$approver_id,"approvel_stag"=>$approvel_stag,"createdon"=>date("Y-m-d H:i:s"), "type"=>1));
	}

    public function create_rule_approvel_req($rule_id, $user_id, $type=1)
	{
		$approvel_stag = 1;
		$approver_id = $user_id;

		$result = $this->db->select("id")->where(array("company_Id"=>$this->session->userdata("companyid_ses"), "role"=>$this->session->userdata("role_ses"), "id !=" =>$user_id))->get("login_user")->row_array();

		// if($result)
		// {
		// 	$approver_id = $result["id"];
		// }

		$this->db->insert("approvel_requests",array("rule_id"=>$rule_id,"user_id"=>$approver_id,"approvel_stag"=>$approvel_stag,"createdon"=>date("Y-m-d H:i:s"), "type"=>$type, "createdby"=>$user_id, "createdby_proxy"=>$this->session->userdata("proxy_userid_ses")));

		if($type==2)
		{
			$db_arr = array("notification_for"=>"New salary rule approval request", "message"=> "New salary rule approval request generated on ".date("d-m-Y"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$approver_id);
			$this->db->insert("notifications",$db_arr);
		}
		elseif($type==3)
		{
			$db_arr = array("notification_for"=>"New bonus rule approval request", "message"=> "New bonus rule approval request generated on ".date("d-m-Y"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$approver_id);
			$this->db->insert("notifications",$db_arr);
		}
		elseif($type==4)
		{
			$db_arr = array("notification_for"=>"New LTI rule approval request", "message"=> "New LTI rule approval request generated on ".date("d-m-Y"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$approver_id);
			$this->db->insert("notifications",$db_arr);
		}
		elseif($type==5)
		{
			$db_arr = array("notification_for"=>"New R and R rule approval request", "message"=> "New R and R rule approval request generated on ".date("d-m-Y"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$approver_id);
			$this->db->insert("notifications",$db_arr);
		}
    elseif($type==6)
		{
			$db_arr = array("notification_for"=>"New SIP rule approval request", "message"=> "New SIP rule approval request generated on ".date("d-m-Y"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$approver_id);
			$this->db->insert("notifications",$db_arr);
		}
	}

	public function update_approvel_req($upload_id,$user_id)
	{
		$flag = 0;
		$result = $this->db->select("*")->where(array("user_id"=>$user_id,"upload_id"=>$upload_id,"status"=>0, "type"=>1))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function update_salary_rule_approvel_req($rule_id,$user_id)
	{
		$flag = 0;
		//$result = $this->db->select("*")->where(array("user_id"=>$user_id,"rule_id"=>$rule_id,"status"=>0, "type"=>2))->get("approvel_requests")->row_array();
		$result = $this->db->select("*")->where(array("rule_id"=>$rule_id,"status"=>0, "type"=>2))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function update_bonus_rule_approvel_req($rule_id,$user_id)
	{
		$flag = 0;
		//$result = $this->db->select("*")->where(array("user_id"=>$user_id,"rule_id"=>$rule_id,"status"=>0, "type"=>3))->get("approvel_requests")->row_array();
		$result = $this->db->select("*")->where(array("rule_id"=>$rule_id,"status"=>0, "type"=>3))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function update_sip_rule_approvel_req($rule_id,$user_id) {
		$flag = 0;
		//$result = $this->db->select("*")->where(array("user_id"=>$user_id,"rule_id"=>$rule_id,"status"=>0, "type"=>3))->get("approvel_requests")->row_array();
		$result = $this->db->select("*")->where(array("rule_id"=>$rule_id,"status"=>0, "type"=>6))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function update_lti_rule_approvel_req($rule_id,$user_id)
	{
		$flag = 0;
		//$result = $this->db->select("*")->where(array("user_id"=>$user_id,"rule_id"=>$rule_id,"status"=>0, "type"=>4))->get("approvel_requests")->row_array();
		$result = $this->db->select("*")->where(array("rule_id"=>$rule_id,"status"=>0, "type"=>4))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function update_rnr_rule_approvel_req($rule_id,$user_id)
	{
		$flag = 0;
		//$result = $this->db->select("*")->where(array("user_id"=>$user_id,"rule_id"=>$rule_id,"status"=>0, "type"=>5))->get("approvel_requests")->row_array();
		$result = $this->db->select("*")->where(array("rule_id"=>$rule_id,"status"=>0, "type"=>5))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$result["id"]));
			$flag = 1;
		}
		return $flag;
	}

	public function get_approvel_request_list($user_id)
	{
		$this->db->select("performance_cycle.id, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, performance_cycle.description, approvel_requests.createdon as request_date, approvel_requests.upload_id");
		$this->db->from("approvel_requests");
		$this->db->join("data_upload","data_upload.id = approvel_requests.upload_id");
		$this->db->join("performance_cycle","data_upload.performance_cycle_id = performance_cycle.id");
		$result = $this->db->where(array("approvel_requests.user_id"=>$user_id,"approvel_requests.status"=>0, "approvel_requests.type"=>1))->get()->result_array();
		return $result;
	}

	public function create_update_approvel_req($upload_id,$user_id)
	{
		$approvel_stag = 1;
		$approver = CV_FIRST_APPROVER;
		$result = $this->db->select("*")->where(array("user_id"=>$user_id,"upload_id"=>$upload_id,"status"=>0))->get("approvel_requests")->row_array();
		if($result)
		{
			$this->db->update("approvel_requests", array('status'=>1,"updatedon"=>date("Y-m-d H:i:s")), array("id"=>$result["id"]));
			if($result["approvel_stag"]==1)
			{
				$approvel_stag = 2;
				$approver = CV_SECOND_APPROVER;
			}
			elseif ($result["approvel_stag"]==2)
			{
				$approvel_stag = 3;
				$approver = CV_THIRD_APPROVER;
			}
			elseif ($result["approvel_stag"]==3)
			{
				$approvel_stag = 4;
				$approver = CV_FOURTH_APPROVER;
			}
			elseif ($result["approvel_stag"]==4)
			{
				$approvel_stag = 5;// Final approved
			}
		}
		if($approvel_stag < 5)
		{
			$this->db->select("datum.uploaded_value")->from("datum");
			$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
			$result1 = $this->db->where(array("business_attribute.module_name"=>$approver, "data_upload_id"=>$upload_id))->get()->row_array();
			if($result1)
			{
				$result2 = $this->db->select("id")->where(array("company_Id"=>$this->session->userdata("companyid_ses"),"email"=>$result1["uploaded_value"]))->get("login_user")->row_array();
				if($result2)
				{
					$this->db->insert("approvel_requests",array("upload_id"=>$upload_id,"user_id"=>$result2["id"],"approvel_stag"=>$approvel_stag,"createdon"=>date("Y-m-d H:i:s")));
				}
			}

		}

	}

	/*public function fetchDatum_with_attributes($upload_id)
	{
		$this->db->select("datum.*, business_attribute.module_name, business_attribute.id as attribute_id");
		$this->db->from("datum");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		return  $this->db->where(array("datum.data_upload_id"=>$upload_id))->get()->result_array();
	}*/

	public function fetchDatum_with_attributes($upload_id)
	{
		$module_name_arr = array(CV_EMAIL_MODULE_NAME, CV_FIRST_APPROVER, CV_SECOND_APPROVER, CV_THIRD_APPROVER, CV_FOURTH_APPROVER, CV_COUNTRY, CV_CITY, CV_BUSINESS_LEVEL_1, CV_BUSINESS_LEVEL_2, CV_BUSINESS_LEVEL_3, CV_FUNCTION, CV_SUB_FUNCTION, CV_SUB_SUB_FUNCTION, CV_DESIGNATION, CV_GRADE, CV_LEVEL, CV_EDUCATION, CV_CRITICAL_TALENT, CV_CRITICAL_POSITION, CV_SPECIAL_CATEGORY, CV_CURRENCY);
		$this->db->select("datum.*, business_attribute.module_name, business_attribute.id as attribute_id");
		$this->db->from("datum");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where_in('business_attribute.module_name', $module_name_arr);
		return  $this->db->where(array("datum.data_upload_id"=>$upload_id, "datum.value !="=>""))->get()->result_array();
	}

	public function fetchDatum_with_modules_for_emp($cnd_arr)
	{
		$module_name_arr = array(CV_EMPLOYEE_FULL_NAME, CV_COUNTRY, CV_CITY, CV_BUSINESS_LEVEL_1, CV_BUSINESS_LEVEL_2, CV_BUSINESS_LEVEL_3, CV_FUNCTION, CV_SUB_FUNCTION, CV_SUB_SUB_FUNCTION, CV_DESIGNATION, CV_GRADE, CV_LEVEL, CV_EDUCATION, CV_CRITICAL_TALENT, CV_CRITICAL_POSITION, CV_SPECIAL_CATEGORY, CV_COMPANY_JOINING_DATE, CV_INCREMENT_PURPOSE_JOINING_DATE, CV_RECENTLY_PROMOTED, CV_CURRENCY);

		$this->db->select("datum.value, business_attribute.module_name,
		CASE module_name
		WHEN '".CV_COUNTRY."' then (select id from manage_".CV_COUNTRY." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_CITY."' then (select id from manage_".CV_CITY." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_BUSINESS_LEVEL_1."' then (select id from manage_".CV_BUSINESS_LEVEL_1." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_BUSINESS_LEVEL_2."' then (select id from manage_".CV_BUSINESS_LEVEL_2." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_BUSINESS_LEVEL_3."' then (select id from manage_".CV_BUSINESS_LEVEL_3." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_FUNCTION."' then (select id from manage_".CV_FUNCTION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_SUB_FUNCTION."' then (select id from manage_".CV_SUB_FUNCTION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_SUB_SUB_FUNCTION."' then (select id from manage_".CV_SUB_SUB_FUNCTION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_DESIGNATION."' then (select id from manage_".CV_DESIGNATION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_GRADE."' then (select id from manage_".CV_GRADE." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_LEVEL."' then (select id from manage_".CV_LEVEL." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_EDUCATION."' then (select id from manage_".CV_EDUCATION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_CRITICAL_TALENT."' then (select id from manage_".CV_CRITICAL_TALENT." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_CRITICAL_POSITION."' then (select id from manage_".CV_CRITICAL_POSITION." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_SPECIAL_CATEGORY."' then (select id from manage_".CV_SPECIAL_CATEGORY." where name = datum.value ORDER BY id DESC LIMIT 1)
		WHEN '".CV_CURRENCY."' then (select id from manage_".CV_CURRENCY." where name = datum.value ORDER BY id DESC LIMIT 1)
		ELSE '0'
		END AS module_pk_id");
		$this->db->from("datum");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where_in('business_attribute.module_name', $module_name_arr);
		if($cnd_arr)
		{
			$this->db->where($cnd_arr);
		}
		return  $this->db->get()->result_array();
	}

	public function get_rules_approvel_request_list($user_id, $condition_arr)
	{
		$this->db->select("hr_parameter.id as rule_id, hr_parameter.salary_rule_name, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, approvel_requests.id, approvel_requests.type, approvel_requests.createdon as request_date");
		$this->db->from("approvel_requests");
		$this->db->join("hr_parameter","hr_parameter.id = approvel_requests.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		//$this->db->where(array("approvel_requests.user_id"=>$user_id, "approvel_requests.status"=>0));
		$this->db->where(array("approvel_requests.status"=>0));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
				return $this->db->get()->result_array();
	}

	public function get_rules_release_approvel_pending_list($condition_arr)
	{
		$this->db->select("hr_parameter.id as rule_id, hr_parameter.salary_rule_name, hr_parameter.template_id, hr_parameter.status as rule_status, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select count(*) from employee_salary_details where employee_salary_details.rule_id = hr_parameter.id) as total_emp_in_rule, (select count(*) from employee_salary_details where employee_salary_details.status = 5 and employee_salary_details.rule_id = hr_parameter.id) as total_appoved_emp_in_rule");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where("(hr_parameter.status = 6 or hr_parameter.status = 7)");
		return $this->db->get()->result_array();
	}

	public function get_lti_rules_approvel_request_list($user_id, $condition_arr)
	{
		$this->db->select("lti_rules.id as rule_id, lti_rules.rule_name, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, approvel_requests.id, approvel_requests.type, approvel_requests.createdon as request_date");
		$this->db->from("approvel_requests");
		$this->db->join("lti_rules","lti_rules.id = approvel_requests.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
		$this->db->where(array("approvel_requests.user_id"=>$user_id, "approvel_requests.status"=>0));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
				return $this->db->get()->result_array();
	}

	public function get_lti_rules_release_approval_pending_list($condition_arr)
	{
		$this->db->select("lti_rules.id as rule_id, lti_rules.rule_name, lti_rules.status as rule_status, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select count(*) from employee_lti_details where employee_lti_details.rule_id = lti_rules.id) as total_emp_in_rule, (select count(*) from employee_lti_details where employee_lti_details.status = 5 and employee_lti_details.rule_id = lti_rules.id) as total_appoved_emp_in_rule");
		$this->db->from("lti_rules");
		$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where("(lti_rules.status = 6 or lti_rules.status = 7)");
		return $this->db->get()->result_array();
	}

	public function get_rnr_rules_approvel_request_list($user_id, $condition_arr)
	{
		$this->db->select("rnr_rules.id as rule_id, rnr_rules.rule_name, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, approvel_requests.id, approvel_requests.type, approvel_requests.createdon as request_date");
		$this->db->from("approvel_requests");
		$this->db->join("rnr_rules","rnr_rules.id = approvel_requests.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = rnr_rules.performance_cycle_id");
		$this->db->where(array("approvel_requests.user_id"=>$user_id, "approvel_requests.status"=>0));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	public function staffs_to_update_datum_on_salary_rule_release($condition_arr)
	{
		$this->db->select("employee_salary_details.user_id, employee_salary_details.rule_id, employee_salary_details.increment_applied_on_elem_dtls, employee_salary_details.manager_discretions, employee_salary_details.emp_new_designation,employee_salary_details.final_salary,manage_grade.id as grade_id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL."");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id");
		$this->db->join("manage_grade", "manage_grade.name = employee_salary_details.grade");
		$this->db->where(array("employee_salary_details.status"=>5));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	/*public function update_datum_dtls_on_rule_release($condition, $data)
    {
        $this->db->where($condition);
        $this->db->update('datum',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }*/

	public function get_bonus_rules_approvel_request_list($user_id, $condition_arr)
	{
		$this->db->select("hr_parameter_bonus.id as rule_id, hr_parameter_bonus.bonus_rule_name, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, approvel_requests.id, approvel_requests.type, approvel_requests.createdon as request_date");
		$this->db->from("approvel_requests");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = approvel_requests.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
		//$this->db->where(array("approvel_requests.user_id"=>$user_id, "approvel_requests.status"=>0));
		$this->db->where(array("approvel_requests.status"=>0));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
				return $this->db->get()->result_array();
	}

  public function get_sip_rules_approvel_request_list($user_id, $condition_arr)
	{
		$this->db->select("sip_hr_parameter.id as rule_id, sip_hr_parameter.sip_rule_name, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, approvel_requests.id, approvel_requests.type, approvel_requests.createdon as request_date");
		$this->db->from("approvel_requests");
		$this->db->join("sip_hr_parameter","sip_hr_parameter.id = approvel_requests.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = sip_hr_parameter.performance_cycle_id");
		//$this->db->where(array("approvel_requests.user_id"=>$user_id, "approvel_requests.status"=>0));
		$this->db->where(array("approvel_requests.status"=>0));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
				return $this->db->get()->result_array();
	}

	public function get_bonus_rules_release_approvel_pending_list($condition_arr)
	{
		$this->db->select("hr_parameter_bonus.id as rule_id, hr_parameter_bonus.bonus_rule_name, hr_parameter_bonus.status as rule_status, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select count(*) from employee_bonus_details where employee_bonus_details.rule_id = hr_parameter_bonus.id) as total_emp_in_rule, (select count(*) from employee_bonus_details where employee_bonus_details.status = 5 and employee_bonus_details.rule_id = hr_parameter_bonus.id) as total_appoved_emp_in_rule");
		$this->db->from("hr_parameter_bonus");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where("(hr_parameter_bonus.status = 6 or hr_parameter_bonus.status = 7)");
		return $this->db->get()->result_array();
	}

  public function get_sip_rules_release_approvel_pending_list($condition_arr)
	{
		$this->db->select("sip_hr_parameter.id as rule_id, sip_hr_parameter.sip_rule_name, sip_hr_parameter.status as rule_status, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select count(*) from sip_employee_details where sip_employee_details.rule_id = sip_hr_parameter.id) as total_emp_in_rule, (select count(*) from sip_employee_details where sip_employee_details.status = 5 and sip_employee_details.rule_id = sip_hr_parameter.id) as total_appoved_emp_in_rule");
		$this->db->from("sip_hr_parameter");
		$this->db->join("performance_cycle", "performance_cycle.id = sip_hr_parameter.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where("(sip_hr_parameter.status = 6 or sip_hr_parameter.status = 7)");
		return $this->db->get()->result_array();
	}

	public function staffs_to_update_datum_on_bonus_salary_rule_release($condition_arr)
	{
		$this->db->select("employee_bonus_details.user_id, employee_bonus_details.rule_id, employee_bonus_details.final_bonus, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL."");
		$this->db->from("employee_bonus_details");
		$this->db->join("login_user", "login_user.id = employee_bonus_details.user_id");
		$this->db->where(array("employee_bonus_details.status"=>5));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	public function check_approvel_request_is_valid_for_user($condition_arr)
	{
		$this->db->select("id, status, type");
		$this->db->from("approvel_requests");
		return $this->db->where($condition_arr)->get()->row_array();
	}

	public function reject_approvel_req($req_id)
	{
		$this->db->update("approvel_requests", array('status'=>2,"updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$req_id));
	}


}
