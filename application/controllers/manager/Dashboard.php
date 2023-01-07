<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{	 
	public function __construct()
	{		
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
		$this->load->model("manager_model");
		$this->load->model("rule_model");
		$this->load->model("front_model");
		$this->load->model("admin_model");
		$this->load->model("bonus_model");
		$this->load->model("sip_model");
		$this->load->model("lti_rule_model");
		$this->load->model('performance_cycle_model');
		$this->load->model("common_model");
		$this->lang->load('message', 'english');
		$this->first_approver_arr = array();
		$this->session->set_userdata(array('sub_session'=>10));

		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or ($this->session->userdata('role_ses') != 10 and $this->session->userdata('role_ses') != 9 and $this->session->userdata('is_manager_ses')==0))
		{
			if($this->session->userdata('role_ses') < 10 and $this->router->fetch_method() == 'self_view')
			{
				//User go with this request
			}
			else
			{
				redirect(site_url("dashboard"));
			}			
		}
		HLP_is_valid_web_token();
	}
	
	// code by om
	public function myteam()
	{
		$data['title'] = "Manager Team";
		$data['body'] = "manager/team";
		$this->load->view('common/structure',$data);
	}
    // end code by om
	
	public function self_view()
	{
		// $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');
		// redirect(site_url("no-rights"));
			
		$this->session->set_userdata(array('sub_session'=>11));
		$data['title'] = "Manager self view";
		$data['body'] = "manager/self_view";
		$this->load->view('common/structure',$data);
	}
	
	public function view_manager_emps()
	{
		if(!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');
			redirect(site_url("no-rights"));		
		}
		
		$data['msg'] = "";		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps();	

		$data['title'] = "Manager Employees";
		$data['body'] = "manager/view_manager_emps";
		$this->load->view('common/structure',$data);
	}
	
	public function view_emplyoee_details($empId)
	{
		if(!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');
			redirect(site_url("no-rights"));		
		}
		
		$data['msg'] = "";
		$tupleData = $this->admin_model->staffDetails($empId);
		$data['staffDetail'] = $this->admin_model->completeStafDetails(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));

		// echo "<pre>";print_r($data['staffDetail']);die();
		$data['title'] = "Staffs";
		$data['body'] = "admin/view_emp_details.php";
		$this->load->view('common/structure',$data);
	}

	public function view_increments_bonus_list($ruleID)
	{
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}

		$data['msg'] = "";	
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$ruleID, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		
		$data['is_open_frm_manager_side'] = "1";
		$sdt = $data['rule_dtls']["start_date"];
		$edt = $data['rule_dtls']["end_date"];
		$cdt = date("Y-m-d");		
		if($sdt > $cdt or $edt < $cdt)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid rule.</b></div>');
			redirect(site_url("dashboard"));
		}

		$staff_list = $this->manager_model->list_of_manager_emps_for_bonus_increment($ruleID);	
		$temp_arr = array();
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}
		$data["staff_list"] = $temp_arr;        
//                $stf=[];
//                foreach($data["staff_list"] as $rs)
//                {
//                    if($rs['rule_id']==$ruleID)
//                    {
//                       $stf[]=$rs;
//                    }
//                }
//                $data["staff_list"]=$stf;
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['title'] = "View Bonus Increment";
		$data['body'] = "view_bonus_increment_index";
		$this->load->view('common/structure',$data);
	}

//************************************ Functionality Start For SIP Rules ****************************
	public function sip_rules()
	{
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";
		$current_dt = date("Y-m-d");
		$rule_list = $this->performance_cycle_model->get_sip_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "sip_hr_parameter.status >="=>6,"sip_hr_parameter.status <"=>CV_STATUS_RULE_RELEASED, "sip_hr_parameter.status !=" => CV_STATUS_RULE_DELETED));
		
		foreach($rule_list as $row)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM sip_rule_users_dtls WHERE rule_id = ".$row["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $row['id'];
				$rule_dtls = $row;
				$temp_arr = array();
				
				$staff_list = $this->sip_model->get_rule_wise_emp_list_for_sip(array("sip_employee_details.rule_id"=>$ruleID, "sip_employee_details.manager_emailid"=>$this->session->userdata('email_ses')));	
				if($staff_list)
				{
					$self_usrs_arr = array();
					$other_usrs_arr = array();
					foreach($staff_list as $emp_row)
					{
						if(strtoupper($emp_row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
						{
							$self_usrs_arr[] = $emp_row;
						}
						else
						{
							$other_usrs_arr[] = $emp_row;
						}
					}
					$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
				}
				$row['staff_list'] = $temp_arr;
				$data['rule_list'][] = $row;
			}
		}
//echo "<pre>";print_r($data);die;
		// released bonus rules
		$rule_list_released=$this->performance_cycle_model->get_sip_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "sip_hr_parameter.status"=>CV_STATUS_RULE_RELEASED));
		foreach($rule_list_released as $row)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM sip_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $row['id'];
				$rule_dtls = $row;

				$temp_arr = array();
				$staff_list = $this->sip_model->get_rule_wise_emp_list_for_sip(array("sip_employee_details.rule_id"=>$ruleID, "sip_employee_details.manager_emailid"=>$this->session->userdata('email_ses')));	
				if($staff_list)
				{
					$self_usrs_arr = array();
					$other_usrs_arr = array();
					foreach($staff_list as $emp_row)
					{
						if(strtoupper($emp_row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
						{
							$self_usrs_arr[] = $emp_row;
						}
					}
					$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
				}
				$row['staff_list'] = $temp_arr;
				$data['rule_list_released'][]=$row;
			}
		}

		$data['business_attributes'] =$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['is_open_frm_manager_side'] = "1";
		$data['b_title']= CV_BONUS_SIP_LABEL_NAME.' Rules';
		$data['title'] = $data['b_title'];
		$data['body'] = "manager/sip_rule_list";
		$data['print_url']='printpreview-bonus';
		$this->load->view('common/structure',$data);  
	}
	
	public function view_employee_sip_dtls($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "sip_hr_parameter.id"=>$rule_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		$condition_arr = array("sip_employee_details.rule_id"=>$rule_id, "sip_employee_details.manager_emailid"=>$this->session->userdata('email_ses'));
		if($data['rule_dtls']["status"]==CV_STATUS_RULE_RELEASED)
		{
			$condition_arr["sip_employee_details.status"]=5;
		}
		
		$data["staff_list"] = $this->sip_model->get_rule_wise_emp_list_for_sip($condition_arr);
		$current_usr_index = array_search($user_id, array_column($data["staff_list"], 'user_id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}			
		$data['is_open_frm_manager_side'] = "1";
		
		if($this->input->post("txt_target_sip_amt") and $this->input->post("txt_target_sip_amt") > 0 and $this->input->post("hf_emp_sip_id") > 0)
		{
			$emp_sip_dtls = $this->sip_model->get_employee_sip_dtls(array("sip_employee_details.rule_id"=>$rule_id, "sip_employee_details.user_id"=>$user_id, "sip_employee_details.manager_emailid" => $this->session->userdata('email_ses'), "sip_employee_details.status <"=>5));
			
			if(!empty($emp_sip_dtls) and strtolower($emp_sip_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and $data['rule_dtls']["status"] == 6)
			{
				$new_sip_amt = $this->input->post("txt_target_sip_amt");
				$new_per = ($this->input->post("txt_target_sip_amt")/$emp_sip_dtls["target_sip"])*100;
				
				$manager_max_incr_per = $emp_sip_dtls["actual_sip_per"] + ($emp_sip_dtls["actual_sip_per"]*$emp_sip_dtls["manager_discretionary_increase"]/100);
				$manager_max_dec_per = $emp_sip_dtls["actual_sip_per"] - ($emp_sip_dtls["actual_sip_per"]*$emp_sip_dtls["manager_discretionary_decrease"]/100);
				
				if($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per)
				{
					$manager_emps_total_budget = 0;
					$manager_emps_total_budget_for_msg = 0;
					
					$manager_emps_total_budget_arr = $this->rule_model->get_table_row("sip_employee_details", "SUM(final_sip) AS final_sip", array("rule_id"=>$rule_id, "approver_1"=>$this->session->userdata('email_ses')), "id desc");
					if($manager_emps_total_budget_arr)
					{
						$manager_emps_total_budget = $manager_emps_total_budget_arr["final_sip"];
						$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
					}
					
					$manager_emps_total_budget = $manager_emps_total_budget - $emp_sip_dtls["final_sip"];
					$total_max_budget = 0;
					$budget_percent_incr =0;

					$managers_arr = json_decode($data['rule_dtls']['manual_budget_dtls'],true);
					foreach($managers_arr as $key => $value)
					{
						if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
						{
							$total_max_budget = round($value[1] + (($value[1]*$value[2])/100));
							$budget_percent_incr = $value[2];
						}
					}

					if($total_max_budget >= ($manager_emps_total_budget + $new_sip_amt))
					{
						$this->manager_model->update_tbl_data("sip_employee_details", array("final_sip"=>$new_sip_amt, "final_sip_per"=>$new_per,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$this->input->post("hf_emp_sip_id")));
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data successfully updated.</b></div>');
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Exceed your budget by allotted budget. You have only left '. ($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.</b></div>');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Increase/decrease percentage out of your limit.</b></div>');					
				}
				redirect(site_url("manager/view-employee-sip-dtls/".$rule_id."/".$user_id));
			}
		}
		
		$data['sip_dtls'] = $this->sip_model->get_employee_sip_dtls(array("sip_employee_details.rule_id"=>$rule_id, "sip_employee_details.user_id"=>$user_id));
		
		$data['rule_id']=$rule_id;
		$data['title'] = "Increments Report";
		$data['body'] = "sip/view_emp_sip_dtl";
		$this->load->view('common/structure',$data);	
	}
	
//************************************ Functionality Start For SIP Rules ****************************




//************************************ Functionality Start For Bonus Rules ****************************

	public function bonus_rules()
	{
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";
		$current_dt = date("Y-m-d");
		$rule_list = $this->performance_cycle_model->get_bonus_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter_bonus.status >="=>6,"hr_parameter_bonus.status <"=>CV_STATUS_RULE_RELEASED, "hr_parameter_bonus.status !=" => CV_STATUS_RULE_DELETED));
		foreach($rule_list as $emps)
		{
			//$ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids']);
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $emps['id'];
				$rule_dtls = $emps;

				$sdt = $rule_dtls["start_date"];
				$edt = $rule_dtls["end_date"];
				$cdt = date("Y-m-d");		
				$temp_arr = array();
				if(!($sdt > $cdt or $edt < $cdt))
				{	
					$staff_list = $this->manager_model->list_of_manager_emps_for_bonus_increment($ruleID);	
					if($staff_list)
					{
						$self_usrs_arr = array();
						$other_usrs_arr = array();
						foreach($staff_list as $row)
						{
							if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
							{
								$self_usrs_arr[] = $row;
							}
							else
							{
								$other_usrs_arr[] = $row;
							}
						}
						$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
					}
				}
				$emps['staff_list'] = $temp_arr;
				$data['rule_list'][] = $emps;
			}
		}

		// released bonus rules
		$rule_list_released=$this->performance_cycle_model->get_bonus_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter_bonus.status"=>CV_STATUS_RULE_RELEASED));
		foreach($rule_list_released as $emps)
		{
			//$ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids']);
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $emps['id'];
				$rule_dtls = $emps;

				$sdt = $rule_dtls["start_date"];
				$edt = $rule_dtls["end_date"];
				$cdt = date("Y-m-d");		
				$temp_arr = array();
				if(!($sdt > $cdt or $edt < $cdt))
				{	
					$staff_list = $this->manager_model->list_of_manager_emps_for_bonus_increment($ruleID);	
					if($staff_list)
					{
						$self_usrs_arr = array();
						$other_usrs_arr = array();
						foreach($staff_list as $row)
						{
							if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
							{
								$self_usrs_arr[] = $row;
							}
							else
							{
								// $other_usrs_arr[] = $row;
							}
						}
						$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
					}
				}
				$emps['staff_list'] = $temp_arr;
				$data['rule_list_released'][]=$emps;
			}
		}

		$data['business_attributes'] =$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['is_open_frm_manager_side'] = "1";
		$data['b_title']= CV_BONUS_LABEL_NAME.' / '. CV_BONUS_SIP_LABEL_NAME.' Rules';
		$data['url']="view-employee-bonus-increments";	
		$data['title'] = $data['b_title'];
		$data['body'] = "manager/bonus_rule_list";
		$data['label']= $data['b_title']." List";
		$data['print_url']='printpreview-bonus';
		// $data['print_url']='manager/dashboard/print_data_bonus';
		$this->load->view('common/structure',$data);  
	}
	
	public function view_emp_bonus_increment_dtls($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		
		/*//Note :: Start :: Redirect on View SIP Rule ********************************
		if($data["rule_dtls"]["type"]== CV_PERFORMANCE_CYCLE_SALES_ID)
		{
			redirect(site_url("manager/sip/view_emp_sip_increment_dtls/".$rule_id."/".$user_id));
		}
		//Note :: End :: Redirect on View SIP Rule *********************************/
		
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_bonus_increment_after_released($rule_id);//$this->manager_model->list_of_manager_emps_for_bonus_increment($rule_id);
		$current_usr_index = array_search($user_id, array_column($data["staff_list"], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}			
		$data['is_open_frm_manager_side'] = "1";
		
		if($this->input->post("txt_target_bonus_amt") and $this->input->post("txt_target_bonus_amt") > 0 and $this->input->post("hf_emp_bonus_id") > 0)
		{
			$bonus_dtls = $this->manager_model->get_employee_bonus_dtls_for_manager_discretions(array("employee_bonus_details.id"=>$this->input->post("hf_emp_bonus_id"), "employee_bonus_details.manager_emailid" => $this->session->userdata('email_ses'), "hr_parameter_bonus.status"=>6, "employee_bonus_details.status <"=>5));
			
			if(!empty($bonus_dtls) and strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')))
			{
				$increased_bonus = $this->input->post("txt_target_bonus_amt");
				$new_per = ($this->input->post("txt_target_bonus_amt")/$bonus_dtls["target_bonus"])*100;
				
				/*$manager_max_incr_per = $bonus_dtls["actual_bonus_per"]+$bonus_dtls["manager_discretionary_increase"];
				$manager_max_dec_per = $bonus_dtls["actual_bonus_per"]-$bonus_dtls["manager_discretionary_decrease"];*/
				
				$manager_max_incr_per = $bonus_dtls["actual_bonus_per"] + ($bonus_dtls["actual_bonus_per"]*$bonus_dtls["manager_discretionary_increase"]/100);
				$manager_max_dec_per = $bonus_dtls["actual_bonus_per"] - ($bonus_dtls["actual_bonus_per"]*$bonus_dtls["manager_discretionary_decrease"]/100);
				
				if($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per)
				{
					$manager_emps_total_budget = 0;
					$manager_emps_total_budget_for_msg = 0;
					$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_bonus_budget($bonus_dtls["rule_id"], $bonus_dtls["first_approver"]);

					if($manager_emps_total_budget_arr)
					{
						$manager_emps_total_budget = $manager_emps_total_budget_arr["final_bonus"];
						$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
					}
					
					$manager_emps_total_budget = $manager_emps_total_budget - $bonus_dtls["final_bonus"];
					$total_max_budget = 0;
					$budget_percent_incr =0;

					$managers_arr = json_decode($bonus_dtls['manual_budget_dtls'],true);
					foreach($managers_arr as $key => $value)
					{
						if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
						{
							$total_max_budget = round($value[1] + (($value[1]*$value[2])/100));
							$budget_percent_incr = $value[2];
						}
					}

					if($total_max_budget >= ($manager_emps_total_budget + $increased_bonus))
					{
						$this->manager_model->update_tbl_data("employee_bonus_details", array("final_bonus"=>$increased_bonus, "final_bonus_per"=>$new_per,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$this->input->post("hf_emp_bonus_id")));
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data successfully updated.</b></div>');
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Exceed your budget by allotted budget. You have only left '. ($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.</b></div>');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Increase/decrease percentage out of your limit.</b></div>');					
				}
				redirect(site_url("manager/view-employee-bonus-increments/".$rule_id."/".$user_id));
			}
		}
		
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
		$data['rule_id']=$rule_id;
		$data['title'] = "Increments Report";
		$data['body'] = "manager/view_emp_bonus_dtl";
		$this->load->view('common/structure',$data);	
	}
	
	public function view_emp_bonus_increment_dtls_released($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_BONUS_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");		
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.status"=>CV_STATUS_RULE_RELEASED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}	
		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_bonus_increment_after_released($rule_id);
		$current_usr_index = array_search($user_id, array_column($data["staff_list"], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}
		
		$data['is_open_frm_manager_side'] = "1";		
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
		$data['rule_id']=$rule_id;
		$data['title'] = "Increments Report";
		$data['body'] = "manager/view_emp_bonus_dtl_released";
		$this->load->view('common/structure',$data);	
	}  
	
	public function send_bonus_for_next_level($RuleID)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_edit_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");		
		$ruleDtls = $this->bonus_model->get_bonus_rule_dtls(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter_bonus.id"=>$RuleID, "hr_parameter_bonus.status <"=>CV_STATUS_RULE_RELEASED, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		if(!$ruleDtls  or $ruleDtls["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		$manager_all_users_arr = $this->manager_model->list_of_manager_emps_for_bonus_increment($RuleID);
		if($manager_all_users_arr)
		{
			$rule_id = $manager_all_users_arr[0]["rule_id"];
			$manager_emailid = $this->session->userdata('email_ses');
			$manager_current_users_arr = $this->rule_model->get_table("employee_bonus_details", "user_id", array("rule_id"=>$rule_id, "manager_emailid"=>$manager_emailid, "employee_bonus_details.status <"=>5));

			if(count($manager_all_users_arr) == count($manager_current_users_arr))
			{
				$flag = 0;
				foreach ($manager_all_users_arr as $row)
				{
					$new_manager_emailid = "";
					$status = 1;
					if($row["req_status"] == 1)
					{
						$status = 2;
						$new_manager_emailid = $row["second_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["second_approver"]))
						{
							$status = 3;
							$new_manager_emailid = $row["third_approver"];
							if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
							{
								$status = 4;
								$new_manager_emailid = $row["fourth_approver"];
								if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
								{
									$status = 5;
								}
							}
						}
						
					}
					elseif($row["req_status"] == 2)
					{
						$status = 3;
						$new_manager_emailid = $row["third_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
						{
							$status = 4;
							$new_manager_emailid = $row["fourth_approver"];
							if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
							{
								$status = 5;
							}
						}
					}
					elseif($row["req_status"] == 3)
					{
						$status = 4;
						$new_manager_emailid = $row["fourth_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
						{
							$status = 5;
						}
					}
					elseif($row["req_status"] == 4)
					{
						$status = 5;
						$new_manager_emailid = $row["fourth_approver"];
					}

					if($new_manager_emailid)
					{
						$flag = 1;
						$this->manager_model->update_tbl_data("employee_bonus_details", array("last_action_by"=>$manager_emailid, "manager_emailid"=>$new_manager_emailid, "status"=>$status,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$row["tbl_pk_id"]));
					}					
				}
				if($flag)
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Request sent for next level successfully.</b></div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid request.</b></div>');
			}
		}
		redirect(site_url("dashboard"));
	}
	
	public function reject_emp_bonus_increment()
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$this->form_validation->set_rules('emp_bonus_dtl_tbl_pk_ids', 'PK Ids', 'trim|required');
		$this->form_validation->set_rules('txt_remark', 'Remark', 'trim|required');

		if($this->form_validation->run())
		{
			$rmark = $this->input->post("txt_remark");
			$to_user_id = "";
			$rule_id = "";
			$emp_bonus_dtl_tbl_pk_id_arr = explode(",", $this->input->post("emp_bonus_dtl_tbl_pk_ids"));
			$manager_emailid = $this->session->userdata('email_ses');
			if(count($emp_bonus_dtl_tbl_pk_id_arr)>0)
			{
				$cnt = 0;
				foreach($emp_bonus_dtl_tbl_pk_id_arr as $emp_bonus_dtl_tbl_pk_id)
				{					
					$bonus_dtls = $this->manager_model->get_employee_bonus_dtls_for_manager_discretions(array("employee_bonus_details.id"=>$emp_bonus_dtl_tbl_pk_id, "employee_bonus_details.manager_emailid" => $manager_emailid, "hr_parameter_bonus.status"=>6, "employee_bonus_details.status >"=>1, "employee_bonus_details.status <"=>5));

					if($bonus_dtls)
					{
						$rule_id = $bonus_dtls["rule_id"];
						$emp_bonus_status = $bonus_dtls["status"];
						$user_id = $bonus_dtls["user_id"];
						$previous_manager_emailid = "";
						$last_action_by = "";
						$previous_status = 1;						
						//$current_user_managers_arr = $this->rule_model->get_table_row("row_owner", "*", array("user_id"=>$user_id), "id desc");						
						$current_user_managers_arr = $this->rule_model->get_table_row("login_user", "".CV_BA_NAME_APPROVER_1.",".CV_BA_NAME_APPROVER_2.",".CV_BA_NAME_APPROVER_3.",".CV_BA_NAME_APPROVER_4."", array("id"=>$user_id), "id desc");
						
						if($current_user_managers_arr)
						{
							if($emp_bonus_status == 2)
							{
								$previous_status = 1;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
							}
							elseif($emp_bonus_status == 3)
							{
								$previous_status = 2;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_2];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
							}
							elseif($emp_bonus_status == 4)
							{
								$previous_status = 3;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_3];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_2];
							}

							if($previous_manager_emailid != "" and $last_action_by != "")
							{
								$this->manager_model->update_tbl_data("employee_bonus_details", array("last_action_by"=>$last_action_by, "manager_emailid"=>$previous_manager_emailid, "status"=>$previous_status,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_bonus_dtl_tbl_pk_id));								
								$emp_dtls = $this->rule_model->get_table_row("login_user", "".CV_BA_NAME_EMP_FULL_NAME.", ".CV_BA_NAME_EMP_EMAIL."", array("id"=>$user_id), "id desc");								
								$previous_manager_dtls = $this->rule_model->get_table_row("login_user", "id, ".CV_BA_NAME_EMP_FULL_NAME."", array("".CV_BA_NAME_EMP_EMAIL.""=>$previous_manager_emailid), "id desc");
								$to_user_id = $previous_manager_dtls["id"];								
								$cnt++;
							}
						}	
					}
				}
				
				if($cnt>0)
				{
					$db_arr = array("notification_for"=>"Bonus increment approval request rejected", "message"=>$rmark, "rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$to_user_id);
					$this->front_model->insert_notifications($db_arr);
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Request rejected successfully.</b></div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid request.</b></div>');
			}
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
		}
		if($rule_id)
		{
			redirect(site_url("manager/view-increments-bonus-list/".$rule_id));
		}
		redirect(site_url("manager/dashboard/bonus_rules"));
	}
	
//************************************ Functionality End For Bonus Rules ****************************


//************************************ Functionality Start For Salary Rules ****************************	
	
	public function salary_rules()
	{
		if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";		
		$current_dt = date("Y-m-d");
		//$salary_rule_list=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.is_adhoc_cycle"=>2, "performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter.status >="=>6, 'hr_parameter.status <'=>CV_STATUS_RULE_RELEASED, "hr_parameter.status !=" => CV_STATUS_RULE_DELETED));
		$salary_rule_list=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.is_adhoc_cycle"=>2, "performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter.status >="=>6, "hr_parameter.status !=" => CV_STATUS_RULE_DELETED), "hr_parameter.id DESC");		
		
		$pc_id_arr = array();
		foreach($salary_rule_list as $emps)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$emps["id"]."");

			if(count($ids)>0)
			{
				$currency_rate = 0;
				$m_currency_rate_dtls = $this->rule_model->get_table_row("currency_rates", "rate", "from_currency = ".$emps['to_currency_id']." AND to_currency = (SELECT ".CV_BA_NAME_CURRENCY." FROM login_user WHERE id = ".$this->session->userdata('userid_ses').")", "id DESC");
				if($m_currency_rate_dtls)
				{
					$currency_rate = $m_currency_rate_dtls["rate"];
				}
				
				$bdgt_dtls = array("allocated_budget"=>0, "available_budget"=>0, "direct_emps_budget"=>0);
				$managers_arr = json_decode($emps['manual_budget_dtls'],true);
				foreach($managers_arr as $key => $value)
				{
					if(strtolower($this->session->userdata('email_ses')) == strtolower($value[0]))
					{												
						$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($emps, strtolower($value[0]));
						$bdgt_dtls = array("allocated_budget"=>$manager_total_bdgt_dtls["manager_total_bdgt"]*$currency_rate, "available_budget"=>($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"])*$currency_rate, "direct_emps_budget"=>($value[1] + (($value[1]*$value[2])/100))*$currency_rate);
						break;
					}
				}
				$emps["rule_wise_budget_dtls"] = $bdgt_dtls;
				$data['salary_rule_list'][]=$emps;
				
				$pc_id_arr[] = $emps["performance_cycle_id"];
			}
		}
		
		$data["plan_dtls"] = "";
		if($pc_id_arr)
		{
			$data["plan_dtls"] = $this->rule_model->get_table("performance_cycle","id, name", "id IN(".implode(",",$pc_id_arr).")", "id DESC");
		}
		$data["m_currency_name"] = $this->rule_model->get_table_row("manage_currency", "name", "id = (SELECT ".CV_BA_NAME_CURRENCY." FROM login_user WHERE id = ".$this->session->userdata('userid_ses').")", "id DESC");
		
		
		// released rules
		/*$salary_rule_list_released=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.is_adhoc_cycle"=>2, "performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, 'hr_parameter.status'=>CV_STATUS_RULE_RELEASED));
		foreach($salary_rule_list_released as $emps)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$data['salary_rule_list_released'][]=$emps;
			}
		}*/
		
		/*$rating_dist=$rating_inc = array();
		foreach($data['salary_rule_list'] as $k=>$v)
		{
			break;//Commented it because it's crashed the system
			$manager_lists = $this->manager_model->list_of_manager_emps_for_increment($v['id']);
	
	
			$count = count($manager_lists);
			foreach ($manager_lists as $key => $value)
			{
				$email[]= $value['email'];
			}
			$down_emp = $this->manager_model->list_of_manager_emps_for_manager($v['id'],$email);
			$total = 0;
			foreach ($down_emp as $key => $value)
			{
				$total += $value['count'];
				$ratting_total += $value['ratting_total'];
			}
			
			foreach ($down_emp as $key => $value)
			{
				$rating_dist[$k][] =array(
					'name'=>$value['performance_rating'],
					'total'=>$value['count'],
					'value'=>($value['count']/$total)*100
				);
				$rating_inc[$k][]= array(
					'name'=>$value['performance_rating'],
					'total'=>$value['amount_total'],
					'value'=>($value['ratting_total']/$value['count'])
				);
			}
		}

		$data['rating_dists'] = $rating_dist;
		$data['rating_incs'] = $rating_inc;*/
		
		/*$data['is_open_frm_manager_side'] = "1";
		$data['urls_arr'] = array(
							"emp_increments_list_url"=>"manager/dashboard/get_emp_increment_list_for_manager_ajax",
							"modify_increment_url"=>"manager/dashboard/update_manager_discretions",
							"modify_rating_url"=>"manager/dashboard/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"manager/update-promotions",
							"delete_promotion_url"=>"manager/dashboard/delete_emp_promotions_dtls",
							"increment_file_format_d_url"=>"manager/dashboard/get_manager_emps_file_to_upload_increments",
							"increment_file_upload_url"=>"manager/dashboard/bulk_upload_managers_direct_emps_increments"
							);*/
		
		/*$data['b_title']='Salary rules';
		$data['url']='view-increments-list';
		$data['label']="Increment List";*/
		
		/*$data['print_url']='print-preview-salary';
		$this->method_call =& get_instance();*/ 
		$data['title'] = "Salary Review List";
		$data['body'] = "manager/salary_rule_list_for_managers";
		$this->load->view('common/structure',$data);  
	}
	
	public function managers_list_to_recommend_salary($rule_id, $show_all_managers_data=0)
	{
		if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";
		$data['show_all_managers_data'] = $show_all_managers_data;		
		$current_dt = date("Y-m-d");
		$salary_rule_list=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.is_adhoc_cycle"=>2, "performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter.id"=>$rule_id, "hr_parameter.status >="=>6, "hr_parameter.status !=" => CV_STATUS_RULE_DELETED));

		foreach($salary_rule_list as $emps)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$emps["id"]."");

			if(count($ids)>0)
			{
				$data['salary_rule_list'][]=$emps;
			}
		}
		
		if(!$data['salary_rule_list'])
		{
			redirect(site_url("manager/dashboard/salary_rules"));
		}
		
		$data['is_open_frm_manager_side'] = "1";
		$data['urls_arr'] = array(
							"emp_increments_list_url"=>"manager/dashboard/get_emp_increment_list_for_manager_ajax",
							"modify_increment_url"=>"manager/dashboard/update_manager_discretions",
							"modify_rating_url"=>"manager/dashboard/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"manager/update-promotions",
							"delete_promotion_url"=>"manager/dashboard/delete_emp_promotions_dtls",
							"increment_file_format_d_url"=>"manager/dashboard/get_manager_emps_file_to_upload_increments",
							"increment_file_upload_url"=>"manager/dashboard/bulk_upload_managers_direct_emps_increments"
							);
		
		$data['print_url']='print-preview-salary';
		$this->method_call =& get_instance(); 
		$data['title'] = "View Increment";
		$data['body'] = "salary/salary_rule_list_hr_manager_landing";
		$this->load->view('common/structure',$data);  
	}
	
	public function get_managers_list_for_salary_rule_ajax($ruleID, $newId, $is_need_data_only=0)
	{
		$data["newId"] = $newId;
		$data["rule_dtls"]=$this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$ruleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$sdt = $data['rule_dtls']["start_date"];
		$edt = $data['rule_dtls']["end_date"];
		$cdt = date("Y-m-d");		
		if($sdt > $cdt or $edt < $cdt)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid rule.</b></div>');
			redirect(site_url("dashboard"));
		}
		
		//$staff_list = $this->manager_model->list_of_manager_emps_for_increment($ruleID);
		$staff_list = $this->rule_model->get_table("employee_salary_details", "manager_emailid, last_action_by, status", array("rule_id"=>$ruleID, "approver_1"=>$this->session->userdata('email_ses')), "last_action_by ASC, emp_name ASC");
		$temp_arr = array();
		$data["is_enable_approve_btn"] = 1;
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if($row["status"] >= 5 or strtolower($row["manager_emailid"]) != strtolower($this->session->userdata('email_ses')))
				{
				  $data["is_enable_approve_btn"] = 0;
				} 
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}
		$staff_list = $temp_arr;		
		$all_managers_in_a_rule_arr = $managers_downline_arr = array();
		$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($data["rule_dtls"], strtolower($this->session->userdata('email_ses')));
		$managers_arr = json_decode($data["rule_dtls"]['manual_budget_dtls'], true);
		foreach($managers_arr as $key => $value)
		{
			$all_managers_in_a_rule_arr[] = strtolower($value[0]);
			if(strtolower($staff_list[0]["last_action_by"]) == strtolower($value[0]))
			{
				$managers_downline_arr = $manager_total_bdgt_dtls["managers_downline_arr"];
			}
		}
		
		$data['all_managers_in_a_rule_arr'] = $all_managers_in_a_rule_arr;
		$data['managers_downline_arr'] = $managers_downline_arr;		
		$data['is_open_frm_manager_side'] = "1";
		if($is_need_data_only)
		{
			return $data;
		}
		else
		{
			$this->load->view('salary/managers_list_for_salary_rule',$data);
		}	
	}
	
/*************** Start :: Dummy urls for testing **************/

	public function managers_list_to_recommend_salary_ravij($rule_id, $show_all_managers_data=0)
	{
		if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";
		$data['show_all_managers_data'] = $show_all_managers_data;		
		$current_dt = date("Y-m-d");
		$salary_rule_list=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.is_adhoc_cycle"=>2, "performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter.id"=>$rule_id, "hr_parameter.status >="=>6, "hr_parameter.status !=" => CV_STATUS_RULE_DELETED));

		foreach($salary_rule_list as $emps)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$emps["id"]."");

			if(count($ids)>0)
			{
				$data['salary_rule_list'][]=$emps;
			}
		}
		
		if(!$data['salary_rule_list'])
		{
			redirect(site_url("manager/dashboard/salary_rules"));
		}
		
		$data['is_open_frm_manager_side'] = "1";
		$data['urls_arr'] = array(
							"emp_increments_list_url"=>"manager/dashboard/get_emp_increment_list_for_manager_ajax",
							"modify_increment_url"=>"manager/dashboard/update_manager_discretions",
							"modify_rating_url"=>"manager/dashboard/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"manager/update-promotions",
							"delete_promotion_url"=>"manager/dashboard/delete_emp_promotions_dtls",
							"increment_file_format_d_url"=>"manager/dashboard/get_manager_emps_file_to_upload_increments",
							"increment_file_upload_url"=>"manager/dashboard/bulk_upload_managers_direct_emps_increments"
							);
		
		$data['print_url']='print-preview-salary';
		$this->method_call =& get_instance(); 
		$data['title'] = "View Increment";
		$data['body'] = "salary/salary_rule_list_hr_manager_landing_ravij";
		$this->load->view('common/structure',$data);  
	}
	
	public function get_managers_list_for_salary_rule_ajax_ravij($ruleID, $newId, $is_need_data_only=0)
	{
		$data["newId"] = $newId;
		$data["rule_dtls"]=$this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$ruleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$sdt = $data['rule_dtls']["start_date"];
		$edt = $data['rule_dtls']["end_date"];
		$cdt = date("Y-m-d");		
		if($sdt > $cdt or $edt < $cdt)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid rule.</b></div>');
			redirect(site_url("dashboard"));
		}
		
		//$staff_list = $this->manager_model->list_of_manager_emps_for_increment($ruleID);
		$staff_list = $this->rule_model->get_table("employee_salary_details", "manager_emailid, last_action_by, status", array("rule_id"=>$ruleID, "approver_1"=>$this->session->userdata('email_ses')), "last_action_by ASC, emp_name ASC");
		$temp_arr = array();
		$data["is_enable_approve_btn"] = 1;
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if($row["status"] >= 5 or strtolower($row["manager_emailid"]) != strtolower($this->session->userdata('email_ses')))
				{
				  $data["is_enable_approve_btn"] = 0;
				} 
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}
		$staff_list = $temp_arr;
		
		
		$m_email = $this->session->userdata('email_ses');
		$m_name = $this->session->userdata('username_ses');
		if(empty($m_name))
		{
			$m_name = $m_email;
		}
		
		$data["managers_downline_arr"] = $this->rule_model->get_current_manager_n_downline_bdgt_dtls_for_increment_list_manager($ruleID, $data["rule_dtls"]["include_promotion_budget"], $m_email, $m_name);		
		
		if($data["rule_dtls"]["budget_accumulation"]==1)
		{
			$data["managers_accumulated_arr"] = $this->rule_model->get_current_manager_n_downline_accumulated_bdgt_dtls_for_increment_list_manager($ruleID, $data["rule_dtls"]["include_promotion_budget"], $m_email);			
		}		
		//echo "<pre>";print_r($data["managers_downline_arr"]);
		//echo "<pre>";print_r($data["managers_accumulated_arr"]);die;
		
		$data['is_open_frm_manager_side'] = "1";
		if($is_need_data_only)
		{
			return $data;
		}
		else
		{
			$this->load->view('salary/managers_list_for_salary_rule_ravij',$data);
		}	
	}

/*************** End :: Dummy urls for testing **************/
	
	public function get_emp_increment_list_for_manager_ajax($ruleID, $email, $newId, $emp_sal_dtl_tbl_id=0)
	{
		$data['newId'] = $newId;
		$data['msg'] = "";	
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$ruleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));		
		
		$sdt = $data['rule_dtls']["start_date"];
		$edt = $data['rule_dtls']["end_date"];
		$cdt = date("Y-m-d");		
		/*if($sdt > $cdt or $edt < $cdt)
		{
			 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid rule.</b></div>');
			 redirect(site_url("dashboard"));
		}*/
		
		if($emp_sal_dtl_tbl_id)
		{
			$whr_cnd = "employee_salary_details.id = ".$emp_sal_dtl_tbl_id;
		}
		else
		{
			$whr_cnd = "employee_salary_details.rule_id = ".$ruleID." AND employee_salary_details.approver_1 = '".base64_decode($email)."'";
		}
		$staff_list = $this->rule_model->get_rule_wise_emp_increment_list_for_hr_manager($whr_cnd);
		$temp_arr = array();
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = $staff_list;
		}
		$data["staff_list"] = $temp_arr;
		
		//echo '<pre>'; print_r($data["staff_list"]);
		$data['performance_rating_list']=$this->common_model->get_table("manage_rating_for_current_year", "*", array('status'=>'1'), "order_no ASC");
		/*if($data["rule_dtls"]['promotion_can_edit']==1)
		{*/
			if($data["rule_dtls"]['promotion_basis_on']==2)
			{	
				$data['promotion_basic_list']=$this->common_model->get_table("manage_grade", "id, name", "status=1", "order_no ASC");
				$data['level_name'] ="grade";
				$str="'new_designation','new_level'";
			}
			else if($data["rule_dtls"]['promotion_basis_on']==3)
			{
				$data['promotion_basic_list']=$this->common_model->get_table("manage_level", "id, name", "status=1", "order_no ASC");
				$data['level_name'] ="level";
				$str="'new_grade','new_designation'";	
			}
			else if($data["rule_dtls"]['promotion_basis_on']==1)
			{
				$data['promotion_basic_list']=$this->common_model->get_table("manage_designation", "id, name", "status=1", "order_no ASC");
				$data['level_name'] ="designation";
				$str="'new_grade','new_level'";
			}
		/*}
		else
		{
			$str="'new_designation','new_grade','new_level'";
		}*/
		if($data["rule_dtls"]['promotion_basis_on'] == 0)
		{
			$cond = "WHERE module_name='hr_screen' AND attribute_name NOT IN (".CV_PROMOTION_RELATED_COLUMNS_ARRAY.") AND status=1 ORDER BY col_attributes_order ASC";
		}
		else
		{
			$cond = "WHERE module_name='hr_screen' AND attribute_name NOT IN (".$str.") AND status=1 ORDER BY col_attributes_order ASC";
		}
		$data['table_atrributes']=$this->common_model->getTableAttributes($cond);
		$data['currency_rate_dtls'] = $this->rule_model->get_currency_rate_dtls();
		
		$data["view_emp_increments_dtls_path"] = "manager/view-employee-increments";
		$data['is_open_frm_manager_side'] = "1";		
	  	
		if($emp_sal_dtl_tbl_id)
		{
			return $this->load->view('salary/ajax_emp_row_for_salary', $data, true);
		}
		else
		{
			$this->load->view('salary/ajax_emp_list_new',$data);
		}
	}

	public function view_increments_list_manager_after_release($ruleID,$tableId)
	{		
		$data['msg'] = "";	
		$data['newId'] = $tableId;	
		$data["rule_dtls"]=$this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$ruleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));	
		
		$sdt = $data['rule_dtls']["start_date"];
		$edt = $data['rule_dtls']["end_date"];
		$cdt = date("Y-m-d");		
		if($sdt > $cdt or $edt < $cdt)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid rule.</b></div>');
			redirect(site_url("dashboard"));
		}
		
		$staff_list = $this->manager_model->list_of_manager_emps_for_increment_after_release($ruleID);
		
		$temp_arr = array();
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}
		$data["staff_list"] = $temp_arr;
		$data['is_open_frm_manager_side'] = "1";
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		$this->load->view('manager/emp_list_after_release',$data);
	}
	
	public function view_employee_increments($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		
		
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}	
		
		if($data['rule_dtls']["status"] == CV_STATUS_RULE_RELEASED)
		{
			$staff_list = $this->manager_model->list_of_manager_emps_for_increment_after_release($rule_id);
			$all_approver_levels_staff_list = $staff_list;
		}
		else
		{
			$data['is_open_frm_manager_side'] = "1";
			$staff_list = $this->manager_model->list_of_manager_emps_for_increment($rule_id);
			//$staff_list = $this->manager_model->list_of_manager_emps_for_increment_after_release($rule_id);
			//$all_approver_levels_staff_list = $this->manager_model->list_of_manager_emps_for_increment($rule_id);
		}
		/*$temp_arr = array();
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}*/
		$data["staff_list"] = $staff_list;//$temp_arr;
		
		/*$current_usr_index = array_search($user_id, array_column($all_approver_levels_staff_list, 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}*/
		//$upload_id = $data["staff_list"][$current_usr_index]["upload_id"];
		$manager_email = $this->session->userdata('email_ses');
		$is_valid_usr = $this->rule_model->get_table_row("login_user", "id", "(login_user.".CV_BA_NAME_APPROVER_1." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_2." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_3." = '$manager_email' or login_user.".CV_BA_NAME_APPROVER_4." = '$manager_email')");
		
		//$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($user_id);		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));

		$data['company_dtls'] = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		
		//$data['role_list']=$this->common_model->get_table("roles", "id, name", "", "id asc");
		
		if($data["rule_dtls"]['promotion_basis_on']==1)
		{
			$data['designation_list']=$this->common_model->get_table("manage_designation", "id, name", "status=1", "order_no ASC");
		}
		else if($data["rule_dtls"]['promotion_basis_on']==2)
		{
			$data['grade_list']=$this->common_model->get_table("manage_grade", "id, name", "status=1", "order_no ASC");
		}
		else if($data["rule_dtls"]['promotion_basis_on']==3)
		{
			$data['level_list']=$this->common_model->get_table("manage_level", "id, name", "status=1", "order_no ASC");
		}
		
		$data['performance_rating_list']=$this->common_model->get_table("manage_rating_for_current_year", "*", array('status'=>'1'), "order_no ASC");

		$data['urls_arr'] = array(
							"main_increments_list_url"=>"manager/managers-list-to-recommend-salary",
							"emp_increment_dtls_pg_url"=>"manager/view-employee-increments",
							"modify_increment_url"=>"manager/dashboard/update_manager_discretions",							
							"modify_rating_url"=>"manager/dashboard/upd_emp_performance_rating_for_salary",							
							"modify_promotion_url"=>"manager/update-promotions",
							"delete_promotion_url"=>"manager/dashboard/delete_emp_promotions_dtls"
							);

		//Set business attribute name for title
		$table_atrributes_cond 	= "WHERE module_name='hr_screen' AND status=1 AND attribute_name IN ('increment_applied_on_salary', 'current_position_pay_range', 'current_target_bonus', 'final_salary', 'revised_variable_salary','new_positioning_in_pay_range', 'merit_increase_amount', 'market_correction_amount', 'sp_increased_salary') ORDER BY col_attributes_order ASC";
		$table_atrributes		= $this->common_model->getTableAttributes($table_atrributes_cond);

		$data['table_atrribute_name_array'] = array();

		if(!empty($table_atrributes)) {

			foreach($table_atrributes as $key => $table_atrribute_value) {

				$data['table_atrribute_name_array'][$table_atrribute_value->attribute_name] = $table_atrribute_value->display_name; 

			}
		}
		//End business attribute name for title

		$this->method_call =& get_instance();
		$data['title'] = "Increments Report";	
		$data['body'] = "salary/empl_sal_dtl_new";
		$data['graph_for_show']='Designation';
		$data['manager']='manager/';
		$this->load->view('common/structure',$data);	
	}
	
	public function get_emp_salary_movement_data_graph($rule_id, $user_id, $graph_for)
	{		
		$data['graph_for'] = $graph_for;
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
		$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($user_id);
		$this->load->view('salary/salary_movement_data_graph',$data);	
	}
	
	public function get_peer_employee_salary_dtls_for_graph($emp_salary_dtl_id, $peer_type, $graph_for)
	{			
		$order_by = $graph_for."_salary ASC";
		$data['graph_for'] = $graph_for;
		$emp_salary_dtls = $this->rule_model->get_table_row("employee_salary_details", "rule_id, user_id", array("employee_salary_details.id"=>$emp_salary_dtl_id));
		
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$emp_salary_dtls["rule_id"], "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		
		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph_new($emp_salary_dtls["rule_id"], $emp_salary_dtls["user_id"], $peer_type, $order_by);
		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$emp_salary_dtls["rule_id"], "employee_salary_details.user_id"=>$emp_salary_dtls["user_id"]));
		
		/*if($peer_type=='grade')
		{
			$peer_type='Designation';
		}
		else
		{
			$peer_type=$peer_type;
		}*/
		$data['peer_type']=$peer_type;
		$this->load->view('salary/peer_comparision_graph',$data);
	}
	
	public function get_emp_market_data_graph_for_multiple_benchmark($rule_id, $user_id, $graph_for)
	{		
		$data['graph_for'] = $graph_for;
		if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
		{	
			
			$data['usr_full_dtls'] = $this->rule_model->get_table_row("compBenView3", "*", array("user_id"=>$user_id), "user_id asc");
			$this->load->view('salary/market_data_graph_for_multiple_benchmark',$data);
		}
		else
		{
			$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
			$data['makt_salary_graph_dtls']=$this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id);
			$this->load->view('salary/market_data_graph',$data);
		}
	}
	
	public function get_emp_team_data_for_graph($rule_id, $user_id, $graph_for)
	{		
		$order_by = $graph_for."_salary ASC";
		$data['graph_for'] = $graph_for;
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
		$data['team_salary_graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph_new($rule_id, $user_id, $order_by);
		$this->load->view('salary/team_data_graph',$data);	
	}
	
	public function upd_emp_performance_rating_for_salary($rule_id, $user_id, $rating_id)
	{
		//$this->session->set_flashdata("open_manager_panel", $rule_id);
		//$_SESSION['active'] = trim($con) ;
		$salary_elem_ba_list = $this->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$emp_current_sal_dtls =$this->rule_model->get_table_row("employee_salary_details","id, user_id, increment_applied_on_salary, proreta_multiplier, final_salary, sp_manager_discretions,promotion_comment, status", array("rule_id"=>$rule_id, "user_id"=>$user_id, "status <"=>5));
		$new_rating_dtls =$this->rule_model->get_table_row("manage_rating_for_current_year","id, name", array("id"=>$rating_id, "status"=>1));
		
		$response = HLP_update_users_performance_rating_for_salary_rule($rule_dtls, $emp_current_sal_dtls, $new_rating_dtls, $salary_elem_ba_list);
		if($response["status"])
		{
			$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($rule_id, $emp_current_sal_dtls["id"]);
			$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
		}
		echo json_encode($response); die;
	}
	
	public function update_manager_discretions()
	{

		//$_SESSION['active'] = trim($this->input->post("con")) ;

		$id = trim($this->input->post("emp_sal_id"));
		$new_per = round(trim($this->input->post("new_per")), CV_SALARY_HIKE_ROUND_OFF);
		$hike_type = $this->input->post("hike_type");
		$hike_column_name = "manager_discretions";
		if($hike_type == "merit")
		{
			$hike_column_name = "final_merit_hike";
		}
		elseif($hike_type == "market")
		{
			$hike_column_name = "final_market_hike";
		}
		/*$promotion_per = trim($this->input->post("txt_promotion_per"));
		
		

		$esop = trim($this->input->post("txt_esop"));
		$pay_per = trim($this->input->post("txt_pay_per"));
		$retention_bonus = trim($this->input->post("txt_retention_bonus"));*/
		if(!$new_per)
		{
			$new_per = 0;
		}
		if($id > 0)// and $new_per > 0)
		{
			//$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "employee_salary_details.manager_emailid" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			
			if($salary_dtls)
			{
				$salary_n_rule_dtls = array(
										"rule_status"=>$salary_dtls["rule_status"],
										"budget_accumulation"=>$salary_dtls["budget_accumulation"],
										"salary_hike_approval_status"=>$salary_dtls["status"],
										"manager_emailid"=>$salary_dtls["manager_emailid"],
										"approver_1"=>$salary_dtls["approver_1"],
										"approver_2"=>$salary_dtls["approver_2"],
										"approver_3"=>$salary_dtls["approver_3"],
										"approver_4"=>$salary_dtls["approver_4"]
										);
				$is_manager_can_edit_dtls = HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $this->session->userdata('email_ses'));
				if($is_manager_can_edit_dtls["is_access_to_edit"])
				{

					// $salary_comment = "\nchange ".HLP_get_formated_percentage_common($new_per)."%" ;
					// $salary_comment_arr =$this->manager_model->get_table_row("employee_salary_details","salary_comment", array("id"=>$id));

					// if($salary_comment_arr['salary_comment']){
					// $comment =$salary_comment_arr['salary_comment']." ".$this->session->userdata('username_ses')." (".date("d/m/Y").") - ".$salary_comment;
					// }else{
					// $comment =$this->session->userdata('username_ses')." ".$salary_comment;
					// }

					/*$manager_max_incr_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]+$salary_dtls["Manager_discretionary_increase"];
					$manager_max_dec_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]-$salary_dtls["Manager_discretionary_decrease"];*/
					$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
					$salary_dtls[$hike_column_name] = $new_per;
					$final_total_hike = $salary_dtls["final_merit_hike"] + $salary_dtls["final_market_hike"];				
					if($salary_dtls["include_promotion_budget"] == 1)
					{
						$final_total_hike += $salary_dtls["sp_manager_discretions"];
					}
					$total_hike = $salary_dtls["final_merit_hike"] + $salary_dtls["final_market_hike"] + $salary_dtls["sp_manager_discretions"];
					
					if($hike_column_name == "manager_discretions")
					{
						$final_total_hike = $new_per;
						$total_hike = $new_per;
					}			
					
					$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + ($salary_dtls["increment_applied_on_salary"]*$total_hike)/100;
					
					
					
					
					$all_hikes_total=$salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"];
					$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$salary_dtls["Manager_discretionary_increase"]/100);
					$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$salary_dtls["Manager_discretionary_decrease"]/100);
					//if(($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per) or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET)
					if(($manager_max_incr_per >= $final_total_hike and $manager_max_dec_per <= $final_total_hike) or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
					{
						$max_hike = $salary_dtls["max_hike"];
						if($salary_dtls["recently_promoted"]=="Yes")
						{
							$max_hike = $salary_dtls["recently_promoted_max_hike"];
						}
						//echo "ok";die;
						/*$total_new_per = $new_per;
						if($salary_dtls["include_promotion_budget"] == 1)
						{
							$total_new_per += $salary_dtls["sp_manager_discretions"];
						}*/
						
						//if($max_hike >= ($new_per + $salary_dtls["sp_manager_discretions"]))
						//if($max_hike >= $total_new_per or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET)
						if($max_hike >= $final_total_hike or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
						{				
							$manager_emps_total_budget = 0;
							$manager_emps_total_budget_for_msg = 0;
							
							/*$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_budget($salary_dtls["rule_id"], $salary_dtls["first_approver"]);
	
							if($manager_emps_total_budget_arr)
							{
								$manager_emps_total_budget = $manager_emps_total_budget_arr["increased_salary"];
								$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
							}
							
							$manager_emps_total_budget = $manager_emps_total_budget - ($salary_dtls["final_salary"] - $salary_dtls["increment_applied_on_salary"]);*/
							
							//$manager_total_bdgt_dtls = $this->get_downline_managers_budget($salary_dtls["rule_id"], strtolower($this->session->userdata('email_ses')));
							$rule_dtls_params_arr = array("id"=>$salary_dtls["rule_id"], "budget_accumulation"=>$salary_dtls["budget_accumulation"], "manual_budget_dtls"=>$salary_dtls["manual_budget_dtls"], "include_promotion_budget"=>$salary_dtls["include_promotion_budget"], "to_currency_id"=>$salary_dtls["to_currency_id"]);
							$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls_params_arr, strtolower($this->session->userdata('email_ses')));
							
							if($manager_total_bdgt_dtls)
							{
								$manager_emps_total_budget = $manager_total_bdgt_dtls["manager_total_used_bdgt"];
								$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
							}
							
							$manager_emps_total_budget = $manager_emps_total_budget - ($salary_dtls["final_salary"] - $salary_dtls["increment_applied_on_salary"])*$salary_dtls["currency_rate"];
							
							$total_max_budget = $manager_total_bdgt_dtls["manager_total_bdgt"];
							//$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;	

							//$promotion_increased_salary = $salary_dtls["increment_applied_on_salary"]*$promotion_per/100;

							//$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + $increased_salary + $salary_dtls["sp_increased_salary"];





							
							/*$manager_total_used_bdgt_new = $manager_emps_total_budget + ($increased_salary*$salary_dtls["currency_rate"]);
							if($salary_dtls["include_promotion_budget"] == 1)
							{
								$manager_total_used_bdgt_new += $salary_dtls["sp_increased_salary"]*$salary_dtls["currency_rate"];
							}*/
							$manager_total_used_bdgt_new = $manager_emps_total_budget + ((($salary_dtls["increment_applied_on_salary"]*$total_hike)/100)*$salary_dtls["currency_rate"]);
							

							if($total_max_budget >= $manager_total_used_bdgt_new or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_GO_IN_NEGATIVE_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
							{
								$post_quartile_range_name = $salary_dtls['post_quartile_range_name'];
								if($salary_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
								{
									$crr_arr = json_decode($salary_dtls["comparative_ratio_range"], true);
									$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$salary_dtls["user_id"]), "id desc");
									$post_quartile_range_name = HLP_get_quartile_position_range_name($users_dtls, $final_salary_increased_salary, $crr_arr);
								}


					######## Commented By Kingjuliean #######
						// "sp_increased_salary"=>$promotion_increased_salary, "sp_manager_discretions"=>$promotion_per,

					#########################################				


								$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "manager_discretions"=>$final_total_hike, $hike_column_name=>$new_per, "post_quartile_range_name" => $post_quartile_range_name,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$id));
								/*$revised_comparative_ratio = 0;
								if($salary_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
								{
									$revised_comparative_ratio = $post_quartile_range_name;
								}
								else
								{
									if($salary_dtls["market_salary"])
									{
										$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
									}
								}*/
								
								if($this->input->is_ajax_request())
								{							
									//$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>$revised_comparative_ratio);
									$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($salary_dtls["rule_id"], $id);
									$response = array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
									echo json_encode($response); die;
								}
								else
								{
									$this->session->set_flashdata("open_manager_panel", "1");
									$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data updated successfully.</b></div>');
									redirect(site_url("manager/dashboard/salary_rules"));
								}
							}
							else
							{	
								if($this->input->is_ajax_request())
								{						
									$response =array("status"=>false,"msg"=>"Exceed your budget by allotted budget. You have only left ". HLP_get_formated_amount_common($total_max_budget - $manager_emps_total_budget_for_msg) ." amount of budget.", "final_updated_salary"=>0, "increased_salary"=>0, "revised_comparative_ratio"=>0);
									echo json_encode($response); die;
								}
								else
								{
									$this->session->set_flashdata("open_manager_panel", "1");
									$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Exceed your budget by allotted budget. You have only left '. HLP_get_formated_amount_common($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.</b></div>');
									redirect(site_url("manager/dashboard/salary_rules"));
								}
							}					
						}
						else
						{
							if($this->input->is_ajax_request())
							{
								$response =array("status"=>false,"msg"=>"Increase percentage out of your max hike.", "updated_salary"=>0);
								echo json_encode($response); die;
							}
							else
							{
								$this->session->set_flashdata("open_manager_panel", "1");
								$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Increase percentage out of your max hike.</b></div>');
								redirect(site_url("manager/dashboard/salary_rules"));
							}
						}
					}
					else
					{
						if($this->input->is_ajax_request())
						{
							$response =array("status"=>false,"msg"=>"Increase/decrease percentage out of your limit.", "updated_salary"=>0);
							echo json_encode($response); die;
						}
						else
						{
							$this->session->set_flashdata("open_manager_panel", "1");
							$this->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Increase/decrease percentage out of your limit.</b></div>');
							redirect(site_url("manager/dashboard/salary_rules"));
						}
					}
				}
				else
				{
					if($this->input->is_ajax_request())
					{
						$response =array("status"=>false,"msg"=>"Invalid request.", "updated_salary"=>0);
						echo json_encode($response); die;
					}
					else
					{
						redirect(site_url("dashboard"));
					}
				}
			}
			else
			{
				if($this->input->is_ajax_request())
				{
					$response =array("status"=>false,"msg"=>"Invalid request.", "updated_salary"=>0);
					echo json_encode($response); die;
				}
				else
				{
					redirect(site_url("dashboard"));
				}
			}	
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo "";
			}
			else
			{
				redirect(site_url("dashboard"));
			}
		}
	}
	
	public function update_emp_promotions_dtls($emp_salary_dtl_id)
	{
		$err_msg = "";
		$_SESSION['active'] = trim($this->input->post("con")) ;
		$new_per = round(trim($this->input->post("txt_emp_sp_salary_per")), CV_SALARY_HIKE_ROUND_OFF);
		$new_desig = trim($this->input->post("txt_emp_new_designation"));

		$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
		if($salary_dtls)
		{
			$salary_n_rule_dtls = array(
										"rule_status"=>$salary_dtls["rule_status"],
										"budget_accumulation"=>$salary_dtls["budget_accumulation"],
										"salary_hike_approval_status"=>$salary_dtls["status"],
										"manager_emailid"=>$salary_dtls["manager_emailid"],
										"approver_1"=>$salary_dtls["approver_1"],
										"approver_2"=>$salary_dtls["approver_2"],
										"approver_3"=>$salary_dtls["approver_3"],
										"approver_4"=>$salary_dtls["approver_4"]
										);
			$is_manager_can_edit_dtls = HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $this->session->userdata('email_ses'));
			if($is_manager_can_edit_dtls["is_access_to_edit"])
			{
				$promotion_col_name = CV_BA_NAME_GRADE;
				$promotion_tbl_name = "manage_grade";
				$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_LEVEL);
				
				if($salary_dtls["promotion_basis_on"] == "1")
				{
					$promotion_col_name = CV_BA_NAME_DESIGNATION;
					$promotion_tbl_name = "manage_designation";
					$other_then_promotion_col_arr = array(CV_BA_NAME_GRADE, CV_BA_NAME_LEVEL);
				}
				elseif($salary_dtls["promotion_basis_on"] == "3")
				{
					$promotion_col_name = CV_BA_NAME_LEVEL;
					$promotion_tbl_name = "manage_level";
					$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_GRADE);
				}
				$promotion_tbl_and_col_dtls = array(
												"promotion_tbl_name"=>$promotion_tbl_name,
												"promotion_col_name"=>$promotion_col_name,
												"other_then_promotion_col_name1"=>$other_then_promotion_col_arr[0],
												"other_then_promotion_col_name2"=>$other_then_promotion_col_arr[1]
												);												
				$salary_dtls["promotion_tbl_and_col_dtls"] = $promotion_tbl_and_col_dtls;
				
				
					
				$salary_dtls["emp_new_suggested_position"] = $new_desig;
				$salary_dtls["emp_new_suggested_promotion_per"] = $new_per;	
				$new_dtls_after_promotion = HLP_get_new_mkt_dtls_after_promotion(2, $salary_dtls);
			
				if($new_dtls_after_promotion["n_promotion_hike"] <= $salary_dtls["standard_promotion_increase"] or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
				{			
					$max_hike = $salary_dtls["max_hike"];
					if($salary_dtls["recently_promoted"]=="Yes")
					{
						$max_hike = $salary_dtls["recently_promoted_max_hike"];
					}
					
					/*$total_new_per = $new_per;
					if($salary_dtls["include_promotion_budget"] == 1)
					{
						$total_new_per += $salary_dtls["manager_discretions"];
					}*/
					$total_new_per = $new_dtls_after_promotion["n_final_total_hike"];
					if($max_hike >= $total_new_per or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
					{
						$manager_emps_total_budget = 0;
						$manager_emps_total_budget_for_msg = 0;
						$rule_dtls_params_arr = array("id"=>$salary_dtls["rule_id"], "budget_accumulation"=>$salary_dtls["budget_accumulation"], "manual_budget_dtls"=>$salary_dtls["manual_budget_dtls"], "include_promotion_budget"=>$salary_dtls["include_promotion_budget"], "to_currency_id"=>$salary_dtls["to_currency_id"]);
						$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls_params_arr, strtolower($this->session->userdata('email_ses')));
						
						if($manager_total_bdgt_dtls)
						{
							$manager_emps_total_budget = $manager_total_bdgt_dtls["manager_total_used_bdgt"];
							$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
						}
						
						//$manager_emps_total_budget = $manager_emps_total_budget - ($salary_dtls["sp_increased_salary"]*$salary_dtls["currency_rate"]);
						$manager_emps_total_budget = $manager_emps_total_budget - (($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"]/100)*$salary_dtls["currency_rate"]);
						
						$total_max_budget = $manager_total_bdgt_dtls["manager_total_bdgt"];					
						
						$increased_salary = $new_dtls_after_promotion["n_promotion_salary"];
						$final_salary_increased_salary = $new_dtls_after_promotion["n_final_salary"];
						
						$is_increased_amount_in_under_budget = 1;
						/*if($salary_dtls["include_promotion_budget"] == 1)
						{
							if($total_max_budget < ($manager_emps_total_budget + ($increased_salary*$salary_dtls["currency_rate"])))
							{
								$is_increased_amount_in_under_budget = 0;
							}						
						}*/
						if($total_max_budget < ($manager_emps_total_budget + (($salary_dtls["increment_applied_on_salary"]*$total_new_per/100)*$salary_dtls["currency_rate"])))
						{
							$is_increased_amount_in_under_budget = 0;
						}
						
						if($is_increased_amount_in_under_budget == 1 or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_GO_IN_NEGATIVE_BUDGET or $salary_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
						{
							/*$post_quartile_range_name = $salary_dtls['post_quartile_range_name'];
							if($salary_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
							{
								$crr_arr = json_decode($salary_dtls["comparative_ratio_range"], true);
								$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$salary_dtls["user_id"]), "id desc");
								$post_quartile_range_name = HLP_get_quartile_position_range_name($users_dtls, $final_salary_increased_salary, $crr_arr);
							}*/
							
							$db_upd_arr = array("manager_discretions"=>$new_dtls_after_promotion["n_final_total_hike"], "final_salary"=>$new_dtls_after_promotion["n_final_salary"], "final_market_hike"=>$new_dtls_after_promotion["n_market_hike"], "mkt_salary_after_promotion"=>$new_dtls_after_promotion["n_market_salary_for_crr"], "crr_after_promotion"=>$new_dtls_after_promotion["n_crr_val"], "sp_increased_salary" =>$new_dtls_after_promotion["n_promotion_salary"], "sp_manager_discretions"=>$new_dtls_after_promotion["n_promotion_hike"], $new_dtls_after_promotion["promotion_col_name"]=>$new_dtls_after_promotion["emp_new_post_id"], "quartile_range_name_after_promotion"=>$new_dtls_after_promotion["quartile_range_name_after_promotion"], "post_quartile_range_name"=>$new_dtls_after_promotion["post_quartile_range_name"], "updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
							if($new_dtls_after_promotion["other_then_promotion_col_name1"]>0)
							{
								$db_upd_arr["emp_new_".$other_then_promotion_col_arr[0]] = $new_dtls_after_promotion["other_then_promotion_col_name1"];
							}
							if($new_dtls_after_promotion["other_then_promotion_col_name2"]>0)
							{
								$db_upd_arr["emp_new_".$other_then_promotion_col_arr[1]] = $new_dtls_after_promotion["other_then_promotion_col_name2"];
							}
							
							$this->manager_model->update_tbl_data("employee_salary_details", $db_upd_arr, array("id"=>$emp_salary_dtl_id));

							//$revised_comparative_ratio=HLP_get_formated_percentage_common($new_dtls_after_promotion["n_crr_val"]);
							/*$revised_comparative_ratio = 0;
							if($new_dtls_after_promotion["n_market_salary_for_crr"])
							{
								$revised_comparative_ratio = HLP_get_formated_percentage_common(($new_dtls_after_promotion["n_final_salary"]/$new_dtls_after_promotion["n_market_salary_for_crr"])*100);
							}
							
							$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>$revised_comparative_ratio);*/
							$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($salary_dtls["rule_id"], $emp_salary_dtl_id);
							$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
							echo json_encode($response); die;
						}
						else
						{
							$err_msg = "Exceed your budget by allotted budget..";
						}	
					}
					else
					{
						$err_msg = "Increase percentage out of your max hike.";
					}	
				}
				else
				{
					$err_msg = "Promotion hike can not be increase more than ".$salary_dtls["standard_promotion_increase"]."%";
				}			
			}
			else
			{
				$err_msg = "Invalid request.";
			}
		}
		else
		{
			$err_msg = "Invalid request..";
		}

		$response =array("status"=>false,"msg"=>$err_msg, "updated_salary"=>0);
		echo json_encode($response);
	}
	
	public function delete_emp_promotions_dtls($emp_salary_dtl_id)
	{
		//$_SESSION['active'] = trim($con) ;
		$err_msg = "";
		if($emp_salary_dtl_id > 0)
		{
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.manager_emailid" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				$promotion_col_name = "emp_new_designation";
				if($salary_dtls['promotion_basis_on']==2)
				{
					$promotion_col_name = "emp_new_grade";
				}
				else if($salary_dtls['promotion_basis_on']==3)
				{
					$promotion_col_name = "emp_new_level";
				}
		
				$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + (($salary_dtls["increment_applied_on_salary"]*($salary_dtls["final_merit_hike"] + $salary_dtls["crr_based_increment"]))/100);
				
				$post_quartile_range_name = $salary_dtls['post_quartile_range_name'];;
				if($salary_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{
					$crr_arr = json_decode($salary_dtls["comparative_ratio_range"], true);
					$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$salary_dtls["user_id"]), "id desc");
					$post_quartile_range_name = HLP_get_quartile_position_range_name($users_dtls, $final_salary_increased_salary, $crr_arr);
				}

				//$this->manager_model->update_tbl_data("employee_salary_details", array("manager_discretions"=>($salary_dtls["final_merit_hike"] + $salary_dtls["crr_based_increment"]), "final_salary"=>$final_salary_increased_salary, "final_market_hike"=>$salary_dtls["crr_based_increment"], "mkt_salary_after_promotion"=>$salary_dtls["market_salary"], "crr_after_promotion"=>$salary_dtls["crr_val"], "sp_increased_salary" => 0, $promotion_col_name=>"", "sp_manager_discretions"=>0,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_salary_dtl_id));
				
				$db_upd_arr = array("manager_discretions"=>($salary_dtls["final_merit_hike"] + $salary_dtls["crr_based_increment"]), "final_salary"=>$final_salary_increased_salary, "final_market_hike"=>$salary_dtls["crr_based_increment"], "mkt_salary_after_promotion"=>$salary_dtls["market_salary"], "crr_after_promotion"=>$salary_dtls["crr_val"], "sp_increased_salary" => 0, $promotion_col_name=>"", "sp_manager_discretions"=>0,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
				
				$promotionComment = array();
				if($salary_dtls['promotion_comment']!="")
				{
					$temp=json_decode($salary_dtls['promotion_comment'],true);
					if(json_last_error()=== JSON_ERROR_NONE)
					{
						for($i=0;$i<count($temp);$i++)
						{
							if($temp[$i]["email"]==strtolower($this->session->userdata('email_ses')))
							{
								$temp[$i]["permotion_per"] = "";
								$promotionComment[]=$temp[$i];
							}
							else
							{
								$promotionComment[]=$temp[$i];
							}
						}
						$db_upd_arr['promotion_comment'] = json_encode($promotionComment);
					}
				}
				
				$this->manager_model->update_tbl_data("employee_salary_details", $db_upd_arr, array("id"=>$emp_salary_dtl_id));

				/*$revised_comparative_ratio = 0;
				if($salary_dtls["market_salary"])
				{
					$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
				}			
				
				$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "revised_comparative_ratio"=>$revised_comparative_ratio);*/
				$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($salary_dtls["rule_id"], $emp_salary_dtl_id);
				$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
				echo json_encode($response); die;
			}
			else
			{
				$err_msg = "Invalid request.";
			}
		}
		else
		{
			$err_msg = "Invalid request.";
		}

		$response =array("status"=>false,"msg"=>$err_msg, "updated_salary"=>0);
		echo json_encode($response);
	}
	
	/* *** Function to prepare data to replace employees table row and all manager's budget dtls *** */
	private function get_emp_sal_row_and_managers_budget_dtls_for_salary($rule_id, $emp_sal_dtl_tbl_pk_id)
	{
		$emp_row_dtls=$this->get_emp_increment_list_for_manager_ajax($rule_id,"",0,$emp_sal_dtl_tbl_pk_id);
		$data = $this->get_managers_list_for_salary_rule_ajax($rule_id, 0, 1);
		
		$rule_dtls = $data["rule_dtls"];
		$managers_downline_arr = $data["managers_downline_arr"];
		$all_managers_in_a_rule_arr = $data["all_managers_in_a_rule_arr"];
		
		$managers_bdgt_dtls_arr = array();
		$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
		$k=1;
		foreach($managers_downline_arr as $row)
		{
			if(!in_array($row['m_email'], $all_managers_in_a_rule_arr))
			{continue;}
			
			foreach($managers_arr as $key => $value)
			{
				if(strtolower($row["m_email"]) == strtolower($value[0]))
				{													
					$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($value[0]));
					$managers_bdgt_dtls_arr[$k] = array("m_total_bdgt"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]), "m_availble_total_bdgt"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]), "m_direct_reports_bdgt"=>HLP_get_formated_amount_common($value[1] + (($value[1]*$value[2])/100)),
					"m_direct_emps_availble_bdgt"=>HLP_get_formated_amount_common(($value[1] + (($value[1]*$value[2])/100)) - $manager_total_bdgt_dtls["manager_direct_emps_used_bdgt"]),
					
"utilize_per"=>HLP_get_formated_percentage_common((($manager_total_bdgt_dtls["manager_total_bdgt"]-($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]))/$manager_total_bdgt_dtls["manager_total_bdgt"])*100),
"m_direct_emps_merit_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget"]),
"m_direct_emps_market_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget"]),
"m_direct_emps_promotion_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget"]),
"m_direct_emps_merit_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget"]),
"m_direct_emps_market_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget"]),
"m_direct_emps_promotion_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget"]),
"m_all_emps_merit_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget"]),
"m_all_emps_market_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget"]),
"m_all_emps_promotion_allocated_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget"]),
"m_all_emps_merit_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget"]),
"m_all_emps_market_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget"]),
"m_all_emps_promotion_available_budget"=>HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget"]),

"m_direct_emps_merit_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget_per"]),
"m_direct_emps_market_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget_per"]),
"m_direct_emps_promotion_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget_per"]),
"m_direct_emps_merit_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget_per"]),
"m_direct_emps_market_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget_per"]),
"m_direct_emps_promotion_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget_per"]),
"m_all_emps_merit_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget_per"]),
"m_all_emps_market_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget_per"]),
"m_all_emps_promotion_allocated_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget_per"]),
"m_all_emps_merit_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget_per"]),
"m_all_emps_market_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget_per"]),
"m_all_emps_promotion_available_budget_per"=>HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget_per"])
					);	
					break;
				}
			}
			$k++;
		}
		return array("emp_row_dtls"=>$emp_row_dtls, "managers_bdgt_dtls_arr"=>$managers_bdgt_dtls_arr);
	}
	
	public function send_for_next_level($rule_idd)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$ruleDtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_idd, "hr_parameter.status <"=>CV_STATUS_RULE_RELEASED, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$ruleDtls  or $ruleDtls["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		//$manager_total_bdgt_dtls = $this->get_downline_managers_budget($rule_idd, strtolower($this->session->userdata('email_ses')));
		$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($ruleDtls, strtolower($this->session->userdata('email_ses')));
		
		if($manager_total_bdgt_dtls["manager_total_bdgt"] >= $manager_total_bdgt_dtls["manager_total_used_bdgt"] or $ruleDtls["overall_budget"] == "No limit" or $ruleDtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_GO_IN_NEGATIVE_BUDGET or $ruleDtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
		{		
			//$manager_all_users_arr = $this->manager_model->list_of_manager_emps_for_increment($rule_idd);
			$manager_all_users_arr = $this->manager_model->list_of_current_manager_send_for_next_level($rule_idd);

			if($manager_all_users_arr)
			{
				############ Get SMTP DEtails FOR Sending Mail #############

                                      //  $email_config=HLP_GetSMTP_Details();

                #############################################################

				$rule_id = $manager_all_users_arr[0]["rule_id"];
				$manager_emailid = $this->session->userdata('email_ses');
				$manager_current_users_arr = $this->rule_model->get_table("employee_salary_details", "user_id", array("rule_id"=>$rule_id, "manager_emailid"=>$manager_emailid, "employee_salary_details.status <"=>5));
				
				if(count($manager_all_users_arr) == count($manager_current_users_arr))
				{
					// echo '<pre>';
					// print_r($manager_all_users_arr);
					// exit;
					
					
					$flag = 0;
					foreach ($manager_all_users_arr as $row)
					{
						$new_manager_emailid = "";
						$status = 1;
						$approver="";
						if($row["req_status"] == 1)
						{
							$status = 2;
							$new_manager_emailid = $row["second_approver"];
							$approver="Approver-1";
							if(strtolower($manager_emailid) == strtolower($row["second_approver"]))
							{
								$approver="Approver-2";
								$status = 3;
								$new_manager_emailid = $row["third_approver"];
								if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
								{
									$approver="Approver-3";
									$status = 4;
									$new_manager_emailid = $row["fourth_approver"];
									if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
									{
										$approver="Approver-4";
										$status = 5;
									}
								}
							}
						}
						elseif($row["req_status"] == 2)
						{
							$approver="Approver-2";
							$status = 3;
							$new_manager_emailid = $row["third_approver"];
							
							if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
							{
								$approver="Approver-3";
								$status = 4;
								$new_manager_emailid = $row["fourth_approver"];
								if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
								{
									$approver="Approver-4";
									$status = 5;
								}
							}
						}
						elseif($row["req_status"] == 3)
						{
							$approver="Approver-3";
							$status = 4;
							$new_manager_emailid = $row["fourth_approver"];
							
							if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
							{
								$approver="Approver-4";
								$status = 5;
							}
						}
						elseif($row["req_status"] == 4)
						{
							$approver="Approver-4";
							$status = 5;
							$new_manager_emailid = $row["fourth_approver"];
						}

						if($new_manager_emailid)
						{
							$flag = 1;

							########## Edited By Kingjuliean ###################
							$temp2="";
							$temp="";
							$salaryComment=[];
							$promotionComment=[];
							$promotionComment[]=array(
									'email'=>strtolower($this->session->userdata('email_ses'))
									,"name"=>$this->session->userdata('username_ses')
									,"increment_per"=>$row['manager_discretions']
									,"permotion_per"=>HLP_get_formated_percentage_common($row['sp_manager_discretions'])
									,"changed_by"=>$approver
									,"role"=>"Manager"
									,"rating"=>$row['performance_rating']
									,"final_salary"=>$row['final_salary']
									,"final_increment_amount"=>$row['final_salary']-$row["increment_applied_on_salary"]
									,"final_increment_per"=>HLP_get_formated_percentage_common($row['sp_manager_discretions']+$row["manager_discretions"]),
									"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")
									
								);

							if($row['sp_manager_discretions']>0)
							{
								// $promotion_comment=$approver." : ".HLP_get_formated_percentage_common($row['sp_manager_discretions'])."%";
								//$promotionComment[]['permotion_per']=HLP_get_formated_percentage_common($row['sp_manager_discretions']);

							}
										

							if($row['promotion_comment']!="")
							{
								$temp=json_decode($row['promotion_comment'],true);
								if(json_last_error()=== JSON_ERROR_NONE)
								{
									for($i=0;$i<count($temp);$i++)
									{
										$promotionComment[]=$temp[$i];
									}
									
								}
							}
							
						// print_r($promotionComment);
						// exit;	

							// $salary_comment=$approver." : ".HLP_get_formated_percentage_common($row['manager_discretions'])."%";

							// $salaryComment[]=array('manager_emailid'=>strtolower($this->session->userdata('email_ses')),"salary_comment"=>$salary_comment);

							// if($row['salary_comment']!="")
							// {
							// 	$temp2=json_decode($row['salary_comment'],true);
							// 	if(json_last_error()=== JSON_ERROR_NONE)
							// 	{
							// 		for($i=0;$i<count($temp2);$i++)
							// 		{
							// 			$salaryComment[]=$temp2[$i];
							// 		}
									
							// 	}
							// }

						$email_aaray[]=$new_manager_emailid;	

							################################################
						
							$this->manager_model->update_tbl_data("employee_salary_details", array("last_action_by"=>$manager_emailid, "manager_emailid"=>$new_manager_emailid,"promotion_comment"=>json_encode($promotionComment), "status"=>$status,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$row["tbl_pk_id"]));

							

							//$this->common_model->send_emails(CV_EMAIL_FROM, $new_manager_emailid, $emailTemplate[0]->email_subject, $mail_body);



                                // $this->common_model->send_emails($email_config['email_from'], $new_manager_emailid, $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

							
						}					
					}
					
					$newEmailArray=array_unique($email_aaray);
					$data1=array(
						'condtion'=>''
						,'user_list'=>json_encode($newEmailArray)
						,'plan_name'=>$ruleDtls['name']
					);
					//print_r($data);
					$this->db->insert(''.CV_PLATFORM_DB_NAME.'.corn_job_queue',array('json_text'=>json_encode($data1),'compnay_id'=>$this->session->userdata('companyid_ses'),'mail_stage'=>SALARY_RULE_NEXT_LEVEL_APPROVER, 'status' => 0, 'createdon' => date("Y-m-d H:i:s")));

					
					
					if($flag)
					{
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Request sent for next level successfully.</b></div>');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Records can not be submitted to next level as there are some records pending in your hierarchy.</b></div>');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You have exceeded your budget. Please review and submit within recommended budget.</b></div>');			
		}
		redirect(site_url("manager/managers-list-to-recommend-salary/".$rule_idd));
	}
	
	public function get_designations_autocomplete()
	{
		$term = $this->input->get('term', TRUE);
		$this->manager_model->get_designations_autocomplete($term);
	}
	public function get_role_autocomplete()
	{
		$term = $this->input->get('term', TRUE);
		$this->manager_model->get_role_autocomplete($term);
	}
	public function get_grade_autocomplete()
	{
		$term = $this->input->get('term', TRUE);
		$this->manager_model->get_grade_autocomplete($term);
	}
	public function reject_emp_increment()
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			echo "You do not have update inrements rights.";die;
		}
		
		$this->form_validation->set_rules('emp_sal_tbl_pk_ids', 'PK Ids', 'trim|required');
		$this->form_validation->set_rules('txt_remark', 'Remark', 'trim|required');

		if($this->form_validation->run())
		{
			$rmark = $this->input->post("txt_remark");
			$to_user_id = "";
			$rule_id = "";
			$emp_salary_dtl_tbl_id_arr = explode(",", $this->input->post("emp_sal_tbl_pk_ids"));
			$manager_emailid = $this->session->userdata('email_ses');
			if(count($emp_salary_dtl_tbl_id_arr)>0)
			{
				$cnt = 0;
				foreach($emp_salary_dtl_tbl_id_arr as $emp_salary_dtl_tbl_id)
				{
					$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_tbl_id, "employee_salary_details.manager_emailid" => $manager_emailid, "hr_parameter.status"=>6, "employee_salary_details.status >"=>1, "employee_salary_details.status <"=>5));

					if($salary_dtls)
					{
						$rule_id = $salary_dtls["rule_id"];
						$emp_salary_status = $salary_dtls["status"];
						$user_id = $salary_dtls["user_id"];
						$previous_manager_emailid = "";
						$last_action_by = "";
						$previous_status = 1;						
						$current_user_managers_arr = $this->rule_model->get_table_row("login_user", "".CV_BA_NAME_APPROVER_1.",".CV_BA_NAME_APPROVER_2.",".CV_BA_NAME_APPROVER_3.",".CV_BA_NAME_APPROVER_4."", array("id"=>$user_id), "id desc");						
						if($current_user_managers_arr)
						{
							if($emp_salary_status == 2)
							{
								$previous_status = 1;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
							}
							elseif($emp_salary_status == 3)
							{
								$previous_status = 2;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_2];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_1];
							}
							elseif($emp_salary_status == 4)
							{
								$previous_status = 3;
								$previous_manager_emailid = $current_user_managers_arr[CV_BA_NAME_APPROVER_3];
								$last_action_by = $current_user_managers_arr[CV_BA_NAME_APPROVER_2];
							}

							if($previous_manager_emailid != "" and $last_action_by != "")
							{
								$this->manager_model->update_tbl_data("employee_salary_details", array("last_action_by"=>$last_action_by, "manager_emailid"=>$previous_manager_emailid, "status"=>$previous_status,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_salary_dtl_tbl_id));								
								$emp_dtls = $this->rule_model->get_table_row("login_user", "".CV_BA_NAME_EMP_FULL_NAME.", ".CV_BA_NAME_EMP_EMAIL."", array("id"=>$user_id), "id desc");								
								$previous_manager_dtls = $this->rule_model->get_table_row("login_user", "id, ".CV_BA_NAME_EMP_FULL_NAME."", array("".CV_BA_NAME_EMP_EMAIL.""=>$previous_manager_emailid), "id desc");
								$to_user_id = $previous_manager_dtls["id"];								
								$cnt++;
							}
						}	
					}
				}
				
				if($cnt>0)
				{
					$db_arr = array("notification_for"=>"Increment approval request rejected", "message"=>$rmark, "rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$to_user_id);
					$this->front_model->insert_notifications($db_arr);
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Request rejected successfully.</b></div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid request.</b></div>');
			}
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
		}
		redirect(site_url("manager/dashboard/salary_rules"));
	}
	
//************************************ Functionality End For Salary Rules ****************************
	
//************************************ Functionality Start For R N R Rules ****************************
	public function view_emp_list_for_rnr()
	{
		if(!helper_have_rights(CV_RANDR_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$data['msg'] = "";		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_rnr();	
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		if(count($data["staff_list"])>=1)
		{
			redirect('manager/propose-for-rnr/'.$data["staff_list"][0]['id']);  
		}
		$data['title'] = "View Employees For R and R";
		$data['body'] = "manager/view_emp_list_for_rnr";
		$this->load->view('common/structure',$data);
	}
	
	public function propose_for_rnr($uid)
	{
		if(!helper_have_rights(CV_RANDR_REVIEW, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$data['msg'] = "";	
		$current_dt = date("Y-m-d");
		$data['rnr_rules'] = $this->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		
		if(!$data['rnr_rules'])
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b> R and R rules not available to propose rewards.</b></div>');
			//redirect(site_url("manager/view-emp-list-for-rnr"));
			redirect(site_url("dashboard"));
		}
		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_rnr();
		if(array_search($uid, array_column($data["staff_list"], 'id')) === FALSE)
		{
			redirect(site_url("dashboard"));
		}
		
		if($this->input->post())
		{
			$rule_id = $this->input->post("ddl_rnr");
			$rule_dtls = $this->rule_model->get_table_row("rnr_rules","criteria, award_type, is_approval_required, award_value, award_frequency, emp_frequency_for_award, budget_type, budget_dtls, (SELECT sum(rnr_rules.award_value) FROM proposed_rnr_dtls JOIN rnr_rules ON rnr_rules.id = proposed_rnr_dtls.rule_id WHERE proposed_rnr_dtls.rule_id = '".$rule_id."' AND proposed_rnr_dtls.status < 3 ) AS total_proposed_award_val", array("rnr_rules.id"=>$rule_id, "status"=>6), "rule_name asc");
			if($rule_dtls)
			{
				$managers_budget = 0;
				$manager_available_budget = 0;
				$managers_arr = json_decode($rule_dtls['budget_dtls'],true);
				foreach($managers_arr as $key => $value)
				{
					if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
					{
						$managers_budget = $value[1];
					}
				}
				$manager_available_budget = $managers_budget - $rule_dtls['total_proposed_award_val'];
				
				//Below condition to increate manager budget because budget_type is 'No limit'
				if($rule_dtls["budget_type"]=="No limit")
				{
					$rule_dtls["manager_available_budget"] = $rule_dtls["managers_budget"]+$rule_dtls['award_value'];
				}
				
				if($manager_available_budget >= $rule_dtls['award_value'] or $rule_dtls['award_type'] == 2 or $rule_dtls['award_type'] == 3)
				{
					$last_award_dtls_of_emp = $this->rule_model->get_table_row("proposed_rnr_dtls","createdon", array("rule_id"=>$rule_id, "user_id"=>$uid, "status <"=>3), "id desc");
					
					if($last_award_dtls_of_emp)
					{
						$start_date = strtotime(date("Y-m-d", strtotime($last_award_dtls_of_emp["createdon"])));
						$end_date = strtotime(date("Y-m-d"));				
						
						$diff = abs($end_date - $start_date);
						$days = floor($diff / (60*60*24));
						$months = round($days/30);
						if($months < $rule_dtls['emp_frequency_for_award'])
						{
							$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You can not give this award before '.$rule_dtls['emp_frequency_for_award'].' months.</b></div>');
							redirect(site_url("manager/propose-for-rnr/".$uid));
						}
					}

					$db_arr["rule_id"] = $rule_id;
					$db_arr["user_id"] = $uid;
					$db_arr["status"] = 2;
					$db_arr["createdby"] = $this->session->userdata('userid_ses');
					$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
					$db_arr["createdon"] = date("Y-m-d H:i:s");
					$db_arr["updatedon"] = date("Y-m-d H:i:s");
					
					if($rule_dtls["is_approval_required"]==2)
					{
						$db_arr["status"] = 1;//Note :: It means no need approval.
						$db_arr["updatedon"] = date("Y-m-d H:i:s");	
						if($rule_dtls['award_type'] == 2)//Awared point to User if Award Type is Points
						{
							$usr_point_dtls = $this->rule_model->get_table_row("login_user","points", array("id"=>$uid), "id desc");						$new_points = $usr_point_dtls["points"] + $rule_dtls['award_value'];
							$this->manager_model->update_tbl_data("login_user", array("points"=> $new_points, "updatedby"=>$this->session->userdata('userid_ses'), "updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("login_user.id"=>$uid));
						}
					}
					$this->admin_model->insert_data_in_tbl("proposed_rnr_dtls", $db_arr);	
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Award has been proposed successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your available amount ('.$manager_available_budget.') is insufficient, Selected award amount is '.$rule_dtls['award_value'].'.</b></div>');
					
				}
			}
			redirect(site_url("manager/propose-for-rnr/".$uid));
		}
		
		$data['emp_details'] = $this->rule_model->get_table_row("login_user","id, ".CV_BA_NAME_EMP_FULL_NAME.", ".CV_BA_NAME_EMP_EMAIL.", (SELECT name FROM manage_designation WHERE id = login_user.".CV_BA_NAME_DESIGNATION.") AS designation, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type", array("id"=>$uid));
		$data["emp_rnr_history"] = $this->manager_model->get_emp_rnr_history(array("proposed_rnr_dtls.user_id"=>$uid, "proposed_rnr_dtls.status <"=>3));
		$data['title'] = "Propose For R and R";
		$data['body'] = "manager/propose_for_rnr";
		$this->load->view('common/structure',$data);
	}
	
	public function get_rnr_rule_dtls()
	{
		$rule_id = $this->input->post("rid");
		$rule_dtls = $this->rule_model->get_table_row("rnr_rules","criteria, award_type, award_value, award_frequency, emp_frequency_for_award, budget_type, budget_dtls, (SELECT sum(rnr_rules.award_value) FROM proposed_rnr_dtls JOIN rnr_rules ON rnr_rules.id = proposed_rnr_dtls.rule_id WHERE proposed_rnr_dtls.rule_id = '".$rule_id."' AND proposed_rnr_dtls.status < 3 ) AS total_proposed_award_val", array("rnr_rules.id"=>$rule_id, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED), "rule_name asc");
		
		$rule_dtls["managers_budget"] = 0;
		$rule_dtls["manager_available_budget"] = 0;
		$managers_arr = json_decode($rule_dtls['budget_dtls'],true);

		foreach($managers_arr as $key => $value)
		{
			if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
			{
				$rule_dtls["managers_budget"] = $value[1];
			}
		}
		$rule_dtls["manager_available_budget"] = $rule_dtls["managers_budget"] - $rule_dtls['total_proposed_award_val'];
		//Below condition to increate manager budget because budget_type is 'No limit'
		if($rule_dtls["budget_type"]=="No limit")
		{
			$rule_dtls["manager_available_budget"] = $rule_dtls["managers_budget"]+$rule_dtls['award_value'];
		}
		
		$response =array("status"=>true,"msg"=>"Ok", "rule_dtls"=>$rule_dtls);
		echo json_encode($response); die;
	}
//************************************ Functionality End For R N R Rules ****************************

//************************************ Functionality End For LTI Rules ****************************
	
	public function lti_rules()
	{
		if(!helper_have_rights(CV_LTI_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		$data['msg'] = "";		
		$data['b_title']='LTI rules';                
		$data['url']="view-employee-lti-dtls";
		$current_dt = date("Y-m-d");
		$lti_rule_list=$this->performance_cycle_model->get_lti_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "lti_rules.status >="=>6,"lti_rules.status <"=>CV_STATUS_RULE_RELEASED, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		foreach($lti_rule_list as $emps)
		{
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $emps['id'];
				$rule_dtls = $emps;		
				$sdt = $rule_dtls["start_date"];
				$edt = $rule_dtls["end_date"];
				$temp_arr = array();
				if(!($sdt > $current_dt or $edt < $current_dt))
				{	
					$staff_list = $this->manager_model->list_of_manager_emps_for_lti_incentives($ruleID);	
					if($staff_list)
					{
						$self_usrs_arr = array();
						$other_usrs_arr = array();
						foreach($staff_list as $row)
						{
							if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
							{
								$self_usrs_arr[] = $row;
							}
							else
							{
								$other_usrs_arr[] = $row;
							}
						}
						$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
					}
				}
				$emps['staff_list'] = $temp_arr;
				$emps['is_open_frm_manager_side'] = 1;
				$data['rule_list'][] = $emps;			
			}
		}

		$lti_rule_list_released=$this->performance_cycle_model->get_lti_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "lti_rules.status"=>CV_STATUS_RULE_RELEASED));

		foreach($lti_rule_list_released as $emps)
		{			
			$ids=$this->manager_model->checkManagerEmpinRule("SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$emps["id"]."");
			if(count($ids)>0)
			{
				$ruleID = $emps['id'];
				$rule_dtls = $emps;		
				$sdt = $rule_dtls["start_date"];
				$edt = $rule_dtls["end_date"];
				$temp_arr = array();
				if(!($sdt > $current_dt or $edt < $current_dt))
				{	
					$staff_list = $this->manager_model->list_of_manager_emps_for_lti_incentives_after_released($ruleID);	
					if($staff_list)
					{
						$self_usrs_arr = array();
						$other_usrs_arr = array();
						foreach($staff_list as $row)
						{
							if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
							{
								$self_usrs_arr[] = $row;
							}
							else
							{
								//$other_usrs_arr[] = $row;
							}
						}
						$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
					}
				}
				$emps['staff_list'] = $temp_arr;
				$emps['is_open_frm_manager_side'] = 1;
				$data['rule_list_released'][] = $emps;			
			}
		}
		
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		$data['title'] = "LTI Rules List";
		$data['label']="LTI List";
		$data['print_url']='print-preview-lti';
		// $data['print_url']='manager/dashboard/print_data_lti';
		$data['body'] = "manager/lti_rule_list_released";
		$this->load->view('common/structure',$data);  
	}

	public function view_emp_lti_dtls($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_LTI_REVIEW, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");		
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		$data['staff_list'] = $this->manager_model->list_of_manager_emps_for_lti_incentives_after_released($rule_id);//$this->manager_model->list_of_manager_emps_for_lti_incentives($rule_id);
		$current_usr_index = array_search($user_id, array_column($data["staff_list"], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}
		$upload_id = $data["staff_list"][$current_usr_index]["upload_id"];
		$data['is_open_frm_manager_side'] = "1";	
		if($this->input->post("txt_target_lti_amt") and $this->input->post("txt_target_lti_amt") > 0 and $this->input->post("hf_emp_lti_id") > 0)
		{
			$usr_lti_dtls = $this->manager_model->get_employee_lti_dtls_for_manager_discretions(array("employee_lti_details.id"=>$this->input->post("hf_emp_lti_id"), "employee_lti_details.manager_emailid" => $this->session->userdata('email_ses'), "lti_rules.status"=>6, "employee_lti_details.status <"=>5));
			
			if(!empty($usr_lti_dtls) and strtolower($usr_lti_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')))
			{
				$usr_lti_req_amt = $this->input->post("txt_target_lti_amt");
				
				$manager_max_incr_amt = $usr_lti_dtls["actual_incentive"] + ($usr_lti_dtls["actual_incentive"]*$usr_lti_dtls["manager_discretionary_increase"])/100;
				$manager_max_dec_amt = $usr_lti_dtls["actual_incentive"] - ($usr_lti_dtls["actual_incentive"]*$usr_lti_dtls["manager_discretionary_decrease"])/100;
				
				if($manager_max_incr_amt >= $usr_lti_req_amt and $manager_max_dec_amt <= $usr_lti_req_amt)
				{
					$manager_emps_total_budget = 0;
					$manager_emps_total_budget_for_msg = 0;
					$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_lti_budget($usr_lti_dtls["rule_id"], $usr_lti_dtls["first_approver"]);

					if($manager_emps_total_budget_arr)
					{
						$manager_emps_total_budget = $manager_emps_total_budget_arr["final_incentive"];
						$manager_emps_total_budget_for_msg = $manager_emps_total_budget;
					}
					
					$manager_emps_total_budget = $manager_emps_total_budget - $usr_lti_dtls["actual_incentive"];
					$total_max_budget = 0;

					$managers_arr = json_decode($usr_lti_dtls['budget_dtls'],true);
					foreach($managers_arr as $key => $value)
					{
						if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
						{
							$total_max_budget = round($value[1] + (($value[1]*$value[2])/100));
						}
					}

					if($total_max_budget >= ($manager_emps_total_budget + $usr_lti_req_amt))
					{
						$this->manager_model->update_tbl_data("employee_lti_details", array("final_incentive"=>$usr_lti_req_amt, "updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$this->input->post("hf_emp_lti_id")));
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data successfully updated.</b></div>');
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Exceed your budget by allotted budget. You have only left '. HLP_get_formated_amount_common($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.</b></div>');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Increase/decrease amount out of your limit.</b></div>');					
				}
				redirect(site_url("manager/view-employee-lti-dtls/".$rule_id."/".$user_id));
			}
		}

		$data['emp_lti_dtls'] = $this->lti_rule_model->get_emp_lti_dtls(array("employee_lti_details.rule_id"=>$rule_id, "employee_lti_details.user_id"=>$user_id));
		
		$data['index_for_vesting'] = 0;
		/*$business_attribute_id=0;
		if($data["rule_dtls"]['target_lti_on'] == CV_DESIGNATION)
		{
			$business_attribute_id = CV_DESIGNATION_ID;
		}
		elseif($data["rule_dtls"]['target_lti_on'] == CV_GRADE)
		{
			$business_attribute_id = CV_GRADE_ID;
		}
		elseif($data["rule_dtls"]['target_lti_on'] == CV_LEVEL)
		{
			$business_attribute_id = CV_LEVEL_ID;
		}
		
		$users_tuple_dtls = $this->lti_rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$user_id, "tuple.data_upload_id"=>$upload_id), "id desc");
		$emp_target_lti_on_arr = $this->rule_model->get_user_cell_value_frm_datum($upload_id, $users_tuple_dtls["row_num"], array("business_attribute_id"=>$business_attribute_id));
		$emp_target_lti_on_val = $emp_target_lti_on_arr['value'];*/
		
		$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$user_id), "id desc");
		$emp_target_lti_on_val = $users_dtls[$data["rule_dtls"]['target_lti_on']];		
		$target_lti_elem_arr = json_decode($data["rule_dtls"]["target_lti_elem"],true);
		
		foreach ($target_lti_elem_arr as $key => $value) 
		{
			$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
			if(($emp_target_lti_on_val) and strtoupper($val_arr[1]) == strtoupper($emp_target_lti_on_val))
			{
				if($data["rule_dtls"]["lti_linked_with"]=="Stock Value")
				{
					$data['index_for_vesting'] = $key+1;
				}
				else
				{
					$data['index_for_vesting'] = $key;
				}
				break;
			}
		}
		$data['rule_id']=$rule_id;
		$data['title'] = "Employee LTI Details";
		$data['body'] = "manager/view_emp_lti_dtls";
		$this->load->view('common/structure',$data);	
	}
	
	public function view_emp_lti_dtls_released($rule_id, $user_id)
	{	
		if(!helper_have_rights(CV_LTI_REVIEW, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.status"=>CV_STATUS_RULE_RELEASED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}
		
		$data['staff_list'] = $this->manager_model->list_of_manager_emps_for_lti_incentives_after_released($rule_id);
		$current_usr_index = array_search($user_id, array_column($data["staff_list"], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("dashboard"));
		}
		$upload_id = $data["staff_list"][$current_usr_index]["upload_id"];
		$data['is_open_frm_manager_side'] = "1";		
		$data['emp_lti_dtls'] = $this->lti_rule_model->get_emp_lti_dtls(array("employee_lti_details.rule_id"=>$rule_id, "employee_lti_details.user_id"=>$user_id));
		
		$data['index_for_vesting'] = 0;
		/*$business_attribute_id=0;
		if($data["rule_dtls"]['target_lti_on'] == CV_DESIGNATION)
		{
			$business_attribute_id = CV_DESIGNATION_ID;
		}
		elseif($data["rule_dtls"]['target_lti_on'] == CV_GRADE)
		{
			$business_attribute_id = CV_GRADE_ID;
		}
		elseif($data["rule_dtls"]['target_lti_on'] == CV_LEVEL)
		{
			$business_attribute_id = CV_LEVEL_ID;
		}
		
		$users_tuple_dtls = $this->lti_rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$user_id, "tuple.data_upload_id"=>$upload_id), "id desc");
		$emp_target_lti_on_arr = $this->rule_model->get_user_cell_value_frm_datum($upload_id, $users_tuple_dtls["row_num"], array("business_attribute_id"=>$business_attribute_id));
		$emp_target_lti_on_val = $emp_target_lti_on_arr['value'];*/
		$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$user_id), "id desc");
		$emp_target_lti_on_val = $users_dtls[$data["rule_dtls"]['target_lti_on']];		
		$target_lti_elem_arr = json_decode($data["rule_dtls"]["target_lti_elem"],true);
		
		foreach ($target_lti_elem_arr as $key => $value) 
		{
			$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
			if(($emp_target_lti_on_val) and strtoupper($val_arr[1]) == strtoupper($emp_target_lti_on_val))
			{
				if($data["rule_dtls"]["lti_linked_with"]=="Stock Value")
				{
					$data['index_for_vesting'] = $key+1;
				}
				else
				{
					$data['index_for_vesting'] = $key;
				}
				break;
			}
		}
		$data['rule_id']=$rule_id;
		$data['title'] = "Employee LTI Details";
		$data['body'] = "manager/view_emp_lti_dtls_released";
		$this->load->view('common/structure',$data);	
	}
	
	public function send_lti_for_next_level($rule_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$cdt = date("Y-m-d");
		$ruleDtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.status <"=>CV_STATUS_RULE_RELEASED, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		
		if(!$ruleDtls  or $ruleDtls["status"] < 4)
		{
			redirect(site_url("dashboard"));
		}	
		
		$manager_all_users_arr = $this->manager_model->list_of_manager_emps_for_lti_incentives($rule_id);
		if($manager_all_users_arr)
		{
			//$rule_id = $manager_all_users_arr[0]["rule_id"];
			$manager_emailid = $this->session->userdata('email_ses');
			$manager_current_users_arr = $this->rule_model->get_table("employee_lti_details", "user_id", array("rule_id"=>$rule_id, "manager_emailid"=>$manager_emailid, "employee_lti_details.status <"=>5));

			if(count($manager_all_users_arr) == count($manager_current_users_arr))
			{
				$flag = 0;
				foreach ($manager_all_users_arr as $row)
				{
					$new_manager_emailid = "";
					$status = 1;
					if($row["req_status"] == 1)
					{
						$status = 2;
						$new_manager_emailid = $row["second_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["second_approver"]))
						{
							$status = 3;
							$new_manager_emailid = $row["third_approver"];
							if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
							{
								$status = 4;
								$new_manager_emailid = $row["fourth_approver"];
								if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
								{
									$status = 5;
								}
							}
						}
						
					}
					elseif($row["req_status"] == 2)
					{
						$status = 3;
						$new_manager_emailid = $row["third_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["third_approver"]))
						{
							$status = 4;
							$new_manager_emailid = $row["fourth_approver"];
							if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
							{
								$status = 5;
							}
						}
					}
					elseif($row["req_status"] == 3)
					{
						$status = 4;
						$new_manager_emailid = $row["fourth_approver"];
						
						if(strtolower($manager_emailid) == strtolower($row["fourth_approver"]))
						{
							$status = 5;
						}
					}
					elseif($row["req_status"] == 4)
					{
						$status = 5;
						$new_manager_emailid = $row["fourth_approver"];
					}

					if($new_manager_emailid)
					{
						$flag = 1;
						$this->manager_model->update_tbl_data("employee_lti_details", array("last_action_by"=>$manager_emailid, "manager_emailid"=>$new_manager_emailid, "status"=>$status,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$row["tbl_pk_id"]));
					}					
				}
				if($flag)
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Request sent for next level successfully.</b></div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid request.</b></div>');
			}
		}
		redirect(site_url("dashboard"));
		//echo "<pre>";print_r($manager_all_users_arr);print_r($manager_current_users_arr);
	}
	
//************************************ Functionality End For LTI Rules ****************************
	
	public function get_managers_for_manual_bdgt($is_view_only=0)
	{
		$budget_type = $this->input->post("budget_type");
		$to_currency_id = $this->input->post("to_currency");
		$rule_id = $this->input->post("rid");
		if($rule_id)
		{
			$to_currency_dtls = $this->admin_model->get_table_row("manage_currency", "*", array("id"=>$to_currency_id));
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
			$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);
			// $managers = $this->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);
            // echo '<pre />';print_r($this->session->userdata('email_ses')); print_r($managers); die();
			if($managers)
			{
				$str = '<table class="table table-bordered">';
				$str .= '<thead><tr>';
				$str .= '<th>Manager Name</th><th>Calculated Budget</th>'; 

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
						} else {
							$str .= $row['first_approver'];
						}              

						$str .= '</td><td>'.$to_currency_dtls["name"].' '.HLP_get_formated_amount_common($manager_budget).'<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" /><input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

						if($budget_type == "Manual") 
						{	
							if($is_view_only)
							{
								$str .= '<td><input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.$to_currency_dtls["name"].' '.$manager_budget.'"  maxlength="10" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required">
								</td>';
							} else {	
								$str .= '<td><input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.$manager_budget.'"  maxlength="10" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required">
								</td>';
							}
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
			} else {
				echo "";
			}
		}
	}
	
	public function calculate_budgt_manager_wise($rule_id, $manager_email, $to_currency_id)
	{	
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		
		$total_max_budget = 0;
		// $managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (".$rule_dtls['user_ids'].") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
		$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");

		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;
			$increment_applied_on_amt = 0;
			$performnace_based_increment_percet=0;

			$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
			$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
			$currency = array("currency_type"=>$currency_arr["name"]);
			$from_currency_id = $currency_arr["id"];
			
			$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["salary_applied_on_elements"].")");
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

			$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
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

			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
						$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
						$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
					}
				}
			}
			else
			{
				$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);

				$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
				$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
			}			

			$crr_per = 0;
			if($emp_market_salary > 0)
			{
				$crr_per = ($increment_applied_on_amt/$emp_market_salary);//
				if($rule_dtls["comparative_ratio"] == "yes")
				{
					$crr_per = ($performnace_based_salary/$emp_market_salary);
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
					if($crr_per > $row1["max"])
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
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
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

			$total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, ((($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100)));
		}
		return $total_max_budget;
	}


//********************** Adhoc Term Rule Functionality For Salary Rule Start **********************//
	public function emp_list_for_adhoc_salary_rule()
	{
		$data['msg'] = "";	
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");		
		$data["staff_list"] = $this->manager_model->emp_list_for_midterm_rule();
		$data['title'] = "Employees List For Adhoc Rule";
		$data['body'] = "manager/emp_list_for_adhoc_salary_rule";
		$this->load->view('common/structure',$data);
	}
	
	public function adhoc_rule_salary_review($emp_id)
	{
		if(!helper_have_rights(CV_SALARY_REVIEW, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_increment_right').'</b></div>');
			redirect(site_url("no-rights"));
		}
		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$emp_id));
		if(empty($data['salary_dtls']) or strtoupper($data['salary_dtls']['manager_emailid']) != strtoupper($this->session->userdata('email_ses')))
		{
			redirect(site_url("dashboard"));
		}
		
		$data['company_dtls'] = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		
		$increment_applied_on_amt = 0;
		$emp_market_salary = 0;		
		//$increment_applied_on_arr = $this->rule_model->get_salary_applied_on_elements_val($data['salary_dtls']['upload_id'], $data['salary_dtls']["row_num"], $data['company_dtls']["adhoc_sal_elem"]);
		$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$emp_id), "id desc");
		$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("id, ba_name","id IN(".$data['company_dtls']["adhoc_sal_elem"].")");
		$increment_applied_on_elem_dtls = array();
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
		}
		
		$ba_id_for_mkt_salary = CV_MKT_ELEMENT_ID_FOR_SINGLE_BM;
		if($data['company_dtls']["market_data_by"]==CV_MARKET_SALARY_CTC_ELEMENT)
		{
			$ba_id_for_mkt_salary = CV_MKT_ELEMENT_ID_FOR_MULTIPLE_BM;
		}
		
		$ba_name_arr_for_mkt_salary = $this->rule_model->get_salary_elements_list("id, ba_name", array("id"=>$ba_id_for_mkt_salary));		
		
		//$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($data['salary_dtls']['upload_id'], $data['salary_dtls']["row_num"], array("business_attribute_id"=>$ba_id_for_mkt_salary));
		
		if($users_dtls[$ba_name_arr_for_mkt_salary[0]["ba_name"]])
		{
			$emp_market_salary = $users_dtls[$ba_name_arr_for_mkt_salary[0]["ba_name"]];
		}
		$data['salary_dtls']["increment_applied_on_salary"] = $increment_applied_on_amt;
		$data['salary_dtls']["final_salary"] = $increment_applied_on_amt;
		$data['salary_dtls']["market_salary"] = $emp_market_salary;
		
		$data['salary_dtls']["manager_discretions"] = 0;
		$data['salary_dtls']["standard_promotion_increase"] = 0;
		$data['salary_dtls']["sp_manager_discretions"] = 0;
		$data['salary_dtls']["sp_increased_salary"] = 0;
		$data['salary_dtls']["emp_new_designation"] = "";
		$data['salary_dtls']["emp_citation"] = "";
		
		if($this->input->post("txt_emp_salary") > 0 and $this->input->post("txt_emp_salary_per") > 0)
		{
			$emp_increased_salary = $this->input->post("txt_emp_salary");
			$max_hike = $this->input->post("txt_emp_salary_per");
			$final_salary = $increment_applied_on_amt + ($increment_applied_on_amt*$this->input->post("txt_emp_salary_per"))/100;
			if($this->input->post("txt_emp_sp_salary_per"))
			{
				$max_hike += $this->input->post("txt_emp_sp_salary_per");
				$final_salary +=  ($increment_applied_on_amt*$this->input->post("txt_emp_sp_salary_per"))/100;
			}
			$crr_val = 0;
			if($emp_market_salary>0)
			{
				$crr_val = $increment_applied_on_amt/$emp_market_salary;
			}
			$user_id = $this->session->userdata("userid_ses");
			$currentDateTime = date("Y-m-d H:i:s");
			$performance_cycle_db_arr = array(
				"name"=>"Adhoc Cycle - ".date("my").$emp_id,
				"type" =>"1",
				"is_adhoc_cycle" => 1,
				"start_date"=>date("Y-m-d"),
				"end_date"=>date("Y-m-d"),
				"description"=>"Cycle For Adhoc Rule By Manager : ".$this->session->userdata("email_ses"),
				"createdby" => $user_id,
				"updatedby"=>$user_id,
				"createdon" => $currentDateTime,
				"updatedon"=> $currentDateTime,
				"createdby_proxy" => $this->session->userdata("proxy_userid_ses"),
				"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")
			);
			
			$performance_cycle_id=$this->performance_cycle_model->insert_performance_cycle($performance_cycle_db_arr);
			
			$manual_budget_dtls[] = array($this->session->userdata('email_ses'), 0, 0, $emp_increased_salary);
			$rating_arr = array('all' => 0);
			
			$rule_db_arr = array(
				"salary_rule_name" => "Adhoc Salary Rule - ".date("my").$emp_id,
				"salary_applied_on_elements" => $data['company_dtls']["adhoc_sal_elem"],
				"include_inactive" => "no",
				"prorated_increase" => "no",
				"overall_budget" => "No limit",
				'manual_budget_dtls' => json_encode($manual_budget_dtls),
				"performnace_based_hike" => "no",
				'performnace_based_hike_ratings' => json_encode($rating_arr),
				'Manager_discretionary_increase' => 0,
				'Manager_discretionary_decrease' => 0,
				'standard_promotion_increase' => 0,
				'Overall_maximum_age_increase' =>'["0"]',
				'if_recently_promoted' =>'["0"]',
				"performance_cycle_id" => $performance_cycle_id,
							//'user_ids' => $emp_id,	
				"status" => 7,		
				"createdby" => $user_id,		
				"updatedby" => $user_id,
				"createdon" => $currentDateTime,
				"updatedon" => $currentDateTime,
				"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
				"updatedby_proxy" => $this->session->userdata('proxy_userid_ses')					
			);
			$rule_id = $this->rule_model->insert_rules($rule_db_arr);
			$this->rule_model->insert_data_as_batch("salary_rule_users_dtls",array("rule_id"=>$rule_id,"user_id"=>$emp_id));
			
			//$emp_dtls = $this->admin_model->get_table_row("login_user", "login_user.tenure_company, login_user.tenure_role", array( "id"=>$emp_id), "id desc");
			//$emp_datum_dtls = $this->common_model->get_employee_dtls_by_datum_tbl(array("datum.data_upload_id"=>$data['salary_dtls']['upload_id'], "datum.row_num"=>$data['salary_dtls']["row_num"]));
			$db_arr =array(
				"rule_id" => $rule_id,
				"user_id" => $emp_id,
				"increment_applied_on_salary" => $increment_applied_on_amt,
				"increment_applied_on_elem_dtls" => json_encode($increment_applied_on_elem_dtls),
				"performnace_based_increment" => 0,
				"performance_rating" => $data['salary_dtls']['performance_rating'],
				"crr_val" => $crr_val,
				"crr_based_increment" => 0,
				"standard_promotion_increase" => 0,
				"sp_manager_discretions" => $this->input->post("txt_emp_sp_salary_per"),
				"emp_new_designation" => $this->input->post("txt_emp_new_designation"),
				"emp_citation" => $this->input->post("txt_citation"),
				"market_salary" => $emp_market_salary,
				"final_salary" => $final_salary,
				"actual_salary" => $increment_applied_on_amt,
				"max_hike" => $max_hike,
				"recently_promoted_max_hike" => 0,
				"manager_discretions"=>$this->input->post("txt_emp_salary_per"),
				"manager_emailid" => $data['salary_dtls']['manager_emailid'],
				"last_action_by" => $data['salary_dtls']['manager_emailid'],							
				"status" => 5,
				"created_by" => $user_id,
				"created_on" =>$currentDateTime,
				"updatedby" =>$user_id,
				"updatedon" =>$currentDateTime,
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
				$bu_2_arr = $this->admin_model->get_table_row("manage_business_level_3", "name", array( "id"=>$users_dtls[CV_BA_NAME_BUSINESS_LEVEL_2]), "id desc");
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
				$approver_1 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_1]), "id desc");
				$db_arr["approver_1"] = @$approver_1[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_APPROVER_2])
			{
				$approver_2 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_2]), "id desc");
				$db_arr[CV_BA_NAME_APPROVER_2] = @$approver_2[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_APPROVER_3])
			{
				$approver_3 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_3]), "id desc");
				$db_arr["approver_3"] = @$approver_3[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_APPROVER_4])
			{
				$approver_4 = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_APPROVER_4]), "id desc");
				$db_arr["approver_4"] = @$approver_4[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_MANAGER_NAME])
			{
				$manager_name = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_MANAGER_NAME]), "id desc");
				$db_arr["manager_name"] = @$manager_name[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER])
			{
				$authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
				$db_arr["authorised_signatory_for_letter"] = @$authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
				$db_arr["authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];
			if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER])
			{
				$hr_authorised_signatory_for_letter = $this->admin_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME, array( CV_BA_NAME_EMP_EMAIL=>$users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER]), "id desc");
				$db_arr["hr_authorised_signatory_for_letter"] = $hr_authorised_signatory_for_letter[CV_BA_NAME_EMP_FULL_NAME];
			}
			if($users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER])
				$db_arr["hr_authorised_signatory_title_for_letter"] = $users_dtls[CV_BA_NAME_HR_AUTHORISED_SIGNATORYS_TITLE_FOR_LETTER];													
			//Newly code by ravi on 11-05-18 End							
			$this->rule_model->insert_emp_salary_dtls($db_arr);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data successfully submitted.</b></div>');
			redirect(site_url("manager/dashboard/emp_list_for_adhoc_salary_rule"));
		}
		
		//$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph_adhoc($emp_id, $data['salary_dtls']['upload_id']);
		$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($emp_id);		
		
		$data['business_attributes']=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		$data['title'] = "Adhoc Salary Review";	
		$data['body'] = "adhoc_rule_salary_review";
		$data['graph_for_show']='Designation';
		$data['manager']='manager/';
		$this->load->view('common/structure',$data);
	}
	
	public function get_emp_salary_movement_data_graph_adhoc($user_id, $graph_for)
	{		
		$data['graph_for'] = $graph_for;
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$user_id));
		
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		
		$increment_applied_on_amt = 0;
		$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$user_id), "id desc");
		$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("id, ba_name","id IN(".$company_dtls["adhoc_sal_elem"].")");
		$increment_applied_on_elem_dtls = array();
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
		
		$data['salary_dtls']["increment_applied_on_salary"] = $increment_applied_on_amt;
		$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($user_id);
		$this->load->view('salary_movement_data_graph',$data);	
	}
	
	public function get_peer_employee_salary_dtls_for_graph_adhoc($emp_id, $peer_type, $graph_for)
	{			
		$order_by = $graph_for."_salary ASC";
		$data['graph_for'] = $graph_for;
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$emp_id));
		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph_adhoc($emp_id,  $peer_type, $order_by);

		if($peer_type=='grade')
		{
			$peer_type='Designation';
		}
		else
		{
			$peer_type=$peer_type;
		}
		$data['peer_type']=$peer_type;		
		$this->load->view('peer_comparision_graph',$data);			
	}
	
	public function get_emp_market_data_graph_for_multiple_benchmark_adhoc($user_id, $graph_for)
	{		
		$data['graph_for'] = $graph_for;
		if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
		{	
			$data['usr_full_dtls'] = $this->rule_model->get_table_row("compBenView3", "*", array("user_id"=>$user_id), "user_id asc");
			$this->load->view('market_data_graph_for_multiple_benchmark',$data);
		}
		else
		{
			$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$user_id));
			$rule_id=0;
			$data['makt_salary_graph_dtls']=$this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id);
			$this->load->view('market_data_graph',$data);
		}
	}
	
	public function get_emp_team_data_for_graph_adhoc($user_id, $graph_for)
	{		
		$order_by = $graph_for."_salary ASC";
		$data['graph_for'] = $graph_for;
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$user_id));
		$rule_id=0;
		$data['team_salary_graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph_new($rule_id, $user_id, $order_by);
		$this->load->view('team_data_graph',$data);	
	}
	
//********************** Adhoc Term Rule Functionality For Salary Rule End **********************//


	public function manager_team_view()
	{	
		//Note:: $graph_type = 1(Salary Growth graph), 2(Market Fitment), 3(Peer Comparison), 4(Team Comparison)
		$data["graph_type"] = 1;
		if($this->input->post("btn_team"))
		{
			$data["graph_type"] = 4;
		}
		elseif($this->input->post("btn_peers"))
		{
			$data["graph_type"] = 3;
		}
		elseif($this->input->post("btn_market"))
		{
			$data["graph_type"] = 2;
		}
		
		$data["staff_list"] = $this->manager_model->emp_list_for_midterm_rule();
		$data['title'] = "Manager Team View";	
		$data['body'] = "manager/manager_team_view_graph";
		$data['graph_for_show'] = 'Designation';
		$data['manager'] = 'manager/';
		$this->load->view('common/structure',$data);
	}
	
	public function get_manager_team_view_graph_dtls($user_id, $graph_type, $graph_for)
	{		
		$order_by = $graph_for."_salary ASC";
		$data['uid'] = $user_id;
		$data['graph_for'] = $graph_for;
		$company_dtls = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls_adhoc(array("login_user.id"=>$user_id));
		//Note:: $graph_type = 1(Salary Growth graph), 2(Market Fitment), 3(Peer Comparison), 4(Team Comparison)
		if($graph_type==4)
		{
			$rule_id=0;
			$data['graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph_new($rule_id, $user_id, $order_by);
			$this->load->view('manager/mtv_team_graph',$data);
		}
		elseif($graph_type==3)
		{
			$peer_type = CV_GRADE;
			if($company_dtls["peer_graph_for"] == CV_LEVEL)
			{
				$peer_type= CV_LEVEL;
			}
			
			$data['graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph_adhoc($user_id, $peer_type, $order_by);
			
			$data['peer_type']=$peer_type;		
			$this->load->view('manager/mtv_peers_graph',$data);
		}
		elseif($graph_type==2)
		{
			if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
			{	
				$data['usr_full_dtls'] = $this->rule_model->get_table_row("compBenView3", "*", array("user_id"=>$user_id), "user_id asc");
				$this->load->view('manager/mtv_market_graph_for_multiple_benchmark',$data);
			}
			else
			{
				$rule_id=0;
				$data['graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id);
				$this->load->view('manager/mtv_market_graph',$data);
			}			
		}
		else
		{			
			$data['graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($user_id);
			$this->load->view('manager/mtv_salary_graph',$data);
		}
	}
	
	public function manager_rpt_dashboard()
	{
		$data['title'] = "Report";
		$data['body'] = "manager/manager_rpt_dashboard";
		$this->load->view('common/structure',$data);
	}

	public function update_salary_rule_comments($rule_id,$user_id){
		$salary_id =$this->input->post('txt_salary_id');
		$salary_comment =$this->input->post('txt_salary_comment');
		
		if($salary_id!='' && $salary_comment!=''){
			$salary_comment_arr =$this->manager_model->get_table_row("employee_salary_details","salary_comment,manager_discretions", array("id"=>$salary_id));

			
			if($salary_comment!=""){
				$salary_comment = $this->session->userdata('username_ses')." / ".date("d-m-Y")." / ".$salary_comment_arr['manager_discretions']." - ".$salary_comment;
			}else{
				$salary_comment = "";
			}
			if($salary_comment_arr['salary_comment']){
				$comment =$salary_comment_arr['salary_comment']."<br>".$salary_comment;
			}else{
				$comment =$salary_comment;
			}
			
			$this->manager_model->update_tbl_data("employee_salary_details", array("salary_comment"=>$comment,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$salary_id));
		}
		redirect(site_url("manager/view-employee-increments/".$rule_id."/".$user_id));
	}
	public function update_promotion_comments($rule_id,$user_id){
		$salary_id =$this->input->post('txt_salary_id');
		$promotion_comment =$this->input->post('txt_promotion_comment');
		
		if($salary_id!='' && $promotion_comment!=''){
			$promotion_comment_arr =$this->manager_model->get_table_row("employee_salary_details","promotion_comment", array("id"=>$salary_id));
			if($promotion_comment!=""){
				$promotion_comment = $this->session->userdata('username_ses')." (".date("d/m/Y").") - ".$promotion_comment;
			}else{
				$promotion_comment = "";
			}
			if($promotion_comment_arr['promotion_comment']){
				$comment =$promotion_comment_arr['promotion_comment']." ".$promotion_comment;
			}else{
				$comment =$promotion_comment;
			}
			
			$this->manager_model->update_tbl_data("employee_salary_details", array("promotion_comment"=>$comment,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$salary_id));
		}
		redirect(site_url("manager/view-employee-increments/".$rule_id."/".$user_id));
	}
// new code for download employee data by rahul
public function download_rule_emp_lists($ruleID)
{
 $staff_list = $this->manager_model->list_of_manager_emps_for_increment($ruleID);
 $emp_emailids = $this->rule_model->array_value_recursive('email', $staff_list);
 $tem_emplist=array();
 foreach ($emp_emailids as $key => $value) {
  $res=$this->manager_model->list_of_manager_emps_for_increment($ruleID,$value);
	  if(!empty($res[0]))
	  {
	  $staff_list[]=$res[0];	
	  }
  
 }

$rules = $this->db->select('*')->where('id',$ruleID)->get('hr_parameter')->row_array();
 $attrarr = [];
$attributes = $this->admin_model->staff_attributes_for_export();
  foreach ($attributes as $val) {
        $attrarr[$val['display_name']] = $val['display_name'];
       
        if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) { 
        $str[]="manage_".$val['ba_name'].".name as ".$val['ba_name']; 
        }
		elseif($val['id']==CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR ;
        }
        elseif($val['id']==CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
        }
        elseif($val['id']==CV_BA_ID_RATING_FOR_2ND_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_3RD_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_4TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_5TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR;
        }
        
		else{
            $str[]="login_user.".$val['ba_name'];
        }
    }  
    $strdata = implode(",",$str);
   $emp_ids = $this->rule_model->array_value_recursive('id', $staff_list);
// echo '<pre>';
// print_r($emp_ids);
//  die;
    $empDetail = $this->admin_model->get_emp_dtls_for_export_ruleList($strdata,$emp_ids,'manager',$ruleID);
$filename =  time().".csv";
       $manager_emailid = strtolower($this->session->userdata('email_ses'));
        HLP_get_manager_hr_emps_file_to_upload_increments($rules, $empDetail,$manager_emailid,'manager',$filename);

        exit;

    $emparr = [];
    $temparr = [];


    for ($k = 0; $k < count($empDetail); $k++) {
        foreach ($attributes as $at) {
			$emparr[$at['display_name']] = $empDetail[$k][$at['ba_name']];
        }

        if(isset($empDetail[$k]['increment_applied_on_salary'])){
				$emparr['Current Salary being reviewed']=HLP_get_formated_amount_common($empDetail[$k]["increment_applied_on_salary"]);	
			}
		if(isset($empDetail[$k]['increment_applied_on_salary'])){
				$emparr['Current Salary being reviewed']=HLP_get_formated_amount_common($empDetail[$k]["increment_applied_on_salary"]);	
			}
			if(isset($empDetail[$k]['current_target_bonus'])){
				$emparr['Current variable salary']=HLP_get_formated_amount_common($empDetail[$k]["current_target_bonus"]);	
			}
			
			$total_sal_incr_per = $empDetail[$k]["manager_discretions"];
			//2
			  if($rules->salary_position_based_on == "2")//Salary Positioning Based On Quartile
                {
                  $current_position_pay_range = $empDetail[$k]["post_quartile_range_name"];
                }
                else
                {
                  // if($empDetail[$k]["market_salary"]){ 
                  //   $current_position_pay_range = HLP_get_formated_percentage_common(($empDetail[$k]["increment_applied_on_salary"]/$empDetail[$k]["market_salary"])*100).' %'; 
                  // }else{
                  //   $current_position_pay_range = 0;
                  // }
                 $current_position_pay_range = HLP_get_formated_percentage_common($empDetail[$k]["crr_val"]).'%';
                }
			$emparr['Current Positioning in pay range']=$current_position_pay_range;
			//3
			$emparr['Salary Increment Amount']=HLP_get_formated_amount_common(($empDetail[$k]["increment_applied_on_salary"]*$total_sal_incr_per)/100 - $empDetail[$k]["sp_increased_salary"]);
			//4
			$total_sal_incr_per = ($empDetail[$k]["manager_discretions"]); 
			$emparr['Salary increase recommended by manager']=HLP_get_formated_percentage_common($total_sal_incr_per).' %';
			//5
			$all_hikes_total = $empDetail[$k]["performnace_based_increment"]+$empDetail[$k]["crr_based_increment"];
			$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rules->Manager_discretionary_increase/100);
			$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rules->Manager_discretionary_decrease/100);
					
			$emparr['Salary increase range']=  (HLP_get_formated_percentage_common($manager_max_dec_per) .'% to '. HLP_get_formated_percentage_common($manager_max_incr_per).'%' ) ;

         
		$emparr['Salary Comments']=$empDetail[$k]["salary_comment"];	
			
			//6 remaining
			
			$emparr['Promotion Increase amount']=  HLP_get_formated_amount_common($empDetail[$k]["sp_increased_salary"]);
			//7
             $sp_per=$empDetail[$k]["sp_manager_discretions"];
			$emparr['Promotion Increase %age']=HLP_get_formated_percentage_common((float)$sp_per);
			//8
			$emparr['Promotion Comments']=$empDetail[$k]["promotion_comment"];	

			$emparr['Final Total Increment Amount']=(HLP_get_formated_amount_common(($empDetail[$k]["final_salary"]-$empDetail[$k]["increment_applied_on_salary"])+$empDetail[$k]["sp_increased_salary"]));
			//9
			$emparr['Final Total increment %age']=(HLP_get_formated_percentage_common((float)$sp_per+$empDetail[$k]["manager_discretions"])).'%';
			//10
			$emparr['Final New Salary']=HLP_get_formated_amount_common($empDetail[$k]["final_salary"]);

 $totalrevised=$empDetail[$k]["current_target_bonus"] + ($empDetail[$k]["current_target_bonus"]*($empDetail[$k]["sp_manager_discretions"] + $empDetail[$k]["manager_discretions"])/100);
			$emparr['Revised Variable Salary']=HLP_get_formated_amount_common($totalrevised);
			//11

			$emparr['New Positioning in Pay range']=HLP_get_formated_percentage_common(($empDetail[$k]["final_salary"]/$empDetail[$k]["market_salary"])*100).'%';
			//12
			
			$emparr[$rules->esop_title]=$empDetail[$k]["esop"];
			//13
			$emparr[$rules->pay_per_title]=$empDetail[$k]["pay_per"];
			
			//14
			if($empDetail[$k]["retention_bonus"] !=''){
				$emparr[$rules->retention_bonus_title?$rules->retention_bonus_title:'bonus_recommendation_title']=$empDetail[$k]["retention_bonus"];
			}
			//15
			//$emparr['Reco from First additional box']='000';
       array_push($temparr, $emparr);
    }
downloadcsv($temparr);   
}

	public function download_rule_emp_list($ruleID)
	{

		echo "string";
		// $csv_file = "Salary-rules-employee-list.csv";
		// header('Content-Type: text/csv');
		// header('Content-Disposition: attachment; filename="' . $csv_file . '"');
		// $fp = fopen('php://output', 'wb');

		$rule_dtls=$this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$ruleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		$staff_list = $this->manager_model->list_of_manager_emps_for_increment($ruleID);

		$temp_arr = array();
		if($staff_list)
		{
			$self_usrs_arr = array();
			$other_usrs_arr = array();
			foreach($staff_list as $row)
			{
				if(strtoupper($row["last_action_by"]) == strtoupper($this->session->userdata('email_ses')))
				{
					$self_usrs_arr[] = $row;
				}
				else
				{
					$other_usrs_arr[] = $row;
				}
			}
			$temp_arr = array_merge($self_usrs_arr, $other_usrs_arr);
		}
		$staff_list = $temp_arr;

		$business_attributes=$this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$managers_arr = json_decode($staff_list[0]['manual_budget_dtls'],true);
		if($staff_list){
			foreach($managers_arr as $key => $value)
			{
				if(strtolower($staff_list[0]["last_action_by"]) == strtolower($value[0]))
				{
					//$manager_total_bdgt_dtls = $this->get_downline_managers_budget($staff_list[0]['rule_id'], strtolower($value[0]));
					$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($value[0]));

					// echo 'Total Budget'.$rule_dtls['rule_currency_name'].HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]);
					fputcsv($fp, array("Total Budget :" ,$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]),"Available budget",$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]),"My Direct Reports Budget",$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($value[1] + (($value[1]*$value[2])/100))));
				}
			}

			fputcsv($fp, array($business_attributes[0]["display_name"],$business_attributes[9]["display_name"],'Date of Joining',$business_attributes[10]["display_name"],$business_attributes[11]["display_name"],$business_attributes[23]["display_name"],'Current Salary being reviewed','Current Positioning in pay range','Salary Increment Amount','Salary increase recommended by manager','Salary increase range','Promotion Increase amount','Promotion Increase %age','Final Total Increment Amount','Final Total increment %age','Final New Salary','New Positioning in Pay range',$rule_dtls['esop_title'],$rule_dtls['pay_per_title'],$rule_dtls['retention_bonus_title'],'Salary Comments','Promotion Comments'));

			foreach($staff_list as $row)
			{
				if($row['salary_position_based_on'] == "2")
				{
					$current_position_pay_range = $row["post_quartile_range_name"];
				}
				else
				{
					if($row["market_salary"]){ $current_position_pay_range = HLP_get_formated_percentage_common(($row["increment_applied_on_salary"]/$row["market_salary"])*100); }else{$current_position_pay_range = 0;}
					;
				}
				$sp_per=$row["sp_manager_discretions"];
				$all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];
				$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);
				$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);

				fputcsv($fp, array($row["name"],$row["desig"],$row["joining_date_for_increment_purposes"],$row["grade"],$row["level"],$row["performance_rating"],HLP_get_formated_amount_common($row["increment_applied_on_salary"]),$current_position_pay_range,HLP_get_formated_amount_common(($row["final_salary"]-$row["increment_applied_on_salary"])-$row["sp_increased_salary"]),$row["manager_discretions"],HLP_get_formated_percentage_common($manager_max_dec_per)." - ".HLP_get_formated_percentage_common($manager_max_incr_per),HLP_get_formated_amount_common($row["sp_increased_salary"]),HLP_get_formated_percentage_common((float)$sp_per),HLP_get_formated_amount_common(($row["final_salary"]-$row["increment_applied_on_salary"])+$row["sp_increased_salary"]),HLP_get_formated_percentage_common((float)$sp_per+$row["manager_discretions"]),HLP_get_formated_amount_common($row["final_salary"]),$current_position_pay_range,$row["esop"],$row["pay_per"],$row["retention_bonus"],$row['salary_comment'],$row['promotion_comment']));
			}
		}

		fclose($fp);
	}
	
	//*Start :: CB::Ravi on 27-05-09 To upload bulk Increments By the Managers *********************
	public function get_manager_emps_file_to_upload_increments($rule_id)
	{		
		$manager_email = $this->session->userdata('email_ses');
		$cdt = date("Y-m-d");
		
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		
		//$staff_list = $this->manager_model->get_managers_direct_emps_list(array("employee_salary_details.rule_id" => $rule_id, "employee_salary_details.status" => 1, "employee_salary_details.approver_1" => $manager_email));
		$staff_list = $this->manager_model->get_managers_direct_emps_list(array("employee_salary_details.rule_id" => $rule_id, "employee_salary_details.manager_emailid" => $manager_email));
		//echo "<pre>";print_r($staff_list);die;
		$manager_emailid = strtolower($this->session->userdata('email_ses'));
        HLP_get_manager_hr_emps_file_to_upload_increments($rule_dtls, $staff_list,$manager_emailid,'manager');
	}
	
	public function bulk_upload_managers_direct_emps_increments($rule_id)
	{
		$manager_email = $this->session->userdata('email_ses');
		$cdt = date("Y-m-d");		
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
	
		if($_FILES)
		{						
			$file_type = explode('.', $_FILES['increments_file']['name']);
			if ($file_type[1] == 'csv')
			{	
				$scan_file_result = HL_scan_uploaded_file($_FILES['increments_file']['name'],$_FILES['increments_file']['tmp_name']);
				if($scan_file_result === true)
				{						
					$uploaded_file_name = $_FILES['increments_file']['name'];
					$fName = time() . "-bulk-increments." . $file_type[1];
					move_uploaded_file($_FILES["increments_file"]["tmp_name"], "uploads/" . $fName);
					$csv_file = base_url() . "uploads/" . $fName;
					if (($handle = fopen($csv_file, "r")) !== FALSE)
					{
						$manager_emailid = strtolower($this->session->userdata('email_ses'));
						$req_response = HLP_bulk_upload_hr_managers_direct_emps_increments($rule_dtls, $csv_file,$manager_emailid);
						$error_msg = "";
						if($req_response["insert_counts"] > 0 and count($req_response["invalid_data"]) == 0)
						{
							$error_msg = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully</b></div>';
						}
						elseif($req_response["insert_counts"] > 0 and count($req_response["invalid_data"]) > 0)
						{
							$error_msg = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$req_response["insert_counts"].' employees data successfully.</b></div>
							<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>But '.count($req_response["invalid_data"]).' employees data not updated.</b></div>';
						}
						elseif($req_response["insert_counts"] == 0 and count($req_response["invalid_data"]) > 0)
						{
							$error_msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid data. Try again with correct data.</b></div>';
						}
						$this->session->set_flashdata('message', $error_msg);
						
						/*$ins_columns = "email_id, performance_rating, salary_increment_percentage, salary_comment, promotion_basis_on, promotion_percentage, promotion_comment";
						if($rule_dtls["esop_title"] != "")
						{
							$ins_columns .= ", esop_val";
						}
						if($rule_dtls["pay_per_title"] != "")
						{
							$ins_columns .= ", pay_per_val";
						}
						if($rule_dtls["retention_bonus_title"] != "")
						{
							$ins_columns .= ", retention_bonus_val";
						}
						
						$emps_list = $this->manager_model->bulk_upload_managers_direct_emps_increments($rule_id, $ins_columns, $csv_file, $rule_dtls['promotion_basis_on']);
						//echo "<pre>";print_r($emps_list);die;
						if($emps_list)
						{
							$error_arr = $correct_emp_arr = array();
							foreach($emps_list as $row)
							{
								if(($row["new_performance_rating_id"]) and $row["new_performance_rating_id"] != $row["old_performance_rating_id"])
								{
									$rating_upd_dtls = HLP_update_users_performance_rating_for_salary_rule($rule_id, $row["user_id"], $row["new_performance_rating_id"]);
									if(!$rating_upd_dtls["status"])
									{
										$error_arr[] = $row["user_id"];
										continue;
									}
								}
								
								$new_per = $row["salary_increment_percentage"];
								$promotion_per = $row["promotion_percentage"];							
								$increased_salary = $row["increment_applied_on_salary"]*$new_per/100;
									
								$promotion_increased_salary = 0;
								$new_desig = $row["promotion_basis_on"];
								if($promotion_per > 0 and $new_desig != "")
								{
									$promotion_increased_salary = $row["increment_applied_on_salary"]*$promotion_per/100;
								}
								
								$final_salary_increased_salary = $row["increment_applied_on_salary"] + $promotion_increased_salary + $increased_salary;
								
								$salary_comment = $row["salary_comment"];							
								if($salary_comment!="")
								{
									$salary_comment = $this->session->userdata('username_ses')." (".date("d/m/Y").") - ".$salary_comment;
								}
								else
								{
									$salary_comment = "";
								}
								if($row["old_salary_comment"] !="")
								{
									$comment = $row["old_salary_comment"]." ".$salary_comment;
								}
								else
								{
									$comment = $salary_comment;
								}	
								$promotion_comment = $row["promotion_comment"];
								if($promotion_comment!="")
								{
									$promotion_comment = $this->session->userdata('username_ses')." (".date("d/m/Y").") - ".$promotion_comment;
								}
								else
								{
									$promotion_comment = "";
								}
								if($row["old_promotion_comment"]){
									$comment1 = $row["old_promotion_comment"]." ".$promotion_comment;
								}
								else
								{
									$comment1 = $promotion_comment;
								}
								
								$post_quartile_range_name = "";
								if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
								{
									$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
									$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$salary_dtls["user_id"]), "id desc");
									$post_quartile_range_name = HLP_get_quartile_position_range_name($users_dtls, $final_salary_increased_salary, $crr_arr);
								}
								
								$db_arr = array("final_salary"=>$final_salary_increased_salary,
											"manager_discretions"=>$new_per,
											"post_quartile_range_name" => $post_quartile_range_name,
											"salary_comment"=>$comment,
											"promotion_comment"=>$comment1,
											"updatedby" =>$this->session->userdata('userid_ses'),
											"updatedon" =>date("Y-m-d H:i:s"),
											"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
											
								if($promotion_per > 0 and $new_desig != "")
								{
									$db_arr["sp_increased_salary"] = $promotion_increased_salary;
									$db_arr["sp_manager_discretions"] = $promotion_per;
									$db_arr["emp_new_designation"] = $new_desig;
								}
											
								if($rule_dtls["esop_title"] != "")
								{
									$db_arr["esop"] = $row["esop_val"];
								}
								if($rule_dtls["pay_per_title"] != "")
								{
									$db_arr["pay_per"] = $row["pay_per_val"];
								}
								if($rule_dtls["retention_bonus_title"] != "")
								{
									$db_arr["retention_bonus"] = $row["retention_bonus_val"];
								}
									
								$this->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("rule_id"=>$rule_id, "user_id"=>$row["user_id"]));	
								$correct_emp_arr[] = array($row["emp_email_id"]=>"Ok");						
							}
							
							$data["emps_list"] = $emps_list;
							$data["error_arr"] = array();
							if($error_arr)
							{
								$data["error_arr"] = $error_arr;
							}
						
							//echo "<pre>";print_r($data);die;
																
							$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully</b></div>');
						}
						else
						{
							$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data not uploaded. Please try agian with correct data</b></div>');
						}*/
						//redirect(site_url("market-data-upload/"));
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not readable. Please try again.</b></div>');
					}
				}
				else
				{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
                }
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
				//redirect(site_url("manager/dashboard/bulk_upload_managers_direct_emps_increments/3"));
			}
			/*if(!isset($error_arr) and (!$error_arr))
			{
				redirect(site_url("manager/dashboard/bulk_upload_managers_direct_emps_increments/".$rule_id));
			}*/			
		}

		redirect(site_url("manager/managers-list-to-recommend-salary/".$rule_id));
	}
	//*End :: CB::Ravi on 27-05-09 To upload bulk Increments By the Managers *********************
	
}
