<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Manager_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }
    
    public function setdb($dbname)
    {
       $this->db->query("use ".$dbname); 
    }
    public function list_of_manager_emps_for_increment($ruleID,$email)
	{
		$tempArr =	array();
		$manager_email = $email;
		//$this->db->select("hr_parameter.id")->where(array("row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter.status >="=>6, "employee_salary_details.status"=>1))->order_by("id desc");
		$this->db->select("hr_parameter.id")->where(array("hr_parameter.id"=>$ruleID,"row_owner.first_approver" => $email, "hr_parameter.status >="=>6, "employee_salary_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			//CB::Ravi on 15-02-2018
			//$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_salary_details.id as tbl_pk_id, employee_salary_details.upload_id, employee_salary_details.rule_id, hr_parameter.salary_rule_name as rule_name, hr_parameter.status as rule_staus, employee_salary_details.status as emp_salary_status, employee_salary_details.last_action_by, employee_salary_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_salary_details.last_action_by) as last_manager_name, employee_salary_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating");
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level,employee_salary_details.manager_discretions,employee_salary_details.increment_applied_on_salary,employee_salary_details.final_salary,employee_salary_details.market_salary,employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, login_user.upload_id, employee_salary_details.rule_id,
employee_salary_details.esop,
				employee_salary_details.bonus_recommendation,
				employee_salary_details.pay_per,
employee_salary_details.pay_per,
				employee_salary_details.joining_date_for_increment_purposes,
				employee_salary_details.manager_discretions, 
				employee_salary_details.performnace_based_increment,
				employee_salary_details.crr_based_increment, 
				employee_salary_details.sp_increased_salary,
				employee_salary_details.standard_promotion_increase, 
				employee_salary_details.emp_new_designation, 
				employee_salary_details.sp_manager_discretions,
				employee_salary_details.salary_comment,
				employee_salary_details.promotion_comment,

			 hr_parameter.salary_rule_name as rule_name, hr_parameter.status as rule_staus,
			 hr_parameter.esop_title, 
				hr_parameter.esop_type
				, hr_parameter.esop_right ,
				hr_parameter.pay_per_title, 
				hr_parameter.pay_per_type
				, hr_parameter.pay_per_right ,
				hr_parameter.retention_bonus_title, 
				hr_parameter.retention_bonus_type
				, hr_parameter.retention_bonus_right ,
				 employee_salary_details.status as emp_salary_status, employee_salary_details.last_action_by, employee_salary_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_salary_details.last_action_by) as last_manager_name, employee_salary_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating,(select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
			$this->db->from("row_owner");
			$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
			$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
			//$this->db->where(array("row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status"=>1));	
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status <"=>5));
			$this->db->order_by("employee_salary_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
			
			/*if($data)
			{
				foreach($data as $row)
				{
					$row["date_of_joining"] = "";
					$row["performance_rating"] = "";

					$this->db->select("value");
					$this->db->join("datum","datum.row_num = tuple.row_num");
					$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
					$dt = $this->db->get("tuple")->row_array();
					if($dt)
					{
						$row["date_of_joining"] = $dt["value"];
					}

					$this->db->select("value");
					$this->db->join("datum","datum.row_num = tuple.row_num");
					$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
					$dt = $this->db->get("tuple")->row_array();
					if($dt)
					{
						$row["performance_rating"] = $dt["value"];
					}

					$tempArr[] = $row;
				}
			}*/
		}
		return $tempArr;	
	}
        public function checkManagerEmpinRule($userids, $email)
        {
                $manager_email = $email;
		$this->db->select("id");
		$this->db->from("row_owner");
		$this->db->where("(row_owner.first_approver = '$manager_email') and user_id in($userids)");
		return $this->db->get()->result_array();
        }
        public function get_managers_employees_total_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
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
	}
        public function update_tbl_data($table, $data, $where_condition)
	{	
		$this->db->where($where_condition);
		$this->db->update($table, $data);
	}
        public function get_employee_salary_dtls_for_manager_discretions($condition_arr)
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
	}  
         public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}
        public function list_of_manager_emps_for_bonus_increment($rule_id,$email)
	{
		$tempArr =	array();
		$manager_email = $email;
		//$this->db->select("hr_parameter_bonus.id")->where(array("row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter_bonus.status >="=>6, "employee_bonus_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->select("hr_parameter_bonus.id")->where(array("hr_parameter_bonus.id"=>$rule_id,"hr_parameter_bonus.status >="=>6))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_bonus_details","row_owner.user_id = employee_bonus_details.user_id");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			//CB::Ravi on 15-02-2018
			//$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_bonus_details.id as tbl_pk_id, employee_bonus_details.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.bonus_rule_name as rule_name, hr_parameter_bonus.status as rule_staus, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name, employee_bonus_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_bonus_details.id as tbl_pk_id, login_user.upload_id, employee_bonus_details.rule_id, hr_parameter_bonus.bonus_rule_name as rule_name, hr_parameter_bonus.status as rule_staus, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name, employee_bonus_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
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
	}
        public function list_of_manager_emps_for_lti_incentives($rule_id,$email)
	{
		$tempArr =	array();
		$manager_email = $email;
		//$this->db->select("lti_rules.id")->where(array("lti_rules.status >="=>6))->order_by("id desc");
                $this->db->select("lti_rules.id")->where(array("lti_rules.id"=>$rule_id,"lti_rules.status >="=>6))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			//CB::Ravi on 15-02-2018
			//$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_lti_details.id as tbl_pk_id, employee_lti_details.upload_id, employee_lti_details.status as emp_incentive_status, employee_lti_details.status as req_status, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name as rule_name, lti_rules.status as rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, manage_function.name as function, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_lti_details.id as tbl_pk_id, login_user.upload_id, employee_lti_details.status as emp_incentive_status, employee_lti_details.status as req_status, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, lti_rules.lti_linked_with, lti_rules.lti_basis_on, lti_rules.rule_name as rule_name, lti_rules.status as rule_staus, lti_rules.lti_linked_with, lti_rules.lti_basis_on, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, manage_function.name as function, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
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
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status <"=>5));
			$this->db->order_by("employee_lti_details.last_action_by asc");
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$tempArr = $this->db->get()->result_array();
			
		}
		return $tempArr;	
	}
        public function list_of_manager_emps_for_rnr($email)
	{
                
		$manager_email = $email;
		
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
	}
        public function get_emp_rnr_history($condition_arr)
	{		
		$this->db->select("rule_name, award_value, login_user.name as recommended_by, proposed_rnr_dtls.updatedon as reward_date");
		$this->db->from("proposed_rnr_dtls");
		$this->db->join("login_user","login_user.id = proposed_rnr_dtls.createdby");
		$this->db->join("rnr_rules","rnr_rules.id = proposed_rnr_dtls.rule_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();	
	}
        public function get_employee_bonus_dtls_for_manager_discretions($condition_arr)
	{	
		//CB::Ravi on 15-02-2018
		//$this->db->select("employee_bonus_details.*, hr_parameter_bonus.manager_discretionary_increase, hr_parameter_bonus.manager_discretionary_decrease, hr_parameter_bonus.overall_budget, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.user_ids, row_owner.first_approver");
		$this->db->select("employee_bonus_details.*, hr_parameter_bonus.manager_discretionary_increase, hr_parameter_bonus.manager_discretionary_decrease, hr_parameter_bonus.overall_budget, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.user_ids, row_owner.first_approver, (select upload_id from login_user where login_user.id = employee_bonus_details.user_id) as upload_id");
		$this->db->from("employee_bonus_details");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$this->db->join("row_owner","row_owner.user_id = employee_bonus_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
       public function get_employee_lti_dtls_for_manager_discretions($condition_arr)
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
	}
        public function get_managers_employees_total_lti_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
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
	}
        public function get_managers_employees_total_bonus_budget($rule_id, $upload_id, $rule_user_ids, $manager_email)
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
	}
        

	     
}