<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_model extends CI_Model
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

   	public function get_all_emp_ids_for_a_bonus_cycle($condition_arr)
	{	
		$this->db->select("bonus_rule_users_dtls.user_id");
		$this->db->from("hr_parameter_bonus");
		$this->db->join("bonus_rule_users_dtls","bonus_rule_users_dtls.rule_id = hr_parameter_bonus.id");
		return $this->db->where($condition_arr)->get()->result_array();
	}

    public function insert_bonus_rules($insertData){
    	$this->db->insert('hr_parameter_bonus',$insertData);
        return $this->db->insert_id();
    }
	
	public function delete_emp_bonus_dtls($whr_cnd)
	{
		$this->db->where($whr_cnd);
  		$this->db->delete('employee_bonus_details');
	}

    public function get_bonus_rule_dtls($condition_arr)
    {   
        $this->db->select("hr_parameter_bonus.*, performance_cycle.name, performance_cycle.type, performance_cycle.start_date, performance_cycle.end_date");
        $this->db->from("hr_parameter_bonus");
        $this->db->join("performance_cycle","performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
        return $this->db->where($condition_arr)->get()->row_array();
    }   

    public function updateBonusRules($updateData,$conditionArr)
	{
        $this->db->where($conditionArr)->update('hr_parameter_bonus',$updateData);
    }
	
	public function get_employees_as_per_rights_for_bonus_rule($condition_arr)
	{	
		$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.role, login_user.status, login_user.hr_user_id, manage_country.name as country, manage_city.name as city, manage_business_level_1.name as business_level_1, manage_business_level_2.name as business_level_2, manage_business_level_3.name as business_level_3, manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as sub_function, manage_sub_subfunction.name as sub_subfunction, manage_grade.name as grade, manage_level.name as level, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining");
		$this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		$this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		$this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_1."","left");
		$this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_2."","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");

		$this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user.".CV_BA_NAME_SUB_SUBFUNCTION."","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where(array("login_user.manage_hr_only"=>0));//Taking only company Emp
		return $this->db->from("login_user")->get()->result_array();
	}

    //************************************** RV ********************************
    

    public function get_rule_wise_emp_list_for_increments($rule_id)
    {
		$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.role, login_user.status, manage_country.name AS country, manage_city.name AS city,  manage_designation.name AS desig, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_grade.name AS grade, manage_level.name AS level, manage_business_level_3.name AS business_unit_3, login_user.upload_id, employee_bonus_details.final_bonus, employee_bonus_details.actual_bonus_per, employee_bonus_details.final_bonus_per, hr_parameter_bonus.manual_budget_dtls, hr_parameter_bonus.bonus_rule_name AS rule_name, employee_bonus_details.status AS emp_bonus_status, employee_bonus_details.rule_id, performance_cycle.name as performance_cycle_name, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_EMAIL." FROM login_user where login_user.".CV_BA_NAME_EMP_EMAIL." = employee_bonus_details.last_action_by) as last_manager_name, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, employee_bonus_details.performance_achievement");
        $this->db->from("employee_bonus_details");
        $this->db->join("login_user","login_user.id = employee_bonus_details.user_id");        
        $this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		$this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");       
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
        $this->db->where(array("employee_bonus_details.rule_id"=>$rule_id));
		$this->db->order_by("employee_bonus_details.last_action_by asc");
        $this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
        $data = $this->db->get()->result_array();
		return $data;
    }
	
    public function get_employee_bonus_dtls($condition_arr)
    {
		$this->db->select("login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.upload_id, (SELECT manage_designation.name FROM manage_designation WHERE manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION.") AS current_designation, employee_bonus_details.*, (SELECT hr_parameter_bonus.status FROM hr_parameter_bonus WHERE hr_parameter_bonus.id = employee_bonus_details.rule_id) AS rule_status, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type");
        $this->db->from("employee_bonus_details");
        $this->db->join("login_user","login_user.id = employee_bonus_details.user_id");
        if($condition_arr)
        {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }
	
	public function get_ratings_list_as_per_bonus_rules_emp($condition_arr)
	{
		$this->db->select("mr.id, mr.name AS value");
		$this->db->from("bonus_rule_users_dtls");
		$this->db->join("login_user", "login_user.id = bonus_rule_users_dtls.user_id");
		$this->db->join("manage_rating_for_current_year mr", "login_user.".CV_BA_NAME_RATING_FOR_CURRENT_YEAR." = mr.id");		
		$this->db->where(array("mr.status" => CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$this->db->group_by("mr.id");
		$this->db->order_by("mr.order_no ASC, mr.name ASC");
		return $this->db->get()->result_array();
	}
	
}