<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Business_attribute_model extends CI_Model
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

    public function get_business_attributes($condition_arr = array())
	{
		$this->db->select("*");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("display_name","asc");
		return $this->db->get("business_attribute")->result_array();
	}

	public function insert_business_attributes($db_arr)
	{
		$this->db->insert("business_attribute",$db_arr);
	}

	public function update_business_attributes($db_arr,$condition_arr)
	{
		$this->db->where($condition_arr);
		$this->db->update('business_attribute', $db_arr);
	}

	public function get_business_attributes_list($condition_arr)
	{
		$this->db->select("*");
		$this->db->from("business_attribute");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("ba_attributes_order","asc");
		$this->db->order_by("status","desc");
		$this->db->order_by("is_required","desc");
		$this->db->order_by("display_name","asc");
		return $this->db->get()->result_array();
	}

	public function get_module_name_list()
	{
		$this->db->select("distinct (`module_name`)");
		$this->db->from("business_attribute");
		$this->db->where(array("module_name !=" => "N/A"));
		$this->db->order_by("module_name","asc");
		return $this->db->get()->result_array();
	}

	public function get_fixed_predefine_modules()
	{
		return array(CV_EMAIL_MODULE_NAME,
					CV_EMPLOYEE_NAME,
					CV_DESIGNATION,
					CV_GRADE,
					CV_FIRST_APPROVER,
					CV_SECOND_APPROVER,
					CV_THIRD_APPROVER,
					CV_FOURTH_APPROVER,
					CV_RATING_ELEMENT,
					CV_INCREMENT_APPLIED_ON,
					CV_SALARY_ELEMENT,
					//CV_MARKET_SALARY_ELEMENT,//CB:Ravi on 22-02-2018
					$this->session->userdata('market_data_by_ses'),
					CV_PREVIOUS_INCREMENTS,
					CV_BUSINESS_LEVELS);
	}

	public function get_ba_display_name($condition_arr = array())
	{
		$this->db->select("ba_name, display_name, id, module_name");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("ba_attributes_order","asc");
		return $this->db->get("business_attribute")->result_array();
	}

	public function get_ba_id_by_ba_name($ba_name)
	{
		$this->db->select("id, display_name");
		$this->db->where(array('ba_name' => $ba_name));
		$business_attributes = $this->db->get("business_attribute")->row_array();
		return $business_attributes;
	}

	public function get_business_attributes_custom($select='*',$condition_arr = array())
	{
		$this->db->select($select);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("ba_attributes_order","asc");
		$this->db->order_by("status","desc");
		$this->db->order_by("is_required","desc");
		$this->db->order_by("display_name","asc");
		return $this->db->get("business_attribute")->result_array();
	}

	public function get_master_tables_list(){
		$master_fields= [
			'country' => 'manage_country',
			'city' => 'manage_city',
			'business_level_1' =>'manage_business_level_1',
			'business_level_2' =>'manage_business_level_2',
			'business_level_3' => 'manage_business_level_3',
			'level' => 'manage_level',
			'education' => 'manage_education' ,
			'critical_talent' => 'manage_critical_talent',
			'critical_position' => 'manage_critical_position',
			'special_category' => 'manage_special_category',				
			'function' => 'manage_function',
			'subfunction' => 'manage_subfunction',
			'sub_subfunction' => 'manage_sub_subfunction',
			'designation' => 'manage_designation',
			'grade' => 'manage_grade' ,
			'currency'=>'manage_currency',
			"rating_for_current_year"=> "manage_rating_for_current_year",
			"rating_for_last_year"=> "manage_rating_for_current_year",
			"rating_for_2nd_last_year"=> "manage_rating_for_current_year",
			"rating_for_3rd_last_year"=> "manage_rating_for_current_year",
			"rating_for_4th_last_year"=> "manage_rating_for_current_year",
			"rating_for_5th_last_year"=> "manage_rating_for_current_year",
			'employee_type' => 'manage_cost_center',
			'designation' => 'manage_employee_type',
			'employee_role' => 'manage_employee_role' 
		];
		return $master_fields;
	}

	public function get_business_attributes_master_tables_list($condition_str='status=1')
	{
		$master_fields=$this->get_master_tables_list();
		$ba_result=$this->get_business_attributes_custom("ba_name,display_name,is_required,status","{$condition_str} and ba_name in ('".implode("','", array_keys($master_fields))."')");
		foreach ($ba_result as  $fld) {
			$fieldlist[$fld['ba_name']]=$fld;
			$fieldlist[$fld['ba_name']]['table']=$master_fields[$fld['ba_name']];					
		}
		return $fieldlist;
	}
	
}
