<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Printview extends CI_Controller 
{	 
	public function __construct()
	{		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		//$this->load->library('parser');
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
		$this->load->model("manager_model");
		$this->load->model("rule_model");
		$this->load->model("front_model");
		$this->load->model("admin_model");
		$this->load->model("bonus_model");
		$this->load->model("lti_rule_model");
		$this->load->model("common_model");
		$this->load->model("approvel_model");

		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '')
		{			
			redirect(site_url("dashboard"));			
		}
		HLP_is_valid_web_token();              
		// if($this->session->userdata('is_manager_ses')==0))
    }

    /* Start - Salary Part */
    public function printpreview_salary ($rule_id, $is_open_frm_sal_review_pg=0)
    {
    	if($this->session->userdata('is_manager_ses')==0)
		{
	    	$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
			{
				redirect(site_url("performance-cycle"));
			}
		} else {
			$cdt = date("Y-m-d");
			$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
			{
				redirect(site_url("dashboard"));
			}
		}

		if($data["rule_dtls"]['performnace_based_hike']=='yes')
		{
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

		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
		if($market_salary_elements_list)
		{
			$data["market_salary_elements_list"] = $market_salary_elements_list;
		}
		else
		{
			$data["market_salary_elements_list"] = "";
		}
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("id"=>$data['rule_dtls']["to_currency_id"]));
		
		/****** Start-/ Below code is used only for showing rule filter on view ******/
		// echo "<pre>";
		// print_r($data["rule_dtls"]);
		// die;
		$user_id = $this->session->userdata('userid_ses');
		$arr = explode('~', $data["rule_dtls"]["default_market_benchmark"]);
		$attribute = $this->db->where(['module_name'=>$this->session->userdata('market_data_by_ses'),'status'=>'1','ba_name'=>end($arr)])->get('business_attribute')->row();
		if(!empty($attribute)){
			$data["rule_dtls"]["default_market_benchmark"] = $attribute->ba_name_cw;
		}
		
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		$data["rule_dtls"]["country_names"] = HLP_get_filter_names("manage_country", "name" , "id IN (".$data["rule_dtls"]["country"].")");
		$data["rule_dtls"]["city_names"] = HLP_get_filter_names("manage_city", "name" , "id IN (".$data["rule_dtls"]["city"].")");
		$data["rule_dtls"]["bl1_names"] = HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$data["rule_dtls"]["business_level1"].")");
		$data["rule_dtls"]["bl2_names"] = HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$data["rule_dtls"]["business_level2"].")");
		$data["rule_dtls"]["bl3_names"] = HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$data["rule_dtls"]["business_level3"].")");
		$data["rule_dtls"]["function_names"] = HLP_get_filter_names("manage_function", "name" , "id IN (".$data["rule_dtls"]["functions"].")");
		$data["rule_dtls"]["sub_function_names"] = HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$data["rule_dtls"]["sub_functions"].")");
		$data["rule_dtls"]["designation_names"] = HLP_get_filter_names("manage_designation", "name" , "id IN (".$data["rule_dtls"]["designations"].")");
		$data["rule_dtls"]["grade_names"] = HLP_get_filter_names("manage_grade", "name" , "id IN (".$data["rule_dtls"]["grades"].")");
		$data["rule_dtls"]["level_names"] = HLP_get_filter_names("manage_level", "name" , "id IN (".$data["rule_dtls"]["levels"].")");
		$data["rule_dtls"]["education_names"] = HLP_get_filter_names("manage_education", "name" , "id IN (".$data["rule_dtls"]["educations"].")");
		$data["rule_dtls"]["critical_talent_names"] = HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$data["rule_dtls"]["critical_talents"].")");
		$data["rule_dtls"]["critical_position_names"] = HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$data["rule_dtls"]["critical_positions"].")");
		$data["rule_dtls"]["special_category_names"] = HLP_get_filter_names("manage_special_category", "name" , "id IN (".$data["rule_dtls"]["special_category"].")");
		
		/************* End-/ code is used only for showing rule filter on view ***********/
			
		if($this->session->userdata('is_manager_ses')==0)
		{
		} else {
			$data["is_open_frm_sal_review_pg"] = $is_open_frm_sal_review_pg;
		}
		$data['title'] = "View Salary Rule Details";
		$data['val'] = $_GET;
		//echo "<pre>";print_r($data['val']);die();
		$this->load->view('manager/print',$data);
    }
    /* End - Salary Part */
	
	/* Start - Bonus Part */
	public function printpreview_bonus ($rule_id)
	{
		if($this->session->userdata('is_manager_ses')==0)
		{
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
			{
				redirect(site_url("performance-cycle"));
			}
		} else {
			$cdt = date("Y-m-d");
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
			{
				redirect(site_url("dashboard"));
			}
		}

		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("id"=>$data['rule_dtls']["to_currency_id"]));

		$user_id = $this->session->userdata('userid_ses');
		$data["rule_dtls"]["bonus_applied_on_elem_list"] = HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$data["rule_dtls"]['bonus_applied_on_elements'].")");
		$data["rule_dtls"]["country_names"] = HLP_get_filter_names("manage_country", "name" , "id IN (".$data["rule_dtls"]["country"].")");
		$data["rule_dtls"]["city_names"] = HLP_get_filter_names("manage_city", "name" , "id IN (".$data["rule_dtls"]["city"].")");
		$data["rule_dtls"]["bl1_names"] = HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$data["rule_dtls"]["business_level1"].")");
		$data["rule_dtls"]["bl2_names"] = HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$data["rule_dtls"]["business_level2"].")");
		$data["rule_dtls"]["bl3_names"] = HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$data["rule_dtls"]["business_level3"].")");
		$data["rule_dtls"]["function_names"] = HLP_get_filter_names("manage_function", "name" , "id IN (".$data["rule_dtls"]["functions"].")");
		$data["rule_dtls"]["sub_function_names"] = HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$data["rule_dtls"]["sub_functions"].")");
		$data["rule_dtls"]["sub_subfunction_names"] = HLP_get_filter_names("manage_sub_subfunction", "name" , "id IN (".$data["rule_dtls"]["sub_subfunctions"].")");
		$data["rule_dtls"]["designation_names"] = HLP_get_filter_names("manage_designation", "name" , "id IN (".$data["rule_dtls"]["designations"].")");
		$data["rule_dtls"]["grade_names"] = HLP_get_filter_names("manage_grade", "name" , "id IN (".$data["rule_dtls"]["grades"].")");
		$data["rule_dtls"]["level_names"] = HLP_get_filter_names("manage_level", "name" , "id IN (".$data["rule_dtls"]["levels"].")");
		$data["rule_dtls"]["education_names"] = HLP_get_filter_names("manage_education", "name" , "id IN (".$data["rule_dtls"]["educations"].")");
		$data["rule_dtls"]["critical_talent_names"] = HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$data["rule_dtls"]["critical_talents"].")");
		$data["rule_dtls"]["critical_position_names"] = HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$data["rule_dtls"]["critical_positions"].")");
		$data["rule_dtls"]["special_category_names"] = HLP_get_filter_names("manage_special_category", "name" , "id IN (".$data["rule_dtls"]["special_category"].")");

		$data["functions"] = $this->rule_model->get_table("manage_function", "*", array("status"=>1), "name asc");
		$data['title'] = "View Bonus Rule Details";
		// echo "<pre>";print_r($data);die();
		$this->load->view('manager/print_bonus',$data);
	}

	public function get_managers_for_manual_bdgt_bonus()
	{
		$budget_type = $this->input->get("budget_type");
		$to_currency_id = $this->input->get("to_currency");
		$rule_id = $this->input->get("rid");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("bonus_rule_users_dtls", $rule_id);
	
			if($managers)
			{
				$str = '<table class="table table-bordered">';
                $str .= '<thead><tr>';

                $str .= '<th>Manager Name</th><th>Calculated Budget</th>'; 

                if($budget_type == "Manual") 
                {
	                $str .= '<th>Final Budget</th>';  
	            }
	            if($budget_type == "Automated but x% can exceed") 
                {
	                $str .= '<th>Percentage</th>';  
	            }
                $str .= '</tr></thead><tbody>';  

				foreach ($managers as $row)
				{
					if((strcasecmp($this->session->userdata('email_ses'),$row['first_approver']))==0)
                    {
						$manager_budget = $this->calculate_budgt_manager_wise_bonus($rule_id, $data["rule_dtls"], $row['first_approver'], $to_currency_id);
						$str .= '<tr><td>';
						if($row['manager_name'])
						{
					    	$str .= $row['manager_name'];
						}
						else
						{
							$str .= $row['first_approver'];
						}              
	              	
	              		$str .= '</td><td>'.$to_currency_dtls["name"].' '.HLP_get_formated_amount_common($manager_budget).'</td>';

		              	if($budget_type == "Manual") 
	                	{		
							$str .= '<td>'.$to_currency_dtls["name"].' '.$manager_budget.'</td>';
				        }
			       
				        if($budget_type == "Automated but x% can exceed") 
		                {
			                $str .= '<td><input type="text" class="form-control" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value=""></td>';
			            }
			        	$str .= '</tr>';
					}
				}
				$str .= '</tbody></table>'; 
				echo $str;
			} else {
				echo "";
			}
		}
	}

	/* This methods is same as Bonus/calculate_budgt_manager_wise use */
	public function calculate_budgt_manager_wise_bonus($rule_id, $rule_dtls, $manager_email, $to_currency_id)
	{			
		$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
		$total_max_budget = 0;
		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;				
			$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
			$currency = array("currency_type"=>$currency_arr["name"]);
			$from_currency_id = $currency_arr["id"];
			
			$emp_bonus_dtls = $this->calculate_bonus_emploee_wise($employee_id, $rule_dtls);
			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_bonus_dtls["cuurent_emp_bonus_amt"]);
			
		}
		return round($total_max_budget,2);
	}

	/* This methods is same as Bonus/calculate_bonus_emploee_wise use for managers */
	public function calculate_bonus_emploee_wise($employee_id, $rule_dtls)
	{
		$bonus_applied_on_amt = $total_weightage_score = 0;
		$bl_1_name = $bl_2_name = $bl_3_name = $bl_funct_name = $bl_sub_funct_name = $bl_sub_subfunct_name = $bl_individual_name = "";
		$bl_1_weightage = $bl_2_weightage = $bl_3_weightage = $bl_funct_weightage = $bl_sub_funct_weightage = $bl_sub_subfunct_weightage = $bl_individual_weightage = 0;
		$bl_1_achievement = $bl_2_achievement = $bl_3_achievement = $bl_funct_achievement = $bl_sub_funct_achievement = $bl_sub_subfunct_achievement = $bl_individual_achievement = 0;
		
		$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
		$bonus_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["bonus_applied_on_elements"].")");
		
		if($bonus_applied_on_arr)
		{
			foreach($bonus_applied_on_arr as $salary_elem)
			{
				if($users_dtls[$salary_elem["ba_name"]])
				{
					$bonus_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
				}
			}
		}
		
		if($rule_dtls["target_bonus"] == "yes")
		{
			$target_bonus_on_column = CV_BA_NAME_DESIGNATION;
			if($rule_dtls["target_bonus_on"] == "grade")
			{
				$target_bonus_on_column = CV_BA_NAME_GRADE;
			}
			elseif($rule_dtls["target_bonus_on"] == "level")
			{
				$target_bonus_on_column = CV_BA_NAME_LEVEL;
			}
			
			$target_bonus_dtl_arr = json_decode($rule_dtls["target_bonus_dtls"],true);
			$indx = 0;
			foreach($target_bonus_dtl_arr as $key => $elemnt)
			{
				$elemnt_arr = explode(CV_CONCATENATE_SYNTAX, $key);
				if($elemnt_arr[0] == $users_dtls[$target_bonus_on_column])
				{	
					if($rule_dtls["target_bonus_elem_value_type"] == 2)
					{
						$bonus_applied_on_amt = $bonus_applied_on_amt + $elemnt;
					}	
					else
					{
						$bonus_applied_on_amt = $bonus_applied_on_amt + ($bonus_applied_on_amt*$elemnt)/100;		
					}
					$bl_1_weightage = explode(",", $rule_dtls["bl_1_weightage"])[$indx];
					$bl_2_weightage = explode(",", $rule_dtls["bl_2_weightage"])[$indx];
					$bl_3_weightage = explode(",", $rule_dtls["bl_3_weightage"])[$indx];
					$bl_funct_weightage = explode(",", $rule_dtls["function_weightage"])[$indx];
					$bl_sub_funct_weightage = explode(",", $rule_dtls["sub_function_weightage"])[$indx];
					$bl_sub_subfunct_weightage = explode(",", $rule_dtls["sub_subfunction_weightage"])[$indx];
					$bl_individual_weightage = explode(",", $rule_dtls["individual_weightage"])[$indx];
					break;
				}
				$indx++;
			}
		}
		else
		{
			$bl_1_weightage = $rule_dtls["bl_1_weightage"];
			$bl_2_weightage = $rule_dtls["bl_2_weightage"];
			$bl_3_weightage = $rule_dtls["bl_3_weightage"];
			$bl_funct_weightage = $rule_dtls["function_weightage"];
			$bl_sub_funct_weightage = $rule_dtls["sub_function_weightage"];
			$bl_sub_subfunct_weightage = $rule_dtls["sub_subfunction_weightage"];
			$bl_individual_weightage = $rule_dtls["individual_weightage"];
		}
		
		$business_level_achievements_arr = json_decode($rule_dtls["business_level_achievement"],true);

		foreach($business_level_achievements_arr as $k => $v) 
		{
			$k_arr = explode(CV_CONCATENATE_SYNTAX, $k);
			if($k_arr[0] == CV_BUSINESS_LEVEL_ID_1 && $k_arr[1] == $users_dtls[CV_BA_NAME_BUSINESS_LEVEL_1])
			{
				$bl_1_name = $k_arr[2];
				$bl_1_achievement = $v;
			}
			elseif($k_arr[0] == CV_BUSINESS_LEVEL_ID_2 && $k_arr[1] == $users_dtls[CV_BA_NAME_BUSINESS_LEVEL_2])
			{
				$bl_2_name = $k_arr[2];
				$bl_2_achievement = $v;
			}
			elseif($k_arr[0] == CV_BUSINESS_LEVEL_ID_3 && $k_arr[1] == $users_dtls[CV_BA_NAME_BUSINESS_LEVEL_3])
			{
				$bl_3_name = $k_arr[2];
				$bl_3_achievement = $v;
			}
			elseif($k_arr[0] == CV_FUNCTION_ID && $k_arr[1] == $users_dtls[CV_BA_NAME_FUNCTION])
			{
				$bl_funct_name = $k_arr[2];
				$bl_funct_achievement = $v;
			}
			elseif($k_arr[0] == CV_SUB_FUNCTION_ID && $k_arr[1] == $users_dtls[CV_BA_NAME_SUBFUNCTION])
			{
				$bl_sub_funct_name = $k_arr[2];
				$bl_sub_funct_achievement = $v;
			}
			elseif($k_arr[0] == CV_SUB_SUB_FUNCTION_ID && $k_arr[1] == $users_dtls[CV_BA_NAME_SUB_SUBFUNCTION])
			{
				$bl_sub_subfunct_name = $k_arr[2];
				$bl_sub_subfunct_achievement = $v;
			}			
		}
		
		if($rule_dtls["performance_type"]==2)//Menas :: Performance Achievements %age Wise case
		{			
			$i=0;
			$perf_achiev_multiplier = 0;
			$achievement_rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"], true);
			$perf_achiev_multipliers_arr = json_decode($rule_dtls["performance_achievements_multipliers"], true);
			foreach($achievement_rangs_arr as $rang) 
			{
				if($i==0)
				{ 
					if($users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT] <= $rang["max"])
					{						
						break;
					}
				}
				elseif(($i+1)==count($crr_arr))
				{
					if($users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT] > $rang["max"])
					{
						break;
					}
				}
				else
				{
					if($rang["min"] < $users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT] and $users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT] <= $rang["max"])
					{
						break;
					}
				}
				$i++;
			}
			$perf_achiev_multiplier = $perf_achiev_multipliers_arr[$i];
			
			if($rule_dtls["performance_achievements_multiplier_type"]==2)
			{
				$bl_individual_achievement = (abs($users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT] - 100)*$perf_achiev_multiplier)+100;
			}
			else
			{
				$bl_individual_achievement = ($bl_individual_weightage*$perf_achiev_multiplier)/100;
			}			
		}
		else//Menas :: Performance Rating Wise case
		{			
			$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if($key_arr[1] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$bl_individual_achievement = $value;
						$bl_individual_name = $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR];
					}
				}			
			}
			else
			{
				$bl_individual_achievement = $rating_dtls["all"];
				$bl_individual_name = "All";
			}
		}

		$total_weightage_score = ($bl_1_weightage*$bl_1_achievement)/100 + ($bl_2_weightage*$bl_2_achievement)/100 + ($bl_3_weightage*$bl_3_achievement)/100 + ($bl_funct_weightage*$bl_funct_achievement)/100 + ($bl_sub_funct_weightage*$bl_sub_funct_achievement)/100 + ($bl_sub_subfunct_weightage*$bl_sub_subfunct_achievement)/100 + ($bl_individual_weightage*$bl_individual_achievement)/100;
	
		$final_bonus_per = $total_weightage_score;
		$cuurent_emp_bonus = ($bonus_applied_on_amt*$final_bonus_per)/100;
		$data = array("user_dtls"=>$users_dtls, "bonus_applied_on_amt"=>$bonus_applied_on_amt, "final_bonus_per"=>$final_bonus_per, "cuurent_emp_bonus_amt"=>$cuurent_emp_bonus, "bl_1_name"=>$bl_1_name, "bl_2_name"=>$bl_2_name, "bl_3_name"=> $bl_3_name, "bl_funct_name"=> $bl_funct_name, "bl_sub_funct_name"=> $bl_sub_funct_name, "bl_sub_subfunct_name"=> $bl_sub_subfunct_name, "bl_individual_name"=> $bl_individual_name, "bl_1_weightage"=>$bl_1_weightage, "bl_2_weightage"=>$bl_2_weightage, "bl_3_weightage"=>$bl_3_weightage, "bl_funct_weightage"=>$bl_funct_weightage, "bl_sub_funct_weightage"=>$bl_sub_funct_weightage, "bl_sub_subfunct_weightage"=>$bl_sub_subfunct_weightage, "bl_individual_weightage"=>$bl_individual_weightage, "bl_1_achievement"=>$bl_1_achievement, "bl_2_achievement"=>$bl_2_achievement, "bl_3_achievement"=>$bl_3_achievement, "bl_funct_achievement"=>$bl_funct_achievement, "bl_sub_funct_achievement"=>$bl_sub_funct_achievement, "bl_sub_subfunct_achievement"=>$bl_sub_subfunct_achievement, "bl_individual_achievement"=>$bl_individual_achievement);

		return $data;
	}

	/* This methods is same as Bonus/get_target_bonus_elements use */
	public function get_target_bonus_elements($rule_id)
	{		
		$tbl_name = "";
		$cnd_str = " status = 1 ";
		$elements_for = $this->input->post("elem_for");
		$rule_dtls = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		
		$elem_value_type = "%";
		$txt_maxlength = "6";
		$validation_of_val = 'onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"';
		if($this->input->post("elem_value_type")==2)
		{
			$elem_value_type = "Amount";
			$txt_maxlength = "9";
			$validation_of_val = 'onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"';
		}
		
		$headers = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", "status = 1 AND (module_name = '".CV_BUSINESS_LEVEL_1."' OR module_name = '".CV_BUSINESS_LEVEL_2."' OR module_name = '".CV_BUSINESS_LEVEL_3."' OR module_name = '".CV_FUNCTION."' OR module_name = '".CV_SUB_FUNCTION."' OR module_name = '".CV_SUB_SUB_FUNCTION."')", "id ASC");
		
		$str_main = '<table class="table table-bordered"><thead><tr>';
		
		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
		{
			$tbl_name = "manage_".$elements_for;
			$cnd_str .= " AND id IN (".$rule_dtls[$elements_for."s"].")"; 
			
			$str_main .= '<th colspan="2">Target '.CV_BONUS_SIP_LABEL_NAME.'</th><th colspan="7">Weightage</th></tr><tr><th style="text-transform: capitalize;">'.$elements_for.'</th><th>Target '.CV_BONUS_SIP_LABEL_NAME.' '.$elem_value_type.'</th>';
		}
		else
		{
			$str_main .= '<th colspan="7">Weightage</th></tr><tr>';
		}
		
		foreach ($headers as $row)
		{
			$str_main .= '<th>'.$row["display_name"].'</th>';
		}		
		$str_main .= '<th>Individual</th></tr></thead><tbody>';
		
		if($tbl_name)
		{
			$elements_list = $this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");	
			if($elements_list)
			{
				$k=1;
				foreach($elements_list as $row)
				{
					$str_main .= '<tr>';
					$str_main .= '<td>'.$row['name'].'<input type="hidden" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['name'].'" name="hf_target_bonus_elem[]" /></td>';
					$str_main .= '<td><input type="text" name="txt_target_bonus_elem[]" id="txt_target_elem_'.$row['id'].'" class="form-control" required maxlength="'.$txt_maxlength.'" '.$validation_of_val.' style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_bl_1_weightage[]" id="txt_bl1_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_bl1_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_bl_2_weightage[]" id="txt_bl2_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_bl2_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_bl_3_weightage[]" id="txt_bl3_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_bl3_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_function_weightage[]" id="txt_funct_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_funct_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_sub_function_weightage[]" id="txt_sub_funct_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_sub_funct_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_sub_subfunction_weightage[]" id="txt_sub_subfunct_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_sub_subfunct_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '<td><input type="text" name="txt_individual_weightage[]" id="txt_indivi_weight_'.$row['id'].'" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_indivi_weight_'".');" style="text-align:center;"/></td>';
					$str_main .= '</tr>';
					$k++;
				}
				$str_main .= '<tr id="tr_btn_put_achievement"><td colspan="9" style="text-align:right;"><input style="color:#fff !important;" type="button" value="Define Actual Achievements Below" class="btn btn-success" onclick="get_achievements_elements();"/></td></tr>';
			}
		}
		else
		{
			$str_main .= '<tr>';
			$str_main .= '<td><input type="text" name="txt_bl_1_weightage[]" id="txt_bl1_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_bl_2_weightage[]" id="txt_bl2_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_bl_3_weightage[]" id="txt_bl3_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_function_weightage[]" id="txt_funct_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_sub_function_weightage[]" id="txt_sub_funct_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_sub_subfunction_weightage[]" id="txt_sub_subfunct_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '<td><input type="text" name="txt_individual_weightage[]" id="txt_indivi_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"/></td>';
			$str_main .= '</tr>';
			
			$str_main .= '<tr id="tr_btn_put_achievement"><td colspan="7" style="text-align:right;"><input style="color:#fff !important;" type="button" value="Define Actual Achievements Below" class="btn btn-success" onclick="get_achievements_elements();"/></td></tr>';
		}
		$str_main .= '</tbody></table>'; 
		echo $str_main;		
	}

	/* This methods is same as Bonus/get_achievements_elements use */
	public function get_achievements_elements($rule_id, $bl_1_achievment, $bl_2_achievment, $bl_3_achievment, $function_achievment, $sub_function_achievment, $sub_subfunction_achievment)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));		
		$headers = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", "status = 1 AND (module_name = '".CV_BUSINESS_LEVEL_1."' OR module_name = '".CV_BUSINESS_LEVEL_2."' OR module_name = '".CV_BUSINESS_LEVEL_3."' OR module_name = '".CV_FUNCTION."' OR module_name = '".CV_SUB_FUNCTION."' OR module_name = '".CV_SUB_SUB_FUNCTION."')", "id ASC");
		
		$temp_arr = array();				
		foreach($headers as $row)
		{
			$tbl_name = "";
			$cnd_str = " status = 1 ";
			if($row["id"] == $bl_1_achievment)
			{
				$tbl_name = "	manage_business_level_1";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["business_level1"].")"; 
			}
			elseif($row["id"] == $bl_2_achievment)
			{
				$tbl_name = "	manage_business_level_2";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["business_level2"].")";
			}
			elseif($row["id"] == $bl_3_achievment)
			{
				$tbl_name = "	manage_business_level_3";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["business_level3"].")";
			}
			elseif($row["id"] == $function_achievment)
			{
				$tbl_name = "manage_function";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["functions"].")";
			}
			elseif($row["id"] == $sub_function_achievment)
			{
				$tbl_name = "manage_subfunction";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["sub_functions"].")";
			}
			elseif($row["id"] == $sub_subfunction_achievment)
			{
				$tbl_name = "manage_sub_subfunction";
				$cnd_str .= " AND id IN (".$data["rule_dtls"]["sub_subfunctions"].")";
			}
			
			if($tbl_name)
			{
				$row['bussiness_level_values']=$this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");
				$temp_arr[] = $row;
			}			
		}
		$data["bussiness_levels"] = $temp_arr;
		$this->load->view('bonus_show_achievements_elements',$data);
	}

	/* End - Bonus Part */

	/* Start - LTI Part */
	public function printpreview_lti ($rule_id)
	{
		if($this->session->userdata('is_manager_ses')==0)
		{
			$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
			{
				redirect(site_url("performance-cycle"));
			}	
		} else {
			$cdt = date("Y-m-d");		  
			$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
			if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
			{
				redirect(site_url("dashboard"));
			}
		}
	
		$data["target_lti_elements"] = json_decode($data["rule_dtls"]["target_lti_elem"], true);
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("id"=>$data['rule_dtls']["to_currency_id"]));

		$data["rule_dtls"]["salary_applied_on_elem_list"] = HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND business_attribute.id IN (".$data["rule_dtls"]["applied_on_elements"].")");
		
		/***** Below code is used only for showing rule filter on view Start *****/
		$user_id = $this->session->userdata('userid_ses');
		$data["rule_dtls"]["country_names"] = HLP_get_filter_names("manage_country", "name" , "id IN (".$data["rule_dtls"]["country"].")");
		$data["rule_dtls"]["city_names"] = HLP_get_filter_names("manage_city", "name" , "id IN (".$data["rule_dtls"]["city"].")");
		$data["rule_dtls"]["bl1_names"] = HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$data["rule_dtls"]["business_level1"].")");
		$data["rule_dtls"]["bl2_names"] = HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$data["rule_dtls"]["business_level2"].")");
		$data["rule_dtls"]["bl3_names"] = HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$data["rule_dtls"]["business_level3"].")");
		$data["rule_dtls"]["function_names"] = HLP_get_filter_names("manage_function", "name" , "id IN (".$data["rule_dtls"]["functions"].")");
		$data["rule_dtls"]["sub_function_names"] = HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$data["rule_dtls"]["sub_functions"].")");
		$data["rule_dtls"]["designation_names"] = HLP_get_filter_names("manage_designation", "name" , "id IN (".$data["rule_dtls"]["designations"].")");
		$data["rule_dtls"]["grade_names"] = HLP_get_filter_names("manage_grade", "name" , "id IN (".$data["rule_dtls"]["grades"].")");
		$data["rule_dtls"]["level_names"] = HLP_get_filter_names("manage_level", "name" , "id IN (".$data["rule_dtls"]["levels"].")");
		$data["rule_dtls"]["education_names"] = HLP_get_filter_names("manage_education", "name" , "id IN (".$data["rule_dtls"]["educations"].")");
		$data["rule_dtls"]["critical_talent_names"] = HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$data["rule_dtls"]["critical_talents"].")");
		$data["rule_dtls"]["critical_position_names"] = HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$data["rule_dtls"]["critical_positions"].")");
		$data["rule_dtls"]["special_category_names"] = HLP_get_filter_names("manage_special_category", "name" , "id IN (".$data["rule_dtls"]["special_category"].")");
		
		/***** Above code is used only for showing rule filter on view End ******/
			
		$data['title'] = "View LTI Rule Details";
		// echo "<pre>"; print_r($data); die();
		$this->load->view('manager/print_lti',$data);
	}

	public function get_managers_for_manual_bdgt_lti()
	{
		$budget_type = $this->input->get("budget_type");
		$to_currency_id = $this->input->get("to_currency");
		$rule_id = $this->input->get("rid");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $rule_id);
	
			if($managers)
			{
				$str = '<table class="table table-bordered">';
                $str .= '<thead><tr>';

                $str .= '<th>Manager Name</th><th>Calculated Budget</th>'; 

                if($budget_type == "Manual") 
                {
	                $str .= '<th>Final Budget</th>';  
	            }
	            if($budget_type == "Automated but x% can exceed") 
                {
	                $str .= '<th>Percentage</th>';  
	            }
                $str .= '</tr></thead><tbody>';  

				foreach ($managers as $row)
				{
					if((strcasecmp($this->session->userdata('email_ses'),$row['first_approver']))==0)
                    { 
						$manager_budget = $this->calculate_budgt_manager_wise_lti($rule_id, $data["rule_dtls"], $row['first_approver'], $to_currency_id);
						$str .= '<tr><td>';
						if($row['manager_name'])
						{
					    	$str .= $row['manager_name'];
						}
						else
						{
							$str .= $row['first_approver'];
						}              
	              	
		              	$str .= '</td><td>'.$to_currency_dtls["name"].' '.HLP_get_formated_amount_common($manager_budget).'</td>';

		              	if($budget_type == "Manual") 
	                	{		
							$str .= '<td>'.$to_currency_dtls["name"].' '.$manager_budget.'
				        		</td>';
				        }
			       
				        if($budget_type == "Automated but x% can exceed") 
		                {
			                $str .= '<td><input type="text" class="form-control customcls" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value=""  maxlength="5"/></td>';
			            }
				        $str .= '</tr>';
			    	}
				}
				$str .= '</tbody></table>'; 
				echo $str;
			} else {
				echo "";
			}
		}
	}

	/* This methods is same as Lti_rule/calculate_budgt_manager use */
	public function calculate_budgt_manager_wise_lti($rule_id, $rule_dtls, $manager_email, $to_currency_id)
	{
		$total_max_budget = 0;
		$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
	
		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;
			$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");						
			$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
			$currency = array("currency_type"=>$currency_arr["name"]);
			$from_currency_id = $currency_arr["id"];
			$emp_lti_dtls = $this->calculate_lti_emploee_wise($employee_id, $rule_dtls, $users_dtls);
			
			$manager_actual_budget += $emp_lti_dtls["current_emp_incentive"];
			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_lti_dtls["current_emp_incentive"]);
			$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_lti_dtls["emp_incremental_amt"]);	
		}
		return $total_max_budget;
	}

	/* This methods is same as Lti_rule/calculate_lti_emploee_wise use */
	public function calculate_lti_emploee_wise($employee_id, $rule_dtls, $users_dtls)
	{	
		$current_emp_incentive = 0;
		$emp_incremental_amt = 0;
		$grant_value = 0;
		$stock_share_price = 0;

		$emp_target_lti_on_val = $users_dtls[$rule_dtls['target_lti_on']];
		$target_lti_elem_arr = json_decode($rule_dtls["target_lti_elem"],true);
		$target_lti_dtls_arr = json_decode($rule_dtls["target_lti_dtls"],true);

		foreach ($target_lti_elem_arr as $key => $value) 
		{
			$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
			if(($emp_target_lti_on_val) and strtoupper($val_arr[1]) == strtoupper($emp_target_lti_on_val))
			{
				if($rule_dtls["lti_basis_on"]==2)
				{
					//Note :: No need to grant value in fixed case (lti_basis_on is fixed amount type)
					if($rule_dtls["lti_linked_with"]==CV_LTI_LINK_WITH_STOCK)
					{							
						$emp_incremental_amt = $target_lti_dtls_arr[0]["grant_value_arr"][$key+1];// Get Fixed Amount of Emp
						$stock_share_price = $target_lti_dtls_arr[0]["grant_value_arr"][0];
					}
					else
					{
						$emp_incremental_amt = $target_lti_dtls_arr[0]["grant_value_arr"][$key];// Get Fixed Amount of Emp for LTI (Incentive)	
					}
					$current_emp_incentive = $emp_incremental_amt;
				}
				else // Get Amount basis on selected Salary Elements condition
				{		
					$emp_tot_salary = 0;	
					$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["applied_on_elements"].")");
		
					if($increment_applied_on_arr)
					{
						foreach($increment_applied_on_arr as $salary_elem)
						{
							if($users_dtls[$salary_elem["ba_name"]])
							{
								$emp_tot_salary += $users_dtls[$salary_elem["ba_name"]];
							}
						}
					}
					
					$emp_incremental_amt = $emp_tot_salary;
					if($rule_dtls["lti_linked_with"]==CV_LTI_LINK_WITH_STOCK)
					{
						$grant_value = $target_lti_dtls_arr[0]["grant_value_arr"][$key+1];
						$current_emp_incentive = ($emp_tot_salary*$grant_value)/100;//Get Amount of Emp
						$stock_share_price = $target_lti_dtls_arr[0]["grant_value_arr"][0];
					}
					else
					{
						$grant_value = $target_lti_dtls_arr[0]["grant_value_arr"][$key];
						$current_emp_incentive=($emp_tot_salary*$grant_value)/100;//Get Amount of Emp for LTI (Incentive)
					}				
				}
				break;
			}
		}	

		return array("current_emp_incentive" => $current_emp_incentive, "emp_incremental_amt" => $emp_incremental_amt, "grant_value" => $grant_value);
	}
	/* End - LTI Part */

	

    

    /* CB: Harshit 05-01-19
    public function lti_rules()
    {
        $this->load->model('performance_cycle_model');
        if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";		
		$data['b_title']='LTI rules';
                $data['url']='view-emp-list-for-lti';                
                //$data["salary_rule_list"]=@array_unique($rulearr);
                $salary_rule_list=$this->performance_cycle_model->get_lti_rules_list(array("lti_rules.status>="=>6,"lti_rules.status!=">8));
                foreach($salary_rule_list as $emps)
                 {
                     $ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids']);
                     if(count($ids)>0)
                     {
                        $data['salary_rule_list'][]=$emps;
                     }
                 }
                $data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		$data['title'] = "View Increment";
                $data['print_url']='print-preview-lti';
                // $data['print_url']='manager/dashboard/print_data_lti';
		$data['body'] = "manager/salary_rule_list";
		$this->load->view('common/structure',$data);  
    }
    
    public function get_managers_for_manual_bdgt()
	{
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$rule_id = $this->input->post("rid");
		if($rule_id)
		{
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
			$managers = $this->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);
			if($managers)
			{
                                
				$str = '<table class="table table-bordered">';
                                $str .= '<thead><tr>';

                                $str .= '<th>Manager Name</th><th>Calculated Budget</th>'; 

                                if($budget_type == "Manual") 
                                {
                                        $str .= '<th>Final Budget</th>';  
                                    }
                                    if($budget_type == "Automated but x% can exceed") 
                                {
                                        $str .= '<th>Percentage</th>';  
                                    }
                                $str .= '</tr></thead><tbody>';  

				foreach ($managers as $row)
				{
                                    
                                       if((strcasecmp($this->session->userdata('email_ses'),$row['first_approver']))==0)
                                           { 
					$manager_budget = $this->calculate_budgt_manager_wise($rule_id, $row['first_approver'], $to_currency_id);
					$str .= '<tr><td>';
					if($row['manager_name'])
					{
				    	$str .= $row['manager_name'];
					}
					else
					{
						$str .= $row['first_approver'];
					}              
	              	
                                        $str .= '</td><td>'.HLP_get_formated_amount_common($manager_budget).'
                                                        <input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" />
                                                        <input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

                                        if($budget_type == "Manual") 
                                        {		
                                                                $str .= '<td><input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.$manager_budget.'"  maxlength="10" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required">
                                                                </td>';
                                                }

                                                if($budget_type == "Automated but x% can exceed") 
                                        {
                                                $str .= '<td><input type="text" class="form-control" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value=""  maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required"></td>';
                                            }
			        $str .= '</tr>';
                                }
				}
				$str .= '</tbody></table>'; 
				echo $str;
			}
			else
			{
				echo "";
			}
		}
	}

    public function calculate_budgt_manager_wise($rule_id, $manager_email)
	{	
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		
		$total_max_budget = 0;
		$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_dtls['user_ids'].") and row_owner.first_approver='".$manager_email."'");
	
		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;
			$increment_applied_on_amt = 0;
			$performnace_based_increment_percet=0;

			$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
			
			
			$increment_applied_on_arr = $this->rule_model->get_salary_applied_on_elements_val($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], $rule_dtls["salary_applied_on_elements"]);

			if($increment_applied_on_arr)
			{
				foreach($increment_applied_on_arr as $salary_elem)
				{
					if($salary_elem["value"])
					{
						$increment_applied_on_amt += $salary_elem["value"];
					}
				}
			}
			
			$emp_salary_rating = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));

			$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$performnace_based_increment_percet = $value;
					}
				}			
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}

			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);

			$emp_market_salary = 0;
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);

			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
						$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
						$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
					}
				}
			}
			else
			{
				$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
				$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
				$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
			}			

			$crr_per = 0;
			if($emp_market_salary > 0)
			{
				$crr_per = $increment_applied_on_amt/$emp_market_salary;//$performnace_based_salary/$emp_market_salary;
				if($rule_dtls["comparative_ratio"] == "yes")
				{
					$crr_per = $performnace_based_salary/$emp_market_salary;
				}
			}

			$i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $row1)
			{			
				if($i==0)
				{ 
					if($crr_per <= $row1["max"])
					{
						break;
					}
				}
				elseif(($i+1)==count($crr_arr))
				{
					if($row1["max"] > $crr_per)
					{
						break;
					}
				}
				else
				{
					if($row1["min"] < $crr_per and $crr_per <= $row1["max"])
					{
						break;
					}
				}
				$i++; 
			}

			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;	
			$crr_based_increment_percet = 0;
			$j=0;
			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
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
			//CB:: Ravi on 22-12-17
			//$current_emp_total_salary = ($increment_applied_on_amt) + (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($increment_applied_on_amt*$rule_dtls["standard_promotion_increase"])/100) + (($crr_based_increment_percet*$performnace_based_increment_percet)/100);
			//$total_max_budget += $current_emp_total_salary;
			$total_max_budget += (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100);	
		}
		return $total_max_budget;
	}*/

    
    
    

	
//************************************ Functionality End For LTI Rules ****************************
    /* CB -Harshit 05-12-2018 */
//     public function print_data_salary_NIU($rule_id)
// 	{
//                 $this->load->model('approvel_model');
// 		$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
// 		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
// 		{
// 			redirect(site_url("performance-cycle"));
// 		}	
	
// 		$is_enable_approve_btn = 0; // No
// 		//$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>2));
// 		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id,"approvel_requests.status"=>0, "approvel_requests.type"=>2));
// 		if($request_dtl)
// 		{
// 			/*if(!helper_have_rights(CV_SALARY_RULES_ID, CV_UPDATE_RIGHT_NAME))
// 			{
// 				$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You do not have update rights.</b></span></div>');
// 				redirect(site_url("performance-cycle"));
// 			}*/
// 			if(helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
// 			{
// 				$is_enable_approve_btn = 1; //Yes
// 			}
// 		}


// 		if($data["rule_dtls"]['performnace_based_hike']=='yes')
// 		{
// 			/*$rating_elements_list = $this->rule_model->get_salary_elements_list("id",array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
// 			if($rating_elements_list)
// 			{
// 				$data["rating_list"] = $this->rule_model->get_ratings_list($rating_elements_list);
// 			}
// 			else
// 			{
// 				$data["rating_list"] = "";
// 			}*/
// 			$rating_elements_list = $this->rule_model->get_ratings_list(array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
// 			if($rating_elements_list)
// 			{
// 				$data["rating_list"] = $rating_elements_list;
// 			}
// 			else
// 			{
// 				$data["rating_list"] = "";
// 			}
// 		}
// 		else
// 		{
// 			$data["rating_list"] = "";
// 		}

// 		/*$market_salary_elements_list = $this->rule_model->get_salary_elements_list("id", array("status"=>1, "module_name"=>CV_MARKET_SALARY_ELEMENT));
// 		if($market_salary_elements_list)
// 		{
// 			$data["market_salary_elements_list"] = $this->rule_model->get_market_salary_header_list($market_salary_elements_list);
// 		}
// 		else
// 		{
// 			$data["market_salary_elements_list"] = "";
// 		}*/
		
// 		//CB:Ravi on 22-02-2018
// 		//$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>CV_MARKET_SALARY_ELEMENT));
// 		$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
// 		if($market_salary_elements_list)
// 		{
// 			$data["market_salary_elements_list"] = $market_salary_elements_list;
// 		}
// 		else
// 		{
// 			$data["market_salary_elements_list"] = "";
// 		}
		
// 		//$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT));
// 		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
		
// /************* Below code is used only for showing rule filter on view Start ***********/
// 		$user_id = $this->session->userdata('userid_ses');
// 		//$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$data['rule_dtls']["performance_cycle_id"]));
		
// 		$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
// 		$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
// 		$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
// 		$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
// 		$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
// 		$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
// 		$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
// 		$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
// 		$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
// 		$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
// 		$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
// 		$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
// 		$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
// 		$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
// 		$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
			
		
// 		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
// 		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
// 		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
// 		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
// 		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

// 		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
// 		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
// 		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
// 		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");

// 		$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
// 		$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
// 		$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
// 		$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
		
// 		if($country_arr_view)
// 		{
// 			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
// 		}		
		
// 		if($city_arr_view)
// 		{
// 			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
// 		}		

// 		if($bl1_arr_view)
// 		{
// 			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
// 		}

// 		if($bl2_arr_view)
// 		{
// 			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
// 		}

// 		if($bl3_arr_view)
// 		{
// 			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
// 		}

// 		if($designation_arr_view)
// 		{
// 			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
// 		}

// 		if($function_arr_view)
// 		{
// 			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
// 		}

// 		if($sub_function_arr_view)
// 		{
// 			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
// 		}		

// 		if($grade_arr_view)
// 		{
// 			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
// 		}
// /************* Below code is used only for showing rule filter on view End ***********/

// 		$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
// 		$data['title'] = "View Salary Rule Details";
// 		$data['body'] = "print";
// 		$this->load->view('manager/print',$data);
// 	}



/* CB -Harshit 05-12-2018 */
// public function print_data_lti_NIU($rule_id)
// 	{
//                 $this->load->model('approvel_model');
// 		$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
// 		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
// 		{
// 			redirect(site_url("performance-cycle"));
// 		}	
	
// 		$is_enable_approve_btn = 0; // No
// 		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>4));
// 		if($request_dtl)
// 		{
// 			if(helper_have_rights(CV_APPROVE_LTI, CV_UPDATE_RIGHT_NAME))
// 			{
// 				$is_enable_approve_btn = 1; //Yes
// 			}
// 		}
		
// 		/*$data["target_lti_elements"] = "";
// 		$elements_for = $data["rule_dtls"]["target_lti_on"];
// 		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
// 		{
// 			$tbl_name = "manage_".$elements_for;
// 		}
			
// 		if($tbl_name)
// 		{
// 			$data["target_lti_elements"] = $this->rule_model->get_table($tbl_name, "*", array("status"=>1), "name asc");	
// 		}*/
// 		$data["target_lti_elements"] = json_decode($data["rule_dtls"]["target_lti_elem"], true);
// 		//$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT));
// 		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
// /************* Below code is used only for showing rule filter on view Start ***********/
// 		$user_id = $this->session->userdata('userid_ses');
		
// 		$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
// 		$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
// 		$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
// 		$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
// 		$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
// 		$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
// 		$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
// 		$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
// 		$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
// 		$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
// 		$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
// 		$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
// 		$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
// 		$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
// 		$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
			
		
// 		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
// 		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
// 		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
// 		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
// 		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

// 		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
// 		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
// 		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
// 		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");

// 		$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
// 		$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
// 		$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
// 		$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
// 		$data['levels_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
// 		if($country_arr_view)
// 		{
// 			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
// 		}		
		
// 		if($city_arr_view)
// 		{
// 			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
// 		}		

// 		if($bl1_arr_view)
// 		{
// 			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
// 		}

// 		if($bl2_arr_view)
// 		{
// 			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
// 		}

// 		if($bl3_arr_view)
// 		{
// 			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
// 		}

// 		if($designation_arr_view)
// 		{
// 			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
// 		}

// 		if($function_arr_view)
// 		{
// 			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
// 		}

// 		if($sub_function_arr_view)
// 		{
// 			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
// 		}		

// 		if($grade_arr_view)
// 		{
// 			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
// 		}
// 		else
// 		{
// 			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
// 		}
// /************* Above code is used only for showing rule filter on view End ***********/

// 		$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
// 		$data['title'] = "View LTI Rule Details";
		
// 		$this->load->view('manager/print_lti',$data);
// 	}

	/* CB -Harshit 05-12-2018 */
 //    public function print_data_bonus_NIU($rule_id)
	// {
 //            $this->load->model('approvel_model');
	// 	$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
	// 	if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
	// 	{
	// 		redirect(site_url("performance-cycle"));
	// 	}

	// 	$is_enable_approve_btn = 0; // No
	// 	//$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>3));
	// 	$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>3));
	// 	if($request_dtl)
	// 	{
	// 		/*if(!helper_have_rights(CV_BONUS_RULES_ID, CV_UPDATE_RIGHT_NAME))
	// 		{
	// 			$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You do not have update rights.</b></span></div>');
	// 			redirect(site_url("performance-cycle"));
	// 		}*/
	// 		if(helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
	// 		{
	// 			$is_enable_approve_btn = 1; //Yes
	// 		}			
	// 	}
	// 	$data['is_enable_approve_btn'] = $is_enable_approve_btn;

	// 	/*$bussiness_level_element_list = $this->bonus_model->get_bussiness_attributes_list("id", "status = 1 and (module_name = '".CV_BUSINESS_LEVEL_1."' or module_name = '".CV_BUSINESS_LEVEL_2."' or module_name = '".CV_BUSINESS_LEVEL_3."')");
	// 	$data["bussiness_levels"] = $this->bonus_model->get_bussiness_level_header_list($bussiness_level_element_list);*/		
	// 	$data["bussiness_levels"] = $this->bonus_model->get_bussiness_level_header_list("status = 1 and (module_name = '".CV_BUSINESS_LEVEL_1."' or module_name = '".CV_BUSINESS_LEVEL_2."' or module_name = '".CV_BUSINESS_LEVEL_3."')");
	// 	foreach ($data["bussiness_levels"] as $key => $value)
	// 	{
	// 		//$data["bussiness_levels"][$key]['bussiness_level_values'] = $this->bonus_model->get_bussiness_level_values(array('id'=>$value['business_attribute_id']));
	// 		$data["bussiness_levels"][$key]['bussiness_level_values'] = $this->bonus_model->get_bussiness_level_values(array('business_attribute_id'=>$value['business_attribute_id']));
	// 	}
 //                $data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
	// 	$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
	// 	$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
	// 	$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
	// 	$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
	// 	$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
	// 	$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
	// 	$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
	// 	$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
	// 	$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
	// 	$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
	// 	$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
	// 	$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
	// 	$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
	// 	$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
			
	// 	$user_id = $this->session->userdata('userid_ses');
	// 	$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
	// 	$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
	// 	$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
	// 	$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
	// 	$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

	// 	$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
	// 	$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
	// 	$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
	// 	$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");

	// 	$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
	// 	$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
	// 	$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
	// 	$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
	// 	$data['levels_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
	// 	if($country_arr_view)
	// 	{
	// 		$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
	// 	}		
		
	// 	if($city_arr_view)
	// 	{
	// 		$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
	// 	}		

	// 	if($bl1_arr_view)
	// 	{
	// 		$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
	// 	}

	// 	if($bl2_arr_view)
	// 	{
	// 		$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
	// 	}

	// 	if($bl3_arr_view)
	// 	{
	// 		$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
	// 	}

	// 	if($designation_arr_view)
	// 	{
	// 		$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
	// 	}

	// 	if($function_arr_view)
	// 	{
	// 		$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
	// 	}

	// 	if($sub_function_arr_view)
	// 	{
	// 		$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
	// 	}		

	// 	if($grade_arr_view)
	// 	{
	// 		$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
	// 	}
	// 	$data["functions"] = $this->rule_model->get_table("manage_function", "*", array("status"=>1), "name asc");
	// 	$data['title'] = "View Bonus Rule Details";
	// 	$data['body'] = "view_bonus_rule_details";
	// 	$this->load->view('manager/print_bonus',$data);
	// }
        

	// public function printpreview_salary ($rule_id, $is_open_frm_sal_review_pg=0)
 //    {
 //    	$is_enable_approve_btn = 0; // No
 //    	if($this->session->userdata('is_manager_ses')==0)
	// 	{
	//     	$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
	// 		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
	// 		{
	// 			redirect(site_url("performance-cycle"));
	// 		}	
		
	// 		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id,"approvel_requests.status"=>0, "approvel_requests.type"=>2));
	// 		if($request_dtl)
	// 		{
	// 			if(helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
	// 			{
	// 				$is_enable_approve_btn = 1; //Yes
	// 			}
	// 		}
	// 	} else {
	// 		$cdt = date("Y-m-d");
	// 		$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
	// 		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
	// 		{
	// 			redirect(site_url("dashboard"));
	// 		}
	// 	}

	// 	if($data["rule_dtls"]['performnace_based_hike']=='yes')
	// 	{
	// 		$rating_elements_list = $this->rule_model->get_ratings_list(array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
	// 		if($rating_elements_list)
	// 		{
	// 			$data["rating_list"] = $rating_elements_list;
	// 		}
	// 		else
	// 		{
	// 			$data["rating_list"] = "";
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$data["rating_list"] = "";
	// 	}

	// 	$market_salary_elements_list = $this->rule_model->get_market_salary_header_list(array("status"=>1, "module_name"=>$this->session->userdata('market_data_by_ses')));
	// 	if($market_salary_elements_list)
	// 	{
	// 		$data["market_salary_elements_list"] = $market_salary_elements_list;
	// 	}
	// 	else
	// 	{
	// 		$data["market_salary_elements_list"] = "";
	// 	}
	// 	$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
		
	// 	/************* Start-/ Below code is used only for showing rule filter on view ***********/
	// 	$user_id = $this->session->userdata('userid_ses');
		
	// 	$data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
	// 	$data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
	// 	$data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
	// 	$data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
	// 	$data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
	// 	$data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
	// 	$data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
	// 	$data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
	// 	$data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
	// 	$data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
	// 	$data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
	// 	$data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
	// 	$data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
	// 	$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
	// 	$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
			
	// 	$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
	// 	$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
	// 	$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
	// 	$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
	// 	$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
	// 	$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
	// 	$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
	// 	$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
	// 	$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");

	// 	$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
	// 	$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
	// 	$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
	// 	$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
	// 	$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
	// 	$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
	// 	if($country_arr_view)
	// 	{
	// 		$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
	// 	}		
		
	// 	if($city_arr_view)
	// 	{
	// 		$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
	// 	}		

	// 	if($bl1_arr_view)
	// 	{
	// 		$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
	// 	}

	// 	if($bl2_arr_view)
	// 	{
	// 		$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
	// 	}

	// 	if($bl3_arr_view)
	// 	{
	// 		$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
	// 	}

	// 	if($designation_arr_view)
	// 	{
	// 		$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
	// 	}

	// 	if($function_arr_view)
	// 	{
	// 		$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
	// 	}

	// 	if($sub_function_arr_view)
	// 	{
	// 		$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
	// 	}		

	// 	if($grade_arr_view)
	// 	{
	// 		$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
	// 	}
	// 	else
	// 	{
	// 		$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
	// 	}
	// 	/************* End-/ code is used only for showing rule filter on view ***********/

	// 	$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
	// 	$data['title'] = "View Salary Rule Details";
	// 	$data['body'] = "print";
	// 	if($this->session->userdata('is_manager_ses')==0)
	// 	{
	//         if($level_arr_view)
	// 		{
	// 			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
	// 		}
	// 		else
	// 		{
	// 			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
	// 		}
	// 		// $this->load->view('print',$data);
	// 	} else {
	// 		// $this->load->view('manager/print',$data);
	// 		$data["is_open_frm_sal_review_pg"] = $is_open_frm_sal_review_pg;
	// 	}
	// 	$this->load->view('manager/print',$data);
 //    }
       
}
