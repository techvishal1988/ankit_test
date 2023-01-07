<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rules extends CI_Controller 
{	 
	public function __construct()
	{		
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
		$this->load->model("rule_model");
		$this->load->model("common_model");
		$this->load->model("approvel_model");
		$this->load->model("admin_model");
		$this->lang->load('message', 'english');
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{			
			redirect(site_url("dashboard"));			
		}  
		HLP_is_valid_web_token();                    
	}

	public function salary_rule_filters($performance_cycle_id, $rule_id=0)
	{
		$data["msg"] = "";
		if(!helper_have_rights(CV_SALARY_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_salary').'</b></div>';
		}
		$is_need_update = 0;//1=Yes,0=No
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->rule_model->get_table_row("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		
		if(!$data['right_dtls'])
		{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your right criteria not set yet. Please contact your admin.</b></div>');
			redirect(site_url("salary-rule-list/".$performance_cycle_id));
		}

		$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));
		
		if(!$data['performance_cycle_dtls'])
		{
			redirect(site_url("performance-cycle"));
		}

		if($rule_id)
		{
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			if($data["rule_dtls"])
			{
				$is_need_update = 1;
				$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
				$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
				$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
				$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
				$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
				$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
				$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
				$data["rule_dtls"]["sub_subfunctions"] = explode(",",$data["rule_dtls"]["sub_subfunctions"]);
				$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
				$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
				$data["rule_dtls"]["levels"] = explode(",",$data["rule_dtls"]["levels"]);
				$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
				$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
				$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
				$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
				$data["rule_dtls"]["cost_centers"] = explode(",",$data["rule_dtls"]["cost_centers"]);
				$data["rule_dtls"]["employee_types"] = explode(",",$data["rule_dtls"]["employee_types"]);
				$data["rule_dtls"]["employee_roles"] = explode(",",$data["rule_dtls"]["employee_roles"]);
				$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
				$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
			}
		}

		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
		
		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$sub_subfunction_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_subfunctions","sub_subfunction_id", array("status"=>1, "user_id"=>$user_id), "manage_sub_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
		
		$data['cost_center_list'] = $this->rule_model->get_table("manage_cost_center","id, name", "status = 1", "name ASC");
		$data['employee_type_list'] = $this->rule_model->get_table("manage_employee_type","id, name", "status = 1", "name ASC");
		$data['employee_role_list'] = $this->rule_model->get_table("manage_employee_role","id, name", "status = 1", "name ASC");
		
		/*//Start :: tenures_list is only for a demo
		$data['tenures_list'] = $this->rule_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", "status = 1", "id asc");
		//End :: tenures_list is only for a demo*/

		if($this->input->post())
		{
			if(!$this->input->post("hf_select_all_filters"))
			{			
				if(!helper_have_rights(CV_SALARY_RULES_ID, CV_INSERT_RIGHT_NAME))
				{
					redirect(site_url("salary-rule-list/".$performance_cycle_id));
				}
			
				$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED);
				if($is_need_update > 0 and $rule_id > 0)
				{
					$condit_arr["hr_parameter.id !="] = $rule_id;
				}
				//$already_created_rule_for_emp_arr = $this->rule_model->get_table("hr_parameter","user_ids", $condit_arr);
				$already_created_rule_for_emp_arr = $this->rule_model->get_all_emp_ids_for_a_cycle($condit_arr);
				
				$already_created_rule_for_emp_ids = array();
				foreach($already_created_rule_for_emp_arr as $row)
				{
					//$already_created_rule_for_emp_ids[] = $row["user_id"]; //Note : CB:: Ravi on 25-11-2018 :: Becyuase we want create multiple rules for the same population in a Cycle. 
				}
		
				if(in_array('all', $this->input->post("ddl_country")))
				{
					$country_arr =$country_arr_view;				
				}
				else
				{
					$country_arr = implode(",",$this->input->post("ddl_country"));
				}
		
				if(in_array('all', $this->input->post("ddl_city")))
				{
					$city_arr = $city_arr_view;
				}
				else
				{
					$city_arr = implode(",",$this->input->post("ddl_city"));
				}
				
				if(in_array('all', $this->input->post("ddl_bussiness_level_1")))
				{
					$bussiness_level_1_arr = $bl1_arr_view;				
				}
				else
				{
					$bussiness_level_1_arr=implode(",",$this->input->post("ddl_bussiness_level_1"));
				}
				
				if(in_array('all', $this->input->post("ddl_bussiness_level_2")))
				{
					$bussiness_level_2_arr = $bl2_arr_view;				
				}
				else
				{
					$bussiness_level_2_arr=implode(",",$this->input->post("ddl_bussiness_level_2"));
				}
				
				if(in_array('all', $this->input->post("ddl_bussiness_level_3")))
				{
					$bussiness_level_3_arr = $bl3_arr_view;				
				}
				else
				{
					$bussiness_level_3_arr=implode(",",$this->input->post("ddl_bussiness_level_3"));
				}
				
				if(in_array('all', $this->input->post("ddl_function")))
				{
					$function_arr = $function_arr_view;
				}
				else
				{
					$function_arr = implode(",",$this->input->post("ddl_function"));
				}
				
				if(in_array('all', $this->input->post("ddl_sub_function")))
				{
					$sub_function_arr = $sub_function_arr_view;
				}
				else
				{
					$sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
				}
				
				if(in_array('all', $this->input->post("ddl_sub_subfunction")))
				{
					$sub_subfunction_arr = $sub_subfunction_arr_view;
				}
				else
				{
					$sub_subfunction_arr = implode(",",$this->input->post("ddl_sub_subfunction"));
				}
				
				if(in_array('all', $this->input->post("ddl_designation")))
				{
					$designation_arr = $designation_arr_view;
				}
				else
				{
					$designation_arr = implode(",",$this->input->post("ddl_designation"));
				}
				
				if(in_array('all', $this->input->post("ddl_grade")))
				{
					$grade_arr = $grade_arr_view;
				}
				else
				{
					$grade_arr = implode(",",$this->input->post("ddl_grade"));
				}
				
				if(in_array('all', $this->input->post("ddl_level")))
				{
					$level_arr = $level_arr_view;
				}
				else
				{
					$level_arr = implode(",",$this->input->post("ddl_level"));
				}
				
				if(in_array('all', $this->input->post("ddl_education")))
				{
					$temp_arr = array();
					$education_arr = "";
					foreach($data['education_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$education_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$education_arr = implode(",",$this->input->post("ddl_education"));
				}
				
				if(in_array('all', $this->input->post("ddl_critical_talent")))
				{
					$temp_arr = array();
					$critical_talent_arr = "";
					foreach($data['critical_talent_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$critical_talent_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$critical_talent_arr = implode(",",$this->input->post("ddl_critical_talent"));
				}
				
				if(in_array('all', $this->input->post("ddl_critical_position")))
				{
					$temp_arr = array();
					$critical_position_arr = "";
					foreach($data['critical_position_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$critical_position_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$critical_position_arr = implode(",",$this->input->post("ddl_critical_position"));
				}
		
				if(in_array('all', $this->input->post("ddl_special_category")))
				{
					$temp_arr = array();
					$special_category_arr = "";
					foreach($data['special_category_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$special_category_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$special_category_arr = implode(",",$this->input->post("ddl_special_category"));
				}
				
				if(in_array('all', $this->input->post("ddl_cost_center")))
				{
					$temp_arr = array();
					$cost_center_arr = "";
					foreach($data['cost_center_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$cost_center_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$cost_center_arr = implode(",",$this->input->post("ddl_cost_center"));
				}
				if(in_array('all', $this->input->post("ddl_employee_type")))
				{
					$temp_arr = array();
					$employee_type_arr = "";
					foreach($data['employee_type_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$employee_type_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$employee_type_arr = implode(",",$this->input->post("ddl_employee_type"));
				}
				if(in_array('all', $this->input->post("ddl_employee_role")))
				{
					$temp_arr = array();
					$employee_role_arr = "";
					foreach($data['employee_role_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$employee_role_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$employee_role_arr = implode(",",$this->input->post("ddl_employee_role"));
				}
				
				if(in_array('all', $this->input->post("ddl_tenure_company")))
				{
					$temp_arr = array();
					for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
					{
						array_push($temp_arr,$i); 
					}
					if($temp_arr)
					{
						$tenure_company_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$tenure_company_arr = implode(",",$this->input->post("ddl_tenure_company"));
				}
				
				if(in_array('all', $this->input->post("ddl_tenure_role")))
				{
					$temp_arr = array();
					for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
					{
						array_push($temp_arr,$i); 
					}
					if($temp_arr)
					{
						$tenure_role_arr = implode(",",$temp_arr);
					}
				}
				else
				{
					$tenure_role_arr = implode(",",$this->input->post("ddl_tenure_role"));
				}
				
				$where ="login_user.role > 1 AND login_user.status = 1";
				if($country_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_COUNTRY." IN (".$country_arr.")";
				}
				
				if($city_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_CITY." IN (".$city_arr.")";
				}
				
				if($bussiness_level_1_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." IN (".$bussiness_level_1_arr.")";
				}
				
				if($bussiness_level_2_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." IN (".$bussiness_level_2_arr.")";
				}
				
				if($bussiness_level_3_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." IN (".$bussiness_level_3_arr.")";
				}
				
				if($function_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_FUNCTION." IN (".$function_arr.")";
				}
				
				if($sub_function_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_SUBFUNCTION." IN (".$sub_function_arr.")";
				}
				
				if($sub_subfunction_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_SUB_SUBFUNCTION." IN (".$sub_subfunction_arr.")";
				}
				
				if($designation_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_DESIGNATION." IN (".$designation_arr.")";
				}
				
				if($grade_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_GRADE." IN (".$grade_arr.")";
				}
				
				if($level_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_LEVEL." IN (".$level_arr.")";
				}
				
				if($education_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_EDUCATION." IN (".$education_arr.")";
				}
				
				if($critical_talent_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_CRITICAL_TALENT." IN (".$critical_talent_arr.")";
				}
				
				if($critical_position_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_CRITICAL_POSITION." IN (".$critical_position_arr.")";
				}
				
				if($special_category_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_SPECIAL_CATEGORY." IN (".$special_category_arr.")";
				}
				
				if($cost_center_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_COST_CENTER." IN (".$cost_center_arr.")";
				}
				
				if($employee_type_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_EMPLOYEE_TYPE." IN (".$employee_type_arr.")";
				}
				
				if($employee_role_arr)
				{
					$where .= " AND login_user.".CV_BA_NAME_EMPLOYEE_ROLE." IN (".$employee_role_arr.")";
				}
				
				if($tenure_company_arr)
				{
					$where .= " AND login_user.tenure_company IN (".$tenure_company_arr.")";
				}
				
				if($tenure_role_arr)
				{
					$where .= " AND login_user.tenure_role IN (".$tenure_role_arr.")";
				}
				
				
				if($already_created_rule_for_emp_ids)
				{
					$where .= " AND login_user.id NOT IN (".implode(",",$already_created_rule_for_emp_ids).")";
				}
				
				$user_ids_arr = array();
				$sal_rule_usr_dtls_arr = $tmp_tbl_db_arr = array();
				//$data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
				$data['employees'] = $this->rule_model->get_employees_for_salary_rule_as_per_rights($where);
				if(!$data['employees'])
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');
					if($rule_id)
					{
						redirect(site_url("salary-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("salary-rule-filters/".$performance_cycle_id));
					}
				}
				else
				{	
					ini_set('memory_limit', '2024M');		
					$txt_cutoff_dt = $this->input->post("txt_cutoff_dt");					
					foreach($data['employees'] as $row)
					{
						/*if($txt_cutoff_dt != "")
						{*/
						$txt_cutoff_dt = date("Y-m-d",strtotime(str_replace("/","-",$txt_cutoff_dt)));							
						$joining_dt = date("Y-m-d",strtotime($row["increment_purpose_joining_date"]));
						if($row["increment_purpose_joining_date"] != "" and $joining_dt <= $txt_cutoff_dt)
						{
							$user_ids_arr[] = $row["id"];
							$tmp_tbl_db_arr[] = array("user_id"=>$row["id"]);
							$sal_rule_usr_dtls_arr[] = array(
							"user_id"=>$row["id"],
							"email"=>$row["email"],
							"name"=>$row["name"],
							"country"=>$row["country"],
							"city"=>$row["city"],
							"function"=>$row["function"],
							"subfunction"=>$row["subfunction"],
							"sub_subfunction"=>$row["sub_subfunction"],
							"business_level_1"=>$row["business_level_1"],
							"business_level_2"=>$row["business_level_2"],
							"business_level_3"=>$row["business_level_3"],
							"designation"=>$row["designation"],
							"grade"=>$row["grade"],
							"level"=>$row["level"],
							"education"=>$row["education"],
							"critical_talent"=>$row["critical_talent"],
							"critical_position"=>$row["critical_position"],
							"special_category"=>$row["special_category"],
							"tenure_company"=>$row["tenure_company"],
							"tenure_role"=>$row["tenure_role"],
							"currency"=>$row["currency"],
							"recently_promoted"=>$row["recently_promoted"],
							"company_joining_date"=>$row["company_joining_date"],
							"increment_purpose_joining_date"=>$row["increment_purpose_joining_date"],
							"start_date_for_role"=>$row["start_date_for_role"],
							"end_date_for_role"=>$row["end_date_for_role"],
							"bonus_incentive_applicable"=>$row["bonus_incentive_applicable"],
							"rating_for_last_year"=>$row["rating_for_last_year"],
							"rating_for_2nd_last_year"=>$row["rating_for_2nd_last_year"],
							"rating_for_3rd_last_year"=>$row["rating_for_3rd_last_year"],
							"rating_for_4th_last_year"=>$row["rating_for_4th_last_year"],
							"rating_for_5th_last_year"=>$row["rating_for_5th_last_year"],
							"rating_for_current_year"=>$row["rating_for_current_year"],
							"effective_date_of_last_salary_increase"=>$row["effective_date_of_last_salary_increase"],
							"effective_date_of_2nd_last_salary_increase"=>$row["effective_date_of_2nd_last_salary_increase"],
							"effective_date_of_3rd_last_salary_increase"=>$row["effective_date_of_3rd_last_salary_increase"],
							"effective_date_of_4th_last_salary_increase"=>$row["effective_date_of_4th_last_salary_increase"],
							"effective_date_of_5th_last_salary_increase"=>$row["effective_date_of_5th_last_salary_increase"],
							"salary_after_last_increase"=>$row["salary_after_last_increase"],
							"salary_after_2nd_last_increase"=>$row["salary_after_2nd_last_increase"],
							"salary_after_3rd_last_increase"=>$row["salary_after_3rd_last_increase"],
							"salary_after_4th_last_increase"=>$row["salary_after_4th_last_increase"],
							"salary_after_5th_last_increase"=>$row["salary_after_5th_last_increase"],
							"total_salary_after_last_increase"=>$row["total_salary_after_last_increase"],
							"total_salary_after_2nd_last_increase"=>$row["total_salary_after_2nd_last_increase"],
							"total_salary_after_3rd_last_increase"=>$row["total_salary_after_3rd_last_increase"],
							"total_salary_after_4th_last_increase"=>$row["total_salary_after_4th_last_increase"],
							"total_salary_after_5th_last_increase"=>$row["total_salary_after_5th_last_increase"],
							"target_salary_after_last_increase"=>$row["target_salary_after_last_increase"],
							"target_salary_after_2nd_last_increase"=>$row["target_salary_after_2nd_last_increase"],
							"target_salary_after_3rd_last_increase"=>$row["target_salary_after_3rd_last_increase"],
							"target_salary_after_4th_last_increase"=>$row["target_salary_after_4th_last_increase"],
							"target_salary_after_5th_last_increase"=>$row["target_salary_after_5th_last_increase"],
							"current_base_salary"=>$row["current_base_salary"],
							"current_target_bonus"=>$row["current_target_bonus"],
							"allowance_1"=>$row["allowance_1"],
							"allowance_2"=>$row["allowance_2"],
							"allowance_3"=>$row["allowance_3"],
							"allowance_4"=>$row["allowance_4"],
							"allowance_5"=>$row["allowance_5"],
							"allowance_6"=>$row["allowance_6"],
							"allowance_7"=>$row["allowance_7"],
							"allowance_8"=>$row["allowance_8"],
							"allowance_9"=>$row["allowance_9"],
							"allowance_10"=>$row["allowance_10"],
							"allowance_11"=>$row["allowance_11"],
							"allowance_12"=>$row["allowance_12"],
							"allowance_13"=>$row["allowance_13"],
							"allowance_14"=>$row["allowance_14"],
							"allowance_15"=>$row["allowance_15"],
							"allowance_16"=>$row["allowance_16"],
							"allowance_17"=>$row["allowance_17"],
							"allowance_18"=>$row["allowance_18"],
							"allowance_19"=>$row["allowance_19"],
							"allowance_20"=>$row["allowance_20"],
							"allowance_21"=>$row["allowance_21"],
							"allowance_22"=>$row["allowance_22"],
							"allowance_23"=>$row["allowance_23"],
							"allowance_24"=>$row["allowance_24"],
							"allowance_25"=>$row["allowance_25"],
							"allowance_26"=>$row["allowance_26"],
							"allowance_27"=>$row["allowance_27"],
							"allowance_28"=>$row["allowance_28"],
							"allowance_29"=>$row["allowance_29"],
							"allowance_30"=>$row["allowance_30"],
							"allowance_31"=>$row["allowance_31"],
							"allowance_32"=>$row["allowance_32"],
							"allowance_33"=>$row["allowance_33"],
							"allowance_34"=>$row["allowance_34"],
							"allowance_35"=>$row["allowance_35"],
							"allowance_36"=>$row["allowance_36"],
							"allowance_37"=>$row["allowance_37"],
							"allowance_38"=>$row["allowance_38"],
							"allowance_39"=>$row["allowance_39"],
							"allowance_40"=>$row["allowance_40"],
							"total_compensation"=>$row["total_compensation"],
							"increment_applied_on"=>$row["increment_applied_on"],
							"job_code"=>$row["job_code"],
							"job_name"=>$row["job_name"],
							"job_level"=>$row["job_level"],
							"market_target_salary_level_min"=>$row["market_target_salary_level_min"],
							"market_total_salary_level_min"=>$row["market_total_salary_level_min"],
							"market_base_salary_level_min"=>$row["market_base_salary_level_min"],
							"market_target_salary_level_1"=>$row["market_target_salary_level_1"],
							"market_total_salary_level_1"=>$row["market_total_salary_level_1"],
							"market_base_salary_level_1"=>$row["market_base_salary_level_1"],
							"market_target_salary_level_2"=>$row["market_target_salary_level_2"],
							"market_total_salary_level_2"=>$row["market_total_salary_level_2"],
							"market_base_salary_level_2"=>$row["market_base_salary_level_2"],
							"market_target_salary_level_3"=>$row["market_target_salary_level_3"],
							"market_total_salary_level_3"=>$row["market_total_salary_level_3"],
							"market_base_salary_level_3"=>$row["market_base_salary_level_3"],
							"market_target_salary_level_4"=>$row["market_target_salary_level_4"],
							"market_total_salary_level_4"=>$row["market_total_salary_level_4"],
							"market_base_salary_level_4"=>$row["market_base_salary_level_4"],
							"market_target_salary_level_5"=>$row["market_target_salary_level_5"],
							"market_total_salary_level_5"=>$row["market_total_salary_level_5"],
							"market_base_salary_level_5"=>$row["market_base_salary_level_5"],
							"market_target_salary_level_6"=>$row["market_target_salary_level_6"],
							"market_total_salary_level_6"=>$row["market_total_salary_level_6"],
							"market_base_salary_level_6"=>$row["market_base_salary_level_6"],
							"market_target_salary_level_7"=>$row["market_target_salary_level_7"],
							"market_total_salary_level_7"=>$row["market_total_salary_level_7"],
							"market_base_salary_level_7"=>$row["market_base_salary_level_7"],
							"market_target_salary_level_8"=>$row["market_target_salary_level_8"],
							"market_total_salary_level_8"=>$row["market_total_salary_level_8"],
							"market_base_salary_level_8"=>$row["market_base_salary_level_8"],
							"market_target_salary_level_9"=>$row["market_target_salary_level_9"],
							"market_total_salary_level_9"=>$row["market_total_salary_level_9"],
							"market_base_salary_level_9"=>$row["market_base_salary_level_9"],
							"market_target_salary_sevel_max"=>$row["market_target_salary_sevel_max"],
							"market_total_salary_level_max"=>$row["market_total_salary_level_max"],
							"market_base_salary_level_max"=>$row["market_base_salary_level_max"],
							"company_1_base_salary_min"=>$row["company_1_base_salary_min"],
							"company_1_base_salary_max"=>$row["company_1_base_salary_max"],
							"company_1_base_salary_average"=>$row["company_1_base_salary_average"],
							"company_2_base_salary_min"=>$row["company_2_base_salary_min"],
							"company_2_base_salary_max"=>$row["company_2_base_salary_max"],
							"company_2_base_salary_average"=>$row["company_2_base_salary_average"],
							"company_3_base_salary_min"=>$row["company_3_base_salary_min"],
							"company_3_base_salary_max"=>$row["company_3_base_salary_max"],
							"company_3_base_salary_average"=>$row["company_3_base_salary_average"],
							"average_base_salary_min"=>$row["average_base_salary_min"],
							"average_base_salary_max"=>$row["average_base_salary_max"],
							"average_base_salary_average"=>$row["average_base_salary_average"],
							"company_1_target_salary_min"=>$row["company_1_target_salary_min"],
							"company_1_target_salary_max"=>$row["company_1_target_salary_max"],
							"company_1_target_salary_average"=>$row["company_1_target_salary_average"],
							"company_2_target_salary_min"=>$row["company_2_target_salary_min"],
							"company_2_target_salary_max"=>$row["company_2_target_salary_max"],
							"company_2_target_salary_average"=>$row["company_2_target_salary_average"],
							"company_3_target_salary_min"=>$row["company_3_target_salary_min"],
							"company_3_target_salary_max"=>$row["company_3_target_salary_max"],
							"company_3_target_salary_average"=>$row["company_3_target_salary_average"],
							"average_target_salary_min"=>$row["average_target_salary_min"],
							"average_target_salary_max"=>$row["average_target_salary_max"],
							"average_target_salary_average"=>$row["average_target_salary_average"],
							"company_1_total_salary_min"=>$row["company_1_total_salary_min"],
							"company_1_total_salary_max"=>$row["company_1_total_salary_max"],
							"company_1_total_salary_average"=>$row["company_1_total_salary_average"],
							"company_2_total_salary_min"=>$row["company_2_total_salary_min"],
							"company_2_sotal_salary_max"=>$row["company_2_sotal_salary_max"],
							"company_2_total_salary_average"=>$row["company_2_total_salary_average"],
							"company_3_total_salary_min"=>$row["company_3_total_salary_min"],
							"company_3_total_salary_max"=>$row["company_3_total_salary_max"],
							"company_3_total_salary_average"=>$row["company_3_total_salary_average"],
							"average_total_salary_min"=>$row["average_total_salary_min"],
							"average_total_salary_max"=>$row["average_total_salary_max"],
							"average_total_salary_average"=>$row["average_total_salary_average"],
							"approver_1"=>$row["approver_1"],
							"approver_2"=>$row["approver_2"],
							"approver_3"=>$row["approver_3"],
							"approver_4"=>$row["approver_4"],
							"manager_name"=>$row["manager_name"],
							"authorised_signatory_for_letter"=>$row["authorised_signatory_for_letter"],
							"authorised_signatorys_title_for_letter"=>$row["authorised_signatorys_title_for_letter"],
							"hr_authorised_signatory_for_letter"=>$row["hr_authorised_signatory_for_letter"],
							"hr_authorised_signatorys_title_for_letter"=>$row["hr_authorised_signatorys_title_for_letter"],
							"company_name"=>$row["company_name"],
							"gender"=>$row["gender"],
							"first_name"=>$row["first_name"],
							"employee_code"=>$row["employee_code"],
							"performance_achievement"=>$row["performance_achievement"],
							"teeth_tail_ratio"=>$row["teeth_tail_ratio"],
							"previous_talent_rating"=>$row["previous_talent_rating"],
							"promoted_in_2_yrs"=>$row["promoted_in_2_yrs"],
							"engagement_level"=>$row["engagement_level"],
							"successor_identified"=>$row["successor_identified"],
							"readyness_level"=>$row["readyness_level"],
							"urban_rural_classification"=>$row["urban_rural_classification"],
							"employee_movement_into_bonus_plan"=>$row["employee_movement_into_bonus_plan"],
							"other_data_9"=>$row["other_data_9"],
							"other_data_10"=>$row["other_data_10"],
							"other_data_11"=>$row["other_data_11"],
							"other_data_12"=>$row["other_data_12"],
							"other_data_13"=>$row["other_data_13"],
							"other_data_14"=>$row["other_data_14"],
							"other_data_15"=>$row["other_data_15"],
							"other_data_16"=>$row["other_data_16"],
							"other_data_17"=>$row["other_data_17"],
							"other_data_18"=>$row["other_data_18"],
							"other_data_19"=>$row["other_data_19"],
							"other_data_20"=>$row["other_data_20"],							
							"cost_center"=>$row["cost_center"],
							"employee_type"=>$row["employee_type"],
							"employee_role"=>$row["employee_role"],
							"other_data_21"=>$row["other_data_21"],
							"other_data_22"=>$row["other_data_22"],
							"other_data_23"=>$row["other_data_23"],
							"other_data_24"=>$row["other_data_24"]
							);
						}
						/*}
						else
						{
							$user_ids_arr[] = $row["id"];
						}	*/					
					}
				}
				
				if(count($user_ids_arr) <= 0)
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');
					if($rule_id)
					{
						redirect(site_url("salary-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("salary-rule-filters/".$performance_cycle_id));
					}
				}
				
				$effective_dt_arr = explode("/",$this->input->post('txt_effective_dt')); 
				
				$usr_ids = implode(",",$user_ids_arr);
				$db_arr = array(
						"performance_cycle_id" => $performance_cycle_id,
						"salary_rule_name" => $this->input->post('txt_salary_rule_name'),
									//"user_ids" => $usr_ids,
						// "country" => HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY),
						// "city" => HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY),
						// "business_level1" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1),
						// "business_level2" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2),
						// "business_level3" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3),
						// "functions" => HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION),
						// "sub_functions" => HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION),
						// "designations" => HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION),
						// "grades" => HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE),
						// "levels" => HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL),
						// "educations" => HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION),
						// "critical_talents" => HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT),
						// "critical_positions" => HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION),
						// "special_category" => HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY),
						"tenure_company" => $tenure_company_arr,
						"tenure_roles" => $tenure_role_arr,
						"effective_dt" => $effective_dt_arr[2].'-'.$effective_dt_arr[1].'-'.$effective_dt_arr[0],
						"cutoff_date" => $txt_cutoff_dt,
						"updatedby" => $this->session->userdata('userid_ses'),
						"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
						"updatedon" => date("Y-m-d H:i:s")
				);
				$db_arr['sub_subfunctions'] = "";
				
				/*if(HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY)){
					$db_arr['country'] = HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY)){
					$db_arr['city'] = HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY); 
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1)){
					$db_arr['business_level1'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2)){
					$db_arr['business_level2'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3)){
					$db_arr['business_level3'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3);
				}  
				if(HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION)){
					$db_arr['functions'] = HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION);
				}             
				if(HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION)){
					$db_arr['sub_functions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION)){
					$db_arr['designations'] = HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION);
				}                
				if(HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE)){
					$db_arr['grades'] = HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE);
				} 
				if(HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL)){
					$db_arr['levels'] = HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL);
				} 
				if(HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION)){
					$db_arr['educations'] = HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT)){
					$db_arr['critical_talents'] = HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION)){
					$db_arr['critical_positions'] = HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION);
				}
				if(HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY)){
					$db_arr['special_category'] = HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY);
				}
				
				if(HLP_get_unique_ids_for_filters($usr_ids, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION)){
					$db_arr['sub_subfunctions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION);
				}*/
				
				/* ******** Start :: Tmp tbl creation & insertion of user ids */
				$table_name = "temp_tbl_user_ids";
				$this->load->dbforge();
				$this->dbforge->drop_table($table_name,TRUE);
				$this->dbforge->add_field(array("user_id" => array('type' => 'INT', 'constraint' => 11)));
				$attributes = array('ENGINE' => 'InnoDB');
				$this->dbforge->create_table($table_name, FALSE, $attributes);
				$this->rule_model->insert_data_as_batch($table_name, $tmp_tbl_db_arr);
				$get_usr_qry = "SELECT user_id FROM temp_tbl_user_ids";
				/* ******** Start :: Tmp tbl creation & insertion of user ids */
				
				$unique_countries = HLP_get_unique_ids_for_filters($get_usr_qry, $country_arr, CV_BA_NAME_COUNTRY);
				if($unique_countries)
				{
					$db_arr['country'] = $unique_countries;
				}
				$unique_cities = HLP_get_unique_ids_for_filters($get_usr_qry, $city_arr, CV_BA_NAME_CITY);
				if($unique_cities)
				{
					$db_arr['city'] = $unique_cities; 
				}
				$unique_bl1s = HLP_get_unique_ids_for_filters($get_usr_qry, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1);
				if($unique_bl1s)
				{
					$db_arr['business_level1'] = $unique_bl1s;
				}
				$unique_bl2s = HLP_get_unique_ids_for_filters($get_usr_qry, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2);
				if($unique_bl2s)
				{
					$db_arr['business_level2'] = $unique_bl2s;
				}
				$unique_bl3s = HLP_get_unique_ids_for_filters($get_usr_qry, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3);
				if($unique_bl3s)
				{
					$db_arr['business_level3'] = $unique_bl3s;
				} 
				$unique_functions=HLP_get_unique_ids_for_filters($get_usr_qry, $function_arr, CV_BA_NAME_FUNCTION);
				if($unique_functions)
				{
					$db_arr['functions'] = $unique_functions;
				}     
				$unique_sub_functions = HLP_get_unique_ids_for_filters($get_usr_qry, $sub_function_arr, CV_BA_NAME_SUBFUNCTION);
				if($unique_sub_functions)
				{
					$db_arr['sub_functions'] = $unique_sub_functions;
				}
				$unique_sub_subfunctions = HLP_get_unique_ids_for_filters($get_usr_qry, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION);
				if($unique_sub_subfunctions)
				{
					$db_arr['sub_subfunctions'] = $unique_sub_subfunctions;
				}
				$unique_designations = HLP_get_unique_ids_for_filters($get_usr_qry, $designation_arr, CV_BA_NAME_DESIGNATION);
				if($unique_designations)
				{
					$db_arr['designations'] = $unique_designations;
				} 
				$unique_grades = HLP_get_unique_ids_for_filters($get_usr_qry, $grade_arr, CV_BA_NAME_GRADE);
				if($unique_grades)
				{
					$db_arr['grades'] = $unique_grades;
				} 
				$unique_levels = HLP_get_unique_ids_for_filters($get_usr_qry, $level_arr, CV_BA_NAME_LEVEL);
				if($unique_levels)
				{
					$db_arr['levels'] = $unique_levels;
				} 
				$unique_educations = HLP_get_unique_ids_for_filters($get_usr_qry, $education_arr, CV_BA_NAME_EDUCATION);
				if($unique_educations)
				{
					$db_arr['educations'] = $unique_educations;
				}
				$unique_critical_talents = HLP_get_unique_ids_for_filters($get_usr_qry, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT);
				if($unique_critical_talents)
				{
					$db_arr['critical_talents'] = $unique_critical_talents;
				}
				$unique_critical_positions = HLP_get_unique_ids_for_filters($get_usr_qry, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION);
				if($unique_critical_positions)
				{
					$db_arr['critical_positions'] = $unique_critical_positions;
				}
				$unique_special_categories = HLP_get_unique_ids_for_filters($get_usr_qry, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY);
				if($unique_special_categories)
				{
					$db_arr['special_category'] = $unique_special_categories;
				}
				
				$unique_cost_centers = HLP_get_unique_ids_for_filters($get_usr_qry, $cost_center_arr, CV_BA_NAME_COST_CENTER);
				if($unique_cost_centers)
				{
					$db_arr['cost_centers'] = $unique_cost_centers;
				}
				$unique_employee_types = HLP_get_unique_ids_for_filters($get_usr_qry, $employee_type_arr, CV_BA_NAME_EMPLOYEE_TYPE);
				if($unique_employee_types)
				{
					$db_arr['employee_types'] = $unique_employee_types;
				}
				$unique_employee_roles = HLP_get_unique_ids_for_filters($get_usr_qry, $employee_role_arr, CV_BA_NAME_EMPLOYEE_ROLE);
				if($unique_employee_roles)
				{
					$db_arr['employee_roles'] = $unique_employee_roles;
				}
				
				$this->dbforge->drop_table($table_name,TRUE);
				
				
				
				if($this->input->post("btn_confirm_selection"))
				{
					if($rule_id > 0)
					{
						$data["rule_dtls"] = array_merge($data["rule_dtls"],$db_arr);
					}
					else
					{
						$data["rule_dtls"] = $db_arr;
					}
					$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
					$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
					$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
					$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
					$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
					$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
					$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
					$data["rule_dtls"]["sub_subfunctions"] = explode(",",$data["rule_dtls"]["sub_subfunctions"]);
					$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
					$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
					$data["rule_dtls"]["levels"] = explode(",",$data["rule_dtls"]["levels"]);
					$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
					$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
					$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
					$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
					$data["rule_dtls"]["cost_centers"] = explode(",",$data["rule_dtls"]["cost_centers"]);
					$data["rule_dtls"]["employee_types"] = explode(",",$data["rule_dtls"]["employee_types"]);
					$data["rule_dtls"]["employee_roles"] = explode(",",$data["rule_dtls"]["employee_roles"]);
					$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
					$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);					
					//echo "<pre>";print_r($data["rule_dtls"]);die;
				}
				else
				{
					if($is_need_update > 0 and $rule_id > 0)
					{
						if($data["rule_dtls"]["status"]==5)
						{
							$db_arr["status"] = 3;
						}
						$this->rule_model->update_rules(array("id"=>$rule_id), $db_arr); 
					}
					else
					{
						$db_arr["promotion_basis_on"] = 2;
						$db_arr["hike_multiplier_basis_on"] = 0;
						$db_arr["status"] = 1;
						$db_arr["createdby"] = $this->session->userdata('userid_ses');
						$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
						$db_arr["createdon"] = date("Y-m-d H:i:s");						
						$rule_id = $this->rule_model->insert_rules($db_arr);
					}
				
					if($rule_id)
					{
						$db_rule_usr_dtl_arr = array();
						foreach($sal_rule_usr_dtls_arr as $emp_row)
						{
							//$db_rule_usr_dtl_arr[] = array("rule_id"=>$rule_id, "user_id"=>$usr_id);
							$emp_row["rule_id"] = $rule_id;
							$db_rule_usr_dtl_arr[] = $emp_row;
						}
						if($db_rule_usr_dtl_arr)
						{
							$this->rule_model->delete_emps_frm_rule_dtls("salary_rule_users_dtls", array("rule_id"=>$rule_id));
							$this->db->trans_start();
							$chunk_data_arr = array_chunk($db_rule_usr_dtl_arr, 2000);							
							foreach($chunk_data_arr as $key => $chunk_db_arr)
							{
								$this->db->insert_batch('salary_rule_users_dtls', $chunk_db_arr);
							}							
							$this->db->trans_complete();							
							//$this->rule_model->insert_data_as_batch("salary_rule_users_dtls", $db_rule_usr_dtl_arr);
						}
						
						if($this->input->post('ddl_quick_plan')>0 and $this->input->post('txt_budget_per')>0)
						{
							$this->apply_quick_model($rule_id, $this->input->post('ddl_quick_plan'), $this->input->post('txt_budget_per'));
							$this->session->set_flashdata('step', '1');
							$this->session->set_flashdata('ses_open_by_quick_plan', '1');
						}
						
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You are covering '.count($user_ids_arr).' employees under this rule.</b></div>'); 
						redirect(site_url("create-salary-rules/".$rule_id));	
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></span></div>'); 
						if($rule_id)
						{
							redirect(site_url("salary-rule-filters/".$performance_cycle_id."/".$rule_id));
						}
						else
						{
							redirect(site_url("salary-rule-filters/".$performance_cycle_id));
						}
					}
				}
			}
		}

		if($country_arr_view)
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		
		
		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}
		
		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}
		
		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}
		
		if($designation_arr_view)
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}
		
		if($function_arr_view)
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}
		
		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
		}
		
		if($sub_subfunction_arr_view)
		{
			$data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1 AND id IN(".$sub_subfunction_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1", "name asc");			
		}		
		
		if($grade_arr_view)
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}
		
		if($level_arr_view)
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}		
		
		$data['quick_module_list'] = $this->rule_model->get_table("quick_modules","id, plan_name", "status = 1", "plan_name ASC");
		
		$data['rule_list_pg_url'] = site_url("salary-rule-list/".$data['performance_cycle_dtls']['id']);
		$data['tooltip'] = getToolTip('salary-rule-filter');
		
		$data['rule_type'] = "salary";
		$data['title'] = "Salary Rule Filters";
		$data['body'] = "salary_rule_filters";
		$this->load->view('common/structure',$data);
	}

	public function create_rules($rule_id)
	{
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.createdby"=>$this->session->userdata('userid_ses'), "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or ($data['rule_dtls']["status"] > 4 and $data['rule_dtls']["rule_refresh_status"] != 1))
		{
			redirect(site_url("performance-cycle"));
		}
		
		if(!helper_have_rights(CV_SALARY_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			redirect(site_url("salary-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		
		$data["market_salary_elements_list"] = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", array("business_attribute.status"=>1, "business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')), "ba_attributes_order ASC");
		
		$data["emp_not_any_cycle_counts"] = $this->emp_not_any_cycle($data['rule_dtls']["performance_cycle_id"]);
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		$conditions=' rule_for=1 and bonus_given=1 and status='.CV_STATUS_RULE_RELEASED;
		$data["bonusListForSalaryRuleCreation"] =getSingleTableData('hr_parameter_bonus',$conditions,'id,bonus_rule_name') ;
		
		$data['title'] = "Create Rules";
		$data['body'] = "salary/create_rules";
		$this->load->view('common/structure',$data);
	}

	public function get_comparative_ratio_element_for_no()
	{
		$ddl_str = '';
		$market_salary = $this->rule_model->get_market_salary_header_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary)
		{
			foreach ($market_salary as $row)
			{
			$ddl_str .= '<option value="'.$row["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$row['ba_name'].'">'.$row["display_name"].'</option>';
			}
			echo $ddl_str;
		}
		else
		{
			echo $ddl_str;//Means No market_salary_elements are available or market_salary_elements Attribute are InActive In Business Attribute Table
		}		
	}
	
	public function get_ratings_list()
	{
		$ddl_name = "ddl_market_salary_".$this->input->post("txt_name");
		$hf_name = "hf_".$this->input->post("txt_name")."_name";
		$rule_id = $this->input->post("rule_id");
		if($this->input->post("txt_name")=="rating")
		{
			$ddl_str = '<input type="text" name="'.$ddl_name.'[]" class="form-control" required onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" />';
		}
		else
		{
			$market_salary = $this->rule_model->get_market_salary_header_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')));
			if($market_salary)
			{
				$ddl_str = '<select class="form-control" name="'.$ddl_name.'[]" required >';
				foreach ($market_salary as $row)
				{
				$ddl_str .= '<option value="'.$row["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$row['ba_name'].'">'.$row["display_name"].'</option>';
				}
				$ddl_str .= '</select>';
			}
			else
			{
				echo "";//Means No market_salary_elements are available or market_salary_elements Attribute are InActive In Business Attribute Table
				die;
			}			
		}
		
		//$ratings = $this->rule_model->get_ratings_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_RATING_ELEMENT));
		//$ratings = $this->rule_model->get_ratings_list();
		$ratings = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
		if($ratings)
		{
			foreach ($ratings as $row)
			{
				echo '<div class="form-group"><div class="row"><div class="col-sm-6">';
				echo '<label class="control-label">'.$row['value'].'</label></div>';
				echo '<div class="col-sm-6">
				<input type="hidden" id="'.$row['id'].'" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['value'].'" name="'.$hf_name.'[]" />
				'.$ddl_str.'
				</div></div>
				</div>';
			}
		}
		else
		{
			echo "";//Means No Ratings available or Rating Attribute is InActive In Business Attribute Table
		}		
	}
	
	public function get_multipliers_list($rule_id, $elements_for)
	{	
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));	
		$tbl_name = "manage_country";
		$col_name = "country";
		$cnd_str = "status = 1 ";
		$lbl_prefix = "Country - ";
		
		if($elements_for == "2")
		{
			$col_name = "grades";
			$tbl_name = "manage_grade";
			$lbl_prefix = "Grade - ";
		}
		elseif($elements_for == "3")
		{
			$col_name = "levels";
			$tbl_name = "manage_level";
			$lbl_prefix = "Level - ";
		}
		
		$cnd_str .= " AND id IN (".$rule_dtls[$col_name].")";
		$multiplier_elements_list = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
		
		$hike_multiplier_arr = json_decode($rule_dtls["hike_multiplier_dtls"], true);
		if($rule_dtls["hike_multiplier_basis_on"] != $elements_for)
		{
			$hike_multiplier_arr = array();
		}
		$str = "";
		foreach($multiplier_elements_list as $row)
		{
			$m_val = "";
			if(isset($hike_multiplier_arr[$row["id"]]))
			{
				$m_val = $hike_multiplier_arr[$row["id"]];
			}
			$str .= '<div class="col-sm-6 removed_padding">
						<label class="control-label">'.$lbl_prefix.$row['name'].'</label></div>';
			$str .= '<div class="col-sm-6 pad_r0">
						<input class="form-control" type="text" id="txt_multiplier_element_'.$row["id"].'" name="txt_multiplier_elements[]" value="'.$m_val.'" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" maxlength="6"/>
						<input type="hidden" name="hf_multiplier_elements[]" value="'.$row["id"].'"/>
					</div>';
		}
		echo $str;
	}
	
	public function get_promotion_basis_on_elements_list($rule_id, $elements_for)
	{	
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));	
		
		$cnd_str = "status = 1 ";
		$col_name = "grades";
		$tbl_name = "manage_grade";
		$lbl_prefix = "Promotion %age for Grade - ";
		
		if($elements_for == "1")
		{
			$col_name = "designations";	
			$tbl_name = "manage_designation";			
			$lbl_prefix = "Promotion %age for Designation - ";
		}
		elseif($elements_for == "3")
		{
			$col_name = "levels";
			$tbl_name = "manage_level";
			$lbl_prefix = "Promotion %age for Level - ";
		}
		
		$cnd_str .= " AND id IN (".$rule_dtls[$col_name].")";
		$elements_list = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
		
		$promotion_type_element_dtls_arr = json_decode($rule_dtls["promotion_type_element_dtls"], true);
		if($rule_dtls["promotion_basis_on"] != $elements_for)
		{
			$promotion_type_element_dtls_arr = array();
		}
		$str = "";
		foreach($elements_list as $row)
		{
			$val = "";
			if(isset($promotion_type_element_dtls_arr[$row["id"]]))
			{
				$val = $promotion_type_element_dtls_arr[$row["id"]];
			}
			$str .= '<div class="col-sm-6 removed_padding">
						<label class="control-label">'.$lbl_prefix.$row['name'].'</label></div>';
			$str .= '<div class="col-sm-6 pad_right0">
						<input class="form-control" type="text" id="txt_promotion_type_element_'.$row["id"].'" name="txt_promotion_type_elements[]" value="'.$val.'" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" maxlength="6"/>
						<input type="hidden" name="hf_promotion_type_elements[]" value="'.$row["id"].'"/>
					</div>';
		}
		echo $str;
	}

	public function get_salary_rule_step2_frm($rule_id)
	{
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$data['rule_dtls']  or ($data['rule_dtls']["status"] > 3 and $data['rule_dtls']["rule_refresh_status"] != 1) or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}	
	
		$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id, (SELECT ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR." FROM login_user WHERE id = salary_rule_users_dtls.user_id) AS ". CV_BA_NAME_RATING_FOR_CURRENT_YEAR, array("rule_id"=>$rule_id), "user_id ASC");
		$data["total_emps_cnt"] = count($staff_list);
		
		if($data["rule_dtls"]['performnace_based_hike']=='yes')
		{		
			//$rating_elements_list = $this->rule_model->get_ratings_list();
			$rating_elements_list = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
			if($rating_elements_list)
			{
				$temp_arr = array();
				//$staff_list = explode(",",$data['rule_dtls']['user_ids']);	
			
				foreach($rating_elements_list as $row)
				{
					$row["rating_wise_total_emps"] = 0;
					foreach($staff_list as $emp_id)
					{
						/*$users_dtls = $this->rule_model->get_table_row("login_user", "id, ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR."", array("id"=>$emp_id["user_id"]), "id desc");
						
						if(strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) == strtoupper($row["id"]))*/
						if($emp_id[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] == $row["id"])
						{
							$row["rating_wise_total_emps"]++;
						}					
					}
					$temp_arr[] = $row;
				}
				$data["rating_list"] = $temp_arr;
			}
			else
			{
				$data["rating_list"] = "";
			}
		}
		else
		{
			$data["rating_list"] = "";
		}
	
		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary_elements_list)
		{
			$data["market_salary_elements_list"] = $market_salary_elements_list;
		}
		else
		{
			$data["market_salary_elements_list"] = "";
		}
		$this->load->view('salary/create_rules_partial',$data);		
	}
	
	public function get_salary_rule_step3_frm($rule_id)
	{
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$data['rule_dtls']  or ($data['rule_dtls']["status"] > 3 and $data['rule_dtls']["rule_refresh_status"] != 1) or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}	
			
		if($data["rule_dtls"]['performnace_based_hike']=='yes')
		{
			$rating_elements_list = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
			if($rating_elements_list)
			{						
				$data["rating_list"] = $rating_elements_list;
			}
			else
			{
				$data["rating_list"] = "";
			}
		}
		else
		{
			$data["rating_list"] = "";
		}
		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary_elements_list)
		{
			$data["market_salary_elements_list"] = $market_salary_elements_list;
		}
		else
		{
			$data["market_salary_elements_list"] = "";
		}
		
		/*************** :: Start :: Data for creating Increment Grids after applying Hike Multipliers ******/
		$tbl_name = "manage_country";
		$col_name = "country";
		$cnd_str = "status = 1 ";
		$lbl_prefix = "Country - ";
		
		if($data["rule_dtls"]['hike_multiplier_basis_on'] == "2")
		{
			$col_name = "grades";
			$tbl_name = "manage_grade";
			$lbl_prefix = "Grade - ";
		}
		elseif($data["rule_dtls"]['hike_multiplier_basis_on'] == "3")
		{
			$col_name = "levels";
			$tbl_name = "manage_level";
			$lbl_prefix = "Level - ";
		}		
		$cnd_str .= " AND id IN (".$data["rule_dtls"][$col_name].")";
		$data["multiplier_elements_list"] = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
		$data["lbl_prefix"] = $lbl_prefix;
		/*************** :: END :: Data for creating Increment Grids after applying Hike Multipliers ******/					
		$this->load->view('salary/increment_grid_after_multiplier',$data);		
	}	

	public function get_salary_rule_step4_frm($rule_id)
	{
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$data['rule_dtls']  or ($data['rule_dtls']["status"] > 3 and $data['rule_dtls']["rule_refresh_status"] != 1) or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}	
		
		// ******* Below code used only for loading the view as create_rules_partial.php Started ********/
		$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id, (SELECT ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR." FROM login_user WHERE id = salary_rule_users_dtls.user_id) AS ". CV_BA_NAME_RATING_FOR_CURRENT_YEAR, array("rule_id"=>$rule_id), "user_id ASC");
		$data["total_emps_cnt"] = count($staff_list);
	
		if($data["rule_dtls"]['performnace_based_hike']=='yes')
		{			
			//$rating_elements_list=$this->rule_model->get_ratings_list(array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
			//$rating_elements_list=$this->rule_model->get_ratings_list();
			$rating_elements_list = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
			if($rating_elements_list)
			{
				$temp_arr = array();
				//$staff_list = explode(",",$data['rule_dtls']['user_ids']);	
				foreach($rating_elements_list as $row)
				{
					$row["rating_wise_total_emps"] = 0;
					foreach($staff_list as $emp_id)
					{
						/*$users_dtls = $this->rule_model->get_table_row("login_user", "id, ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR."", array("id"=>$emp_id["user_id"]), "id desc");
						
						if(strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) == strtoupper($row["id"]))*/
						if($emp_id[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] == $row["id"])
						{
							$row["rating_wise_total_emps"]++;
						}					
					}
					$temp_arr[] = $row;
				}			
				$data["rating_list"] = $temp_arr;
			}
			else
			{
				$data["rating_list"] = "";
			}
		}
		else
		{
			$data["rating_list"] = "";
		}
		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary_elements_list)
		{
			$data["market_salary_elements_list"] = $market_salary_elements_list;
		}
		else
		{
			$data["market_salary_elements_list"] = "";
		}
		$data["is_show_on_manager"] = 1;
		
		/*************** :: Start :: Data for creating Increment Grids after applying Hike Multipliers ******/
		if($data["rule_dtls"]['hike_multiplier_basis_on'])
		{
			$tbl_name = "manage_country";
			$col_name = "country";
			$cnd_str = "status = 1 ";
			$lbl_prefix = "Country - ";
			
			if($data["rule_dtls"]['hike_multiplier_basis_on'] == "2")
			{
				$col_name = "grades";
				$tbl_name = "manage_grade";
				$lbl_prefix = "Grade - ";
			}
			elseif($data["rule_dtls"]['hike_multiplier_basis_on'] == "3")
			{
				$col_name = "levels";
				$tbl_name = "manage_level";
				$lbl_prefix = "Level - ";
			}		
			$cnd_str .= " AND id IN (".$data["rule_dtls"][$col_name].")";
			$data["multiplier_elements_list"] = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
			$data["lbl_prefix"] = $lbl_prefix;
		}
		/*************** :: END :: Data for creating Increment Grids after applying Hike Multipliers ******/		
		
		$data["partial_body"] = $this->load->view('salary/create_rules_partial',$data, true);
		// ******* Above code used only for loading the view as create_rules_partial.php Ended ********/
		
		$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));	
		$this->load->view('salary/create_rules_partial_for_manager_dtls',$data);		
	}
	
	public function apply_quick_model($rule_id, $quick_plan_id, $budget_per)
	{		
		$quick_dtls=$this->rule_model->get_table_row("quick_modules", "*", array("id"=>$quick_plan_id), "id desc");
		$salary_applied_on_elem_list = $this->rule_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS salary_elements", "business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		$ratings = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
		$default_currency = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		
		$performnace_based_hike_ratings_arr = $comparative_ratio_calculations_arr = $crr_percent_arr = $overall_maximum_age_increase_arr = array();
		$i=1;
		$first_rating_val = $budget_per*$quick_dtls["hike_calculation_multiplier"];
		$second_last_rating_val = $budget_per/$quick_dtls["hike_calculation_multiplier"];
		$rating_dif = ($first_rating_val - $second_last_rating_val)/(count($ratings)-2);
		$previous_rating_val = $first_rating_val;
		
		foreach($ratings as $r_row)
		{
			if($i==1)
			{
				$performnace_based_hike_ratings_arr[$r_row["id"].CV_CONCATENATE_SYNTAX.$r_row['value']] = $first_rating_val;
			}
			elseif($i == count($ratings))
			{
				$performnace_based_hike_ratings_arr[$r_row["id"].CV_CONCATENATE_SYNTAX.$r_row['value']] = 0;
			}
			else
			{
				$previous_rating_val = $previous_rating_val-$rating_dif;
				$performnace_based_hike_ratings_arr[$r_row["id"].CV_CONCATENATE_SYNTAX.$r_row['value']] = $previous_rating_val;
			}
			$comparative_ratio_calculations_arr[$r_row["id"].CV_CONCATENATE_SYNTAX.$r_row['value']] = $quick_dtls["default_market_benchmark"];
			$i++;
		}
		
		$ranges_multiplier_arr = explode(",", $quick_dtls["crr_calculation_multiplier"]);
		for($j=0; $j< count($ranges_multiplier_arr); $j++)
		{
			$previous_rating_val = $first_rating_val;
			$temp_crr_percent_arr = array();
			foreach($performnace_based_hike_ratings_arr as $key=>$value)
			{
				$temp_crr_percent_arr[] = $value*$ranges_multiplier_arr[$j];
				if($j==0)
				{
					$overall_maximum_age_increase_arr[] = $value+($value*$ranges_multiplier_arr[$j]);
				}
			}
			$crr_percent_arr[] = $temp_crr_percent_arr;
		}
		
		$db_arr = array(
						'salary_applied_on_elements'=>$salary_applied_on_elem_list["salary_elements"],								
						//'standard_promotion_increase' => $quick_dtls["standard_promotion_increase"],
						'include_inactive' => $quick_dtls["include_inactive"],
						'prorated_increase' => $quick_dtls["prorated_increase"],
						'Manager_discretionary_increase' => $quick_dtls["manager_discretionary_increase"],
						'Manager_discretionary_decrease' => $quick_dtls["manager_discretionary_decrease"],
						'overall_budget' => $quick_dtls["overall_budget"],
						'manager_can_exceed_budget' => $quick_dtls["manager_can_exceed_budget"],
						'include_promotion_budget' => $quick_dtls["include_promotion_budget"],
						'comparative_ratio_range' => $quick_dtls["comparative_ratio_range"],
						'default_market_benchmark' => $quick_dtls["default_market_benchmark"],
						'salary_position_based_on' => $quick_dtls["salary_position_based_on"],
						'comparative_ratio' => $quick_dtls["market_comparison_after_applying_performance_hike"],
						'performnace_based_hike' => $quick_dtls["performance_based_hike"],
						'manager_can_change_rating' => $quick_dtls["manager_can_change_rating"],
						'budget_accumulation' => $quick_dtls["budget_accumulation"],
						'performnace_based_hike_ratings' => json_encode($performnace_based_hike_ratings_arr),
						'comparative_ratio_calculations' => json_encode($comparative_ratio_calculations_arr),
						'crr_percent_values' => json_encode($crr_percent_arr),
						'Overall_maximum_age_increase' => json_encode($overall_maximum_age_increase_arr),
						'if_recently_promoted' => json_encode($overall_maximum_age_increase_arr),
						'to_currency_id' => $default_currency["currency"],	
						//'promotion_basis_on' => 2,
						//'hike_multiplier_basis_on' => 0,
						'esop_type' => 1,
						'esop_right' => 1,
						'pay_per_type' => 1,
						'pay_per_right' => 1,
						'bonus_recommendation_type' => 1,
						'bonus_recommendation_right' => 1,
						'retention_bonus_type' => 1,
						'retention_bonus_right' => 1,					
						'status' => 2,
						"updatedby" => $this->session->userdata('userid_ses'),
						"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
						"updatedon" => date("Y-m-d H:i:s")
						);
				
		$this->rule_model->update_rules(array('id'=>$rule_id),$db_arr);
		
		//$this->db->query("UPDATE hr_parameter SET hr_parameter.hike_multiplier_dtls = (SELECT CONCAT(\"{\", GROUP_CONCAT('\"',manage_country.id,'\":', '\"100\"'), \"}\") FROM manage_country WHERE FIND_IN_SET (manage_country.id, hr_parameter.country)) WHERE hr_parameter.id = ".$rule_id.";");
		$this->db->query("UPDATE hr_parameter SET hr_parameter.promotion_type_element_dtls = (SELECT CONCAT(\"{\", GROUP_CONCAT('\"',manage_grade.id,'\":', '\"0\"'), \"}\") FROM manage_grade WHERE FIND_IN_SET (manage_grade.id, hr_parameter.grades)) WHERE hr_parameter.id = ".$rule_id.";");
		
		$new_budget_per = $this->get_managers_for_manual_bdgt(0, $rule_id);
		foreach($performnace_based_hike_ratings_arr as $key=>$value)
		{
			$performnace_based_hike_ratings_arr[$key] = HLP_get_formated_percentage_common(($value/$new_budget_per)*$budget_per);
		}
		
		$crr_percent_arr = $overall_maximum_age_increase_arr = array();
		for($j=0; $j< count($ranges_multiplier_arr); $j++)
		{
			$previous_rating_val = $first_rating_val;
			$temp_crr_percent_arr = array();
			foreach($performnace_based_hike_ratings_arr as $key=>$value)
			{
				$temp_crr_percent_arr[] = HLP_get_formated_percentage_common($value*$ranges_multiplier_arr[$j]);
				if($j==0)
				{
					$overall_maximum_age_increase_arr[] = HLP_get_formated_percentage_common($value+($value*$ranges_multiplier_arr[$j]));
				}
			}
			$crr_percent_arr[] = $temp_crr_percent_arr;
		}
		
		$db_new_arr = array(
						'performnace_based_hike_ratings' => json_encode($performnace_based_hike_ratings_arr),
						'crr_percent_values' => json_encode($crr_percent_arr),
						'Overall_maximum_age_increase' => json_encode($overall_maximum_age_increase_arr),
						'if_recently_promoted' => json_encode($overall_maximum_age_increase_arr)
						);
				
		$this->rule_model->update_rules(array('id'=>$rule_id),$db_new_arr);		
		//echo "Post :- <pre>";print_r($performnace_based_hike_ratings_arr);die;
	}
	//Piy@9Jan
	public function get_increment_distribution_bdgt()
	{ 
		$to_currency_id = $this->input->post("to_currency");
		$rule_id = $this->input->post("rid");
		$budget_type = $this->input->post("budget_type");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id" => $rule_id));
		$records=$this->rule_model->get_increment_distribution_bdgt_report($rule_id, $rule_dtls["show_prorated_current_sal"], $to_currency_id,$budget_type);
		$currency_name = $this->admin_model->get_table_row("manage_currency", "name", array("id" => $to_currency_id))['name'];

		foreach ($records['result'] as $key => $row) {
			$records['result'][$key]['per']=$row['amount']/$records['current_salary']*100;
			$records['result'][$key]['current_salary']=$records['current_salary'];
			$total['cnt']+=$row['cnt'];
			$total['amount']+=$row['amount'];
			$total['per']+=$records['result'][$key]['per'];
		}

		$str_head1['title'] = 'Increment Distribution';
		$str_head1['cnt'] = 'No of Employees';
		$str_head1['current_salary'] = "Current salary ({$currency_name})";
		$str_head1['per'] = "%age ({$currency_name})";
		$str_head1['amount'] = "Amount ({$currency_name})";
		
		
		
		$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead><tr>';
		foreach ($str_head1 as $key => $value) {
			$str_main .= "<th style='vertical-align: middle;' class='white'>{$value}</th>";
		}
		$str_main .= '</tr>';
		//head2
		$str_main .= "<tr>";					
		$str_main .= "<th class=''>Total</th>";
		$str_main .= "<th class='text-center'>" /*.  HLP_get_formated_amount_common($total['cnt'])*/ . "</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($records['current_salary']) . "</th>";
		$str_main .= "<th class='text-center'>" . HLP_get_formated_percentage_common($total['per']) . " %</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($total['amount']) . "</th>";
		$str_main .= "</tr>";
		$str_main .= '</thead>';
		//content
		foreach ($records['result'] as $key => $row) {
			$str_body .= "<tr>";					
			$str_body .= "<td class=''>{$row['name']}</td>";
			$str_body .= "<td class='text-center'>" . HLP_get_formated_amount_common($row['cnt']) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['current_salary']) . "</td>";
			$str_body .= "<td class='text-center'>" . HLP_get_formated_percentage_common($row['per']) . " %</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['amount']) . "</td>";
			$str_body .= "</tr>";
		}
		$str_body .= '</table>';
		echo $str_main.$str_body;
	}
	//Piy@7Jan
	public function get_attributeswise_bdgt_NIU()
	{

		$table_name = 'tmp_categorywise_salary_rpt';
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$for_attributes = $this->input->post("for_attributes");
		$rule_id = $this->input->post("rid");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id" => $rule_id));
		$prorated_txt = "";
		if($rule_dtls["show_prorated_current_sal"] == 1)
		{
			$prorated_txt = "Prorated ";
		}
		switch ($for_attributes) {
			case 'emp_performance_rating':
				$attributes_name = "Performance Rating";
				break;
			default:
				$attributes_name = $this->admin_model->get_table_row("business_attribute", "display_name", ['ba_name' => $for_attributes])['display_name'];
		}
		$currency_name = $this->admin_model->get_table_row("manage_currency", "name", array("id" => $to_currency_id))['name'];

		//heading
		$str_head1['attributes_name'] = $attributes_name;
		if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
		{
		$str_head1['function'] ='Function';
		}

		$str_head1['noofemployees'] = 'No of Employees';
		$str_head1['current_salary'] = $prorated_txt."Current salary ({$currency_name})";
		$str_head1['budget_plan'] = "Budget as per the Plan ({$currency_name})";
		if ($budget_type == 'Automated but x% can exceed') {
			$str_head1['additional_budget_amount'] = "Additional Budget Amount ({$currency_name})";
		}
		$str_head1['final_salary_per'] = 'Final Salary Review Budget %';
		$str_head1['final_salary_amount'] = "Final Salary Review Budget Amount ({$currency_name})";

		//head1
		$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead><tr>';
		foreach ($str_head1 as $key => $value) {
			$str_main .= "<th style='vertical-align: middle;' class='white'>{$value}</th>";
		}
		$str_main .= '</tr>';

		switch ($for_attributes) {
			case 'sub_subfunction':
				$for_attributes = 'sub_sub_function';
				break;
			case 'subfunction':
				$for_attributes = 'sub_function';
				break;
			default:
				# code...
				break;
		}

		//if ($budget_type == 'Automated but x% can exceed') {
			$this->load->dbforge();
			$this->dbforge->drop_table($table_name, TRUE);
			$fields[$for_attributes] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["user_id"] = array('type' => 'INT', 'constraint' => '11', 'default' => 0);
			$fields["increment_applied_on_salary"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);
			$fields["emp_final_bdgt"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);
			$fields["performnace_based_increment"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["crr_based_increment"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["currency"] = array('type' => 'VARCHAR', 'constraint' => '3', 'null' => TRUE);
			$fields["budget_plan"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);								
			$fields["approver"] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["first_approver"] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["additional_budget"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);

			$fields = array_merge(array("id" => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE)), $fields);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$attributes = array('ENGINE' => 'InnoDB');
			$this->dbforge->create_table($table_name, FALSE, $attributes);

			//herirarcial 
			switch ($for_attributes) {
				case 'approver_4':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_4');
				case 'approver_3':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_3');
				case 'approver_2':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_2');
				default:
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_1');
				break;
			} 

			
			$manual_budget_dtls = json_decode($rule_dtls['manual_budget_dtls'], true);

			$sql = '';
			//Note emp_final_bdgt included additional bugget amount
			foreach ($manual_budget_dtls as $key => $value) {
				list($email, $b, $per) = $value;
				$sql="update {$table_name} set additional_budget={$per}/100 * `budget_plan` where `first_approver`='{$email}';";
				//$sql = "update {$table_name} set additional_budget=`emp_final_bdgt`*100/({$per}+100) where `approver`='{$email}';";
				$query = $this->db->query($sql);
			}
		//}

		//head 2
		$records = $this->rule_model->get_attributeswise_bdgt_sum_report($rule_id, $to_currency_id, $budget_type,$table_name);

		foreach ($records as  $recordObj) {
			$str_main .= "<tr>";					
			$str_main .= "<th class=''>{$recordObj->ba_groupon}</th>";
			if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
			{
				$str_main .= "<th class=''></th>";
			}
			$str_main .= "<th class='text-center'>" . HLP_get_formated_amount_common($recordObj->noofemployees) . "</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->current_salary) . "</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->budget_plan) . "</th>";
			if ($budget_type == 'Automated but x% can exceed') {
				$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->additional_budget_amount) . "</th>";
			}
			$str_main .= "<th class='text-center'>" . HLP_get_formated_percentage_common($recordObj->final_salary_per) . " %</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->final_salary_amount) . "</th>";

			$str_main .= "</tr>";
		}

		$str_main .= '</thead>';
		//content
		$approver_dtls = $this->rule_model->get_attributeswise_bdgt_manager_detail(" email in (select distinct approver from {$table_name})");
		
		$records = $this->rule_model->get_attributeswise_bdgt_report($rule_id, $to_currency_id, $for_attributes, $budget_type,$table_name);
		$str_body='';
		foreach ($records as  $recordObj) {
			$str_body .= "<tr>";
			if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
			{ 
				$str_body .= "<td class=''>".$approver_dtls[$recordObj->ba_groupon]['name']."</td>";
				$str_body .= "<td class=''>".$approver_dtls[$recordObj->ba_groupon]['function']."</td>";
			}else
			{
				$str_body .= "<td class=''>{$recordObj->ba_groupon}</td>";
			}
			$str_body .= "<td class='text-center'>" . HLP_get_formated_amount_common($recordObj->noofemployees) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->current_salary) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->budget_plan) . "</td>";
			if ($budget_type == 'Automated but x% can exceed') {
				$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->additional_budget_amount) . "</td>";
			}
			$str_body .= "<td class='text-center'>" . HLP_get_formated_percentage_common($recordObj->final_salary_per) . " %</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->final_salary_amount) . "</td>";

			$str_body .= "</tr>";
		}

		$str_body .= '</table>';

		if ($budget_type == 'Automated but x% can exceed') {
			$this->dbforge->drop_table($table_name, TRUE);
		}
		if ($records) {
			echo $str_main . $str_body;
		} else {
			echo 'No record Found';
			return;
		}
	}

	public function get_attributeswise_bdgt()
	{

		$table_name = 'tmp_categorywise_salary_rpt';
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$for_attributes = $this->input->post("for_attributes");
		$rule_id = $this->input->post("rid");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id" => $rule_id));
		$prorated_txt = "";
		if($rule_dtls["show_prorated_current_sal"] == 1)
		{
			$prorated_txt = "Prorated ";
		}
		switch ($for_attributes) {
			case 'emp_performance_rating':
				$attributes_name = "Performance Rating";
				break;
			default:
				$attributes_name = $this->admin_model->get_table_row("business_attribute", "display_name", ['ba_name' => $for_attributes])['display_name'];
		}
		$currency_name = $this->admin_model->get_table_row("manage_currency", "name", array("id" => $to_currency_id))['name'];

		//heading
		$str_head1['attributes_name'] = $attributes_name;
		if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
		{
		$str_head1['function'] ='Function';
		}

		$str_head1['noofemployees'] = 'No of Employees';
		$str_head1['current_salary'] = $prorated_txt."Current salary ({$currency_name})";
		$str_head1['budget_plan'] = "Budget as per the Plan ({$currency_name})";
		if ($budget_type == 'Automated but x% can exceed') {
			$str_head1['additional_budget_amount'] = "Additional Budget Amount ({$currency_name})";
		}
		$str_head1['final_salary_per'] = 'Final Salary Review Budget %';
		$str_head1['final_salary_amount'] = "Final Salary Review Budget Amount ({$currency_name})";

		//head1
		$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead><tr>';
		foreach ($str_head1 as $key => $value) {
			$str_main .= "<th style='vertical-align: middle;' class='white'>{$value}</th>";
		}
		$str_main .= '</tr>';

		switch ($for_attributes) {
			case 'sub_subfunction':
				$for_attributes = 'sub_sub_function';
				break;
			case 'subfunction':
				$for_attributes = 'sub_function';
				break;
			default:
				# code...
				break;
		}

		//if ($budget_type == 'Automated but x% can exceed') {
			$this->load->dbforge();
			$this->dbforge->drop_table($table_name, TRUE);
			$fields[$for_attributes] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["user_id"] = array('type' => 'INT', 'constraint' => '11', 'default' => 0);
			$fields["increment_applied_on_salary"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);
			$fields["emp_final_bdgt"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);
			$fields["performnace_based_increment"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["crr_based_increment"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["emp_currency_rate"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["currency"] = array('type' => 'VARCHAR', 'constraint' => '3', 'null' => TRUE);
			$fields["budget_plan"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);								
			$fields["approver"] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["first_approver"] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["additional_budget"] = array('type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0);

			$fields = array_merge(array("id" => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE)), $fields);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$attributes = array('ENGINE' => 'InnoDB');
			$this->dbforge->create_table($table_name, FALSE, $attributes);

			//herirarcial 
			switch ($for_attributes) {
				case 'approver_4':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_4');
				case 'approver_3':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_3');
				case 'approver_2':
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_2');
				default:
					$this->rule_model->set_attributeswise_bdgt_insert_temp_report($rule_id, $rule_dtls["show_prorated_current_sal"], $for_attributes, $table_name,'approver_1');
				break;
			} 

			
			/*$manual_budget_dtls = json_decode($rule_dtls['manual_budget_dtls'], true);

			$sql = '';
			//Note emp_final_bdgt included additional bugget amount
			foreach ($manual_budget_dtls as $key => $value) {
				list($email, $b, $per) = $value;
				$sql="update {$table_name} set additional_budget={$per}/100 * `budget_plan` where `first_approver`='{$email}';";
				//$sql = "update {$table_name} set additional_budget=`emp_final_bdgt`*100/({$per}+100) where `approver`='{$email}';";
				$query = $this->db->query($sql);
			}*/
			
			if($budget_type == 'Automated but x% can exceed') 
			{
				/*$standard_bdgt_per = 0;
				$managers_bdgt_dtls_for_tbl_head = json_decode($rule_dtls['managers_bdgt_dtls_for_tbl_head'],true);
				if(isset($managers_bdgt_dtls_for_tbl_head["standard_bdgt_per"]))
				{
					$standard_bdgt_per = $managers_bdgt_dtls_for_tbl_head["standard_bdgt_per"];
				}
				
				$sql="UPDATE {$table_name} SET additional_budget=((({$standard_bdgt_per} - (`performnace_based_increment`+`crr_based_increment`))/(`performnace_based_increment`+`crr_based_increment`))*`budget_plan`*emp_currency_rate) ;";
				$query = $this->db->query($sql);*/
				
				
				
				$managers_bdgt_dtls_for_tbl = json_decode($rule_dtls['managers_bdgt_dtls_for_tbl'], true);
				$sql = '';
				//Note emp_final_bdgt included additional bugget amount
				foreach ($managers_bdgt_dtls_for_tbl as $bd_row)
				{
					$sql="UPDATE {$table_name} SET additional_budget= ((".$bd_row["increased_amt_per"]."*increment_applied_on_salary/100) - `budget_plan`)*emp_currency_rate WHERE `first_approver`='".$bd_row["manager_email"]."';";
					$query = $this->db->query($sql);
				}
			}
		//}

		//head 2
		$records = $this->rule_model->get_attributeswise_bdgt_sum_report($rule_id, $to_currency_id, $budget_type,$table_name);

		foreach ($records as  $recordObj) {
			$str_main .= "<tr>";					
			$str_main .= "<th class=''>{$recordObj->ba_groupon}</th>";
			if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
			{
				$str_main .= "<th class=''></th>";
			}
			$str_main .= "<th class='text-center'>" . HLP_get_formated_amount_common($recordObj->noofemployees) . "</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->current_salary) . "</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->budget_plan) . "</th>";
			if ($budget_type == 'Automated but x% can exceed') {
				$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->additional_budget_amount) . "</th>";
			}
			$str_main .= "<th class='text-center'>" . HLP_get_formated_percentage_common($recordObj->final_salary_per) . " %</th>";
			$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->final_salary_amount) . "</th>";

			$str_main .= "</tr>";
		}

		$str_main .= '</thead>';
		//content
		$approver_dtls = $this->rule_model->get_attributeswise_bdgt_manager_detail(" email in (select distinct approver from {$table_name})");
		
		$records = $this->rule_model->get_attributeswise_bdgt_report($rule_id, $to_currency_id, $for_attributes, $budget_type,$table_name);
		$str_body='';
		foreach ($records as  $recordObj) {
			$str_body .= "<tr>";
			if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
			{ 
				$str_body .= "<td class=''>".$approver_dtls[$recordObj->ba_groupon]['name']."</td>";
				$str_body .= "<td class=''>".$approver_dtls[$recordObj->ba_groupon]['function']."</td>";
			}else
			{
				$str_body .= "<td class=''>{$recordObj->ba_groupon}</td>";
			}
			$str_body .= "<td class='text-center'>" . HLP_get_formated_amount_common($recordObj->noofemployees) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->current_salary) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->budget_plan) . "</td>";
			if ($budget_type == 'Automated but x% can exceed') {
				$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->additional_budget_amount) . "</td>";
			}
			$str_body .= "<td class='text-center'>" . HLP_get_formated_percentage_common($recordObj->final_salary_per) . " %</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->final_salary_amount) . "</td>";

			$str_body .= "</tr>";
		}

		$str_body .= '</table>';

		/*if ($budget_type == 'Automated but x% can exceed') {
			$this->dbforge->drop_table($table_name, TRUE);
		}*/
		if ($records) {
			echo $str_main . $str_body;
		} else {
			echo 'No record Found';
			return;
		}
	}

	public function get_managers_for_manual_bdgt($is_view_only=0, $is_req_frm_quick_module=0)
	{
		//Note :: $is_req_frm_quick_module > 0(Yes req called from Quick Module and its value is a rule id), 0=No or Normal req.
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$show_prorated_current_sal = $this->input->post("show_prorated_current_sal");
		$rule_id = $this->input->post("rid");
		if($is_req_frm_quick_module)
		{
			$rule_id = $is_req_frm_quick_module;
		}
		if($rule_id)
		{
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			if($is_req_frm_quick_module)
			{
				$budget_type = $data["rule_dtls"]["overall_budget"];
				$to_currency_id = $data["rule_dtls"]["to_currency_id"];
			}
			else
			{
				$data["rule_dtls"]["show_prorated_current_sal"] = $show_prorated_current_sal;
			}
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			
			$cr1_col_styl = "";
			if($data["rule_dtls"]['salary_position_based_on'] == "2")
			{
				$cr1_col_styl = "display:none;";
			}
			
			$prorated_txt = "";
			if($data["rule_dtls"]['show_prorated_current_sal']==1)
			{
				$prorated_txt = "Prorated ";
			}
		
			$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);
			//$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$data["rule_dtls"]["salary_applied_on_elements"].")");
		
		
			$salary_elem_ba_list = $this->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");
			$increment_applied_on_ids_arr = explode(",", $data["rule_dtls"]["salary_applied_on_elements"]);
			$increment_applied_on_names_arr = $modules_select_arr = array();
			foreach($salary_elem_ba_list as $ba_row)
			{
				if(in_array($ba_row["id"], $increment_applied_on_ids_arr))
				{
					$increment_applied_on_names_arr[] = $ba_row['ba_name'];
				}
				$modules_select_arr[] = $ba_row['ba_name'];
			}
			$modules_select_str = implode(",", $modules_select_arr);
			$increment_applied_on_str = implode("+", $increment_applied_on_names_arr);
			
			
			$select_str = "login_user.id, login_user." . CV_BA_NAME_EMP_EMAIL . ", login_user.".CV_BA_NAME_COUNTRY.", login_user.".CV_BA_NAME_GRADE.", login_user.".CV_BA_NAME_LEVEL.", login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", (SELECT name FROM manage_currency mc WHERE mc.id = login_user." . CV_BA_NAME_CURRENCY . ") AS currency_name";		
			
			$select_str .= "," . $modules_select_str;
			$select_str .= " , (" . $increment_applied_on_str . ") AS total_salary_to_apply_increment";
			
			if($managers)
			{
				$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead>';
				$str_main .= '<tr>';
				
				$str_main .= '<th style="vertical-align: middle;">Manager Name</th><th style="vertical-align: middle;">Function</th><th style="vertical-align: middle;">BU Level-3</th><th style="vertical-align: middle;">Number of<br>Employees</th><th style="vertical-align: middle;">'.$prorated_txt.'Current Salary ('.$to_currency_dtls["name"].')</th><th style="vertical-align: middle;">Budget as per the plan ('.$to_currency_dtls["name"].')</th>';
				//$colspn = 4;
			
				if($budget_type == "Automated but x% can exceed") 
				{
					//$colspn = 5;
					//Piy@17Dec head 1
					$str_main .= '<th style="vertical-align: middle;">Additional budget %age</th><th style="vertical-align: middle;">Additional Budget amount ('.$to_currency_dtls["name"].')</th>
					<th style="vertical-align: middle;">Final Salary Review Budget %age</th>
					<th style="vertical-align: middle;">Final Salary Review Budget Amount ('.$to_currency_dtls["name"].')</th>'; 

				}
				else
				{
					$str_main .= '<th style="vertical-align: middle;">Final Salary Review Budget %age</th>';
				}	
				$str_main .= '<th style="vertical-align: middle; display:none; '.$cr1_col_styl.' ">Budget to bring all to their target<br/>positioning (only for
				reference)<br>('.$to_currency_dtls["name"].')</th>'; 
				
				$str_main .= '</tr>'; 
				$str = '';
				$t=0;
				$totalEmp=0;
				$emptotalB=0;
				$total_cr1=0;
				$i=1;
				foreach ($managers as $row)
				{
					$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($data["rule_dtls"], $row['first_approver'], $to_currency_id, $select_str);
					$manager_emp_budget_dtls['currency']['currency_type'] = $to_currency_dtls["name"];
					$manager_budget = $manager_emp_budget_dtls["budget"];
					
					$str .= '<tr><td>';
					if($row['manager_name'])
					{
						$str .= $row['manager_name'];
					}
					else
					{
						$str .= $row['first_approver'];
					}    
					$str .= '</td><td>'.$row["function_name"].'</td><td>'.$row["bl3_name"].'<input type="hidden" value="'.$row['function_name'].'" name="hf_manager_function_name[]" /><input type="hidden" value="'.$row['bl3_name'].'" name="hf_manager_bl3_name[]" /></td>';
					          
					$t=$t+$manager_budget;
					$total_cr1 += $manager_emp_budget_dtls["managers_budget_to_make_CR_1"];
					$totalEmp=$totalEmp+$manager_emp_budget_dtls["total_emps"];
					$emptotalB=$emptotalB+$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];
						
					$str .= '<td class="text-center">'.$manager_emp_budget_dtls["total_emps"].'</td><td class="txtalignright">'.HLP_get_formated_amount_common($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]).'</td><td class="txtalignright">'.HLP_get_formated_amount_common($manager_budget).'
				<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" id="hf_pre_calculated_budgt_'.$i.'"/>
				<input type="hidden" value="'.$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"].'" name="hf_emps_total_salary[]" id="hf_incremental_amt_'.$i.'" />
				<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" />
				<input type="hidden" value="'.$row['manager_name'].'" name="hf_manager_names[]" />
				<input type="hidden" value="'.$manager_emp_budget_dtls["total_emps"].'" name="hf_manager_total_emps[]" />
				<input type="hidden" value="'.$manager_emp_budget_dtls["managers_budget_to_make_CR_1"].'" name="hf_budget_to_cr1[]" />
				<input type="hidden" value="'.($manager_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100).'" name="increased[]" />
				<input type="hidden" value="'.(($manager_emp_budget_dtls["managers_budget_to_make_CR_1"])).'" name="budget_to_bring []" />
				</td>';
					if($is_view_only)
					{						
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td class="txtalignright"><ravi id="dv_x_per_budget_'.$i.'"></ravi></td>';
						}
					}
					else
					{						
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td ><div style="position:relative !important;"><input type="text" class="form-control addpersen" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value="0" onKeyUp="validate_percentage_onkeyup_with_minus_sign_common(this,3);" onBlur="validate_percentage_onkeyup_with_minus_sign_common(this,3);" required="required"  onChange="calculat_percent_increased_val(2,this.value, '.$i.')">
							<input type="hidden" name="hf_additional_bdgt_per[]" id="hf_additional_bdgt_per_'.$i.'" value="0" />
							<span></span></div></td>';

						}
					}
				
					if($budget_type == "Automated but x% can exceed") 
					{	//Piy@17Dec 
						$str .= '<td class="text-center"><input type="hidden" value="0" id="hf_increased_amt_val_'.$i.'" /><ravi id="td_increased_amt_val_'.$i.'">0</ravi></td>';

						
					}						
				
					/*if($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]>0)
					{
						$str .= '<td id="td_increased_amt_'.$i.'" class="text-center com_bg_colo_sal fnt_bold"> '.HLP_get_formated_percentage_common($manager_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100).' %</td>';
					}
					else
					{
						$str .= '<td id="td_increased_amt_'.$i.'" class="text-center"> 0 %</td>';
					}*/
					
					$manager_rule_based_bdgt_per = 0;
					$manager_rule_based_bdgt_cls = "text-center";
					if($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]>0)
					{
						$manager_rule_based_bdgt_per = $manager_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100;
						$manager_rule_based_bdgt_cls = "text-center com_bg_colo_sal fnt_bold";
					}
					$str .= '<td id="td_increased_amt_'.$i.'" class="'.$manager_rule_based_bdgt_cls.'"> '.HLP_get_formated_percentage_common($manager_rule_based_bdgt_per).' %</td>
						<input type="hidden" value="'.$manager_rule_based_bdgt_per.'" id="hf_manager_rule_base_bdgt_per_'.$i.'" />';

					if($budget_type == "Automated but x% can exceed") 
					{	//Piy@17Dec 
						

						$str .= '<td class="txtalignright"><ravi id="td_revised_bdgt_'.$i.'">'.HLP_get_formated_amount_common($manager_budget).'</ravi></td>';
					}						
				
					$str .= '<td class="txtalignright" style="display:none;'.$cr1_col_styl.'">'.HLP_get_formated_amount_common(($manager_emp_budget_dtls["managers_budget_to_make_CR_1"])).'</td></tr>';
					$i++;
				}
				
				if($is_req_frm_quick_module)
				{
					return ($t/$emptotalB)*100;
				}
				//Piy@17Dec head 2
				$str_main .='<tr class="tablealign"><th style="text-align: right;"><input type="hidden" value="'.$i.'" id="hf_manager_cnt"/>Total&nbsp;</th><th></th><th></th><th>'.$totalEmp.'</th><th style="text-align:right !important;"><input type="hidden" value="'.$emptotalB.'" id="hf_total_current_sal" name="hf_total_current_sal"/>'.HLP_get_formated_amount_common($emptotalB).'</th><th style="text-align:right !important;"  ><input type="hidden" value="'.$t.'" id="hf_total_budget_plan"/><ravi id="th_total_budget_plan">'.HLP_get_formated_amount_common($t).'</ravi></th>';
				if($budget_type == "Automated but x% can exceed") 
				{
					//Piy@17Dec head 2
					$str_main .= '
					<th style="text-align:right !important;"><ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common($t).'</ravi></th>
					<th style="text-align:right !important;"><ravi id="th_additional_budget_manual">0</ravi></th>
					<th style="text-align:center !important; position:relative;" ><ravi id="th_final_per">'.HLP_get_formated_percentage_common(($t/$emptotalB)*100).' %</ravi>
					<div class="edit_standard_bdgt_per"><a data-toggle="tooltip" title="Apply standard budget to all managers irrespective of rule based budget." data-original-title="" data-placement="bottom">
					<i id="standard_bdgt_per_edit" onclick="show_standard_bdgt_dv_to_managers()" class="fa fa-pencil" aria-hidden="true"></i> 
					 </a></div><ravi style="display:none;" id="rv_input_standard_bdgt_per_dv_to_managers">
                    <div class="save_standard_budget_per"><input type="text" value="'.HLP_get_formated_percentage_common(($t/$emptotalB)*100).'" id="txt_standard_bdgt_per" name="txt_standard_bdgt_per" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);"/>
					<div class="save_bud_links"><i onclick="allocate_standard_bdgt_to_managers();" class="fa fa-check" aria-hidden="true"></i> 
					<i onclick="hide_standard_bdgt_dv_to_managers();" class="fa fa-times" aria-hidden="true"></i>
					</div>
					</div>

					</ravi></th>
					<th style="text-align:right !important;">
					<ravi id="th_total_budget">'.HLP_get_formated_amount_common($t).'</ravi></th>';
				}
				else
				{
					$str_main .='<th style="text-align:center !important;" id="th_final_per">'.HLP_get_formated_percentage_common(($t/$emptotalB)*100).' %</th>';
				}	
				$str_main .='<th style="display:none;'.$cr1_col_styl.' text-align:right !important;"><input type="hidden" value="'.$total_cr1.'" name="hf_total_budget_to_cr1"/>'.($total_cr1).'</th></tr>';
				$str_main .= $str;
				$str_main .= '</tbody></table></div>'; 
				echo $str_main;
			}
			else
			{
				if($is_req_frm_quick_module)
				{
					return 0;
				}
				echo "";
			}
		}
	}




	public function calculate_budgt_manager_wise($rule_dtls, $manager_email, $to_currency_id, $select_str)
	{	
		$rule_id = $rule_dtls["id"];
		//$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		//$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["salary_applied_on_elements"].")");
		
		$total_max_budget = 0;
		//$manager_actual_budget = 0;
		$managers_emps_tot_incremental_amt = 0;
		$total_budget_to_make_CR_1 = 0;
		//$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
		
		$managers_emp_arr = $this->rule_model->get_table("login_user", $select_str, "login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'", "login_user.id ASC");
		
		if($rule_dtls["hike_multiplier_basis_on"])
		{
			$hike_multiplier_basis_on = CV_BA_NAME_COUNTRY;
			if($rule_dtls["hike_multiplier_basis_on"]=="2")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_GRADE;
			}
			elseif($rule_dtls["hike_multiplier_basis_on"]=="3")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_LEVEL;
			}
			//$hike_multiplier_arr = json_decode($rule_dtls["hike_multiplier_dtls"], true);
			$multiplier_wise_per_dtls = json_decode($rule_dtls["multiplier_wise_per_dtls"], true);
		}	
	
		foreach($managers_emp_arr as $row)
		{
			$users_dtls = $row;
			$employee_id = $users_dtls["id"];//$row;
			//$hike_multiplier_val = 1;//0;
			/*if(isset($hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]))
			{
				$hike_multiplier_val = $hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]/100;
			}*/
			
			$increment_applied_on_amt = $users_dtls["total_salary_to_apply_increment"];
			$performnace_based_increment_percet=0;
			/*$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
			
			$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
			$currency = array("currency_type"=>$currency_arr["name"]);
			$from_currency_id = $currency_arr["id"];*/
			$currency = array("currency_type"=>$row["currency_name"]);
			$from_currency_id = $row[CV_BA_NAME_CURRENCY];
			
			/*if($increment_applied_on_arr)
			{
			foreach($increment_applied_on_arr as $salary_elem)
			{
			if($users_dtls[$salary_elem["ba_name"]])
			{
				$increment_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
			}
			}
			}*/
			
			//**************** Note :: Proreta Calculation Start ****************/		
			/*$proreta_multiplier = 1;//Default
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			if($rule_dtls["prorated_increase"] == "yes")
			{
				//if(strtotime($joining_dt) <= strtotime($rule_dtls["start_dt"]))
				//{
				//	$proreta_multiplier = 1;
				//}
				//else
				if(strtotime($joining_dt) <= strtotime($rule_dtls["end_dt"]))
				{
					$numerator = round((strtotime($rule_dtls["end_dt"]) - strtotime($joining_dt)) / (60 * 60 * 24));
					$denominator = round((strtotime($rule_dtls["end_dt"]) - strtotime($rule_dtls["start_dt"])) / (60 * 60 * 24));
					$proreta_multiplier = HLP_get_formated_percentage_common(($numerator/$denominator));
				}
				else
				{
					$proreta_multiplier = 0;
				}					
			}
			elseif($rule_dtls["prorated_increase"] == "fixed-percentage")
			{
				$range_of_doj_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"],true);
				foreach($range_of_doj_arr as $key=> $doj_range) 
				{
					if(strtotime(date('Y-m-d', strtotime($doj_range["From"]))) <= strtotime($joining_dt) and strtotime($joining_dt) >= strtotime(date('Y-m-d', strtotime($doj_range["To"]))))
					{
						$proreta_multiplier = $doj_range["Percentage"]/100;
						break;
					}					
				}				
			}*/
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			$proreta_multiplier = HLP_get_pro_rated_multiplier_for_salary($rule_dtls, $joining_dt);
			//$total_per_to_increase_salary = $total_per_to_increase_salary*$proreta_multiplier;
			//**************** Note :: Proreta Calculation End ****************/
			
			/*$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);*/
			if($rule_dtls["hike_multiplier_basis_on"])
			{
				$rating_dtls = $multiplier_wise_per_dtls["rating"][$users_dtls[$hike_multiplier_basis_on]];
				$comparative_ratio_dtls=$multiplier_wise_per_dtls["mkt_elem"][$users_dtls[$hike_multiplier_basis_on]];
				$crr_tbl_arr_temp = $multiplier_wise_per_dtls["crr"][$users_dtls[$hike_multiplier_basis_on]];
			}
			else
			{
				$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
				$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
				$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
			}
			
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$performnace_based_increment_percet = $value;
						break;
					}
				}			
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}
			
			$performnace_based_increment_percet = ($performnace_based_increment_percet*$proreta_multiplier);
			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);
			
			$emp_market_salary = 0;
			$crr_per = 0;			
			
			if($rule_dtls['salary_position_based_on'] != "2")//Salary Positioning Not Based On Quartile
			{
				if($rule_dtls["performnace_based_hike"] == "yes")
				{
					foreach ($comparative_ratio_dtls as $key => $value) 
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
						{
							$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
							/*$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
							$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];*/
							$emp_market_salary = $users_dtls[$val_arr[1]];
							break;
						}
					}
				}
				else
				{
					$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
					/*$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
					$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];*/
					$emp_market_salary = $users_dtls[$val_arr[1]];
				}
			
				if($emp_market_salary > 0)
				{
					$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
					if($rule_dtls["comparative_ratio"] == "yes")
					{
						$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
					}
				}
			}
			
			$i=0; 
			$min_mkt_salary = $min_mkt_salary_to_bring_emp_to_min_salary = 0;
			$increment_applied_on_amt_for_quartile = $increment_applied_on_amt;
			if($rule_dtls["comparative_ratio"] == "yes")
			{
				$increment_applied_on_amt_for_quartile = $performnace_based_salary;
			}
			$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $key => $row1)
			{
				if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{
					$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
					if($i==0)
					{ 
						if($increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							$min_mkt_salary_to_bring_emp_to_min_salary = $users_dtls[$quartile_range_arr[1]];
							break;
						}
					}
					else
					{
						if($min_mkt_salary <= $increment_applied_on_amt_for_quartile and $increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							break;
						}
					}
					if(($i+1)==count($crr_arr))
					{
						if($increment_applied_on_amt_for_quartile >= $users_dtls[$quartile_range_arr[1]])
						{
							$i++;
							break;
						}
					}
					$min_mkt_salary = $users_dtls[$quartile_range_arr[1]];
				}
				else
				{		
					if($i==0)
					{ 
						if($crr_per < $row1["max"])
						{
							break;
						}
					}
					else
					{
						if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
						{
							break;
						}
					}
					if(($i+1)==count($crr_arr))
					{
						if($crr_per >= $row1["max"])
						{
							$i++;
							break;
						}
					}
				}
				$i++; 
			}
			
			
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;	
			$crr_based_increment_percet = 0;
			$j=0;
			
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
						break;
					}
					$j++;
				}
			}
			else
			{
				$crr_based_increment_percet =  $crr_tbl_arr[$j];
			}
			
			if($rule_dtls['bring_emp_to_min_sal'] == 1 and $rule_dtls['salary_position_based_on'] == "2" and $i == 0 and $min_mkt_salary_to_bring_emp_to_min_salary > 0)//Salary Positioning Based On Quartile Case
			{
				$crr_based_increment_percet = HLP_get_mkt_hike_to_bring_emp_to_min_salary($increment_applied_on_amt, $min_mkt_salary_to_bring_emp_to_min_salary, $performnace_based_increment_percet, $crr_based_increment_percet);
			}
			else
			{
				$crr_based_increment_percet = ($crr_based_increment_percet*$proreta_multiplier);
			}
			$total_per_to_increase_salary = $performnace_based_increment_percet + $crr_based_increment_percet;
				
			//$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, ((($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100)));
			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, ((($increment_applied_on_amt*$total_per_to_increase_salary)/100)));
			//$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id,$increment_applied_on_amt);
			if($rule_dtls['show_prorated_current_sal']==1)
			{
				$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id,($increment_applied_on_amt*$proreta_multiplier));//Note : Used just prorated salary from 17-Feb-2020
			}
			else
			{
				$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id,($increment_applied_on_amt));
			}
			
			//$total_budget_to_make_CR_1 += $emp_market_salary - $increment_applied_on_amt;	
			if($emp_market_salary > 0 and ($increment_applied_on_amt/$emp_market_salary)<1)//Note :: Calculate CR1 only for those for which crr < 1
			{
				$total_budget_to_make_CR_1 += HLP_convert_currency($from_currency_id, $to_currency_id, ($emp_market_salary - $increment_applied_on_amt));
			}
		}
		return array("total_emps"=>count($managers_emp_arr), "budget"=>$total_max_budget, "managers_emps_tot_incremental_amt"=>$managers_emps_tot_incremental_amt,"currency"=>$currency, "managers_budget_to_make_CR_1"=>$total_budget_to_make_CR_1);
	}

	public function set_rules($rule_id=0, $step=0)
	{
		if($step>0 and $rule_id > 0)
		{
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			if(!$data['rule_dtls'] or ($data['rule_dtls']["status"] > 4 and $data['rule_dtls']["rule_refresh_status"] != 1))//Set for approval yet or Approved
			{
				echo "";die;
			}	
			
			if($step==1)
			{	
				if(!$this->input->post("hf_show_next_step"))	
				{
					$step1_db_arr = array(						
						'salary_rule_name' => $this->input->post("txt_salary_rule_name"),
						'salary_applied_on_elements'=>implode(",",$this->input->post("ddl_increment_applied_elem")),						
						'type_of_hike_can_edit' => implode(",",$this->input->post("chk_type_of_hike_can_edit")),		
						//'standard_promotion_increase' => $this->input->post("txt_standard_promotion_increase"),
						/*'sp_manager_discretionary_increase' => $this->input->post("txt_sp_manager_discretionary_increase"),
						'sp_manager_discretionary_decrease' => $this->input->post("txt_sp_manager_discretionary_decrease"),*/
						'include_inactive' => $this->input->post("ddl_include_inactive"),
						'prorated_increase' => $this->input->post("ddl_prorated_increase"),
						'Manager_discretionary_increase' => $this->input->post("txt_manager_discretionary_increase"),
						'Manager_discretionary_decrease' => $this->input->post("txt_manager_discretionary_decrease"),
						'esop_title' => $this->input->post("txt_esop_title"),
						'esop_type' => $this->input->post("ddl_esop_type"),
						'esop_right' => $this->input->post("ddl_esop_right"),
						'pay_per_title' => $this->input->post("txt_pay_per_title"),
						'pay_per_type' => $this->input->post("ddl_pay_per_type"),
						'pay_per_right' => $this->input->post("ddl_pay_per_right"),
						'bonus_recommendation_title' => $this->input->post("txt_bonus_recommendation_title"),
						'bonus_recommendation_type' => $this->input->post("ddl_bonus_recommendation_type"),
						'bonus_recommendation_right' => $this->input->post("ddl_bonus_recommendation_right"),					
						'retention_bonus_title' => $this->input->post("txt_retention_bonus_title"),
						'retention_bonus_type' => $this->input->post("ddl_retention_bonus_type"),
						'retention_bonus_right' => $this->input->post("ddl_retention_bonus_right"),
						'linked_bonus_rule_id' => $this->input->post("linked_bonus_rule_id"),
						'rounding_final_salary' => $this->input->post("ddl_rounding_final_salary"),
						"updatedby" => $this->session->userdata('userid_ses'),
						"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
						"updatedon" => date("Y-m-d H:i:s"),
						//'status' => 2,
						//'overall_budget' => "",
						/*'budget_amount' => "",
						'budget_percent' => "",*/
						'manual_budget_dtls' => "",
						//'Overall_maximum_age_increase' =>"",
						//'if_recently_promoted' =>"",
						//'crr_percent_values' => ""
						);
					
					if($data['rule_dtls']["rule_refresh_status"] != 1)
					{
						//$step1_db_arr['status'] = 2;	
						$step1_db_arr['promotion_basis_on'] = $this->input->post("ddl_promotion_based_on");
						
						if($step1_db_arr['promotion_basis_on']>0)
						{
							$promotion_type_element_dtls_arr = array();
							foreach($_REQUEST['hf_promotion_type_elements'] as $key=> $pte_val) 
							{ 						
								$promotion_type_element_dtls_arr[$pte_val]=$_REQUEST['txt_promotion_type_elements'][$key];
							}
							$step1_db_arr['promotion_type_element_dtls'] = json_encode($promotion_type_element_dtls_arr);
						}
					}
					
					$step1_db_arr['performnace_based_hike'] = $this->input->post("ddl_performnace_based_hikes");
					$step1_db_arr['manager_can_change_rating']=$this->input->post("ddl_manager_can_change_rating");
					//$step1_db_arr['performnace_based_hike_ratings'] = "";
					$step1_db_arr['salary_position_based_on'] = $this->input->post("ddl_salary_position_based_on");
					$step1_db_arr['bring_emp_to_min_sal'] = 2;
					if($step1_db_arr['salary_position_based_on'] == 2)
					{
						$step1_db_arr['bring_emp_to_min_sal'] = $this->input->post("ddl_bring_emp_to_min_sal");	
					}	
					$step1_db_arr['promotion_can_edit']=$this->input->post("ddl_promotion_can_edit");
					$step1_db_arr['display_performance_achievement']=$this->input->post("ddl_display_performance_achievement");
					$step1_db_arr['display_variable_salary']=$this->input->post("ddl_display_variable_salary");		
					$step1_db_arr['comparative_ratio'] = $this->input->post("ddl_comparative_ratio");
					//$step1_db_arr['comparative_ratio_calculations'] = "";					
					$step1_db_arr['default_market_benchmark'] = $this->input->post("ddl_comparative_ratio1");
					
					$crr_arr = array();
					$min_range = 0;
					$cnt = 0;
					if($step1_db_arr['salary_position_based_on']==2)
					{
						/*$crr_arr = $this->input->post("chk_quartile");*/
						foreach($_REQUEST['chk_quartile'] as $key=> $quar_value) 
						{ 
							$quartile_key_arr = explode(CV_CONCATENATE_SYNTAX, $quar_value);
							if(!$min_range)
							{
								$min_range = $quartile_key_arr[2];
							}
							
							$crr_arr[$quartile_key_arr[0].CV_CONCATENATE_SYNTAX.$quartile_key_arr[1]] = array("min"=>$min_range,"max"=>$quartile_key_arr[2]);
							$min_range = $quartile_key_arr[2];
							$cnt++;
						}
					}
					else
					{
						foreach($_REQUEST['txt_crr'] as $key=> $value) 
						{ 
							if($value !='') 
							{ 
								$crr_arr["range".($cnt+1)] = array("min"=>$min_range,"max"=>$value);
								$min_range = $value;
								$cnt++;
							}
						}
					}
				
					$fixed_per = array();
					$cfixed_per = 0;
					foreach($_REQUEST['txt_start_dt_fixed_per'] as $key=> $value) 
					{ 
						if($value !='') 
						{ 
							$fixed_per[($cfixed_per+1)] = array("From"=>$_REQUEST['txt_start_dt_fixed_per'][$key],"To"=>$_REQUEST['txt_end_dt_fixed_per'][$key],"Percentage"=>$_REQUEST['txt_fixed_per'][$key]);
							
							$cfixed_per++;
						}
					}
					$step1_db_arr['comparative_ratio_range'] = json_encode($crr_arr);
					$step1_db_arr['fixed_percentage_range_of_doj'] = json_encode($fixed_per);
					
					$pp_start_dt=explode("/",$this->input->post('txt_pp_start_dt')); 
					$step1_db_arr['pp_start_dt'] = $pp_start_dt[2].'-'.$pp_start_dt[1].'-'.$pp_start_dt[0]; 	
					$pp_end_dt=explode("/",$this->input->post('txt_pp_end_dt')); 
					$step1_db_arr['pp_end_dt'] = $pp_end_dt[2].'-'.$pp_end_dt[1].'-'.$pp_end_dt[0];	
					
					$step1_db_arr['start_dt'] = "";
					$step1_db_arr['end_dt'] = "";
					if($this->input->post('ddl_prorated_increase') == "fixed_period")
					{
						$start_dt=explode("/",$this->input->post('txt_start_dt')); 
						$step1_db_arr['start_dt'] = $start_dt[2].'-'.$start_dt[1].'-'.$start_dt[0]; 	
						$end_dt=explode("/",$this->input->post('txt_end_dt')); 
						$step1_db_arr['end_dt'] = $end_dt[2].'-'.$end_dt[1].'-'.$end_dt[0];	
					}	
					elseif($this->input->post('ddl_prorated_increase') == "yes")
					{
						$step1_db_arr['start_dt'] = $step1_db_arr['pp_start_dt'];
						$step1_db_arr['end_dt'] = $step1_db_arr['pp_end_dt'];	
					}
					
					//echo "<pre>";print_r($step1_db_arr);die;				
					$this->rule_model->update_rules(array('id'=>$rule_id),$step1_db_arr);
				}
				echo true; die;
			}
			elseif($step==2)
			{
				if(!$this->input->post("hf_show_next_step"))	
				{
					$rating_arr = array();
					if($data["rule_dtls"]['performnace_based_hike']=='yes')
					{
						foreach($_REQUEST['hf_rating_name'] as $key=> $value) 
						{ 
							if($value !='') 
							{ 
								$rating_arr[$value] = $_REQUEST['txt_ratings'][$key];
							}
						}
					}
					else
					{
						$rating_arr['all'] = $this->input->post("txt_rating1");
					}
					$performnace_based_hike_ratings = json_encode($rating_arr);
					
					$comparative_ratio_arr = array();				
					if($data["rule_dtls"]['performnace_based_hike']=='yes')
					{			
						foreach($_REQUEST['hf_comparative_ratio_name'] as $key=> $value) 
						{ 
							if($value !='') 
							{ 
								$comparative_ratio_arr[$value] = $_REQUEST['ddl_market_salary_comparative_ratio'][$key];
							}
						}
					}
					else
					{
						$comparative_ratio_arr['all'] = $this->input->post("ddl_comparative_ratio1");
					}
					$comparative_ratio_calculations = json_encode($comparative_ratio_arr);
					
					$crr_percent_values_arr = array();
					for($i=0; $i<=$this->input->post("hf_crr_counts"); $i++)
					{
						$crr_percent_values_arr[$i] = $_REQUEST['txt_range_val'.$i];
					}
					
					/******************* Start Preparing Data Multiplier Wise *******************/					
					$multiplier_wise_per_dtls = $multiplier_arr = $multiplier_wise_rating_arr = $multiplier_wise_crr_per_arr = $multiplier_wise_mkt_ele_arr = $multiplier_wise_max_per_arr = $multiplier_wise_recently_max_per_arr = array();
					if($this->input->post("ddl_hike_multiplier_basis_on"))	
					{
						foreach($_REQUEST['hf_multiplier_elements'] as $key=> $m_val) 
						{ 						
							$m_per_val = $_REQUEST['txt_multiplier_elements'][$key];
							$multiplier_arr[$m_val] = $m_per_val;
							
							$mw_rating_arr = array();
							if($data["rule_dtls"]['performnace_based_hike']=='yes')
							{
								foreach($_REQUEST['hf_rating_name'] as $key=> $value) 
								{ 
									if($value !='') 
									{ 
										$mw_rating_arr[$value] = ($_REQUEST['txt_ratings'][$key]*$m_per_val)/100;
									}
								}
							}
							else
							{
								$mw_rating_arr['all'] = ($this->input->post("txt_rating1")*$m_per_val)/100;
							}
							$multiplier_wise_rating_arr[$m_val] = $mw_rating_arr;
							
							$mw_crr_per_arr = array();
							for($i=0; $i<=$this->input->post("hf_crr_counts"); $i++)
							{
								$crr_per_arr = $_REQUEST['txt_range_val'.$i];
								for($k=0; $k<count($crr_per_arr); $k++)
								{
									$crr_per_arr[$k] = $crr_per_arr[$k]*$m_per_val/100;
								}
								$mw_crr_per_arr[$i] = $crr_per_arr;
							}
							$multiplier_wise_crr_per_arr[$m_val] = $mw_crr_per_arr;						
							$multiplier_wise_mkt_ele_arr[$m_val] = $comparative_ratio_arr;
							
							
							$max_per_arr = $_REQUEST['txt_max_hike'];
							for($m=0; $m<count($max_per_arr); $m++)
							{
								$max_per_arr[$m] = $max_per_arr[$m]*$m_per_val/100;
							}
							$multiplier_wise_max_per_arr[$m_val] = $max_per_arr;
							
							$recently_max_per_arr = $_REQUEST['txt_recently_promoted_max_salary_increase'];
							for($r=0; $r<count($recently_max_per_arr); $r++)
							{
								$recently_max_per_arr[$r] = $recently_max_per_arr[$r]*$m_per_val/100;
							}
							$multiplier_wise_recently_max_per_arr[$m_val] = $recently_max_per_arr;
						}
						//print_r($multiplier_wise_max_per_arr);die;
						$multiplier_wise_per_dtls = array("rating"=>$multiplier_wise_rating_arr, "crr"=>$multiplier_wise_crr_per_arr, "mkt_elem"=>$multiplier_wise_mkt_ele_arr, "max_per"=>$multiplier_wise_max_per_arr, "recently_max_per"=>$multiplier_wise_recently_max_per_arr);	
						
						$multiplier_arr = json_encode($multiplier_arr);
						$multiplier_wise_per_dtls = json_encode($multiplier_wise_per_dtls);
					}
					else
					{
						$multiplier_wise_per_dtls = $multiplier_arr = "";
					}				
					/******************* Start Preparing Data Multiplier Wise *******************/
					
					$step2_db_arr = array(
							'performnace_based_hike_ratings' => $performnace_based_hike_ratings,																	
							'Overall_maximum_age_increase' =>json_encode($_REQUEST['txt_max_hike']),
							'if_recently_promoted' =>json_encode($_REQUEST['txt_recently_promoted_max_salary_increase']),
							'crr_percent_values' => json_encode($crr_percent_values_arr),
							'comparative_ratio_calculations' => $comparative_ratio_calculations,
							'hike_multiplier_basis_on' => $this->input->post("ddl_hike_multiplier_basis_on"),
							'hike_multiplier_dtls' => $multiplier_arr,//json_encode($multiplier_arr),
							'multiplier_wise_per_dtls' => $multiplier_wise_per_dtls,//json_encode($multiplier_wise_per_dtls),
							"updatedby" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedon" => date("Y-m-d H:i:s")
						);
					
					$this->rule_model->update_rules(array("id"=>$rule_id), $step2_db_arr);
				} 
				if($this->input->post("ddl_hike_multiplier_basis_on"))	
				{
					echo 2;
				}
				else
				{
					echo 3;
				}
				die;
			}
			elseif($step==3)
			{
				$tbl_name = "manage_country";
				$col_name = "country";
				$cnd_str = "status = 1 ";
				
				if($data["rule_dtls"]['hike_multiplier_basis_on'] == "2")
				{
					$col_name = "grades";
					$tbl_name = "manage_grade";
				}
				elseif($data["rule_dtls"]['hike_multiplier_basis_on'] == "3")
				{
					$col_name = "levels";
					$tbl_name = "manage_level";
				}		
				$cnd_str .= " AND id IN (".$data["rule_dtls"][$col_name].")";
				$multiplier_elements_list = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
				$multiplier_wise_per_dtls = json_decode($data['rule_dtls']["multiplier_wise_per_dtls"], true);
				$mw_rating_arr = $multiplier_wise_per_dtls["rating"];
				$mw_mkt_elem_arr = $multiplier_wise_per_dtls["mkt_elem"];
				$mw_crr_arr = $multiplier_wise_per_dtls["crr"];				
				$mw_max_per_arr = $multiplier_wise_per_dtls["max_per"];
				$mw_recently_max_per_arr = $multiplier_wise_per_dtls["recently_max_per"];
				
				foreach($multiplier_elements_list as $m_key => $me_row)
				{
					$rating_val_arr = $mw_rating_arr[$me_row["id"]];
					$mkt_elem_arr = $mw_mkt_elem_arr[$me_row["id"]];
					$crr_arr = $mw_crr_arr[$me_row["id"]];
					$max_per_arr = $mw_max_per_arr[$me_row["id"]];
					$recently_max_per_arr = $mw_recently_max_per_arr[$me_row["id"]];
					
					$i = 0;
					foreach($rating_val_arr as $r_key => $r_val)
					{
					 	$r_arr = explode(CV_CONCATENATE_SYNTAX, $r_key);
						$rating_val_arr[$r_key] = $_REQUEST['txt_rating_'.$me_row["id"]][$i];
						$mkt_elem_arr[$r_key] = $_REQUEST['ddl_market_element_'.$me_row["id"]][$i];
						$max_per_arr[$i] = $_REQUEST['txt_max_hike_'.$me_row["id"]][$i];
						$recently_max_per_arr[$i] = $_REQUEST['txt_recently_promoted_max_hike_'.$me_row["id"]][$i];					
						$i++;
					}
					$mw_rating_arr[$me_row["id"]] = $rating_val_arr;
					$mw_mkt_elem_arr[$me_row["id"]] = $mkt_elem_arr;
					$mw_max_per_arr[$me_row["id"]] = $max_per_arr;
					$mw_recently_max_per_arr[$me_row["id"]] = $recently_max_per_arr;
					
					for($c=0; $c<count($crr_arr); $c++)
					{
						$crr_arr[$c] = $_REQUEST['txt_crr_per_'.$me_row["id"]."_".$c];
					}
					$mw_crr_arr[$me_row["id"]] = $crr_arr; 
				}
				
				$multiplier_wise_per_dtls["rating"] = $mw_rating_arr;
				$multiplier_wise_per_dtls["mkt_elem"] = $mw_mkt_elem_arr;
				$multiplier_wise_per_dtls["crr"] = $mw_crr_arr;
				$multiplier_wise_per_dtls["max_per"] = $mw_max_per_arr;
				$multiplier_wise_per_dtls["recently_max_per"] = $mw_recently_max_per_arr;
				//echo "<pre>";print_r($multiplier_wise_per_dtls);die;
				$step3_db_arr = array(
										'multiplier_wise_per_dtls' => json_encode($multiplier_wise_per_dtls),
										"updatedby" => $this->session->userdata('userid_ses'),
										"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
										"updatedon" => date("Y-m-d H:i:s")
									);
				$this->rule_model->update_rules(array("id"=>$rule_id), $step3_db_arr);
			
				echo 3; die;
			}
			elseif($step==4)
			{
				$manual_budget_dtls = array();
				$managers_total_budget = 0;				
				$budgt_type = $this->input->post("ddl_overall_budget");
				$total_budget_to_cr1 = $this->input->post("hf_total_budget_to_cr1");
				$total_current_salary = $this->input->post("hf_total_current_sal");
				
				$managers_bdgt_dtls_arr = array();
				$managers_total_bdgt_dtls_arr = array("total_employees"=>0, "total_emps_total_salary"=>0, "total_budget_as_per_plan"=>0, "total_additional_budget_per"=>0, "total_revised_budget"=>0, "total_increased_amt_per"=>0, "total_budget_to_cr1"=>0);
				
				$standard_bdgt_per = 0;
				$manager_x_per_arr = array();
				if($this->input->post("ddl_overall_budget")=="Automated but x% can exceed")
				{
					$standard_bdgt_per = $this->input->post("txt_standard_bdgt_per");
					if($_FILES)
					{						
						$file_type = explode('.', $_FILES['increments_file']['name']);
						if($file_type[1] == 'csv')
						{
							$scan_file_result = HL_scan_uploaded_file($_FILES['increments_file']['name'],$_FILES['increments_file']['tmp_name']);
							if($scan_file_result === true)
							{				
								$filename = $_FILES["increments_file"]["tmp_name"];
								$file = fopen($filename, "r");
								$row = 1;
								while(($csv_data = fgetcsv($file, "", ",")) !== FALSE)
								{
									if($row == 1)
									{
										$row++;
										continue;
									}
									if(!empty(trim($csv_data[1])))
									{
										// $uploaded_x_per_val = 0;
										// if(trim($csv_data[2])*1 > 0)
										// {
										// 	$uploaded_x_per_val = trim($csv_data[2])*1;
										// }
										$uploaded_x_per_val = trim($csv_data[2])*1;
										$manager_x_per_arr[] = array("manager_email"=>strtolower($csv_data[1]), "x_per"=>$uploaded_x_per_val);
									}
								}
							}
							else
							{
								$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
								$this->session->set_flashdata('step', '1');					
								redirect($_SERVER['HTTP_REFERER']);
							}
						}		
					}
				}
						
				foreach($_REQUEST['hf_managers'] as $key=> $value) 
				{				
					$manager_budget = 0;				
					$additional_budget_per = 0;
					$pre_calculated_budgt = $_REQUEST['hf_pre_calculated_budgt'][$key];
					
					if($this->input->post("ddl_overall_budget")=="Automated locked" or $this->input->post("ddl_overall_budget")=="No limit")
					{
						$manager_budget = $pre_calculated_budgt;
					}
					elseif($this->input->post("ddl_overall_budget")=="Automated but x% can exceed")
					{
						$additional_budget_per = $_REQUEST['hf_additional_bdgt_per'][$key];
						if($manager_x_per_arr)
						{
							foreach($manager_x_per_arr as $m_row)
							{
								if($m_row["manager_email"] == strtolower($value))
								{
									$additional_budget_per = $m_row["x_per"];
									continue;
								}
							}
						}
						$manager_budget = $pre_calculated_budgt;
					}
					
					$managers_total_budget += $manager_budget + ($manager_budget*$additional_budget_per)/100;
					$manual_budget_dtls[]=array($value, $manager_budget, $additional_budget_per, $pre_calculated_budgt);				
					
					$current_manager_bdgt_dtls_arr = array("manager_name"=>"", "manager_email"=>"", "total_employees"=>0, "emps_total_salary"=>0, "budget_as_per_plan"=>0, "additional_budget_per"=>0, "revised_budget"=>0, "increased_amt_per"=>0, "total_budget_to_cr1"=>0);
					
					$current_manager_bdgt_dtls_arr["manager_name"] = $_REQUEST['hf_manager_names'][$key];
					$current_manager_bdgt_dtls_arr["manager_email"] = $value;
					$current_manager_bdgt_dtls_arr["total_employees"] = $_REQUEST['hf_manager_total_emps'][$key];
					$current_manager_bdgt_dtls_arr["emps_total_salary"] = $_REQUEST['hf_emps_total_salary'][$key];//$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];				
					$current_manager_bdgt_dtls_arr["budget_as_per_plan"] = $manager_budget;
					$revised_budget = ($manager_budget + ($manager_budget*$additional_budget_per)/100);		
					$current_manager_bdgt_dtls_arr["additional_budget_per"] = $additional_budget_per;
					$current_manager_bdgt_dtls_arr["revised_budget"] = $revised_budget;	
					if($current_manager_bdgt_dtls_arr["emps_total_salary"]>0)
					{			
						$current_manager_bdgt_dtls_arr["increased_amt_per"] = $revised_budget/$current_manager_bdgt_dtls_arr["emps_total_salary"]*100;
					}
					$current_manager_bdgt_dtls_arr["total_budget_to_cr1"] = $_REQUEST['hf_budget_to_cr1'][$key];//$manager_emp_budget_dtls['managers_budget_to_make_CR_1'];
					
					$current_manager_bdgt_dtls_arr["f_name"] = $_REQUEST['hf_manager_function_name'][$key];
					$current_manager_bdgt_dtls_arr["bl3_name"] = $_REQUEST['hf_manager_bl3_name'][$key];
					
					$managers_total_bdgt_dtls_arr["f_col"] = "";
					$managers_total_bdgt_dtls_arr["bl3_col"] = "";	
					$managers_total_bdgt_dtls_arr["total_employees"] +=$current_manager_bdgt_dtls_arr["total_employees"];					
					$managers_total_bdgt_dtls_arr["total_emps_total_salary"] += $current_manager_bdgt_dtls_arr["emps_total_salary"];					
					$managers_total_bdgt_dtls_arr["total_budget_as_per_plan"] += $manager_budget;
					$managers_total_bdgt_dtls_arr["total_additional_budget_per"] += $additional_budget_per;					
					$managers_total_bdgt_dtls_arr["total_revised_budget"] += $revised_budget;	
					if($current_manager_bdgt_dtls_arr["emps_total_salary"]>0)
					{
						$managers_total_bdgt_dtls_arr["total_increased_amt_per"] += $revised_budget/$current_manager_bdgt_dtls_arr["emps_total_salary"]*100;
					}					
					$managers_total_bdgt_dtls_arr["total_budget_to_cr1"] += $current_manager_bdgt_dtls_arr["total_budget_to_cr1"];
					$managers_bdgt_dtls_arr[] = $current_manager_bdgt_dtls_arr;
				}
			
				$managers_total_bdgt_dtls_arr["total_increased_amt_per"] = ($managers_total_bdgt_dtls_arr["total_revised_budget"]/$managers_total_bdgt_dtls_arr["total_emps_total_salary"])*100;
				
				$managers_total_bdgt_dtls_arr["avg_of_total_improvment_on_cr"] = $this->input->post("hf_improvement_avg_crr");
				$managers_total_bdgt_dtls_arr["avg_of_total_pre_cr"] = $this->input->post("hf_improvement_pre_avg_crr");
				$managers_total_bdgt_dtls_arr["avg_of_total_post_cr"] = $this->input->post("hf_improvement_post_avg_crr");
				$managers_total_bdgt_dtls_arr["standard_bdgt_per"] = $standard_bdgt_per;
				$step3_db_arr = array(		
							'budget_accumulation' => $this->input->post("ddl_budget_accumulation"),
							'include_promotion_budget' => $this->input->post("ddl_include_promotion_budget"),
							'manager_can_exceed_budget' => $this->input->post("ddl_manager_can_exceed_budget"),						
							'overall_budget' => $this->input->post("ddl_overall_budget"),
							'to_currency_id' => $this->input->post("ddl_to_currency"),
							'manual_budget_dtls' => json_encode($manual_budget_dtls),
							"managers_bdgt_dtls_for_tbl" => json_encode($managers_bdgt_dtls_arr),
							"managers_bdgt_dtls_for_tbl_head" => json_encode($managers_total_bdgt_dtls_arr),
							"show_prorated_current_sal" => $this->input->post("ddl_show_prorated_current_sal"),							
							"updatedby" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedon" => date("Y-m-d H:i:s")
						);
				
				if($data['rule_dtls']["rule_refresh_status"] != 1)
				{
					$step3_db_arr['status'] = 3;
				}
				$this->rule_model->update_rules(array("id"=>$rule_id), $step3_db_arr);
				
				if($data['rule_dtls']["rule_refresh_status"] != 1)
				{
					$this->rule_model->delete_emp_salary_dtls(array("rule_id"=>$rule_id));
					$this->calculate_increments($rule_id, 1);// Insert emp salary as rule
				}
				
				/*
				//*********** Start :: Code to store data for rule comparison **************
				$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");
				$avg_cr_dtls = $this->calculate_increments($data["rule_dtls"]["id"],0);	
				$rule_comparison_dtls = array("total_emps"=>count($staff_list), "total_managers"=>count($manual_budget_dtls), "total_rule_budget"=>$managers_total_budget, "total_budget_to_cr1"=>$total_budget_to_cr1, "total_current_salary"=>$total_current_salary, "avg_of_total_improvment_on_cr"=>$avg_cr_dtls["avg_of_total_improvment_on_cr"], "avg_of_total_pre_cr"=>$avg_cr_dtls["avg_of_total_pre_cr"], "avg_of_total_post_cr"=>$avg_cr_dtls["avg_of_total_post_cr"]);	
				$this->rule_model->update_rules(array("id"=>$rule_id), array('rule_comparison_dtls' => json_encode($rule_comparison_dtls)));
				//*********** End :: Code to store data for rule comparison **************
				*/				
				
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_create_right_salary').'</b></div>'); 
				if(isset($_POST['upload_file']))
				{
					$this->session->set_flashdata('step', '1');
					
					redirect($_SERVER['HTTP_REFERER']);
				}
				if($this->input->is_ajax_request())
				{
					echo 4; die;
				}
				else
				{
					if($data["rule_dtls"]["rule_refresh_status"] == 1)
					{
						redirect(site_url("rules/refresh_salary_rule_data/".$rule_id));
					}
					else
					{
						redirect(site_url("view-salary-rule-details/".$rule_id));
					}
				}
			}			
		}
	}

	public function get_file_to_upload_x_increments($rule_id, $to_currency_id, $show_prorated_current_sal)
	{
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$rule_dtls['show_prorated_current_sal'] = $show_prorated_current_sal;
		$salary_elem_ba_list = $this->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");
		$increment_applied_on_ids_arr = explode(",", $rule_dtls["salary_applied_on_elements"]);
		$increment_applied_on_names_arr = $modules_select_arr = array();
		foreach($salary_elem_ba_list as $ba_row)
		{
			if(in_array($ba_row["id"], $increment_applied_on_ids_arr))
			{
				$increment_applied_on_names_arr[] = $ba_row['ba_name'];
			}
			$modules_select_arr[] = $ba_row['ba_name'];
		}
		$modules_select_str = implode(",", $modules_select_arr);
		$increment_applied_on_str = implode("+", $increment_applied_on_names_arr);
		
		$select_str_for_manager_bdgt = "login_user.id, login_user." . CV_BA_NAME_EMP_EMAIL . ", login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", (SELECT name FROM manage_currency mc WHERE mc.id = login_user." . CV_BA_NAME_CURRENCY . ") AS currency_name";		
		$select_str_for_manager_bdgt .= "," . $modules_select_str;
		$select_str_for_manager_bdgt .= " , (" .$increment_applied_on_str .") AS total_salary_to_apply_increment";
		
		$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);
		if($managers)
		{	
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			
			$prorated_txt = "";
			if($rule_dtls['show_prorated_current_sal']==1)
			{
				$prorated_txt = "Prorated ";
			}
			
			$csv_file = "managers-x-increments.csv";
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $csv_file . '"');
			$fp = fopen('php://output', 'wb');
			
			if($rule_dtls['salary_position_based_on'] == "2")
			{
				$head_arr = array("Name", "Email Id", "Automated but x% can exceed", "Number Of Employee", $prorated_txt."Current Salary(".$to_currency_dtls["name"].")","Budget as per the plan (".$to_currency_dtls["name"].")", "Revised Budget (".$to_currency_dtls["name"].")","% Increased");
			}
			else
			{
				$head_arr = array("Name", "Email Id", "Automated but x% can exceed", "Number Of Employee", $prorated_txt."Current Salary(".$to_currency_dtls["name"].")","Budget as per the plan (".$to_currency_dtls["name"].")", "Revised Budget (".$to_currency_dtls["name"].")","% Increased","Budget to bring all to their target positioning (only forreference)(".$to_currency_dtls["name"].")");
			}
			fputcsv($fp, $head_arr);
			
			$managers_old_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
			foreach($managers as $row)
			{
				$additional_budget_per = 0;
				$current_manager_bdgt_dtls_arr = array("manager_name"=>"", "manager_email"=>"", "total_employees"=>0, "emps_total_salary"=>0, "budget_as_per_plan"=>0, "additional_budget_per"=>0, "revised_budget"=>0, "increased_amt_per"=>0, "total_budget_to_cr1"=>0);
				
				$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($rule_dtls, $row['first_approver'], $to_currency_id, $select_str_for_manager_bdgt);
				$manager_emp_budget_dtls['currency']['currency_type'] = $to_currency_dtls["name"];
				$manager_budget = $manager_emp_budget_dtls["budget"];
				
				$current_manager_bdgt_dtls_arr["manager_name"] = $row['manager_name'];
				$current_manager_bdgt_dtls_arr["manager_email"] = $row['first_approver'];
				$current_manager_bdgt_dtls_arr["total_employees"] = $manager_emp_budget_dtls["total_emps"];					
				$current_manager_bdgt_dtls_arr["emps_total_salary"] = $manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];					
				$current_manager_bdgt_dtls_arr["budget_as_per_plan"] = $manager_budget;
				
				$revised_budget = $manager_budget;
				if($managers_old_arr) 
				{
					foreach($managers_old_arr as $key => $value)
					{
						if(strtoupper($value[0]) == strtoupper($row['first_approver']))
						{
							$additional_budget_per = $value[2];
							$revised_budget = ($revised_budget + ($revised_budget*$value[2])/100);
							break;
						}
					}
				}
				$current_manager_bdgt_dtls_arr["additional_budget_per"] = $additional_budget_per;
				$current_manager_bdgt_dtls_arr["revised_budget"] = $revised_budget;
				if($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]>0)
				{
					$current_manager_bdgt_dtls_arr["increased_amt_per"] = $revised_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100;
				}		
				$current_manager_bdgt_dtls_arr["total_budget_to_cr1"] = $manager_emp_budget_dtls['managers_budget_to_make_CR_1'];		
						
				
				if($rule_dtls['salary_position_based_on'] == "2")
				{
					$item_arr = array($current_manager_bdgt_dtls_arr["manager_name"], $current_manager_bdgt_dtls_arr["manager_email"], round($current_manager_bdgt_dtls_arr["additional_budget_per"], 2), $current_manager_bdgt_dtls_arr["total_employees"], round($current_manager_bdgt_dtls_arr["emps_total_salary"]), round($current_manager_bdgt_dtls_arr["budget_as_per_plan"]), round($current_manager_bdgt_dtls_arr["revised_budget"]), round($current_manager_bdgt_dtls_arr["increased_amt_per"], 2));
				}
				else
				{
					$item_arr = array($current_manager_bdgt_dtls_arr["manager_name"], $current_manager_bdgt_dtls_arr["manager_email"], round($current_manager_bdgt_dtls_arr["additional_budget_per"], 2), $current_manager_bdgt_dtls_arr["total_employees"], round($current_manager_bdgt_dtls_arr["emps_total_salary"]), round($current_manager_bdgt_dtls_arr["budget_as_per_plan"]), round($current_manager_bdgt_dtls_arr["revised_budget"]), round($current_manager_bdgt_dtls_arr["increased_amt_per"], 2), round($current_manager_bdgt_dtls_arr["total_budget_to_cr1"]));
				}
				fputcsv($fp, $item_arr);				
			}	
			fclose($fp);	
		}
	}

	public function calculate_increments($rule_id, $is_need_to_save_data=0, $send_for_release=0)
	{
		// $is_need_to_save_data = 0 (No) and 1 (Yes)
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$salary_elem_ba_list = $this->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");
		$increment_applied_on_ids_arr = explode(",", $rule_dtls["salary_applied_on_elements"]);
		$increment_applied_on_names_arr = $modules_select_arr = array();
		foreach($salary_elem_ba_list as $ba_row)
		{
			if(in_array($ba_row["id"], $increment_applied_on_ids_arr))
			{
				$increment_applied_on_names_arr[] = $ba_row['ba_name'];
			}
			$modules_select_arr[] = $ba_row['ba_name'];
		}
		$modules_select_str = implode(",", $modules_select_arr);
		$increment_applied_on_str = implode("+", $increment_applied_on_names_arr);
		
		
		//************ Start :: To recalculate the Manager's Budget Details ****************************//
		
		/*$select_str_for_manager_bdgt = "login_user.id, login_user." . CV_BA_NAME_EMP_EMAIL . ", login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", (SELECT name FROM manage_currency mc WHERE mc.id = login_user." . CV_BA_NAME_CURRENCY . ") AS currency_name";		
		$select_str_for_manager_bdgt .= "," . $modules_select_str;
		$select_str_for_manager_bdgt .= " , (" .$increment_applied_on_str .") AS total_salary_to_apply_increment";
		
		
		$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);
		if($managers)
		{	
			$managers_bdgt_dtls_arr = $managers_total_bdgt_dtls_arr = $managers_manual_budget_dtls = array();
			$budget_type = $rule_dtls["overall_budget"];
			$to_currency_id = $rule_dtls["to_currency_id"];
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			
			$managers_old_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
			$managers_total_bdgt_dtls_arr = array("total_employees"=>0, "total_emps_total_salary"=>0, "total_budget_as_per_plan"=>0, "total_additional_budget_per"=>0, "total_revised_budget"=>0, "total_increased_amt_per"=>0, "total_budget_to_cr1"=>0);
			foreach($managers as $row)
			{
				$additional_budget_per = 0;
				$current_manager_bdgt_dtls_arr = array("manager_name"=>"", "manager_email"=>"", "total_employees"=>0, "emps_total_salary"=>0, "budget_as_per_plan"=>0, "additional_budget_per"=>0, "revised_budget"=>0, "increased_amt_per"=>0, "total_budget_to_cr1"=>0);
				
				$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($rule_dtls, $row['first_approver'], $to_currency_id, $select_str_for_manager_bdgt);
				$manager_emp_budget_dtls['currency']['currency_type'] = $to_currency_dtls["name"];
				$manager_budget = $manager_emp_budget_dtls["budget"];
				
				$current_manager_bdgt_dtls_arr["manager_name"] = $row['manager_name'];
				$current_manager_bdgt_dtls_arr["manager_email"] = $row['first_approver'];
				$current_manager_bdgt_dtls_arr["total_employees"] = $manager_emp_budget_dtls["total_emps"];					
				$current_manager_bdgt_dtls_arr["emps_total_salary"] = $manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];					
				$current_manager_bdgt_dtls_arr["budget_as_per_plan"] = $manager_budget;
				
				$revised_budget = $manager_budget;
				if($budget_type == "Automated but x% can exceed") 
				{
					foreach($managers_old_arr as $key => $value)
					{
						if(strtoupper($value[0]) == strtoupper($row['first_approver']))
						{
							$additional_budget_per = $value[2];
							$revised_budget = round($revised_budget + ($revised_budget*$value[2])/100);
							break;
						}
					}
				}
				$current_manager_bdgt_dtls_arr["additional_budget_per"] = $additional_budget_per;
				$current_manager_bdgt_dtls_arr["revised_budget"] = $revised_budget;
				if($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]>0)
				{
					$current_manager_bdgt_dtls_arr["increased_amt_per"] = $revised_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100;
				}
				
				$current_manager_bdgt_dtls_arr["total_budget_to_cr1"] = $manager_emp_budget_dtls['managers_budget_to_make_CR_1'];
				
				$managers_total_bdgt_dtls_arr["total_employees"] += $manager_emp_budget_dtls["total_emps"];					
				$managers_total_bdgt_dtls_arr["total_emps_total_salary"] += $manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];					
				$managers_total_bdgt_dtls_arr["total_budget_as_per_plan"] += $manager_budget;
				$managers_total_bdgt_dtls_arr["total_additional_budget_per"] += $additional_budget_per;					
				$managers_total_bdgt_dtls_arr["total_revised_budget"] += $revised_budget;
				if($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]>0)
				{
					$managers_total_bdgt_dtls_arr["total_increased_amt_per"] += $revised_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]*100;
				}					
				
				$managers_total_bdgt_dtls_arr["total_budget_to_cr1"] += $manager_emp_budget_dtls['managers_budget_to_make_CR_1'];
				
				$managers_manual_budget_dtls[] = array($row['first_approver'], $manager_budget, $additional_budget_per, $manager_budget);
				$managers_bdgt_dtls_arr[] = $current_manager_bdgt_dtls_arr;					
			}
		
			$managers_total_bdgt_dtls_arr["total_increased_amt_per"] = ($managers_total_bdgt_dtls_arr["total_revised_budget"]/$managers_total_bdgt_dtls_arr["total_emps_total_salary"])*100;
			
			$this->rule_model->update_rules(array("id"=>$rule_id), array("managers_bdgt_dtls_for_tbl"=>json_encode($managers_bdgt_dtls_arr), "managers_bdgt_dtls_for_tbl_head"=>json_encode($managers_total_bdgt_dtls_arr), "manual_budget_dtls"=>json_encode($managers_manual_budget_dtls)));
			$rule_dtls['manual_budget_dtls'] = json_encode($managers_manual_budget_dtls);
		}*/
		//************ End :: To recalculate the Manager's Budget Details ****************************//
		
		$managers_budget_dtls = array();
		
		//$data['total_max_budget'] = 0;
		$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
		foreach($managers_arr as $key => $value)
		{
			$managers_budget_dtls[$key]["manager_email"] = $value[0];
			$managers_budget_dtls[$key]["manager_budegt"] = $value[1] + (($value[1]*$value[2])/100);
			$managers_budget_dtls[$key]["manager_employee_tot_incr_salary"] = 0;
			
			$managers_budget_dtls[$key]["manager_emp_arr"] = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$value[0]."'");
			$managers_budget_dtls[$key]["bdgt_x_per_exceed_val"] = $value[2];
		}			
		
		$all_emp_total_salary = 0;
		//$total_improvment_on_cr = $total_pre_cr = $total_post_cr = 0;
		$total_pre_cr = $total_post_cr = 0;
		
		//$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");	
		
		$user_id_based_condition = "login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")";
		$select_str = "login_user.id, login_user.employee_code, login_user." . CV_BA_NAME_EMP_FULL_NAME . ", login_user." . CV_BA_NAME_EMP_EMAIL . ", login_user." . CV_BA_NAME_GENDER . ",login_user." . CV_BA_NAME_EMP_FIRST_NAME . ", login_user." . CV_BA_NAME_COUNTRY . ", login_user." . CV_BA_NAME_CITY . ", login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . ", login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . ", login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . ", login_user." . CV_BA_NAME_FUNCTION . ", login_user." . CV_BA_NAME_SUBFUNCTION . ", login_user." . CV_BA_NAME_SUB_SUBFUNCTION . ", login_user." . CV_BA_NAME_DESIGNATION . ", login_user." . CV_BA_NAME_GRADE . ", login_user." . CV_BA_NAME_LEVEL . ", login_user." . CV_BA_NAME_EDUCATION . ", login_user." . CV_BA_NAME_CRITICAL_TALENT . ", login_user." . CV_BA_NAME_CRITICAL_POSITION . ", login_user." . CV_BA_NAME_SPECIAL_CATEGORY . ", login_user.tenure_company, login_user.tenure_role, login_user.company_name, login_user." . CV_BA_NAME_COMPANY_JOINING_DATE . ", login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", login_user." . CV_BA_NAME_RECENTLY_PROMOTED . ", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", login_user.".CV_BA_NAME_TOTAL_COMPENSATION.", login_user." . CV_BA_NAME_PERFORMANCE_ACHIEVEMENT . ", login_user.".CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE.", login_user.".CV_BA_NAME_START_DATE_FOR_ROLE.", login_user.".CV_BA_NAME_END_DATE_FOR_ROLE.", login_user.".CV_BA_NAME_APPROVER_1.", login_user.".CV_BA_NAME_APPROVER_2.", login_user.".CV_BA_NAME_APPROVER_3.", login_user.".CV_BA_NAME_APPROVER_4.", login_user.".CV_BA_NAME_MANAGER_NAME.", (SELECT name FROM login_user l WHERE l.email=login_user." . CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER . ") AS " . CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER . ", (SELECT name FROM login_user l WHERE l.email=login_user." . CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER . ") AS " . CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER . ", login_user.".CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER.", login_user.".CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER.", manage_country.name AS country_name, manage_city.name AS city_name, manage_business_level_1.name AS bu1_name, manage_business_level_2.name AS bu2_name, manage_business_level_3.name AS bu3_name, manage_function.name AS function_name, manage_subfunction.name AS subfunction_name, manage_sub_subfunction.name AS sub_subfunction_name, manage_designation.name AS designation_name, manage_grade.name AS grade_name, manage_level.name AS level_name, manage_education.name AS education_name, manage_critical_talent.name AS critical_talent_name, manage_critical_position.name AS critical_position_name, manage_special_category.name AS special_category_name, manage_currency.name AS currency_name, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS performance_rating_name, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.".CV_BA_NAME_RATING_FOR_LAST_YEAR.") AS ".CV_BA_NAME_RATING_FOR_LAST_YEAR."
, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.".CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR.") AS ".CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR."
, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.".CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR.") AS ".CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR."
, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.".CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR.") AS ".CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR."
, (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user.".CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR.") AS ".CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR;		
		$select_str .= "," . $modules_select_str;
		$select_str .= " , (" . $increment_applied_on_str . ") AS total_salary_to_apply_increment";
		$staff_list = $this->rule_model->get_users_list_for_salary_rule($select_str, $user_id_based_condition);
		$currency_rate_list = $this->rule_model->get_table("currency_rates", "id, from_currency, to_currency, rate", "status=1", "id ASC");
		/*$staff_list = $this->rule_model->get_table("login_user", "*", "id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")", "id ASC");
		$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("id, ba_name","id IN(".$rule_dtls["salary_applied_on_elements"].")");*/
		
		$promotion_basis_on = CV_BA_NAME_DESIGNATION;
		if($rule_dtls["promotion_basis_on"]=="2")
		{
			$promotion_basis_on = CV_BA_NAME_GRADE;
		}
		elseif($rule_dtls["promotion_basis_on"]=="3")
		{
			$promotion_basis_on = CV_BA_NAME_LEVEL;
		}
		$promotion_type_element_dtls = json_decode($rule_dtls["promotion_type_element_dtls"], true);
		
		if($rule_dtls["hike_multiplier_basis_on"])
		{
			$hike_multiplier_basis_on = CV_BA_NAME_COUNTRY;
			if($rule_dtls["hike_multiplier_basis_on"]=="2")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_GRADE;
			}
			elseif($rule_dtls["hike_multiplier_basis_on"]=="3")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_LEVEL;
			}
			//$hike_multiplier_arr = json_decode($rule_dtls["hike_multiplier_dtls"], true);
			$multiplier_wise_per_dtls = json_decode($rule_dtls["multiplier_wise_per_dtls"], true);
		}
		
		$main_db_arr = array();
		foreach($staff_list as $row)
		{
			$users_dtls = $row;//$this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
			$employee_id = $users_dtls["id"];//$row["user_id"];
			$increment_applied_on_amt = $users_dtls["total_salary_to_apply_increment"];
			$total_per_to_increase_salary=0;
			$performnace_based_increment_percet=0;
			$performance_rating_name = $users_dtls["performance_rating_name"];
			$performance_rating_id = $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR];
			
			//$hike_multiplier_val = 1;//0;
			/*if(isset($hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]))
			{
				$hike_multiplier_val = $hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]/100;
			}*/
			
			/*$currency_rate_dtls = $this->rule_model->get_table_row("currency_rates", "rate", array("from_currency"=>$users_dtls[CV_BA_NAME_CURRENCY], "to_currency"=>$rule_dtls['to_currency_id']));
			if($currency_rate_dtls["rate"])
			{
			$currency_conv_rate = $currency_rate_dtls["rate"];
			}*/
			
			$currency_conv_rate = 0;
			foreach($currency_rate_list as $rate_row)
			{
				if($rate_row["from_currency"] == $users_dtls[CV_BA_NAME_CURRENCY] and $rate_row["to_currency"] == $rule_dtls['to_currency_id'])
				{
					$currency_conv_rate = $rate_row["rate"];
					break;
				}
			}
			
			//**************** Note :: Proreta Calculation Start ****************/
			/*$proreta_multiplier = 1;//Default
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			if($rule_dtls["prorated_increase"] == "yes")
			{
				//if(strtotime($joining_dt) <= strtotime($rule_dtls["start_dt"]))
				//{
				//$proreta_multiplier = 1;
				//}
				//else
				if(strtotime($joining_dt) <= strtotime($rule_dtls["end_dt"]))
				{
					$numerator = round((strtotime($rule_dtls["end_dt"]) - strtotime($joining_dt)) / (60 * 60 * 24));
					$denominator = round((strtotime($rule_dtls["end_dt"]) - strtotime($rule_dtls["start_dt"])) / (60 * 60 * 24));
					$proreta_multiplier = HLP_get_formated_percentage_common(($numerator/$denominator));
				}
				else
				{
					$proreta_multiplier = 0;
				}					
			}
			elseif($rule_dtls["prorated_increase"] == "fixed-percentage")
			{
				$range_of_doj_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"],true);
				foreach($range_of_doj_arr as $key=> $doj_range) 
				{
					if(strtotime(date('Y-m-d', strtotime($doj_range["From"]))) <= strtotime($joining_dt) and strtotime($joining_dt) >= strtotime(date('Y-m-d', strtotime($doj_range["To"]))))
					{
						$proreta_multiplier = $doj_range["Percentage"]/100;
						break;
					}					
				}				
			}*/
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			$proreta_multiplier = HLP_get_pro_rated_multiplier_for_salary($rule_dtls, $joining_dt);
			//$total_per_to_increase_salary = $total_per_to_increase_salary*$proreta_multiplier;
			//**************** Note :: Proreta Calculation End ****************/
			
			$increment_applied_on_elem_dtls = array();
			if($increment_applied_on_ids_arr)
			{
				foreach($salary_elem_ba_list as $ba)
				{
					if(in_array($ba["id"], $increment_applied_on_ids_arr))
					{
						$increment_applied_on_elem_dtls[] = array(
							"ba_name" => $ba["ba_name"],
							"value" => $users_dtls[$ba["ba_name"]],
							"business_attribute_id" => $ba["id"]);
					}
				}
			}
			
			/*$increment_applied_on_elem_dtls = array();
			if($increment_applied_on_arr)
			{
			foreach($increment_applied_on_arr as $salary_elem)
			{
			$increment_applied_on_elem_dtls[] = array(
				"ba_name"=>$salary_elem["ba_name"],
				"value"=>$users_dtls[$salary_elem["ba_name"]],
				"business_attribute_id"=>$salary_elem["id"],
			);
			if($users_dtls[$salary_elem["ba_name"]])
			{
				$increment_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
			}
			}
			}*/
			
			/*$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
			$max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"], true);
			$recently_promoted_max_hike_arr = json_decode($rule_dtls["if_recently_promoted"], true);
			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);*/
			//echo "<pre>";print_r($multiplier_wise_per_dtls["rating"][$users_dtls[$hike_multiplier_basis_on]]);die;
			if($rule_dtls["hike_multiplier_basis_on"])
			{
				$rating_dtls = $multiplier_wise_per_dtls["rating"][$users_dtls[$hike_multiplier_basis_on]];
				$comparative_ratio_dtls=$multiplier_wise_per_dtls["mkt_elem"][$users_dtls[$hike_multiplier_basis_on]];
				$crr_tbl_arr_temp = $multiplier_wise_per_dtls["crr"][$users_dtls[$hike_multiplier_basis_on]];
				$max_hike_arr = $multiplier_wise_per_dtls["max_per"][$users_dtls[$hike_multiplier_basis_on]];
				$recently_promoted_max_hike_arr = $multiplier_wise_per_dtls["recently_max_per"][$users_dtls[$hike_multiplier_basis_on]];			
			}
			else
			{
				$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
				$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
				$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
				$max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"], true);
				$recently_promoted_max_hike_arr = json_decode($rule_dtls["if_recently_promoted"], true);
			}
			
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$performnace_based_increment_percet = $value;
						//$performance_rating = $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR];
						break;
					}
				}			
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}
			
			$performnace_based_increment_percet = ($performnace_based_increment_percet*$proreta_multiplier);
			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);
			
			$emp_market_salary = 0;
			$market_salary_column = "";
			$crr_per = 0;
			
			
			if($rule_dtls['salary_position_based_on'] != "2")//Salary Positioning Not Based On Quartile
			{
				if($rule_dtls["performnace_based_hike"] == "yes")
				{
					foreach($comparative_ratio_dtls as $key => $value) 
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
						{
							$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
							//$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
							//$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
							$emp_market_salary = $users_dtls[$val_arr[1]];
							$market_salary_column = $val_arr[1];
							break;
						}
					}			
				}
				else
				{
					$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
					//$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
					//$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
					$market_salary_column = $val_arr[1];
					$emp_market_salary = $users_dtls[$val_arr[1]];
				}
				
				if($emp_market_salary > 0)
				{
					$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
					if($rule_dtls["comparative_ratio"] == "yes")
					{
						$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
					}				
				}
				else
				{
					$emp_market_salary = 0;	
				}
			}
			
			$i=0; 
			$min_mkt_salary = $min_mkt_salary_to_bring_emp_to_min_salary = 0;
			$pre_quartile_range_name = "";
			$increment_applied_on_amt_for_quartile = $increment_applied_on_amt;
			if($rule_dtls["comparative_ratio"] == "yes")
			{
				$increment_applied_on_amt_for_quartile = $performnace_based_salary;
			}
			$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $key => $row1)
			{
				if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{	
					$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
					if($i==0)
					{ 
						if($increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							$min_mkt_salary_to_bring_emp_to_min_salary = $users_dtls[$quartile_range_arr[1]];
							$pre_quartile_range_name = " < ".$row1["max"];
							break;
						}
					}
					else
					{
						if($min_mkt_salary <= $increment_applied_on_amt_for_quartile and $increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							$pre_quartile_range_name = $row1["min"]." To ".$row1["max"];
							break;
						}
					}
					
					if(($i+1)==count($crr_arr))
					{
						if($increment_applied_on_amt_for_quartile >= $users_dtls[$quartile_range_arr[1]])
						{
							$i++;
							$pre_quartile_range_name = " > ".$row1["max"];
							break;
						}
					}
					$min_mkt_salary = $users_dtls[$quartile_range_arr[1]];
				}
				else
				{		
					if($i==0)
					{ 
						if($crr_per < $row1["max"])
						{
							$pre_quartile_range_name = " < ".$row1["max"];
							break;
						}
					}
					else
					{
						if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
						{
							$pre_quartile_range_name = $row1["min"]." To ".$row1["max"];
							break;
						}
					}
					
					if(($i+1)==count($crr_arr))
					{
						if($crr_per >= $row1["max"])
						{
							$i++;
							$pre_quartile_range_name = " > ".$row1["max"];
							break;
						}
					}
				}
				$i++; 
			}
			
			$max_hike = 0;
			$recently_promoted_max_hike = 0;
			
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;	
			$crr_based_increment_percet = 0;
			$j=0;
			
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
						$max_hike = $max_hike_arr[$j];
						$recently_promoted_max_hike = $recently_promoted_max_hike_arr[$j];
						break;
					}
					$j++;
				}
			}
			else
			{
				$crr_based_increment_percet =  $crr_tbl_arr[$j];
				$max_hike = $max_hike_arr[$j];
				$recently_promoted_max_hike = $recently_promoted_max_hike_arr[$j];
			}
			
			if($rule_dtls['bring_emp_to_min_sal'] == 1 and $rule_dtls['salary_position_based_on'] == "2" and $i == 0 and $min_mkt_salary_to_bring_emp_to_min_salary > 0)//Salary Positioning Based On Quartile Case
			{
				$crr_based_increment_percet = HLP_get_mkt_hike_to_bring_emp_to_min_salary($increment_applied_on_amt, $min_mkt_salary_to_bring_emp_to_min_salary, $performnace_based_increment_percet, $crr_based_increment_percet);
			}
			else
			{
				$crr_based_increment_percet = ($crr_based_increment_percet*$proreta_multiplier);
			}
			$total_per_to_increase_salary = $performnace_based_increment_percet + $crr_based_increment_percet;
			
			//$data['standard_promotion_increase_perc'] = $rule_dtls["standard_promotion_increase"]*$hike_multiplier_val;
			$data['standard_promotion_increase_perc'] = 0;
			if($rule_dtls["promotion_basis_on"] > 0 and isset($promotion_type_element_dtls[$users_dtls[$promotion_basis_on]]))
			{
				$data['standard_promotion_increase_perc'] = $promotion_type_element_dtls[$users_dtls[$promotion_basis_on]];
			}
			
			
			$data['final_salary'] = $increment_applied_on_amt + (($increment_applied_on_amt*($total_per_to_increase_salary))/100);
			//$current_emp_total_salary = $data['final_salary'];
			$all_emp_total_salary += (($increment_applied_on_amt*($total_per_to_increase_salary))/100);
			$manager_emailid = "";
			$bdgt_x_per_exceed_val = 0;
			foreach($managers_budget_dtls as $emp_key => $emp_arr)
			{
				if(in_array($employee_id, $emp_arr["manager_emp_arr"]))
				{
					$manager_emailid = $managers_budget_dtls[$emp_key]["manager_email"];
					$managers_budget_dtls[$emp_key]["manager_employee_tot_incr_salary"] =  $managers_budget_dtls[$emp_key]["manager_employee_tot_incr_salary"] + (($increment_applied_on_amt*($total_per_to_increase_salary))/100);
					$bdgt_x_per_exceed_val = $managers_budget_dtls[$emp_key]["bdgt_x_per_exceed_val"];;
					break;
				}					
			}
			
			if($emp_market_salary>0)
			{
				//$total_improvment_on_cr += ((($data['final_salary']/$emp_market_salary)*100) - (($increment_applied_on_amt/$emp_market_salary)*100))/(($increment_applied_on_amt/$emp_market_salary)*100);
				$total_pre_cr += ($increment_applied_on_amt/$emp_market_salary)*100;
				$total_post_cr += ($data['final_salary']/$emp_market_salary)*100;
			}
			
			if($is_need_to_save_data==1)
			{
				// Note :: $send_for_release => 1=Rule send for release directly so no need to verify salary by managers, other then 1 means need verify salary by managers
				$status = 1;
				
				if($send_for_release == 1)
				{			
					$status = 5;
				}
				
				$emp_final_bdgt = (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($increment_applied_on_amt*$crr_based_increment_percet)/100);
				if($rule_dtls["overall_budget"] == "No limit")	
				{
					//$emp_final_bdgt = 0;// No limit set for budget//Commented this line because we need this bdgt
				}
				elseif($rule_dtls["overall_budget"] == "Automated but x% can exceed")
				{
					$emp_final_bdgt += ($emp_final_bdgt*$bdgt_x_per_exceed_val)/100; 
				}
				//$current_users_rating_dtls = $this->rule_model->get_table_row("manage_rating_for_current_year", "*", array("id"=>$performance_rating_name), "id desc");
				
				$min_salary_for_penetration = 0;
				$max_salary_for_penetration = 0;
				if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{
					$crr_range_arr=array_keys(json_decode($rule_dtls["comparative_ratio_range"], true));
					$min_range_name = explode(CV_CONCATENATE_SYNTAX ,$crr_range_arr[0])[1];
					$max_range_name = explode(CV_CONCATENATE_SYNTAX ,$crr_range_arr[count($crr_range_arr)-1])[1];
					
					$min_salary_for_penetration = $users_dtls[$min_range_name];
					$max_salary_for_penetration = $users_dtls[$max_range_name];
				}
				
				$db_arr =array(
					"rule_id" => $rule_id,
					"user_id" => $employee_id,	
					"emp_currency_conversion_rate" => $currency_conv_rate,						
					"increment_applied_on_salary" => $increment_applied_on_amt,
					"increment_applied_on_elem_dtls" => json_encode($increment_applied_on_elem_dtls),
					"performnace_based_increment" => $performnace_based_increment_percet,
					"performance_rating" => $performance_rating_name,
					"emp_performance_rating" => $performance_rating_name,
					"performance_rating_id" => $performance_rating_id,
					"budget_to_make_cr1" => $emp_market_salary - $increment_applied_on_amt,
					"crr_val" => $crr_per,
					"crr_based_increment" => $crr_based_increment_percet,
					"pre_quartile_range_name" => $pre_quartile_range_name,
					"post_quartile_range_name" => HLP_get_quartile_position_range_name($users_dtls, $data['final_salary'], $crr_arr),
					"standard_promotion_increase" => $data['standard_promotion_increase_perc'],
					"sp_manager_discretions" => "",
					"emp_new_designation" => "",							
					"market_salary" => $emp_market_salary,
					"market_salary_column" => $market_salary_column,					
					"mkt_salary_after_promotion" => $emp_market_salary,
					"crr_after_promotion" => $crr_per,
					"quartile_range_name_after_promotion" => $pre_quartile_range_name,
					"final_merit_hike" => $performnace_based_increment_percet,
					"final_market_hike" => $crr_based_increment_percet,
					"min_salary_for_penetration" => $min_salary_for_penetration,
					"max_salary_for_penetration" => $max_salary_for_penetration,
					"emp_final_bdgt" => $emp_final_bdgt,
					"final_salary" => $data['final_salary'],
					"actual_salary" => $data['final_salary'],
					"max_hike" => $max_hike,
					"recently_promoted_max_hike" => $recently_promoted_max_hike,
					"proreta_multiplier"=>$proreta_multiplier,
					//"total_hike_as_per_rule" =>$total_per_to_increase_salary, 
					"manager_discretions"=>$total_per_to_increase_salary,
					"manager_emailid" => $manager_emailid,
					"last_action_by" => $manager_emailid,							
					"status" => $status,
					"created_by" => $this->session->userdata('userid_ses'),
					"created_on" =>date("Y-m-d H:i:s"),
					"updatedby" =>$this->session->userdata('userid_ses'),
					"updatedon" =>date("Y-m-d H:i:s"),
					"createdby_proxy"=>$this->session->userdata("proxy_userid_ses"),
					"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"),
					"country" => "",
					"city" => "",
					"business_level_1" => "",
					"business_level_2" => "",
					"business_level_3" => "",
					"designation" => "",
					"function" => "",
					"sub_function" => "",
					"sub_sub_function" => "",
					"grade" => "",
					"level" => "",
					"education" => "",
					"critical_talent" => "",
					"critical_position" => "",
					"special_category" => "",
					"tenure_company" => "",
					"tenure_role" => "",
					"company_name" => "",
					"emp_name" => "",
					"emp_first_name" => "",
					"email_id" => "",
					"gender" => "",
					"recently_promoted" => "",
					"performance_achievement" => "",
					"currency" => "",
					"current_base_salary" => "",
					"allowance_1" => "",
					"allowance_2" => "",
					"allowance_3" => "",
					"allowance_4" => "",
					"allowance_5" => "",
					"allowance_6" => "",
					"allowance_7" => "",
					"allowance_8" => "",
					"allowance_9" => "",
					"allowance_10" => "",
					"allowance_11" => "",
					"allowance_12" => "",
					"allowance_13" => "",
					"allowance_14" => "",
					"allowance_15" => "",
					"allowance_16" => "",
					"allowance_17" => "",
					"allowance_18" => "",
					"allowance_19" => "",
					"allowance_20" => "",
					"allowance_21" => "",
					"allowance_22" => "",
					"allowance_23" => "",
					"allowance_24" => "",
					"allowance_25" => "",
					"allowance_26" => "",
					"allowance_27" => "",
					"allowance_28" => "",
					"allowance_29" => "",
					"allowance_30" => "",
					"allowance_31" => "",
					"allowance_32" => "",
					"allowance_33" => "",
					"allowance_34" => "",
					"allowance_35" => "",
					"allowance_36" => "",
					"allowance_37" => "",
					"allowance_38" => "",
					"allowance_39" => "",
					"allowance_40" => "",
					"bonus_incentive_applicable" => "",
					"current_target_bonus" => "",
					"total_compensation" => "",
					"joining_date_for_increment_purposes" => "",
					"joining_date_the_company" => "",
					"start_date_for_role" => "",
					"end_date_the_role" => "",					
					"rating_last_year" => "",
					"rating_2nd_last_year" => "",
					"rating_3rd_last_year" => "",
					"rating_4th_last_year" => "",
					"rating_5th_last_year" => "",					
					"approver_1" => "",
					"approver_2" => "",
					"approver_3" => "",
					"approver_4" => "",
					"manager_name" => "",
					"authorised_signatory_for_letter" => "",
					"authorised_signatory_title_for_letter" => "",
					"hr_authorised_signatory_for_letter" => "",
					"hr_authorised_signatory_title_for_letter" => ""					
				);
				
				//Newly code by ravi to insert required parameters from datum tbl to this tbl on 10-05-18 Start
				if($users_dtls['country_name'])
				{
					//$country_arr = $this->admin_model->get_table_row("manage_country", "name", array( "id"=>$users_dtls[CV_BA_NAME_COUNTRY]), "id desc");
					$db_arr["country"] = $users_dtls['country_name'];
				}
				if($users_dtls['city_name'])
				{
					//$city_arr = $this->admin_model->get_table_row("manage_city", "name", array( "id"=>$users_dtls[CV_BA_NAME_CITY]), "id desc");
					$db_arr["city"] = $users_dtls['city_name'];//$city_arr['name'];
				}
				if($users_dtls['bu1_name'])
				{
					//$bu_1_arr = $this->admin_model->get_table_row("manage_business_level_1", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_1]), "id desc");
					$db_arr["business_level_1"] = $users_dtls['bu1_name'];//$bu_1_arr['name'];
				}
				if($users_dtls['bu2_name'])
				{
					//$bu_2_arr = $this->admin_model->get_table_row("manage_business_level_2", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_2]), "id desc");
					$db_arr["business_level_2"] = $users_dtls['bu2_name'];//$bu_2_arr['name'];
				}
				if($users_dtls['bu3_name'])
				{
					//$bu_3_arr = $this->admin_model->get_table_row("manage_business_level_3", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_3]), "id desc");
					$db_arr["business_level_3"] = $users_dtls['bu3_name'];//$bu_3_arr['name'];
				}
				if($users_dtls['designation_name'])
				{
					//$design_arr = $this->admin_model->get_table_row("manage_designation", "name", array( "id"=>$users_dtls[CV_BA_NAME_DESIGNATION]), "id desc");
					$db_arr["designation"] = $users_dtls['designation_name'];//$design_arr['name'];
				}
				if($users_dtls['function_name'])
				{
				//$function_arr = $this->admin_model->get_table_row("manage_function", "name", array( "id"=>$users_dtls[CV_BA_NAME_FUNCTION]), "id desc");
				$db_arr["function"] = $users_dtls['function_name'];//$function_arr['name'];
				}
				if($users_dtls['subfunction_name'])
				{
				//$sub_function_arr = $this->admin_model->get_table_row("manage_subfunction", "name", array( "id"=>$users_dtls[CV_BA_NAME_SUBFUNCTION]), "id desc");
				$db_arr["sub_function"] = $users_dtls['subfunction_name'];//$sub_function_arr['name'];
				}
				
				if($users_dtls['sub_subfunction_name'])
				{
				//$sub_sub_function_arr = $this->admin_model->get_table_row("manage_sub_subfunction", "name", array( "id"=>$users_dtls[CV_BA_NAME_SUB_SUBFUNCTION]), "id desc");
				$db_arr["sub_sub_function"] = $users_dtls['sub_subfunction_name'];//$sub_sub_function_arr['name'];
				}
				
				if($users_dtls['grade_name'])
				{
				//$grade_arr = $this->admin_model->get_table_row("manage_grade", "name", array( "id"=>$users_dtls[CV_BA_NAME_GRADE]), "id desc");
				$db_arr["grade"] = $users_dtls['grade_name'];//$grade_arr['name'];
				}
				if($users_dtls['level_name'])
				{
				//$level_arr = $this->admin_model->get_table_row("manage_level", "name", array( "id"=>$users_dtls[CV_BA_NAME_LEVEL]), "id desc");
				$db_arr["level"] = $users_dtls['level_name'];//$level_arr['name'];
				}
				if($users_dtls['education_name'])
				{
				//$education_arr = $this->admin_model->get_table_row("manage_education", "name", array( "id"=>$users_dtls[CV_BA_NAME_EDUCATION]), "id desc");
				$db_arr["education"] = $users_dtls['education_name'];//$education_arr['name'];
				}
				if($users_dtls['critical_talent_name'])
				{
				//$critical_talent_arr = $this->admin_model->get_table_row("manage_critical_talent", "name", array( "id"=>$users_dtls[CV_BA_NAME_CRITICAL_TALENT]), "id desc");
				$db_arr["critical_talent"] = $users_dtls['critical_talent_name'];//$critical_talent_arr['name'];
				}
				if($users_dtls['critical_position_name'])
				{
				//$critical_position_arr = $this->admin_model->get_table_row("manage_critical_position", "name", array( "id"=>$users_dtls[CV_BA_NAME_CRITICAL_POSITION]), "id desc");
				$db_arr["critical_position"] = $users_dtls['critical_position_name'];//$critical_position_arr['name'];
				}
				if($users_dtls['special_category_name'])
				{
				//$special_category_arr = $this->admin_model->get_table_row("manage_special_category", "name", array( "id"=>$users_dtls[CV_BA_NAME_SPECIAL_CATEGORY]), "id desc");
				$db_arr["special_category"] = $users_dtls['special_category_name'];//$special_category_arr['name'];
				}
				if($users_dtls['tenure_company'])
				$db_arr["tenure_company"] = $users_dtls['tenure_company'];
				if($users_dtls['tenure_role'])
				$db_arr["tenure_role"] = $users_dtls['tenure_role'];
				if($users_dtls[CV_BA_NAME_COMPANY_NAME])
				$db_arr["company_name"] = $users_dtls[CV_BA_NAME_COMPANY_NAME];
				if($users_dtls[CV_BA_NAME_EMP_FULL_NAME])
				$db_arr["emp_name"] = $users_dtls[CV_BA_NAME_EMP_FULL_NAME];
				if($users_dtls[CV_BA_NAME_EMP_FIRST_NAME])
				$db_arr["emp_first_name"] = $users_dtls[CV_BA_NAME_EMP_FIRST_NAME];	
				if($users_dtls[CV_BA_NAME_EMP_EMAIL])
				$db_arr["email_id"] = $users_dtls[CV_BA_NAME_EMP_EMAIL];
				if($users_dtls[CV_BA_NAME_GENDER])
				$db_arr["gender"] = $users_dtls[CV_BA_NAME_GENDER];
				if($users_dtls[CV_BA_NAME_RECENTLY_PROMOTED])
				$db_arr["recently_promoted"] = $users_dtls[CV_BA_NAME_RECENTLY_PROMOTED];
				if($users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT])
				$db_arr["performance_achievement"] = $users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT];
				if($users_dtls['currency_name'])
				{
				//$currency_arr = $this->admin_model->get_table_row("manage_currency", "name", array( "id"=>$users_dtls[CV_BA_NAME_CURRENCY]), "id desc");
				$db_arr["currency"] = $users_dtls['currency_name'];//$currency_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY])
				$db_arr["current_base_salary"] = $users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_1])
				$db_arr["allowance_1"] = $users_dtls[CV_BA_NAME_ALLOWANCE_1];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_2])
				$db_arr["allowance_2"] = $users_dtls[CV_BA_NAME_ALLOWANCE_2];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_3])
				$db_arr["allowance_3"] = $users_dtls[CV_BA_NAME_ALLOWANCE_3];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_4])
				$db_arr["allowance_4"] = $users_dtls[CV_BA_NAME_ALLOWANCE_4];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_5])
				$db_arr["allowance_5"] = $users_dtls[CV_BA_NAME_ALLOWANCE_5];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_6])
				$db_arr["allowance_6"] = $users_dtls[CV_BA_NAME_ALLOWANCE_6];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_7])
				$db_arr["allowance_7"] = $users_dtls[CV_BA_NAME_ALLOWANCE_7];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_8])
				$db_arr["allowance_8"] = $users_dtls[CV_BA_NAME_ALLOWANCE_8];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_9])
				$db_arr["allowance_9"] = $users_dtls[CV_BA_NAME_ALLOWANCE_9];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_10])
				$db_arr["allowance_10"] = $users_dtls[CV_BA_NAME_ALLOWANCE_10];				
				if($users_dtls[CV_BA_NAME_ALLOWANCE_11])
				$db_arr["allowance_11"] = $users_dtls[CV_BA_NAME_ALLOWANCE_11];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_12])
				$db_arr["allowance_12"] = $users_dtls[CV_BA_NAME_ALLOWANCE_12];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_13])
				$db_arr["allowance_13"] = $users_dtls[CV_BA_NAME_ALLOWANCE_13];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_14])
				$db_arr["allowance_14"] = $users_dtls[CV_BA_NAME_ALLOWANCE_14];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_15])
				$db_arr["allowance_15"] = $users_dtls[CV_BA_NAME_ALLOWANCE_15];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_16])
				$db_arr["allowance_16"] = $users_dtls[CV_BA_NAME_ALLOWANCE_16];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_17])
				$db_arr["allowance_17"] = $users_dtls[CV_BA_NAME_ALLOWANCE_17];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_18])
				$db_arr["allowance_18"] = $users_dtls[CV_BA_NAME_ALLOWANCE_18];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_19])
				$db_arr["allowance_19"] = $users_dtls[CV_BA_NAME_ALLOWANCE_19];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_20])
				$db_arr["allowance_20"] = $users_dtls[CV_BA_NAME_ALLOWANCE_20];
				
				if($users_dtls[CV_BA_NAME_ALLOWANCE_21])
				$db_arr["allowance_21"] = $users_dtls[CV_BA_NAME_ALLOWANCE_21];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_22])
				$db_arr["allowance_22"] = $users_dtls[CV_BA_NAME_ALLOWANCE_22];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_23])
				$db_arr["allowance_23"] = $users_dtls[CV_BA_NAME_ALLOWANCE_23];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_24])
				$db_arr["allowance_24"] = $users_dtls[CV_BA_NAME_ALLOWANCE_24];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_25])
				$db_arr["allowance_25"] = $users_dtls[CV_BA_NAME_ALLOWANCE_25];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_26])
				$db_arr["allowance_26"] = $users_dtls[CV_BA_NAME_ALLOWANCE_26];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_27])
				$db_arr["allowance_27"] = $users_dtls[CV_BA_NAME_ALLOWANCE_27];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_28])
				$db_arr["allowance_28"] = $users_dtls[CV_BA_NAME_ALLOWANCE_28];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_29])
				$db_arr["allowance_29"] = $users_dtls[CV_BA_NAME_ALLOWANCE_29];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_30])
				$db_arr["allowance_30"] = $users_dtls[CV_BA_NAME_ALLOWANCE_30];				
				if($users_dtls[CV_BA_NAME_ALLOWANCE_31])
				$db_arr["allowance_31"] = $users_dtls[CV_BA_NAME_ALLOWANCE_31];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_32])
				$db_arr["allowance_32"] = $users_dtls[CV_BA_NAME_ALLOWANCE_32];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_33])
				$db_arr["allowance_33"] = $users_dtls[CV_BA_NAME_ALLOWANCE_33];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_34])
				$db_arr["allowance_34"] = $users_dtls[CV_BA_NAME_ALLOWANCE_34];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_35])
				$db_arr["allowance_35"] = $users_dtls[CV_BA_NAME_ALLOWANCE_35];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_36])
				$db_arr["allowance_36"] = $users_dtls[CV_BA_NAME_ALLOWANCE_36];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_37])
				$db_arr["allowance_37"] = $users_dtls[CV_BA_NAME_ALLOWANCE_37];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_38])
				$db_arr["allowance_38"] = $users_dtls[CV_BA_NAME_ALLOWANCE_38];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_39])
				$db_arr["allowance_39"] = $users_dtls[CV_BA_NAME_ALLOWANCE_39];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_40])
				$db_arr["allowance_40"] = $users_dtls[CV_BA_NAME_ALLOWANCE_40];						
				
				if($users_dtls[CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE])
				$db_arr["bonus_incentive_applicable"] = $users_dtls[CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE];
				if($users_dtls[CV_BA_NAME_CURRENT_TARGET_BONUS])
				$db_arr["current_target_bonus"] = $users_dtls[CV_BA_NAME_CURRENT_TARGET_BONUS];
				if($users_dtls[CV_BA_NAME_TOTAL_COMPENSATION])
				$db_arr["total_compensation"] = $users_dtls[CV_BA_NAME_TOTAL_COMPENSATION];
				if($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE])
				$db_arr["joining_date_for_increment_purposes"] = $users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE];
				if($users_dtls[CV_BA_NAME_COMPANY_JOINING_DATE])
				$db_arr["joining_date_the_company"] = $users_dtls[CV_BA_NAME_COMPANY_JOINING_DATE];
				if($users_dtls[CV_BA_NAME_START_DATE_FOR_ROLE])
				$db_arr["start_date_for_role"] = $users_dtls[CV_BA_NAME_START_DATE_FOR_ROLE];
				if($users_dtls[CV_BA_NAME_END_DATE_FOR_ROLE])
				$db_arr["end_date_the_role"] = $users_dtls[CV_BA_NAME_END_DATE_FOR_ROLE];
				if($users_dtls[CV_BA_NAME_RATING_FOR_LAST_YEAR])
				$db_arr["rating_last_year"] = $users_dtls[CV_BA_NAME_RATING_FOR_LAST_YEAR];
				if($users_dtls[CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR])
				$db_arr["rating_2nd_last_year"] = $users_dtls[CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR];
				if($users_dtls[CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR])
				$db_arr["rating_3rd_last_year"] = $users_dtls[CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR];
				if($users_dtls[CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR])
				$db_arr["rating_4th_last_year"] = $users_dtls[CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR];
				if($users_dtls[CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR])
				$db_arr["rating_5th_last_year"] = $users_dtls[CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR];				
				if($users_dtls[CV_BA_NAME_APPROVER_1])
				{
				/*$db_arr["approver_1"] = "";
				$approver_1 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_1]), "id desc");
				if($approver_1[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["approver_1"] = $users_dtls[CV_BA_NAME_APPROVER_1];//$approver_1[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_2])
				{
				/*$db_arr["approver_2"] = "";
				$approver_2 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_2]), "id desc");
				if($approver_2[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["approver_2"] = $users_dtls[CV_BA_NAME_APPROVER_2];//$approver_2[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_3])
				{
				/*$db_arr["approver_3"] = "";
				$approver_3 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_3]), "id desc");
				if($approver_3[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["approver_3"] = $users_dtls[CV_BA_NAME_APPROVER_3];//$approver_3[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_4])
				{
				/*$db_arr["approver_4"] = "";
				$approver_4 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_4]), "id desc");
				if($approver_4[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["approver_4"] = $users_dtls[CV_BA_NAME_APPROVER_4];//$approver_4[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_MANAGER_NAME])
				{
				/*$db_arr["manager_name"] = "";
				$manager_name = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_MANAGER_NAME]), "id desc");
				if($manager_name[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["manager_name"] = $users_dtls[CV_BA_NAME_MANAGER_NAME];//$manager_name[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
				/*$db_arr["authorised_signatory_for_letter"] = "";
				$authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
				if($authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["authorised_signatory_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER];//$authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
				$db_arr["authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
				/*$db_arr["hr_authorised_signatory_for_letter"] = "";
				$hr_authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
				if($hr_authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME])*/
					$db_arr["hr_authorised_signatory_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER];//$hr_authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
				$db_arr["hr_authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];							
				
				//$this->rule_model->insert_emp_salary_dtls($db_arr);
				//echo "<pre>";print_r(count($db_arr));
				$main_db_arr[] = $db_arr;
				if(count($main_db_arr)>1000)
				{	
					$this->rule_model->insert_data_as_batch("employee_salary_details", $main_db_arr);
					$main_db_arr=[];
				}
			}
		}
		
		if($main_db_arr)
		{
			$this->rule_model->insert_data_as_batch("employee_salary_details", $main_db_arr);
		}
		//$avg_of_total_improvment_on_cr = ($total_improvment_on_cr/count($staff_list))*100;
		$avg_of_total_pre_cr = $total_pre_cr/count($staff_list);
		$avg_of_total_post_cr = $total_post_cr/count($staff_list);
		
		return array("avg_of_total_improvment_on_cr"=> ($avg_of_total_post_cr - $avg_of_total_pre_cr), "avg_of_total_pre_cr"=>$avg_of_total_pre_cr, "avg_of_total_post_cr"=>$avg_of_total_post_cr);
	}
	
	public function refresh_status_change_to_reopen_salary_rule($rule_id)
	{
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if($rule_dtls["status"] == 6 or $rule_dtls["status"] == 7)
		{
			$this->rule_model->update_rules(array('id'=>$rule_id), array("rule_refresh_status"=>1, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));			
			redirect(site_url("salary-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_id));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}		
	}
	
	public function refresh_salary_rule_data($rule_id)
	{
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$rule_dtls or $rule_dtls["rule_refresh_status"] != 1)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$this->rule_model->get_backup_before_salary_rule_data_refreshed($rule_id);
		$this->calculate_increments($rule_id, 1);// Insert emp salary as rule
		$this->rule_model->restore_emps_old_hike_dtls_on_refresh_salary_rule($rule_id);
		
		$this->rule_model->update_emps_salary_dtls_on_refresh_rule($rule_dtls);
		
		$this->rule_model->update_rules(array('id'=>$rule_id),array("rule_refresh_status"=>2, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Rule data refreshed successfully.</b></div>');
		
		redirect(site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]));
	}
	
	public function send_rule_approval_request($rule_id, $send_for_release=0,$manager_id='')
	{
	// Note :: $send_for_release => 1=Need to send rule to release, other than 1 no need to send for release
		// echo 'rule_id'.$rule_id.'<br>';
		// echo 'send_for_release'.$send_for_release.'<br>';
		// echo 'manager_id'.$manager_id.'<br>';
		// exit;
	$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
	if(!$rule_dtls  or $rule_dtls["status"] < 3)
	{
	redirect(site_url("performance-cycle"));
	}	
	
	//Note :: Check for the duplicate population started *********************
	$already_created_rule_for_emp_arr = $this->rule_model->get_table("hr_parameter","id, salary_rule_name","performance_cycle_id = ".$rule_dtls["performance_cycle_id"]." AND status > 3 AND status NOT IN(5,".CV_STATUS_RULE_DELETED.")");		
	//$current_rule_emp_arr = explode(",", $rule_dtls["user_ids"]);
	$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");
	$current_rule_emp_arr = $this->rule_model->array_value_recursive("user_id", $staff_list);
	//echo "<pre>";print_r($current_rule_emp_arr);die;
	foreach($already_created_rule_for_emp_arr as $row)
	{
	//$old_emps_arr = explode(",", $row["user_ids"]);
	$old_rules_staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id", array("rule_id"=>$row["id"]), "user_id ASC");
	$old_emps_arr = $this->rule_model->array_value_recursive("user_id", $old_rules_staff_list);
	
	$search_result = array_intersect($current_rule_emp_arr, $old_emps_arr);
	if($search_result)
	{
	$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Current rule populations are already exist in another rule as : "'.$row["salary_rule_name"].'".</b></div>');
	redirect(site_url("view-salary-rule-details/".$rule_dtls["id"]));
	} 
	}
	//Note :: Check for the duplicate population Ended *********************
	
	//$this->calculate_increments($rule_id, 1, $send_for_release);// Insert emp salary as rule
	
	if($send_for_release == 1)
	{		
	$this->admin_model->update_tbl_data("employee_salary_details", array("status"=>5), array("rule_id"=>$rule_id));	
	$this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_salary_rule_for_release').'</b></div>');
	}
	else
	{
		
		if(empty($manager_id))
		{
			$manager_id=$this->session->userdata("userid_ses");
		}
		
	$this->approvel_model->create_rule_approvel_req($rule_id,$manager_id, 2);
	$this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>4, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_salary_rule_for_approval').'</b></div>');
	}
	
	redirect(site_url("view-salary-rule-details/".$rule_id));
	}	

	function searchForBudget($id, $array) {
	   foreach ($array as $key => $val) {
		   if ($val[0] === $id) {
			   return $val[1];
		   }
	   }
	   return null;
	}
	
	public function view_rule_dashboard($rule_id,$status=1)
	{
		$data['approval_count'] = $this->rule_model->get_attributeswise_dashboard_bdgt_approval_lists($rule_id);
		if($status != null){
			$data['approval_lists'] = $this->rule_model->get_attributeswise_dashboard_bdgt_approval_count($rule_id);
		}else{
			$data['approval_lists'] = array();
		}
		//piy@31Dec19
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$cond=($rule_dtls['include_promotion_budget']==1)? "":" -`sp_increased_salary`";
		$to_currency_id = $rule_dtls['to_currency_id']; 
		$data['budget_amount'] = $this->rule_model->get_attributeswise_dashboard_bdgt_budget_count($rule_id,$to_currency_id,$cond);
		$data["ddl_attributeswise_budget"] = $this->rule_model->get_ba_list_to_categorywise_salary_rpt();
		//End

		$data['parameter'] =$this->rule_model->get_table_row_object('hr_parameter', 'manual_budget_dtls', ['id'=>$rule_id]);
		$data['rattings']=$this->rule_model->get_table_object('manage_rating_for_current_year', 'id, name', ['status'=>1],'order_no') ;
		$res = $this->rule_model->get_attributeswise_dashboard_bdgt_performance_rating($rule_id);
		$total = 0;
		foreach ($res as $key => $value) {
			$total += $value->count;
		}

		/*
		* get function list which are use in this rule
		*/
		$function_cond = array('`employee_salary_details`.`rule_id`' => $rule_id);
		$data['function_array'] = $this->common_model->get_table("employee_salary_details", "DISTINCT(`function`) AS function_name", $function_cond , "id asc");
		/*
		* end function list which are use in this rule
		*/
		$data['performances_row_total'] = count($res);
		$data['performances_total'] = $total;
		$data['performances'] = $res;
		$data['rule_id'] = $rule_id;
		$data['performance_cycle_id'] = $rule_dtls["performance_cycle_id"];
		$data['title'] = "Rule Dashboard";
		$data['body'] = "view_salary_dashboard";
		$this->load->view('common/structure',$data);
	}


	//piy@25Dec19
	public function get_attributeswise_dashboard_bdgt()
	{
		$ratings = $this->rule_model->get_table_object('manage_rating_for_current_year', 'name', ['status' => 1], 'order_no');
		$for_attributes = $this->input->post("for_attributes");
		$rule_id = $this->input->post("rid");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id" => $rule_id));
		$to_currency_id = $rule_dtls['to_currency_id'];
		switch ($for_attributes) {
			case 'emp_performance_rating':
				$attributes_name = "Performance Rating";
				break;
			default:
				$attributes_name = $this->admin_model->get_table_row("business_attribute", "display_name", ['ba_name' => $for_attributes])['display_name'];
		}

		//heading
		$str_head1['sno'] = 'S.No';
		$str_head1['attributes_name'] = $attributes_name;
		$str_head1['noofemployees'] = 'No of Pending Employee';
		$str_head1['allocated_budget'] = "Allocated Budget";
		$str_head1['utilized_budget'] = "Utilized Budget";
		$str_head1['available_budget'] = "Available Budget";
		$str_head1['rating_name'] = "Rating Name";
		$str_head1['rating_distribution'] = 'Rating Distribution';
		$str_head1['avg_increase_by_rating'] = "Average Increase by Rating";

		//head1
		$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead><tr>';
		foreach ($str_head1 as $key => $value) {
			$str_main .= "<th style='vertical-align: middle;' >{$value}</th>";
		}
		$str_main .= '</tr>';
		$str_main .= '</thead>';
		switch ($for_attributes) {
			case 'sub_subfunction':
				$for_attributes = 'sub_sub_function';
				break;
			case 'subfunction':
				$for_attributes = 'sub_function';
				break;
			default:
				# code...
				break;
		}

		if (in_array($for_attributes, ['approver_1', 'approver_2', 'approver_3', 'approver_4'])) {

			$table_name = 'tmp_categorywise_dashboard_bdgt_rpt';
			$this->load->dbforge();
			$this->dbforge->drop_table($table_name, TRUE);
			$fields[$for_attributes] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["user_id"] = array('type' => 'INT', 'constraint' => '11', 'default' => 0);
			$fields["increment_applied_on_salary"] = array('type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0);
			$fields["emp_final_bdgt"] = array('type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0);
			$fields["final_salary"] = array('type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0);
			$fields["sp_increased_salary"] = array('type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0);
			$fields["currency"] = array('type' => 'VARCHAR', 'constraint' => '3', 'null' => TRUE);
			$fields["approver"] = array('type' => 'TEXT', 'null' => TRUE);
			$fields["emp_performance_rating"] = array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE);
			$fields["manager_discretions"] = array('type' => 'DECIMAL', 'constraint' => '15,8', 'default' => 0);
			$fields["status"] = array('type' => 'INT', 'constraint' => '2', 'default' => 0);
			$fields["rule_id"] = array('type' => 'INT', 'constraint' => '11', 'default' => 0);
			$fields = array_merge(array("id" => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE)), $fields);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$attributes = array('ENGINE' => 'InnoDB');
			$this->dbforge->create_table($table_name, FALSE, $attributes);

			//herirarcial 
			switch ($for_attributes) {
				case 'approver_4':
					$this->rule_model->set_attributeswise_dashboard_bdgt_insert_temp_report($rule_id, $for_attributes, $table_name, 'approver_4');
				case 'approver_3':
					$this->rule_model->set_attributeswise_dashboard_bdgt_insert_temp_report($rule_id, $for_attributes, $table_name, 'approver_3');
				case 'approver_2':
					$this->rule_model->set_attributeswise_dashboard_bdgt_insert_temp_report($rule_id, $for_attributes, $table_name, 'approver_2');
				default:
					$this->rule_model->set_attributeswise_dashboard_bdgt_insert_temp_report($rule_id, $for_attributes, $table_name, 'approver_1');
					break;
			}

			$approver_dtls = $this->rule_model->get_attributeswise_bdgt_manager_detail(" email in (select distinct approver from {$table_name})");

		}
		else
		{
			$table_name = 'employee_salary_details';
		}
		
		$cond = ($rule_dtls['include_promotion_budget'] == 1) ? "" : " -`sp_increased_salary`";
		$records = $this->rule_model->get_attributeswise_dashboard_bdgt_report($rule_id, $to_currency_id, $for_attributes, $table_name, $cond);

		$sn = 0;
		foreach ($records as  $recordObj) {

			$rating_names = explode(",", $recordObj->rating_name);
			$rating_distributions = explode(",", $recordObj->rating_distribution);

			for ($i = 0; $i < count($rating_names); $i++) {
				$recordObj->rating->{$rating_names[$i]} += $rating_distributions[$i];
				$recordObj->ratingcount->{$rating_names[$i]}++;
				$recordObj->rating_name_totalcount++;
			}
			foreach ($ratings as $name) {
				$rating_name = $name->name;
				if (isset($recordObj->rating->{$rating_name})) {
					$recordObj->rating_name_text .= "{$rating_name}</br>";

				$per =HLP_get_formated_percentage_common($recordObj->rating->{$rating_name}/$recordObj->ratingcount->{$rating_name});
				$recordObj->avg_increase_by_rating.="{$per}%</br>";
								
				$per =HLP_get_formated_percentage_common($recordObj->ratingcount->{$rating_name}*100/$recordObj->rating_name_totalcount);
				$recordObj->rating_distribution_text.="{$per}% ({$recordObj->ratingcount->{$rating_name}})</br>";

				}

			}			

			$sn++;
			$str_body .= "<tr>";
			$str_body .= "<td class='text-center'>{$sn}</td>";
			if(in_array($for_attributes,['approver_1','approver_2','approver_3','approver_4']))
			{ 
				$str_body .= "<td class='' style='min-width:250px' >".$approver_dtls[$recordObj->ba_groupon]['name']."</td>";
			}else
			{
				$str_body .= "<td class='' style='min-width:250px'>{$recordObj->ba_groupon}</td>";
			}

			$str_body .= "<td class='text-center'>" . HLP_get_formated_amount_common($recordObj->noofemployees) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->allocated_budget) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->utilized_budget) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($recordObj->available_budget) . "</td>";
			$str_body .= "<td style='min-width:250px'>" . $recordObj->rating_name_text . "</td>";
			$str_body .= "<td class='text-center'>" . $recordObj->rating_distribution_text . "</td>";
			$str_body .= "<td class='text-center'>" . $recordObj->avg_increase_by_rating . "</td>";
			$str_body .= "</tr>";
		}
		
		$str_body .= '</table>';

		if (count($records)) {
			echo $str_main . $str_body;
		} else {
			echo 'No Record Found';
		}
	}

	//Piy@10Jan
	public function get_increment_distribution_dashboard_bdgt()
	{ 
		$rule_id = $this->input->post("rid");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id" => $rule_id));
		$to_currency_id = $rule_dtls['to_currency_id'];
		$budget_type = $rule_dtls['overall_budget'];

		$records=$this->rule_model->get_increment_distribution_dashboard_bdgt_report($rule_id, $to_currency_id,$budget_type);
		$currency_name = $this->admin_model->get_table_row("manage_currency", "name", array("id" => $to_currency_id))['name'];

		$ratings = $this->rule_model->get_table_object('manage_rating_for_current_year', 'name', ['status' => 1], 'order_no');
		$total=['cnt'=>0,'amount'=>0,'per'=>0];
		foreach ($records['result'] as $key => $row) {
			$records['result'][$key]['per']=$row['amount']/$records['current_salary']*100;
			$records['result'][$key]['current_salary']=$records['current_salary'];
			$total['cnt']+=$row['cnt'];
			$total['amount']+=$row['amount'];
			$total['available_budget']+=$row['available_budget'];
			$total['allocated_budget']+=$row['allocated_budget'];
			$total['utilized_budget']+=$row['utilized_budget'];
			$total['per']+=$records['result'][$key]['per'];
			$rating_names = explode(",",$row['rating_name']);
			$rating_distributions = explode(",", $row['rating_distribution']);
			for ($i = 0; $i < count($rating_names); $i++) {
				$records['result'][$key]['rating'][$rating_names[$i]] += $rating_distributions[$i];
				$records['result'][$key]['ratingcount'][$rating_names[$i]]++;
				$records['result'][$key]['rating_name_totalcount']++;
			}

			foreach ($ratings as $name) {
				$rating_name = $name->name;
				if (isset($records['result'][$key]['rating'][$rating_name])) {
					$records['result'][$key]['rating_name_text'] .= "{$rating_name}</br>";
					
				$per =HLP_get_formated_percentage_common($records['result'][$key]['rating'][$rating_name]/$records['result'][$key]['ratingcount'][$rating_name]);
				$records['result'][$key]['avg_increase_by_rating'].="{$per}%</br>";
								
				$per =HLP_get_formated_percentage_common($records['result'][$key]['ratingcount'][$rating_name]*100/$records['result'][$key]['rating_name_totalcount']);
				$records['result'][$key]['rating_distribution_text'].="{$per}% ({$records['result'][$key]['ratingcount'][$rating_name]})</br>";
	
				}
			}
		}

		$str_head1['sno'] = 'S.No';
		$str_head1['title'] = 'Increment Distribution';
		$str_head1['cnt'] = 'No of Pending Employee';
	//	$str_head1['current_salary'] = "Current salary<br/>({$currency_name})";
		$str_head1['allocated_budget'] = "Allocated Budget";
		$str_head1['utilized_budget'] = "Utilized Budget";
		$str_head1['available_budget'] = "Available Budget";		
		$str_head1['rating_name'] = "Rating Name";
		$str_head1['rating_distribution'] = 'Rating Distribution';
		$str_head1['avg_increase_by_rating'] = "Average Increase by Rating";
	
		
		$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered" style="background:#fff;"><thead><tr>';
		foreach ($str_head1 as $key => $value) {
			$str_main .= "<th style='vertical-align: middle;' class='white'>{$value}</th>";
		}
		$str_main .= '</tr>';
		//head2
		/*
		$str_main .= "<tr>";					
		$str_main .= "<th class='' style='min-width:250px'>Total</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($total['cnt']) . "</th>";
	//	$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($records['current_salary']) . "</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($total['allocated_budget']) . " %</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($total['utilized_budget']) . "</th>";
		$str_main .= "<th class='txtalignright'>" . HLP_get_formated_amount_common($total['available_budget']) . "</th>";		
		$str_main .= "<th class=''></th>";
		$str_main .= "<th class=''></th>";
		$str_main .= "<th class=''></th>";
		$str_main .= "</tr>";*/
		$str_main .= '</thead>';
		//content
		$i=0;
		foreach ($records['result'] as $key => $row) {
			$i++;
			$str_body .= "<tr>";		
			$str_body .= "<td class='text-center'>{$i}</td>";			
			$str_body .= "<td style='min-width:250px' >{$row['name']}</td>";
			$str_body .= "<td class='text-center'>" . HLP_get_formated_amount_common($row['cnt']) . "</td>";
		//	$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['current_salary']) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['allocated_budget']) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['utilized_budget']) . "</td>";
			$str_body .= "<td class='txtalignright'>" . HLP_get_formated_amount_common($row['available_budget']) . "</td>";			
			$str_body .= "<td style='min-width:250px'>" . $row['rating_name_text'] . "</td>";
			$str_body .= "<td class='text-center'>" . $row['rating_distribution_text'] . "</td>";
			$str_body .= "<td class='text-center '>" . $row['avg_increase_by_rating'] . "</td>";	
			$str_body .= "</tr>";
		}
		$str_body .= '</table>';
		echo $str_main.$str_body;
	}
	
	public function view_salary_rule_details($rule_id)
	{
		$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$conditions=' rule_for=1 and bonus_given=1 and status='.CV_STATUS_RULE_RELEASED;
		$data["bonusListForSalaryRuleCreation"] =getSingleTableData('hr_parameter_bonus',$conditions,'id,bonus_rule_name') ;
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}	
	
		$is_enable_approve_btn = 0; // No
		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id,"approvel_requests.status"=>0, "approvel_requests.type"=>2));
		if($request_dtl)
		{
			if(helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
			{
					$is_enable_approve_btn = 1; //Yes
			}
		}
	
		$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id, (SELECT ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR." FROM login_user WHERE id = salary_rule_users_dtls.user_id) AS ". CV_BA_NAME_RATING_FOR_CURRENT_YEAR, array("rule_id"=>$rule_id), "user_id ASC");
		$data["total_emps_cnt"] = count($staff_list);
	
		if($data["rule_dtls"]['performnace_based_hike']=='yes')
		{			
			$temp_arr = array();
			$rating_val_arr = json_decode($data["rule_dtls"]["performnace_based_hike_ratings"],true);			
			//$staff_list = explode(",",$data["rule_dtls"]['user_ids']);	
			foreach($rating_val_arr as $key => $val)
			{
			$temp_arr[$key] = 0;
			$rating_name_arr =explode(CV_CONCATENATE_SYNTAX, $key);
			foreach($staff_list as $emp_id)
			{						
			/*$users_dtls = $this->rule_model->get_table_row("login_user", CV_BA_NAME_RATING_FOR_CURRENT_YEAR, array("id"=>$emp_id["user_id"]), "id desc");
			if($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] == $rating_name_arr[0])*/
			if($emp_id[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] == $rating_name_arr[0])
			{
				$temp_arr[$key]++;
			}					
			}				
			}			
			$data["rating_wise_total_emps"] = $temp_arr;			
		}
		else
		{
			//$data["rating_wise_total_emps"]["all"] = count(explode(",",$data["rule_dtls"]['user_ids']));
			$data["rating_wise_total_emps"]["all"] = count($staff_list);
		}
		
		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary_elements_list)
		{
			$data["market_salary_elements_list"] = $market_salary_elements_list;
		}
		else
		{
			$data["market_salary_elements_list"] = "";
		}
	
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
		$data["market_salary_elements_list"] = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", array("business_attribute.status"=>1, "business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')), "ba_attributes_order ASC");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("id"=>$data['rule_dtls']["to_currency_id"]));
		$data["users_for_approval_req_list"] = array();
		if($data["rule_dtls"]['status']==3)
		{
			$data["users_for_approval_req_list"] = $this->admin_model->get_table("login_user", "id, name", "role = 1 OR role IN (SELECT role_id FROM role_permissions WHERE page_id = ".CV_APPROVE_SALARY." AND ".CV_UPDATE_RIGHT_NAME." = 1)");
		}
		
		/*************** :: Start :: Data for creating Increment Grids after applying Hike Multipliers ******/
		if($data["rule_dtls"]['hike_multiplier_basis_on'])
		{
			if($data["rule_dtls"]['performnace_based_hike']=='yes')
			{			
				//$rating_elements_list=$this->rule_model->get_ratings_list(array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
				//$rating_elements_list=$this->rule_model->get_ratings_list();
				$rating_elements_list = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
				if($rating_elements_list)
				{
					$temp_arr = array();
					//$staff_list = explode(",",$data['rule_dtls']['user_ids']);	
					foreach($rating_elements_list as $row)
					{
						$row["rating_wise_total_emps"] = 0;
						foreach($staff_list as $emp_id)
						{
							/*$users_dtls = $this->rule_model->get_table_row("login_user", "id, ".CV_BA_NAME_RATING_FOR_CURRENT_YEAR."", array("id"=>$emp_id["user_id"]), "id desc");
							
							if(strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) == strtoupper($row["id"]))*/
							if($emp_id[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] == $row["id"])
							{
								$row["rating_wise_total_emps"]++;
							}					
						}
						$temp_arr[] = $row;
					}			
					$data["rating_list"] = $temp_arr;
				}
				else
				{
					$data["rating_list"] = "";
				}
			}
			else
			{
				$data["rating_list"] = "";
			}
			
			$tbl_name = "manage_country";
			$col_name = "country";
			$cnd_str = "status = 1 ";
			$lbl_prefix = "Country - ";
			
			if($data["rule_dtls"]['hike_multiplier_basis_on'] == "2")
			{
				$col_name = "grades";
				$tbl_name = "manage_grade";
				$lbl_prefix = "Grade - ";
			}
			elseif($data["rule_dtls"]['hike_multiplier_basis_on'] == "3")
			{
				$col_name = "levels";
				$tbl_name = "manage_level";
				$lbl_prefix = "Level - ";
			}		
			$cnd_str .= " AND id IN (".$data["rule_dtls"][$col_name].")";
			$data["multiplier_elements_list"] = $this->rule_model->get_table($tbl_name, "id, name", $cnd_str, "name ASC");
			$data["lbl_prefix"] = $lbl_prefix;
		}
		$data["is_show_on_manager"] = 1;
		/*************** :: END :: Data for creating Increment Grids after applying Hike Multipliers ******/
	
		/************* Below code is used only for showing rule filter on view Start ***********/
		$user_id = $this->session->userdata('userid_ses');
		
		$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
		$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
		$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
		$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
		$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
		$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
		$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
		$data["rule_dtls"]["sub_subfunctions"] = explode(",",$data["rule_dtls"]["sub_subfunctions"]);
		$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
		$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
		$data["rule_dtls"]["levels"] = explode(",",$data["rule_dtls"]["levels"]);
		$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
		$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
		$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
		$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
		$data["rule_dtls"]["cost_centers"] = explode(",",$data["rule_dtls"]["cost_centers"]);
		$data["rule_dtls"]["employee_types"] = explode(",",$data["rule_dtls"]["employee_types"]);
		$data["rule_dtls"]["employee_roles"] = explode(",",$data["rule_dtls"]["employee_roles"]);
		$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
		$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
		
		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
		
		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$sub_subfunction_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_subfunctions","sub_subfunction_id", array("status"=>1, "user_id"=>$user_id), "manage_sub_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		
		$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
		$data['cost_center_list'] = $this->rule_model->get_table("manage_cost_center","id, name", "status = 1", "name ASC");
		$data['employee_type_list'] = $this->rule_model->get_table("manage_employee_type","id, name", "status = 1", "name ASC");
		$data['employee_role_list'] = $this->rule_model->get_table("manage_employee_role","id, name", "status = 1", "name ASC");
	
		if($country_arr_view)
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		
		
		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}
		
		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}
		
		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}
		
		if($designation_arr_view)
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}
		
		if($function_arr_view)
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}
		
		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
		}
		if($sub_subfunction_arr_view)
		{
			$data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1 AND id IN(".$sub_subfunction_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1", "name asc");			
		}		
		
		if($grade_arr_view)
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}
		
		if($level_arr_view)
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}
		//piy@19Dec19
		$data["ddl_attributeswise_budget"] = $this->rule_model->get_ba_list_to_categorywise_salary_rpt();
		/************* Below code is used only for showing rule filter on view End ***********/
		
		$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
		$data['title'] = "View Salary Rule Details";
		$data['body'] = "salary/view_salary_rule_details";
		$this->load->view('common/structure',$data);
	}

	public function emp_not_any_cycle($performance_cycle_id, $is_need_to_show=0)
	{
		$user_id = $this->session->userdata('userid_ses');
		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
		
		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$sub_subfunction_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_subfunctions","sub_subfunction_id", array("status"=>1, "user_id"=>$user_id), "manage_sub_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		
		$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED);
		//$already_created_rule_for_emp_arr = $this->rule_model->get_table("hr_parameter","user_ids", $condit_arr);
		$already_created_rule_for_emp_arr = $this->rule_model->get_all_emp_ids_for_a_cycle($condit_arr);
		
		$already_created_rule_for_emp_ids = array();
		foreach($already_created_rule_for_emp_arr as $row)
		{
			$already_created_rule_for_emp_ids[] = $row["user_id"];
		}
		
		$where ="login_user.role > 1 AND login_user.status = 1";
		if($country_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_COUNTRY." IN (".$country_arr_view.")";
		}
		
		if($city_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_CITY." IN (".$city_arr_view.")";
		}
		
		if($bl1_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." IN (".$bl1_arr_view.")";
		}
		
		if($bl2_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." IN (".$bl2_arr_view.")";
		}
		
		if($bl3_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." IN (".$bl3_arr_view.")";
		}
		
		if($function_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_FUNCTION." IN (".$function_arr_view.")";
		}
		
		if($sub_function_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_SUBFUNCTION." IN (".$sub_function_arr_view.")";
		}
		
		if($sub_subfunction_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_SUB_SUBFUNCTION." IN (".$sub_subfunction_arr_view.")";
		}
		
		if($designation_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_DESIGNATION." IN (".$designation_arr_view.")";
		}
		
		if($grade_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_GRADE." IN (".$grade_arr_view.")";
		}
		
		if($level_arr_view)
		{
			$where .= " AND login_user.".CV_BA_NAME_LEVEL." IN (".$level_arr_view.")";
		}
		
		if($already_created_rule_for_emp_ids)
		{
			$where .= " AND login_user.id NOT IN (".implode(",",$already_created_rule_for_emp_ids).")";
		}
		
		$user_ids_arr = array();
		$employees = $this->admin_model->get_employees_as_per_rights($where);
		
		if($employees)
		{
			foreach($employees as $row)
			{
				$user_ids_arr[] = $row["id"];
			}
			$user_ids_arr = "login_user.id IN (".implode(",",$user_ids_arr).")";
		}
		
		if($is_need_to_show)
		{
			$data['staff_list'] = $this->admin_model->get_staff_list($user_ids_arr);	
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
			$data['title'] = "Staffs";
			$data['body'] = "not_any_cycle_staff_list";
			$this->load->view('common/structure',$data);
		}
		else
		{
			return count($employees);
		}
	}

	public function delete_salary_rule($rule_id)
	{
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if($data['rule_dtls']  and ($data['rule_dtls']["status"] < CV_STATUS_RULE_DELETED))
		{
			if(!helper_have_rights(CV_SALARY_RULES_ID, CV_DELETE_RIGHT_NAME))
			{
				redirect(site_url("salary-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
			}
		
			$db_arr = array("status"=>CV_STATUS_RULE_DELETED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
			$this->rule_model->update_rules(array('id'=>$rule_id), $db_arr);
			$this->rule_model->delete_emp_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id));
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_delete_salary').'</b></div>');
			redirect(site_url("salary-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}

	public function get_emp_perc_crr_range_wise()
	{
		$rule_id = $this->input->post("rule_id");
		$mkt_sal_elem_arr = explode(CV_CONCATENATE_SYNTAX, $this->input->post("mkt_sal_val"));
		$mkt_sal_elem_id = $mkt_sal_elem_arr[0];
		$increment_percet = $this->input->post("increment_percet");;
		$rating_val = $this->input->post("rating_val");;
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["salary_applied_on_elements"].")");
		$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$mkt_sal_elem_id));
		
		$cureent_crr_per_arr = array();
		$updated_crr_per_arr = array();
		$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
		for($r=0; $r<= count($crr_arr); $r++)
		{			
			$cureent_crr_per_arr[] = 0;
			$updated_crr_per_arr[] = 0;
		}
		
		$total_pre_crr = $total_post_crr = 0;	
		//$staff_list = $this->rule_model->get_table("salary_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");
		$staff_list = $this->rule_model->get_table("login_user", "*", "id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.")", "id ASC");
		
		if($rule_dtls["hike_multiplier_basis_on"])
		{
			$hike_multiplier_basis_on = CV_BA_NAME_COUNTRY;
			if($rule_dtls["hike_multiplier_basis_on"]=="2")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_GRADE;
			}
			elseif($rule_dtls["hike_multiplier_basis_on"]=="3")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_LEVEL;
			}
			//$hike_multiplier_arr = json_decode($rule_dtls["hike_multiplier_dtls"], true);
			$multiplier_wise_per_dtls = json_decode($rule_dtls["multiplier_wise_per_dtls"], true);
		}	
		
		foreach($staff_list as $row)
		{
			$performnace_based_increment_percet = $increment_percet;
			$employee_id = $row["id"];//$row["user_id"];
			$increment_applied_on_amt = 0;
			$emp_market_salary = 0;
			$total_per_to_increase_salary=0;
			
			$users_dtls = $row;//$this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
			//$hike_multiplier_val = 1;//0;
			/*if(isset($hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]))
			{
				$hike_multiplier_val = $hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]/100;
			}*/
			
			//**************** Note :: Proreta Calculation Start ****************/
			/*$proreta_multiplier = 1;//Default
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			if($rule_dtls["prorated_increase"] == "yes")
			{
				//if(strtotime($joining_dt) <= strtotime($rule_dtls["start_dt"]))
				//{
				//	$proreta_multiplier = 1;
				//}
				//else
				if(strtotime($joining_dt) <= strtotime($rule_dtls["end_dt"]))
				{
					$numerator = round((strtotime($rule_dtls["end_dt"]) - strtotime($joining_dt)) / (60 * 60 * 24));
					$denominator = round((strtotime($rule_dtls["end_dt"]) - strtotime($rule_dtls["start_dt"])) / (60 * 60 * 24));
					$proreta_multiplier = HLP_get_formated_percentage_common(($numerator/$denominator));
				}
				else
				{
					$proreta_multiplier = 0;
				}					
			}
			elseif($rule_dtls["prorated_increase"] == "fixed-percentage")
			{
				$range_of_doj_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"],true);
				foreach($range_of_doj_arr as $key=> $doj_range) 
				{
					if(strtotime(date('Y-m-d', strtotime($doj_range["From"]))) <= strtotime($joining_dt) and strtotime($joining_dt) >= strtotime(date('Y-m-d', strtotime($doj_range["To"]))))
					{
						$proreta_multiplier = $doj_range["Percentage"]/100;
						break;
					}					
				}				
			}*/
			$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
			$proreta_multiplier = HLP_get_pro_rated_multiplier_for_salary($rule_dtls, $joining_dt);
			
			//$total_per_to_increase_salary = $total_per_to_increase_salary*$proreta_multiplier;
			//**************** Note :: Proreta Calculation End ****************/
			
			if($increment_applied_on_arr)
			{
				foreach($increment_applied_on_arr as $salary_elem)
				{					
					if($users_dtls[$salary_elem["ba_name"]])
					{
						$increment_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
					}
				}
			}
			
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				//if(empty($emp_salary_rating) or strtoupper($emp_salary_rating[0]["value"]) != strtoupper($rating_val))
				if(empty($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) or strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) != strtoupper($rating_val))
				{
					continue;
				}
			}
			
			$performnace_based_increment_percet = ($performnace_based_increment_percet*$proreta_multiplier);
			
			//$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);
			$performnace_based_salary = $increment_applied_on_amt;
			
			$crr_per = 0;
			if($rule_dtls['salary_position_based_on'] != "2")//Salary Positioning Not Based On Quartile
			{
				$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
				if($emp_market_salary > 0)
				{
					$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
					if($rule_dtls["comparative_ratio"] == "yes")
					{
						$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
					}				
				}
				else
				{
					$emp_market_salary = 0;	
				}
			}
			
			$i=0;
			$min_mkt_salary = $min_mkt_salary_to_bring_emp_to_min_salary = 0;
			foreach($crr_arr as $key =>$row1)
			{	
				if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{	
					$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
					if($i==0)
					{ 
						if($increment_applied_on_amt < $users_dtls[$quartile_range_arr[1]])
						{
							$min_mkt_salary_to_bring_emp_to_min_salary = $users_dtls[$quartile_range_arr[1]];
							break;
						}
					}
					else
					{
						if($min_mkt_salary <= $increment_applied_on_amt and $increment_applied_on_amt < $users_dtls[$quartile_range_arr[1]])
						{
							break;
						}
					}
				
					if(($i+1)==count($crr_arr))
					{
						if($increment_applied_on_amt >= $users_dtls[$quartile_range_arr[1]])
						{
							$i++;
							break;
						}
					}
					$min_mkt_salary = $users_dtls[$quartile_range_arr[1]];
				}
				else
				{	
					if($i==0)
					{ 
						if($crr_per < $row1["max"])
						{
							break;
						}
					}
					else
					{
						if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
						{
							break;
						}
					}
				
					if(($i+1)==count($crr_arr))
					{
						if($crr_per >= $row1["max"])
						{
							$i++;
							break;
						}
					}
				}
				$i++; 
			}
			$cureent_crr_per_arr[$i] += 1;
			$total_pre_crr += $crr_per;
		
			// ************* Below code used to get emp perc crr wise after increment Start **************/
			if($rule_dtls["hike_multiplier_basis_on"])
			{
				$comparative_ratio_dtls=$multiplier_wise_per_dtls["mkt_elem"][$users_dtls[$hike_multiplier_basis_on]];
			}
			else
			{
				$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
			}
			
			
			if($rule_dtls["status"] >= 2 and ($comparative_ratio_dtls))//($rule_dtls["comparative_ratio_calculations"]))
			{
				/*$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
				$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);*/
				if($rule_dtls["hike_multiplier_basis_on"])
				{
					$crr_tbl_arr_temp = $multiplier_wise_per_dtls["crr"][$users_dtls[$hike_multiplier_basis_on]];
				}
				else
				{
					$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
				}
				$crr_tbl_arr = $crr_tbl_arr_temp[$i];				
				$crr_based_increment_percet = 0;
				$j=0;
			
				if($rule_dtls["performnace_based_hike"] == "yes")
				{
					foreach ($comparative_ratio_dtls as $key => $value) 
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[0]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
						{
							$crr_based_increment_percet =  $crr_tbl_arr[$j];						
						}
						$j++;
					}
				}
				else
				{
					$crr_based_increment_percet =  $crr_tbl_arr[$j];
				}
				
				if($rule_dtls['bring_emp_to_min_sal'] == 1 and $rule_dtls['salary_position_based_on'] == "2" and $i == 0 and $min_mkt_salary_to_bring_emp_to_min_salary > 0)//Salary Positioning Based On Quartile Case
				{
					$crr_based_increment_percet = HLP_get_mkt_hike_to_bring_emp_to_min_salary($increment_applied_on_amt, $min_mkt_salary_to_bring_emp_to_min_salary, $performnace_based_increment_percet, $crr_based_increment_percet);
				}
				else
				{
					$crr_based_increment_percet = ($crr_based_increment_percet*$proreta_multiplier);
				}
				$total_per_to_increase_salary = $performnace_based_increment_percet + $crr_based_increment_percet;
				
				$final_salary = $increment_applied_on_amt + (($increment_applied_on_amt*($total_per_to_increase_salary))/100);
				$updated_crr_per = 0;
				if($rule_dtls['salary_position_based_on'] != "2")//Salary Positioning Not Based On Quartile
				{
					if($emp_market_salary > 0)
					{
						$updated_crr_per = ($final_salary/$emp_market_salary)*100;
					}
				}
				
				$i=0;
				foreach($crr_arr as $key => $row1)
				{	
					if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
					{	
						$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
						if($i==0)
						{ 
							if($final_salary < $users_dtls[$quartile_range_arr[1]])
							{
								break;
							}
						}
						else
						{
							if($min_mkt_salary <= $final_salary and $final_salary < $users_dtls[$quartile_range_arr[1]])
							{
								break;
							}
						}
						
						if(($i+1)==count($crr_arr))
						{
							if($final_salary >= $users_dtls[$quartile_range_arr[1]])
							{
								$i++;
								break;
							}
						}
						$min_mkt_salary = $users_dtls[$quartile_range_arr[1]];
					}
					else
					{		
						if($i==0)
						{ 
							if($updated_crr_per < $row1["max"])
							{
								break;
							}
						}
						else
						{
							if($row1["min"] <= $updated_crr_per and $updated_crr_per < $row1["max"])
							{
								break;
							}
						}
						
						if(($i+1)==count($crr_arr))
						{
							if($updated_crr_per >= $row1["max"])
							{
								$i++;
								break;
							}
						}
					}
					$i++; 
				}
				$updated_crr_per_arr[$i] += 1;
				$total_post_crr += $updated_crr_per;
			}
			// ************* Below code used to get emp perc crr wise after increment End **************/
		}	
		
		for($k=0; $k< count($cureent_crr_per_arr); $k++)
		{			
			$cureent_crr_per_arr[$k] = HLP_get_formated_percentage_common(($cureent_crr_per_arr[$k]/count($staff_list))*100)."%";
			$updated_crr_per_arr[$k] = HLP_get_formated_percentage_common(($updated_crr_per_arr[$k]/count($staff_list))*100)."%";
		}	
		echo json_encode(array($cureent_crr_per_arr, $updated_crr_per_arr, $total_pre_crr, $total_post_crr));
	}

	public function get_encoded_url($pc_id, $rule_ids)
	{
		echo site_url("salary-rule-comparisons/".base64_encode($pc_id)."/".base64_encode(str_replace("-",",",$rule_ids)));
	}

	public function salary_rule_comparisons($encoded_pc_id, $encoded_rule_ids)
	{
		$pc_id = base64_decode($encoded_pc_id);
		$rule_ids = base64_decode($encoded_rule_ids);
		$rule_list = $this->rule_model->get_salary_rules_for_comparison("hr_parameter.performance_cycle_id = ".$pc_id." AND hr_parameter.id IN (".$rule_ids.")");
		
		$tempArr = array();
		$i = 0;
		foreach($rule_list as $row)
		{	   
			/*$row["country_names"] = HLP_get_filter_names("manage_country", "name" , "id IN (".$row["country"].")");
			$row["city_names"] = HLP_get_filter_names("manage_city", "name" , "id IN (".$row["city"].")");
			$row["bl1_names"] = HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$row["business_level1"].")");
			$row["bl2_names"] = HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$row["business_level2"].")");
			$row["bl3_names"] = HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$row["business_level3"].")");
			$row["function_names"] = HLP_get_filter_names("manage_function", "name" , "id IN (".$row["functions"].")");
			$row["sub_function_names"] = HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$row["sub_functions"].")");
			$row["designation_names"] = HLP_get_filter_names("manage_designation", "name" , "id IN (".$row["designations"].")");
			$row["grade_names"] = HLP_get_filter_names("manage_grade", "name" , "id IN (".$row["grades"].")");
			$row["level_names"] = HLP_get_filter_names("manage_level", "name" , "id IN (".$row["levels"].")");
			$row["education_names"] = HLP_get_filter_names("manage_education", "name" , "id IN (".$row["educations"].")");
			$row["critical_talent_names"] = HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$row["critical_talents"].")");
			$row["critical_position_names"] = HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$row["critical_positions"].")");
			$row["special_category_names"] = HLP_get_filter_names("manage_special_category", "name" , "id IN (".$row["special_category"].")");
			
			$row["salary_element_names"] = HLP_get_filter_names("business_attribute", "display_name" , "id IN (".$row["salary_applied_on_elements"].")");*/
			
			$tempArr[] = $row;			
			$i++;
		}
		$data['rule_list'] = $tempArr;
		//echo "<pre>";print_r($data);die;
		
		
		$data['rule_list_pg_url'] = site_url("salary-rule-list/".$pc_id);
		$data['title'] = "Salary Rule Comparisons";
		$data['body'] = "salary/view_salary_rule_comparison";
		$this->load->view('common/structure',$data);
	}

	public function print_data($rule_id)
	{
	$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
	if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
	{
	redirect(site_url("performance-cycle"));
	}	
	
	$is_enable_approve_btn = 0; // No
	//$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>2));
	$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id,"approvel_requests.status"=>0, "approvel_requests.type"=>2));
	if($request_dtl)
	{
	/*if(!helper_have_rights(CV_SALARY_RULES_ID, CV_UPDATE_RIGHT_NAME))
	{
	$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You do not have update rights.</b></span></div>');
	redirect(site_url("performance-cycle"));
	}*/
	if(helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
	{
	$is_enable_approve_btn = 1; //Yes
	}
	}
	
	
	if($data["rule_dtls"]['performnace_based_hike']=='yes')
	{
	/*$rating_elements_list = $this->rule_model->get_salary_elements_list("id",array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
	if($rating_elements_list)
	{
	$data["rating_list"] = $this->rule_model->get_ratings_list($rating_elements_list);
	}
	else
	{
	$data["rating_list"] = "";
	}*/
	//$rating_elements_list = $this->rule_model->get_ratings_list(array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
	$rating_elements_list = $this->rule_model->get_ratings_list_as_per_rules_emp(array("salary_rule_users_dtls.rule_id"=>$rule_id));
	if($rating_elements_list)
	{
	$data["rating_list"] = $rating_elements_list;
	}
	else
	{
	$data["rating_list"] = "";
	}
	}
	else
	{
	$data["rating_list"] = "";
	}
	
	/*$market_salary_elements_list = $this->rule_model->get_salary_elements_list("id", array("status"=>1, "module_name"=>CV_MARKET_SALARY_ELEMENT));
	if($market_salary_elements_list)
	{
	$data["market_salary_elements_list"] = $this->rule_model->get_market_salary_header_list($market_salary_elements_list);
	}
	else
	{
	$data["market_salary_elements_list"] = "";
	}*/
	//CB:Ravi on 22-02-2018
	//$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>CV_MARKET_SALARY_ELEMENT));
	$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
	if($market_salary_elements_list)
	{
	$data["market_salary_elements_list"] = $market_salary_elements_list;
	}
	else
	{
	$data["market_salary_elements_list"] = "";
	}
	
	//$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT));
	$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
	
	
	/************* Below code is used only for showing rule filter on view Start ***********/
	$user_id = $this->session->userdata('userid_ses');
	//$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$data['rule_dtls']["performance_cycle_id"]));
	
	$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
	$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
	$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
	$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
	$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
	$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
	$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
	$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
	$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
	$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
	$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
	$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
	$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
	$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
	$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
	
	
	$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
	$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
	$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
	$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
	$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
	
	$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
	$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
	$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
	$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
	
	$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
	$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
	$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
	$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
	$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
	$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
	if($country_arr_view)
	{
	$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
	}
	else
	{
	$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
	}		
	
	if($city_arr_view)
	{
	$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
	}
	else
	{
	$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
	}		
	
	if($bl1_arr_view)
	{
	$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
	}
	else
	{
	$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
	}
	
	if($bl2_arr_view)
	{
	$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
	}
	else
	{
	$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
	}
	
	if($bl3_arr_view)
	{
	$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
	}
	else
	{
	$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
	}
	
	if($designation_arr_view)
	{
	$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
	}
	else
	{
	$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
	}
	
	if($function_arr_view)
	{
	$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
	}
	else
	{
	$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
	}
	
	if($sub_function_arr_view)
	{
	$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
	}
	else
	{
	$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
	}		
	
	if($grade_arr_view)
	{
	$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
	}
	else
	{
	$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
	}
	/************* Below code is used only for showing rule filter on view End ***********/
	if($level_arr_view)
	{
	$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
	}
	else
	{
	$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
	}
	$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
	$data['title'] = "View Salary Rule Details";
	$data['body'] = "print";
	$this->load->view('print',$data);
	}

	public function get_managerList($value='')
	{
		$data["rule_dtls"]=$this->rule_model->get_table_row('hr_parameter', 'id, managers_bdgt_dtls_for_tbl', ['id'=>$_GET['rule_id']]) ;
		$this->load->view('salary_rule_relrease_frm',$data);
	}
}
