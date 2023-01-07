<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller 
{	 
	 public function __construct()
	 {		
<<<<<<< HEAD
        parent::__construct();		
        $this->load->model("admin_model");                             
    }
	
	public function vw_cmpny_lst()
	{ 
		$cmpny_lst = $this->db->select("*")->from("manage_company")->get()->result_array();
		echo '<table width="50%" border="1">
  <tr>
    <th scope="col">Sr No</th>
    <th scope="col">Company Name</th>
    <th scope="col">DB Name</th>
  </tr>';
		foreach($cmpny_lst as $row)
		{
			echo '<tr>
    <td>'.$row['id'].'</td>
    <td>'.$row['company_name'].'</td>
    <td>'.$row['dbname'].'</td>
  </tr>';
		}
		echo "</table>";
	
	
	$domain_list = $this->db->select("*")->from("domain")->get()->result_array();
		//$this->db->join("domain", "domain.company_Id = manage_company.id");
		//$this->db->join("login_user", "login_user.company_Id = manage_company.id");
		echo '<br><table width="50%" border="1">
  <tr>
    <th scope="col">Sr No</th>
    <th scope="col">Domain Name</th>
  </tr>';
		foreach($domain_list as $row)
		{
			echo '<tr>
    <td>'.$row['id'].'</td>
    <td>'.$row['domainName'].'</td>
  </tr>';
		}
		echo "</table>";
		
	}

	public function test() {

		$query = "UPDATE login_user lu use index(email) INNER JOIN temp_upload_data_8 tu USING (email) SET lu.upload_id = 5, lu.updatedon = '2020-03-09 17:16:53', lu.company_name = CASE WHEN (tu.company_name = '' OR tu.company_name IS NULL) THEN lu.company_name ELSE tu.company_name END, lu.employee_code = CASE WHEN (tu.employee_code = '' OR tu.employee_code IS NULL) THEN lu.employee_code ELSE tu.employee_code END, lu.name = CASE WHEN (tu.name = '' OR tu.name IS NULL) THEN lu.name ELSE tu.name END, lu.first_name = CASE WHEN (tu.first_name = '' OR tu.first_name IS NULL) THEN lu.first_name ELSE tu.first_name END, lu.email = CASE WHEN (tu.email = '' OR tu.email IS NULL) THEN lu.email ELSE tu.email END, lu.gender = CASE WHEN (tu.gender = '' OR tu.gender IS NULL) THEN lu.gender ELSE tu.gender END, lu.urban_rural_classification = CASE WHEN (tu.urban_rural_classification = '' OR tu.urban_rural_classification IS NULL) THEN lu.urban_rural_classification ELSE tu.urban_rural_classification END, lu.company_joining_date = CASE WHEN (tu.company_joining_date = '' OR tu.company_joining_date IS NULL) THEN lu.company_joining_date ELSE tu.company_joining_date END, lu.increment_purpose_joining_date = CASE WHEN (tu.increment_purpose_joining_date = '' OR tu.increment_purpose_joining_date IS NULL) THEN lu.increment_purpose_joining_date ELSE tu.increment_purpose_joining_date END, lu.start_date_for_role = CASE WHEN (tu.start_date_for_role = '' OR tu.start_date_for_role IS NULL) THEN lu.start_date_for_role ELSE tu.start_date_for_role END, lu.end_date_for_role = CASE WHEN (tu.end_date_for_role = '' OR tu.end_date_for_role IS NULL) THEN lu.end_date_for_role ELSE tu.end_date_for_role END, lu.bonus_incentive_applicable = CASE WHEN (tu.bonus_incentive_applicable = '' OR tu.bonus_incentive_applicable IS NULL) THEN lu.bonus_incentive_applicable ELSE tu.bonus_incentive_applicable END, lu.employee_movement_into_bonus_plan = CASE WHEN (tu.employee_movement_into_bonus_plan = '' OR tu.employee_movement_into_bonus_plan IS NULL) THEN lu.employee_movement_into_bonus_plan ELSE tu.employee_movement_into_bonus_plan END, lu.recently_promoted = CASE WHEN (tu.recently_promoted = '' OR tu.recently_promoted IS NULL) THEN lu.recently_promoted ELSE tu.recently_promoted END, lu.performance_achievement = CASE WHEN (tu.performance_achievement = '' OR tu.performance_achievement IS NULL) THEN lu.performance_achievement ELSE tu.performance_achievement END, lu.effective_date_of_last_salary_increase = CASE WHEN (tu.effective_date_of_last_salary_increase = '' OR tu.effective_date_of_last_salary_increase IS NULL) THEN lu.effective_date_of_last_salary_increase ELSE tu.effective_date_of_last_salary_increase END, lu.effective_date_of_2nd_last_salary_increase = CASE WHEN (tu.effective_date_of_2nd_last_salary_increase = '' OR tu.effective_date_of_2nd_last_salary_increase IS NULL) THEN lu.effective_date_of_2nd_last_salary_increase ELSE tu.effective_date_of_2nd_last_salary_increase END, lu.effective_date_of_3rd_last_salary_increase = CASE WHEN (tu.effective_date_of_3rd_last_salary_increase = '' OR tu.effective_date_of_3rd_last_salary_increase IS NULL) THEN lu.effective_date_of_3rd_last_salary_increase ELSE tu.effective_date_of_3rd_last_salary_increase END, lu.effective_date_of_4th_last_salary_increase = CASE WHEN (tu.effective_date_of_4th_last_salary_increase = '' OR tu.effective_date_of_4th_last_salary_increase IS NULL) THEN lu.effective_date_of_4th_last_salary_increase ELSE tu.effective_date_of_4th_last_salary_increase END, lu.effective_date_of_5th_last_salary_increase = CASE WHEN (tu.effective_date_of_5th_last_salary_increase = '' OR tu.effective_date_of_5th_last_salary_increase IS NULL) THEN lu.effective_date_of_5th_last_salary_increase ELSE tu.effective_date_of_5th_last_salary_increase END, lu.salary_after_last_increase = CASE WHEN (tu.salary_after_last_increase = '' OR tu.salary_after_last_increase IS NULL) THEN lu.salary_after_last_increase ELSE tu.salary_after_last_increase END, lu.salary_after_2nd_last_increase = CASE WHEN (tu.salary_after_2nd_last_increase = '' OR tu.salary_after_2nd_last_increase IS NULL) THEN lu.salary_after_2nd_last_increase ELSE tu.salary_after_2nd_last_increase END, lu.salary_after_3rd_last_increase = CASE WHEN (tu.salary_after_3rd_last_increase = '' OR tu.salary_after_3rd_last_increase IS NULL) THEN lu.salary_after_3rd_last_increase ELSE tu.salary_after_3rd_last_increase END, lu.salary_after_4th_last_increase = CASE WHEN (tu.salary_after_4th_last_increase = '' OR tu.salary_after_4th_last_increase IS NULL) THEN lu.salary_after_4th_last_increase ELSE tu.salary_after_4th_last_increase END, lu.salary_after_5th_last_increase = CASE WHEN (tu.salary_after_5th_last_increase = '' OR tu.salary_after_5th_last_increase IS NULL) THEN lu.salary_after_5th_last_increase ELSE tu.salary_after_5th_last_increase END, lu.total_salary_after_last_increase = CASE WHEN (tu.total_salary_after_last_increase = '' OR tu.total_salary_after_last_increase IS NULL) THEN lu.total_salary_after_last_increase ELSE tu.total_salary_after_last_increase END, lu.total_salary_after_2nd_last_increase = CASE WHEN (tu.total_salary_after_2nd_last_increase = '' OR tu.total_salary_after_2nd_last_increase IS NULL) THEN lu.total_salary_after_2nd_last_increase ELSE tu.total_salary_after_2nd_last_increase END, lu.total_salary_after_3rd_last_increase = CASE WHEN (tu.total_salary_after_3rd_last_increase = '' OR tu.total_salary_after_3rd_last_increase IS NULL) THEN lu.total_salary_after_3rd_last_increase ELSE tu.total_salary_after_3rd_last_increase END, lu.total_salary_after_4th_last_increase = CASE WHEN (tu.total_salary_after_4th_last_increase = '' OR tu.total_salary_after_4th_last_increase IS NULL) THEN lu.total_salary_after_4th_last_increase ELSE tu.total_salary_after_4th_last_increase END, lu.total_salary_after_5th_last_increase = CASE WHEN (tu.total_salary_after_5th_last_increase = '' OR tu.total_salary_after_5th_last_increase IS NULL) THEN lu.total_salary_after_5th_last_increase ELSE tu.total_salary_after_5th_last_increase END, lu.target_salary_after_last_increase = CASE WHEN (tu.target_salary_after_last_increase = '' OR tu.target_salary_after_last_increase IS NULL) THEN lu.target_salary_after_last_increase ELSE tu.target_salary_after_last_increase END, lu.target_salary_after_2nd_last_increase = CASE WHEN (tu.target_salary_after_2nd_last_increase = '' OR tu.target_salary_after_2nd_last_increase IS NULL) THEN lu.target_salary_after_2nd_last_increase ELSE tu.target_salary_after_2nd_last_increase END, lu.target_salary_after_3rd_last_increase = CASE WHEN (tu.target_salary_after_3rd_last_increase = '' OR tu.target_salary_after_3rd_last_increase IS NULL) THEN lu.target_salary_after_3rd_last_increase ELSE tu.target_salary_after_3rd_last_increase END, lu.target_salary_after_4th_last_increase = CASE WHEN (tu.target_salary_after_4th_last_increase = '' OR tu.target_salary_after_4th_last_increase IS NULL) THEN lu.target_salary_after_4th_last_increase ELSE tu.target_salary_after_4th_last_increase END, lu.target_salary_after_5th_last_increase = CASE WHEN (tu.target_salary_after_5th_last_increase = '' OR tu.target_salary_after_5th_last_increase IS NULL) THEN lu.target_salary_after_5th_last_increase ELSE tu.target_salary_after_5th_last_increase END, lu.current_base_salary = CASE WHEN (tu.current_base_salary = '' OR tu.current_base_salary IS NULL) THEN lu.current_base_salary ELSE tu.current_base_salary END, lu.current_target_bonus = CASE WHEN (tu.current_target_bonus = '' OR tu.current_target_bonus IS NULL) THEN lu.current_target_bonus ELSE tu.current_target_bonus END, lu.allowance_1 = CASE WHEN (tu.allowance_1 = '' OR tu.allowance_1 IS NULL) THEN lu.allowance_1 ELSE tu.allowance_1 END, lu.allowance_2 = CASE WHEN (tu.allowance_2 = '' OR tu.allowance_2 IS NULL) THEN lu.allowance_2 ELSE tu.allowance_2 END, lu.allowance_3 = CASE WHEN (tu.allowance_3 = '' OR tu.allowance_3 IS NULL) THEN lu.allowance_3 ELSE tu.allowance_3 END, lu.allowance_4 = CASE WHEN (tu.allowance_4 = '' OR tu.allowance_4 IS NULL) THEN lu.allowance_4 ELSE tu.allowance_4 END, lu.allowance_5 = CASE WHEN (tu.allowance_5 = '' OR tu.allowance_5 IS NULL) THEN lu.allowance_5 ELSE tu.allowance_5 END, lu.allowance_6 = CASE WHEN (tu.allowance_6 = '' OR tu.allowance_6 IS NULL) THEN lu.allowance_6 ELSE tu.allowance_6 END, lu.allowance_7 = CASE WHEN (tu.allowance_7 = '' OR tu.allowance_7 IS NULL) THEN lu.allowance_7 ELSE tu.allowance_7 END, lu.allowance_8 = CASE WHEN (tu.allowance_8 = '' OR tu.allowance_8 IS NULL) THEN lu.allowance_8 ELSE tu.allowance_8 END, lu.allowance_9 = CASE WHEN (tu.allowance_9 = '' OR tu.allowance_9 IS NULL) THEN lu.allowance_9 ELSE tu.allowance_9 END, lu.allowance_10 = CASE WHEN (tu.allowance_10 = '' OR tu.allowance_10 IS NULL) THEN lu.allowance_10 ELSE tu.allowance_10 END, lu.allowance_11 = CASE WHEN (tu.allowance_11 = '' OR tu.allowance_11 IS NULL) THEN lu.allowance_11 ELSE tu.allowance_11 END, lu.allowance_12 = CASE WHEN (tu.allowance_12 = '' OR tu.allowance_12 IS NULL) THEN lu.allowance_12 ELSE tu.allowance_12 END, lu.allowance_13 = CASE WHEN (tu.allowance_13 = '' OR tu.allowance_13 IS NULL) THEN lu.allowance_13 ELSE tu.allowance_13 END, lu.allowance_14 = CASE WHEN (tu.allowance_14 = '' OR tu.allowance_14 IS NULL) THEN lu.allowance_14 ELSE tu.allowance_14 END, lu.allowance_15 = CASE WHEN (tu.allowance_15 = '' OR tu.allowance_15 IS NULL) THEN lu.allowance_15 ELSE tu.allowance_15 END, lu.allowance_16 = CASE WHEN (tu.allowance_16 = '' OR tu.allowance_16 IS NULL) THEN lu.allowance_16 ELSE tu.allowance_16 END, lu.allowance_17 = CASE WHEN (tu.allowance_17 = '' OR tu.allowance_17 IS NULL) THEN lu.allowance_17 ELSE tu.allowance_17 END, lu.allowance_18 = CASE WHEN (tu.allowance_18 = '' OR tu.allowance_18 IS NULL) THEN lu.allowance_18 ELSE tu.allowance_18 END, lu.allowance_19 = CASE WHEN (tu.allowance_19 = '' OR tu.allowance_19 IS NULL) THEN lu.allowance_19 ELSE tu.allowance_19 END, ";
		$query .= "lu.allowance_20 = CASE WHEN (tu.allowance_20 = '' OR tu.allowance_20 IS NULL) THEN lu.allowance_20 ELSE tu.allowance_20 END, lu.allowance_21 = CASE WHEN (tu.allowance_21 = '' OR tu.allowance_21 IS NULL) THEN lu.allowance_21 ELSE tu.allowance_21 END, lu.allowance_22 = CASE WHEN (tu.allowance_22 = '' OR tu.allowance_22 IS NULL) THEN lu.allowance_22 ELSE tu.allowance_22 END, lu.allowance_23 = CASE WHEN (tu.allowance_23 = '' OR tu.allowance_23 IS NULL) THEN lu.allowance_23 ELSE tu.allowance_23 END, lu.allowance_24 = CASE WHEN (tu.allowance_24 = '' OR tu.allowance_24 IS NULL) THEN lu.allowance_24 ELSE tu.allowance_24 END, lu.allowance_25 = CASE WHEN (tu.allowance_25 = '' OR tu.allowance_25 IS NULL) THEN lu.allowance_25 ELSE tu.allowance_25 END, lu.allowance_26 = CASE WHEN (tu.allowance_26 = '' OR tu.allowance_26 IS NULL) THEN lu.allowance_26 ELSE tu.allowance_26 END, lu.allowance_27 = CASE WHEN (tu.allowance_27 = '' OR tu.allowance_27 IS NULL) THEN lu.allowance_27 ELSE tu.allowance_27 END, lu.allowance_28 = CASE WHEN (tu.allowance_28 = '' OR tu.allowance_28 IS NULL) THEN lu.allowance_28 ELSE tu.allowance_28 END, lu.allowance_29 = CASE WHEN (tu.allowance_29 = '' OR tu.allowance_29 IS NULL) THEN lu.allowance_29 ELSE tu.allowance_29 END, lu.allowance_30 = CASE WHEN (tu.allowance_30 = '' OR tu.allowance_30 IS NULL) THEN lu.allowance_30 ELSE tu.allowance_30 END, lu.allowance_31 = CASE WHEN (tu.allowance_31 = '' OR tu.allowance_31 IS NULL) THEN lu.allowance_31 ELSE tu.allowance_31 END, lu.allowance_32 = CASE WHEN (tu.allowance_32 = '' OR tu.allowance_32 IS NULL) THEN lu.allowance_32 ELSE tu.allowance_32 END, lu.allowance_33 = CASE WHEN (tu.allowance_33 = '' OR tu.allowance_33 IS NULL) THEN lu.allowance_33 ELSE tu.allowance_33 END, lu.allowance_34 = CASE WHEN (tu.allowance_34 = '' OR tu.allowance_34 IS NULL) THEN lu.allowance_34 ELSE tu.allowance_34 END, lu.allowance_35 = CASE WHEN (tu.allowance_35 = '' OR tu.allowance_35 IS NULL) THEN lu.allowance_35 ELSE tu.allowance_35 END, lu.allowance_36 = CASE WHEN (tu.allowance_36 = '' OR tu.allowance_36 IS NULL) THEN lu.allowance_36 ELSE tu.allowance_36 END, lu.allowance_38 = CASE WHEN (tu.allowance_38 = '' OR tu.allowance_38 IS NULL) THEN lu.allowance_38 ELSE tu.allowance_38 END, lu.allowance_37 = CASE WHEN (tu.allowance_37 = '' OR tu.allowance_37 IS NULL) THEN lu.allowance_37 ELSE tu.allowance_37 END, lu.allowance_39 = CASE WHEN (tu.allowance_39 = '' OR tu.allowance_39 IS NULL) THEN lu.allowance_39 ELSE tu.allowance_39 END, lu.allowance_40 = CASE WHEN (tu.allowance_40 = '' OR tu.allowance_40 IS NULL) THEN lu.allowance_40 ELSE tu.allowance_40 END, lu.total_compensation = CASE WHEN (tu.total_compensation = '' OR tu.total_compensation IS NULL) THEN lu.total_compensation ELSE tu.total_compensation END, lu.increment_applied_on = CASE WHEN (tu.increment_applied_on = '' OR tu.increment_applied_on IS NULL) THEN lu.increment_applied_on ELSE tu.increment_applied_on END, lu.job_code = CASE WHEN (tu.job_code = '' OR tu.job_code IS NULL) THEN lu.job_code ELSE tu.job_code END, lu.job_name = CASE WHEN (tu.job_name = '' OR tu.job_name IS NULL) THEN lu.job_name ELSE tu.job_name END, lu.job_level = CASE WHEN (tu.job_level = '' OR tu.job_level IS NULL) THEN lu.job_level ELSE tu.job_level END, lu.approver_1 = CASE WHEN (tu.approver_1 = '' OR tu.approver_1 IS NULL) THEN lu.approver_1 ELSE tu.approver_1 END, lu.approver_2 = CASE WHEN (tu.approver_2 = '' OR tu.approver_2 IS NULL) THEN lu.approver_2 ELSE tu.approver_2 END, lu.approver_3 = CASE WHEN (tu.approver_3 = '' OR tu.approver_3 IS NULL) THEN lu.approver_3 ELSE tu.approver_3 END, lu.approver_4 = CASE WHEN (tu.approver_4 = '' OR tu.approver_4 IS NULL) THEN lu.approver_4 ELSE tu.approver_4 END, lu.manager_name = CASE WHEN (tu.manager_name = '' OR tu.manager_name IS NULL) THEN lu.manager_name ELSE tu.manager_name END, lu.authorised_signatory_for_letter = CASE WHEN (tu.authorised_signatory_for_letter = '' OR tu.authorised_signatory_for_letter IS NULL) THEN lu.authorised_signatory_for_letter ELSE tu.authorised_signatory_for_letter END, lu.authorised_signatorys_title_for_letter = CASE WHEN (tu.authorised_signatorys_title_for_letter = '' OR tu.authorised_signatorys_title_for_letter IS NULL) THEN lu.authorised_signatorys_title_for_letter ELSE tu.authorised_signatorys_title_for_letter END, lu.hr_authorised_signatory_for_letter = CASE WHEN (tu.hr_authorised_signatory_for_letter = '' OR tu.hr_authorised_signatory_for_letter IS NULL) THEN lu.hr_authorised_signatory_for_letter ELSE tu.hr_authorised_signatory_for_letter END, lu.hr_authorised_signatorys_title_for_letter = CASE WHEN (tu.hr_authorised_signatorys_title_for_letter = '' OR tu.hr_authorised_signatorys_title_for_letter IS NULL) THEN lu.hr_authorised_signatorys_title_for_letter ELSE tu.hr_authorised_signatorys_title_for_letter END, lu.other_data_21 = CASE WHEN (tu.other_data_21 = '' OR tu.other_data_21 IS NULL) THEN lu.other_data_21 ELSE tu.other_data_21 END, lu.other_data_22 = CASE WHEN (tu.other_data_22 = '' OR tu.other_data_22 IS NULL) THEN lu.other_data_22 ELSE tu.other_data_22 END, lu.other_data_23 = CASE WHEN (tu.other_data_23 = '' OR tu.other_data_23 IS NULL) THEN lu.other_data_23 ELSE tu.other_data_23 END, lu.other_data_24 = CASE WHEN (tu.other_data_24 = '' OR tu.other_data_24 IS NULL) THEN lu.other_data_24 ELSE tu.other_data_24 END, lu.teeth_tail_ratio = CASE WHEN (tu.teeth_tail_ratio = '' OR tu.teeth_tail_ratio IS NULL) THEN lu.teeth_tail_ratio ELSE tu.teeth_tail_ratio END, lu.previous_talent_rating = CASE WHEN (tu.previous_talent_rating = '' OR tu.previous_talent_rating IS NULL) THEN lu.previous_talent_rating ELSE tu.previous_talent_rating END, lu.promoted_in_2_yrs = CASE WHEN (tu.promoted_in_2_yrs = '' OR tu.promoted_in_2_yrs IS NULL) THEN lu.promoted_in_2_yrs ELSE tu.promoted_in_2_yrs END, lu.engagement_level = CASE WHEN (tu.engagement_level = '' OR tu.engagement_level IS NULL) THEN lu.engagement_level ELSE tu.engagement_level END, lu.successor_identified = CASE WHEN (tu.successor_identified = '' OR tu.successor_identified IS NULL) THEN lu.successor_identified ELSE tu.successor_identified END, lu.readyness_level = CASE WHEN (tu.readyness_level = '' OR tu.readyness_level IS NULL) THEN lu.readyness_level ELSE tu.readyness_level END, lu.other_data_9 = CASE WHEN (tu.other_data_9 = '' OR tu.other_data_9 IS NULL) THEN lu.other_data_9 ELSE tu.other_data_9 END, lu.other_data_10 = CASE WHEN (tu.other_data_10 = '' OR tu.other_data_10 IS NULL) THEN lu.other_data_10 ELSE tu.other_data_10 END, lu.other_data_11 = CASE WHEN (tu.other_data_11 = '' OR tu.other_data_11 IS NULL) THEN lu.other_data_11 ELSE tu.other_data_11 END, lu.other_data_12 = CASE WHEN (tu.other_data_12 = '' OR tu.other_data_12 IS NULL) THEN lu.other_data_12 ELSE tu.other_data_12 END, lu.other_data_13 = CASE WHEN (tu.other_data_13 = '' OR tu.other_data_13 IS NULL) THEN lu.other_data_13 ELSE tu.other_data_13 END, lu.other_data_14 = CASE WHEN (tu.other_data_14 = '' OR tu.other_data_14 IS NULL) THEN lu.other_data_14 ELSE tu.other_data_14 END, lu.other_data_15 = CASE WHEN (tu.other_data_15 = '' OR tu.other_data_15 IS NULL) THEN lu.other_data_15 ELSE tu.other_data_15 END, lu.other_data_16 = CASE WHEN (tu.other_data_16 = '' OR tu.other_data_16 IS NULL) THEN lu.other_data_16 ELSE tu.other_data_16 END, lu.Other_data_17 = CASE WHEN (tu.Other_data_17 = '' OR tu.Other_data_17 IS NULL) THEN lu.Other_data_17 ELSE tu.Other_data_17 END, lu.other_data_18 = CASE WHEN (tu.other_data_18 = '' OR tu.other_data_18 IS NULL) THEN lu.other_data_18 ELSE tu.other_data_18 END, lu.other_data_19 = CASE WHEN (tu.other_data_19 = '' OR tu.other_data_19 IS NULL) THEN lu.other_data_19 ELSE tu.other_data_19 END, lu.other_data_20 = CASE WHEN (tu.other_data_20 = '' OR tu.other_data_20 IS NULL) THEN lu.other_data_20 ELSE tu.other_data_20 END, lu.cost_center = CASE WHEN (tu.cost_center = '' OR tu.cost_center IS NULL) THEN lu.cost_center ELSE tu.cost_center END, lu.employee_type = CASE WHEN (tu.employee_type = '' OR tu.employee_type IS NULL) THEN lu.employee_type ELSE tu.employee_type END, lu.country = CASE WHEN (tu.country = '' OR tu.country IS NULL) THEN lu.country ELSE tu.country END, lu.city = CASE WHEN (tu.city = '' OR tu.city IS NULL) THEN lu.city ELSE tu.city END, lu.business_level_1 = CASE WHEN (tu.business_level_1 = '' OR tu.business_level_1 IS NULL) THEN lu.business_level_1 ELSE tu.business_level_1 END, lu.business_level_2 = CASE WHEN (tu.business_level_2 = '' OR tu.business_level_2 IS NULL) THEN lu.business_level_2 ELSE tu.business_level_2 END, lu.business_level_3 = CASE WHEN (tu.business_level_3 = '' OR tu.business_level_3 IS NULL) THEN lu.business_level_3 ELSE tu.business_level_3 END, lu.function = CASE WHEN (tu.function = '' OR tu.function IS NULL) THEN lu.function ELSE tu.function END, lu.subfunction = CASE WHEN (tu.subfunction = '' OR tu.subfunction IS NULL) THEN lu.subfunction ELSE tu.subfunction END, lu.sub_subfunction = CASE WHEN (tu.sub_subfunction = '' OR tu.sub_subfunction IS NULL) THEN lu.sub_subfunction ELSE tu.sub_subfunction END, lu.designation = CASE WHEN (tu.designation = '' OR tu.designation IS NULL) THEN lu.designation ELSE tu.designation END, lu.grade = CASE WHEN (tu.grade = '' OR tu.grade IS NULL) THEN lu.grade ELSE tu.grade END, lu.level = CASE WHEN (tu.level = '' OR tu.level IS NULL) THEN lu.level ELSE tu.level END, lu.employee_role = CASE WHEN (tu.employee_role = '' OR tu.employee_role IS NULL) THEN lu.employee_role ELSE tu.employee_role END, lu.education = CASE WHEN (tu.education = '' OR tu.education IS NULL) THEN lu.education ELSE tu.education END, lu.critical_talent = CASE WHEN (tu.critical_talent = '' OR tu.critical_talent IS NULL) THEN lu.critical_talent ELSE tu.critical_talent END, lu.critical_position = CASE WHEN (tu.critical_position = '' OR tu.critical_position IS NULL) THEN lu.critical_position ELSE tu.critical_position END, ";
		$query .= "lu.special_category = CASE WHEN (tu.special_category = '' OR tu.special_category IS NULL) THEN lu.special_category ELSE tu.special_category END, lu.rating_for_current_year = CASE WHEN (tu.rating_for_current_year = '' OR tu.rating_for_current_year IS NULL) THEN lu.rating_for_current_year ELSE tu.rating_for_current_year END, lu.rating_for_last_year = CASE WHEN (tu.rating_for_last_year = '' OR tu.rating_for_last_year IS NULL) THEN lu.rating_for_last_year ELSE tu.rating_for_last_year END, lu.rating_for_2nd_last_year = CASE WHEN (tu.rating_for_2nd_last_year = '' OR tu.rating_for_2nd_last_year IS NULL) THEN lu.rating_for_2nd_last_year ELSE tu.rating_for_2nd_last_year END, lu.rating_for_3rd_last_year = CASE WHEN (tu.rating_for_3rd_last_year = '' OR tu.rating_for_3rd_last_year IS NULL) THEN lu.rating_for_3rd_last_year ELSE tu.rating_for_3rd_last_year END, lu.rating_for_4th_last_year = CASE WHEN (tu.rating_for_4th_last_year = '' OR tu.rating_for_4th_last_year IS NULL) THEN lu.rating_for_4th_last_year ELSE tu.rating_for_4th_last_year END, lu.rating_for_5th_last_year = CASE WHEN (tu.rating_for_5th_last_year = '' OR tu.rating_for_5th_last_year IS NULL) THEN lu.rating_for_5th_last_year ELSE tu.rating_for_5th_last_year END, lu.currency = CASE WHEN (tu.currency = '' OR tu.currency IS NULL) THEN lu.currency ELSE tu.currency END WHERE tu.is_error = 0 and tu.id between 15001 and 16000;";

		print '<pre><br> Start Time: '.date("Y-m-d H:i:s");
		$this->admin_model->test($query);
		print '<pre><br> Start Time: '.date("Y-m-d H:i:s");
		die("end");

	}
}
=======
        parent::__construct();
        $this->load->database();
        $this->load->model("admin_model");
        $this->load->model("mail_send_model");
        $this->currentTime	= date("Y-m-d H:i:s",time());
        $this->dbname = '190902_1567424804';//'190916_1568632104';//$this->session->userdata("dbname_ses");
	}
	
    public function mail_send_by_cron_new()
	{

        $this->db->query("Use ".$this->dbname);

        $send_mail = $this->SentMail($this->input->get('mailSubject'), $this->input->get('mailContent'), $this->input->get('mailFromName'), $this->input->get('mailTo'), $this->input->get('mailCc'), $this->input->get('mailBcc'), $this->input->get('companyid_ses'));

        if($send_mail) { print '<br>'.$this->input->get('id');
            $where_condition = array(
                'id' => $this->input->get('id'),
            );

            $update_data = array(
                'status' => 1,
                'executionTime' => $this->currentTime,
            );

            $this->mail_send_model->update_mail_data($update_data, $where_condition);
        }


       
    }


    public function mail_send_by_cron_direct($id, $mailSubject, $mailContent, $mailFromName, $mailTo, $mailCc, $mailBcc, $companyid)
	{

        $this->db->query("Use ".$this->dbname);

        $send_mail = $this->SentMail($mailSubject, $mailContent, $mailFromName, $mailTo, $mailCc, $mailBcc, $companyid);

        if($send_mail) { print '<br> == direct == '.$id;
            $where_condition = array(
                'id' => $id,
            );

            $update_data = array(
                'status' => 1,
                'executionTime' => $this->currentTime,
            );

            $this->mail_send_model->update_mail_data($update_data, $where_condition);
        }
       
    }


    public function send_mail_direct() {

        $this->db->query("Use ".$this->dbname);

        $select_fields = 'id, mailTo, mailCc, mailBcc, mailFrom, mailFromName, mailSubject, mailContent';
        $data_array    =  $this->admin_model->get_table('cron_mail_queue', $select_fields, '');

        if(!empty($data_array)) {
            foreach($data_array as $key => $batchItem){
                $batchItem['companyid_ses'] =  $this->session->userdata('companyid_ses');
                $this->mail_send_by_cron_direct($batchItem['id'], $batchItem['mailSubject'], $batchItem['mailContent'], $batchItem['mailFromName'], $batchItem['mailTo'], $batchItem['mailCc'], $batchItem['mailBcc'], $batchItem['companyid_ses']);
            }
        }

    }
    

    public function SentMail($mailSubject, $mailContent, $mailFromName, $mailTo, $mailCc, $mailBcc, $companyid)
	{
       
        $email_config=HLP_GetSMTP_Details();

		if(!empty($email_config['result'])) {

			$mailSubject    = $mailSubject ?? "Testing today";
			$mailContent    = $mailContent?? "Hello team";
			$mailFromName   = $mailFromName ?? "Gaurav Test";
			$mailCc         = 'gaurav.kumar110@gmail.com';
			$mailBcc        = '';
			$mailTo 	    = 'gaurav.kumar110@yahoo.com';
			$mailContent 	= stripslashes($mailContent);	
            $email_config   = $email_config['result'];

			$config = Array('charset' => 'utf-8', 'mailtype' => 'html','smtp_timeout' => 5, 'validation'=> TRUE, 'smtp_keepalive' => TRUE, 'priority' => 1);
			$config["protocol"]  = $email_config['protocol'];
			$config["smtp_host"] = 'smtp.pepipost.com';//'smtp.gmail.com';//$email_config['smtp_host'];//$email_config['smtp_host'];//'smtp.sendgrid.net';
			$config["smtp_port"] = '587';//$email_config['smtp_port'];//'465';//
			$config["smtp_user"] = 'gauravkumar110';//'gaurav.kumar110@gmail.com';//'apikey';//$email_config['smtp_user'];//$email_config['smtp_user'];
			$config["smtp_pass"] = 'gauravkumar110_781d59f29fa691ab62e61a51e520a583';//'Computer12-';////'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';//'gauravkumar110_781d59f29fa691ab62e61a51e520a583';//$email_config['smtp_pass'];
			$config["smtp_crypto"] ='TLS';//$email_config['smtp_crypto'];//'ssl';//'tls';//

            $mailFrom = 'info@pepisandbox.com';

            /*print '<br><pre> == '.__LINE__.' == ';print_r($mailSubject);
            print '<br><pre> == '.__LINE__.' == ';print_r($mailContent);
            print '<br><pre> == '.__LINE__.' == ';print_r($mailFromName);
            print '<br><pre> == '.__LINE__.' == ';print_r($mailTo);
            print '<br><pre> == '.__LINE__.' == ';print_r($mailCc);
            print '<br><pre> == '.__LINE__.' == ';print_r($mailBcc);
            die("end");*/

			$this->load->library('Email', null ,'email');

			//$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			//$this->email->set_header('x-smtpapi',$json_string);
			$this->email->from($mailFrom,$mailFromName);
			$this->email->to($mailTo);

			if(!empty($mailCc)) {
			//	$this->email->cc($mailCc);
			}

			if(!empty($mailBcc)) {
				$this->email->cc($mailBcc);
			}

			$this->email->subject($mailSubject);
			$this->email->message($mailContent);
			return $rslt = $this->email->send();

		} else {
			return FALSE;
		}
    }

}
>>>>>>> cf8c0cd229d059a6a5658a9d249aa9e4d5af60c1
