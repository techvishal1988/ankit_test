<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sip extends CI_controller
{
	public function __construct()
 	{
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
		$this->load->model("admin_model");
		$this->load->model("sip_model");
		$this->load->model("rule_model");
		$this->load->model("common_model");
		$this->load->model("approvel_model");
		$this->load->model("Business_attribute_model");
		$this->lang->load('message', 'english');
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{
			redirect(site_url("dashboard"));
		}
		HLP_is_valid_web_token();
    }

    public function sip_rule_filters($performance_cycle_id, $rule_id=0)
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
			redirect(site_url("sip-rule-list/".$performance_cycle_id));
		}

		$data['performance_cycle_dtls'] = $this->rule_model->get_table_row("performance_cycle", "*", array("id"=>$performance_cycle_id));

		if(!$data['performance_cycle_dtls'])
		{
			redirect(site_url("performance-cycle"));
		}

		if($rule_id)
		{
			$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));

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
					redirect(site_url("sip-rule-list/".$performance_cycle_id));
				}

				$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED);
				if($is_need_update > 0 and $rule_id > 0)
				{
					$condit_arr["sip_hr_parameter.id !="] = $rule_id;
				}

				//$already_created_rule_for_emp_arr = $this->rule_model->get_table("sip_hr_parameter","user_ids", $condit_arr);
				$already_created_rule_for_emp_arr = $this->sip_model->get_all_emp_ids_for_a_sip_cycle($condit_arr);

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
				$data['employees'] = $this->sip_model->get_employees_as_per_rights_for_sip_rule($where);
				if(!$data['employees'])
				{
					$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have no employee as per selected filters.</b></div>');

					if($rule_id)
					{
						redirect(site_url("sip-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("sip-rule-filters/".$performance_cycle_id));
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
						redirect(site_url("sip-rule-filters/".$performance_cycle_id."/".$rule_id));
					}
					else
					{
						redirect(site_url("sip-rule-filters/".$performance_cycle_id));
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
								"updatedBy" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedOn" => date("Y-m-d H:i:s")
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
						/*if($data["rule_dtls"]["status"]==5)
						{
							$db_arr["status"] = 3;
						}*/
						if($data["rule_dtls"]["status"]>2)
						{
							$db_arr["status"] = 2;
						}
						$db_arr["actual_achievement_file_path"] = "";
						$this->sip_model->updateSipRules($db_arr,array('id'=>$rule_id));
					}
					else
					{
						$db_arr["status"] = 1;
						$db_arr["createdby"] = $this->session->userdata('userid_ses');
						$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
						$db_arr["createdon"] = date("Y-m-d H:i:s");
						$rule_id = $this->sip_model->insert_sip_rules($db_arr);
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
							$this->rule_model->delete_emps_frm_rule_dtls("sip_rule_users_dtls",array("rule_id"=>$rule_id));
							$this->rule_model->insert_data_as_batch("sip_rule_users_dtls", $db_rule_usr_ids_arr);
						}

						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You are covering '.count($user_ids_arr).' employees under this rule.</b></div>');
						redirect(site_url("create-sip-rule/".$rule_id));
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></div>');
						if($rule_id)
						{
							redirect(site_url("sip-rule-filters/".$performance_cycle_id."/".$rule_id));
						}
						else
						{
							redirect(site_url("sip-rule-filters/".$performance_cycle_id));
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

		$data['rule_list_pg_url'] = site_url("sip-rule-list/".$data['performance_cycle_dtls']['id']);
		$data['tooltip'] = getToolTip('sip-rule-page-1');

		$data['title'] = "Set ".$data['rule_txt_name']." Rule Filters";
		$data['body'] = "salary_rule_filters";
		$this->load->view('common/structure',$data);
	}

	public function createSipRules($rule_id)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id, "sip_hr_parameter.createdby"=>$this->session->userdata('userid_ses'), "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] >= 4)
		{
			redirect(site_url("performance-cycle"));
		}
		$data["emp_not_any_cycle_counts"] = $this->emp_not_any_cycle($data['rule_dtls']["performance_cycle_id"]);

		$data["sip_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");

		$data['ba_list'] = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", "status = 1 AND (module_name = '".CV_BUSINESS_LEVEL_1."' OR module_name = '".CV_BUSINESS_LEVEL_2."' OR module_name = '".CV_BUSINESS_LEVEL_3."' OR module_name = '".CV_FUNCTION."' OR module_name = '".CV_SUB_FUNCTION."' OR module_name = '".CV_SUB_SUB_FUNCTION."')", "id ASC");

		$data['title'] = CV_BONUS_SIP_LABEL_NAME." Rules";
		$data['body'] = "sip/create_sip_rules";
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

		$condit_arr = array("performance_cycle_id" => $performance_cycle_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED);
		//$already_created_rule_for_emp_arr = $this->rule_model->get_table("sip_hr_parameter","user_ids", $condit_arr);
		$already_created_rule_for_emp_arr = $this->sip_model->get_all_emp_ids_for_a_sip_cycle($condit_arr);

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
		$employees = $this->sip_model->get_employees_as_per_rights_for_sip_rule($where);

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

	public function get_ratings_list_NIU()
	{
		$ddl_name = "ddl_market_salary_rating";
		$hf_name = "hf_rating_name";
		$ddl_str = '<input type="text" name="'.$ddl_name.'[]" class="form-control" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" maxlength="6" />';

		$rating_elements_list = $this->rule_model->get_ratings_list();
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

	public function get_target_sip_elements_NIU($rule_id, $target_sip, $elements_for)
	{
		$return_data = array();
		$tbl_name = "";
		$cnd_str = " status = 1 ";
		
		$rule_dtls = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));

		$elem_value_type = "%";
		$txt_maxlength = "6";
		$validation_of_val = 'onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"';
		
		if($target_sip==2)
		{
			$elem_value_type = "Amount";
			$txt_maxlength = "9";
			$validation_of_val = 'onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"';
		}

		$tfoot_colspan = 0;
		$thead_tsi_colspan = 1;
		$weightage_colspan = 1;
		$headers = array();
		$hf_selected_ba = array();
		$hf_selected_custom_id = array();
		$custom_input_id = 0;
		$target_sip_on_changed = TRUE;		

		if($rule_dtls["target_sip_on"] == $elements_for)
		{
			$target_sip_on_changed = FALSE;
		}

		$achievement_exists = 0;
		$query_achievement_check = $this->db->query("SELECT DISTINCT 1 FROM sip_weightage_parameters swp
		where type = 1 and swp.sip_hr_parameter_id = $rule_id");
		if($query_achievement_check->num_rows() > 0)
		{
			$achievement_exists = 1;
		}

		$query_ba = $this->db->query("SELECT DISTINCT swp.ba_id, ba.ba_name, ba.display_name FROM sip_weightage_parameters swp
		INNER JOIN business_attribute ba ON swp.ba_id = ba.id
		where swp.type = 1 and swp.sip_hr_parameter_id = $rule_id");

		foreach($query_ba->result() as $row)
		{
			$individual_attr = Array("id" => $row->ba_id, "ba_name" => $row->ba_name, "display_name" => $row->display_name);
			$headers[] = $individual_attr;
			$weightage_colspan++;
		}

		$headers_custom = array();

		$query_custom = $this->db->query("SELECT DISTINCT swp.name FROM sip_weightage_parameters swp
		where swp.type = 2 and swp.sip_hr_parameter_id = $rule_id");

		foreach ($query_custom->result() as $row)
		{
			$individual_attr = Array("ba_name" => 'custom', "display_name" => $row->name);
			$headers_custom[] = $individual_attr;
			$weightage_colspan++;
		}
		$str_main = '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';

		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
		{
			$tbl_name = "manage_".$elements_for;
			$cnd_str .= " AND id IN (".$rule_dtls[$elements_for."s"].")";
			$tfoot_colspan++;

			if(($target_sip == "1") || ($target_sip == "2"))
			{
				$thead_tsi_colspan = 2;
			}
			
			$str_main .= '<th class="first_hed_colone" colspan="' . $thead_tsi_colspan . '">Target '.CV_BONUS_SIP_LABEL_NAME.'</th><th class="first_hed_coltwo" colspan="' . $weightage_colspan . '">Weightage for SIP Parameters</th></tr><tr class="dynamic"><th style="text-transform: capitalize;" class="td_frist_hed">'.$elements_for.'</th>';
			
			if($target_sip == "1")
			{
				$tfoot_colspan++;
				$str_main .= '<th class="td_frist_hed">Target Sales Incentive '.$elem_value_type.'</th>';
			}
			else if($target_sip == "2")
			{
				$tfoot_colspan++;
				$str_main .= '<th>Target Sales Incentive '.$elem_value_type.'</th>';
			}
		}
		else
		{
			if(($target_sip == "1") || ($target_sip == "2"))
			{
				$str_main .= '<th colspan="' . $thead_tsi_colspan . '">Target '.CV_BONUS_SIP_LABEL_NAME.'</th>';
			}

			$str_main .= '<th colspan="' . $weightage_colspan . '">Weightage for SIP Parameters</th></tr><tr>';

			if($target_sip == "1" or $target_sip == "2")
			{
				$tfoot_colspan++;
				$str_main .= '<th>Target Sales Incentive'.$elem_value_type.'</th>';
			}
		}

		// Individual
		$str_main .= "<th class='sip-params'>Individual</th>";
		$tfoot_colspan++;

		foreach ($headers as $row)
		{
			$tfoot_colspan++;
			$str_main .= "<th class='sip-params' data-value='".$row["ba_name"]."' data-ba_id='".$row["id"]."'>".$row["display_name"]."<br><span class='cross-button' onclick='hide_sip_parameter(this)'>x</span></th>";
			$hf_selected_ba[] = (int)$row["id"];
		}

		$sequential_var = 0;
		foreach ($headers_custom as $row)
		{
			$sequential_var++;
			$tfoot_colspan++;
			$str_main .= "<th class='sip-params' data-value='".$row["ba_name"]."'  data-custom_id='" . $sequential_var . "' ><br><input class='form-control' style='margin-top:10px;' type='text' id='custom_input_name_" . $sequential_var . "' name='custom_input_name_" . $sequential_var . "' value='".$row["display_name"]."'><br><span class='cross-button' onclick='hide_sip_parameter(this)'>x</span></th>";
			$hf_selected_custom_id[] = (int)$sequential_var;
		}
		$custom_input_id = $sequential_var;

		$str_main .= '</tr></thead><tbody>';

		// Target Sales Incentive %
		$query_tsi = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
		where swp.type = 4 and swp.sip_hr_parameter_id = $rule_id");

		$tsi_val_arr = array_map('current', $query_tsi->result());

		// Individual
		$query_individual = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
		where swp.type = 3 and swp.sip_hr_parameter_id = $rule_id");

		$individual_val_arr = array_map('current', $query_individual->result());

		// Business Attribute
		foreach ($headers as $key => $ba_row)
		{
			$query_ba_val = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
			where swp.type = 1 and swp.sip_hr_parameter_id = $rule_id and ba_id = " . $ba_row['id']);
			$headers[$key]['values'] = array_map('current', $query_ba_val->result());
		}

		//custom values
		foreach($headers_custom as $key => $custom_row)
		{
			$query_custom_val = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
			where swp.type = 2 and swp.sip_hr_parameter_id = $rule_id and name = '" . $custom_row['display_name'] . "'");
			$headers_custom[$key]['values'] = array_map('current', $query_custom_val->result());
		}

		if($tbl_name)
		{
			$elements_list = $this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");
			if($elements_list)
			{
				$k=1;
				foreach($elements_list as $row)
				{
					$str_main .= '<tr>';
					$str_main .= '<td>'.$row['name'].'<input type="hidden" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['name'].'" name="hf_target_sip_elem[]" /></td>';

					if(($target_sip == "1") || ($target_sip == "2"))
					{
						$input_val = $tsi_val_arr[$k-1];
						if($target_sip_on_changed)
						{
							$input_val = "";
						}

						$str_main .= '<td class="weblik-cen"><input class="bo_vl_width form-control" type="text" name="txt_target_sip_elem[]" id="txt_target_elem_'.$row['id'].'" required maxlength="'.$txt_maxlength.'" '.$validation_of_val.'  onchange="fill_below_weightage(this.value, '.$k.",'txt_target_elem_'".');"  style="text-align:center;" value="' . $input_val . '" /></td>';
					}

					$input_val = $individual_val_arr[$k-1];
					if($target_sip_on_changed)
					{
						$input_val = "";
					}

					$str_main .= '<td class="weblik-cen"><input type="text" name="txt_individual_weightage[]" id="txt_indivi_weight_'.$row['id'].'" class="form-control bo_vl_width" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_indivi_weight_'".');" style="text-align:center;" value="' . $input_val . '"/></td>';

					foreach ($headers as $ba_row)
					{
						$ba_id = $ba_row["id"];
						$ba_name = $ba_row["ba_name"];
						$display_name = $ba_row["display_name"];
						$ba_val_arr = $ba_row["values"];

						$input_val = $ba_val_arr[$k-1];
						if($target_sip_on_changed)
						{
							$input_val = "";
						}

						$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" data-ba_id="' . $ba_id . '" data-ba_name="' . $ba_name . '" name="txt_' . $ba_name . '[]" id="txt_' . $ba_name . '_'.$k.'" onchange="fill_below_weightage_ba(this.value, '.$k.', \'txt_' . $ba_name . '_\');" value="' . $input_val . '"></td>';
					}

					$sequential_var = 0;
					foreach ($headers_custom as $custom_row)
					{
						$sequential_var++;
						$ba_name = $custom_row["ba_name"];
						$display_name = $custom_row["display_name"];
						$custom_val_arr = $custom_row["values"];

						$input_val = $custom_val_arr[$k-1];
						if($target_sip_on_changed)
						{
							$input_val = "";
						}

						$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" name="custom_input_' . $sequential_var . '[]" id="custom_input_' . $sequential_var . '_'.$k.'" onchange="fill_below_weightage_ba(this.value, '.$k.', \'custom_input_' . $sequential_var . '_\');" value="' . $input_val . '"></td>';
					}
					$str_main .= '</tr>';
					$k++;
				}
			}
		}
		else
		{
			$str_main .= '<tr>';				
			if(($target_sip == "1") || ($target_sip == "2"))
			{
				$input_val = "";
				if(isset($tsi_val_arr[0]))
				{
					$input_val = $tsi_val_arr[0];
				}
				$str_main .= '<td class="weblik-cen"><input class="bo_vl_width form-control" type="text" name="txt_target_sip_elem[]" id="txt_target_elem" required maxlength="'.$txt_maxlength.'" '.$validation_of_val.'   style="text-align:center;" value="' . $input_val . '" /></td>';
			}

			$input_val = "";
			if(isset($individual_val_arr[0]))
			{
				$input_val = $individual_val_arr[0];
			}

			$str_main .= '<td><input type="text" name="txt_individual_weightage[]" id="txt_indivi_weightage" class="form-control" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;" value="' . $input_val . '"/></td>';

			foreach ($headers as $ba_row)
			{
				$ba_id = $ba_row["id"];
				$ba_name = $ba_row["ba_name"];
				$display_name = $ba_row["display_name"];
				$ba_val_arr = $ba_row["values"];
				
				$input_val = "";
				if(isset($ba_val_arr[0]))
				{
					$input_val = $ba_val_arr[0];
				}
				
				$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" data-ba_id="' . $ba_id . '" data-ba_name="' . $ba_name . '" name="txt_' . $ba_name . '[]" id="txt_' . $ba_name . '" value="' . $input_val . '"></td>';
			}

			$sequential_var = 0;
			foreach ($headers_custom as $custom_row)
			{
				$sequential_var++;
				$ba_name = $custom_row["ba_name"];
				$display_name = $custom_row["display_name"];
				$custom_val_arr = $custom_row["values"];
				
				$input_val = "";
				if(isset($custom_val_arr[0]))
				{
					$input_val = $custom_val_arr[0];
				}
				
				$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" name="custom_input_' . $sequential_var . '[]" id="custom_input_' . $sequential_var . '" value="' . $input_val . '"></td>';
			}
			$str_main .= '</tr>';
		}

		$str_main .= '</tbody><tfoot><tr id="tr_btn_put_achievement"><td colspan="' . $tfoot_colspan . '" style="text-align:right;"><input style="color:#fff !important;" type="button" value="Define Actual Achievements Below" class="btn btn-success" onclick="get_achievements_elements();"/></td></tr></tfoot></table></div>';
		
		$return_data['html'] = $str_main;
		$return_data['hf_selected_ba'] = $hf_selected_ba;
		$return_data['hf_selected_custom_id'] = $hf_selected_custom_id;
		$return_data['custom_input_id'] = $custom_input_id;
		$return_data['achievement_exists'] = $achievement_exists;

		echo json_encode($return_data);
	}
	
	public function get_target_sip_elements($rule_id, $target_sip, $elements_for)
	{
		$return_data = array();
		$tbl_name = "manage_grade";
		$cnd_str = " status = 1 ";
		
		$rule_dtls = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));

		$elem_value_type = "%";
		$txt_maxlength = "6";
		$validation_of_val = 'onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"';
		
		if($target_sip==2)
		{
			$elem_value_type = "Amount";
			$txt_maxlength = "9";
			$validation_of_val = 'onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"';
		}

		$tfoot_colspan = 0;
		$thead_tsi_colspan = 1;
		$weightage_colspan = 1;
		$headers = array();
		$hf_selected_ba = array();
		$hf_selected_custom_id = array();
		$custom_input_id = 0;
		$target_sip_on_changed = TRUE;		

		if($rule_dtls["target_sip_on"] == $elements_for)
		{
			$target_sip_on_changed = FALSE;
		}

		$achievement_exists = 0;
		$query_achievement_check = $this->db->query("SELECT DISTINCT 1 FROM sip_weightage_parameters swp
		where type = 1 and swp.sip_hr_parameter_id = $rule_id");
		if($query_achievement_check->num_rows() > 0)
		{
			$achievement_exists = 1;
		}

		$query_ba = $this->db->query("SELECT DISTINCT swp.ba_id, ba.ba_name, ba.display_name FROM sip_weightage_parameters swp
		INNER JOIN business_attribute ba ON swp.ba_id = ba.id
		where swp.type = 1 and swp.sip_hr_parameter_id = $rule_id");

		foreach($query_ba->result() as $row)
		{
			$individual_attr = Array("id" => $row->ba_id, "ba_name" => $row->ba_name, "display_name" => $row->display_name);
			$headers[] = $individual_attr;
			$weightage_colspan++;
		}

		$headers_custom = array();

		$query_custom = $this->db->query("SELECT DISTINCT swp.name FROM sip_weightage_parameters swp
		where swp.type = 2 and swp.sip_hr_parameter_id = $rule_id");

		foreach ($query_custom->result() as $row)
		{
			$individual_attr = Array("ba_name" => 'custom', "display_name" => $row->name);
			$headers_custom[] = $individual_attr;
			$weightage_colspan++;
		}
		$str_main = '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';

		if($elements_for == "designation" or $elements_for == "grade" or $elements_for == "level")
		{
			$tbl_name = "manage_".$elements_for;
		}
		
		$cnd_str .= " AND id IN (".$rule_dtls[$elements_for."s"].")";
		$tfoot_colspan++;

		if(($target_sip == "1") || ($target_sip == "2"))
		{
			$thead_tsi_colspan = 2;
		}
		
		$str_main .= '<th class="first_hed_colone" colspan="' . $thead_tsi_colspan . '">Target '.CV_BONUS_SIP_LABEL_NAME.'</th><th class="first_hed_coltwo" colspan="' . $weightage_colspan . '">Weightage for SIP Parameters</th></tr><tr class="dynamic"><th style="text-transform: capitalize;" class="td_frist_hed">'.$elements_for.'</th>';
		
		if($target_sip == "1")
		{
			$tfoot_colspan++;
			$str_main .= '<th class="td_frist_hed">Target Sales Incentive '.$elem_value_type.'</th>';
		}
		else if($target_sip == "2")
		{
			$tfoot_colspan++;
			$str_main .= '<th>Target Sales Incentive '.$elem_value_type.'</th>';
		}
		

		// Individual
		$str_main .= "<th class='sip-params'>Individual</th>";
		$tfoot_colspan++;

		foreach ($headers as $row)
		{
			$tfoot_colspan++;
			$str_main .= "<th class='sip-params' data-value='".$row["ba_name"]."' data-ba_id='".$row["id"]."'>".$row["display_name"]."<br><span class='cross-button' onclick='hide_sip_parameter(this)'>x</span></th>";
			$hf_selected_ba[] = (int)$row["id"];
		}

		$sequential_var = 0;
		foreach ($headers_custom as $row)
		{
			$sequential_var++;
			$tfoot_colspan++;
			$str_main .= "<th class='sip-params' data-value='".$row["ba_name"]."'  data-custom_id='" . $sequential_var . "' ><br><input class='form-control' style='margin-top:10px;' type='text' id='custom_input_name_" . $sequential_var . "' name='custom_input_name_" . $sequential_var . "' value='".$row["display_name"]."'><br><span class='cross-button' onclick='hide_sip_parameter(this)'>x</span></th>";
			$hf_selected_custom_id[] = (int)$sequential_var;
		}
		$custom_input_id = $sequential_var;

		$str_main .= '</tr></thead><tbody>';

		// Target Sales Incentive %
		$query_tsi = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
		where swp.type = 4 and swp.sip_hr_parameter_id = $rule_id");

		$tsi_val_arr = array_map('current', $query_tsi->result());

		// Individual
		$query_individual = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
		where swp.type = 3 and swp.sip_hr_parameter_id = $rule_id");

		$individual_val_arr = array_map('current', $query_individual->result());

		// Business Attribute
		foreach ($headers as $key => $ba_row)
		{
			$query_ba_val = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
			where swp.type = 1 and swp.sip_hr_parameter_id = $rule_id and ba_id = " . $ba_row['id']);
			$headers[$key]['values'] = array_map('current', $query_ba_val->result());
		}

		//custom values
		foreach($headers_custom as $key => $custom_row)
		{
			$query_custom_val = $this->db->query("SELECT swp.value FROM sip_weightage_parameters swp
			where swp.type = 2 and swp.sip_hr_parameter_id = $rule_id and name = '" . $custom_row['display_name'] . "'");
			$headers_custom[$key]['values'] = array_map('current', $query_custom_val->result());
		}

		$elements_list = $this->rule_model->get_table($tbl_name, "*", $cnd_str, "name asc");
		if($elements_list)
		{
			$k=1;
			foreach($elements_list as $row)
			{
				$str_main .= '<tr>';
				$str_main .= '<td class="weblik-cen">'.$row['name'].'<input type="hidden" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['name'].'" name="hf_target_sip_elem[]" /></td>';

				if(($target_sip == "1") || ($target_sip == "2"))
				{
					$input_val = $tsi_val_arr[$k-1];
					if($target_sip_on_changed)
					{
						$input_val = "";
					}

					$str_main .= '<td class="weblik-cen"><input class="bo_vl_width form-control" type="text" name="txt_target_sip_elem[]" id="txt_target_elem_'.$row['id'].'" required maxlength="'.$txt_maxlength.'" '.$validation_of_val.'  onchange="fill_below_weightage(this.value, '.$k.",'txt_target_elem_'".');"  style="text-align:center;" value="' . $input_val . '" /></td>';
				}

				$input_val = $individual_val_arr[$k-1];
				if($target_sip_on_changed)
				{
					$input_val = "";
				}

				$str_main .= '<td class="weblik-cen"><input type="text" name="txt_individual_weightage[]" id="txt_indivi_weight_'.$row['id'].'" class="form-control bo_vl_width" required maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="fill_below_weightage(this.value, '.$k.",'txt_indivi_weight_'".');" style="text-align:center;" value="' . $input_val . '"/></td>';

				foreach ($headers as $ba_row)
				{
					$ba_id = $ba_row["id"];
					$ba_name = $ba_row["ba_name"];
					$display_name = $ba_row["display_name"];
					$ba_val_arr = $ba_row["values"];

					$input_val = $ba_val_arr[$k-1];
					if($target_sip_on_changed)
					{
						$input_val = "";
					}

					$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" data-ba_id="' . $ba_id . '" data-ba_name="' . $ba_name . '" name="txt_' . $ba_name . '[]" id="txt_' . $ba_name . '_'.$k.'" onchange="fill_below_weightage_ba(this.value, '.$k.', \'txt_' . $ba_name . '_\');" value="' . $input_val . '"></td>';
				}

				$sequential_var = 0;
				foreach ($headers_custom as $custom_row)
				{
					$sequential_var++;
					$ba_name = $custom_row["ba_name"];
					$display_name = $custom_row["display_name"];
					$custom_val_arr = $custom_row["values"];

					$input_val = $custom_val_arr[$k-1];
					if($target_sip_on_changed)
					{
						$input_val = "";
					}

					$str_main .= '<td class="weblik-cen"><input type="text" class="form-control bo_vl_width" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" style="text-align:center;" name="custom_input_' . $sequential_var . '[]" id="custom_input_' . $sequential_var . '_'.$k.'" onchange="fill_below_weightage_ba(this.value, '.$k.', \'custom_input_' . $sequential_var . '_\');" value="' . $input_val . '"></td>';
				}
				$str_main .= '</tr>';
				$k++;
			}
		}

		//$str_main .= '</tbody><tfoot><tr id="tr_btn_put_achievement"><td colspan="' . $tfoot_colspan . '" style="text-align:right;"><input style="color:#fff !important;" type="button" value="Define Actual Achievements Below" class="btn btn-success" onclick="get_achievements_elements();"/></td></tr></tfoot></table></div>';
		$str_main .= '</tbody></table></div>';
		
		$return_data['html'] = $str_main;
		$return_data['hf_selected_ba'] = $hf_selected_ba;
		$return_data['hf_selected_custom_id'] = $hf_selected_custom_id;
		$return_data['custom_input_id'] = $custom_input_id;
		$return_data['achievement_exists'] = $achievement_exists;

		echo json_encode($return_data);
	}

	public function get_achievements_elements_NIU($rule_id, $bl_1_achievment, $bl_2_achievment, $bl_3_achievment, $function_achievment, $sub_function_achievment, $sub_subfunction_achievment)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		$headers = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", "status = 1 AND (module_name = '".CV_BUSINESS_LEVEL_1."' OR module_name = '".CV_BUSINESS_LEVEL_2."' OR module_name = '".CV_BUSINESS_LEVEL_3."' OR module_name = '".CV_FUNCTION."' OR module_name = '".CV_SUB_FUNCTION."' OR module_name = '".CV_SUB_SUB_FUNCTION."')", "id ASC");

		if(isset($_GET['custom_input_names'])) {
			$custom_input_names = $_GET['custom_input_names'];
		}

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
		$data["custom_input_names"] = $custom_input_names;

		$this->load->view('sip_show_achievements_elements',$data);
	}

	public function saveSipRules($rule_id, $step)
	{
		if($step > 0 and $rule_id > 0)
		{
			$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
			if(!$data['rule_dtls'] or $data['rule_dtls']["status"] >= 4)//Sent for approval yet or Approved
			{
				echo "";die;
			}

			if($step == 1)
			{
				if(!$this->input->post("hf_show_next_step"))
				{
					$recurr_plan_start_dt = $this->input->post("txt_plan_start_dt");
					$recurr_plan_end_dt = $this->input->post("txt_plan_end_dt");

					$recurr_plan_start_dt=explode("/",$recurr_plan_start_dt);
					$recurr_plan_start_dt = ($recurr_plan_start_dt[2].'-'.$recurr_plan_start_dt[1].'-'.$recurr_plan_start_dt[0]);

					$recurr_plan_end_dt=explode("/",$recurr_plan_end_dt);
					$recurr_plan_end_dt = ($recurr_plan_end_dt[2].'-'.$recurr_plan_end_dt[1].'-'.$recurr_plan_end_dt[0]);
					$db_arr = array(
							'sip_rule_name' => $this->input->post("txt_rule_name"),
							'prorated_increase' => $this->input->post("ddl_prorated_increase"),
							'recurring_plan' => $this->input->post("ddl_recurring_plan"),
							'frequency_of_plan' => $this->input->post("ddl_frequency_of_plan"),
							'recurr_plan_start_dt' => $recurr_plan_start_dt,
							'recurr_plan_end_dt' => $recurr_plan_end_dt,
							'target_sip' => $this->input->post("ddl_target_sip"),
							//'target_sip_dtls'=>"",
							'sip_applied_on_elements' => CV_ALLOWANCE_1_ID,//Set it to manage target_sip is 3
							'target_sip_on' => $this->input->post("ddl_target_sip_on"),
							//'business_level_achievement'=>"",
							'performance_achievement_rangs' => "",							
							'performance_achievements_multiplier_type' => $this->input->post("ddl_performance_achievements_multiplier"),
							'manager_discretionary_increase' => $this->input->post("txt_manager_discretionary_increase"),
							'manager_discretionary_decrease' => $this->input->post("txt_manager_discretionary_decrease"),							
							'overall_budget' => "",
							'manual_budget_dtls' => "",
							'status' => 2,
							"updatedBy" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedOn" => date("Y-m-d H:i:s"));
							
					$target_elements_arr = array();
					if($this->input->post("ddl_target_sip")=="1")
					{
						$db_arr["sip_applied_on_elements"] = implode(",",$this->input->post("ddl_sip_applied_elem"));						
						/*foreach($_REQUEST['hf_target_sip_elem'] as $key=> $value)
						{
							if($value !='')
							{
								$target_elements_arr[$value] = $_REQUEST['txt_target_sip_elem'][$key];
							}
						}
						$db_arr['target_sip_dtls'] = json_encode($target_elements_arr);*/
					}
					/*elseif(($this->input->post("ddl_target_sip")=="2") || ($this->input->post("ddl_target_sip")=="3"))
					{
						foreach($_REQUEST['hf_target_sip_elem'] as $key=> $value)
						{
							if($value !='')
							{
								$target_elements_arr[$value] = $_REQUEST['txt_target_sip_elem'][$key];
							}
						}
						$db_arr['target_sip_dtls'] = json_encode($target_elements_arr);
					}*/

					//NIU Section Start *****************************************************
					/*$business_level_element_val_arr = array();
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

					$custom_element_val_arr = array();

					$i=0;
					foreach($_REQUEST['hf_custom'] as $key=> $value)
					{
						if($this->input->post("txt_custom_element_val_".$i))
						{
							foreach($_REQUEST['hf_custom_element_val_'.$i] as $k=> $v)
							{
								if($v !='')
								{
										$custom_element_val_arr[$v] = $_REQUEST['txt_custom_element_val_'.$i][$k];
								}
							}
						}
						$i++;
					}

					$db_arr["custom_achievement"] = json_encode($custom_element_val_arr);*/
					
					//NIU Section End *****************************************************

					/*$min_range = 0;
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
					$db_arr['performance_achievement_rangs'] = json_encode($perfo_achie_rangs_arr);*/
					
					//$this->sip_model->updateSipRules($db_arr,array('id'=>$data['rule_dtls']["id"]));

					// sip_Weightage_parameters insertion start
					$sip_weightage_parameters = array();

					// custom case
					$hf_selected_custom_id_arr = json_decode($this->input->post("hf_selected_custom_id"), true);
					foreach ($hf_selected_custom_id_arr as $custom_input_id)
					{
						$custom_name = $this->input->post("custom_input_name_".$custom_input_id);
						if($this->input->post("custom_input_".$custom_input_id))
						{
							$sip_weightage_parameters[] = array(
												'name' => $custom_name,
												'type' => 2,
												'param_arr' => $this->input->post("custom_input_".$custom_input_id),
												'ba_id' => ''
											);
						}
					}

					if($this->input->post("txt_target_sip_elem"))
					{
						$sip_weightage_parameters[] = array(
												'type' => 4,
												'param_arr' => $this->input->post("txt_target_sip_elem"),
												'ba_id' => '',
												'name' => 'Target Sales Incentive'
						);
					}
					if($this->input->post("txt_individual_weightage"))
					{
						$sip_weightage_parameters[] = array(
													'type' => 3,
													'param_arr' => $this->input->post("txt_individual_weightage"),
													'ba_id' => '',
													'name' => 'Individual'
						);
					}

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_BUSINESS_LEVEL_1);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_BUSINESS_LEVEL_2);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_BUSINESS_LEVEL_3);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_FUNCTION);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_SUB_FUNCTION);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					$weightage_parameters_vals= $this->getWeightageParamForBA(CV_SUB_SUB_FUNCTION);
					if(!empty($weightage_parameters_vals))
						$sip_weightage_parameters[] = $weightage_parameters_vals;

					// deleting existing params in sip_weightage_parameters
				  	$this->db->where(array('sip_hr_parameter_id' => $data['rule_dtls']["id"]))->delete('sip_weightage_parameters');

					foreach ($sip_weightage_parameters as $key => $weightage_type)
					{
						$type = $weightage_type['type'];
						$param_arr = $weightage_type['param_arr'];
						$ba_id = $weightage_type['ba_id'];
						$name = $weightage_type['name'];
						$hf_target_sip_elem = $this->input->post("hf_target_sip_elem");
						foreach ($param_arr as $param_arr_key => $value)
						{
							$insert_vals = array(
								'value' => $value,
								'type'	=> $type,
								'sip_hr_parameter_id' => $data['rule_dtls']["id"]
							);

							if(isset($hf_target_sip_elem))
							{
								$hf_target_sip_elem_val = explode(CV_CONCATENATE_SYNTAX, $hf_target_sip_elem[$param_arr_key]);
								$target_based_on_id = $hf_target_sip_elem_val[0];
								$insert_vals['target_based_on_id'] = $target_based_on_id;
							}

							if($ba_id != '')
							{
								$insert_vals['ba_id'] = $ba_id;
							}
							if($name != '')
							{
								$insert_vals['name'] = $name;
							}
							$this->sip_model->insert_sip_weightage_parameters($insert_vals);
						}
					}
					// sip_Weightage_parameters insertion end

					// saving performance achievment, Fixed %ages for a range of DOJ and Recurring fields.
					// $txt_perfo_achiev_min = $this->input->post("txt_perfo_achiev_min");
					$txt_perfo_achiev_max = $this->input->post("txt_perfo_achiev_max");
					$txt_perfo_achiev_val = $this->input->post("txt_perfo_achiev_val");

					$performance_achievement_rangs = array();
					$min = 0;
					foreach ($txt_perfo_achiev_max as $key => $value)
					{
						$performance_achievement_rangs['range'.($key + 1)] = array(
							'min' => $min,
							'max' => $txt_perfo_achiev_max[$key]
						);
						$min = $txt_perfo_achiev_max[$key] + 1;
					}

					$txt_fix_per_range_doj_min = $this->input->post("txt_fix_per_range_doj_min");
					$txt_fix_per_range_doj_max = $this->input->post("txt_fix_per_range_doj_max");
					$txt_fix_per_range_doj_val = $this->input->post("txt_fix_per_range_doj_val");

					array_unshift($txt_fix_per_range_doj_min, 0);
					array_push($txt_fix_per_range_doj_max, 'max');

					$fix_per_range_doj = array();
					foreach ($txt_fix_per_range_doj_min as $key => $value)
					{
						$fix_per_range_doj[] = array(
							'min' => $txt_fix_per_range_doj_min[$key],
							'max' => $txt_fix_per_range_doj_max[$key],
							'val' => $txt_fix_per_range_doj_val[$key],
						);
					}
					
					//$db_arr['performance_achievement_rangs'] = json_encode($performance_achievement_rangs);
					//$db_arr['performance_achievements_multipliers'] = json_encode($txt_perfo_achiev_val);
					$db_arr['fix_per_range_doj'] = json_encode($fix_per_range_doj);
					$this->sip_model->updateSipRules($db_arr,array('id'=>$data['rule_dtls']["id"]));
					
					$rule_dtls_new = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$data['rule_dtls']["id"]));
					$multiplier_arr_dtls = $this->get_performance_multipliers($rule_dtls_new);
					$this->sip_model->updateSipRules(array("multiplier_dtls"=>json_encode($multiplier_arr_dtls)), array('id'=>$data['rule_dtls']["id"]));
				}
				echo 1;
			}
			elseif($step == 2)
			{
				if(!$this->input->post("hf_show_next_step3"))
				{
					$db_arr = array(
									"performance_achievement_rangs" => "",
									
									"individual_performance_below_check" => $this->input->post("ddl_individual_performance_below_check"),
									"min_payout" => $this->input->post("txt_min_payout"),
									"max_payout" => $this->input->post("txt_max_payout"),
									"status" => 2,
									'overall_budget' => "",
									'to_currency_id' => "",
									'manual_budget_dtls' => "",
									"updatedBy" => $this->session->userdata('userid_ses'),
									"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
									"updatedOn" => date("Y-m-d H:i:s")
									);
									
					$multiplier_arr_dtls = json_decode($data["rule_dtls"]["multiplier_dtls"], true);
					$perf_achiev_rang_arr = array();
					if($data["rule_dtls"]["performance_achievements_multiplier_type"] != 3)
					{
						foreach($multiplier_arr_dtls as $m_row)
						{
							$txt_perfo_achiev_max = $this->input->post("txt_perfo_achiev_max_".$m_row["key"]);
							$txt_perfo_achiev_val = $this->input->post("txt_perfo_achiev_val_".$m_row["key"]);
			
							$min = 0;
							$rang_arr = array();
							foreach($txt_perfo_achiev_max as $key => $value)
							{
								$rang_arr[] = array(
													'min' => $min,
													'max' => $txt_perfo_achiev_max[$key],
													'multiplier' => $txt_perfo_achiev_val[$key]
													);
								$min = $txt_perfo_achiev_max[$key];
							}
							$perf_achiev_rang_arr[$m_row["key"]] = $rang_arr;
						}
						
						$db_arr["performance_achievement_rangs"] = json_encode($perf_achiev_rang_arr);
					}					
					
					if($_FILES['achievements_file']['name'])
					{		
						$this->load->model("upload_model");				
						$file_type = explode('.', $_FILES['achievements_file']['name']);
						if(end($file_type) == 'csv')
						{
							$uploaded_file_name = str_replace(' ','_',$_FILES['achievements_file']['name']);
							$fName = time().".".end($file_type);
							move_uploaded_file($_FILES["achievements_file"]["tmp_name"], "uploads/" . $fName);
							$csv_file = base_url()."uploads/".$fName;
		
							if(($handle = fopen($csv_file, "r")) !== FALSE)
							{								
								$field_from_csv_arr = array("@col1", "@col2");
								$insert_fields_str = "email = @col2";
								$update_fields_str = "";
								$temp_tbl_fields = array();
								$temp_tbl_fields["email"] = array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE);
								$i = 3;
								$a='"';
								$b="'";
								$c='{';
								$d=',';								
								foreach($multiplier_arr_dtls as $m_row)
								{
									$temp_tbl_fields[$m_row["key"]] = array('type'=>'decimal', 'constraint'=>'10,2', 'null'=>TRUE);
									$field_from_csv_arr[] = "@col".$i;
									$insert_fields_str .= ", ".$m_row["key"]." = @col".$i; 
									if(count($multiplier_arr_dtls)+2 == $i)
									{
										$d='}';
									}
									$update_fields_str .= $b.$c.$a.$m_row["key"].$a.":".$b.", ".$b.$a.$b.", ".$m_row["key"].", ".$b.$a.$b.", ".$b.$d.$b."\n";
									$c = "";
									$i++;
									//Note : Need create string itno below format to create json
									/*SELECT CONCAT
									(
									  '"name_field":'   , '"', name_field   , '"', ',' 
									  '"address_field":', '"', address_field, '"', ','
									  '"contact_age":'  , contact_age
									) AS my_json FROM contact*/
								}
								//echo "<pre>";print_r($update_fields_str);die;
								$tbl_name = "temp_tbl_achievements_" . $rule_id;
								$this->upload_model->create_upload_temp_table($tbl_name, $temp_tbl_fields);
								$this->sip_model->insert_achievements_data_in_tmp_tbl($rule_id, $csv_file, $tbl_name, implode(",", $field_from_csv_arr), $insert_fields_str, $update_fields_str);
								$db_arr["actual_achievement_file_path"] = "uploads/".$fName;
								$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data uploaded successfully.</b></div>');
							}
							else
							{
								$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not readable. Please try again.</b></div>');
							}
						}
						else
						{
							$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
						}		
					}
					
					$this->sip_model->updateSipRules($db_arr,array('id'=>$data['rule_dtls']["id"]));
					$this->session->set_flashdata('show_step', '3');
					redirect(site_url("create-sip-rule/".$rule_id));
				}
				echo 2;
			}
			elseif($step == 3)
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
								"status" => 3,
								'overall_budget' => $this->input->post("ddl_overall_budget"),
								'to_currency_id' => $this->input->post("ddl_to_currency"),
								'manual_budget_dtls' => json_encode($manual_budget_dtls),
								"updatedBy" => $this->session->userdata('userid_ses'),
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"updatedOn" => date("Y-m-d H:i:s"));
				// 'status' => 3;
				$this->sip_model->updateSipRules($step2_db_arr,array('id'=>$data['rule_dtls']["id"]));
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule created successfully.</b></div>');
				echo 3; die;
			}
		}
	}
	
	public function getWeightageParamForBA($ba_name)
	{
		$input_name = "txt_".$ba_name;
		$rtnArr = array();
		if($this->input->post($input_name)) {
			$ba_arr = $this->Business_attribute_model->get_ba_id_by_ba_name($ba_name);

			$hf_selected_ba_arr = json_decode($this->input->post("hf_selected_ba"), true);
			if (in_array($ba_arr["id"], $hf_selected_ba_arr)) {
				$rtnArr = array(
					'type' => 1,
					'param_arr' => $this->input->post($input_name),
					'ba_id' => $ba_arr["id"],
					'name' => $ba_arr["display_name"]
				);
			}
		}
		return $rtnArr;
	}

	public function get_sip_rule_step2_frm($rule_id)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}	
		$this->load->view('sip/sip_multiplier_panel',$data);
	}
	
	public function get_performance_multipliers($rule_dtls)
	{
		$multiplier_arr_dtls = array();
		if($rule_dtls["individual_weightage"])
		{
			$multiplier_arr_dtls[] = array("key"=>"individual", "value"=>"Individual");
		}
		
		$ba_dtls_arr = $this->admin_model->get_table("business_attribute", "ba_name AS key, display_name AS value", "id IN (SELECT ba_id FROM sip_weightage_parameters WHERE sip_hr_parameter_id = ".$rule_dtls["id"]." AND type = 1)");
		$multiplier_arr_dtls = array_merge($multiplier_arr_dtls, $ba_dtls_arr);
		
		$custom_tags = $this->db->query("SELECT name FROM sip_weightage_parameters WHERE sip_hr_parameter_id = ".$rule_dtls["id"]." AND type = 2 GROUP BY name ORDER BY id ASC");
        $custom_count = 1;
        foreach($custom_tags->result() as $row)
		{
			$multiplier_arr_dtls[] = array("key"=>'custom_name_'.$custom_count, "value"=>$row->name);
			$custom_count++;
        }
		return $multiplier_arr_dtls;
	}
	
	public function get_file_to_upload_achievements($rule_id)
	{
		$rule_dtls = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		$user_dtls = $this->admin_model->get_table("login_user", "id, ".CV_BA_NAME_EMP_FULL_NAME.", ".CV_BA_NAME_EMP_EMAIL, "id IN (SELECT user_id FROM sip_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$multiplier_arr_dtls = array_merge($multiplier_arr_dtls, $ba_dtls_arr);
		
		$head_arr = array("Name", "Email Id");
		
		$multiplier_arr_dtls = json_decode($rule_dtls["multiplier_dtls"], true);
		foreach($multiplier_arr_dtls as $m_row)
		{
			$head_arr[] = $m_row["value"]." Achievement" ;
		}
		//echo "<pre>";print_r($head_arr);die;
		$csv_file = "performance-actual-achievements-file-format.csv";
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $csv_file . '"');
		$fp = fopen('php://output', 'wb');
		fputcsv($fp, $head_arr);
		
		foreach($user_dtls as $row)
		{
			$item_arr = array($row[CV_BA_NAME_EMP_FULL_NAME], $row["email"]);
			fputcsv($fp, $item_arr);				
		}	
		fclose($fp);		
	}
	
	public function get_sip_rule_step3_frm($rule_id)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] > 3 or $rule_id <0)
		{
			echo "";die;//Wrong rule details taken
		}

		$data["default_currency"] = $this->rule_model->get_default_currency_for_rule("id IN (SELECT user_id FROM sip_rule_users_dtls WHERE rule_id = ".$rule_id.")");
		$data["currencys"] = $this->admin_model->get_table("manage_currency", "*", array("status"=>1));
		$this->load->view('sip/create_sip_rule_partial_for_manager_dtls',$data);
	}

	public function get_managers_for_manual_bdgt($is_view_only=0)
	{
		/*$budget_type = "Automated but x% can exceed";//$this->input->post("budget_type");
		$rule_id = 8;//$this->input->post("rid");
		$to_currency_id = 2;//$this->input->post("to_currency");*/
		$budget_type = $this->input->post("budget_type");
		$rule_id = $this->input->post("rid");
		$to_currency_id = $this->input->post("to_currency");
		if($rule_id)
		{
			$to_currency_dtls = $this->rule_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("sip_rule_users_dtls", $rule_id);
			$all_currency_dtls = $this->rule_model->get_table("manage_currency", "id, name", "status = 1");
			$data["rule_dtls"]["weightage_dtls"] = $this->rule_model->get_table("sip_weightage_parameters", "value, type, target_based_on_id, ba_id", "sip_hr_parameter_id = ".$rule_id." AND type != 4", "id ASC");
			$data["rule_dtls"]["target_based_on_dtls"] = $this->rule_model->get_table("sip_weightage_parameters", "value, type, target_based_on_id, ba_id", "sip_hr_parameter_id = ".$rule_id." AND type = 4", "id ASC");

			if($managers)
			{
				$str_main = '<div class="table-responsive" style="overflow-x: unset;"><table class="table tablecustm table-bordered"><thead>';
                $str_main .= '<tr>';
				$str_main .= '<th>Manager Name</th><th>Number of Employees</th>';
				$str_main .= '<th>Target '.CV_BONUS_SIP_LABEL_NAME.'</th>';
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
	                $str_main .= '<th>Additional budget (as %age of the allocated budget)</th>';
	                $str_main .= '<th>Additional Budget (as amount of the allocated budget)</th>';  

	            }
				$str_main .= '<th>Revised Budget</th><th>%age of Target Incentive</th>';
                $str_main .= '</tr>';
                $cTotal=0;
                $EmpTotal=0;
                $cbudget=0;
                $tsalary=0;
				$i=1;
				$str = '';

				foreach($managers as $row)
				{
					$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($data["rule_dtls"], $row['first_approver'], $to_currency_id, $all_currency_dtls);

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
							$str .= '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="dv_manual_budget_'.$i.'"></ravi></td>';
						}

						if($budget_type == "Automated but x% can exceed")
						{
							$str .= '<td class="txtalignright"><ravi id="dv_x_per_budget_'.$i.'"></ravi></td>';
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
							$str .= '<td><input type="text" class="form-control" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value="0"  maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" required="required" onChange="calculat_percent_increased_val(2,this.value, '.$i.')"></td>';
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
                             .'<th style="text-align: center;"><input type="hidden" id="curency" value="'.$manager_emp_budget_dtls['currency']['currency_type'].'"/><input type="hidden" value="'.$i.'" id="hf_manager_cnt"/>Total&nbsp;</th>'
                             .'<th style="text-align: center;">'.$EmpTotal.'</th><th><input type="hidden" value="'.round($tsalary).'" id="hf_total_target_sip"/>'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($tsalary)).'</th>'
                             .'<th>'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_plan">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
				//. '<th id="th_total_budget">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($cTotal)).'</th>';
				if($budget_type == "Manual")
				{
					$str_main .= '<th> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
				}

				if($budget_type == "Automated but x% can exceed")
				{
					$str_main .= '<th> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget_manual">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th>';
					$str_main .= '<th style="text-align: right !important;"> '.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_additional_budget_manual">'.HLP_get_formated_amount_common(0).'</ravi></th>'; 
				}
				$str_main .='<th>'.$manager_emp_budget_dtls['currency']['currency_type'].' <ravi id="th_total_budget">'.HLP_get_formated_amount_common(round($cTotal)).'</ravi></th><th id="th_final_per">'.HLP_get_formated_percentage_common(($cTotal/$tsalary)*100).' %</th></tr></thead><tbody>';
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

	public function calculate_budgt_manager_wise($rule_dtls, $manager_email, $to_currency_id, $all_currency_dtls)
	{
		$rule_id =  $rule_dtls["id"];
		$managers_emp_arr = $this->sip_model->get_employees_dtls_for_sip(array("sip_rule_users_dtls.rule_id"=>$rule_id, "login_user.".CV_BA_NAME_APPROVER_1=>$manager_email), $rule_dtls["sip_applied_on_elements"], 2);
		
		$total_max_budget = 0;
		$manager_actual_budget = 0;
		$managers_emps_tot_incremental_amt = 0;
		foreach($managers_emp_arr as $emp_row)
		{
			$employee_id = $emp_row["id"];
			$emp_row["currency_name"] = "";
			foreach($all_currency_dtls as $c_row)
			{
				if($c_row["id"] == $emp_row[CV_BA_NAME_CURRENCY])
				{
					$emp_row["currency_name"] = $c_row["name"];
					$currency = array("currency_type"=>$c_row["name"]);
					$from_currency_id = $emp_row[CV_BA_NAME_CURRENCY];
					break;
				}
			}
			
			$emp_sip_dtls = $this->calculate_sip_emploee_wise($emp_row, $rule_dtls);
			$manager_actual_budget += $emp_sip_dtls["cuurent_emp_sip_amt"];
			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_sip_dtls["cuurent_emp_sip_amt"]);
			$managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id, $emp_sip_dtls["sip_applied_on_amt"]);
		}
		return array("total_emps"=>count($managers_emp_arr), "budget"=>round($total_max_budget,2), "managers_emps_tot_incremental_amt"=>$managers_emps_tot_incremental_amt,"currency"=>$currency, "manager_actual_budget"=>$manager_actual_budget);
	}

	public function calculate_sip_emploee_wise($users_dtls, $rule_dtls)
	{
		$employee_id = $users_dtls["id"];
		$total_weightage_score = 0;
		$weightage_achievement_multiplier_dtls = array();
		$multiplier_arr_dtls = json_decode($rule_dtls["multiplier_dtls"], true);
		foreach($multiplier_arr_dtls as $m_row)
		{
			${$m_row["key"]."_weightage"} = 0;
			${$m_row["key"]."_achievement"} = 0;
		}
		$sip_applied_on_amt = $users_dtls["total_salary_to_apply_sip"];
		
		$target_sip_on_column = CV_BA_NAME_DESIGNATION;
		if($rule_dtls["target_sip_on"] == "grade")
		{
			$target_sip_on_column = CV_BA_NAME_GRADE;
		}
		elseif($rule_dtls["target_sip_on"] == "level")
		{
			$target_sip_on_column = CV_BA_NAME_LEVEL;
		}
		
		foreach($rule_dtls["target_based_on_dtls"] as $row)
		{
			if($row["target_based_on_id"] == $users_dtls[$target_sip_on_column])
			{
				if($rule_dtls["target_sip"] == 3)//Use "Uploaded Target Incentive" column value
				{
					$sip_applied_on_amt = $sip_applied_on_amt;
				}
				elseif($rule_dtls["target_sip"] == 2)// Use feeded "Fixed Amount"
				{
					$sip_applied_on_amt = $row["value"];
				}
				else//Use "% of Salary Elements" value
				{
					$sip_applied_on_amt = ($sip_applied_on_amt*$row["value"])/100;
				}
				break;
			}
		}
		
		if($rule_dtls["frequency_of_plan"]==1)//Frequency is Monthly
		{
			$sip_applied_on_amt = $sip_applied_on_amt/12;
		}
		elseif($rule_dtls["frequency_of_plan"]==2)//Frequency is Quarterly
		{
			$sip_applied_on_amt = $sip_applied_on_amt/4;
		}
		
		$coust_cnt = 1;
		foreach($rule_dtls["weightage_dtls"] as $w_row)
		{
			if($w_row["target_based_on_id"] == $users_dtls[$target_sip_on_column])
			{
				if($w_row["type"] == 3)
				{				
					$individual_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 5)
				{				
					$business_level_1_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 6)
				{				
					$business_level_2_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 7)
				{				
					$business_level_3_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 8)
				{				
					$function_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 9)
				{				
					$subfunction_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 1 and $w_row["ba_id"] == 136)
				{				
					$sub_subfunction_weightage = $w_row["value"];
				}
				elseif($w_row["type"] == 2)
				{				
					${"custom_name_".$coust_cnt."_weightage"} = $w_row["value"];
					$coust_cnt++;
				}
			}
		}
		
		$actual_achievements_arr = json_decode($users_dtls["actual_achievements"], true);
		$multiplier_rang_dtls = json_decode($rule_dtls["performance_achievement_rangs"], true);
		//echo "<pre>";print_r($users_dtls);die;
		foreach($multiplier_arr_dtls as $m_row)
		{
			$perf_achiev_multiplier = 0;
			$actual_achievement_val = $actual_achievements_arr[$m_row["key"]];
			if($rule_dtls["performance_achievements_multiplier_type"] != 3)//Simple Multiplier of Achievement
			{
				$multiplier_rang_arr = $multiplier_rang_dtls[$m_row["key"]];
				foreach($multiplier_rang_arr as $m_range_row)
				{
					if($actual_achievement_val >= $m_range_row["min"] and $actual_achievement_val < $m_range_row["max"])
					{
						$perf_achiev_multiplier = $m_range_row["multiplier"];
						break;
					}
				}
			}
			
			if($rule_dtls["performance_achievements_multiplier_type"]==3)//Simple Multiplier of Achievement
			{
				${$m_row["key"]."_achievement"} = $actual_achievement_val;
			}
			elseif($rule_dtls["performance_achievements_multiplier_type"]==2)//Decelerated or Accelerated Multiplier
			{
				${$m_row["key"]."_achievement"} = (abs($actual_achievement_val - 100)*$perf_achiev_multiplier)+100;
			}
			else//Single Multiplier condition
			{
				${$m_row["key"]."_achievement"} = $perf_achiev_multiplier;//(${$m_row["key"]."_weightage"} * $perf_achiev_multiplier)/100;
			}
			$total_weightage_score +=  (${$m_row["key"]."_weightage"} * ${$m_row["key"]."_achievement"})/100;
			//echo "<pre>";print_r("Actual ".$m_row["key"]." : ".$actual_achievement_val.", New : ".${$m_row["key"]."_achievement"}.", Multiplier : ".$perf_achiev_multiplier.", Weightage : ".${$m_row["key"]."_weightage"});
			
			
			$dtls_for = "";
			if($m_row["key"]=="business_level_1")
			{
				$dtls_for = $users_dtls['bu1_name'];
			}
			elseif($m_row["key"]=="business_level_2")
			{
				$dtls_for = $users_dtls['bu2_name'];
			}
			elseif($m_row["key"]=="business_level_3")
			{
				$dtls_for = $users_dtls['bu3_name'];
			}
			elseif($m_row["key"]=="function")
			{
				$dtls_for = $users_dtls['function_name'];
			}
			elseif($m_row["key"]=="subfunction")
			{
				$dtls_for = $users_dtls['subfunction_name'];
			}
			elseif($m_row["key"]=="sub_subfunction")
			{
				$dtls_for = $users_dtls['sub_subfunction_name'];
			}
			else
			{
				$dtls_for = $m_row["value"];
			}
			
			//Note :: k=Key or column name, n=Name of the Parameter, w=Weightage, a=Achievement, m=Multiplier
			$weightage_achievement_multiplier_dtls[] = array("k"=>$m_row["key"], "n" =>$dtls_for, "w" =>${$m_row["key"]."_weightage"}, "a" =>${$m_row["key"]."_achievement"}, "m" =>$perf_achiev_multiplier);
		}
		//echo "<pre>";print_r($weightage_achievement_multiplier_dtls);die;
		$final_sip_per = $total_weightage_score;
		$cuurent_emp_sip = ($sip_applied_on_amt*$final_sip_per)/100;
		
		$data = array("sip_applied_on_amt"=>$sip_applied_on_amt, "final_sip_per"=>$final_sip_per, "cuurent_emp_sip_amt"=>$cuurent_emp_sip, "weightage_achievement_multiplier_dtls"=>$weightage_achievement_multiplier_dtls);
		
		//echo "<pre>";print_r($users_dtls);die;
		return $data;
	}

	public function calculate_sip($rule_id, $is_need_to_save_data=0, $send_for_release=0)
	{
		// $is_need_to_save_data = 0 (No) and 1 (Yes)
		$rule_dtls =  $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$all_currency_dtls = $this->rule_model->get_table("manage_currency", "id, name", "status = 1");
		$rule_dtls["weightage_dtls"] = $this->rule_model->get_table("sip_weightage_parameters", "value, type, target_based_on_id, ba_id", "sip_hr_parameter_id = ".$rule_id." AND type != 4", "id ASC");
		$rule_dtls["target_based_on_dtls"] = $this->rule_model->get_table("sip_weightage_parameters", "value, type, target_based_on_id, ba_id", "sip_hr_parameter_id = ".$rule_id." AND type = 4", "id ASC");

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

			$managers_budget_dtls[$key]["manager_emp_arr"] = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM sip_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$value[0]."'");
			$managers_budget_dtls[$key]["bdgt_x_per_exceed_val"] = $value[2];
		}

		//$staff_list = $this->rule_model->get_table("sip_rule_users_dtls", "user_id", array("rule_id"=>$rule_id), "user_id ASC");
		$staff_list = $this->sip_model->get_employees_dtls_for_sip(array("sip_rule_users_dtls.rule_id"=>$rule_id), $rule_dtls["sip_applied_on_elements"], 1);

		//$total_sip_percentage = 0;
		//$total_sip_amt = 0;
		//$total_employee = count($staff_list);
		
		//$cnt = 0;
		$main_db_arr = array();
		foreach($staff_list as $row)
		{
			$employee_id = $row["id"];
			$row["currency_name"] = "";
			foreach($all_currency_dtls as $c_row)
			{
				if($c_row["id"] == $row[CV_BA_NAME_CURRENCY])
				{
					$row["currency_name"] = $c_row["name"];
					break;
				}
			}
			
			$users_dtls = $row;
			$emp_sip_dtls = $this->calculate_sip_emploee_wise($users_dtls, $rule_dtls);
			//$emp_sip_dtls = $this->calculate_sip_emploee_wise($employee_id, $rule_dtls);
			//$users_dtls = $emp_sip_dtls["user_dtls"];
//echo "<pre>";print_r($users_dtls);die;


			
			//$total_sip_percentage += $emp_sip_dtls["final_sip_per"];
			//$total_sip_amt += $emp_sip_dtls["cuurent_emp_sip_amt"];
			//$cnt++;

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

				$emp_final_bdgt = $emp_sip_dtls["cuurent_emp_sip_amt"];
				if($rule_dtls["overall_budget"] == "No limit")
				{
					$emp_final_bdgt = 0;// No limit set for budget
				}
				elseif($rule_dtls["overall_budget"] == "Automated but x% can exceed")
				{
					$emp_final_bdgt += round((($emp_final_bdgt*$bdgt_x_per_exceed_val)/100), 2);
				}

				$db_arr =array(
							"rule_id" => $rule_id,
							"user_id" => $employee_id,
							"target_sip" => $emp_sip_dtls["sip_applied_on_amt"],							
							"emp_final_bdgt" => $emp_final_bdgt,
							"final_sip" => $emp_sip_dtls["cuurent_emp_sip_amt"],
							"final_sip_per" => $emp_sip_dtls["final_sip_per"],
							"actual_sip" => $emp_sip_dtls["cuurent_emp_sip_amt"],
							"actual_sip_per" => $emp_sip_dtls["final_sip_per"],
							"emp_weightage_achievement_dtls"=>json_encode($emp_sip_dtls['weightage_achievement_multiplier_dtls']),
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
							"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"),
							"country" => "",
							"city" => "",
							"business_level_1" => "",
							"business_level_2" => "",
							"business_level_3" => "",							
							"function" => "",
							"sub_function" => "",
							"sub_sub_function" => "",
							"designation" => "",
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
							"currency" => "",
							"current_base_salary" => "",
							"sip_incentive_applicable" => "",
							"current_target_sip" => "",
							"total_compensation" => "",
							"joining_date_for_increment_purposes" => "",
							"joining_date_the_company" => "",
							"start_date_for_role" => "",
							"end_date_the_role" => "",
							"approver_1" => "",
							"approver_2" => "",
							"approver_3" => "",
							"approver_4" => "",
							"manager_name" => "",
							"authorised_signatory_for_letter" => "",
							"authorised_signatory_title_for_letter" => "",
							"hr_authorised_signatory_for_letter" => "",
							"hr_authorised_signatory_title_for_letter" => "");

				if($users_dtls['country_name'])
				{
					$db_arr["country"] = $users_dtls['country_name'];
				}
				if($users_dtls['city_name'])
				{
					$db_arr["city"] = $users_dtls['city_name'];
				}
				if($users_dtls['bu1_name'])
				{
					$db_arr["business_level_1"] = $users_dtls['bu1_name'];
				}
				if($users_dtls['bu2_name'])
				{
					$db_arr["business_level_2"] = $users_dtls['bu2_name'];
				}
				if($users_dtls['bu3_name'])
				{
					$db_arr["business_level_3"] = $users_dtls['bu3_name'];
				}
				if($users_dtls['function_name'])
				{
					$db_arr["function"] = $users_dtls['function_name'];
				}
				if($users_dtls['subfunction_name'])
				{
					$db_arr["sub_function"] = $users_dtls['subfunction_name'];
				}
				
				if($users_dtls['sub_subfunction_name'])
				{
					$db_arr["sub_sub_function"] = $users_dtls['sub_subfunction_name'];
				}
				if($users_dtls['designation_name'])
				{
					$db_arr["designation"] = $users_dtls['designation_name'];
				}
				if($users_dtls['grade_name'])
				{
					$db_arr["grade"] = $users_dtls['grade_name'];
				}
				if($users_dtls['level_name'])
				{
					$db_arr["level"] = $users_dtls['level_name'];
				}
				if($users_dtls['education_name'])
				{
					$db_arr["education"] = $users_dtls['education_name'];
				}
				if($users_dtls['critical_talent_name'])
				{
					$db_arr["critical_talent"] = $users_dtls['critical_talent_name'];
				}
				if($users_dtls['critical_position_name'])
				{
					$db_arr["critical_position"] = $users_dtls['critical_position_name'];
				}
				if($users_dtls['special_category_name'])
				{
					$db_arr["special_category"] = $users_dtls['special_category_name'];
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
				if($users_dtls["currency_name"])
				{
					$db_arr["currency"] = $users_dtls["currency_name"];
				}
				if($users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY])
					$db_arr["current_base_salary"] = $users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY];
				if($users_dtls[CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE])
					$db_arr["sip_incentive_applicable"] = $users_dtls[CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE];
				if($users_dtls[CV_BA_NAME_ALLOWANCE_1])
					$db_arr["current_target_sip"] = $users_dtls[CV_BA_NAME_ALLOWANCE_1];
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
					$db_arr["approver_1"] = $users_dtls[CV_BA_NAME_APPROVER_1];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_2])
				{
					$db_arr["approver_2"] = $users_dtls[CV_BA_NAME_APPROVER_2];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_3])
				{
					$db_arr["approver_3"] = $users_dtls[CV_BA_NAME_APPROVER_3];
				}
				if($users_dtls[CV_BA_NAME_APPROVER_4])
				{
					$db_arr["approver_4"] = $users_dtls[CV_BA_NAME_APPROVER_4];
				}
				if($users_dtls[CV_BA_NAME_MANAGER_NAME])
				{
					$db_arr["manager_name"] = $users_dtls[CV_BA_NAME_MANAGER_NAME];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
					$db_arr["authorised_signatory_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER];
				}
				if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
					$db_arr["authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER])
				{
					$db_arr["hr_authorised_signatory_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER];
				}
				if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
					$db_arr["hr_authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
				//$this->admin_model->insert_data_in_tbl("sip_employee_details", $db_arr);
				$main_db_arr[] = $db_arr;
			}
		}
		
		if($main_db_arr)
		{//echo "<pre>";print_r($main_db_arr);die;
			$this->rule_model->insert_data_as_batch("sip_employee_details", $main_db_arr);
		}
		
		//$data['total_sip_percentage'] = $total_sip_percentage;
		//$data['total_sip_amt'] = $total_sip_amt;
		//$data['total_employee'] = $total_employee;
		return $data;
	}

	public function view_sip_rule_details($rule_id)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));

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
		$request_dtl= $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>6));
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

		$data["sip_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");

		$data['title'] = "View Sip Rule Details";
		$data['body'] = "sip/view_sip_rule_details";
		$this->load->view('common/structure',$data);
	}

	public function send_sip_rule_approval_request($rule_id, $send_for_release=0)
	{
		// Note :: $send_for_release => 1=Need to send rule to release, other than 1 no need to send for release
		$rule_dtls = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		if(!$rule_dtls or $rule_dtls["status"] < 3)
		{
			redirect(site_url("performance-cycle"));
		}

		$this->calculate_sip($rule_id, 1, $send_for_release);

		if($send_for_release == 1)
		{
			$this->sip_model->updateSipRules(array("status"=>6, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s")), array('id'=>$rule_id));

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
			$this->approvel_model->create_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"), 6);
			$this->sip_model->updateSipRules(array("status"=>4, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s")), array('id'=>$rule_id));
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule sent for approval successfully.</b></div>');
		}
		redirect(site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]));
	}

	public function delete_sip_rule($rule_id)
	{
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		//if($data['rule_dtls']  and ($data['rule_dtls']["status"] < 4 or $data['rule_dtls']["status"] == 5))
		if($data['rule_dtls']  and ($data['rule_dtls']["status"] < CV_STATUS_RULE_DELETED))
		{
			if(!helper_have_rights(CV_BONUS_RULES_ID, CV_DELETE_RIGHT_NAME))
			{
				redirect(site_url("sip-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
			}

			$db_arr = array("status"=>CV_STATUS_RULE_DELETED, "updatedBy" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedOn" => date("Y-m-d H:i:s"));
			$this->sip_model->updateSipRules($db_arr, array('id'=>$rule_id));
			$this->sip_model->delete_emp_sip_dtls(array("sip_employee_details.rule_id"=>$rule_id));
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.CV_BONUS_SIP_LABEL_NAME.' rule deleted successfully.</b></div>');
			redirect(site_url("sip-rule-list/".$data['rule_dtls']["performance_cycle_id"]));
		}
		else
		{
			redirect(site_url("performance-cycle"));
		}
	}
}
