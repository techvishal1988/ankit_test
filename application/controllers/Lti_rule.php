<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lti_rule extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');	
		$this->load->model("lti_rule_model");
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

    public function lti_rule_filters($performance_cycle_id, $rule_id=0)
	{
		$data["msg"] = "";
		if(!helper_have_rights(CV_LTI_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';
		}
		$is_need_update = 0;//1=Yes,0=No
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->lti_rule_model->get_table_row("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		
		if(!$data['right_dtls'])
		{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your right for criteria not set yet. Please contact your admin.</b></span></div>');
			redirect(site_url("lti-rule-list/".$performance_cycle_id));
		}

		$data['performance_cycle_dtls'] = $this->lti_rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));
		
		if(!$data['performance_cycle_dtls'])
		{
			redirect(site_url("performance-cycle"));
		}

		if($rule_id)
		{
			$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
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
		$data['education_list'] = $this->common_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->common_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->common_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->common_model->get_table("manage_special_category","id, name", "status = 1", "name asc");

		if($this->input->post())
		{
			if(!$this->input->post("hf_select_all_filters"))
			{
				if(!helper_have_rights(CV_LTI_RULES_ID, CV_INSERT_RIGHT_NAME))
				{
					redirect(site_url("lti-rule-list/".$performance_cycle_id));
				}
				
				$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED);
				if($is_need_update > 0 and $rule_id > 0)
				{
					$condit_arr["lti_rules.id !="] = $rule_id;
				}
				//$already_created_rule_for_emp_arr = $this->common_model->get_table("lti_rules","user_ids", $condit_arr);
				$already_created_rule_for_emp_arr = $this->lti_rule_model->get_all_emp_ids_for_a_lti_cycle($condit_arr);
	
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
	
				if(in_array('all', $this->input->post("ddl_tenure_company")))
				{
					$temp_arr = array();
					for($i=0; $i<=35; $i++)
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
					for($i=0; $i<=35; $i++)
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
				$data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
				if(!$data['employees'])
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></span></div>');
					if($rule_id)
					{
						redirect(site_url("lti-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("lti-rule-filters/".$performance_cycle_id));
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
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></span></div>');
					if($rule_id)
					{
						redirect(site_url("lti-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("lti-rule-filters/".$performance_cycle_id));
					}
				}
				
				$usr_ids = implode(",",$user_ids_arr);
				$db_arr = array(
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
								"updatedby" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedon" => date("Y-m-d H:i:s")
								);
				$db_arr['sub_subfunctions'] = "";
				$db_arr['sub_subfunctions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_subfunction_arr, CV_BA_NAME_SUB_SUBFUNCTION);
				
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
						$this->lti_rule_model->update_rules(array("id"=>$rule_id), $db_arr); 
					}
					else
					{
						$db_arr["status"] = 1;
						$db_arr["createdby"] = $this->session->userdata('userid_ses');
						$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
						$db_arr["createdon"] = date("Y-m-d H:i:s");					
						$rule_id = $this->lti_rule_model->insert_rules($db_arr);
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
							$this->rule_model->delete_emps_frm_rule_dtls("lti_rule_users_dtls", array("rule_id"=>$rule_id));
							$this->rule_model->insert_data_as_batch("lti_rule_users_dtls", $db_rule_usr_ids_arr);
						}
						
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have '.count($user_ids_arr).' employees for this rule.</b></div>'); 
						redirect(site_url("create-lti-rules/".$rule_id));	
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></div>'); 
						if($rule_id)
						{
							redirect(site_url("lti-rule-filters/".$performance_cycle_id."/".$rule_id));
						}
						else
						{
							redirect(site_url("lti-rule-filters/".$performance_cycle_id));
						}						
					}
				}
			}
		}
		
		if($country_arr_view)
		{
			$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1 AND id IN (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1 AND id IN (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		

		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1 AND id IN(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}

		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1 AND id IN(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}

		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1 AND id IN(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}

		if($designation_arr_view)
		{
			$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1 AND id IN(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}

		if($function_arr_view)
		{
			$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1 AND id IN(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}

		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1 AND id IN(".$sub_function_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
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
			$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1 AND id IN(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}
		
		if($level_arr_view)
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 AND id IN(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}
		
		$data['rule_list_pg_url'] = site_url("lti-rule-list/".$data['performance_cycle_dtls']['id']);
		$data['tooltip'] = getToolTip('lti-rule-page-1');		
		
		$data['title'] = "LTI Rule Filters";
		$data['body'] = "salary_rule_filters";
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
		
		$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED);
		//$already_created_rule_for_emp_arr = $this->common_model->get_table("lti_rules","user_ids", $condit_arr);
		$already_created_rule_for_emp_arr = $this->lti_rule_model->get_all_emp_ids_for_a_lti_cycle($condit_arr);

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
	
	public function create_lti_rules($rule_id)
	{
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id, "lti_rules.createdby"=>$this->session->userdata('userid_ses'), "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] >= 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		if(!helper_have_rights(CV_LTI_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			redirect(site_url("lti-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}

		$data["emp_not_any_cycle_counts"] = $this->emp_not_any_cycle($data['rule_dtls']["performance_cycle_id"]);
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");

		$data['title'] = "Create LTI Rules";
		$data['body'] = "create_lti_rules";
		$this->load->view('common/structure',$data);
	}
	
	public function save_lti_rule($rule_id=0, $step=0)
	{
		if($step>0 and $rule_id > 0)
		{
			$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
			if(!$data['rule_dtls'] or $data['rule_dtls']["status"] > 4)//Set for approval yet or Approved
			{
				echo "";die;
			}	

			if($step==1)
			{	
				if(!$this->input->post("hf_show_next_step"))	
				{							
					$step1_db_arr = array(
								'rule_name' => $this->input->post("txt_rule_name"),
								'applied_on_elements' => "",
								'lti_basis_on' => $this->input->post("ddl_lti_basis_on"),
								'lti_linked_with' => $this->input->post("ddl_lti_linked_with"),
								'target_lti_on ' => $this->input->post("ddl_target_lti_on"),
								'target_lti_elem' =>"",
								'target_lti_dtls' =>"",	
								'budget_type' =>"",
								'budget_dtls' =>"",							
								'manager_discretionary_increase' => $this->input->post("txt_manager_discretionary_increase"),
								'manager_discretionary_decrease' => $this->input->post("txt_manager_discretionary_decrease"),
								"updatedby" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							    "updatedon" => date("Y-m-d H:i:s"),
								'status' => 2);
					if($this->input->post("ddl_lti_basis_on")=='1')
					{
						$step1_db_arr['applied_on_elements'] = implode(",",$this->input->post("ddl_salary_elements"));
					}

					$this->lti_rule_model->update_rules(array('id'=>$rule_id),$step1_db_arr);
				}
				echo true; die;
			}
			elseif($step==2)
			{
				if(!$this->input->post("hf_show_next_step"))	
				{
					$target_lti_elem_arr = $_REQUEST['hf_target_lti_elem'];
					
					$target_lti_dtls_arr[] = array("grant_value_arr"=>$_REQUEST['txt_grant_val']);
					$target_lti_dtls_arr[] = array("vesting_1_arr"=>$_REQUEST['txt_vesting_val_1']);
					$target_lti_dtls_arr[] = array("vesting_2_arr"=>$_REQUEST['txt_vesting_val_2']);
					$target_lti_dtls_arr[] = array("vesting_3_arr"=>$_REQUEST['txt_vesting_val_3']);
					$target_lti_dtls_arr[] = array("vesting_4_arr"=>$_REQUEST['txt_vesting_val_4']);
					$target_lti_dtls_arr[] = array("vesting_5_arr"=>$_REQUEST['txt_vesting_val_5']);
					$target_lti_dtls_arr[] = array("vesting_6_arr"=>$_REQUEST['txt_vesting_val_6']);
					$target_lti_dtls_arr[] = array("vesting_7_arr"=>$_REQUEST['txt_vesting_val_7']);
					
					$step2_db_arr = array(
									'vesting_date_dtls'=>json_encode($this->input->post('txt_vesting_date')),
									'target_lti_elem' => json_encode($target_lti_elem_arr),							
									'target_lti_dtls' =>json_encode($target_lti_dtls_arr),
									"updatedby" => $this->session->userdata('userid_ses'),
									"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
									"updatedon" => date("Y-m-d H:i:s")
									);
		
					$this->lti_rule_model->update_rules(array('id'=>$rule_id),$step2_db_arr);
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
					/*elseif($this->input->post("ddl_overall_budget")=="Manual")
					{
						$budget_amount = $_REQUEST['txt_manual_budget_amt'][$key];
					}*/
					$manual_budget_dtls[] = array($value, $budget_amount, $budget_percent, $pre_calculated_budgt);
				}
				
				$step3_db_arr = array(								
								'budget_type' => $this->input->post("ddl_overall_budget"),
								'to_currency_id' => $this->input->post("ddl_to_currency"),
								'budget_dtls' => json_encode($manual_budget_dtls),
								"updatedby" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							    "updatedon" => date("Y-m-d H:i:s"),
								'status' => 3);
				$this->lti_rule_model->update_rules(array("id"=>$rule_id), $step3_db_arr);				
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule created successfully.</b></div>'); 
				echo 3; die;
			}			
		}
	}
	
	public function get_rule_step2_frm($rule_id)
	{
		$data["target_lti_elements"] = "";
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}
		
		$elements_for = $data["rule_dtls"]["target_lti_on"];
		$tbl_name = "";
		$cnd_str = " status = 1 ";
		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
		{
			$tbl_name = "manage_".$elements_for;
			if($elements_for == "designation")
			{
				$tbl_name = "manage_".$elements_for;
				$cnd_str .= " AND id IN (".$data['rule_dtls']["designations"].")"; 
			}
			elseif($elements_for == "grade")
			{
				$tbl_name = "manage_".$elements_for;
				$cnd_str .= " AND id IN (".$data['rule_dtls']["grades"].")";
			}
			else
			{
				$cnd_str .= " AND id IN (".$data['rule_dtls']["levels"].")";
			}
		}
			
		if($tbl_name)
		{
			$data["target_lti_elements"] = $this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");	
		}	
		$this->load->view('create_lti_rule_partial',$data);		
	}	

	public function get_rule_step3_frm($rule_id)
	{
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}	
		$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));	
		$this->load->view('create_lti_rules_partial_for_manager_dtls',$data);		
	}
	
	public function get_managers_for_manual_bdgt($is_view_only=0)
	{
		$budget_type = $this->input->post("budget_type");
		$rule_id = $this->input->post("rid");
		$to_currency_id = $this->input->post("to_currency");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"]=$this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $rule_id);
	
			if($managers)
			{
				$str_main = '<div class="table-responsive"><table class="tablecustm table table-bordered"><thead>';
                $str_main .= '<tr>';

                $str_main .= '<th>Manager Name</th><th>Number of Employees</th><th>Base for LTI</th><th>Budget as per the plan</th>';
				$colspn = '';
                
	            if($budget_type == "Automated but x% can exceed") 
                {
	                $str_main .= '<th>Additional budget</br> (as %age of the allocated budget)</th>';  
	                $str_main .= '<th>Additional Budget (as amount of the allocated budget)</th>';  
	            }
				$str_main .= '<th>Revised Budget</th><th>% Increased</th>';
                $str_main .= '</tr>';  
                $t=0;
                $tEmp=0;
                $tsal=0;
				$i=1;
				$str = "";
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
	              	$t=$t+$manager_budget;
					$tEmp=$tEmp+$manager_emp_budget_dtls["total_emps"];
					$tsal=$tsal+$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];
	              	$str .= '</td><td style="text-align:center;">'.$manager_emp_budget_dtls["total_emps"].'</td><td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]).'</td><td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_budget).'
	              			<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" id="hf_pre_calculated_budgt_'.$i.'"/>
							<input type="hidden" value="'.$manager_actual_budget.'" name="hf_pre_calculated_budgt_actual[]"/>
							<input type="hidden" value="'.$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"].'" id="hf_incremental_amt_'.$i.'" />
	              			<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

					if($is_view_only)
					{					   
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td class="txtalignright"><ravi id="dv_x_per_budget_'.$i.'"></ravi> %</td>';
						}
					}
					else
					{					   
						if($budget_type == "Automated but x% can exceed") 
						{
							$str .= '<td><div style="position:relative;"><input type="text" style="padding-top:8px !important;" class="form-control text-right addpersen" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value="0"  maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" required="required" onChange="calculat_percent_increased_val(2,this.value, '.$i.')"><span></span></div></td>';
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
				
				$str_main .='<tr class="tablealign"><th style="text-align: center;" ><input type="hidden" value="'.$i.'" id="hf_manager_cnt"/><label>Total&nbsp;</label></th>'
                                        . '<th style="text-align: center;">'.$tEmp.'</th><th style="text-align: right !important;"><input type="hidden" value="'.round($tsal).'" id="hf_total_base_lti"/>'.$manager_emp_budget_dtls['currency']['currency_type'].'&nbsp;'.HLP_get_formated_amount_common(round($tsal)).'</th>'
                                        . '<th style="text-align: right !important;">'.$manager_emp_budget_dtls['currency']['currency_type'].'&nbsp;<ravi id="th_total_budget_plan">'.HLP_get_formated_amount_common(round($t)).'</ravi></th>';
				
				if($budget_type == "Automated but x% can exceed") 
				{
					$str_main .='<th style="text-align: right !important;">'.$manager_emp_budget_dtls['currency']['currency_type'].'&nbsp;<ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common(round($t)).'</ravi></th>'; 
					$str_main .= '<th style="text-align: right !important;"> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_additional_budget_manual">'.HLP_get_formated_amount_common(0).'</ravi></th>'; 
				}
				
				$str_main .=$colspn.'<th style="text-align: right !important;">'.$manager_emp_budget_dtls['currency']['currency_type'].'&nbsp;<ravi id="th_total_budget">'.HLP_get_formated_amount_common(round($t)).'</ravi></th>';
				$str_main .= '<th style="text-align: right !important;" id="th_final_per">'.HLP_get_formated_percentage_common(($t/$tsal)*100,2)
                                        . ' %</th></tr></thead><tbody>';
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
		$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		
		$total_max_budget = 0;
		$manager_actual_budget = 0;
		$managers_emps_tot_incremental_amt = 0;
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
		return array("total_emps"=>count($managers_emp_arr), "budget"=>$total_max_budget, "managers_emps_tot_incremental_amt"=>$managers_emps_tot_incremental_amt,"currency"=>$currency, "manager_actual_budget"=>$manager_actual_budget);
	}
	
	public function calculate_lti_emploee_wise($employee_id, $rule_dtls, $users_dtls)
	{	
		//$business_attribute_id=0;
		$current_emp_incentive = 0;
		$emp_incremental_amt = 0;
		$grant_value = 0;
		$stock_share_price = 0;

		/*if($rule_dtls['target_lti_on'] == CV_DESIGNATION)
		{
			$business_attribute_id = CV_DESIGNATION_ID;
		}
		elseif($rule_dtls['target_lti_on'] == CV_GRADE)
		{
			$business_attribute_id = CV_GRADE_ID;
		}
		elseif($rule_dtls['target_lti_on'] == CV_LEVEL)
		{
			$business_attribute_id = CV_LEVEL_ID;
		}*/
		
		//$emp_target_lti_on_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$business_attribute_id));
		$emp_target_lti_on_val = $users_dtls[$rule_dtls['target_lti_on']];//$emp_target_lti_on_arr['value'];
		
		$target_lti_elem_arr = json_decode($rule_dtls["target_lti_elem"],true);
		$target_lti_dtls_arr = json_decode($rule_dtls["target_lti_dtls"],true);

		foreach ($target_lti_elem_arr as $key => $value) 
		{
			$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
			if(($emp_target_lti_on_val) and strtoupper($val_arr[0]) == strtoupper($emp_target_lti_on_val))
			{
				if($rule_dtls["lti_basis_on"]==2)// Fixed Amount condition
				{
					//Note :: No need to grant value in fixed case (lti_basis_on is fixed amount type)
					if($rule_dtls["lti_linked_with"]==CV_LTI_LINK_WITH_STOCK)
					{							
						$emp_incremental_amt = $target_lti_dtls_arr[0]["grant_value_arr"][$key+1];// Get Fixed Amount of Emp
						$stock_share_price = $target_lti_dtls_arr[0]["grant_value_arr"][0];//Get current share price							
						//$current_emp_incentive = round($emp_incremental_amt/$stock_share_price);//Total no of shares getting for the employee
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
					//$increment_applied_on_arr = $this->rule_model->get_salary_applied_on_elements_val($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], $rule_dtls["applied_on_elements"]);
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
						$stock_share_price = $target_lti_dtls_arr[0]["grant_value_arr"][0];//Get current share price							
						//$current_emp_incentive = round((($emp_tot_salary*$grant_value)/100)/$stock_share_price);//Total no of shares getting for the employee
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
	
	public function calculate_increments($rule_id, $is_need_to_save_data=0, $send_for_release=0)
	{	
		// $is_need_to_save_data = 0 (No) and 1 (Yes)
		$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}	
		$managers_budget_dtls = array();
		
		$data['total_max_budget'] = 0;
		$managers_arr = json_decode($rule_dtls['budget_dtls'],true);
		foreach($managers_arr as $key => $value)
		{
			if($rule_dtls["budget_type"] != "No limit")	
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
			
			$managers_budget_dtls[$key]["manager_emp_arr"] = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$value[0]."'");
			$managers_budget_dtls[$key]["bdgt_x_per_exceed_val"] = $value[2];
		}			

		$all_emp_total_salary = 0;
		//$staff_list = explode(",",$rule_dtls['user_ids']);
		$staff_list = $this->rule_model->get_table("lti_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");
		
		foreach($staff_list as $row)
		{
			$employee_id = $row["user_id"];
			$business_attribute_id=0;
			$current_emp_incentive = 0;
			$grant_value = 0;
			$stock_share_price = 0;
			
			//$users_last_tuple_dtls = $this->lti_rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
			$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
			
			$emp_lti_dtls = $this->calculate_lti_emploee_wise($employee_id, $rule_dtls, $users_dtls);
			//$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, );
			//$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_lti_dtls["emp_incremental_amt"]);	
			
			$current_emp_incentive = $emp_lti_dtls["current_emp_incentive"];
			$grant_value = $emp_lti_dtls["grant_value"];
			
			$all_emp_total_salary += $current_emp_incentive;
			$manager_emailid = "";
			$bdgt_x_per_exceed_val = 0;
			foreach($managers_budget_dtls as $emp_key => $emp_arr)
			{
				if(in_array($employee_id, $emp_arr["manager_emp_arr"]))
				{
					$manager_emailid = $managers_budget_dtls[$emp_key]["manager_email"];
					$managers_budget_dtls[$emp_key]["manager_employee_tot_incr_salary"] =  $managers_budget_dtls[$emp_key]["manager_employee_tot_incr_salary"] + $current_emp_incentive;
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
				
				$emp_final_bdgt = $current_emp_incentive;
				if($rule_dtls["budget_type"] == "No limit")	
				{
					$emp_final_bdgt = 0;// No limit set for budget
				}
				elseif($rule_dtls["budget_type"] == "Automated but x% can exceed")
				{
					$emp_final_bdgt += round((($emp_final_bdgt*$bdgt_x_per_exceed_val)/100), 2); 
				}
				
				//$emp_dtls = $this->admin_model->get_table_row("login_user", "login_user.tenure_company, login_user.tenure_role", array( "id"=>$employee_id), "id desc");
				//$emp_datum_dtls = $this->common_model->get_employee_dtls_by_datum_tbl(array("datum.data_upload_id"=>$users_last_tuple_dtls["data_upload_id"], "datum.row_num"=>$users_last_tuple_dtls["row_num"]));
				$db_arr =array(
							"rule_id" => $rule_id,
							"user_id" => $employee_id,	
							"emp_final_bdgt" => $emp_final_bdgt,						
							"grant_value" => $grant_value,
							//"stock_share_price" => $stock_share_price,
							"final_incentive" => $current_emp_incentive,
							"actual_incentive" => $current_emp_incentive,
							"manager_emailid" => $manager_emailid,
							"last_action_by" => $manager_emailid,
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
				//Newly code by ravi on 11-05-18 End
				$this->lti_rule_model->insert_emp_lti_dtls($db_arr);
			}
		}
		
		return array("total_max_budget" => $data['total_max_budget'], "all_emp_total_salary" => $all_emp_total_salary, "managers_budget_dtls" => $managers_budget_dtls);
	}
	
	public function send_lti_rule_approval_request($rule_id, $send_for_release=0)
	{
		// Note :: $send_for_release => 1=Need to send rule to release, other than 1 no need to send for release
		$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}	

		$this->calculate_increments($rule_id, 1, $send_for_release);// Insert emp wise lti rule details
		 
		if($send_for_release == 1)
		{			
			$this->lti_rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule sent for release successfully.</b></div>');
		}
		else
		{
			$this->approvel_model->create_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"), 4);
			$this->lti_rule_model->update_rules(array('id'=>$rule_id),array("status"=>4, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule sent for approval successfully.</b></div>');
		}
		
		redirect(site_url("view-lti-rule-details/".$rule_id));
	}

	public function view_lti_rule_details($rule_id)
	{
		$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}	
	
		$is_enable_approve_btn = 0; // No
		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>4));
		if($request_dtl)
		{
			if(helper_have_rights(CV_APPROVE_LTI, CV_UPDATE_RIGHT_NAME))
			{
				$is_enable_approve_btn = 1; //Yes
			}
		}
		$data["target_lti_elements"] = json_decode($data["rule_dtls"]["target_lti_elem"], true);
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
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

		$data['is_enable_approve_btn'] = $is_enable_approve_btn;			
		$data['title'] = "View LTI Rule Details";
		$data['body'] = "view_lti_rule_details";
		$this->load->view('common/structure',$data);
	}

	public function delete_lti_rule($rule_id)
	{
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		//if($data['rule_dtls'] and ($data['rule_dtls']["status"] < 4 or $data['rule_dtls']["status"] == 5))
		if($data['rule_dtls'] and ($data['rule_dtls']["status"] < CV_STATUS_RULE_DELETED))
		{
			if(!helper_have_rights(CV_LTI_RULES_ID, CV_DELETE_RIGHT_NAME))
			{
				redirect(site_url("lti-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
			}
			
			$db_arr = array("status"=>CV_STATUS_RULE_DELETED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
			$this->lti_rule_model->update_rules(array("id"=>$rule_id), $db_arr);
			$this->lti_rule_model->delete_emp_salary_dtls(array("employee_lti_details.rule_id"=>$rule_id));
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule deleted successfully.</b></div>');
			redirect(site_url("lti-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}
	
	public function edit_lti_stock_value_of_vestings($rule_id)
	{
		$data["target_lti_elements"] = "";
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] != CV_STATUS_RULE_RELEASED or $rule_id < 0 or $data['rule_dtls']["lti_linked_with"] != CV_LTI_LINK_WITH_STOCK)
		{
			redirect(site_url("dashboard"));
		}
		
		$elements_for = $data["rule_dtls"]["target_lti_on"];
		$tbl_name = "";
		$cnd_str = " status = 1 ";
		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
		{
			$tbl_name = "manage_".$elements_for;
			if($elements_for == "designation")
			{
				$tbl_name = "manage_".$elements_for;
				$cnd_str .= " AND id IN (".$data['rule_dtls']["designations"].")"; 
			}
			elseif($elements_for == "grade")
			{
				$tbl_name = "manage_".$elements_for;
				$cnd_str .= " AND id IN (".$data['rule_dtls']["grades"].")";
			}
		}
			
		if($tbl_name)
		{
			$data["target_lti_elements"] = $this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");	
		}
		
		
		if($this->input->post("txt_grant_val") > 0 and $this->input->post("txt_vesting_val_1") > 0 and $data['rule_dtls']["target_lti_dtls"] != "")	
		{		
			$target_lti_dtls = json_decode($data['rule_dtls']["target_lti_dtls"], true);
			
			$target_lti_dtls[0]["grant_value_arr"][0] = $this->input->post("txt_grant_val");
			$target_lti_dtls[1]["vesting_1_arr"][0] = $this->input->post("txt_vesting_val_1");
			$target_lti_dtls[2]["vesting_2_arr"][0] = $this->input->post("txt_vesting_val_2");
			$target_lti_dtls[3]["vesting_3_arr"][0] = $this->input->post("txt_vesting_val_3");
			$target_lti_dtls[4]["vesting_4_arr"][0] = $this->input->post("txt_vesting_val_4");
			$target_lti_dtls[5]["vesting_5_arr"][0] = $this->input->post("txt_vesting_val_5");
			$target_lti_dtls[6]["vesting_6_arr"][0] = $this->input->post("txt_vesting_val_6");
			$target_lti_dtls[7]["vesting_7_arr"][0] = $this->input->post("txt_vesting_val_7");
			//echo "<pre>";print_r($target_lti_dtls);die;	
			$step2_db_arr = array(						
							'target_lti_dtls' =>json_encode($target_lti_dtls),
							"updatedby" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedon" => date("Y-m-d H:i:s")
							);
			$this->lti_rule_model->update_rules(array('id'=>$rule_id),$step2_db_arr);
			$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data updated successfully.</b></div>');
			redirect(site_url("lti_rule/edit_lti_stock_value_of_vestings/".$rule_id));
		}

		$data['title'] = "Edit LTI Stock Value Of Vestings";
		$data['body'] = "edit_lti_stock_value_of_vestings";
		$this->load->view('common/structure',$data);		
	}


}
