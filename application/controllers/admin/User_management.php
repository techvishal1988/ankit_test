<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');	
		$this->load->model("admin_model");
		$this->load->model("common_model");
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{			
			redirect(site_url("dashboard"));			
		}  
		HLP_is_valid_web_token();                     
    }

	public function set_user_rights($user_id)
	{
		if(!helper_have_rights(CV_HR_RIGHTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("staff"));		
		}
		
		$data['msg'] = "";

		if($this->input->post())
		{			
			$uid = $user_id;

			if(in_array('0', $this->input->post("ddl_country")))
			{
				$country_arr = 0;
			}
			else
			{
				$country_arr = implode(",",$this->input->post("ddl_country"));
			}
			
			if(in_array('0', $this->input->post("ddl_city")))
			{
				$city_arr = 0;
			}
			else
			{
				$city_arr = implode(",",$this->input->post("ddl_city"));
			}

			if(in_array('0', $this->input->post("ddl_bussiness_level_1")))
			{
				$bussiness_level_1_arr = 0;
			}
			else
			{
				$bussiness_level_1_arr = implode(",",$this->input->post("ddl_bussiness_level_1"));
			}

			if(in_array('0', $this->input->post("ddl_bussiness_level_2")))
			{
				$bussiness_level_2_arr = 0;
			}
			else
			{
				$bussiness_level_2_arr = implode(",",$this->input->post("ddl_bussiness_level_2"));
			}

			if(in_array('0', $this->input->post("ddl_bussiness_level_3")))
			{
				$bussiness_level_3_arr = 0;
			}
			else
			{
				$bussiness_level_3_arr = implode(",",$this->input->post("ddl_bussiness_level_3"));
			}

			if(in_array('0', $this->input->post("ddl_function")))
			{
				$function_arr = 0;
			}
			else
			{
				$function_arr = implode(",",$this->input->post("ddl_function"));
			}

			if(in_array('0', $this->input->post("ddl_sub_function")))
			{
				$sub_function_arr = 0;
			}
			else
			{
				$sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
			}
			
			if(in_array('0', $this->input->post("ddl_sub_subfunction")))
			{
				$sub_subfunction_arr = 0;
			}
			else
			{
				$sub_subfunction_arr = implode(",",$this->input->post("ddl_sub_subfunction"));
			}

			if(in_array('0', $this->input->post("ddl_designation")))
			{
				$designation_arr = 0;
			}
			else
			{
				$designation_arr = implode(",",$this->input->post("ddl_designation"));
			}

			if(in_array('0', $this->input->post("ddl_grade")))
			{
				$grade_arr = 0;
			}
			else
			{
				$grade_arr = implode(",",$this->input->post("ddl_grade"));
			}
			
			if(in_array('0', $this->input->post("ddl_level")))
			{
				$level_arr = 0;
			}
			else
			{
				$level_arr = implode(",",$this->input->post("ddl_level"));
			}

			/*$country_arr = implode(",",$this->input->post("ddl_country"));
			$city_arr = implode(",",$this->input->post("ddl_city"));
			$bussiness_unit_arr = implode(",",$this->input->post("ddl_bussiness_unit"));
			$function_arr = implode(",",$this->input->post("ddl_function"));
			$sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
			$designation_arr = implode(",",$this->input->post("ddl_designation"));
			$grade_arr = implode(",",$this->input->post("ddl_grade"));*/
			
			$user_dtls = $this->admin_model->get_table_row("login_user", "id, email, role", array("id"=>$user_id), "id desc");
			
			$rights_for_user_id = $user_dtls["id"];
			$role = $user_dtls["role"];
			
			$is_rights_conflict = $this->admin_model->check_user_rights_conflicts($rights_for_user_id, $role, $country_arr, $city_arr, $bussiness_level_1_arr, $bussiness_level_2_arr, $bussiness_level_3_arr, $function_arr, $sub_function_arr, $sub_subfunction_arr, $designation_arr, $grade_arr, $level_arr);
			if($is_rights_conflict)
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Selected rights are conflict with others.</b></div>');
				redirect(site_url("set-user-rights/".$user_id));
			}

			$this->admin_model->update_tbl_data("rights_on_country", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_city", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_business_level_1", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_business_level_2", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_business_level_3", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_functions", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_sub_functions", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_sub_subfunctions", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_designations", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_grades", array( "status" => 2), array("user_id" => $uid, "status" => 1));
			$this->admin_model->update_tbl_data("rights_on_levels", array( "status" => 2), array("user_id" => $uid, "status" => 1));

			if(in_array('0', $this->input->post("ddl_country")))
			{
				$db_arr = array(
							"user_id" => $uid,
							"country_id" => 0,
							"createdby" => $this->session->userdata('userid_ses'),
							"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
							"createdon" => date("Y-m-d H:i:s")
							);
				$this->admin_model->insert_data_in_tbl("rights_on_country", $db_arr);
			}
			else
			{
				foreach($_REQUEST['ddl_country'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"country_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_country", $db_arr);
				}
			}
			
			if(in_array('0', $this->input->post("ddl_city")))
			{
				foreach($_REQUEST['ddl_city'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"city_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_city", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_city'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"city_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_city", $db_arr);
				}
			}

			if(in_array('0', $this->input->post("ddl_bussiness_level_1")))
				{
					foreach($_REQUEST['ddl_bussiness_level_1'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_1_id" => 0,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_1", $db_arr);
					}
				}
				else
				{
					foreach($_REQUEST['ddl_bussiness_level_1'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_1_id" => $value,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_1", $db_arr);
					}
				}

				if(in_array('0', $this->input->post("ddl_bussiness_level_2")))
				{
					foreach($_REQUEST['ddl_bussiness_level_2'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_2_id" => 0,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_2", $db_arr);
					}
				}
				else
				{
					foreach($_REQUEST['ddl_bussiness_level_2'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_2_id" => $value,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_2", $db_arr);
					}
				}

				if(in_array('0', $this->input->post("ddl_bussiness_level_3")))
				{
					foreach($_REQUEST['ddl_bussiness_level_3'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_3_id" => 0,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_3", $db_arr);
					}
				}
				else
				{
					foreach($_REQUEST['ddl_bussiness_level_3'] as $key=> $value) 
					{ 
						$db_arr = array(
									"user_id" => $uid,
									"business_level_3_id" => $value,
									"createdby" => $this->session->userdata('userid_ses'),
									"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									);
						$this->admin_model->insert_data_in_tbl("rights_on_business_level_3", $db_arr);
					}
				}

			if(in_array('0', $this->input->post("ddl_function")))
			{
				foreach($_REQUEST['ddl_function'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"function_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_functions", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_function'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"function_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_functions", $db_arr);
				}
			}

			if(in_array('0', $this->input->post("ddl_sub_function")))
			{
				foreach($_REQUEST['ddl_sub_function'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"sub_function_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_sub_functions", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_sub_function'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"sub_function_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_sub_functions", $db_arr);
				}
			}
			
			if(in_array('0', $this->input->post("ddl_sub_subfunction")))
			{
				foreach($_REQUEST['ddl_sub_subfunction'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"sub_subfunction_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_sub_subfunctions", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_sub_subfunction'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"sub_subfunction_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_sub_subfunctions", $db_arr);
				}
			}

			if(in_array('0', $this->input->post("ddl_designation")))
			{
				foreach($_REQUEST['ddl_designation'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"designation_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_designations", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_designation'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"designation_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_designations", $db_arr);
				}
			}

			if(in_array('0', $this->input->post("ddl_grade")))
			{
				foreach($_REQUEST['ddl_grade'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"grade_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_grades", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_grade'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"grade_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_grades", $db_arr);
				}
			}	
			
			if(in_array('0', $this->input->post("ddl_level")))
			{
				foreach($_REQUEST['ddl_level'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"level_id" => 0,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_levels", $db_arr);
				}
			}
			else
			{
				foreach($_REQUEST['ddl_level'] as $key=> $value) 
				{ 
					$db_arr = array(
								"user_id" => $uid,
								"level_id" => $value,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
								);
					$this->admin_model->insert_data_in_tbl("rights_on_levels", $db_arr);
				}
			}		

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New rights created successfully.</b></div>'); 
			redirect(site_url("hr-list"));
		}

		$data['country_list'] = $this->admin_model->get_table("manage_country","id, name",array("status"=>1));
		/*if(!$data['country_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active country for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['city_list'] = $this->admin_model->get_table("manage_city","id, name",array("status"=>1));
		/*if(!$data['city_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active city for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['bussiness_level_1_list'] = $this->admin_model->get_table("manage_business_level_1","id, name",array("status"=>1));
		$data['bussiness_level_2_list'] = $this->admin_model->get_table("manage_business_level_2","id, name",array("status"=>1));
		$data['bussiness_level_3_list'] = $this->admin_model->get_table("manage_business_level_3","id, name",array("status"=>1));
		/*if(!$data['bussiness_unit_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active business units for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['designation_list'] = $this->admin_model->get_table("manage_designation","id, name",array("status"=>1));
		/*if(!$data['designation_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active designations for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['function_list'] = $this->admin_model->get_table("manage_function","id, name",array("status"=>1));
		/*if(!$data['function_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active functions for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['sub_function_list'] = $this->admin_model->get_table("manage_subfunction","id, name",array("status"=>1));
		$data['sub_subfunction_list'] = $this->admin_model->get_table("manage_sub_subfunction","id, name",array("status"=>1));
		/*if(!$data['sub_function_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active sub functions for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$data['grade_list'] = $this->admin_model->get_table("manage_grade","id, name",array("status"=>1));
		$data['level_list'] = $this->admin_model->get_table("manage_level","id, name",array("status"=>1));
		/*if(!$data['grade_list'])
		{
			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active grades for creating HR Rights.</b></span></div>");
			redirect(site_url("staff"));	
		}*/

		$users_old_right_dtls = $this->admin_model->get_table_row("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		if($users_old_right_dtls)
		{
			$user_cntry_arr = $this->admin_model->get_table("rights_on_country", "country_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_cntry_arr)==1)
			{
				$user_cntry_arr[] = array("id"=>$user_cntry_arr[0]["id"]);
			}				
			$data["users_old_right_dtls"]['countrys'] = $this->common_model->array_value_recursive("id", $user_cntry_arr);
			
			$user_city_arr = $this->admin_model->get_table("rights_on_city", "city_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_city_arr)==1)
			{
				$user_city_arr[] = array("id"=>$user_city_arr[0]["id"]);
			}			
			$data["users_old_right_dtls"]['citys']  = $this->common_model->array_value_recursive("id", $user_city_arr);

			$user_bl_1_arr = $this->admin_model->get_table("rights_on_business_level_1", "business_level_1_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_bl_1_arr)==1)
			{
				$user_bl_1_arr[] = array("id"=>$user_bl_1_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['bl_1']  = $this->common_model->array_value_recursive("id", $user_bl_1_arr);

			$user_bl_2_arr = $this->admin_model->get_table("rights_on_business_level_2", "business_level_2_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_bl_2_arr)==1)
			{
				$user_bl_2_arr[] = array("id"=>$user_bl_2_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['bl_2']  = $this->common_model->array_value_recursive("id", $user_bl_2_arr);

			$user_bl_3_arr = $this->admin_model->get_table("rights_on_business_level_3", "business_level_3_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_bl_3_arr)==1)
			{
				$user_bl_3_arr[] = array("id"=>$user_bl_3_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['bl_3']  = $this->common_model->array_value_recursive("id", $user_bl_3_arr);

//echo "<pre>";print_r($data["users_old_right_dtls"]['bu'] );die;
			$user_desig_arr = $this->admin_model->get_table("rights_on_designations", "designation_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_desig_arr)==1)
			{
				$user_desig_arr[] = array("id"=>$user_desig_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['designations']  = $this->common_model->array_value_recursive("id", $user_desig_arr);

			$user_funct_arr = $this->admin_model->get_table("rights_on_functions", "function_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_funct_arr)==1)
			{
				$user_funct_arr[] = array("id"=>$user_funct_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['functions'] = $this->common_model->array_value_recursive("id", $user_funct_arr);

			$user_sub_funct_arr = $this->admin_model->get_table("rights_on_sub_functions", "sub_function_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_sub_funct_arr)==1)
			{
				$user_sub_funct_arr[] = array("id"=>$user_sub_funct_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['sub_functions']  = $this->common_model->array_value_recursive("id", $user_sub_funct_arr);
			
			
			
			$user_sub_subfunct_arr = $this->admin_model->get_table("rights_on_sub_subfunctions", "sub_subfunction_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_sub_subfunct_arr)==1)
			{
				$user_sub_subfunct_arr[] = array("id"=>$user_sub_subfunct_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['sub_subfunctions']  = $this->common_model->array_value_recursive("id", $user_sub_subfunct_arr);
			

			$user_grd_arr = $this->admin_model->get_table("rights_on_grades", "grade_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_grd_arr)==1)
			{
				$user_grd_arr[] = array("id"=>$user_grd_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['grades']  = $this->common_model->array_value_recursive("id", $user_grd_arr);
			
			$user_lvl_arr = $this->admin_model->get_table("rights_on_levels", "level_id as id", array("status"=>1, "user_id"=>$user_id));
			if(count($user_lvl_arr)==1)
			{
				$user_lvl_arr[] = array("id"=>$user_lvl_arr[0]["id"]);
			}
			$data["users_old_right_dtls"]['levels']  = $this->common_model->array_value_recursive("id", $user_grd_arr);

			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Rights already created for this user.</b></div>';
			//echo "<pre>";print_r($data["users_old_right_dtls"]);
		}

		$data['title'] = "Set User Rights";
		$data['body'] = "admin/set_user_rights";
		$this->load->view('common/structure',$data);		
	}

	public function view_user_right_details($role_id)
	{
		$data["msg"]="";
		if(!helper_have_rights(CV_HR_RIGHTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></span></div>');
			redirect(site_url("no-rights"));		
		}
		
	if(!helper_have_rights(CV_HR_RIGHTS_ID, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';		
		}
		if($role_id=='')
		{
			redirect(site_url("view-roles"));
		}
		$users = $this->admin_model->get_role_wise_users_for_view_rights($role_id);
		$tempArr = array();
		if($users)
		{ 
			$i = 0; $j = 0;
			foreach ($users as $row)
			{
			//echo $row['user_id'];	  die; 
				//$user_country_list =  $this->admin_model->get_table("rights_on_country","country_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$country_arr = $this->common_model->get_value_coma_seprated($user_country_list, "country_id");
				$tempArr[$i]['country_list'] = $this->admin_model->get_table("manage_country","id, name", "id in (select country_id from rights_on_country where status=1 and user_id = ".$row["user_id"].")", "name asc");
			
				//$user_city_list =  $this->admin_model->get_table("rights_on_city","city_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$city_arr =  $this->common_model->get_value_coma_seprated($user_city_list, "city_id");
				$tempArr[$i]['city_list'] = $this->admin_model->get_table("manage_city","id, name", "id in (select city_id from rights_on_city where status=1 and user_id = ".$row["user_id"].")", "name asc");

				//$user_bu_list =  $this->admin_model->get_table("rights_on_business_units","business_unit_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$bu_arr = $this->common_model->get_value_coma_seprated($user_bu_list, "business_unit_id");
				$tempArr[$i]['bussiness_level_1_list'] = $this->admin_model->get_table("manage_business_level_1","id, name", "id in (select business_level_1_id from rights_on_business_level_1 where status=1 and user_id = ".$row["user_id"].")", "name asc");
				$tempArr[$i]['bussiness_level_2_list'] = $this->admin_model->get_table("manage_business_level_2","id, name", "id in (select business_level_2_id from rights_on_business_level_2 where status=1 and user_id = ".$row["user_id"].")", "name asc");
				$tempArr[$i]['bussiness_level_3_list'] = $this->admin_model->get_table("manage_business_level_3","id, name", "id in (select business_level_3_id from rights_on_business_level_3 where status=1 and user_id = ".$row["user_id"].")", "name asc");

				//$user_designation_list =  $this->admin_model->get_table("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$designation_arr = $this->common_model->get_value_coma_seprated($user_designation_list, "designation_id");
				$tempArr[$i]['designation_list'] = $this->admin_model->get_table("manage_designation","id, name", "id in (select designation_id from rights_on_designations where status=1 and user_id = ".$row["user_id"].")", "name asc");

				//$user_function_list =  $this->admin_model->get_table("rights_on_functions","function_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$function_arr = $this->common_model->get_value_coma_seprated($user_function_list, "function_id");
				$tempArr[$i]['function_list'] = $this->admin_model->get_table("manage_function","id, name", "id in (select function_id from rights_on_functions where status=1 and user_id = ".$row["user_id"].")", "name asc");

				//$user_sub_function_list =  $this->admin_model->get_table("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$sub_function_arr = $this->common_model->get_value_coma_seprated($user_sub_function_list, "sub_function_id");
				$tempArr[$i]['sub_function_list'] = $this->admin_model->get_table("manage_subfunction","id, name", "id in (select sub_function_id from rights_on_sub_functions where status=1 and user_id = ".$row["user_id"].")", "name asc");
				
				$tempArr[$i]['sub_subfunction_list'] = $this->admin_model->get_table("manage_sub_subfunction","id, name", "id in (select sub_subfunction_id from rights_on_sub_subfunctions where status=1 and user_id = ".$row["user_id"].")", "name asc");

				//$user_grade_list =  $this->admin_model->get_table("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$row["user_id"]));
				//$grade_arr = $this->common_model->get_value_coma_seprated($user_grade_list, "grade_id");
				$tempArr[$i]['grade_list'] = $this->admin_model->get_table("manage_grade","id, name", "id in (select grade_id from rights_on_grades where status=1 and user_id = ".$row["user_id"].")", "name asc");
				$tempArr[$i]['level_list'] = $this->admin_model->get_table("manage_level","id, name", "id in (select level_id from rights_on_levels where status=1 and user_id = ".$row["user_id"].")", "name asc");
				
				$tempArr[$i]['user_dtls'] = $this->admin_model->get_table_row("login_user", "*", array("id"=>$row['user_id']), "id desc");
				$role[$i] = $this->admin_model->get_table_row("roles", "*", array("id"=>$tempArr[$i]['user_dtls']['role']), "id desc");

				$rights_details[$i]  = array(
									'user_name' => $tempArr[$i]['user_dtls']['name'],
									'user_id' => $row["user_id"],
									'role_id' => $role_id,
									'role' => $role[$i]['name'], 
									'country_list' => $tempArr[$i]['country_list'],
									'city_list' => $tempArr[$i]['city_list'], 
									'bussiness_level_1_list' => $tempArr[$i]['bussiness_level_1_list'],
									'bussiness_level_2_list' => $tempArr[$i]['bussiness_level_2_list'],
									'bussiness_level_3_list' => $tempArr[$i]['bussiness_level_3_list'],
									'designation_list' => $tempArr[$i]['designation_list'],
									'function_list' => $tempArr[$i]['function_list'],
									'sub_function_list' => $tempArr[$i]['sub_function_list'],
									'sub_subfunction_list' => $tempArr[$i]['sub_subfunction_list'],
									'grade_list' => $tempArr[$i]['grade_list'],
									'level_list' => $tempArr[$i]['level_list']);
					//echo "<pre>";print_r($rights_details);
				$i++;
			}
			$data['rights_details'] = $rights_details;	   
			$data["emp_not_any_cycle_counts"] = $this->employee_not_in_hr_criteria();
		}
		else
		{
			$data['rights_details'] = "";	
			$data["emp_not_any_cycle_counts"] = 0;   
		//$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>No rights found for the selected user.</b></span></div>");
		//redirect(site_url("staff"));
		}
		$data['title'] = "View User Rights";
		$data['body'] = "admin/view_user_rights";
		$this->load->view('common/structure',$data); 
 	}
	
	public function view_role_permissions($role_id)
	{
//            echo '<pre />';
//            print_r($this->session->userdata() ); die;
		$data['msg'] = "";
		if(!helper_have_rights(CV_ROLE_PERMISSION, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></div>');
			redirect(site_url("no-rights"));		
		}
		
		if(!helper_have_rights(CV_ROLE_PERMISSION, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';		
		}
			
		if($role_id==1)
		{
			redirect(site_url("view-roles"));
		}	
		if($this->input->post())
		{
			if(!helper_have_rights(CV_ROLE_PERMISSION, CV_INSERT_RIGHT_NAME))
			{
                           
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>');
				redirect(site_url("view-roles"));		
			}
			
			if(!helper_have_rights(CV_ROLE_PERMISSION, CV_INSERT_RIGHT_NAME))
			{
                             echo 'here '; die;
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
				redirect(site_url("view-roles"));		
			}
			
			$this->admin_model->update_tbl_data("role_permissions", array('view' => '0', 'insert' => '0', 'update' => '0', 'delete' => '0', 'updatedon'=>date('Y-m-d H:i:s')), array('role_id' =>$role_id));

			if(isset($_REQUEST["chk_view"]))
			{
				foreach ($_REQUEST["chk_view"] as $key => $value) 
				{
					$data = $this->admin_model->get_table_row("role_permissions", "id, view, insert, update, delete", array('role_id'=>$role_id, 'page_id'=>$value));
					if($data)
					{
						$this->admin_model->update_tbl_data("role_permissions",
                                                                        array("view"=>1,'insert' => 0,
									'update' => 0,
									'delete'=>0, 'updatedon'=>date('Y-m-d H:i:s')), array('page_id' =>$value, 'role_id'=>$role_id));
					}
					else
					{
						$arr  = array('view' => 1,
									'insert' => 0,
									'update' => 0,
									'delete'=>0, 
									'role_id'=>$role_id,
									'page_id'=>$value,
									'updatedon'=>date('Y-m-d H:i:s'),
									'createdon'=>date('Y-m-d H:i:s'));
						$this->admin_model->insert_data_in_tbl("role_permissions", $arr);
					}
				}
			}

			if(isset($_REQUEST["chk_insert"]))
			{
				foreach ($_REQUEST["chk_insert"] as $key => $value) 
				{
					$data = $this->admin_model->get_table_row("role_permissions", "id, view, insert, update, delete", array('role_id'=>$role_id, 'page_id'=>$value));

					if($data)
					{
						$this->admin_model->update_tbl_data("role_permissions", 
                                                                   array('view' => 1,
									'insert' => 1,
									'update' => 1,
									'delete'=>1, 'updatedon'=>date('Y-m-d H:i:s')), array('page_id' =>$value, 'role_id'=>$role_id));
					}
					else
					{
						$arr  = array('view' => 1,
									'insert' => 1,
									'update' => 1,
									'delete'=>1, 
									'role_id'=>$role_id,
									'page_id'=>$value,
									'updatedon'=>date('Y-m-d H:i:s'),
									'createdon'=>date('Y-m-d H:i:s'));
						$this->admin_model->insert_data_in_tbl("role_permissions", $arr);
					}
				}
			}

			/*if(isset($_REQUEST["chk_update"]))
			{
				foreach ($_REQUEST["chk_update"] as $key => $value) 
				{
					$data = $this->admin_model->get_table_row("role_permissions", "id, view, insert, update, delete", array('role_id'=>$role_id, 'page_id'=>$value));

					if($data)
					{
						$this->admin_model->update_tbl_data("role_permissions", array("update"=>1, 'updatedon'=>date('Y-m-d H:i:s')), array('page_id' =>$value, 'role_id'=>$role_id ));
					}
					else
					{
						$arr  = array('view' => 0,
								'insert' =>0,
								'update' => 1,
								'delete'=>0, 
								'role_id'=>$role_id,
								'page_id'=>$value,
								'updatedon'=>date('Y-m-d H:i:s'),
								'createdon'=>date('Y-m-d H:i:s'));
						$this->admin_model->insert_data_in_tbl("role_permissions", $arr);
					}
				}
			}

			if(isset($_REQUEST["chk_delete"]))
			{
				foreach ($_REQUEST["chk_delete"] as $key => $value) 
				{
					$data = $this->admin_model->get_table_row("role_permissions", "id, view, insert, update, delete", array('role_id'=>$role_id, 'page_id'=>$value));

					if($data)
					{
						$this->admin_model->update_tbl_data("role_permissions", array("delete"=>1, 'updatedon'=>date('Y-m-d H:i:s')), array('page_id' =>$value, 'role_id'=>$role_id));
					}
					else
					{
						$arr  = array('view' => 0,
								'insert' =>0,
								'update' => 0,
								'delete'=>1, 
								'role_id'=>$role_id,
								'page_id'=>$value,
								'updatedon'=>date('Y-m-d H:i:s'),
								'createdon'=>date('Y-m-d H:i:s'));
						$this->admin_model->insert_data_in_tbl("role_permissions", $arr);
					}
				}
			}
                        */

			$roles_dtl = $this->admin_model->get_table_row("roles", "*", array("id"=>$role_id));
			$this->common_model->set_permissions_session_arr();
			
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Role '.$roles_dtl["name"].' permissions saved successfully.</b></div>'); 
			redirect(site_url("view-roles"));
		}
		$data['role']=$this->admin_model->get_role_info($role_id);
		$data['pages_details'] = $this->admin_model->get_table("pages", "pages.name as page_name, pages.id as page_id", array("status"=>1));
		$role_permissions = $this->admin_model->get_role_permission_details($role_id);
		$data['role_permissions'] = json_encode($role_permissions);
		$data['title'] = "Role Permissions";
		$data['body'] = "admin/view_role_permission.php";
		$this->load->view('common/structure',$data);
	}

	public function view_roles()
	{
		if(!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></div>');
			redirect(site_url("no-rights"));		
		}
		
		$data['msg'] = "";		
		$data['roles'] = $this->admin_model->get_table("roles", "*", array("id >"=>1, "id <"=>12));				
		$data['title'] = "Roles";
		$data['body'] = "admin/role_list";
		$this->load->view('common/structure',$data);		
	}

	public function employee_not_in_hr_criteria($is_need_to_show=0)
	{
		$users = $this->admin_model->get_users_for_view_rights();
		$user_ids_arr = array();

		foreach ($users as $row)
		{
			$user_id = $row["user_id"];
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

			//$where ="login_user.role > 1 and login_user.status = 1";
			$where ="login_user.role > 2 and login_user.status = 1";
			if($country_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_COUNTRY." in (".$country_arr_view.")";
			}
			
			if($city_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_CITY." in (".$city_arr_view.")";
			}

			if($bl1_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." in (".$bl1_arr_view.")";
			}

			if($bl2_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." in (".$bl2_arr_view.")";
			}

			if($bl3_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." in (".$bl3_arr_view.")";
			}

			if($function_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_FUNCTION." in (".$function_arr_view.")";
			}

			if($sub_function_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_SUBFUNCTION." in (".$sub_function_arr_view.")";
			}
			
			if($sub_subfunction_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_SUB_SUBFUNCTION." in (".$sub_subfunction_arr_view.")";
			}

			if($designation_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_DESIGNATION." in (".$designation_arr_view.")";
			}

			if($grade_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_GRADE." in (".$grade_arr_view.")";
			}
			
			if($level_arr_view)
			{
				$where .= " and login_user.".CV_BA_NAME_LEVEL." in (".$level_arr_view.")";
			}
			
			$employees = $this->admin_model->get_employees_as_per_rights($where);
			if($employees)
			{
				foreach($employees as $row)
				{
					$user_ids_arr[] = $row["id"];
				}
			}
		}
		
		if($user_ids_arr)
		{
			$user_ids_arr = "login_user.id not in (".implode(",",$user_ids_arr).")";
		}
		
		$data['staff_list'] = $this->admin_model->get_staff_list($user_ids_arr);
		if($is_need_to_show)
		{	
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
			$data['is_hr'] = "1";		
			$data['title'] = "Staffs";
			$data['body'] = "not_any_cycle_staff_list";
			$this->load->view('common/structure',$data);
		}
		else
		{
			return count($data['staff_list']);
		}
	}

}
