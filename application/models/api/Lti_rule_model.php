<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Lti_rule_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Calcutta');
    }	
    public function setdb($dbname)
    {
       $this->db->query("use ".$dbname); 
    }

    public function get_rule_dtls_for_performance_cycles($condition_arr)
	{	
		$this->db->select("lti_rules.*, performance_cycle.name");
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
	
	public function insert_emp_lti_dtls($data)
	{
		$this->db->insert("employee_lti_details",$data);
		return $this->db->insert_id();
	}
	
	public function list_of_manager_emps_for_lti_increment($email)
	{
		$tempArr =	array();
		$manager_email = $email;
		$this->db->select("lti_rules.id")->where(array("row_owner.first_approver" => $email, "lti_rules.status >="=>6, "employee_lti_details.manager_emailid"=>$manager_email))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			$this->db->select("login_user.id, login_user.name, login_user.email,employee_lti_details.grant_value,employee_lti_details.final_incentive,employee_lti_details.actual_incentive, manage_level.name as level, employee_lti_details.id as tbl_pk_id, employee_lti_details.upload_id, employee_lti_details.rule_id, lti_rules.rule_name as rule_name, lti_rules.status as rule_staus, employee_lti_details.status as emp_bonus_status, employee_lti_details.manager_emailid, employee_lti_details.status as req_status, manage_designation.name as desig, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3, performance_cycle.name as performance_cycle_name");
			$this->db->from("row_owner");
			$this->db->join("employee_lti_details","row_owner.user_id = employee_lti_details.user_id");
			$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_lti_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
			$this->db->where("(row_owner.first_approver = '$manager_email' or row_owner.second_approver = '$manager_email' or row_owner.third_approver = '$manager_email' or row_owner.fourth_approver = '$manager_email')");
			$this->db->where(array("employee_lti_details.rule_id"=>$rule_dtls["id"], "employee_lti_details.status <"=>5));
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$data = $this->db->get()->result_array();
			
			if($data)
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
			}
		}
		return $tempArr;	
	}
        public function get_emp_lti_dtls($condition_arr)
    {   
        $this->db->select("login_user.name, login_user.email, (select manage_designation.name from manage_designation where manage_designation.id = login_user.desig) as current_designation, employee_lti_details.*, (select lti_rules.status from lti_rules where lti_rules.id = employee_lti_details.rule_id) as rule_status, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
        $this->db->from("employee_lti_details");
        $this->db->join("login_user","login_user.id = employee_lti_details.user_id");
        if($condition_arr)
        {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }
    public function get_rule_wise_emp_list_for_incentives($rule_id)
	{
		//CB::Ravi on 15-02-2018
		//$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, employee_lti_details.upload_id, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, employee_lti_details.status as emp_incentive_status, lti_rules.lti_linked_with, lti_rules.lti_basis_on, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
		$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, login_user.upload_id, employee_lti_details.final_incentive, employee_lti_details.grant_value, employee_lti_details.rule_id, employee_lti_details.status as emp_incentive_status, lti_rules.lti_linked_with, lti_rules.lti_basis_on, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_lti_details.last_action_by, employee_lti_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_lti_details.last_action_by) as last_manager_name");
		$this->db->from("employee_lti_details");
		$this->db->join("lti_rules","lti_rules.id = employee_lti_details.rule_id");
		$this->db->join("login_user","login_user.id = employee_lti_details.user_id");		
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where(array("employee_lti_details.rule_id"=>$rule_id));
		$this->db->order_by("employee_lti_details.last_action_by asc");
		$this->db->order_by("login_user.name asc");
		$tempArr = $this->db->get()->result_array();
		/*$tempArr =	array();	
		if($data)
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
		return $tempArr;
	} 
}