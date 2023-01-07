<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sip_model extends CI_Model
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

   	public function get_all_emp_ids_for_a_sip_cycle($condition_arr)
	{
		$this->db->select("sip_rule_users_dtls.user_id");
		$this->db->from("sip_hr_parameter");
		$this->db->join("sip_rule_users_dtls","sip_rule_users_dtls.rule_id = sip_hr_parameter.id");
		return $this->db->where($condition_arr)->get()->result_array();
	}

    public function insert_sip_rules($insertData){
    	$this->db->insert('sip_hr_parameter',$insertData);
        return $this->db->insert_id();
    }

	public function delete_emp_sip_dtls($whr_cnd)
	{
		$this->db->where($whr_cnd);
  		$this->db->delete('sip_employee_details');
	}

    public function get_sip_rule_dtls($condition_arr) {
        $this->db->select("sip_hr_parameter.*, performance_cycle.name, performance_cycle.type, performance_cycle.start_date, performance_cycle.end_date");
        $this->db->from("sip_hr_parameter");
        $this->db->join("performance_cycle","performance_cycle.id = sip_hr_parameter.performance_cycle_id");
        $rule_dtls = $this->db->where($condition_arr)->get()->row_array();

        $bl_1_weightage = "";
        $bl_2_weightage = "";
        $bl_3_weightage = "";
        $function_weightage = "";
        $sub_function_weightage = "";
        $sub_subfunction_weightage = "";
        $individual_weightage = "";

        if(isset($rule_dtls['id'])) {
          $bl_1_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_BUSINESS_LEVEL_1);
          $bl_2_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_BUSINESS_LEVEL_2);
          $bl_3_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_BUSINESS_LEVEL_3);
          $function_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_FUNCTION);
          $sub_function_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_SUB_FUNCTION);
          $sub_subfunction_weightage = $this->get_business_weightage_for_rule($rule_dtls['id'], CV_SUB_SUB_FUNCTION);
          $individual_weightage = $this->get_individual_weightage_for_rule($rule_dtls['id']);
        }

        $rule_dtls['bl_1_weightage'] = $bl_1_weightage;
        $rule_dtls['bl_2_weightage'] = $bl_2_weightage;
        $rule_dtls['bl_3_weightage'] = $bl_3_weightage;
        $rule_dtls['function_weightage'] = $function_weightage;
        $rule_dtls['sub_function_weightage'] = $sub_function_weightage;
        $rule_dtls['sub_subfunction_weightage'] = $sub_subfunction_weightage;
        $rule_dtls['individual_weightage'] = $individual_weightage;

        $query_ba = $this->db->query("SELECT name, GROUP_CONCAT(value) as value FROM sip_weightage_parameters where sip_hr_parameter_id = '" . $rule_dtls['id'] . "' and type = 2 GROUP BY name ");
        $custom_count = 1;
        foreach ($query_ba->result() as $row) {
          $rule_dtls['custom_'.$custom_count] = $row->value;
          $rule_dtls['custom_name_'.$custom_count] = $row->name;
          $custom_count++;
        }

        $rule_dtls['custom_param_count'] = $custom_count-1;

        return $rule_dtls;
    }

    public function get_business_weightage_for_rule($rule_id, $module_name) {
      $query_ba = $this->db->query("SELECT value FROM sip_weightage_parameters where sip_hr_parameter_id = '" . $rule_id . "' and ba_id = ( SELECT id FROM business_attribute where module_name = '" . $module_name . "')");
      return implode(",",array_map('current', $query_ba->result()));
    }

    public function get_individual_weightage_for_rule($rule_id) {
      $query_ba = $this->db->query("SELECT value FROM sip_weightage_parameters where sip_hr_parameter_id = '" . $rule_id . "' and type = 3 ");
      return implode(",",array_map('current', $query_ba->result()));
    }

    // public function get_custom_weightage_for_rule($rule_id) {
    //   $query_ba = $this->db->query("SELECT GROUP_CONCAT(value) as value FROM sip_weightage_parameters where sip_hr_parameter_id = '" . $rule_id . "' and type = 2 GROUP BY name ");
    //   $custom_count = 1;
    //   foreach ($query_ba->result() as $row) {
    //     print_r($row->value);
    //   }
    //   // return $query_ba->result();
    // }

    public function updateSipRules($updateData,$conditionArr)
	{
        $this->db->where($conditionArr)->update('sip_hr_parameter',$updateData);
    }

	public function get_employees_as_per_rights_for_sip_rule($condition_arr)
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


    public function get_rule_wise_emp_list_for_sip($condition_arr)
    {
		//$this->db->select("login_user.id, login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.role, login_user.status, manage_country.name AS country, manage_city.name AS city,  manage_designation.name AS desig, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_grade.name AS grade, manage_level.name AS level, manage_business_level_3.name AS business_unit_3, login_user.upload_id, sip_employee_details.final_sip, sip_employee_details.actual_sip_per, sip_employee_details.final_sip_per, sip_hr_parameter.manual_budget_dtls, sip_hr_parameter.sip_rule_name AS rule_name, sip_employee_details.status AS emp_sip_status, sip_employee_details.rule_id, performance_cycle.name as performance_cycle_name, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, sip_employee_details.last_action_by, sip_employee_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_EMAIL." FROM login_user where login_user.".CV_BA_NAME_EMP_EMAIL." = sip_employee_details.last_action_by) as last_manager_name, login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." AS date_of_joining, manage_rating_for_current_year.name AS performance_rating");
		$this->db->select("sip_employee_details.*, (SELECT login_user.".CV_BA_NAME_EMP_EMAIL." FROM login_user where login_user.".CV_BA_NAME_EMP_EMAIL." = sip_employee_details.last_action_by) as last_manager_name");
        $this->db->from("sip_employee_details");
        $this->db->where($condition_arr);
		$this->db->order_by("sip_employee_details.last_action_by asc");
        $this->db->order_by("sip_employee_details.emp_name asc");
        return $this->db->get()->result_array();
    }

    public function get_employee_sip_dtls($condition_arr)
    {
		//$this->db->select("login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.upload_id, (SELECT manage_designation.name FROM manage_designation WHERE manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION.") AS current_designation, sip_employee_details.*, (SELECT sip_hr_parameter.status FROM sip_hr_parameter WHERE sip_hr_parameter.id = sip_employee_details.rule_id) AS rule_status, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type");
		$this->db->select("*");
        $this->db->from("sip_employee_details");
        //$this->db->join("login_user","login_user.id = sip_employee_details.user_id");
        if($condition_arr)
        {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }

    public function insert_sip_weightage_parameters($insert_vals){
      $this->db->insert('sip_weightage_parameters', $insert_vals);
      return $this->db->insert_id();
    }
	
	public function insert_achievements_data_in_tmp_tbl($rule_id, $file_path, $table_name, $field_from_csv, $insert_fields_str, $update_fields_str)
	{
		$enclosed_by ='"';		
		//Insert data into temp table
		$this->db->query("LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$table_name." FIELDS TERMINATED BY ',' ENCLOSED BY '".$enclosed_by."' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (".$field_from_csv.") set ".$insert_fields_str);
		
		$this->db->query("UPDATE ".$table_name." temp_tbl SET temp_tbl.is_error = 1, temp_tbl.error_msg = 'Email is not valid.' WHERE NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.email = temp_tbl.email);");
		
		$this->db->query("UPDATE ".$table_name." temp_tbl INNER JOIN login_user lu ON temp_tbl.email = lu.email SET temp_tbl.email = lu.id WHERE temp_tbl.is_error = 0;");
		
		$this->db->query("UPDATE sip_rule_users_dtls srud INNER JOIN ".$table_name." temp_tbl ON srud.user_id = temp_tbl.email SET srud.actual_achievements = CONCAT (".$update_fields_str.") WHERE srud.rule_id = ".$rule_id." AND temp_tbl.is_error = 0;");
		
		$this->load->dbforge();
		$this->dbforge->drop_table($table_name,TRUE);
	}
	
	public function get_employees_dtls_for_sip($condition_arr, $sip_applied_on_elements, $is_needed_all_columns=1)
    {
		//Note :: $is_needed_all_columns=1(Yes, all columns needed), =2(No, only specific columns needed) 		
		$this->db->select("id, ba_name, module_name, display_name")->from("business_attribute");
		$sip_elem_ba_list = $this->db->where("(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "')")->get()->result_array();
		
		$sip_applied_on_ids_arr = explode(",", $sip_applied_on_elements);
		$sip_applied_on_names_arr = $modules_select_arr = array();
		foreach($sip_elem_ba_list as $ba_row)
		{
			if(in_array($ba_row["id"], $sip_applied_on_ids_arr))
			{
				$sip_applied_on_names_arr[] = $ba_row['ba_name'];
			}
			$modules_select_arr[] = $ba_row['ba_name'];
		}
		$modules_select_str = implode(",", $modules_select_arr);
		$sip_applied_on_str = implode("+", $sip_applied_on_names_arr);
		
		$select_str = "sip_rule_users_dtls.actual_achievements, login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_CURRENCY.", login_user.".CV_BA_NAME_COMPANY_JOINING_DATE.", login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_1.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_2.", login_user.".CV_BA_NAME_BUSINESS_LEVEL_3.", login_user.".CV_BA_NAME_FUNCTION.", login_user.".CV_BA_NAME_SUBFUNCTION.", login_user.".CV_BA_NAME_SUB_SUBFUNCTION.", login_user.".CV_BA_NAME_DESIGNATION.", login_user.".CV_BA_NAME_GRADE.", login_user.".CV_BA_NAME_LEVEL.", manage_business_level_1.name AS bu1_name, manage_business_level_2.name AS bu2_name, manage_business_level_3.name AS bu3_name, manage_function.name AS function_name, manage_subfunction.name AS subfunction_name, manage_sub_subfunction.name AS sub_subfunction_name";
		
		if($is_needed_all_columns==1)
		{		
			$select_str .= ", login_user.employee_code, login_user.".CV_BA_NAME_GENDER.",login_user.".CV_BA_NAME_EMP_FIRST_NAME.", login_user.".CV_BA_NAME_COUNTRY.", login_user.".CV_BA_NAME_CITY.", login_user.".CV_BA_NAME_EDUCATION.", login_user.".CV_BA_NAME_CRITICAL_TALENT.", login_user.".CV_BA_NAME_CRITICAL_POSITION.", login_user.".CV_BA_NAME_SPECIAL_CATEGORY.", login_user.tenure_company, login_user.tenure_role, login_user.company_name, login_user.".CV_BA_NAME_RECENTLY_PROMOTED.", login_user.".CV_BA_NAME_RATING_FOR_CURRENT_YEAR.", login_user.".CV_BA_NAME_TOTAL_COMPENSATION.", login_user.".CV_BA_NAME_PERFORMANCE_ACHIEVEMENT.", login_user.".CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE.", login_user.".CV_BA_NAME_START_DATE_FOR_ROLE.", login_user.".CV_BA_NAME_END_DATE_FOR_ROLE.", login_user.".CV_BA_NAME_APPROVER_1.", login_user.".CV_BA_NAME_APPROVER_2.", login_user.".CV_BA_NAME_APPROVER_3.", login_user.".CV_BA_NAME_APPROVER_4.", (SELECT name FROM login_user l WHERE l.email=login_user.".CV_BA_NAME_MANAGER_NAME.") AS ".CV_BA_NAME_MANAGER_NAME.", (SELECT name FROM login_user l WHERE l.email=login_user.".CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER.") AS ".CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER.", (SELECT name FROM login_user l WHERE l.email=login_user.".CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER.") AS ".CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER.", login_user.".CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER.", login_user.".CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER.", manage_country.name AS country_name, manage_city.name AS city_name, manage_designation.name AS designation_name, manage_grade.name AS grade_name, manage_level.name AS level_name, manage_education.name AS education_name, manage_critical_talent.name AS critical_talent_name, manage_critical_position.name AS critical_position_name, manage_special_category.name AS special_category_name";	
		}
			
		$select_str .= ",".$modules_select_str;
		$select_str .= " , (".$sip_applied_on_str.") AS total_salary_to_apply_sip";
		
		$this->db->select($select_str);
		$this->db->from("sip_rule_users_dtls");
        $this->db->join("login_user","login_user.id = sip_rule_users_dtls.user_id");
		$this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
		$this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
		
		$this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
		$this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUB_SUBFUNCTION . "", "left");
		
		if($is_needed_all_columns==1)
		{
			$this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
			$this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
			$this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
			$this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
			$this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");	   
			$this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
			$this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
			$this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left"); 
			$this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
		}
        if ($condition_arr)
		{
            $this->db->where($condition_arr);
        }
        return $this->db->get()->result_array();
    }
	
	public function get_emp_sip_dtls_to_export($condition_arr)
    {
		$business_attributes = $this->db->select("display_name")->order_by("id asc")->get("business_attribute")->result_array();
		$this->db->select("sed.emp_name AS ".$business_attributes[0]["display_name"].", sed.email_id AS Email Id, sed.business_level_3 AS ".$business_attributes[6]["display_name"].", sed.designation AS ".$business_attributes[9]["display_name"].", sed.grade AS ".$business_attributes[10]["display_name"].", sed.level AS ".$business_attributes[11]["display_name"].", sed.final_sip_per AS Sales Incentive %age, sed.final_sip AS Sales Incentive Amount, sed.target_sip AS Target Sales Incentive, sed.currency AS Currency, sed.joining_date_for_increment_purposes AS ".$business_attributes[17]["display_name"]);
        $this->db->from("sip_employee_details sed");
        $this->db->where($condition_arr);
		$this->db->order_by("sed.last_action_by asc");
        $this->db->order_by("sed.emp_name asc");
        return $this->db->get()->result_array();
    }

}
