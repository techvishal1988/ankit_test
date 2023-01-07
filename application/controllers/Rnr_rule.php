<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rnr_rule extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');	
		$this->load->model("rnr_rule_model");
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

    public function rnr_rule_filters($performance_cycle_id, $rule_id=0)
	{
		$data["msg"] = "";
		if(!helper_have_rights(CV_RNR_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';
		}
		$is_need_update = 0;//1=Yes,0=No
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->rnr_rule_model->get_table_row("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		
		if(!$data['right_dtls'])
		{
			$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your right for criteria not set yet. Please contact your admin.</b></div>');
			redirect(site_url("rnr-rule-list/".$performance_cycle_id));
		}

		$data['performance_cycle_dtls'] = $this->rnr_rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));
		
		if(!$data['performance_cycle_dtls'])
		{
			redirect(site_url("performance-cycle"));
		}

		if($rule_id)
		{
			$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
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
				if(!helper_have_rights(CV_RNR_RULES_ID, CV_INSERT_RIGHT_NAME))
				{
					redirect(site_url("rnr-rule-list/".$performance_cycle_id));
				}
				
				$condit_arr = array("performance_cycle_id" => $performance_cycle_id);
				if($is_need_update > 0 and $rule_id > 0)
				{
					$condit_arr["rnr_rules.id !="] = $rule_id;
				}
				//$already_created_rule_for_emp_arr = $this->common_model->get_table("rnr_rules","user_ids", $condit_arr);
				$already_created_rule_for_emp_arr = $this->rnr_rule_model->get_all_emp_ids_for_a_rnr_cycle($condit_arr);
	
				//CB:: Because we have no need to check duplicate emps in a cycle for a rules
				/*$already_created_rule_for_emp_ids = array();
				foreach($already_created_rule_for_emp_arr as $row)
				{
					$already_created_rule_for_emp_ids[] = $row["user_id"];
				}*/
	
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
	
				//CB:: Because we have no need to check duplicate emps in a cycle for a rules
				/*if($already_created_rule_for_emp_ids)
				{
					$where .= " AND login_user.id NOT IN (".implode(",",$already_created_rule_for_emp_ids).")";
				}*/
	
				$user_ids_arr = array();
				$data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
				if(!$data['employees'])
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');
					if($rule_id)
					{
						redirect(site_url("rnr-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("rnr-rule-filters/".$performance_cycle_id));
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
						redirect(site_url("rnr-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("rnr-rule-filters/".$performance_cycle_id));
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
						$this->rnr_rule_model->update_rules(array("id"=>$rule_id), $db_arr); 
					}
					else
					{
						$db_arr["status"] = 1;
						$db_arr["createdby"] = $this->session->userdata('userid_ses');
						$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
						$db_arr["createdon"] = date("Y-m-d H:i:s");						
						$rule_id = $this->rnr_rule_model->insert_rules($db_arr);
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
							$this->rule_model->delete_emps_frm_rule_dtls("rnr_rule_users_dtls", array("rule_id"=>$rule_id));
							$this->rule_model->insert_data_as_batch("rnr_rule_users_dtls", $db_rule_usr_ids_arr);
						}
						
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have '.count($user_ids_arr).' employees for this rule.</b></div>'); 
						redirect(site_url("create-rnr-rules/".$rule_id));	
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></div>');
						if($rule_id)
						{
							redirect(site_url("rnr-rule-filters/".$performance_cycle_id."/".$rule_id));
						}
						else
						{
							redirect(site_url("rnr-rule-filters/".$performance_cycle_id));
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
		
		$data['rule_list_pg_url'] = site_url("rnr-rule-list/".$data['performance_cycle_dtls']['id']);
		$data['tooltip'] = getToolTip('rnr-rule-page-1');	
		
		$data['title'] = "R and R Rule Filters";
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
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		
		$condit_arr = array("performance_cycle_id" => $performance_cycle_id);
		//$already_created_rule_for_emp_arr = $this->common_model->get_table("rnr_rules","user_ids", $condit_arr);
		$already_created_rule_for_emp_arr = $this->rnr_rule_model->get_all_emp_ids_for_a_rnr_cycle($condit_arr);

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
			$data['title'] = "Staffs";
			$data['body'] = "not_any_cycle_staff_list";
			$this->load->view('common/structure',$data);
		}
		else
		{
			return count($employees);
		}
	}
	
	public function create_rnr_rules($rule_id)
	{
		$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id, "rnr_rules.createdby"=>$this->session->userdata('userid_ses'), "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] >= 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		if(!helper_have_rights(CV_RNR_RULES_ID, CV_INSERT_RIGHT_NAME))
		{
			redirect(site_url("rnr-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}

		$data["emp_not_any_cycle_counts"] = $this->emp_not_any_cycle($data['rule_dtls']["performance_cycle_id"]);		
		$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM rnr_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));
		$data['title'] = "Create R and R Rules";
		$data['body'] = "create_rnr_rules";
		$this->load->view('common/structure',$data);
	}
	
	public function save_rnr_rule($rule_id=0)
	{
		if($this->input->post())
		{
			$data["rule_dtls"] =$this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
			if(!$data['rule_dtls'] or $data['rule_dtls']["status"] > 4)//Set for approval yet or Approved
			{
				redirect(site_url("performance-cycle"));
			}	

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
				elseif($this->input->post("ddl_overall_budget")=="Manual")
				{
					$budget_amount = $_REQUEST['txt_manual_budget_amt'][$key];
				}
				$manual_budget_dtls[] = array($value, $budget_amount, $budget_percent, $pre_calculated_budgt);
			}
								
			$db_arr = array(
						'rule_name' => $this->input->post("txt_rule_name"),
						'category' => $this->input->post("txt_category"),
						'criteria' => $this->input->post("txt_criteria"),
						'award_type' => $this->input->post("ddl_award_type"),
						'award_value' => $this->input->post("txt_award_value"),
						'award_frequency' => $this->input->post("txt_award_frequency"),
						'emp_frequency_for_award' => $this->input->post("txt_emp_frequency_for_award"),	
						'is_approval_required' => $this->input->post("ddl_is_approval_required"),
						'budget_type' => $budgt_type,
						'to_currency_id' => $this->input->post("ddl_to_currency"),
						'budget_dtls' => json_encode($manual_budget_dtls),
						"updatedby" => $this->session->userdata('userid_ses'),
						"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
						"updatedon" => date("Y-m-d H:i:s"),
						'status' => 3);
			if($this->input->post("ddl_award_type")==3 or $this->input->post("ddl_award_type")==4)
			{
				$db_arr['award_value'] = 0;
			}
			
			if($this->input->post("btn_save_rule") == "Submit & Send For Approval")
			{
				$db_arr['status'] = 4;
				$this->rnr_rule_model->update_rules(array('id'=>$rule_id),$db_arr);
				
				$this->approvel_model->create_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"), 5);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule sent for approval successfully.</b></div>'); 
				redirect(site_url("create-rnr-rules/".$rule_id));
			}
			else
			{
				$this->rnr_rule_model->update_rules(array('id'=>$rule_id),$db_arr);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data saved successfully.</b></div>'); 
			}
			
			redirect(site_url("create-rnr-rules/".$rule_id));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}
	
	public function get_managers_for_manual_bdgt()
	{
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$rule_id = $this->input->post("rid");
		$award_val = $this->input->post("award_val");
		$award_fr_val = $this->input->post("award_fr_val");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] =$this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("rnr_rule_users_dtls", $rule_id);

			if($managers)
			{
				$str = '<table class="table tablecustm table-bordered">';
                $str .= '<thead><tr>';
                $str .= '<th>Manager Name</th><th>Calculated budget as per rule</th>'; 
	            if($budget_type == "Automated but x% can exceed") 
                {
	                $str .= '<th>Percentage</th>';  
	            }
                $str .= '</tr></thead><tbody>';  
                 $t=0;
				foreach ($managers as $row)
				{
					$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM rnr_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$row['first_approver']."'");
					
					$manager_budget = 0;
					$manager_actual_budget = $award_val*$award_fr_val * count($managers_emp_arr);
					foreach($managers_emp_arr as $manager_emp_id)
					{						
						$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$manager_emp_id));
						$from_currency_id = $currency_arr["id"];
						$manager_budget += HLP_convert_currency($from_currency_id, $to_currency_id, ($award_val*$award_fr_val));					}
					
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
	              	$str .= '</td><td class="txtalignright">'.$to_currency_dtls["name"].' '.HLP_get_formated_amount_common($manager_budget).'
	              			<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" />
							<input type="hidden" value="'.$manager_actual_budget.'" name="hf_pre_calculated_budgt_actual[]"/>
	              			<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

			        if($budget_type == "Automated but x% can exceed") 
	                {
		                $str .= '<td><div style="position:relative;"><input type="text" class="form-control text-right addpersen" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value="0"  maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" required="required"><span></span></div></td>';
		            }
			        $str .= '</tr>';
				}
                
				$str.='<tr><th style="text-align: right;" colspan=1>Total</th><th class="txtalignright">'.$to_currency_dtls["name"].' '.HLP_get_formated_amount_common($t).'</th></tr>';
				$str .= '</tbody></table>'; 
				echo $str;
			}
			else
			{
				echo "";
			}
		}
	}

	public function view_rnr_rule_details($rule_id)
	{
		$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}	
	
		$is_enable_approve_btn = 0; // No
		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>5));
		if($request_dtl)
		{
			if(helper_have_rights(CV_APPROVE_RNR, CV_UPDATE_RIGHT_NAME))
			{
				$is_enable_approve_btn = 1; //Yes
			}
		}
				
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
		$data['title'] = "View R and R Rule Details";
		$data['body'] = "view_rnr_rule_details";
		$this->load->view('common/structure',$data);
	}

	public function delete_rnr_rule($rule_id)
	{
		$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
		if($data['rule_dtls'] and ($data['rule_dtls']["status"] < 4 or $data['rule_dtls']["status"] == 5))
		{
			if(!helper_have_rights(CV_RNR_RULES_ID, CV_DELETE_RIGHT_NAME))
			{
				redirect(site_url("rnr-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
			}
			
			$db_arr = array("status"=>CV_STATUS_RULE_DELETED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
			$this->rnr_rule_model->update_rules(array("id"=>$rule_id), $db_arr);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule deleted successfully.</b></div>');
			redirect(site_url("rnr-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}


}
