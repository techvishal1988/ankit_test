<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Lti_rule_model extends CI_Model
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
	
	public function get_all_emp_ids_for_a_lti_cycle($condition_arr)
	{	
		$this->db->select("lti_rule_users_dtls.user_id");
		$this->db->from("lti_rules");
		$this->db->join("lti_rule_users_dtls","lti_rule_users_dtls.rule_id = lti_rules.id");
		return $this->db->where($condition_arr)->get()->result_array();
	}

    public function get_rule_dtls_for_performance_cycles($condition_arr)
	{	
		$this->db->select("lti_rules.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date");
		$this->db->from("lti_rules");
		$this->db->join("performance_cycle","performance_cycle.id = lti_rules.performance_cycle_id");
		return $this->db->where($condition_arr)->get()->row_array();
	}
	
	public function get_table_row($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->row_array();		
	}	

	public function insert_rules($data)
	{
		$this->db->insert("lti_rules",$data);
		return $this->db->insert_id();
	}

	public function update_rules($condition_arr,$setData)
	{		
		$this->db->where($condition_arr);
		$this->db->update('lti_rules', $setData);
	}
	
	public function delete_emp_salary_dtls($whr_cnd)
	{
		$this->db->where($whr_cnd);
  		$this->db->delete('employee_lti_details');
	}
	
	public function insert_emp_lti_dtls($data)
	{
		$this->db->insert("employee_lti_details",$data);
		return $this->db->insert_id();
	}
	
	public function get_rule_wise_emp_list_for_incentives($rule_id)
	{
		$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.role, login_user.status, manage_country.name AS country, manage_city.name AS city,  manage_designation.name AS desig, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_grade.name AS grade, manage_level.name AS level, manage_business_level_3.name AS business_unit_3, login_user.upload_id, employee_lti_details.actual_incentive, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, employee_lti_details.status AS emp_incentive_status, lti_rules.lti_linked_with, lti_rules.budget_dtls, lti_rules.lti_basis_on, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_lti_details.last_action_by) AS last_manager_name");
		$this->db->from("employee_lti_details");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$this->db->join("login_user","login_user.id = employee_lti_details.user_id");
		$this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		$this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
		$this->db->where(array("employee_lti_details.rule_id"=>$rule_id));
		$this->db->order_by("employee_lti_details.last_action_by asc");
		$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
		$tempArr = $this->db->get()->result_array();
		return $tempArr;
	} 
	
	public function get_emp_lti_dtls($condition_arr)
    {   
        $this->db->select("login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", (SELECT manage_designation.name FROM manage_designation WHERE manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION.") AS current_designation, employee_lti_details.*, (SELECT lti_rules.status FROM lti_rules WHERE lti_rules.id = employee_lti_details.rule_id) AS rule_status, manage_rating_for_current_year.name AS performance_rating, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type");
        $this->db->from("employee_lti_details");
        $this->db->join("login_user","login_user.id = employee_lti_details.user_id");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
        if($condition_arr)
        {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }
	     
}