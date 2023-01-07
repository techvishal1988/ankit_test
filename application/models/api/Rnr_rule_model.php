<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Rnr_rule_model extends CI_Model
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
    public function getRules($condition_arr)
	{	
		$this->db->select("rnr_rules.*, performance_cycle.name");
		$this->db->from("rnr_rules");
		$this->db->join("performance_cycle","performance_cycle.id = rnr_rules.performance_cycle_id");
		return $this->db->where_in($condition_arr)->get()->row_array();
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
		$this->db->insert("rnr_rules",$data);
		return $this->db->insert_id();
	}

	public function update_rules($condition_arr,$setData)
	{		
		$this->db->where($condition_arr);
		$this->db->update('rnr_rules', $setData);
	}
     public function list_of_manager_emps($email)
	{
		$tempArr =	array();
		$manager_email = $email;
		$this->db->select("hr_parameter.id")->where(array("row_owner.first_approver" => $email, "hr_parameter.status >="=>6))->order_by("id desc");
		$this->db->from("row_owner");
		$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		$rule_dtls = $this->db->get()->row_array();

		if($rule_dtls)
		{			
			$this->db->select("login_user.id, login_user.name, login_user.email, manage_level.name as level, employee_salary_details.id as tbl_pk_id, employee_salary_details.upload_id, employee_salary_details.rule_id, hr_parameter.status as rule_staus, employee_salary_details.status as emp_salary_status, employee_salary_details.manager_emailid, employee_salary_details.status as req_status, manage_designation.name as desig, manage_function.name as function, manage_grade.name as grade, row_owner.first_approver, row_owner.second_approver, row_owner.third_approver, row_owner.fourth_approver, manage_business_level_3.name as business_unit_3");
			$this->db->from("row_owner");
			$this->db->join("employee_salary_details","row_owner.user_id = employee_salary_details.user_id");
			$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");	
			$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
			$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
			$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
			$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
			$this->db->join("manage_level", "manage_level.id = login_user.level","left");
			$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
			//$this->db->where(array("row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status"=>1));	
			$this->db->where("(row_owner.first_approver = '$manager_email')");
			$this->db->where(array("employee_salary_details.rule_id"=>$rule_dtls["id"], "employee_salary_details.status <"=>5));
			$this->db->order_by("login_user.name asc");
			$this->db->group_by("row_owner.user_id");
			$data = $this->db->get()->result_array();
			
			if($data)
			{
				foreach($data as $row)
				{
					//$row["business_unit_3"] = "";
					$row["date_of_joining"] = "";
					$row["performance_rating"] = "";

					/*$this->db->select("value");
					$this->db->join("datum","datum.row_num = tuple.row_num");
					$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_BUSINESS_LEVEL_3_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
					$dt = $this->db->get("tuple")->row_array();
					if($dt)
					{
						$row["business_unit_3"] = $dt["value"];
					}*/

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
	     
}