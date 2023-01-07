<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Manager_model extends CI_Model
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

    public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}

    public function list_of_manager_emps()
	{
		$manager_email = $this->session->userdata('email_ses');
		
		$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_salary_details.id as tbl_pk_id, employee_salary_details.upload_id, employee_salary_details.rule_id, hr_parameter.status as rule_staus, employee_salary_details.status as emp_salary_status, employee_salary_details.manager_emailid, employee_salary_details.status as req_status, manage_designation.name as desig, manage_function.name as function, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating");
		$this->db->from("row_owner");
		$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where("(row_owner.first_approver = '$manager_email')");
		$this->db->order_by("login_user.name asc");
		$this->db->group_by("row_owner.user_id");
		return $this->db->get()->result_array();	
	}
	
	/*public function checkManagerEmpinRule($userids)
	{
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("id");
		$this->db->from("row_owner");
		$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email') and user_id in($userids)");
		return $this->db->get()->result_array();
    }*/
	
	public function checkManagerEmpinRule($get_user_ids_qry)
	{
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("id");
		$this->db->from("login_user");
		$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_2." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_3." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_4." = '$manager_email') AND id IN($get_user_ids_qry)");
		return $this->db->get()->result_array();
    }
	
	public function list_of_manager_emps_for_increment($ruleID,$email='')
	{
		$tempArr =	array();
		if($email=='')
		{
			$manager_email = $this->session->userdata('email_ses');
		}
		else
		{
			$manager_email=$email;
		}
		
		/*$status=$this->db->query("select status from employee_salary_details where rule_id='".$ruleID."' and status > 1 and manager_emailid !='".$manager_email."'")->num_rows();
		if($status>0)
		{
			
			$con=array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.last_action_by"=>$manager_email);
		}
		else
		{
			$con=array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.manager_emailid"=>$manager_email);
			
		}
		
		$this->db->select("hr_parameter.id")->where($con)->order_by("id desc");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{*/
				$this->db->select("employee_salary_details.user_id AS id, employee_salary_details.emp_name AS name, employee_salary_details.email_id AS email, employee_salary_details.increment_applied_on_salary, employee_salary_details.final_salary, employee_salary_details.market_salary, employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, employee_salary_details.rule_id,
				employee_salary_details.esop,
				employee_salary_details.bonus_recommendation,
				employee_salary_details.pay_per,employee_salary_details.retention_bonus, employee_salary_details.joining_date_for_increment_purposes,
				employee_salary_details.joining_date_the_company,
				employee_salary_details.manager_discretions, 
				employee_salary_details.performnace_based_increment,
				employee_salary_details.crr_based_increment, 
				employee_salary_details.sp_increased_salary,
				employee_salary_details.standard_promotion_increase, 
				employee_salary_details.emp_new_designation, 
				employee_salary_details.emp_new_grade, 
				employee_salary_details.emp_new_level, 
				employee_salary_details.sp_manager_discretions,

				employee_salary_details.promotion_comment,
				employee_salary_details.salary_comment,
				employee_salary_details.promotion_comment,
				employee_salary_details.retention_bonus,
				employee_salary_details.business_level_1,
				employee_salary_details.business_level_2,
				employee_salary_details.business_level_3,
				employee_salary_details.city,
				employee_salary_details.performance_rating,
				employee_salary_details.current_target_bonus,
				employee_salary_details.performance_rating_id,
				employee_salary_details.city,
				employee_salary_details.post_quartile_range_name,
				employee_salary_details.performance_rating,
				employee_salary_details.performance_rating_id,
				employee_salary_details.current_target_bonus,
				employee_salary_details.sub_sub_function,
				employee_salary_details.function,
				employee_salary_details.education,
				employee_salary_details.critical_talent,
				employee_salary_details.critical_position,
				employee_salary_details.company_name,
				employee_salary_details.gender,
				employee_salary_details.special_category,
				employee_salary_details.recently_promoted,
				employee_salary_details.performance_achievement,
				employee_salary_details.currency,
				employee_salary_details.manager_name,
				employee_salary_details.post_quartile_range_name,
				, employee_salary_details.status as emp_salary_status,
				employee_salary_details.designation as desig,
				employee_salary_details.grade,
				employee_salary_details.level,
				employee_salary_details.last_action_by,
				employee_salary_details.status,
				employee_salary_details.country,
				employee_salary_details.sub_function as subfunction,
				employee_salary_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_salary_details.last_action_by) as last_manager_name, (SELECT login_user.employee_code FROM login_user WHERE login_user.id = employee_salary_details.user_id) as employee_code, employee_salary_details.status as req_status, employee_salary_details.approver_1 AS first_approver, employee_salary_details.approver_2 AS second_approver, employee_salary_details.approver_3 AS third_approver, employee_salary_details.approver_4 AS fourth_approver, employee_salary_details.joining_date_for_increment_purposes AS date_of_joining, employee_salary_details.crr_val AS current_crr");
			$this->db->from("employee_salary_details");
			//$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			 //$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
			// $this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		// $this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		// $this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		// $this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");	
		// 	$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		// 	$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		// 	$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		// 	$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			//$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			// $this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");	
			/*$this->db->where("(employee_salary_details.approver_1 = '$manager_email' or employee_salary_details.approver_2 = '$manager_email' or employee_salary_details.approver_3 = '$manager_email' or employee_salary_details.approver_4 = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status <"=>5));
			$this->db->where('employee_salary_details.last_action_by',$manager_email);*/
			$this->db->where("(employee_salary_details.approver_1 = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$ruleID));
			$this->db->order_by("employee_salary_details.last_action_by asc");
			$this->db->order_by("employee_salary_details.emp_name asc");
			//$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();			
		//}
		return $tempArr;	
	}
	
	public function getEmployee($ruleID,$manager_email='')
	{
			$tempArr =	array();
		
			$this->db->select("employee_salary_details.email_id AS email");
			$this->db->from("employee_salary_details");
			
			$this->db->where("(employee_salary_details.approver_1 = '$manager_email' or employee_salary_details.approver_2 = '$manager_email' or employee_salary_details.approver_3 = '$manager_email' or employee_salary_details.approver_4 = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$ruleID));
			$this->db->where('employee_salary_details.last_action_by',$manager_email);
			$this->db->order_by("employee_salary_details.last_action_by asc");
			$this->db->order_by("employee_salary_details.emp_name asc");
			//$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result();			
		
		return $tempArr;	
	}
	public function list_of_manager_emps_for_manager($ruleID,$manager_email_arr='')
	{
		$tempArr =	array();
		$manager_email1 = $this->session->userdata('email_ses');
		// print_r($manager_email_arr);
		// die;
		//$manager_email_arr = explode(',', $manager_email);
		
		loop:
		$tempArr =array();
		foreach ($manager_email_arr as $key => $value) {
			$manager_email .= "'".$value."',";
			//echo "<br/>";
			$res = $this->getEmployee($ruleID,$value);
			foreach ($res as $k => $v) {
				$tempArr[] = $v->email;
			}
			//print_r($res);
			//echo "<br/>";
		}

		// echo "temp";
		// print_r($tempArr);
		if(!empty($tempArr)){
			$manager_email_arr = $tempArr;
			goto loop;
		}
		$manager_email = rtrim($manager_email,',');
		// echo count(explode(',', $manager_email));
		// print_r($manager_email);
		// echo "end";
		// die;

		if($manager_email)
		{
			$con = "";
			$this->db->select("e.performance_rating,count(e.performance_rating) as count,sum(e.manager_discretions) as ratting_total,sum(e.increment_applied_on_salary*e.manager_discretions/100) as amount_total");
			$this->db->from("employee_salary_details as e");
			$this->db->join("login_user as l",'e.user_id=l.id');
			$this->db->join("manage_rating_for_current_year as r",'e.performance_rating=r.name');
			$this->db->where("(l.email IN (".$manager_email.") )");
			//$this->db->where("(e.approver_1 IN (".$manager_email.") or e.approver_2 IN (".$manager_email.") or e.approver_3 IN (".$manager_email.") or e.approver_4 IN (".$manager_email.") )");
			$this->db->where(array("e.rule_id"=>$ruleID));
			$this->db->order_by("r.order_no");
			$this->db->group_by("e.performance_rating");
			$tempArr = $this->db->get()->result_array();	

		}
		// echo "<pre>";
		// print_r($tempArr);
		// die;
		return $tempArr;	
	}
	
	
	public function list_of_current_manager_send_for_next_level($rule_id)
	{
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("employee_salary_details.id as tbl_pk_id, employee_salary_details.rule_id, employee_salary_details.status as req_status, employee_salary_details.approver_1 AS first_approver, employee_salary_details.approver_2 AS second_approver, employee_salary_details.approver_3 AS third_approver, employee_salary_details.approver_4 AS fourth_approver,
			employee_salary_details.manager_discretions,
			employee_salary_details.sp_manager_discretions,
			employee_salary_details.final_salary,
			employee_salary_details.increment_applied_on_salary,
			employee_salary_details.performance_rating,
			employee_salary_details.promotion_comment,
			");
		$this->db->from("employee_salary_details");	
		$this->db->where("(employee_salary_details.approver_1 = '$manager_email' or employee_salary_details.approver_2 = '$manager_email' or employee_salary_details.approver_3 = '$manager_email' or employee_salary_details.approver_4 = '$manager_email')");
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.status <"=>5));
		return $this->db->get()->result_array();
	}


	function otherManager($ruleID)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		
		$status=$this->db->query("select status from employee_salary_details where rule_id='".$ruleID."' and status > 1 and manager_emailid !='".$manager_email."'")->num_rows();
		if($status>0)
		{
			
			$con=array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.last_action_by"=>$manager_email);
		}
		else
		{
			$con=array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.manager_emailid"=>$manager_email);
			
		}
		
		$this->db->select("hr_parameter.id")->where($con)->order_by("id desc");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{
			$this->db->select("employee_salary_details.last_action_by, employee_salary_details.manager_name, (SELECT lu.name FROM login_user lu WHERE lu.email = `employee_salary_details`.`last_action_by`) AS last_action_by_name");
			$this->db->from("employee_salary_details");
			//$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			//$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		// 	$this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		// $this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		// $this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		// $this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");	
		// 	$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		// 	$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		// 	$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		// 	$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			//$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			// $this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");	
			$this->db->where("(employee_salary_details.approver_1 = '$manager_email' or employee_salary_details.approver_2 = '$manager_email' or employee_salary_details.approver_3 = '$manager_email' or employee_salary_details.approver_4 = '$manager_email')");
			$this->db->where('employee_salary_details.last_action_by !=',$manager_email);
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status <"=>5));
			$this->db->order_by("employee_salary_details.last_action_by asc");
			//$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			//$this->db->group_by("login_user.id");
			$this->db->group_by("employee_salary_details.last_action_by");
			$tempArr = $this->db->get()->result_array();			
		}
		return $tempArr;	
	}
	    
	/*public function list_of_manager_emps_for_increment_after_release($ruleID)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("hr_parameter.id")->where(array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{	
			$this->db->select("hr_parameter.template_id,hr_parameter.manual_budget_dtls,hr_parameter.overall_budget,hr_parameter.user_ids,performance_cycle.id as cycleID,login_user.id, login_user.name, login_user.email, manage_level.name as level,employee_salary_details.increment_applied_on_salary,employee_salary_details.manager_discretions,employee_salary_details.final_salary,employee_salary_details.market_salary,employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, login_user.upload_id, employee_salary_details.rule_id, hr_parameter.salary_rule_name as rule_name, hr_parameter.status as rule_staus, employee_salary_details.status as emp_salary_status, employee_salary_details.last_action_by, employee_salary_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_salary_details.last_action_by) as last_manager_name, employee_salary_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating");
			$this->db->from("row_owner");
			$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
			$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");	
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status ="=>5));
			$this->db->order_by("employee_salary_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}*/
	
	public function list_of_manager_emps_for_increment_after_release($ruleID)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("hr_parameter.id, hr_parameter.status")->where(array("hr_parameter.id"=>$ruleID, "hr_parameter.status >="=>6, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED, "employee_salary_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{	
			// $this->db->select("hr_parameter.template_id, hr_parameter.manual_budget_dtls, hr_parameter.overall_budget, performance_cycle.id as cycleID, login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name as level,employee_salary_details.increment_applied_on_salary,employee_salary_details.manager_discretions,employee_salary_details.final_salary,employee_salary_details.market_salary,employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, login_user.upload_id, employee_salary_details.rule_id, hr_parameter.salary_rule_name as rule_name, hr_parameter.status as rule_staus, employee_salary_details.status as emp_salary_status, employee_salary_details.last_action_by, employee_salary_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_salary_details.last_action_by) as last_manager_name, employee_salary_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, employee_salary_details.crr_val AS current_crr");
			// $this->db->from("employee_salary_details");

							$this->db->select("employee_salary_details.user_id AS id, employee_salary_details.emp_name AS name, employee_salary_details.email_id AS email, employee_salary_details.increment_applied_on_salary, employee_salary_details.final_salary, employee_salary_details.market_salary, employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, employee_salary_details.rule_id,
				employee_salary_details.esop,
				employee_salary_details.bonus_recommendation,
				employee_salary_details.pay_per,employee_salary_details.retention_bonus, employee_salary_details.joining_date_for_increment_purposes,
				employee_salary_details.joining_date_the_company,
				employee_salary_details.manager_discretions, 
				employee_salary_details.performnace_based_increment,
				employee_salary_details.crr_based_increment, 
				employee_salary_details.sp_increased_salary,
				employee_salary_details.standard_promotion_increase, 
				employee_salary_details.emp_new_designation, 
				employee_salary_details.emp_new_grade, 
				employee_salary_details.emp_new_level, 
				employee_salary_details.sp_manager_discretions,

				employee_salary_details.promotion_comment,
				employee_salary_details.salary_comment,
				employee_salary_details.promotion_comment,
				employee_salary_details.retention_bonus,
				employee_salary_details.business_level_1,
				employee_salary_details.business_level_2,
				employee_salary_details.business_level_3,
				employee_salary_details.city,
				employee_salary_details.performance_rating,
				employee_salary_details.current_target_bonus,
				employee_salary_details.performance_rating_id,
				employee_salary_details.city,
				employee_salary_details.post_quartile_range_name,
				employee_salary_details.performance_rating,
				employee_salary_details.performance_rating_id,
				employee_salary_details.current_target_bonus,
				employee_salary_details.sub_sub_function,
				employee_salary_details.function,
				employee_salary_details.education,
				employee_salary_details.critical_talent,
				employee_salary_details.critical_position,
				employee_salary_details.company_name,
				employee_salary_details.gender,
				employee_salary_details.special_category,
				employee_salary_details.recently_promoted,
				employee_salary_details.performance_achievement,
				employee_salary_details.currency,
				employee_salary_details.manager_name,
				employee_salary_details.post_quartile_range_name,
				, employee_salary_details.status as emp_salary_status,
				employee_salary_details.designation as desig,
				employee_salary_details.grade,
				employee_salary_details.level,
				employee_salary_details.last_action_by,
				employee_salary_details.status,
				employee_salary_details.country,
				employee_salary_details.sub_function as subfunction,
				employee_salary_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_salary_details.last_action_by) as last_manager_name, (SELECT login_user.employee_code FROM login_user WHERE login_user.id = employee_salary_details.user_id) as employee_code, employee_salary_details.status as req_status, employee_salary_details.approver_1 AS first_approver, employee_salary_details.approver_2 AS second_approver, employee_salary_details.approver_3 AS third_approver, employee_salary_details.approver_4 AS fourth_approver, employee_salary_details.joining_date_for_increment_purposes AS date_of_joining, employee_salary_details.crr_val AS current_crr");
			$this->db->from("employee_salary_details");
			//$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
			//$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
			//$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
			//$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
			//$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			//$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			//$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");	
			//$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");
			if($rule_dtls["status"] == CV_STATUS_RULE_RELEASED)
			{
				$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status ="=>5));
			}
			else
			{
				$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"]));
			}
			$this->db->order_by("employee_salary_details.last_action_by asc");
			$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}

	/*public function get_employee_salary_dtls_for_manager_discretions($condition_arr)
	{	
		$this->db->select("employee_salary_details.*, hr_parameter.Manager_discretionary_increase, hr_parameter.Manager_discretionary_decrease, hr_parameter.overall_budget, hr_parameter.budget_amount, hr_parameter.budget_percent, hr_parameter.manual_budget_dtls, hr_parameter.user_ids, row_owner.first_approver, hr_parameter.sp_manager_discretionary_increase, hr_parameter.sp_manager_discretionary_decrease, (select recently_promoted from login_user where login_user.id = employee_salary_details.user_id) as recently_promoted, (select upload_id from login_user where login_user.id = employee_salary_details.user_id) as upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$this->db->join("row_owner","row_owner.user_id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}*/  
	
	public function get_employee_salary_dtls_for_manager_discretions($condition_arr)
	{	
		$salary_elem_ba_list = $this->db->select("ba_name")->from("business_attribute")->where("(business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')")->get()->result_array();
		
		$mkt_elem_select_arr = array();
		foreach($salary_elem_ba_list as $ba_row)
		{
			$mkt_elem_select_arr[] = "login_user.".$ba_row['ba_name'];
		}
		$mkt_elem_select_arr = implode(",", $mkt_elem_select_arr);
		
		
		
		
		$this->db->select("employee_salary_details.*, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.recently_promoted, login_user.upload_id, (SELECT rate FROM currency_rates WHERE currency_rates.to_currency = hr_parameter.to_currency_id AND currency_rates.from_currency = (SELECT id FROM manage_currency WHERE manage_currency.name = employee_salary_details.currency)) AS currency_rate, hr_parameter.Manager_discretionary_increase, hr_parameter.Manager_discretionary_decrease, hr_parameter.overall_budget, hr_parameter.manual_budget_dtls, hr_parameter.include_promotion_budget, hr_parameter.salary_position_based_on, hr_parameter.bring_emp_to_min_sal, hr_parameter.comparative_ratio_range, hr_parameter.manager_can_change_rating, hr_parameter.manager_can_exceed_budget, hr_parameter.budget_accumulation, hr_parameter.to_currency_id, login_user.".CV_BA_NAME_COUNTRY.", login_user.".CV_BA_NAME_CITY.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_1.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_2.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_3.", login_user.".CV_BA_NAME_FUNCTION.", login_user.".CV_BA_NAME_SUBFUNCTION.", login_user.".CV_BA_NAME_SUB_SUBFUNCTION.", login_user.".CV_BA_NAME_DESIGNATION.", login_user.".CV_BA_NAME_GRADE.", login_user.".CV_BA_NAME_LEVEL.", login_user.".CV_BA_NAME_EDUCATION.", login_user.".CV_BA_NAME_JOB_CODE.", login_user.".CV_BA_NAME_JOB_NAME.", login_user.".CV_BA_NAME_JOB_LEVEL.", login_user.".CV_BA_NAME_URBAN_RURAL_CLASSIFICATION.", hr_parameter.promotion_basis_on, hr_parameter.multiplier_wise_per_dtls, hr_parameter.hike_multiplier_basis_on, hr_parameter.performnace_based_hike, hr_parameter.comparative_ratio, hr_parameter.comparative_ratio_calculations, hr_parameter.status AS rule_status, hr_parameter.crr_percent_values,".$mkt_elem_select_arr);
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}

	/*public function get_managers_employees_total_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
	{
		$this->db->select("user_id");
		$this->db->from("row_owner");
		$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$manager_email));
		$this->db->where("user_id in (".$rule_user_ids.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

			//$this->db->select_sum("final_salary");
			$this->db->select("sum(final_salary - increment_applied_on_salary) as increased_salary");
			$this->db->from("employee_salary_details");		
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_salary_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}*/
	
	public function get_managers_employees_total_budget($rule_id, $manager_email)
	{
		$this->db->select("id AS user_id");
		$this->db->from("login_user");
		$this->db->where(array(CV_BA_NAME_APPROVER_1=>$manager_email));
		$this->db->where("id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);
			$this->db->select("SUM(final_salary - increment_applied_on_salary) AS increased_salary");
			$this->db->from("employee_salary_details");		
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_salary_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}

	public function update_tbl_data($table, $data, $where_condition)
	{	
		$this->db->where($where_condition);
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	} 
	 public function get_table_row($table, $fields, $condition_arr, $order_by = "id") {
        $this->db->select($fields);
        $this->db->from($table);
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->order_by($order_by);
        return $this->db->get()->row_array();
    }
	/*public function emp_list_for_midterm_rule()
	{
		$manager_email = $this->session->userdata('email_ses');
		
		$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, manage_designation.name as desig, manage_function.name as function, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating");
		$this->db->from("row_owner");			
		$this->db->join("login_user","login_user.id = row_owner.user_id");	
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where("(row_owner.first_approver = '$manager_email')");
		$this->db->order_by("login_user.name asc");
		$this->db->group_by("row_owner.user_id");
		return $this->db->get()->result_array();	
	}*/
	
	public function emp_list_for_midterm_rule()
	{
		$manager_email = $this->session->userdata('email_ses');
		
		$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name as level, manage_designation.name as desig, manage_function.name as function, manage_grade.name as grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name as business_unit_3, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating");
		$this->db->from("login_user");	
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
		$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");
		$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
		$this->db->group_by("login_user.id");
		return $this->db->get()->result_array();	
	}
	
	public function get_designations_autocomplete($term)
    {
        $query = $this->db->query("SELECT name as value FROM manage_designation WHERE status = 1 and name LIKE '%".$term."%' ");
        echo json_encode($query->result_array());
    }
	
	public function get_role_autocomplete($term)
    {
        $query = $this->db->query("SELECT name as value FROM roles WHERE name LIKE '%".$term."%' ");
        echo json_encode($query->result_array());
    }
	
	public function get_grade_autocomplete($term)
    {
       $query = $this->db->query("SELECT name as value FROM manage_grade WHERE status = 1 and name LIKE '%".$term."%' ");
        echo json_encode($query->result_array());
    }
	
	
	
// Functionas for Bonus Increments *******************************

	/*public function list_of_manager_emps_for_bonus_increment($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("hr_parameter_bonus.id")->where(array("hr_parameter_bonus.id"=>$rule_id,"hr_parameter_bonus.status >="=>6, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_bonus_details","row_owner.user_id = employee_bonus_details.user_id");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_bonus_details.id as tbl_pk_id, login_user.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.user_ids, hr_parameter_bonus.bonus_rule_name as rule_name, hr_parameter_bonus.status as rule_staus, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid,employee_bonus_details.actual_bonus_per, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name, employee_bonus_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
			$this->db->from("row_owner");
			$this->db->join("employee_bonus_details","row_owner.user_id = employee_bonus_details.user_id");
			$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_bonus_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where(array("employee_bonus_details.rule_id"=>$rule_dtls["id"], "employee_bonus_details.status <"=>5));
			$this->db->order_by("employee_bonus_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}*/
	
	public function list_of_manager_emps_for_bonus_increment($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');		
		$this->db->select("hr_parameter_bonus.id")->where(array("hr_parameter_bonus.id"=>$rule_id,"hr_parameter_bonus.status >="=>6, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED, "employee_bonus_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("employee_bonus_details");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{
			$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name AS level, employee_bonus_details.id as tbl_pk_id, login_user.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.bonus_rule_name as rule_name, hr_parameter_bonus.status AS rule_staus, employee_bonus_details.status AS emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid,employee_bonus_details.actual_bonus_per, (select login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_bonus_details.last_action_by) AS last_manager_name, employee_bonus_details.status AS req_status, manage_designation.name AS desig, manage_grade.name AS grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name AS business_unit_3, performance_cycle.name AS performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, employee_bonus_details.performance_achievement, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type");
			$this->db->from("employee_bonus_details");
			$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_bonus_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
			$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
			$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_2." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_3." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_4." = '$manager_email')");
			$this->db->where(array("employee_bonus_details.rule_id"=>$rule_dtls["id"], "employee_bonus_details.status <"=>5));
			$this->db->order_by("employee_bonus_details.last_action_by asc");
			$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}
	
	/*public function list_of_manager_emps_for_bonus_increment_after_released($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("hr_parameter_bonus.id")->where(array("hr_parameter_bonus.id"=>$rule_id,"hr_parameter_bonus.status >="=>6, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_bonus_details","row_owner.user_id = employee_bonus_details.user_id");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_bonus_details.id as tbl_pk_id, login_user.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.bonus_rule_name as rule_name, hr_parameter_bonus.status as rule_staus, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name, employee_bonus_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per,employee_bonus_details.actual_bonus_per, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
			$this->db->from("row_owner");
			$this->db->join("employee_bonus_details","row_owner.user_id = employee_bonus_details.user_id");
			$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_bonus_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where(array("employee_bonus_details.rule_id"=>$rule_dtls["id"], "employee_bonus_details.status ="=>5));
			$this->db->order_by("employee_bonus_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}*/
	
	public function list_of_manager_emps_for_bonus_increment_after_released($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("hr_parameter_bonus.id, hr_parameter_bonus.status")->where(array("hr_parameter_bonus.id"=>$rule_id,"hr_parameter_bonus.status >="=>6, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED, "employee_bonus_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("employee_bonus_details");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{
			$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name AS level, employee_bonus_details.id AS tbl_pk_id, login_user.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.bonus_rule_name AS rule_name, hr_parameter_bonus.status AS rule_staus, employee_bonus_details.status AS emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_bonus_details.last_action_by) as last_manager_name, employee_bonus_details.status AS req_status, manage_designation.name AS desig, manage_grade.name AS grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name AS business_unit_3, performance_cycle.name AS performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per,employee_bonus_details.actual_bonus_per, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, employee_bonus_details.performance_achievement, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type");
			$this->db->from("employee_bonus_details");
			$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_bonus_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
			$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
			//$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");
			if($rule_dtls["status"]==CV_STATUS_RULE_RELEASED)
			{
				$this->db->where(array("employee_bonus_details.rule_id"=>$rule_dtls["id"], "employee_bonus_details.status ="=>5));
			}
			else
			{
				$this->db->where(array("employee_bonus_details.rule_id"=>$rule_dtls["id"]));
			}
			$this->db->order_by("employee_bonus_details.last_action_by asc");
			$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}
	
	/*public function get_employee_bonus_dtls_for_manager_discretions($condition_arr)
	{
		$this->db->select("employee_bonus_details.*, hr_parameter_bonus.manager_discretionary_increase, hr_parameter_bonus.manager_discretionary_decrease, hr_parameter_bonus.overall_budget, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.user_ids, row_owner.first_approver, (select upload_id from login_user where login_user.id = employee_bonus_details.user_id) as upload_id");
		$this->db->from("employee_bonus_details");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$this->db->join("row_owner","row_owner.user_id = employee_bonus_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}*/
	
	public function get_employee_bonus_dtls_for_manager_discretions($condition_arr)
	{
		$this->db->select("employee_bonus_details.*, hr_parameter_bonus.manager_discretionary_increase, hr_parameter_bonus.manager_discretionary_decrease, hr_parameter_bonus.overall_budget, hr_parameter_bonus.manual_budget_dtls, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.upload_id");
		$this->db->from("employee_bonus_details");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$this->db->join("login_user","login_user.id = employee_bonus_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
	
	/*public function get_managers_employees_total_bonus_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
	{
		$this->db->select("user_id");
		$this->db->from("row_owner");
		$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$manager_email));
		$this->db->where("user_id in (".$rule_user_ids.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

			$this->db->select_sum("final_bonus");
			$this->db->from("employee_bonus_details");		
			$this->db->where(array("employee_bonus_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_bonus_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}*/
	
	public function get_managers_employees_total_bonus_budget($rule_id, $manager_email)
	{
		$this->db->select("id AS user_id");
		$this->db->from("login_user");
		$this->db->where(array(CV_BA_NAME_APPROVER_1=>$manager_email));
		$this->db->where("id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

			$this->db->select_sum("final_bonus");
			$this->db->from("employee_bonus_details");		
			$this->db->where(array("employee_bonus_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_bonus_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}
	
	/*public function list_of_manager_emps_for_rnr()
	{
		$manager_email = $this->session->userdata('email_ses');
		
		$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, manage_designation.name as desig, manage_function.name as function, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating");
		$this->db->from("row_owner");	
		$this->db->join("login_user","login_user.id = row_owner.user_id");	
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where(array("login_user.status <"=>2));
		$this->db->where("(row_owner.first_approver = '$manager_email')");
		$this->db->order_by("login_user.name asc");
		$this->db->group_by("row_owner.user_id");
		return $this->db->get()->result_array();	
	}*/
	
	public function list_of_manager_emps_for_rnr()
	{
		$manager_email = $this->session->userdata('email_ses');		
		$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name AS level, manage_designation.name AS desig, manage_function.name AS function, manage_grade.name AS grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name AS business_unit_3, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating");
		$this->db->from("login_user");
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
		$this->db->where(array("login_user.status <"=>2));
		$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");
		$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
		$this->db->group_by("login_user.id");
		return $this->db->get()->result_array();	
	}
	
	public function get_emp_rnr_history($condition_arr)
	{		
		$this->db->select("rule_name, award_type, award_value, login_user.".CV_BA_NAME_EMP_FULL_NAME." as recommended_by, proposed_rnr_dtls.updatedon as reward_date");
		$this->db->from("proposed_rnr_dtls");
		$this->db->join("login_user","login_user.id = proposed_rnr_dtls.createdby");
		$this->db->join("rnr_rules","rnr_rules.id = proposed_rnr_dtls.rule_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();	
	}
	
	/*public function list_of_manager_emps_for_lti_incentives($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("lti_rules.id")->where(array("lti_rules.id"=>$rule_id,"lti_rules.status >="=>6,"lti_rules.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_lti_details.id as tbl_pk_id, login_user.upload_id, employee_lti_details.status as emp_incentive_status, employee_lti_details.status as req_status, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.budget_dtls, lti_rules.user_ids, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name as rule_name, lti_rules.status as rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, manage_function.name as function, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
			$this->db->from("row_owner");
			$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
			$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_lti_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			//$this->db->where("(row_owner.first_approver = '$manager_email')");//Show only 1st approver employees
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status <"=>5));
			$this->db->order_by("employee_lti_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}*/
	
	public function list_of_manager_emps_for_lti_incentives($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("lti_rules.id")->where(array("lti_rules.id"=>$rule_id,"lti_rules.status >="=>6,"lti_rules.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("employee_lti_details");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name AS level, employee_lti_details.id AS tbl_pk_id, login_user.upload_id, employee_lti_details.status AS emp_incentive_status, employee_lti_details.status AS req_status, employee_lti_details.actual_incentive, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.budget_dtls, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name AS rule_name, lti_rules.status AS rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name AS desig, manage_grade.name AS grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name AS business_unit_3, manage_function.name AS function, performance_cycle.name AS performance_cycle_name, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_lti_details.last_action_by) AS last_manager_name");
			$this->db->from("employee_lti_details");
			$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_lti_details.user_id");
			$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
			$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
			$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
			$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_2." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_3." = '$manager_email' OR login_user.".CV_BA_NAME_APPROVER_4." = '$manager_email')");
			//$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");//Show only 1st approver employees
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status <"=>5));
			$this->db->order_by("employee_lti_details.last_action_by asc");
			$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}
	    
	/*public function list_of_manager_emps_for_lti_incentives_after_released($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("lti_rules.id")->where(array("lti_rules.id"=>$rule_id,"lti_rules.status >="=>6,"lti_rules.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{	
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_lti_details.id as tbl_pk_id, login_user.upload_id, employee_lti_details.status as emp_incentive_status, employee_lti_details.status as req_status, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.budget_dtls, lti_rules.user_ids, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name as rule_name, lti_rules.status as rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, manage_function.name as function, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
			$this->db->from("row_owner");
			$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
			$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_lti_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
			//$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where("(row_owner.first_approver = '$manager_email')");//Show only 1st approver employees
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status "=>5));
			$this->db->order_by("employee_lti_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}*/

	public function list_of_manager_emps_for_lti_incentives_after_released($rule_id)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		$this->db->select("lti_rules.id, lti_rules.status")->where(array("lti_rules.id"=>$rule_id,"lti_rules.status >="=>6,"lti_rules.status !="=>CV_STATUS_RULE_DELETED))->order_by("id desc");
		$this->db->from("employee_lti_details");		
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{	
			$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", manage_level.name AS level, employee_lti_details.id AS tbl_pk_id, login_user.upload_id, employee_lti_details.status AS emp_incentive_status, employee_lti_details.status AS req_status, employee_lti_details.actual_incentive, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.budget_dtls, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name AS rule_name, lti_rules.status AS rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name AS desig, manage_grade.name AS grade, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver, login_user.".CV_BA_NAME_APPROVER_2." AS second_approver, login_user.".CV_BA_NAME_APPROVER_3." AS third_approver, login_user.".CV_BA_NAME_APPROVER_4." AS fourth_approver, manage_business_level_3.name AS business_unit_3, manage_function.name AS function, performance_cycle.name AS performance_cycle_name, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_lti_details.last_action_by) AS last_manager_name");
			$this->db->from("employee_lti_details");
			$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_lti_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
			$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
			$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
			$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
			$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
			$this->db->where("(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email')");//Show only 1st approver employees
			if($rule_dtls["status"]==CV_STATUS_RULE_RELEASED)
			{
				$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status "=>5));
			}
			else
			{
				$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"]));
			}
			$this->db->order_by("employee_lti_details.last_action_by asc");
			$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
			$this->db->group_by("login_user.id");
			$tempArr = $this->db->get()->result_array();
		}
		return $tempArr;	
	}
	
	/*public function get_employee_lti_dtls_for_manager_discretions($condition_arr)
	{	
		$this->db->select("employee_lti_details.*, lti_rules.manager_discretionary_increase, lti_rules.manager_discretionary_decrease, lti_rules.budget_type, lti_rules.budget_dtls, lti_rules.user_ids, row_owner.first_approver");
		$this->db->from("employee_lti_details");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$this->db->join("row_owner","row_owner.user_id = employee_lti_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}*/
	
	public function get_employee_lti_dtls_for_manager_discretions($condition_arr)
	{	
		$this->db->select("employee_lti_details.*, lti_rules.manager_discretionary_increase, lti_rules.manager_discretionary_decrease, lti_rules.budget_type, lti_rules.budget_dtls, login_user.".CV_BA_NAME_APPROVER_1." AS first_approver");
		$this->db->from("employee_lti_details");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$this->db->join("login_user","login_user.id = employee_lti_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
	
	/*public function get_managers_employees_total_lti_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
	{
		$this->db->select("user_id");
		$this->db->from("row_owner");
		$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$manager_email));
		$this->db->where("user_id in (".$rule_user_ids.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

			$this->db->select_sum("final_incentive");
			$this->db->from("employee_lti_details");		
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_lti_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}*/
	
	public function get_managers_employees_total_lti_budget($rule_id, $manager_email)
	{
		$this->db->select("id AS user_id");
		$this->db->from("login_user");
		$this->db->where(array(CV_BA_NAME_APPROVER_1=>$manager_email));
		$this->db->where("id IN (SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$rule_id.")" );
		$team_user_arr = $this->db->get()->result_array();
		
		if($team_user_arr)
		{
			$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);
			$this->db->select_sum("final_incentive");
			$this->db->from("employee_lti_details");		
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_id));
			$this->db->where_in("employee_lti_details.user_id",$team_user_ids);
			return $this->db->get()->row_array();
		}
	}
	
	//*Start :: CB::Ravi on 27-05-09 To upload bulk Increments By the Managers *********************
	public function get_managers_direct_emps_list($condition_arr, $select_fields="")
	{
		if($select_fields != "")
		{
			$this->db->select($select_fields);
		}
		else
		{
			//$this->db->select("employee_salary_details.user_id, employee_salary_details.email_id, employee_salary_details.increment_applied_on_salary, employee_salary_details.manager_discretions, employee_salary_details.status as emp_salary_status, employee_salary_details.performance_rating, employee_salary_details.sp_increased_salary, employee_salary_details.sp_manager_discretions, employee_salary_details.emp_new_designation, employee_salary_details.designation, employee_salary_details.grade, employee_salary_details.level");
			$this->db->select("employee_salary_details.*, employee_salary_details.status AS emp_salary_status, (SELECT login_user.employee_code FROM login_user WHERE login_user.id = employee_salary_details.user_id) AS employee_code");
		}
		$this->db->from("employee_salary_details");
		//$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("employee_salary_details.emp_name asc");
		$data = $this->db->get()->result_array();
		return $data;	
	}
		
	public function bulk_upload_managers_direct_emps_increments($rule_dtls, $fields, $file_path, $req_by)
	{
		//Note :: $req_by (1=Called this function By Manager, 2=Called this function By HR)
		$rule_id = $rule_dtls["id"];
		
		$promotion_col_name = CV_BA_NAME_GRADE;
		$other_then_promotion_col_arr = array("designation", "level");
		if($rule_dtls['promotion_basis_on']==1)
		{
			$promotion_col_name = CV_BA_NAME_DESIGNATION;
			$other_then_promotion_col_arr = array("grade", "level");
		}
		elseif($rule_dtls['promotion_basis_on']==3)
		{
			$promotion_col_name = CV_BA_NAME_LEVEL;
			$other_then_promotion_col_arr = array("designation", "grade");
		}
		
		if($req_by == 1)
		{
			$other_then_promotion_col_arr = array();
		}
		
        $enclosed_by = '"';
        $this->db->query("TRUNCATE TABLE tbl_temp_bulk_upload_emp_increments;");
        //Insert data into temp table
        $this->db->query("LOAD DATA LOCAL INFILE '" . $file_path . "' INTO TABLE tbl_temp_bulk_upload_emp_increments FIELDS TERMINATED BY ',' ENCLOSED BY '" . $enclosed_by . "' LINES TERMINATED BY '\n' IGNORE 1 LINES (" . $fields . ")");
        // echo $this->db->last_query();
        // exit;
		if($req_by == 2)
		{
			$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = 'Email id is not valid.' WHERE ttbu.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM employee_salary_details esd WHERE esd.rule_id = '".$rule_id."' AND esd.email_id = ttbu.email_id)");
		}
		else
		{
			$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = 'Email id is not valid.' WHERE ttbu.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM employee_salary_details esd WHERE esd.rule_id = '".$rule_id."' AND esd.status < 5 AND esd.email_id = ttbu.email_id AND esd.manager_emailid = '".$this->session->userdata('email_ses')."')");
		}
		
		$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = 'Performance Rating is not valid.' WHERE ttbu.is_error = 0 AND ttbu.performance_rating != '' AND NOT EXISTS (SELECT 1 FROM manage_rating_for_current_year mr WHERE mr.name = ttbu.performance_rating)");
		
		//$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = 'Increment %age is not valid.' WHERE ttbu.is_error = 0 AND (ttbu.merit_hike < 0 OR ttbu.market_hike < 0 OR ttbu.total_hike < 0)");		
		
		if($rule_dtls['promotion_basis_on'] > 0)
		{
			$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = 'Promotion Recommendation is not valid.' WHERE ttbu.is_error = 0 AND ttbu.promotion_recommendation NOT IN('','Yes','No')");
			
			if($req_by == 2 or ($req_by == 1 and $rule_dtls['promotion_can_edit']==1))
			{			
				$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = '".$promotion_col_name." is not valid.' WHERE ttbu.is_error = 0 AND ttbu.emp_new_".$promotion_col_name." != '' AND NOT EXISTS (SELECT 1 FROM manage_".$promotion_col_name." md WHERE md.name = ttbu.emp_new_".$promotion_col_name.")");
			}
			
			if($other_then_promotion_col_arr)
			{
				$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = '".$other_then_promotion_col_arr[0]." is not valid.' WHERE ttbu.is_error = 0 AND ttbu.emp_new_".$other_then_promotion_col_arr[0]." != '' AND NOT EXISTS (SELECT 1 FROM manage_".$other_then_promotion_col_arr[0]." md WHERE md.name = ttbu.emp_new_".$other_then_promotion_col_arr[0].")");
				$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.is_error= 1, ttbu.error_msg = '".$other_then_promotion_col_arr[1]." is not valid.' WHERE ttbu.is_error = 0 AND ttbu.emp_new_".$other_then_promotion_col_arr[1]." != '' AND NOT EXISTS (SELECT 1 FROM manage_".$other_then_promotion_col_arr[1]." md WHERE md.name = ttbu.emp_new_".$other_then_promotion_col_arr[1].")");
			}
		}
				
		//$this->db->query("UPDATE tbl_temp_bulk_upload_emp_increments ttbu SET ttbu.email_id = (SELECT esd.user_id FROM employee_salary_details esd WHERE esd.rule_id = '".$rule_id."' AND esd.email_id = ttbu.email_id limit 1) WHERE ttbu.is_error = 0;");
		
		$salary_elem_ba_list = $this->db->select("ba_name")->from("business_attribute")->where("(business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')")->get()->result_array();
		$mkt_elem_select_arr = array();
		foreach($salary_elem_ba_list as $ba_row)
		{
			$mkt_elem_select_arr[] = "login_user.".$ba_row['ba_name'];
		}
		$mkt_elem_select_arr = implode(",", $mkt_elem_select_arr);
				
		$this->db->select("ttbu.id AS ttbu_pk_id, ttbu.email_id AS emp_email_id, ttbu.performance_rating, ttbu.merit_hike, ttbu.market_hike, ttbu.total_hike, ttbu.promotion_recommendation, ttbu.promotion_percentage, ttbu.emp_new_designation, ttbu.emp_new_grade, ttbu.emp_new_level, ttbu.esop_val, ttbu.pay_per_val, ttbu.retention_bonus_val,		
		esd.id, esd.user_id, esd.increment_applied_on_salary, esd.proreta_multiplier, esd.final_salary, esd.performance_rating_id AS old_performance_rating_id, esd.promotion_comment, esd.esop AS emp_esop, esd.pay_per AS emp_pay_per, esd.retention_bonus AS emp_retention_bonus, esd.status, esd.standard_promotion_increase AS emp_default_standard_promotion, (SELECT manage_rating_for_current_year.id FROM manage_rating_for_current_year WHERE manage_rating_for_current_year.name = ttbu.performance_rating) AS new_performance_rating_id,		
		esd.market_salary, esd.mkt_salary_after_promotion, esd.crr_after_promotion, esd.quartile_range_name_after_promotion, esd.market_salary_column, esd.final_merit_hike, esd.final_market_hike, esd.manager_discretions, esd.sp_manager_discretions, esd.sp_increased_salary,		
		login_user.".CV_BA_NAME_COUNTRY.", login_user.".CV_BA_NAME_CITY.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_1.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_2.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_3.", login_user.".CV_BA_NAME_FUNCTION.", login_user.".CV_BA_NAME_SUBFUNCTION.", login_user.".CV_BA_NAME_SUB_SUBFUNCTION.", login_user.".CV_BA_NAME_DESIGNATION.", login_user.".CV_BA_NAME_GRADE.", login_user.".CV_BA_NAME_LEVEL.", login_user.".CV_BA_NAME_EDUCATION.", login_user.".CV_BA_NAME_JOB_CODE.", login_user.".CV_BA_NAME_JOB_NAME.", login_user.".CV_BA_NAME_JOB_LEVEL.", login_user.".CV_BA_NAME_URBAN_RURAL_CLASSIFICATION.",".$mkt_elem_select_arr);
		$this->db->from("tbl_temp_bulk_upload_emp_increments ttbu");
		$this->db->join("employee_salary_details esd","esd.email_id = ttbu.email_id");
		$this->db->join("login_user","login_user.email = ttbu.email_id");
		$this->db->where("ttbu.is_error = 0 AND esd.rule_id = ".$rule_id);
		return $this->db->get()->result_array();
    }	
	//*End :: CB::Ravi on 27-05-09 To upload bulk Increments By the Managers *********************

	/* select all rows from table*/
	public function get_table_rows($table, $fields, $condition_arr, $or_condition_arr, $order_by = "id") {

        $this->db->select($fields);
		$this->db->from($table);

        if ($condition_arr) {
            $this->db->where($condition_arr);
		}

		if ($or_condition_arr) {
            $this->db->or_where($or_condition_arr);
		}

		$this->db->order_by($order_by);

		return $this->db->get()->result_array();
    }
	
		    
}