<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Rule_model extends CI_Model
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
	
	public function manage_users_history($condition_str)
	{		
		//Manage login_user tbl History before updating data of the users
		$this->db->query("INSERT INTO login_user_history SELECT * FROM login_user WHERE ".$condition_str);
	}
	
	public function get_all_emp_ids_for_a_cycle($condition_arr)
	{	
		$this->db->select("salary_rule_users_dtls.user_id");
		$this->db->from("hr_parameter");
		$this->db->join("salary_rule_users_dtls","salary_rule_users_dtls.rule_id = hr_parameter.id");
		return $this->db->where($condition_arr)->get()->result_array();
	}
	
	public function insert_data_as_batch($tbl_name, $db_arr)
	{		
		$this->db->insert_batch($tbl_name, $db_arr);
	} 
	
	public function delete_emps_frm_rule_dtls($tbl_name, $whr_cnd)
	{
		$this->db->where($whr_cnd);
		$this->db->delete($tbl_name);
	}

	public function get_rule_dtls_for_performance_cycles($condition_arr)
	{	
		$this->db->select("hr_parameter.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (SELECT name FROM manage_currency WHERE manage_currency.id = hr_parameter.to_currency_id) AS rule_currency_name,b.bonus_rule_name");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle","performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->join("hr_parameter_bonus as b","b.id = hr_parameter.linked_bonus_rule_id","left");
		return $this->db->where($condition_arr)->get()->row_array();
	}
	
	public function get_employees_for_salary_rule_as_per_rights($condition_arr)
	{//login_user.role, login_user.status, login_user.hr_user_id, 
        $this->db->select("manage_country.name AS country, manage_city.name AS city, manage_business_level_1.name AS business_level_1, manage_business_level_2.name AS business_level_2, manage_business_level_3.name AS business_level_3, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_sub_subfunction.name AS sub_subfunction, manage_designation.name AS designation, manage_grade.name AS grade, manage_level.name AS level, manage_education.name AS education, manage_critical_talent.name AS critical_talent, manage_critical_position.name AS critical_position, manage_special_category.name AS special_category, manage_cost_center.name AS cost_center, manage_employee_type.name AS employee_type, manage_employee_role.name AS employee_role,
		 login_user.id, login_user.email, login_user.name, login_user.tenure_company, login_user.tenure_role, login_user.currency, login_user.recently_promoted, login_user.company_joining_date, login_user.increment_purpose_joining_date, login_user.start_date_for_role, login_user.end_date_for_role, login_user.bonus_incentive_applicable, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_last_year) AS rating_for_last_year, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_2nd_last_year) AS rating_for_2nd_last_year, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_3rd_last_year) AS rating_for_3rd_last_year, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_4th_last_year) AS rating_for_4th_last_year, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_5th_last_year) AS rating_for_5th_last_year, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.rating_for_current_year) AS rating_for_current_year, login_user.effective_date_of_last_salary_increase, login_user.effective_date_of_2nd_last_salary_increase, login_user.effective_date_of_3rd_last_salary_increase, login_user.effective_date_of_4th_last_salary_increase, login_user.effective_date_of_5th_last_salary_increase, login_user.salary_after_last_increase, login_user.salary_after_2nd_last_increase, login_user.salary_after_3rd_last_increase, login_user.salary_after_4th_last_increase, login_user.salary_after_5th_last_increase, login_user.total_salary_after_last_increase, login_user.total_salary_after_2nd_last_increase, login_user.total_salary_after_3rd_last_increase, login_user.total_salary_after_4th_last_increase, login_user.total_salary_after_5th_last_increase, login_user.target_salary_after_last_increase, login_user.target_salary_after_2nd_last_increase, login_user.target_salary_after_3rd_last_increase, login_user.target_salary_after_4th_last_increase, login_user.target_salary_after_5th_last_increase, login_user.current_base_salary, login_user.current_target_bonus, login_user.allowance_1, login_user.allowance_2, login_user.allowance_3, login_user.allowance_4, login_user.allowance_5, login_user.allowance_6, login_user.allowance_7, login_user.allowance_8, login_user.allowance_9, login_user.allowance_10, login_user.allowance_11, login_user.allowance_12, login_user.allowance_13, login_user.allowance_14, login_user.allowance_15, login_user.allowance_16, login_user.allowance_17, login_user.allowance_18, login_user.allowance_19, login_user.allowance_20, login_user.allowance_21, login_user.allowance_22, login_user.allowance_23, login_user.allowance_24, login_user.allowance_25, login_user.allowance_26, login_user.allowance_27, login_user.allowance_28, login_user.allowance_29, login_user.allowance_30, login_user.allowance_31, login_user.allowance_32, login_user.allowance_33, login_user.allowance_34, login_user.allowance_35, login_user.allowance_36, login_user.allowance_37, login_user.allowance_38, login_user.allowance_39, login_user.allowance_40, login_user.total_compensation, login_user.increment_applied_on, login_user.job_code, login_user.job_name, login_user.job_level, login_user.market_target_salary_level_min, login_user.market_total_salary_level_min, login_user.market_base_salary_level_min, login_user.market_target_salary_level_1, login_user.market_total_salary_level_1, login_user.market_base_salary_level_1, login_user.market_target_salary_level_2, login_user.market_total_salary_level_2, login_user.market_base_salary_level_2, login_user.market_target_salary_level_3, login_user.market_total_salary_level_3, login_user.market_base_salary_level_3, login_user.market_target_salary_level_4, login_user.market_total_salary_level_4, login_user.market_base_salary_level_4, login_user.market_target_salary_level_5, login_user.market_total_salary_level_5, login_user.market_base_salary_level_5, login_user.market_target_salary_level_6, login_user.market_total_salary_level_6, login_user.market_base_salary_level_6, login_user.market_target_salary_level_7, login_user.market_total_salary_level_7, login_user.market_base_salary_level_7, login_user.market_target_salary_level_8, login_user.market_total_salary_level_8, login_user.market_base_salary_level_8, login_user.market_target_salary_level_9, login_user.market_total_salary_level_9, login_user.market_base_salary_level_9, login_user.market_target_salary_sevel_max, login_user.market_total_salary_level_max, login_user.market_base_salary_level_max, login_user.company_1_base_salary_min, login_user.company_1_base_salary_max, login_user.company_1_base_salary_average, login_user.company_2_base_salary_min, login_user.company_2_base_salary_max, login_user.company_2_base_salary_average, login_user.company_3_base_salary_min, login_user.company_3_base_salary_max, login_user.company_3_base_salary_average, login_user.average_base_salary_min, login_user.average_base_salary_max, login_user.average_base_salary_average, login_user.company_1_target_salary_min, login_user.company_1_target_salary_max, login_user.company_1_target_salary_average, login_user.company_2_target_salary_min, login_user.company_2_target_salary_max, login_user.company_2_target_salary_average, login_user.company_3_target_salary_min, login_user.company_3_target_salary_max, login_user.company_3_target_salary_average, login_user.average_target_salary_min, login_user.average_target_salary_max, login_user.average_target_salary_average, login_user.company_1_total_salary_min, login_user.company_1_total_salary_max, login_user.company_1_total_salary_average, login_user.company_2_total_salary_min, login_user.company_2_sotal_salary_max, login_user.company_2_total_salary_average, login_user.company_3_total_salary_min, login_user.company_3_total_salary_max, login_user.company_3_total_salary_average, login_user.average_total_salary_min, login_user.average_total_salary_max, login_user.average_total_salary_average, login_user.approver_1, login_user.approver_2, login_user.approver_3, login_user.approver_4, login_user.manager_name, login_user.authorised_signatory_for_letter, login_user.authorised_signatorys_title_for_letter, login_user.hr_authorised_signatory_for_letter, login_user.hr_authorised_signatorys_title_for_letter, login_user.company_name, login_user.gender, login_user.first_name, login_user.employee_code, login_user.performance_achievement, login_user.teeth_tail_ratio, login_user.previous_talent_rating, login_user.promoted_in_2_yrs, login_user.engagement_level, login_user.successor_identified, login_user.readyness_level, login_user.urban_rural_classification, login_user.employee_movement_into_bonus_plan, login_user.other_data_9, login_user.other_data_10, login_user.other_data_11, login_user.other_data_12, login_user.other_data_13, login_user.other_data_14, login_user.other_data_15, login_user.other_data_16, login_user.other_data_17, login_user.other_data_18, login_user.other_data_19, login_user.other_data_20, login_user.other_data_21, login_user.other_data_22, login_user.other_data_23, login_user.other_data_24");
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
		$this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUB_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
		$this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
		$this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
		$this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left"); 
		$this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
		$this->db->join("manage_cost_center", "manage_cost_center.id = login_user.".CV_BA_NAME_COST_CENTER, "left");
		$this->db->join("manage_employee_type", "manage_employee_type.id = login_user.".CV_BA_NAME_EMPLOYEE_TYPE, "left");
		$this->db->join("manage_employee_role", "manage_employee_role.id = login_user.".CV_BA_NAME_EMPLOYEE_ROLE, "left");
		
        if ($condition_arr)
		{
            $this->db->where($condition_arr);
        }
        $this->db->where(array("login_user.manage_hr_only" => 0)); //Taking only company Emp
        return $this->db->from("login_user")->get()->result_array();
    }
	
	public function get_users_list_for_salary_rule($select_str, $condition_arr)
	{
        $this->db->select($select_str);
        $this->db->from('login_user');
        //$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id");
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUB_SUBFUNCTION . "", "left");
         $this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
          $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
          $this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left"); 
        $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
        $this->db->where(array("login_user.status" => CV_STATUS_ACTIVE));
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->result_array();
    }	

	public function insert_rules($data)
	{
		$this->db->insert("hr_parameter",$data);
		return $this->db->insert_id();
	}

	public function update_rules($condition_arr,$setData)
	{		
		$this->db->where($condition_arr);
		$this->db->update('hr_parameter', $setData);
	}

	public function insert_emp_salary_dtls($data)
	{
		$this->db->insert("employee_salary_details",$data);
		return $this->db->insert_id();
	}
	
	public function delete_emp_salary_dtls($whr_cnd)
	{
		$this->db->where($whr_cnd);
		$this->db->delete('employee_salary_details');
	}
	
	public function get_backup_before_salary_rule_data_refreshed($rule_id)
	{
		/*$this->load->dbforge();
		$this->dbforge->drop_table("tbl_temp_for_employee_salary_details_backup",TRUE);*/
		$this->db->query("DROP TABLE IF EXISTS `tbl_temp_for_employee_salary_details_backup`;");
		$this->db->query("CREATE TABLE `tbl_temp_for_employee_salary_details_backup` LIKE `employee_salary_details`;");
		$this->db->query("INSERT INTO `tbl_temp_for_employee_salary_details_backup` SELECT * FROM `employee_salary_details` WHERE rule_id = ".$rule_id.";");
		$this->delete_emp_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id));
	}
	
	public function restore_emps_old_hike_dtls_on_refresh_salary_rule($rule_id)
	{
		$this->db->query("UPDATE employee_salary_details em_sa_de 
INNER JOIN tbl_temp_for_employee_salary_details_backup tmp_tbl USING (user_id) 
SET em_sa_de.mkt_salary_after_promotion = tmp_tbl.mkt_salary_after_promotion, em_sa_de.crr_after_promotion = tmp_tbl.crr_after_promotion, em_sa_de.quartile_range_name_after_promotion = tmp_tbl.quartile_range_name_after_promotion, em_sa_de.final_merit_hike = tmp_tbl.final_merit_hike, 
	em_sa_de.final_market_hike = tmp_tbl.final_market_hike, em_sa_de.manager_discretions = tmp_tbl.manager_discretions, em_sa_de.final_salary = em_sa_de.increment_applied_on_salary + (em_sa_de.increment_applied_on_salary * (tmp_tbl.manager_discretions + tmp_tbl.sp_manager_discretions))/100, em_sa_de.sp_manager_discretions = tmp_tbl.sp_manager_discretions, em_sa_de.sp_increased_salary = (em_sa_de.increment_applied_on_salary*tmp_tbl.sp_manager_discretions)/100, em_sa_de.salary_comment = tmp_tbl.salary_comment, em_sa_de.promotion_comment = tmp_tbl.promotion_comment, em_sa_de.esop = tmp_tbl.esop, em_sa_de.retention_bonus = tmp_tbl.retention_bonus, em_sa_de.pay_per = tmp_tbl.pay_per, em_sa_de.emp_new_designation = tmp_tbl.emp_new_designation, em_sa_de.emp_new_grade = tmp_tbl.emp_new_grade, em_sa_de.emp_new_level = tmp_tbl.emp_new_level
WHERE em_sa_de.rule_id = ".$rule_id.";");

		$this->db->query("UPDATE employee_salary_details em_sa_de 
INNER JOIN tbl_temp_for_employee_salary_details_backup tmp_tbl USING (user_id) 
SET em_sa_de.status = tmp_tbl.status, em_sa_de.last_action_by = tmp_tbl.last_action_by, em_sa_de.manager_emailid = tmp_tbl.manager_emailid
WHERE em_sa_de.rule_id = ".$rule_id." AND em_sa_de.approver_1 = tmp_tbl.approver_1 AND em_sa_de.approver_2 = tmp_tbl.approver_2 AND em_sa_de.approver_3 = tmp_tbl.approver_3 AND em_sa_de.approver_4 = tmp_tbl.approver_4;");
	}
	
	public function update_emps_salary_dtls_on_refresh_rule($rule_dtls)
	{
		if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{
			$this->db->simple_query('SET SESSION group_concat_max_len=9999999');
			$ba_names_arr = $this->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(ba_name) SEPARATOR ', lu.') AS mkt_ba_names", "(business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_CTC_ELEMENT . "')");
			$ba_names_str = $ba_names_arr["mkt_ba_names"];
			
			$this->db->select("em_sa_de.id, em_sa_de.user_id, em_sa_de.final_salary, lu.".$ba_names_str);
			$this->db->from('employee_salary_details em_sa_de');
			$this->db->join("login_user lu", "lu.id = em_sa_de.user_id");
			$this->db->where(array("em_sa_de.rule_id" => $rule_dtls["id"]));
			$emp_list = $this->db->get()->result_array();
			
			$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);		
			$db_arr = array();
			foreach($emp_list as $row)
			{
				$post_quartile_range_name = HLP_get_quartile_position_range_name($row, $row['final_salary'], $crr_arr);
				$db_arr[] = array("id" => $row["id"], "post_quartile_range_name" => $post_quartile_range_name);
			}
			
			if($db_arr)
			{
				$this->db->update_batch('employee_salary_details', $db_arr, "id");
			}
		}
		
		/*$this->db->query("DELETE tmp_tbl 
FROM tbl_temp_for_employee_salary_details_backup tmp_tbl 
INNER JOIN employee_salary_details em_sa_de ON tmp_tbl.user_id = em_sa_de.user_id
WHERE em_sa_de.rule_id = ".$rule_dtls["id"]." AND em_sa_de.approver_1 = tmp_tbl.approver_1 AND em_sa_de.approver_2 = tmp_tbl.approver_2 AND em_sa_de.approver_3 = tmp_tbl.approver_3 AND em_sa_de.approver_4 = tmp_tbl.approver_4;");*/

		$this->db->select("em_sa_de.id, em_sa_de.user_id, em_sa_de.approver_1");
		$this->db->from("employee_salary_details em_sa_de");
		$this->db->where("em_sa_de.rule_id = ".$rule_dtls["id"]." AND em_sa_de.user_id IN (SELECT tmp_tbl.user_id FROM tbl_temp_for_employee_salary_details_backup tmp_tbl WHERE tmp_tbl.rule_id = em_sa_de.rule_id AND (em_sa_de.approver_1 != tmp_tbl.approver_1 OR em_sa_de.approver_2 != tmp_tbl.approver_2 OR em_sa_de.approver_3 != tmp_tbl.approver_3 OR em_sa_de.approver_4 != tmp_tbl.approver_4));");
		$changed_managers_emp_list = $this->db->get()->result_array();
		if($changed_managers_emp_list)
		{
			$db_arr = array();
			foreach($changed_managers_emp_list as $row)
			{
				$this->db->select("status, last_action_by, manager_emailid")->from("employee_salary_details");
				$this->db->where("rule_id = ".$rule_dtls["id"]." AND user_id != ".$row["user_id"]." AND approver_1 = '".$row["approver_1"]."';");
				$new_managers_emp_dtls = $this->db->get()->row_array();
				if($new_managers_emp_dtls)
				{
					$db_arr[] = array("id" => $row["id"], "status" => $new_managers_emp_dtls["status"], "last_action_by" => $new_managers_emp_dtls["last_action_by"], "manager_emailid" => $new_managers_emp_dtls["manager_emailid"]);
				}				
			}
			
			if($db_arr)
			{
				$this->db->update_batch('employee_salary_details', $db_arr, "id");
			}
		}
			
        return true;
    }

	public function get_rule_wise_emp_list_for_increment($whr_cnd)
	{		
		$this->db->select("employee_salary_details.*,login_user.employee_code");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->where($whr_cnd);
		$this->db->order_by("login_user.".CV_BA_NAME_EMP_FULL_NAME." asc");
		$data = $this->db->get()->result_array();
		return $data;
	} 
	
	public function get_rule_wise_emp_list_for_increments($rule_id,$whr_cnd='')
	{		
		/*if($email=='')
		{
			$manager_email = $this->session->userdata('email_ses');
		}
		else
		{
			$manager_email=$email;
		}*/
		$this->db->select("hr_parameter.status AS rule_status, hr_parameter.template_id,
			hr_parameter.esop_title, 
			hr_parameter.esop_type
			, hr_parameter.esop_right ,
			hr_parameter.pay_per_title, 
			hr_parameter.pay_per_type
			, hr_parameter.pay_per_right ,
			hr_parameter.retention_bonus_title, 
			hr_parameter.retention_bonus_type
			, hr_parameter.retention_bonus_right 
			, hr_parameter.salary_position_based_on, 
			hr_parameter.performance_cycle_id,
			hr_parameter.manual_budget_dtls,
			 employee_salary_details.user_id AS id,
employee_salary_details.id as tbl_pk_id, employee_salary_details.crr_val AS current_crr,
		 employee_salary_details.increment_applied_on_salary, employee_salary_details.final_salary, employee_salary_details.market_salary, employee_salary_details.manager_discretions,
		 employee_salary_details.esop,
		 employee_salary_details.bonus_recommendation,
		 employee_salary_details.pay_per,
			employee_salary_details.joining_date_for_increment_purposes,
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
			employee_salary_details.salary_comment,
			employee_salary_details.promotion_comment,
			employee_salary_details.retention_bonus,
			employee_salary_details.business_level_1,
			employee_salary_details.business_level_2,
			employee_salary_details.business_level_3,
			employee_salary_details.city,
			employee_salary_details.post_quartile_range_name,
			employee_salary_details.performance_rating,
			employee_salary_details.performance_rating_id,
			employee_salary_details.current_target_bonus,
			employee_salary_details.sub_sub_function,
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
			employee_salary_details.last_action_by,
			(SELECT login_user.employee_code FROM login_user WHERE login_user.id = employee_salary_details.user_id) as employee_code,
		  	employee_salary_details.email_id AS email, employee_salary_details.emp_name AS name, employee_salary_details.country, employee_salary_details.city,  employee_salary_details.designation AS desig, employee_salary_details.function, employee_salary_details.sub_function AS subfunction, employee_salary_details.grade,employee_salary_details.level, employee_salary_details.business_level_3 AS business_unit_3, employee_salary_details.joining_date_for_increment_purposes AS date_of_joining");
		$this->db->from("employee_salary_details");
		//$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		/*$this->db->join("manage_country", "manage_country.id = login_user.".CV_BA_NAME_COUNTRY."","left");
		$this->db->join("manage_city", "manage_city.id = login_user.".CV_BA_NAME_CITY."","left");
		$this->db->join("manage_function", "manage_function.id = login_user.".CV_BA_NAME_FUNCTION."","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.".CV_BA_NAME_SUBFUNCTION."","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION."","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.".CV_BA_NAME_GRADE."","left");
		$this->db->join("manage_level", "manage_level.id = login_user.".CV_BA_NAME_LEVEL."","left");*/
		$this->db->join("hr_parameter", "hr_parameter.id = employee_salary_details.rule_id","left");
		//$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.".CV_BA_NAME_BUSINESS_LEVEL_3."","left");
		//$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		if($whr_cnd)
		{
			$this->db->where($whr_cnd);
		}		
		$this->db->order_by("employee_salary_details.emp_name asc");
		$data = $this->db->get()->result_array();
		return $data;
	} 
	
	/*public function get_employee_salary_dtls($condition_arr)
	{	
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$qry = "login_user.name, login_user.email, (select manage_designation.name from manage_designation where manage_designation.id = login_user.desig) as current_designation, employee_salary_details.id, employee_salary_details.manager_emailid, employee_salary_details.user_id, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, market_salary, performance_rating,`final_salary`, employee_salary_details.actual_salary, employee_salary_details.manager_discretions, (select hr_parameter.status from hr_parameter where hr_parameter.id = employee_salary_details.rule_id) as rule_status, employee_salary_details.sp_manager_discretions, employee_salary_details.emp_new_designation, employee_salary_details.emp_citation, employee_salary_details.sp_increased_salary, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, login_user.upload_id, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["target_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["total_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		
		$this->db->select($qry);
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}*/ 

	public function get_employee_salary_dtls($condition_arr)
	{	
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$qry = "employee_salary_details.emp_name AS name, employee_salary_details.email_id AS email, employee_salary_details.designation AS current_designation, employee_salary_details.id, employee_salary_details.manager_emailid, employee_salary_details.user_id, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, market_salary, performance_rating,`final_salary`, employee_salary_details.actual_salary, employee_salary_details.manager_discretions, (select hr_parameter.status from hr_parameter where hr_parameter.id = employee_salary_details.rule_id) as rule_status, (select hr_parameter.manager_can_exceed_budget from hr_parameter where hr_parameter.id = employee_salary_details.rule_id) as manager_can_exceed_budget, employee_salary_details.sp_manager_discretions, employee_salary_details.status AS salary_hike_approval_status, 
		employee_salary_details.rule_id, employee_salary_details.pre_quartile_range_name, employee_salary_details.post_quartile_range_name, employee_salary_details.crr_val AS current_crr,
		employee_salary_details.mkt_salary_after_promotion,
		employee_salary_details.crr_after_promotion,
		employee_salary_details.quartile_range_name_after_promotion,
		employee_salary_details.final_merit_hike,
		employee_salary_details.final_market_hike,
		employee_salary_details.approver_1,
		employee_salary_details.approver_2,
		employee_salary_details.approver_3,
		employee_salary_details.approver_4,
		employee_salary_details.emp_new_designation,employee_salary_details.emp_new_grade,employee_salary_details.emp_new_level, employee_salary_details.emp_citation, employee_salary_details.esop, employee_salary_details.bonus_recommendation, employee_salary_details.retention_bonus, employee_salary_details.pay_per,
		employee_salary_details.salary_comment,
		employee_salary_details.promotion_comment,
		employee_salary_details.comments,
		employee_salary_details.performance_achievement, employee_salary_details.current_target_bonus,
		employee_salary_details.joining_date_for_increment_purposes, employee_salary_details.sp_increased_salary, employee_salary_details.currency AS currency_type, login_user.upload_id, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR.", login_user.".CV_BA_NAME_CURRENT_BASE_SALARY." AS Base_salary, (SELECT salary_rule_users_dtls.other_data_11 FROM salary_rule_users_dtls WHERE salary_rule_users_dtls.rule_id = employee_salary_details.rule_id AND salary_rule_users_dtls.user_id = employee_salary_details.user_id) AS other_data_11";
		if($company_dtls["target_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["target_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["total_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		$this->db->select($qry);
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	} 
	
	/*public function get_peer_employee_salary_dtls_for_graph_new($rule_id, $uid, $upload_id, $rule_user_ids, $graph_on=CV_GRADE, $order_by="")
	{	
		$this->db->select("id, grade, level");
		$this->db->from("login_user");
		$this->db->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();
		
		
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
								
		$qry = "login_user.name, login_user.email, (select (value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$qry .= ", (select sum(value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["target_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$qry .= ", (select sum(value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["total_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		$this->db->select($qry);
		$this->db->from("login_user");			
		$this->db->where("login_user.id != '".$uid."' and login_user.id in (".$rule_user_ids.")");
		if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.level"=>$user_grade_level_dtls["level"]));
		}
		else
		{
			$this->db->where(array("login_user.grade"=>$user_grade_level_dtls["grade"]));
		}
		
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{
			$this->db->order_by("Base_salary","asc");
			$this->db->order_by("Target_salary","asc");
			$this->db->order_by("Total_salary","asc");
		}		
		return $this->db->get()->result_array();		
	}*/ 
	
	public function get_peer_employee_salary_dtls_for_graph_new($rule_id, $uid, $graph_on=CV_GRADE, $order_by="")
	{
		$this->db->select("id, ".CV_BA_NAME_DESIGNATION.", ".CV_BA_NAME_GRADE.", ".CV_BA_NAME_LEVEL.", ".CV_BA_NAME_FUNCTION.", ".CV_BA_NAME_JOB_CODE."")->from("login_user")->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();	
		
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$rule_dtls = $this->rule_model->get_table_row("hr_parameter", "salary_applied_on_elements", array("id"=>$rule_id));
				
		$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$rule_dtls["salary_applied_on_elements"].")");
		$temp_arr = array();
		foreach($ba_name_arr as $row)
		{
			$temp_arr[] = "login_user.".$row["ba_name"];
		}
		
		$qry = "login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL;
		$qry .= ", (".implode(" + ", $temp_arr).") as Base_salary";

		//$qry = "login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_CURRENT_BASE_SALARY." AS Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["target_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["total_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		$this->db->select($qry.", (SELECT final_salary FROM employee_salary_details WHERE rule_id =".$rule_id." AND user_id = login_user.id) AS emp_revised_salary");
		$this->db->from("login_user");			
		$this->db->where("login_user.id != '".$uid."' and login_user.id in (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		/*if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.".CV_BA_NAME_LEVEL.""=>$user_grade_level_dtls[CV_BA_NAME_LEVEL], "login_user.".CV_BA_NAME_JOB_CODE.""=>$user_grade_level_dtls[CV_BA_NAME_JOB_CODE]));
		}
		else
		{
			$this->db->where(array("login_user.".CV_BA_NAME_GRADE.""=>$user_grade_level_dtls[CV_BA_NAME_GRADE], "login_user.".CV_BA_NAME_JOB_CODE.""=>$user_grade_level_dtls[CV_BA_NAME_JOB_CODE]));
		}*/
		if($company_dtls["peer_group_base"]==2)
		{
			$this->db->where(array("login_user.".$graph_on.""=>$user_grade_level_dtls[$graph_on], "login_user.".CV_BA_NAME_FUNCTION.""=>$user_grade_level_dtls[CV_BA_NAME_FUNCTION], "login_user.".CV_BA_NAME_JOB_CODE.""=>$user_grade_level_dtls[CV_BA_NAME_JOB_CODE]));
		}
		else
		{
			$this->db->where(array("login_user.".$graph_on.""=>$user_grade_level_dtls[$graph_on], "login_user.".CV_BA_NAME_JOB_CODE.""=>$user_grade_level_dtls[CV_BA_NAME_JOB_CODE]));
		}		
		
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{
			$this->db->order_by("Base_salary","asc");
			$this->db->order_by("Target_salary","asc");
			$this->db->order_by("Total_salary","asc");
		}		
		return $this->db->get()->result_array();		
	} 

	public function get_team_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id, $rule_user_ids)
	{	
		$this->db->select("row_owner.first_approver");
		$this->db->from("row_owner");
		$this->db->where(array("row_owner.upload_id"=>$upload_id, "row_owner.user_id" =>$uid));
		$user_first_approver = $this->db->get()->row_array()["first_approver"];

		if($user_first_approver)
		{
			$this->db->select("user_id");
			$this->db->from("row_owner");
			//$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$user_first_approver));
			$this->db->where(array( "first_approver"=>$user_first_approver));
			$this->db->where("user_id != '".$uid."' and user_id in (".$rule_user_ids.")" );
			$team_user_arr = $this->db->get()->result_array();
			
			if($team_user_arr)
			{
				$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

				$this->db->select("login_user.name, login_user.email, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, `final_salary`");
				$this->db->from("employee_salary_details");		
				$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
				$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
				$this->db->where_in("employee_salary_details.user_id",$team_user_ids);
				$this->db->order_by("final_salary","asc");
				return $this->db->get()->result_array();
			}
		}
	} 
	
	/*public function get_team_employee_salary_dtls_for_graph_new($rule_id, $uid, $upload_id, $order_by="")
	{	
		$this->db->select("row_owner.first_approver");
		$this->db->from("row_owner");
		$this->db->where(array("row_owner.upload_id"=>$upload_id, "row_owner.user_id" =>$uid));
		$user_first_approver = $this->db->get()->row_array()["first_approver"];

		if($user_first_approver)
		{
			$this->db->select("user_id");
			$this->db->from("row_owner");
			$this->db->where(array( "first_approver"=>$user_first_approver));
			$this->db->where("user_id != '".$uid."'" );
			$team_user_arr = $this->db->get()->result_array();
			
			if($team_user_arr)
			{
				$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);
				$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
								
				$qry = "login_user.name, login_user.email, (select (value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as Base_salary";
				if($company_dtls["target_sal_elem"])
				{
					$qry .= ", (select sum(value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["target_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Target_salary";
				}
				else
				{
					$qry .= ", (select '0') as Target_salary";
				}
				
				if($company_dtls["total_sal_elem"])
				{
					$qry .= ", (select sum(value + 0) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["total_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Total_salary";
				}
				else
				{
					$qry .= ", (select '0') as Total_salary";
				}
				
				$this->db->select($qry);
				$this->db->from("login_user");				
				$this->db->where_in("login_user.id",$team_user_ids);
				
				if($order_by)
				{
					$this->db->order_by($order_by);
				}
				else
				{
					$this->db->order_by("Base_salary","asc");
					$this->db->order_by("Target_salary","asc");
					$this->db->order_by("Total_salary","asc");
				}			
								
				return $this->db->get()->result_array();				
			}
		}
	}*/
	
	public function get_team_employee_salary_dtls_for_graph_new($rule_id, $uid, $order_by="")
	{	
		$this->db->select(CV_BA_NAME_APPROVER_1)->from("login_user")->where(array("id"=>$uid));
		$user_first_approver = $this->db->get()->row_array()[CV_BA_NAME_APPROVER_1];

		if($user_first_approver)
		{
			$this->db->select("id as user_id")->from("login_user")->where(array(CV_BA_NAME_APPROVER_1=>$user_first_approver));
			$this->db->where("id != '".$uid."'" );
			$team_user_arr = $this->db->get()->result_array();
			
			if($team_user_arr)
			{
				$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);
				$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
				$rule_dtls = $this->rule_model->get_table_row("hr_parameter", "salary_applied_on_elements", array("id"=>$rule_id));
				
				$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$rule_dtls["salary_applied_on_elements"].")");
				$temp_arr = array();
				foreach($ba_name_arr as $row)
				{
					$temp_arr[] = "login_user.".$row["ba_name"];
				}
				
				$qry = "login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL;
				$qry .= ", (".implode(" + ", $temp_arr).") as Base_salary";
				
				if($company_dtls["target_sal_elem"])
				{
					$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["target_sal_elem"].")");
					$temp_arr = array();
					foreach($ba_name_arr as $row)
					{
						$temp_arr[] = "login_user.".$row["ba_name"];
					}
					$qry .= ", (".implode(" + ", $temp_arr).") as Target_salary";
				}
				else
				{
					$qry .= ", (select '0') as Target_salary";
				}
				
				if($company_dtls["total_sal_elem"])
				{
					$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["total_sal_elem"].")");
					$temp_arr = array();
					foreach($ba_name_arr as $row)
					{
						$temp_arr[] = "login_user.".$row["ba_name"];
					}
					$qry .= ", (".implode(" + ", $temp_arr).") as Total_salary";
				}
				else
				{
					$qry .= ", (select '0') as Total_salary";
				}
				
				$this->db->select($qry.", (SELECT final_salary FROM employee_salary_details WHERE rule_id =".$rule_id." AND user_id = login_user.id) AS emp_revised_salary");
				$this->db->from("login_user");				
				$this->db->where_in("login_user.id",$team_user_ids);
				
				if($order_by)
				{
					$this->db->order_by($order_by);
				}
				else
				{
					$this->db->order_by("Base_salary","asc");
					$this->db->order_by("Target_salary","asc");
					$this->db->order_by("Total_salary","asc");
				}			

				return $this->db->get()->result_array();				
			}
		}
	}
	
	/*public function get_employee_market_salary_dtls_for_graph($rule_id, $uid, $upload_id)
	{		
		$this->db->select("ba_name, display_name, (value + 0) as value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
		$this->db->where(array("business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')));
		$this->db->order_by("value","asc");
		return $this->db->get()->result_array();
	}*/ 
	
	public function get_employee_market_salary_dtls_for_graph($rule_id, $uid)
	{		
		$temp_arr = array();
		$ba_name_arr = $this->get_salary_elements_list("ba_name, display_name", array("business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')));
		$users_dtls = $this->get_table_row("login_user", "*", array("id"=>$uid), "id desc");
		foreach($ba_name_arr as $row)
		{
			$temp_arr[] = array("ba_name"=>$row["ba_name"], "display_name"=>$row["display_name"], "value"=>$users_dtls[$row["ba_name"]]);
			
		}
		
		if($temp_arr)
		{
			$temp_arr = HLP_sort_multidimensional_array($temp_arr, 'value', SORT_ASC);		
		}
		return $temp_arr;
	}

    /*public function get_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id)
	{	
		$this->db->select("display_name, value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
		$this->db->where(array("business_attribute.module_name"=>CV_PREVIOUS_INCREMENTS));
		$this->db->where(array("business_attribute.status"=>1));
		$this->db->order_by("business_attribute.id","desc");
		return $this->db->get()->result_array();
	}*/
	public function get_employee_salary_dtls_for_graph($uid)
	{	
		$temp_arr = array();
		$ba_name_arr = $this->get_salary_elements_list("ba_name, display_name", array("business_attribute.module_name"=>CV_PREVIOUS_INCREMENTS, "business_attribute.status"=>1));
		$users_dtls = $this->get_table_row("login_user", "*", array("id"=>$uid), "id desc");
		foreach($ba_name_arr as $row)
		{
			if($row["ba_name"]=='salary_after_last_increase')
			{
				$effectiveDate='effective_date_of_last_salary_increase';
			}
			else if($row["ba_name"]=='salary_after_2nd_last_increase')
			{
				$effectiveDate='effective_date_of_2nd_last_salary_increase';
			}
			else if($row["ba_name"]=='salary_after_3rd_last_increase')
			{
				$effectiveDate='effective_date_of_3rd_last_salary_increase';
			}
			else if($row["ba_name"]=='salary_after_4th_last_increase')
			{
				$effectiveDate='effective_date_of_4th_last_salary_increase';
			}
			else if($row["ba_name"]=='salary_after_5th_last_increase')
			{
				$effectiveDate='effective_date_of_5th_last_salary_increase';
			}
			$temp_arr[] = array("display_name"=>$row["display_name"], "value"=>$users_dtls[$row["ba_name"]], "ba_name"=>$row["ba_name"],'effective_date'=>$users_dtls[$effectiveDate]);
		}
		if($temp_arr)
		{
			$temp_arr = HLP_sort_multidimensional_array($temp_arr, 'effective_date', SORT_ASC);
		}
		return $temp_arr;
	}

	public function get_ratings_list_as_per_rules_emp($condition_arr)
	{
		$this->db->select("mr.id, mr.name AS value");
		$this->db->from("salary_rule_users_dtls");
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id");
		$this->db->join("manage_rating_for_current_year mr", "login_user.".CV_BA_NAME_RATING_FOR_CURRENT_YEAR." = mr.id");		
		$this->db->where(array("mr.status" => CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$this->db->group_by("mr.id");
		$this->db->order_by("mr.order_no ASC, mr.name ASC");
		return $this->db->get()->result_array();
	}
	
    /* public function get_market_salary_header_list($condition_in_arr)
	{	
		$atti_ids = $this->array_value_recursive('id', $condition_in_arr);
		$this->db->select("distinct (`display_name_override`), business_attribute_id");
		$this->db->from("datum");
		//$this->db->where("data_upload_id",$upload_id);
		//return $this->db->where_in("business_attribute_id",$atti_ids)->group_by("display_name_override")->get()->result_array();
		return $this->db->where_in("business_attribute_id",$atti_ids)->get()->result_array();
	}*/	
	
	public function get_market_salary_header_list($condition_in_arr)
	{			
		$this->db->select("ba_name, display_name, id as business_attribute_id");
		$this->db->from("business_attribute");
		if($condition_in_arr)
		{
			$this->db->where($condition_in_arr);
		}
		$this->db->order_by("business_attribute.display_name","asc");		
		return $this->db->get()->result_array();
	}

	public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}

	public function get_salary_elements_list($select_fields, $condition_arr)
	{	
		$this->db->select($select_fields);
		$this->db->from("business_attribute");
		return $this->db->where($condition_arr)->get()->result_array();
	}

	/*public function get_managers_for_manual_bdgt($user_ids)
	{	
		$this->db->select("row_owner.id, row_owner.first_approver, (select login_user.name from login_user where login_user.email = row_owner.first_approver) as manager_name, (select value from datum where datum.data_upload_id = row_owner.upload_id and datum.row_num = row_owner.row_id and business_attribute_id = ". CV_CURRENCY_ID ."  ORDER BY row_owner.id DESC LIMIT 1) as currency_type");
		$this->db->from("row_owner");
		return $this->db->where(" row_owner.user_id in ($user_ids) and row_owner.first_approver != ''")->group_by("first_approver")->order_by("first_approver","asc")->get()->result_array();
	}*/
	
	public function get_managers_for_manual_bdgt($tbl_name, $rule_id)
	{	
		/*$this->db->select("DISTINCT(login_user.".CV_BA_NAME_APPROVER_1.") AS first_approver, (SELECT lu.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = login_user.".CV_BA_NAME_APPROVER_1.") AS manager_name, (SELECT manage_currency.name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, (SELECT name FROM manage_function mf WHERE mf.id = login_user." . CV_BA_NAME_FUNCTION . ") AS function_name, (SELECT name FROM manage_business_level_3 mbl3 WHERE mbl3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . ") AS bl3_name");
		$this->db->from("login_user");
		return $this->db->where("login_user.id IN (SELECT user_id FROM ".$tbl_name." WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1." != ''")->order_by("login_user.".CV_BA_NAME_APPROVER_1."","asc")->get()->result_array();*/
		return $this->db->query("SELECT DISTINCT(lu1.approver_1) AS first_approver, lu2.name AS manager_name, mc.name AS currency_type, mf.name AS function_name, mbl3.name AS bl3_name
FROM login_user AS lu1
JOIN ".$tbl_name." AS srud ON lu1.id = srud.user_id
LEFT JOIN login_user lu2 ON lu1.approver_1 = lu2.email
LEFT JOIN manage_currency AS mc ON mc.id = lu2.currency 
LEFT JOIN manage_function AS mf ON mf.id = lu2.function
LEFT JOIN manage_business_level_3 AS mbl3 ON mbl3.id = lu2.business_level_3
WHERE srud.rule_id = ".$rule_id." ORDER BY lu1.approver_1 ASC")->result_array();
	}

	/*public function get_managers_employees($condition_arr)
	{	
		$this->db->select("distinct (`user_id`)");
		$this->db->from("row_owner");
		$manager_emp_arr = $this->db->where($condition_arr)->get()->result_array();
		if(count($manager_emp_arr)>1)
		{
			return $this->array_value_recursive('user_id', $manager_emp_arr);
		}
		elseif(count($manager_emp_arr)==1)
		{
			return array($manager_emp_arr[0]["user_id"]) ;
		}
		else
		{
			return array();
		}
	}*/
	
	public function get_managers_employees($condition_arr)
	{	
		$this->db->select("DISTINCT(`id`)");
		$this->db->from("login_user");
		$manager_emp_arr = $this->db->where($condition_arr)->get()->result_array();
		if(count($manager_emp_arr)>1)
		{
			return $this->array_value_recursive('id', $manager_emp_arr);
		}
		elseif(count($manager_emp_arr)==1)
		{
			return array($manager_emp_arr[0]["id"]) ;
		}
		else
		{
			return array();
		}
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
	
	/*public function get_salary_applied_on_elememts_list($condition_in_arr)
	{			
		$this->db->select("display_name, business_attribute_id, datum.value");
		$this->db->from("datum");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		if($condition_in_arr)
		{
			$this->db->where($condition_in_arr);
		}
		$this->db->group_by("datum.business_attribute_id");
		$this->db->order_by("business_attribute.display_name","asc");		
		return $this->db->get()->result_array();
	}*/
	public function get_salary_applied_on_elememts_list($condition_in_arr)
	{			
		$this->db->select("display_name, id as business_attribute_id");
		$this->db->from("business_attribute");
		if($condition_in_arr)
		{
			$this->db->where($condition_in_arr);
		}
		$this->db->order_by("business_attribute.display_name","asc");		
		return $this->db->get()->result_array();
	}

	public function get_emp_currency_dtls($condition_in_arr)
	{			
		$this->db->select("manage_currency.id, manage_currency.name, manage_currency.display_name");
		$this->db->from("login_user");
		$this->db->join("manage_currency", "manage_currency.id = login_user.".CV_BA_NAME_CURRENCY."");
		if($condition_in_arr)
		{
			$this->db->where($condition_in_arr);
		}		
		return $this->db->get()->row_array();
	}	
	
	public function get_default_currency_for_rule($condition_in_arr)
	{			
		$this->db->select("".CV_BA_NAME_CURRENCY.", count(*) as counted");
		$this->db->from("login_user");		
		if($condition_in_arr)
		{
			$this->db->where($condition_in_arr);
		}
		$this->db->group_by(CV_BA_NAME_CURRENCY);
		$this->db->order_by("counted","desc");
		return $this->db->get()->row_array();
	}   
	
	public function get_salary_rules_for_comparison($condition_arr)
	{
		$this->db->select("id, salary_rule_name, salary_applied_on_elements, prorated_increase, overall_budget, manual_budget_dtls, managers_bdgt_dtls_for_tbl_head, performnace_based_hike, comparative_ratio, country, city, business_level1, business_level2, business_level3, functions, sub_functions, designations, grades, levels, educations, critical_talents, critical_positions, special_category, tenure_company, tenure_roles, (select name from manage_currency where manage_currency.id = hr_parameter.to_currency_id) as currency_name");
		$this->db->from("hr_parameter");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}

	
//********************** Adhoc Term Rule Functionality For Salary Rule Start **********************//

	public function get_emp_dtls($condition_arr)
	{			
		$this->db->select("login_user.id, login_user.name, login_user.email, login_user.upload_id, manage_designation.name as current_designation, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, (select first_approver from row_owner where row_owner.upload_id = login_user.upload_id and row_owner.user_id = login_user.id ORDER BY row_owner.id DESC LIMIT 1) as emp_manager");
		$this->db->from("login_user");		
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->where(array("login_user.status"=>1));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
	
	/*public function get_employee_salary_dtls_adhoc($condition_arr)
	{
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$qry = "login_user.id as user_id, login_user.name, login_user.email, login_user.upload_id, (select manage_designation.name from manage_designation where manage_designation.id = login_user.desig) as current_designation, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, (select first_approver from row_owner where row_owner.upload_id = login_user.upload_id and row_owner.user_id = login_user.id ORDER BY row_owner.id DESC LIMIT 1) as manager_emailid, (select row_num from tuple where tuple.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as row_num, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["target_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["total_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		
		$this->db->select($qry);
		$this->db->from("login_user");
		$this->db->where(array("login_user.status"=>1));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}*/
	
	public function get_employee_salary_dtls_adhoc($condition_arr)
	{
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$qry = "login_user.id as user_id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.upload_id, (select manage_designation.name from manage_designation where manage_designation.id = login_user.".CV_BA_NAME_DESIGNATION.") as current_designation, (SELECT manage_rating_for_current_year.name FROM manage_rating_for_current_year WHERE manage_rating_for_current_year.id = login_user.".CV_BA_NAME_RATING_FOR_CURRENT_YEAR.") AS performance_rating, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR.", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR.", login_user.".CV_BA_NAME_APPROVER_1." AS manager_emailid, login_user.".CV_BA_NAME_CURRENT_BASE_SALARY." AS Base_salary";
		if($company_dtls["target_sal_elem"])
		{			
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["target_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["total_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		
		$this->db->select($qry);
		$this->db->from("login_user");
		$this->db->where(array("login_user.status"=>1));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
	
	/*public function get_employee_salary_dtls_for_graph_adhoc($uid, $upload_id)
	{	
		$this->db->select("display_name, value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id,"user_id"=>$uid));
		$this->db->where(array("business_attribute.module_name"=>CV_PREVIOUS_INCREMENTS));
		$this->db->where(array("business_attribute.status"=>1));
		//$this->db->order_by("business_attribute.id","desc");
		$this->db->order_by("value","ASC");
		return $this->db->get()->result_array();
	}*/
	
	/*public function get_peer_employee_salary_dtls_for_graph_adhoc($uid, $upload_id, $graph_on=CV_GRADE, $order_by="")
	{	
		$this->db->select("id, grade, level");
		$this->db->from("login_user");
		$this->db->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();
		
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
								
		$qry = "login_user.name, login_user.email, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["target_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$qry .= ", (select sum(value) from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id in (". $company_dtls["total_sal_elem"] .") and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id) as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		$this->db->select($qry);
		$this->db->from("login_user");			
		$this->db->where("login_user.id != '".$uid."'");
		$this->db->where(array("login_user.status"=>1));
		if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.level"=>$user_grade_level_dtls["level"]));
		}
		else
		{
			$this->db->where(array("login_user.grade"=>$user_grade_level_dtls["grade"]));
		}
		
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{
			$this->db->order_by("Base_salary","asc");
			$this->db->order_by("Target_salary","asc");
			$this->db->order_by("Total_salary","asc");
		}
					
		return $this->db->get()->result_array();		
	}*/
	
	public function get_peer_employee_salary_dtls_for_graph_adhoc($uid, $graph_on=CV_GRADE, $order_by="")
	{	
		$this->db->select("id, grade, level")->from("login_user")->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();
		
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));

		$qry = "login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", login_user.".CV_BA_NAME_CURRENT_BASE_SALARY." AS Base_salary";
		if($company_dtls["target_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["target_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Target_salary";
		}
		else
		{
			$qry .= ", (select '0') as Target_salary";
		}
		
		if($company_dtls["total_sal_elem"])
		{
			$ba_name_arr = $this->get_salary_elements_list("ba_name", "id IN(".$company_dtls["total_sal_elem"].")");
			$temp_arr = array();
			foreach($ba_name_arr as $row)
			{
				$temp_arr[] = "login_user.".$row["ba_name"];
			}
			$qry .= ", (".implode(" + ", $temp_arr).") as Total_salary";
		}
		else
		{
			$qry .= ", (select '0') as Total_salary";
		}
		
		$this->db->select($qry);
		$this->db->from("login_user");			
		$this->db->where("login_user.id != '".$uid."'");
		$this->db->where(array("login_user.status"=>1));
		if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.level"=>$user_grade_level_dtls["level"]));
		}
		else
		{
			$this->db->where(array("login_user.grade"=>$user_grade_level_dtls["grade"]));
		}
		
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{
			$this->db->order_by("Base_salary","asc");
			$this->db->order_by("Target_salary","asc");
			$this->db->order_by("Total_salary","asc");
		}

		return $this->db->get()->result_array();		
	}
	
//********************** Adhoc Term Rule Functionality For Salary Rule End **********************//


//************ Start : Below Functions are not in use, but need to confirm before removing them ************//
	public function getCurrency($condition_arr)
	{
		$this->db->select("(select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
		$this->db->from("proposed_rnr_dtls");
		$this->db->join("login_user","login_user.id = proposed_rnr_dtls.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}
	
	public function get_peer_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id, $rule_user_ids, $graph_on=CV_GRADE)
	{	
		$this->db->select("id, grade, level");
		$this->db->from("login_user");
		$this->db->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();

		$this->db->select("login_user.name, login_user.email, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, `final_salary`");
		$this->db->from("employee_salary_details");	
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->where("login_user.id != '".$uid."' and login_user.id in (".$rule_user_ids.")");
		if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.level"=>$user_grade_level_dtls["level"]));
		}
		else
		{
			$this->db->where(array("login_user.grade"=>$user_grade_level_dtls["grade"]));
		}
		$this->db->order_by("final_salary","asc");
		return $this->db->get()->result_array();		
	} 
	
	public function get_user_performance_ratings($user_id, $upload_id, $row_no, $condition_arr=array())
	{
		if($condition_arr)
		{
			$rating_elements_list = $this->get_salary_elements_list("id", $condition_arr);
		}

		/*$this->db->select("*");
		$this->db->from("tuple");
		$user_tuple_dtls = $this->db->where(array("tuple.user_id"=>$user_id))->order_by("id","desc")->get()->row_array();*/

		$this->db->select("datum.*");
		$this->db->from("datum");
		if(isset($rating_elements_list) and ($rating_elements_list))
		{
			return $this->db->where(array("datum.row_num"=>$row_no, "datum.data_upload_id"=>$upload_id, "datum.business_attribute_id"=>$rating_elements_list[0]["id"]))->get()->result_array();
		}
		else
		{
			return $this->db->where(array("datum.row_num"=>$row_no, "datum.data_upload_id"=>$upload_id))->get()->result_array();
		}
	}
	
	public function get_salary_applied_on_elements_val($upload_id, $row_no, $ba_ids)
	{
		$ba_ids_arr = explode(",",$ba_ids);
		$this->db->select("datum.*");
		$this->db->from("datum");
		$this->db->where(array("datum.row_num"=>$row_no, "datum.data_upload_id"=>$upload_id));
		$this->db->where_in("business_attribute_id",$ba_ids_arr);
		$this->db->order_by("business_attribute_id","asc");
		return $this->db->get()->result_array();
	}

	public function get_user_cell_value_frm_datum($upload_id, $row_no, $condition_arr=array())
	{
		$this->db->select("datum.*");
		$this->db->from("datum");
		return $this->db->where(array("data_upload_id"=>$upload_id, "row_num"=>$row_no))->where($condition_arr)->get()->row_array();
	}

	public function get_performance_cycles_for_api($condition_arr)
	{
		$this->db->select("performance_cycle.id,performance_cycle.name, ");
		$this->db->from("performance_cycle");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("performance_cycle.id asc");
		return $this->db->get()->result_array();
	}

//************ End : Below Functions are not in use, but need to confirm before removing them ************//
	public function get_salary_applied_on_elememts_list_new($condition_in_arr) {
		$this->db->select("display_name, id as business_attribute_id");
		$this->db->from("business_attribute");
		if ($condition_in_arr) {
			$this->db->where($condition_in_arr);
		}
		$this->db->order_by("business_attribute.ba_attributes_order", "asc");
		return $this->db->get()->result_array();
	}  



	/*public function check_hr_permission_on_salary_dtls($rule_id)
	{
		$this->db->select("count(hp.id) as count_is_hr_vaild");
		$this->db->from("hr_parameter hp");
		$this->db->join("employee_salary_details esd","hp.id =esd.rule_id");	
		$this->db->where(array("hp.id"=>$rule_id,"hp.status"=>6,"esd.`status`!="=>5));
		
		return $this->db->get()->row_array();
	}*/
public function update_salary_rule_users_dtls_data($data, $rule_id) {
        $this->db->where("rule_id", $rule_id);
        $this->db->update_batch('employee_salary_details', $data, 'user_id');
    }


   /* public function allManager($ruleID)
	{
		$tempArr =	array();
		$manager_email = $this->session->userdata('email_ses');
		
		$this->db->select("employee_salary_details.last_action_by,employee_salary_details.manager_name,hr_parameter.manual_budget_dtls, (SELECT lu.name FROM login_user lu WHERE lu.email = `employee_salary_details`.`last_action_by`) AS last_action_by_name");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter","hr_parameter.id = employee_salary_details.rule_id");
		//$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		$this->db->where(array("employee_salary_details.rule_id"=>$ruleID));
		$this->db->order_by("employee_salary_details.emp_name asc");
		$this->db->group_by("employee_salary_details.last_action_by");
		$tempArr = $this->db->get()->result_array();	
		return $tempArr;	
		
	}*/
	
	public function allManager($whr_cnd)
	{
		//$this->db->select("employee_salary_details.approver_1 AS approver_1_email, (SELECT lu.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user lu WHERE lu." . CV_BA_NAME_EMP_EMAIL . " = `employee_salary_details`.`approver_1`) AS approver_1_name");
		$this->db->select("LOWER(employee_salary_details.approver_1) AS m_email, (SELECT lu.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user lu WHERE lu." . CV_BA_NAME_EMP_EMAIL . " = `employee_salary_details`.`approver_1`) AS m_name, (SELECT manage_function.name FROM manage_function WHERE manage_function.id = (SELECT lu.function FROM login_user lu WHERE lu.email = `employee_salary_details`.`approver_1`)) AS m_function_name");
		$this->db->from("employee_salary_details");
		$this->db->where($whr_cnd);
		//$this->db->order_by("approver_1_name ASC");
		$this->db->order_by("m_name ASC");
		$this->db->group_by("employee_salary_details.approver_1");
		return $this->db->get()->result_array();
	}

	public function get_currency_rate_dtls()
	{
		$currency_rate_dtls = $this->db->query("SELECT CONCAT(\"{\", GROUP_CONCAT('\"',UPPER(manage_currency.name),'\":', '\"',currency_rates.rate,'\"'), \"}\") AS json_obj FROM currency_rates JOIN manage_currency on manage_currency.id = currency_rates.to_currency WHERE currency_rates.from_currency=1;")->row_array();
		return json_decode($currency_rate_dtls["json_obj"], true);
	}
	
	public function get_rule_wise_emp_increment_list_for_hr_manager($whr_cnd,$limit='', $start='')
	{
		$this->db->select("employee_salary_details.user_id AS id, employee_salary_details.emp_name AS name, employee_salary_details.email_id AS email, employee_salary_details.increment_applied_on_salary, employee_salary_details.final_salary, employee_salary_details.market_salary, employee_salary_details.final_salary, employee_salary_details.id as tbl_pk_id, employee_salary_details.rule_id,
		employee_salary_details.mkt_salary_after_promotion,
		employee_salary_details.crr_after_promotion,
		employee_salary_details.quartile_range_name_after_promotion,
		employee_salary_details.final_merit_hike,
		employee_salary_details.final_market_hike,		
		employee_salary_details.rating_last_year,
		employee_salary_details.rating_2nd_last_year,
		employee_salary_details.rating_3rd_last_year,
		employee_salary_details.rating_4th_last_year,
		employee_salary_details.rating_5th_last_year,		
		employee_salary_details.min_salary_for_penetration,
		employee_salary_details.max_salary_for_penetration,
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
		employee_salary_details.comments,
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
		employee_salary_details.letter_status,
		employee_salary_details.country,
		employee_salary_details.sub_function as subfunction,
		employee_salary_details.manager_emailid, (SELECT login_user.".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.".CV_BA_NAME_EMP_EMAIL." = employee_salary_details.last_action_by) AS last_manager_name, (SELECT login_user.employee_code FROM login_user WHERE login_user.id = employee_salary_details.user_id) as employee_code, employee_salary_details.status as req_status, employee_salary_details.approver_1 AS first_approver, employee_salary_details.approver_2 AS second_approver, employee_salary_details.approver_3 AS third_approver, employee_salary_details.approver_4 AS fourth_approver, employee_salary_details.joining_date_for_increment_purposes AS date_of_joining, employee_salary_details.crr_val AS current_crr
		, srud.recently_promoted, srud.performance_achievement, srud.salary_after_last_increase, srud.total_salary_after_last_increase, srud.target_salary_after_last_increase, srud.previous_talent_rating, srud.promoted_in_2_yrs, srud.successor_identified, srud.readyness_level, srud.urban_rural_classification, srud.other_data_9, srud.other_data_10, srud.other_data_11, srud.other_data_12, srud.other_data_13, srud.other_data_14, srud.other_data_15, srud.other_data_16, srud.other_data_17, srud.other_data_18, srud.other_data_19, srud.other_data_20");
		$this->db->from("employee_salary_details");
		$this->db->join("salary_rule_users_dtls srud", "(srud.rule_id = employee_salary_details.rule_id AND srud.user_id = employee_salary_details.user_id)");
		$this->db->where($whr_cnd);
		$this->db->order_by("employee_salary_details.last_action_by asc");
		$this->db->order_by("employee_salary_details.emp_name asc");
		if($limit!='' && $start!=''){
			$this->db->limit($limit, $start);
		}
		return $this->db->get()->result_array();
	}
	//Piy@4Jan20
	public function get_ba_list_to_categorywise_salary_rpt() {
		return   $this->db->query("select id,ba_name,display_name from business_attribute where status=1 and id in (".CV_BA_ID_COUNTRY.", ".CV_BA_ID_CITY.", ".CV_BUSINESS_LEVEL_ID_1.", ".CV_BUSINESS_LEVEL_ID_2.", ".CV_BUSINESS_LEVEL_ID_3.", "
		.CV_FUNCTION_ID.", ".CV_GRADE_ID.",".CV_LEVEL_ID.",135,". CV_SECOND_APPROVER_ID.",".CV_THIRD_APPROVER_ID.",".CV_FOURTH_APPROVER_ID."
			 ) order by display_name ASC")->result_array();
		//.CV_FIRST_APPROVER_ID."," ,  ".CV_EDUCATION_ID." ".CV_DESIGNATION_ID.",".CV_SUB_FUNCTION_ID.", ".CV_SUB_SUB_FUNCTION_ID.",, 154, 50, 51, 52, 75, 77, 76, 78, 80, 79, 81, 83, 82, 84, 86, 85, 87, 89, 88, 90, 92, 91, 93, 95, 94, 96, 98, 97, 99, 101, 100, 102, 104, 103, 105, 107, 106, 108, 110, 109
	} 

	public function get_attributeswise_bdgt_manager_detail( $condition_arr)
	{
		
        $this->db->select("login_user.`email`,login_user.`name` as approver,manage_function.name as function");
        $this->db->from('login_user');
		$this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
		$this->db->where(array("login_user.status" => CV_STATUS_ACTIVE));
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
		$result=[];
		foreach ($this->db->get()->result() as $key => $value) {
			$result[$value->email]=['name'=>$value->approver,'function'=>$value->function];
		}
		return $result;
    }	
	public function get_attributeswise_bdgt_sum_report_NIU($rule_id, $to_currency_id, $budget_type, $table_name)
	{
		if ($budget_type == 'Automated but x% can exceed') {
			$sql = "SELECT 'Total' as `ba_groupon`, 
        		count(`user_id`) as 'noofemployees' ,
        		sum( `increment_applied_on_salary`* rate) as 'current_salary',
        		sum((`additional_budget`)* rate) as 'additional_budget_amount',
        		sum(`budget_plan` * rate) as 'budget_plan',
        		sum(`emp_final_bdgt`* rate)/ sum(`increment_applied_on_salary` * rate) *100 as 'final_salary_per',
        		sum(`emp_final_bdgt`* rate) as 'final_salary_amount' 
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}	";
		} else {
			$sql = "SELECT 'Total' as `ba_groupon`, 
    		count(`user_id`) as 'noofemployees' ,
    		sum( `increment_applied_on_salary` * rate) as 'current_salary',
    		sum(`emp_final_bdgt` * rate) as 'budget_plan',
    		sum(`emp_final_bdgt` * rate)/sum( `increment_applied_on_salary` * rate)*100 as 'final_salary_per', 
    		sum(`emp_final_bdgt` * rate) as 'final_salary_amount' 
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
			";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_attributeswise_bdgt_report_NIU($rule_id, $to_currency_id, $for_attributes = 'approver_1', $budget_type, $table_name)
	{
		if ($budget_type == 'Automated but x% can exceed') {
			$sql = "SELECT `{$for_attributes}` as `ba_groupon`, 
        	count(`user_id`) as 'noofemployees' ,
        		sum( `increment_applied_on_salary`* rate) as 'current_salary',
        		sum((`additional_budget`)* rate) as 'additional_budget_amount',
        		sum(`budget_plan` * rate) as 'budget_plan',
        		sum(`emp_final_bdgt` * rate )/ sum(`increment_applied_on_salary` * rate) * 100 as 'final_salary_per',
        		sum(`emp_final_bdgt`* rate) as 'final_salary_amount' 
        		FROM `{$table_name}` as esd 
					JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
					JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
				GROUP BY `{$for_attributes}` ";
		} else {
			$sql = "SELECT `{$for_attributes}` as `ba_groupon`, 
			count(`user_id`) as 'noofemployees' ,
			sum( `increment_applied_on_salary` * rate) as 'current_salary',
			sum(`emp_final_bdgt` * rate) as 'budget_plan',
			sum(`emp_final_bdgt` * rate)/sum( `increment_applied_on_salary` * rate)*100 as 'final_salary_per', 
			sum(`emp_final_bdgt` * rate) as 'final_salary_amount' 
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
			GROUP BY `{$for_attributes}`";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_attributeswise_bdgt_sum_report($rule_id, $to_currency_id, $budget_type, $table_name)
	{
		if ($budget_type == 'Automated but x% can exceed') {
			$sql = "SELECT 'Total' as `ba_groupon`, 
        		count(`user_id`) as 'noofemployees' ,
        		sum( `increment_applied_on_salary`* rate) as 'current_salary',
        		SUM(`additional_budget`) AS 'additional_budget_amount',
        		sum(`budget_plan` * rate) as 'budget_plan',
        		SUM((`additional_budget` + (`budget_plan`* rate)))/ SUM(`increment_applied_on_salary` * rate) *100 AS 'final_salary_per',
        		SUM((`additional_budget` + (`budget_plan`* rate))) AS 'final_salary_amount'
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}	";
		} else {
			$sql = "SELECT 'Total' as `ba_groupon`, 
    		count(`user_id`) as 'noofemployees' ,
    		sum( `increment_applied_on_salary` * rate) as 'current_salary',
    		sum(`emp_final_bdgt` * rate) as 'budget_plan',
    		sum(`emp_final_bdgt` * rate)/sum( `increment_applied_on_salary` * rate)*100 as 'final_salary_per', 
    		sum(`emp_final_bdgt` * rate) as 'final_salary_amount' 
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
			";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_attributeswise_bdgt_report($rule_id, $to_currency_id, $for_attributes = 'approver_1', $budget_type, $table_name)
	{
		if ($budget_type == 'Automated but x% can exceed') {
			$sql = "SELECT `{$for_attributes}` as `ba_groupon`, 
        	count(`user_id`) as 'noofemployees' ,
        		sum( `increment_applied_on_salary`* rate) as 'current_salary',
        		SUM((`additional_budget`)) AS 'additional_budget_amount',
        		sum(`budget_plan` * rate) as 'budget_plan',
        		SUM((`additional_budget` + (`budget_plan`* rate)))/ SUM(`increment_applied_on_salary` * rate) *100 AS 'final_salary_per',
        		SUM((`additional_budget` + (`budget_plan`* rate))) AS 'final_salary_amount' 
        		FROM `{$table_name}` as esd 
					JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
					JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
				GROUP BY `{$for_attributes}` ";
		} else {
			$sql = "SELECT `{$for_attributes}` as `ba_groupon`, 
			count(`user_id`) as 'noofemployees' ,
			sum( `increment_applied_on_salary` * rate) as 'current_salary',
			sum(`emp_final_bdgt` * rate) as 'budget_plan',
			sum(`emp_final_bdgt` * rate)/sum( `increment_applied_on_salary` * rate)*100 as 'final_salary_per', 
			sum(`emp_final_bdgt` * rate) as 'final_salary_amount' 
			FROM `{$table_name}` as esd 
				JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
				JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
			GROUP BY `{$for_attributes}`";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function set_attributeswise_bdgt_insert_temp_report($rule_id, $show_prorated_current_sal, $for_attributes, $table_name,$approverfld='approver_1')
	{
		$emp_current_salary_col = "`increment_applied_on_salary`";
		if($show_prorated_current_sal == 1)
		{
			$emp_current_salary_col = "`increment_applied_on_salary` * `proreta_multiplier`";
		}
		/*$sql = "INSERT INTO `{$table_name}` (`budget_plan`, `additional_budget`,`{$for_attributes}`,`first_approver`, `user_id`,  `increment_applied_on_salary`, `emp_final_bdgt`,`approver`,`performnace_based_increment`,`crr_based_increment`,`currency`) 
		SELECT ((`increment_applied_on_salary`)*(`crr_based_increment`+`performnace_based_increment`)/100) ,0,`{$for_attributes}`,`approver_1`, `user_id`, ".$emp_current_salary_col.", `emp_final_bdgt`, `{$approverfld}`,`performnace_based_increment`,`crr_based_increment`,`currency` FROM `employee_salary_details` where `rule_id`={$rule_id} and 
		`user_id` not in (select `user_id` from `{$table_name}`)";*/
		$sql = "INSERT INTO `{$table_name}` (`budget_plan`, `additional_budget`,`{$for_attributes}`,`first_approver`, `user_id`,  `increment_applied_on_salary`, `emp_final_bdgt`,`approver`,`performnace_based_increment`,`crr_based_increment`,`currency`, emp_currency_rate) 
		SELECT ((`increment_applied_on_salary`)*(`crr_based_increment`+`performnace_based_increment`)/100) ,0,`{$for_attributes}`,`approver_1`, `user_id`, ".$emp_current_salary_col.", `emp_final_bdgt`, `{$approverfld}`,`performnace_based_increment`,`crr_based_increment`,`currency`, `emp_currency_conversion_rate` FROM `employee_salary_details` where `rule_id`={$rule_id} and 
		`user_id` not in (select `user_id` from `{$table_name}`)";
		$query = $this->db->query($sql);
	}
	
	//Piy@9Jan

	public function get_increment_distribution_bdgt_report($rule_id, $show_prorated_current_sal, $to_currency_id,$budget_type,$cond='')
	{
		$emp_current_salary_col = "`increment_applied_on_salary`";
		if($show_prorated_current_sal == 1)
		{
			$emp_current_salary_col = "`increment_applied_on_salary` * `proreta_multiplier`";
		}
		$sql="select sum(".$emp_current_salary_col." * rate) as current_salary from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} {$cond}";
		$ret['current_salary'] = $this->db->query($sql)->row()->current_salary;

		$sql="select 'Merit as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary`  * performnace_based_increment / 100) * rate) as amount from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and performnace_based_increment>0 {$cond}";
		$ret['result']['merit'] = $this->db->query($sql)->row_array();

		$sql="select 'Promotion as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary`  * sp_manager_discretions  / 100) * rate) as amount from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and sp_manager_discretions >0 {$cond}";
		$ret['result']['promotion'] = $this->db->query($sql)->row_array(); 

		$sql="select 'Market Correction as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary`  * crr_based_increment / 100) * rate) as amount from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and crr_based_increment>0 {$cond}";
		$ret['result']['market'] = $this->db->query($sql)->row_array();
		
		if ($budget_type == 'Automated but x% can exceed') {
		$sql="select 'Additional allocated' as name,count(user_id) as cnt,sum((emp_final_bdgt-(`increment_applied_on_salary`*(`crr_based_increment`+`performnace_based_increment`)/100)) * rate) as amount from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} {$cond}";	
		$ret['result']['additional'] = $this->db->query($sql)->row_array();
		}
		return $ret;
	}
	//Piy@3Jan20
	public function get_attributeswise_dashboard_bdgt_report($rule_id,$to_currency_id,$for_attributes='approver_1',$table_name='`employee_salary_details`',$cond='')
	{
		$sql="SELECT esd.`{$for_attributes}` as `ba_groupon`,
		count(user_id) as noofemployees,
		sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`,
		sum(`sp_increased_salary`) as `sp_increased_salary`,
		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution`
		FROM {$table_name} as esd
			JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
			JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		WHERE  `rule_id`= {$rule_id} and esd.`status` < 5 GROUP by esd.`{$for_attributes}`";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function set_attributeswise_dashboard_bdgt_insert_temp_report($rule_id, $for_attributes, $table_name,$approverfld='approver_1')
	{
		$sql = "INSERT INTO `{$table_name}` (`{$for_attributes}`, `user_id`, `increment_applied_on_salary`, `emp_final_bdgt`,`approver`,`final_salary`,`sp_increased_salary`,`currency`,`emp_performance_rating`,`manager_discretions`,`status`,`rule_id`) 
		SELECT `{$for_attributes}`, `user_id`, `increment_applied_on_salary`, `emp_final_bdgt`, `{$approverfld}`,`final_salary`,`sp_increased_salary`,`currency`,`emp_performance_rating`,`manager_discretions`,`status`,`rule_id` FROM `employee_salary_details` where `rule_id`={$rule_id} and 
		`user_id` not in (select `user_id` from `{$table_name}`)";
		$query = $this->db->query($sql);
	}
	
	//Piy@3Jan20
	public function get_attributeswise_dashboard_bdgt_budget_count($rule_id,$to_currency_id,$cond='')
	{
		$sql="SELECT sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`		
		FROM `employee_salary_details` as esd
			JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
			JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		WHERE  `rule_id`= {$rule_id} and esd.`status` < 5 ";
		return $this->db->query($sql)->row();
	}
	//Piy@10Jan20
	public function get_increment_distribution_dashboard_bdgt_report($rule_id, $to_currency_id,$budget_type,$cond='')
	{
		$sql="select sum(`increment_applied_on_salary` * rate) as current_salary,
		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution` from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} {$cond}";
		$ret['current_salary'] = $this->db->query($sql)->row()->current_salary;

		$sql="select 'Merit as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary` * final_merit_hike / 100) * rate) as amount,
		sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`,

		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution` from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and final_merit_hike>0 {$cond}";
		$ret['result']['merit'] = $this->db->query($sql)->row_array();

		$sql="select 'Promotion as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary` * sp_manager_discretions  / 100) * rate) as amount,
		sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`,
		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution` from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and sp_manager_discretions >0 {$cond}";
		$ret['result']['promotion'] = $this->db->query($sql)->row_array(); 

		$sql="select 'Market Correction as per rule' as name,count(user_id) as cnt,sum((`increment_applied_on_salary` * final_market_hike / 100) * rate) as amount,
		sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`,
		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution` from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} and final_market_hike>0 {$cond}";
		$ret['result']['market'] = $this->db->query($sql)->row_array();
		
		if ($budget_type == 'Automated but x% can exceed') {
		$sql="select 'Additional allocated' as name,count(user_id) as cnt,sum((emp_final_bdgt-(`increment_applied_on_salary`*(`crr_based_increment`+`performnace_based_increment`)/100)) * rate) as amount,
		sum(`emp_final_bdgt`*rate) as `allocated_budget`,
		sum(((`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `utilized_budget`,
		sum((`emp_final_bdgt`-(`final_salary`-`increment_applied_on_salary` {$cond}) )*rate) as `available_budget`,
		GROUP_CONCAT(`emp_performance_rating`) as `rating_name`,
		GROUP_CONCAT(`manager_discretions`) as `rating_distribution` from employee_salary_details as esd
		JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(esd.currency)
		JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}
		where `rule_id`={$rule_id} {$cond}";	
		$ret['result']['additional'] = $this->db->query($sql)->row_array();
		}
		return $ret;
	}

	public function get_attributeswise_dashboard_bdgt_approval_lists($rule_id)
	{
		return $this->db->query("Select status, count(*) as count from employee_salary_details where rule_id=$rule_id AND status < 5  group by status")->result_array();
	}
	public function get_attributeswise_dashboard_bdgt_approval_count($rule_id)
	{
		return $this->db->query("select esd.manager_emailid,esd.id, count(esd.id) as count,lu.name from employee_salary_details as esd LEFT JOIN login_user as lu on lu.email = esd.manager_emailid where esd.rule_id=$rule_id and  esd.status < 5 group by esd.manager_emailid")->result_array();
	}
	public function get_attributeswise_dashboard_bdgt_performance_rating($rule_id)
	{
		return $this->db->query("SELECT e.performance_rating,count(e.performance_rating) as count,sum(e.manager_discretions) as ratting_total,count(e.manager_discretions) as ratting_count,sum(e.increment_applied_on_salary*e.manager_discretions/100) as amount_total FROM `employee_salary_details` as e LEFT JOIN manage_rating_for_current_year as r ON  e.performance_rating=r.name WHERE e.`rule_id` ={$rule_id} and e.status < 5 GROUP by performance_rating order by r.order_no")->result();		
	}
	
	public function get_table_object($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
		$this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->result();		
	}

	public function get_table_row_object($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
		$this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->row();		
	}
	//Piy End

	/* save candidate offer rule */
	public function insert_candidate_offer_rules($data)
	{
		$this->db->insert("hr_candidate_offer_parameter",$data);
		return $this->db->insert_id();
	}

	/* update candidate offer rule */
	public function update_candidate_offer_rules($setData, $condition_arr)
	{
		$this->db->where($condition_arr);
		$this->db->update('hr_candidate_offer_parameter', $setData);
		return true;
	}

	/*
	* get rule details with performance cycle
	*/

	public function get_rule_dtls_with_plan($condition_arr) {

		$this->db->select("hr_parameter.id, hr_parameter.salary_rule_name, hr_parameter.performance_cycle_id");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle","performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->where($condition_arr);
		return $this->db->get()->result_array();

	}
	//piy@25feb on increment filter search
	public function get_users_name($rule_id,$fldName,$query)
    {
        if($this->session->userdata('role_ses'))
        {
		 	$query = $this->db->query("SELECT DISTINCT {$fldName} as text,{$fldName} as value FROM salary_rule_users_dtls WHERE rule_id={$rule_id} and {$fldName} LIKE '{$query}%'");    
			return json_encode($query->result());

        }
    }
	
	/**** Start :: To get all approver 1 budget details For Admin/HR Side For Salary Rule Increment Page ****/
	public function get_all_approver1_bdgt_dtls_for_increment_list_hr($rule_id, $include_promotion_bdgt, $whr_cnd)
    {
		$is_data_exist = $this->db->query("SELECT rule_id FROM `employee_salary_details_rows` WHERE rule_id = ".$rule_id.";")->row_array();
		if(!$is_data_exist)
		{
			$this->db->query("INSERT INTO employee_salary_details_rows(email_id,approver_1,rule_id)
SELECT DISTINCT approver_1,approver_1,rule_id  FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_2,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_3,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_4,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id.";");
		}
		
		$qry = "SELECT  employee_salary_details.approver_1 AS m_email, lu1.name AS m_name, mf1.name AS m_function_name,
IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - 
(sp_increased_salary*emp_currency_conversion_rate))) AS manager_total_used_bdgt,
SUM(emp_final_bdgt*emp_currency_conversion_rate) AS manager_total_bdgt,  
SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_allocated_bdgt, 
SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_allocated_bdgt, 
SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_used_bdgt, 
SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_used_bdgt, 
SUM(sp_increased_salary*emp_currency_conversion_rate) AS m_direct_emps_promotion_used_bdgt, 
SUM(increment_applied_on_salary*emp_currency_conversion_rate) AS m_direct_emps_current_total_salary 
FROM employee_salary_details
INNER JOIN (
SELECT DISTINCT LOWER(e1.approver_1) AS email_id, 
lu1.`name` AS m_name, 
mf1.name AS m_function_name 
FROM `employee_salary_details` e1
LEFT OUTER JOIN login_user lu1 ON e1.`approver_1`=lu1.`email`
LEFT OUTER JOIN manage_function mf1 ON lu1.`function`=mf1.`id`
WHERE `e1`.`rule_id` = ".$rule_id." 
GROUP BY LOWER(e1.approver_1)
) a ON employee_salary_details.approver_1=a.email_id
LEFT OUTER  JOIN login_user lu1 ON employee_salary_details.`approver_1`=lu1.`email`
LEFT OUTER  JOIN manage_function mf1 ON lu1.`function`=mf1.`id`
WHERE ".$whr_cnd."
GROUP BY employee_salary_details.approver_1
ORDER BY m_name ASC;";
		return $this->db->query($qry)->result_array();
	}
	/**** End :: To get all approver 1 budget details For Admin/HR Side For Salary Rule Increment Page ****/
	
	/* Start::To get all approver 1 budget details with Accmulation For Admin/HR Side For Salary Increment Page */
	public function get_all_approver1_accumulated_bdgt_dtls_for_increment_list_hr($rule_id, $include_promotion_bdgt, $whr_cnd)
    {
		$qry = "SELECT  employee_salary_details.approver_1 AS m_email,
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.manager_total_used_bdgt ELSE
IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - (sp_increased_salary*emp_currency_conversion_rate))) 
END) AS manager_total_used_bdgt,
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.manager_total_bdgt ELSE
SUM(emp_final_bdgt*emp_currency_conversion_rate) END) AS manager_total_bdgt,  
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_merit_allocated_bdgt ELSE
SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) END) AS m_direct_emps_merit_allocated_bdgt, 
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_market_allocated_bdgt ELSE
SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01)  END)AS m_direct_emps_market_allocated_bdgt, 
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_merit_used_bdgt ELSE
SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) END) AS m_direct_emps_merit_used_bdgt, 
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_market_used_bdgt ELSE
SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01)END) AS m_direct_emps_market_used_bdgt, 
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_promotion_used_bdgt ELSE
SUM(sp_increased_salary*emp_currency_conversion_rate) END) AS m_direct_emps_promotion_used_bdgt, 
(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_current_total_salary ELSE
SUM(increment_applied_on_salary*emp_currency_conversion_rate)END) AS m_direct_emps_current_total_salary 
FROM employee_salary_details
INNER JOIN (
SELECT DISTINCT 
ChildUserType.email_id,ParentUserType.approver_1
FROM employee_salary_details_rows ChildUserType
LEFT JOIN employee_salary_details_rows ParentUserType ON ChildUserType.approver_1 = ParentUserType.email_id
INNER JOIN (
SELECT DISTINCT LOWER(e1.approver_1) AS email_id 
FROM `employee_salary_details` e1
WHERE `e1`.`rule_id` = ".$rule_id." 
GROUP BY LOWER(e1.approver_1)
) c ON ParentUserType.approver_1=c.email_id
AND  ParentUserType.rule_id=".$rule_id."
) a  ON employee_salary_details.approver_1=a.email_id
LEFT OUTER JOIN 
(SELECT   a.approver_1,employee_salary_details.approver_1 AS m_email,
IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - (sp_increased_salary*emp_currency_conversion_rate))) AS manager_total_used_bdgt,
SUM(emp_final_bdgt*emp_currency_conversion_rate) AS manager_total_bdgt,  
SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_allocated_bdgt, 
SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_allocated_bdgt, 
SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_used_bdgt, 
SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_used_bdgt, 
SUM(sp_increased_salary*emp_currency_conversion_rate) AS m_direct_emps_promotion_used_bdgt, SUM(increment_applied_on_salary*emp_currency_conversion_rate) AS m_direct_emps_current_total_salary 
FROM employee_salary_details
INNER JOIN (
SELECT DISTINCT 
ChildUserType.email_id,ParentUserType.approver_1
FROM employee_salary_details_rows ChildUserType
LEFT JOIN employee_salary_details_rows ParentUserType ON ChildUserType.approver_1 = ParentUserType.email_id
INNER JOIN (
SELECT DISTINCT LOWER(e1.approver_1) AS email_id
FROM `employee_salary_details` e1
WHERE `e1`.`rule_id` = ".$rule_id." 
GROUP BY LOWER(e1.approver_1)
) c ON ParentUserType.approver_1=c.email_id
AND  ParentUserType.rule_id=".$rule_id."
) a ON employee_salary_details.approver_1=a.email_id
WHERE employee_salary_details.rule_id=".$rule_id."
GROUP BY a.approver_1 ) b ON employee_salary_details.approver_1=b.approver_1
WHERE ".$whr_cnd." 
GROUP BY employee_salary_details.approver_1;";
			
		$managers_accumulated_arr = $this->db->query($qry)->result_array();
		$tmp_arr = array();
		foreach($managers_accumulated_arr as $row)
		{
			$tmp_arr[$row["m_email"]] = $row;
		}			
		return $tmp_arr;
	}
	/* End::To get all approver 1 budget details with Accmulation For Admin/HR Side For Salary Increment Page */	
	
	/* Start :: To get Current Manager & Downline Budget dtls For Salary Rule Increment Page */
	public function get_current_manager_n_downline_bdgt_dtls_for_increment_list_manager($rule_id, $include_promotion_bdgt, $m_email, $m_name)
    {
		$is_data_exist = $this->db->query("SELECT rule_id FROM `employee_salary_details_rows` WHERE rule_id = ".$rule_id.";")->row_array();
		if(!$is_data_exist)
		{
			$this->db->query("INSERT INTO employee_salary_details_rows(email_id,approver_1,rule_id)
SELECT DISTINCT approver_1,approver_1,rule_id  FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_2,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_3,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id."
UNION ALL
SELECT DISTINCT approver_1,approver_4,rule_id FROM employee_salary_details WHERE rule_id=".$rule_id.";");
		}
		
		$qry = "SELECT  employee_salary_details.approver_1 AS m_email, lu1.name AS m_name, mf1.name AS m_function_name,
IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - (sp_increased_salary*emp_currency_conversion_rate))) AS manager_total_used_bdgt,
SUM(emp_final_bdgt*emp_currency_conversion_rate) AS manager_total_bdgt, 
SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_allocated_bdgt, 
SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_allocated_bdgt, 
SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_used_bdgt, 
SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_used_bdgt, 
SUM(sp_increased_salary*emp_currency_conversion_rate) AS m_direct_emps_promotion_used_bdgt, SUM(increment_applied_on_salary*emp_currency_conversion_rate) AS m_direct_emps_current_total_salary 
FROM employee_salary_details 
INNER JOIN (
SELECT DISTINCT
ChildUserType.approver_1
FROM employee_salary_details_rows  ChildUserType
LEFT JOIN employee_salary_details_rows ParentUserType ON ChildUserType.approver_1 = ParentUserType.email_id
WHERE  ParentUserType.approver_1='".$m_email."' AND 
ParentUserType.rule_id=".$rule_id."
UNION
SELECT '".$m_email."'
) a 
ON employee_salary_details.approver_1=a.approver_1
LEFT OUTER  JOIN login_user lu1 ON employee_salary_details.`approver_1`=lu1.`email`
LEFT OUTER  JOIN manage_function mf1 ON lu1.`function`=mf1.`id`
WHERE employee_salary_details.rule_id=".$rule_id."
GROUP BY employee_salary_details.approver_1,lu1.name,mf1.name ORDER BY FIELD(m_name, '".$m_name."') DESC, m_name ASC";
		return $this->db->query($qry)->result_array();
	}
	/* End :: To get Current Manager & Downline Budget dtls For Salary Rule Increment Page */
	
	/* Start :: To get Current Manager & Downline Accumulated Budget dtls For Salary Rule Increment Page */
	public function get_current_manager_n_downline_accumulated_bdgt_dtls_for_increment_list_manager($rule_id, $include_promotion_bdgt, $m_email)
    {
		$qry = "SELECT employee_salary_details.approver_1 AS m_email,
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.manager_total_used_bdgt ELSE
		IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
		SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - (sp_increased_salary*emp_currency_conversion_rate))) 
		END) AS manager_total_used_bdgt,
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.manager_total_bdgt ELSE
		SUM(emp_final_bdgt*emp_currency_conversion_rate) END) AS manager_total_bdgt,  
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_merit_allocated_bdgt ELSE
		SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) END) AS m_direct_emps_merit_allocated_bdgt, 
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_market_allocated_bdgt ELSE
		SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01)  END)AS m_direct_emps_market_allocated_bdgt, 
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_merit_used_bdgt ELSE
		SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) END) AS m_direct_emps_merit_used_bdgt, 
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_market_used_bdgt ELSE
		SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01)END) AS m_direct_emps_market_used_bdgt, 
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_promotion_used_bdgt ELSE
		SUM(sp_increased_salary*emp_currency_conversion_rate) END) AS m_direct_emps_promotion_used_bdgt, 
		(CASE WHEN employee_salary_details.approver_1=b.approver_1 THEN b.m_direct_emps_current_total_salary ELSE
		SUM(increment_applied_on_salary*emp_currency_conversion_rate)END) AS m_direct_emps_current_total_salary 
		FROM employee_salary_details
		INNER JOIN (
		SELECT DISTINCT 
		ChildUserType.email_id,ParentUserType.approver_1
		FROM employee_salary_details_rows ChildUserType
		LEFT JOIN employee_salary_details_rows ParentUserType ON ChildUserType.approver_1 = ParentUserType.email_id
		WHERE  ParentUserType.approver_1='".$m_email."' AND 
		ParentUserType.rule_id=".$rule_id."
		) a ON employee_salary_details.approver_1=a.email_id
		LEFT OUTER JOIN 
		(SELECT a.approver_1,employee_salary_details.approver_1 AS m_email,
		IF(".$include_promotion_bdgt." = 1, SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate)), 
		SUM((final_salary*emp_currency_conversion_rate) - (increment_applied_on_salary*emp_currency_conversion_rate) - (sp_increased_salary*emp_currency_conversion_rate))) AS manager_total_used_bdgt,
		SUM(emp_final_bdgt*emp_currency_conversion_rate) AS manager_total_bdgt,  
		SUM(increment_applied_on_salary*performnace_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_allocated_bdgt, 
		SUM(increment_applied_on_salary*crr_based_increment*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_allocated_bdgt, 
		SUM(increment_applied_on_salary*final_merit_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_merit_used_bdgt, 
		SUM(increment_applied_on_salary*final_market_hike*emp_currency_conversion_rate*0.01) AS m_direct_emps_market_used_bdgt, 
		SUM(sp_increased_salary*emp_currency_conversion_rate) AS m_direct_emps_promotion_used_bdgt, SUM(increment_applied_on_salary*emp_currency_conversion_rate) AS m_direct_emps_current_total_salary 
		FROM employee_salary_details
		INNER JOIN (
		SELECT DISTINCT 
		ChildUserType.email_id,ParentUserType.approver_1
		FROM employee_salary_details_rows ChildUserType
		LEFT JOIN employee_salary_details_rows ParentUserType ON ChildUserType.approver_1 = ParentUserType.email_id
		WHERE  ParentUserType.approver_1='".$m_email."' AND 
		ParentUserType.rule_id=".$rule_id."
		) a 
		ON employee_salary_details.approver_1=a.email_id
		WHERE employee_salary_details.rule_id=".$rule_id." 
		GROUP BY a.approver_1 ) b ON employee_salary_details.approver_1=b.approver_1			
		WHERE employee_salary_details.rule_id=".$rule_id." 
		GROUP BY employee_salary_details.approver_1";
		
		$managers_accumulated_arr = $this->db->query($qry)->result_array();
		$tmp_arr = array();
		foreach($managers_accumulated_arr as $row)
		{
			$tmp_arr[$row["m_email"]] = $row;
		}			
		return $tmp_arr;
	}
	/* Start :: To get Current Manager & Downline Accumulated Budget dtls For Salary Rule Increment Page */

}