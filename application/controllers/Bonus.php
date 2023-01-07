<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus extends CI_controller
{
	public function __construct()
 	{		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');	
		$this->load->model("admin_model");
		$this->load->model("bonus_model");		
		$this->load->model("rule_model");
		$this->load->model("common_model");
		$this->load->model("approvel_model");
		$this->lang->load('message', 'english');
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{			
			redirect(site_url("dashboard"));			
		}    
		HLP_is_valid_web_token();                
    }

    public function bonus_rule_filters($performance_cycle_id, $rule_id=0)
	{
		$data["msg"] = "";
		if(!helper_have_rights(CV_BONUS_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></span></div>';
		}
		
		$is_need_update = 0;//1=Yes,0=No
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->rule_model->get_table_row("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		
		if(!$data['right_dtls'])
		{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your criteria for right not set yet. Please contact your admin.</b></span></div>');
			redirect(site_url("bonus-rule-list/".$performance_cycle_id));
		}

		$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));
		
		if(!$data['performance_cycle_dtls'])
		{
			redirect(site_url("performance-cycle"));
		}

		if($rule_id)
		{
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));

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
				$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
				$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
				//echo "<pre>";print_r($data["rule_dtls"]["tenure_roles"]);die;
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

		if($this->input->post())
		{			
			if(!$this->input->post("hf_select_all_filters"))
			{
				if(!helper_have_rights(CV_BONUS_RULES_ID, CV_INSERT_RIGHT_NAME))
				{
					redirect(site_url("bonus-rule-list/".$performance_cycle_id));
				}
				
				$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED);
				if($is_need_update > 0 and $rule_id > 0)
				{
					$condit_arr["hr_parameter_bonus.id !="] = $rule_id;
				}
	
				//$already_created_rule_for_emp_arr = $this->rule_model->get_table("hr_parameter_bonus","user_ids", $condit_arr);
				$already_created_rule_for_emp_arr = $this->bonus_model->get_all_emp_ids_for_a_bonus_cycle($condit_arr);
	
				$already_created_rule_for_emp_ids = array();
				foreach($already_created_rule_for_emp_arr as $row)
				{
					$already_created_rule_for_emp_ids[] = $row["user_id"];
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
				
				// if($data['performance_cycle_dtls']["type"] == CV_PERFORMANCE_CYCLE_SALES_ID)
				// {
					if(in_array('all', $this->input->post("ddl_sub_subfunction")))
					{
						$sub_subfunction_arr = $sub_subfunction_arr_view;
					}
					else
					{
						$sub_subfunction_arr = implode(",",$this->input->post("ddl_sub_subfunction"));
					}
				//}				
	
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
				
				// if($data['performance_cycle_dtls']["type"] == CV_PERFORMANCE_CYCLE_SALES_ID)
				// {
					if($sub_subfunction_arr)
					{
						$where .= " AND login_user.".CV_BA_NAME_SUB_SUBFUNCTION." IN (".$sub_subfunction_arr.")";
					}
				//}
				
	
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
				$data['employees'] = $this->bonus_model->get_employees_as_per_rights_for_bonus_rule($where);
				if(!$data['employees'])
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');
					
					if($rule_id)
					{
						redirect(site_url("bonus-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("bonus-rule-filters/".$performance_cycle_id));
					}
				}
				else
				{
					$txt_cutoff_dt = $this->input->post("txt_cutoff_dt");
					foreach($data['employees'] as $row)
					{
						if($txt_cutoff_dt != "")
						{
							$txt_cutoff_dt = date("Y-m-d",strtotime(str_replace("/","-",$txt_cutoff_dt)));							
							$joining_dt = date("Y-m-d",strtotime($row["date_of_joining"]));
							if($row["date_of_joining"] != "" and $joining_dt <= $txt_cutoff_dt)
							{
								$user_ids_arr[] = $row["id"];
							}
						}
						else
						{
							$user_ids_arr[] = $row["id"];
						}
					}
				}
				
				if(count($user_ids_arr) <= 0)
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');
					if($rule_id)
					{
						redirect(site_url("bonus-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("bonus-rule-filters/".$performance_cycle_id));
					}
				}
				
				$usr_ids = implode(",",$user_ids_arr);
				$db_arr = array(
								"rule_for" => 1,
								"performance_cycle_id" => $performance_cycle_id,
								//"user_ids" => $usr_ids,
								"country" => HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY),
								"city" => HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY),
								"business_level1" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1),
								"business_level2" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2),
								"business_level3" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3),
								"functions" => HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION),
								"sub_functions" => HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION),
								"designations" => HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION),
								"grades" => HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE),
								"levels" => HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL),
								"educations" => HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION),
								"critical_talents" => HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT),
								"critical_positions" => HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION),
								"special_category" => HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY),																
								"tenure_company" => $tenure_company_arr,
								"tenure_roles" => $tenure_role_arr,
								"cutoff_date" => $txt_cutoff_dt,
								"updatedBy" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedOn" => date("Y-m-d H:i:s")
								);
				
				$db_arr['sub_subfunctions'] = "";
				$db_arr['sub_subfunctions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION);
				if($data['performance_cycle_dtls']["type"] == CV_PERFORMANCE_CYCLE_SALES_ID)
				{
					//$db_arr['sub_subfunctions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION);
					$db_arr['rule_for'] = 2;
				}
				
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
					$data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
					$data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);					
				}
				else
				{	
					if($is_need_update > 0 and $rule_id > 0)
					{ 
						if($data["rule_dtls"]["status"]==5)
						{
							$db_arr["status"] = 3;
						}
						$this->bonus_model->updateBonusRules($db_arr,array('id'=>$rule_id));
					}
					else
					{
						$db_arr["status"] = 1;
						$db_arr["createdby"] = $this->session->userdata('userid_ses');
						$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
						$db_arr["createdon"] = date("Y-m-d H:i:s");
						$rule_id = $this->bonus_model->insert_bonus_rules($db_arr);
					}
					
					if($rule_id)
					{
						$db_rule_usr_ids_arr = array();
						foreach($user_ids_arr as $usr_id)
						{
							$db_rule_usr_ids_arr[] = array("rule_id"=>$rule_id, "user_id"=>$usr_id);
						}
						if($db_rule_usr_ids_arr)
						{
							$this->rule_model->delete_emps_frm_rule_dtls("bonus_rule_users_dtls",array("rule_id"=>$rule_id));
							$this->rule_model->insert_data_as_batch("bonus_rule_users_dtls", $db_rule_usr_ids_arr);
						}
						
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You are covering '.count($user_ids_arr).' employees under this rule.</b></div>'); 
						redirect(site_url("create-bonus-rule/".$rule_id));	
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></div>'); 
						if($rule_id)
						{
							redirect(site_url("bonus-rule-filters/".$performance_cycle_id."/".$rule_id));
						}
						else
						{
							redirect(site_url("bonus-rule-filters/".$performance_cycle_id));
						}
					}
				}
			}
		}

		if($country_arr_view)
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 AND id IN (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 AND id IN (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		

		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 AND id IN(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}

		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 AND id IN(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}

		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 AND id IN(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}

		if($designation_arr_view)
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 AND id IN(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}

		if($function_arr_view)
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 AND id IN(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}

		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 AND id IN(".$sub_function_arr_view.")", "name asc");
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
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 AND id IN(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}	
		
		if($level_arr_view)
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 AND id IN(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}
		
		$data['rule_txt_name'] = CV_BONUS_LABEL_NAME;
		if($data['performance_cycle_dtls']["type"] == CV_PERFORMANCE_CYCLE_SALES_ID)
		{
			$data['rule_txt_name'] = CV_BONUS_SIP_LABEL_NAME;
		}
		
		$data['rule_list_pg_url'] = site_url("bonus-rule-list/".$data['performance_cycle_dtls']['id']);
		$data['tooltip'] = getToolTip('bonus-rule-page-1');
		
		$data['title'] = "Set ".$data['rule_txt_name']." Rule Filters";
		$data['body'] = "salary_rule_filters";
		$this->load->view('common/structure',$data);
	}
	
	public function createBonusRules($rule_id)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.createdby"=>$this->session->userdata('userid_ses'), "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
				
		/*//Note :: Start :: Redirect on View SIP Rule ********************************
		if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
		{ 
			redirect(site_url("sip/create_sip_rule/".$rule_id));
		}
		//Note :: End :: Redirect on View SIP Rule *********************************/
		
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] >= 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
        $data["emp_not_any_cycle_counts"] = $this->emp_not_any_cycle($data['rule_dtls']["performance_cycle_id"]);
		
		$data["bonus_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
		$data['title'] = CV_BONUS_LABEL_NAME." Rules";
		if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
		{
			$data['title'] = CV_BONUS_SIP_LABEL_NAME." Rules";
		}
		
		$data['body'] = "create_bonus_rules";
		$this->load->view('common/structure',$data);
	}
    
	public function emp_not_any_cycle($performance_cycle_id, $is_need_to_show=0)
	{
		$performance_cycle_dtls = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));
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
		
		$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED);
		//$already_created_rule_for_emp_arr = $this->rule_model->get_table("hr_parameter_bonus","user_ids", $condit_arr);
		$already_created_rule_for_emp_arr = $this->bonus_model->get_all_emp_ids_for_a_bonus_cycle($condit_arr);

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
		
		/*if($performance_cycle_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID)
		{*/
			if($sub_subfunction_arr_view)
			{
				$where .= " AND login_user.".CV_BA_NAME_SUB_SUBFUNCTION." IN (".$sub_subfunction_arr_view.")";
			}
		//}

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
		$employees = $this->bonus_model->get_employees_as_per_rights_for_bonus_rule($where);

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
	
	public function get_ratings_list()
	{
		$rule_id = $this->input->post("rule_id");
		$ddl_name = "ddl_market_salary_rating";
		$hf_name = "hf_rating_name";
		$ddl_str = '<input type="text" name="'.$ddl_name.'[]" class="form-control" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" maxlength="6" />';
		
		//$rating_elements_list = $this->rule_model->get_ratings_list();
		$rating_elements_list = $this->bonus_model->get_ratings_list_as_per_bonus_rules_emp(array("bonus_rule_users_dtls.rule_id"=>$rule_id));
		if($rating_elements_list)
		{
			foreach ($rating_elements_list as $row)
			{
				echo '<div class="col-sm-6 removed_padding"><label for="inputEmail3" class="control-label">'.$row['value'].'</label></div>';
                echo '<div class="col-sm-6"><input type="hidden" id="'.$row['id'].'" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['value'].'" name="'.$hf_name.'[]" />'.$ddl_str.'</div>';
			}
		}
		else
		{
			echo "";//Means No Ratings available or Rating Attribute is InActive In Business Attribute Table
		}
	}
	
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
			
			if($rule_dtls["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
			{
				$str_main .= '<th colspan="2">Target '.CV_BONUS_SIP_LABEL_NAME.'</th><th colspan="7">Weightage</th></tr><tr><th style="text-transform: capitalize;">'.$elements_for.'</th><th>Target '.CV_BONUS_SIP_LABEL_NAME.' '.$elem_value_type.'</th>';
			}
			else
			{
				$str_main .= '<th colspan="2">Target '.CV_BONUS_LABEL_NAME.'</th><th colspan="7">Weightage</th></tr><tr><th style="text-transform: capitalize;">'.$elements_for.'</th><th>Target '.CV_BONUS_LABEL_NAME.' '.$elem_value_type.'</th>';
			}			
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

	public function saveBonusRules($rule_id, $step)
	{
		if($step > 0 and $rule_id > 0)
		{
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
			if(!$data['rule_dtls'] or $data['rule_dtls']["status"] >= 4)//Sent for approval yet or Approved
			{
				echo "";die;
			}	

			if($step==1)
			{
				if(!$this->input->post("hf_show_next_step"))	
				{
					$start_dt=explode("/",$this->input->post('txt_start_dt')); 						
					$end_dt=explode("/",$this->input->post('txt_end_dt'));
					
					$db_arr = array(
							'bonus_rule_name' => $this->input->post("txt_rule_name"),
							'payment_basis' => $this->input->post("rb_payment_basis"),
							'bonus_given' => 1,//$this->input->post("rb_bonus_given"),		
							'prorated_increase' => $this->input->post("ddl_prorated_increase"),
							'start_dt' => $start_dt[2].'-'.$start_dt[1].'-'.$start_dt[0],
							'end_dt' => $end_dt[2].'-'.$end_dt[1].'-'.$end_dt[0],				
							'target_bonus' => $this->input->post("ddl_target_bonus"),
							'target_bonus_dtls'=>"",
							'target_bonus_on'=>"",	
							'bl_1_weightage'=>implode(",",$this->input->post("txt_bl_1_weightage")),
							'bl_2_weightage'=>implode(",",$this->input->post("txt_bl_2_weightage")),
							'bl_3_weightage'=>implode(",",$this->input->post("txt_bl_3_weightage")),
							'function_weightage'=>implode(",",$this->input->post("txt_function_weightage")),
							'sub_function_weightage'=>implode(",",$this->input->post("txt_sub_function_weightage")),
							'sub_subfunction_weightage'=>implode(",",$this->input->post("txt_sub_subfunction_weightage")),
							'individual_weightage'=>implode(",",$this->input->post("txt_individual_weightage")),
							'business_level_achievement'=>"",								
							'performance_type' => $this->input->post("ddl_performance_type"),
							'performance_achievements_multiplier_type' => "",	
							'performnace_based_hike_ratings' => "",
							'performance_achievement_rangs' => "",			
							'manager_discretionary_increase' => $this->input->post("txt_manager_discretionary_increase"),
							'manager_discretionary_decrease' => $this->input->post("txt_manager_discretionary_decrease"),
							"updatedBy" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedOn" => date("Y-m-d H:i:s"));
					
					$db_arr["bonus_applied_on_elements"] = CV_BONUS_APPLIED_ON_ID;
					if($this->input->post("ddl_target_bonus")=="yes")
					{
						$db_arr["bonus_applied_on_elements"] = implode(",",$this->input->post("ddl_bonus_applied_elem"));
						$db_arr["target_bonus_on"] = $this->input->post("ddl_target_bonus_on");
						$target_elements_arr = array();
						foreach($_REQUEST['hf_target_bonus_elem'] as $key=> $value) 
						{ 
							if($value !='') 
							{ 
								$target_elements_arr[$value] = $_REQUEST['txt_target_bonus_elem'][$key];
							}
						}					
						$db_arr['target_bonus_dtls'] = json_encode($target_elements_arr);
						$db_arr['target_bonus_elem_value_type'] = $this->input->post("ddl_target_bonus_elem_value_type");
					}

					$business_level_element_val_arr = array();
					
					$i=0;
					foreach($_REQUEST['hf_business_level'] as $key=> $value) 
					{ 
						if($this->input->post("txt_business_level_element_val_".$i))
						{
							foreach($_REQUEST['hf_business_level_element_val_'.$i] as $k=> $v) 
							{ 
								if($v !='') 
								{
										$business_level_element_val_arr[$v] = $_REQUEST['txt_business_level_element_val_'.$i][$k];
								}
							}
						}
						$i++;
					}
					
					$db_arr["business_level_achievement"] = json_encode($business_level_element_val_arr);
					$perfo_achie_rangs_arr = $rating_arr = array();
					$performnace_based_hike = "";
					
					if($db_arr["performance_type"]==1)
					{						
						$performnace_based_hike = $this->input->post("ddl_performnace_based_hikes");
						if($performnace_based_hike=='yes')
						{
							foreach($_REQUEST['hf_rating_name'] as $key=> $value) 
							{ 
								if($value !='') 
								{ 
									$rating_arr[$value] = $_REQUEST['ddl_market_salary_rating'][$key];
								}
							}
						}
						else
						{
							$rating_arr['all'] = $this->input->post("rating_for_all");
						}
						$db_arr['performnace_based_hike_ratings'] = json_encode($rating_arr);
					}
					else
					{
						$min_range = 0;
						$cnt = 0;
						foreach($_REQUEST['txt_perfo_achiev_range'] as $key=> $value) 
						{ 
							if($value !='') 
							{ 
								$perfo_achie_rangs_arr["range".($cnt+1)] = array("min"=>$min_range,"max"=>$value);
								$min_range = $value;
								$cnt++;
							}
						}
						$db_arr['performance_achievement_rangs'] = json_encode($perfo_achie_rangs_arr);
						$db_arr["performance_achievements_multiplier_type"] = $this->input->post("ddl_performance_achievements_multiplier");
					}

					$db_arr['performnace_based_hike'] = $performnace_based_hike;					
					$db_arr['overall_budget'] = "";
					$db_arr['manual_budget_dtls'] = "";
					$db_arr['status'] = 2;
					$this->bonus_model->updateBonusRules($db_arr,array('id'=>$data['rule_dtls']["id"]));
				}
				echo 1;
			}
			elseif($step==2)
			{
				if(!$this->input->post("hf_show_next_step"))	
				{					
					$step2_db_arr = array(
								'performance_achievements_multipliers' => json_encode($this->input->post("txt_perfo_achie_rangs")),
								"updatedBy" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedOn" => date("Y-m-d H:i:s"));
					$this->bonus_model->updateBonusRules($step2_db_arr,array('id'=>$data['rule_dtls']["id"]));
					
				} 
				echo 2; die;	
			}
			elseif($step==3)
			{
				$manual_budget_dtls = array();				
				$budgt_type = $this->input->post("ddl_overall_budget");

				foreach($_REQUEST['hf_managers'] as $key=> $value) 
				{
					$budget_amount = 0;
					$budget_percent = 0;
					//$pre_calculated_budgt = $_REQUEST['hf_pre_calculated_budgt'][$key];
					$pre_calculated_budgt = $_REQUEST['hf_pre_calculated_budgt_actual'][$key];

					if($this->input->post("ddl_overall_budget")=="Automated locked")
					{
						$budget_amount = $pre_calculated_budgt;
					}
					elseif($this->input->post("ddl_overall_budget")=="Automated but x% can exceed")
					{
						$budget_percent = $_REQUEST['txt_manual_budget_per'][$key];
						$budget_amount = $pre_calculated_budgt;
					}
					$manual_budget_dtls[] = array($value, $budget_amount, $budget_percent, $pre_calculated_budgt);
				}
				
				$step2_db_arr = array(								
								'overall_budget' => $this->input->post("ddl_overall_budget"),
								'to_currency_id' => $this->input->post("ddl_to_currency"),
								'manual_budget_dtls' => json_encode($manual_budget_dtls),
								"updatedBy" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedOn" => date("Y-m-d H:i:s"),
								'status' => 3);
				$this->bonus_model->updateBonusRules($step2_db_arr,array('id'=>$data['rule_dtls']["id"]));	
				
				if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule created successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_LABEL_NAME.' rule created successfully.</b></div>');
				}				
				 
				echo 3; die;
			}			
		}
	}

	public function get_bonus_rule_step2_frm($rule_id)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}		
		
		if($data["rule_dtls"]["performance_type"]==1)
		{
			$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.")");
			$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));
			$this->load->view('create_bonus_rule_partial_for_manager_dtls',$data);	
		}
		else
		{
			$this->load->view('create_bonus_performance_achievement_rangs_grid',$data);
		}
	}
	
	public function get_bonus_rule_step3_frm($rule_id)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}		
		
		$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));
		$this->load->view('create_bonus_rule_partial_for_manager_dtls',$data);
	}

	public function get_managers_for_manual_bdgt($is_view_only=0)
	{
		$budget_type = $this->input->post("budget_type");
		$rule_id = $this->input->post("rid");
		$to_currency_id = $this->input->post("to_currency");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("bonus_rule_users_dtls", $rule_id);
	
			if($managers)
			{
				$str_main = '<div class="table-responsive" style="overflow-x: unset;"><table class="table tablecustm table-bordered"><thead>';
                $str_main .= '<tr>';
				$str_main .= '<th>Manager Name</th><th>Number of Employees</th>';
				
				if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
				{
					$str_main .= '<th>Target '.CV_BONUS_SIP_LABEL_NAME.'</th>';
				}
				else
				{
					$str_main .= '<th>Target '.CV_BONUS_LABEL_NAME.'</th>';
				}
				$str_main .= '<th>Budget as per the plan</th>';
				
				$colspn = 4;

                if($budget_type == "Manual") 
                {
					$colspn = 5;
	                $str_main .= '<th>Final Budget</th>';  
	            }
	            if($budget_type == "Automated but x% can exceed") 
                {
					$colspn = 5;
	                $str_main .= '<th>Additional Budget (as %age of the allocated budget)</th>'; 
	                $str_main .= '<th>Additional Budget (as amount of the allocated budget)</th>';  
	            }
				$str_main .= '<th>Revised Budget</th><th>%age Allocated</th>'; 
                $str_main .= '</tr>';  
                $cTotal=0;
                $EmpTotal=0;
                $cbudget=0;
                $tsalary=0;
				$i=1;
				$str = '';
				
				foreach ($managers as $row)
				{
					$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($rule_id, $row['first_approver'], $to_currency_id);
					$manager_emp_budget_dtls['currency']['currency_type'] = $to_currency_dtls["name"];
					$manager_budget = $manager_emp_budget_dtls["budget"];
					$manager_actual_budget = $manager_emp_budget_dtls["manager_actual_budget"];
					
					$str .= '<tr><td>';
					if($row['manager_name'])
					{
				    	$str .= $row['manager_name'];
					}
					else
					{
						$str .= $row['first_approver'];
					}              
	              	$cTotal=$cTotal+$manager_budget;
					$EmpTotal=$EmpTotal+$manager_emp_budget_dtls["total_emps"];
					$tsalary=$tsalary+$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];
	              	$str .= '</td><td style="text-align:center;">'.$manager_emp_budget_dtls["total_emps"].'</td><td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]).'</td><td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_budget).'
	              			<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" id="hf_pre_calculated_budgt_'.$i.'"/>
							<input type="hidden" value="'.$manager_actual_budget.'" name="hf_pre_calculated_budgt_actual[]"/>
							<input type="hidden" value="'.$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"].'" id="hf_incremental_amt_'.$i.'" />
	              			<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

					if($is_view_only)
					{
						if($budget_type == "Manual") 
						{		
							$str .= '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="dv_manual_budget_'.$i.'"></ravi> % </td>';
						}
					   
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td class="txtalignright"><ravi id="dv_x_per_budget_'.$i.'"></ravi> % </td>';
						}
					}
					else
					{
						if($budget_type == "Manual") 
						{		
							$str .= '<td><input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.round($manager_budget).'"  maxlength="12" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" required="required" onChange="calculat_percent_increased_val(1,this.value, '.$i.')"></td>';
						}
					   
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td><div style="position:relative;"><input type="text" class="form-control text-right addpersen" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value="0"  maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" required="required" onChange="calculat_percent_increased_val(2,this.value, '.$i.')"><span></span></div></td>';
						}
					}
					//Piy@17Dec19
					if($budget_type == "Automated but x% can exceed") 
					{
						$str .= '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="td_increased_amt_val_'.$i.'">'.HLP_get_formated_amount_common(0).'</ravi></td>';
					}					
					$str .= '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="td_revised_bdgt_'.$i.'">'.HLP_get_formated_amount_common($manager_budget).'</ravi></td>';


					$str .= '<td id="td_increased_amt_'.$i.'" class="txtalignright">'.HLP_get_formated_percentage_common(($manager_budget/$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"])*100).' %</td>';
			        $str .= '</tr>';
					$i++;
				}
                     
				$str_main .='<tr class="tablealign">'
                                        . '<th style="text-align: center;"><input type="hidden" id="curency" value="'.$manager_emp_budget_dtls['currency']['currency_type'].'"/><input type="hidden" value="'.$i.'" id="hf_manager_cnt"/>Total&nbsp;</th>'
                                        . '<th style="text-align: center;">'.$EmpTotal.'</th><th style="text-align: right !important;"><input type="hidden" value="'.round($tsalary).'" id="hf_total_target_bonus"/>'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($tsalary)).'</th>'
                                        . '<th style="text-align: right !important;">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_plan">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
				//. '<th id="th_total_budget">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($cTotal)).'</th>';
				if($budget_type == "Manual") 
				{		
				  $str_main .= '<th style="text-align: right !important;"> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
				}

				if($budget_type == "Automated but x% can exceed") 
				{
					$str_main .= '<th style="text-align: right !important;"> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
					$str_main .= '<th style="text-align: right !important;"> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_additional_budget_manual">'.HLP_get_formated_amount_common(0).'</ravi></th>';
					
				}
				 $str_main .='<th style="text-align: right !important;">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th><th id="th_final_per" style="text-align: right !important;">'.HLP_get_formated_percentage_common(($cTotal/$tsalary)*100).' %</th></tr></thead><tbody>';
				$str_main .= '</tr>';
				$str_main .= $str;
				$str_main .= '</tbody></table></div>'; 
				echo $str_main;
			}
			else
			{
				echo "";
			}
		}
	}

	public function calculate_budgt_manager_wise($rule_id, $manager_email, $to_currency_id)
	{	
		$rule_dtls =  $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));		
		$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
		$total_max_budget = 0;
		$manager_actual_budget = 0;
		$managers_emps_tot_incremental_amt = 0;
		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;				
			$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
			$currency = array("currency_type"=>$currency_arr["name"]);
			$from_currency_id = $currency_arr["id"];
			
			$emp_bonus_dtls = $this->calculate_bonus_emploee_wise($employee_id, $rule_dtls);			
			$manager_actual_budget += $emp_bonus_dtls["cuurent_emp_bonus_amt"];
			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_bonus_dtls["cuurent_emp_bonus_amt"]);
			$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_bonus_dtls["bonus_applied_on_amt"]);
			
		}
		return array("total_emps"=>count($managers_emp_arr), "budget"=>round($total_max_budget,2), "managers_emps_tot_incremental_amt"=>$managers_emps_tot_incremental_amt,"currency"=>$currency, "manager_actual_budget"=>$manager_actual_budget);
	}	
	
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
						$bonus_applied_on_amt = $elemnt;//$bonus_applied_on_amt + $elemnt;
					}	
					else
					{
						$bonus_applied_on_amt = ($bonus_applied_on_amt*$elemnt)/100;//$bonus_applied_on_amt + ($bonus_applied_on_amt*$elemnt)/100;		
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
					if($key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$bl_individual_achievement = $value;
						$bl_individual_name = $key_arr[1];//$users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR];
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
	
	public function calculate_bonus($rule_id, $is_need_to_save_data=0, $send_for_release=0)
	{
		// $is_need_to_save_data = 0 (No) and 1 (Yes)
		$rule_dtls =  $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}

		$managers_budget_dtls = array();
		$data['total_max_budget'] = 0;
		$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
		foreach($managers_arr as $key => $value)
		{
			if($rule_dtls["overall_budget"] != "No limit")	
			{
				$data['total_max_budget'] += $value[1] + (($value[1]*$value[2])/100);
			}
			else
			{
				$data['total_max_budget'] = 0; // No limit set for budget
			}
			$managers_budget_dtls[$key]["manager_email"] = $value[0];
			$managers_budget_dtls[$key]["manager_budegt"] = $value[1] + (($value[1]*$value[2])/100);
			$managers_budget_dtls[$key]["manager_employee_tot_incr_salary"] = 0;
			
			$managers_budget_dtls[$key]["manager_emp_arr"] = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$value[0]."'");
			$managers_budget_dtls[$key]["bdgt_x_per_exceed_val"] = $value[2];
		}
	
		//$staff_list = explode(",",$rule_dtls['user_ids']);
		$staff_list = $this->rule_model->get_table("bonus_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");

		$total_bonus_percentage = 0;
		$total_bonus_amt = 0;
		$total_employee = count($staff_list);
		$str = "";
		$cnt = 0;
		foreach ($staff_list as $row)
		{
			$employee_id = $row["user_id"];
			$emp_bonus_dtls = $this->calculate_bonus_emploee_wise($employee_id, $rule_dtls);
			//$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
			$users_dtls = $emp_bonus_dtls["user_dtls"];

			$str .= "<tr><td class='hidden-xs'>". ($cnt + 1) ."</td>";
			if(($users_dtls[CV_BA_NAME_EMP_FULL_NAME]) and $users_dtls[CV_BA_NAME_EMP_FULL_NAME] != "")
			{
				$str .= "<td>".$users_dtls[CV_BA_NAME_EMP_FULL_NAME]."</td>";
			}
			else
			{
				$str .= "<td>N/A</td>";
			}
			$str .= "<td>".$users_dtls[CV_BA_NAME_EMP_EMAIL]."</td>";
			$str .= "<td>".round($emp_bonus_dtls["final_bonus_per"],2)."%</td>";
			$str .= "<td class='txtalignright'>".HLP_get_formated_amount_common($emp_bonus_dtls["cuurent_emp_bonus_amt"])."</td></tr>";
			$total_bonus_percentage += $emp_bonus_dtls["final_bonus_per"];
			$total_bonus_amt += $emp_bonus_dtls["cuurent_emp_bonus_amt"];
			$cnt++;

			$manager_emailid = "";
			$bdgt_x_per_exceed_val = 0;
			foreach($managers_budget_dtls as $emp_key => $emp_arr)
			{
				if(in_array($employee_id, $emp_arr["manager_emp_arr"]))
				{
					$manager_emailid = $managers_budget_dtls[$emp_key]["manager_email"];
					$bdgt_x_per_exceed_val = $managers_budget_dtls[$emp_key]["bdgt_x_per_exceed_val"];
					break;
				}					
			}

			if($is_need_to_save_data==1)
			{
				// Note :: $send_for_release => 1=Rule send for release directly so no need to verify salary by managers, other then 1 means need verify salary by managers
				$status = 1;
				if($send_for_release == 1)
				{			
					$status = 5;
				}
				
				$emp_final_bdgt = $emp_bonus_dtls["cuurent_emp_bonus_amt"];
				if($rule_dtls["overall_budget"] == "No limit")	
				{
					$emp_final_bdgt = 0;// No limit set for budget
				}
				elseif($rule_dtls["overall_budget"] == "Automated but x% can exceed")
				{
					$emp_final_bdgt += round((($emp_final_bdgt*$bdgt_x_per_exceed_val)/100), 2); 
				}

				//$emp_datum_dtls = $this->common_model->get_employee_dtls_by_datum_tbl(array("datum.data_upload_id"=>$users_last_tuple_dtls["data_upload_id"], "datum.row_num"=>$users_last_tuple_dtls["row_num"]));
				
				$db_arr =array(
							"rule_id" => $rule_id,
							"user_id" => $employee_id,
							//"upload_id" => $users_last_tuple_dtls["data_upload_id"],//CB::Ravi on 15-02-2018
							"target_bonus" => $emp_bonus_dtls["bonus_applied_on_amt"],
							"performnace_rating" => $emp_bonus_dtls["bl_individual_name"],
							"performance_achievement" => $users_dtls[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT],
							"bl_1_name" => $emp_bonus_dtls["bl_1_name"],
							"bl_1_weightage" => $emp_bonus_dtls["bl_1_weightage"],
							"bl_1_achievement" => $emp_bonus_dtls["bl_1_achievement"],
							"bl_2_name" => $emp_bonus_dtls["bl_2_name"],
							"bl_2_weightage" => $emp_bonus_dtls["bl_2_weightage"],
							"bl_2_achievement" => $emp_bonus_dtls["bl_2_achievement"],
							"bl_3_name" => $emp_bonus_dtls["bl_3_name"],
							"bl_3_weightage" => $emp_bonus_dtls["bl_3_weightage"],
							"bl_3_achievement" => $emp_bonus_dtls["bl_3_achievement"],
							"individual_name" => $emp_bonus_dtls["bl_individual_name"],
							"individual_weightage" => $emp_bonus_dtls["bl_individual_weightage"],
							"individual_achievement" => $emp_bonus_dtls["bl_individual_achievement"],
							"function_name" => $emp_bonus_dtls["bl_funct_name"],
							"function_weightage" => $emp_bonus_dtls["bl_funct_weightage"],
							"function_achievement" => $emp_bonus_dtls["bl_funct_achievement"],							
							"sub_function_name" => $emp_bonus_dtls["bl_sub_funct_name"],
							"sub_function_weightage" => $emp_bonus_dtls["bl_sub_funct_weightage"],
							"sub_function_achievement" => $emp_bonus_dtls["bl_sub_funct_achievement"],
							"sub_subfunction_name" => $emp_bonus_dtls["bl_sub_subfunct_name"],
							"sub_subfunction_weightage" => $emp_bonus_dtls["bl_sub_subfunct_weightage"],
							"sub_subfunction_achievement" => $emp_bonus_dtls["bl_sub_subfunct_achievement"],
							"emp_final_bdgt" => $emp_final_bdgt,							
							"final_bonus" => $emp_bonus_dtls["cuurent_emp_bonus_amt"],
							"final_bonus_per" => $emp_bonus_dtls["final_bonus_per"],							
							"actual_bonus" => $emp_bonus_dtls["cuurent_emp_bonus_amt"],
							"actual_bonus_per" => $emp_bonus_dtls["final_bonus_per"],
							"manager_discretionary_increase" => $rule_dtls['manager_discretionary_increase'],
							"manager_discretionary_decrease"=> $rule_dtls['manager_discretionary_decrease'],
							"last_action_by" => $manager_emailid,
							"manager_emailid" => $manager_emailid,
							"status" => $status,
							"created_by" => $this->session->userdata('userid_ses'),
							"created_on" =>date("Y-m-d H:i:s"),
							"updatedby" =>$this->session->userdata('userid_ses'),
							"updatedon" =>date("Y-m-d H:i:s"),
							"createdby_proxy"=>$this->session->userdata("proxy_userid_ses"),
							"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
							
				//Newly code by ravi to insert required parameters from datum tbl to this tbl on 10-05-18 Start
				if($users_dtls[CV_BA_NAME_COUNTRY])
				{
					$country_arr = $this->admin_model->get_table_row("manage_country", "name", array( "id"=>$users_dtls[CV_BA_NAME_COUNTRY]), "id desc");
					$db_arr["country"] = $country_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_CITY])
				{
					$city_arr = $this->admin_model->get_table_row("manage_city", "name", array( "id"=>$users_dtls[CV_BA_NAME_CITY]), "id desc");
					$db_arr["city"] = $city_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_BUSINESS_LEVEL_1])
				{
					$bu_1_arr = $this->admin_model->get_table_row("manage_business_level_1", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_1]), "id desc");
					$db_arr["business_level_1"] = $bu_1_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_BUSINESS_LEVEL_2])
				{
					$bu_2_arr = $this->admin_model->get_table_row("manage_business_level_2", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_2]), "id desc");
					$db_arr["business_level_2"] = $bu_2_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_BUSINESS_LEVEL_3])
				{
					$bu_3_arr = $this->admin_model->get_table_row("manage_business_level_3", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_3]), "id desc");
					$db_arr["business_level_3"] = $bu_3_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_DESIGNATION])
				{
					$design_arr = $this->admin_model->get_table_row("manage_designation", "name", array( "id"=>$users_dtls[CV_BA_NAME_DESIGNATION]), "id desc");
					$db_arr["designation"] = $design_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_FUNCTION])
				{
					$function_arr = $this->admin_model->get_table_row("manage_function", "name", array( "id"=>$users_dtls[CV_BA_NAME_FUNCTION]), "id desc");
					$db_arr["function"] = $function_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_SUBFUNCTION])
				{
					$sub_function_arr = $this->admin_model->get_table_row("manage_subfunction", "name", array( "id"=>$users_dtls[CV_BA_NAME_SUBFUNCTION]), "id desc");
					$db_arr["sub_function"] = $sub_function_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_SUB_SUBFUNCTION])
				{
					$sub_sub_function_arr = $this->admin_model->get_table_row("manage_sub_subfunction", "name", array( "id"=>$users_dtls[CV_BA_NAME_SUB_SUBFUNCTION]), "id desc");
					$db_arr["sub_sub_function"] = $sub_sub_function_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_GRADE])
				{
					$grade_arr = $this->admin_model->get_table_row("manage_grade", "name", array( "id"=>$users_dtls[CV_BA_NAME_GRADE]), "id desc");
					$db_arr["grade"] = $grade_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_LEVEL])
				{
					$level_arr = $this->admin_model->get_table_row("manage_level", "name", array( "id"=>$users_dtls[CV_BA_NAME_LEVEL]), "id desc");
					$db_arr["level"] = $level_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_EDUCATION])
				{
					$education_arr = $this->admin_model->get_table_row("manage_education", "name", array( "id"=>$users_dtls[CV_BA_NAME_EDUCATION]), "id desc");
					$db_arr["education"] = $education_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_CRITICAL_TALENT])
				{
					$critical_talent_arr = $this->admin_model->get_table_row("manage_critical_talent", "name", array( "id"=>$users_dtls[CV_BA_NAME_CRITICAL_TALENT]), "id desc");
					$db_arr["critical_talent"] = $critical_talent_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_CRITICAL_POSITION])
				{
					$critical_position_arr = $this->admin_model->get_table_row("manage_critical_position", "name", array( "id"=>$users_dtls[CV_BA_NAME_CRITICAL_POSITION]), "id desc");
					$db_arr["critical_position"] = $critical_position_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_SPECIAL_CATEGORY])
				{
					$special_category_arr = $this->admin_model->get_table_row("manage_special_category", "name", array( "id"=>$users_dtls[CV_BA_NAME_SPECIAL_CATEGORY]), "id desc");
					$db_arr["special_category"] = $special_category_arr['name'];
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
				if($users_dtls[CV_BA_NAME_CURRENCY])
				{
					$currency_arr = $this->admin_model->get_table_row("manage_currency", "name", array( "id"=>$users_dtls[CV_BA_NAME_CURRENCY]), "id desc");
					$db_arr["currency"] = $currency_arr['name'];
				}
				if($users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY])
					$db_arr["current_base_salary"] = $users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY];									
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
				if($users_dtls[CV_BA_NAME_APPROVER_1])
				{
					$db_arr["approver_1"] = "";
					$approver_1 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_1]), "id desc");
					if($approver_1[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["approver_1"] = $approver_1[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_2])
				{
					$db_arr["approver_2"] = "";
					$approver_2 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_2]), "id desc");
					if($approver_2[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["approver_2"] = $approver_2[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_3])
				{
					$db_arr["approver_3"] = "";
					$approver_3 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_3]), "id desc");
					if($approver_3[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["approver_3"] = $approver_3[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_4])
				{
					$db_arr["approver_4"] = "";
					$approver_4 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_4]), "id desc");
					if($approver_4[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["approver_4"] = $approver_4[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_MANAGER_NAME])
				{
					$db_arr["manager_name"] = "";
					$manager_name = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_MANAGER_NAME]), "id desc");
					if($manager_name[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["manager_name"] = $manager_name[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
					$db_arr["authorised_signatory_for_letter"] = "";
					$authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
					if($authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["authorised_signatory_for_letter"] = $authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
					$db_arr["authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
					$db_arr["hr_authorised_signatory_for_letter"] = "";
					$hr_authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
					if($hr_authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME])
						$db_arr["hr_authorised_signatory_for_letter"] = $hr_authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
				}
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
					$db_arr["hr_authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
				$this->admin_model->insert_data_in_tbl("employee_bonus_details", $db_arr);
			}
		}
		
		$data['tbl_data'] = $str;
		$data['total_bonus_percentage'] = $total_bonus_percentage;
		$data['total_bonus_amt'] = $total_bonus_amt;
		$data['total_employee'] = $total_employee;
		return $data;
	}

	public function view_bonus_rule_details($rule_id)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		
		/*//Note :: Start :: Redirect on View SIP Rule ********************************
		if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
		{
			redirect(site_url("sip/view_sip_rule_details/".$rule_id));
		}
		//Note :: End :: Redirect on View SIP Rule *********************************/
		
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}
		$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$data['rule_dtls']["performance_cycle_id"]));

		$is_enable_approve_btn = 0; // No		
		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>3));
		if($request_dtl)
		{
			if(helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
			{
				$is_enable_approve_btn = 1; //Yes
			}			
		}
		$data['is_enable_approve_btn'] = $is_enable_approve_btn;
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("id"=>$data['rule_dtls']["to_currency_id"]));
		
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
		
		if($country_arr_view)
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 AND id IN (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 AND id IN (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		

		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 AND id IN(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}

		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 AND id IN(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}

		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 AND id IN(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}

		if($designation_arr_view)
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 AND id in(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}

		if($function_arr_view)
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 AND id IN(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}

		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 AND id IN(".$sub_function_arr_view.")", "name asc");
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
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 AND id IN(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}
		if($level_arr_view)
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 AND id IN(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}
/************* Above code is used only for showing rule filter on view End ***********/
		
		$data["bonus_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
		$data['title'] = "View Bonus Rule Details";
		$data['body'] = "view_bonus_rule_details";
		$this->load->view('common/structure',$data);
	}

	public function send_bonus_rule_approval_request($rule_id, $send_for_release=0)
	{
		// Note :: $send_for_release => 1=Need to send rule to release, other than 1 no need to send for release
		$rule_dtls = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		// echo '<pre>';
		// print_r($rule_dtls);
		// exit;
		if(!$rule_dtls or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}

		$this->calculate_bonus($rule_id, 1, $send_for_release);
		
		if($send_for_release == 1)
		{			
			$this->bonus_model->updateBonusRules(array("status"=>6, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s")), array('id'=>$rule_id));	
			
			if($rule_dtls["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
			{
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule sent for release successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_LABEL_NAME.' rule sent for release successfully.</b></div>');
			}
		}
		else
		{
			$this->approvel_model->create_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"), 3);
			$this->bonus_model->updateBonusRules(array("status"=>4, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s")), array('id'=>$rule_id));	
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule sent for approval successfully.</b></div>');
		}
		redirect(site_url("view-bonus-rule-details/".$rule_id));
	}
	
	public function delete_bonus_rule($rule_id)
	{
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		//if($data['rule_dtls']  and ($data['rule_dtls']["status"] < 4 or $data['rule_dtls']["status"] == 5))
		if($data['rule_dtls']  and ($data['rule_dtls']["status"] < CV_STATUS_RULE_DELETED))
		{
			if(!helper_have_rights(CV_BONUS_RULES_ID, CV_DELETE_RIGHT_NAME))
			{
				redirect(site_url("bonus-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
			}
			
			$db_arr = array("status"=>CV_STATUS_RULE_DELETED, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s"));
			$this->bonus_model->updateBonusRules($db_arr, array('id'=>$rule_id));
			$this->bonus_model->delete_emp_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id));
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule deleted successfully.</b></div>');
			redirect(site_url("bonus-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}
	
}