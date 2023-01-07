<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approvel extends CI_Controller
{
	 public function __construct()
	 {
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
		$this->load->model("approvel_model");
		//$this->load->model("upload_model");
		$this->load->model("front_model");
		$this->load->model("rule_model");
		$this->load->model("bonus_model");
		$this->load->model("sip_model");
		$this->load->model("common_model");
		$this->load->model("lti_rule_model");
		$this->load->model("rnr_rule_model");
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{
			redirect(site_url("dashboard"));
		}
		HLP_is_valid_web_token();
    }

	public function salary_rule_approval_request_list()
	{
		$condition_arr = " (approvel_requests.type = 2)";
		$data['rules_approvel_request_list'] = $this->approvel_model->get_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		$data['title'] = "Rule Approvel Request List";
		$data['body'] = "salary_ruels_approvel_request_list";
		$this->load->view('common/structure',$data);
	}

	public function update_salary_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_salary_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));

			$db_arr = array("notification_for"=>"Salary rule approved", "message"=>"Salary rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));


			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
				$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);

				if($managers)
				{
					$recipients_arr =array();
					foreach ($managers as $row)
					{
						if($row["first_approver"] != "")
						{
							$recipients_arr[] = $row["first_approver"];
						}
					}
					if($recipients_arr)
					{
						$mail_body = "Dear Team,
						<br /><br />
						New salary rule as :".$data['rule_dtls']["salary_rule_name"]." is now approved.<br />
						<br /><br />
						Please go to site then login and check.";
						$mail_sub = "New salary rule approved on ".date("d/m/Y H:i:s");
						//$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);
					}
				}
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule not approved. Try again!</b></div>');
		}
		//redirect(site_url("salary-rule-approval-request-list"));
		redirect(site_url("view-salary-rule-details/".$rule_id));
	}

	public function reject_salary_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		if(trim($this->input->post("txt_remark")))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>2));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>2));
			if($request_dtl)
			{
				$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));



				$this->approvel_model->reject_approvel_req($request_dtl["id"]);
				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$this->input->post("txt_remark"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($this->input->post("hf_req_for")==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "Salary rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "Salary rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule rejected successfully.</b></div>');
				}
				$this->rule_model->update_rules(array('id'=>$rule_id), $db_arr1);
				$this->rule_model->delete_emp_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id));
				$this->front_model->insert_notifications($db_arr2);
			}
		}
		else
		{
			redirect(site_url("view-salary-rule-details/".$rule_id));
		}
		redirect(site_url("view-salary-rule-details/".$rule_id));
	}

	public function update_bonus_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_bonus_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] =  $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));

			$db_arr = array("notification_for"=>"Bonus rule approved", "message"=>"Bonus rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->bonus_model->updateBonusRules(array("status"=>6, "updatedBy"=>$this->session->userdata("userid_ses"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"), "updatedOn"=>date("Y-m-d H:i:s")), array('id'=>$rule_id));

			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
			// 	$managers = $this->rule_model->get_managers_for_manual_bdgt("bonus_rule_users_dtls", $rule_id);

			// 	if($managers)
			// 	{
			// 	$recipients_arr =array();
			// 	foreach ($managers as $row)
			// 	{
			// 		if($row["first_approver"] != "")
			// 		{
			// 			$recipients_arr[] = $row["first_approver"];
			// 		}
			// 	}
			// 	if($recipients_arr)
			// 	{
			// 	$emailTemplate=$this->common_model->getEmailTemplate('newBonusRuleApproved');
			// 	$emailTemplate=$this->common_model->getEmailTemplate('newBonusRuleApproved');
			// 	$str=str_replace("{{bonus_rule_name}}",$data['rule_dtls']["bonus_rule_name"] , $emailTemplate[0]->email_body);
			// 	$str=str_replace("{{url}}",site_url() , $str);
			// 	$mail_body=$str;
			// 	$mail_sub = $emailTemplate[0]->email_subject." on ".date("d/m/Y H:i:s");
			// 		$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);
			// 	}
			// }
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Bonus rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Bonus rule not approved. Try again!</b></div>');
		}
		redirect(site_url("view-bonus-rule-details/".$rule_id));
	}

	public function reject_bonus_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		if(trim($this->input->post("txt_remark")))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>3));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>3));
			if($request_dtl)
			{
				$data['rule_dtls'] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
				$this->approvel_model->reject_approvel_req($request_dtl["id"]);
				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$this->input->post("txt_remark"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($this->input->post("hf_req_for")==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "Bonus rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Bonus rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "Bonus rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Bonus rule rejected successfully.</b></div>');
				}

				$this->bonus_model->updateBonusRules($db_arr1, array('id'=>$rule_id));
				$this->bonus_model->delete_emp_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id));
				$this->front_model->insert_notifications($db_arr2);
			}
		}
		else
		{
			redirect(site_url("view-bonus-rule-details/".$rule_id));
		}


	}


	public function update_lti_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_LTI, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_lti_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));

			$db_arr = array("notification_for"=>"LTI rule approved", "message"=>"LTI rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->lti_rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
			// 	$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $rule_id);

			// 	if($managers)
			// 	{
			// 	$recipients_arr =array();
			// 	foreach ($managers as $row)
			// 	{
			// 		if($row["first_approver"] != "")
			// 		{
			// 			$recipients_arr[] = $row["first_approver"];
			// 		}
			// 	}
			// 	if($recipients_arr)
			// 	{
			// 		$mail_body = "Dear Team,
			// 		<br /><br />
			// 		New LTI rule as :".$data['rule_dtls']["rule_name"]." is now approved.<br />
			// 		<br /><br />
			// 		Please go to site then login and check.";
			// 		$mail_sub = "New lti rule approved on ".date("d/m/Y H:i:s");
			// 		$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);
			// 	}
			// }
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule not approved. Try again!</b></div>');
		}
		redirect(site_url("view-lti-rule-details/".$rule_id));
	}

	public function reject_lti_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_LTI, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		if(trim($this->input->post("txt_remark")))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>4));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>4));

			if($request_dtl)
			{
				$data['rule_dtls'] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
				$this->approvel_model->reject_approvel_req($request_dtl["id"]);

				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$this->input->post("txt_remark"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($this->input->post("hf_req_for")==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "LTI rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><span><b>LTI rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "LTI rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>LTI rule rejected successfully.</b></div>');
				}

				$this->lti_rule_model->update_rules(array('id'=>$rule_id), $db_arr1);
				$this->lti_rule_model->delete_emp_salary_dtls(array("employee_lti_details.rule_id"=>$rule_id));
				$this->front_model->insert_notifications($db_arr2);
			}
		}
		else
		{
			redirect(site_url("view-lti-rule-details/".$rule_id));
		}
		redirect(site_url("view-lti-rule-details/".$rule_id));
	}

	public function update_rnr_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_RNR, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_rnr_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));

			$db_arr = array("notification_for"=>"R and R rule approved", "message"=>"R and R rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->rnr_rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
				$managers = $this->rule_model->get_managers_for_manual_bdgt("rnr_rule_users_dtls", $rule_id);

				if($managers)
				{
				$recipients_arr =array();
				foreach ($managers as $row)
				{
					if($row["first_approver"] != "")
					{
						$recipients_arr[] = $row["first_approver"];
					}
				}
				if($recipients_arr)
				{
					############ Get SMTP DEtails FOR Sending Mail #############

					$email_config=HLP_GetSMTP_Details();

					#############################################################
					$mail_body = "Dear Team,
					<br /><br />
					New R and R rule as :".$data['rule_dtls']["rule_name"]." is now approved.<br />
					<br /><br />
					Please go to site then login and check.";
					$mail_sub = "New R and R rule approved on ".date("d/m/Y H:i:s");


					//$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);

					$this->common_model->send_emails($email_config['email_from'], $recipients_arr, $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule not approved. Try again!</b></div>');
		}
		redirect(site_url("view-rnr-rule-details/".$rule_id));
	}

	public function reject_rnr_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_RNR, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		if(trim($this->input->post("txt_remark")))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>5));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>5));
			if($request_dtl)
			{
				$data['rule_dtls'] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
				$this->approvel_model->reject_approvel_req($request_dtl["id"]);

				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$this->input->post("txt_remark"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($this->input->post("hf_req_for")==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "R and R rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "R and R rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>R and R rule rejected successfully.</b></div>');
				}

				$this->rnr_rule_model->update_rules(array('id'=>$rule_id), $db_arr1);
				$this->front_model->insert_notifications($db_arr2);
			}
		}
		else
		{
			redirect(site_url("view-rnr-rule-details/".$rule_id));
		}
		redirect(site_url("view-rnr-rule-details/".$rule_id));
	}

	public function salary_rule_approval_request_list_NIU()
	{
		$condition_arr = " (approvel_requests.type = 2)";
		$data['rules_approvel_request_list'] = $this->approvel_model->get_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		$data['title'] = "Rule Approvel Request List";
		$data['body'] = "salary_ruels_approvel_request_list";
		$this->load->view('common/structure',$data);
	}

	public function update_salary_rule_approvel_req_NIU($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_salary_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));

			$db_arr = array("notification_for"=>"Salary rule approved", "message"=>"Salary rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>6, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));


			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
				$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);

				if($managers)
				{
					$recipients_arr =array();
					foreach ($managers as $row)
					{
						if($row["first_approver"] != "")
						{
							$recipients_arr[] = $row["first_approver"];
						}
					}
					if($recipients_arr)
					{
						$mail_body = "Dear Team,
						<br /><br />
						New salary rule as :".$data['rule_dtls']["salary_rule_name"]." is now approved.<br />
						<br /><br />
						Please go to site then login and check.";
						$mail_sub = "New salary rule approved on ".date("d/m/Y H:i:s");
						//$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);
					}
				}
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule not approved. Try again!</b></div>');
		}
		//redirect(site_url("salary-rule-approval-request-list"));
		redirect(site_url("performance-cycle"));
	}

	public function reject_salary_rule_approvel_req_NIU($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		if(trim($this->input->post("txt_remark")))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>2));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>2));
			if($request_dtl)
			{
				$data['rule_dtls'] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));



				$this->approvel_model->reject_approvel_req($request_dtl["id"]);
				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$this->input->post("txt_remark"),"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($this->input->post("hf_req_for")==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "Salary rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "Salary rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Salary rule rejected successfully.</b></div>');
				}
				$this->rule_model->update_rules(array('id'=>$rule_id), $db_arr1);
				$this->rule_model->delete_emp_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id));
				$this->front_model->insert_notifications($db_arr2);
			}
		}
		else
		{
			redirect(site_url("view-salary-rule-details/".$rule_id));
		}
		redirect(site_url("performance-cycle"));
	}

	public function update_sip_rule_approvel_req($rule_id)
	{
		if(!helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$result = $this->approvel_model->update_sip_rule_approvel_req($rule_id, $this->session->userdata("userid_ses"));
		if($result)
		{
			$data['rule_dtls'] =  $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));

			$db_arr = array("notification_for"=>"Bonus rule approved", "message"=>"SIP rule approved on ".date("d-m-Y") ,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);
			$this->front_model->insert_notifications($db_arr);
			$this->sip_model->updateSipRules(array("status"=>6, "updatedBy"=>$this->session->userdata("userid_ses"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"), "updatedOn"=>date("Y-m-d H:i:s")), array('id'=>$rule_id));

			$sdt = $data['rule_dtls']["start_date"];
			$edt = $data['rule_dtls']["end_date"];
			$cdt = date("Y-m-d", strtotime("+ 1 day"));
			if($sdt <= $cdt and $edt >= $cdt)//If current date is between date of start & end date of cycle then we have to soot mail to managers otherwier no need to do it.
			{
			// 	$managers = $this->rule_model->get_managers_for_manual_bdgt("sip_rule_users_dtls", $rule_id);

			// 	if($managers)
			// 	{
			// 	$recipients_arr =array();
			// 	foreach ($managers as $row)
			// 	{
			// 		if($row["first_approver"] != "")
			// 		{
			// 			$recipients_arr[] = $row["first_approver"];
			// 		}
			// 	}
			// 	if($recipients_arr)
			// 	{
			// 	$emailTemplate=$this->common_model->getEmailTemplate('newBonusRuleApproved');
			// 	$emailTemplate=$this->common_model->getEmailTemplate('newBonusRuleApproved');
			// 	$str=str_replace("{{sip_rule_name}}",$data['rule_dtls']["sip_rule_name"] , $emailTemplate[0]->email_body);
			// 	$str=str_replace("{{url}}",site_url() , $str);
			// 	$mail_body=$str;
			// 	$mail_sub = $emailTemplate[0]->email_subject." on ".date("d/m/Y H:i:s");
			// 		$this->common_model->send_emails(CV_EMAIL_FROM, $recipients_arr, $mail_sub, $mail_body);
			// 	}
			// }
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>SIP rule approved successfully.</b></div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>SIP rule not approved. Try again!</b></div>');
		}
		redirect(site_url("performance-cycle"));
	}

	public function reject_sip_rule_approvel_req($rule_id)
	{

		if(!helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
			redirect(site_url("performance-cycle"));
		}

			if(($this->input->post("txt_remark")) && ($this->input->post("hf_req_for"))) {
				$txt_remark = $this->input->post("txt_remark");
				$hf_req_for = $this->input->post("hf_req_for");
			}
			else if(($this->input->get("txt_remark")) && ($this->input->get("hf_req_for"))) {
				$txt_remark = $this->input->get("txt_remark");
				$hf_req_for = $this->input->post("hf_req_for");
			}
			else {
				redirect(site_url("view-sip-rule-details/".$rule_id));
			}

		if(trim($txt_remark))
		{
			//$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.user_id"=>$this->session->userdata("userid_ses"),"approvel_requests.status"=>0, "approvel_requests.type"=>3));
			$request_dtl = $this->approvel_model->check_approvel_request_is_valid_for_user(array("rule_id"=>$rule_id, "approvel_requests.status"=>0, "approvel_requests.type"=>6));
			if($request_dtl)
			{
				$data['rule_dtls'] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
				$this->approvel_model->reject_approvel_req($request_dtl["id"]);
				$db_arr1 = array("updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s"));
				$db_arr2 = array("message"=>$txt_remark,"rule_id"=>$rule_id, "updatedon"=> date("Y-m-d H:i:s"), "createdon"=> date("Y-m-d H:i:s"), "to_user_id"=>$data['rule_dtls']["createdby"]);

				if($hf_req_for==2)//Menas Rule deleted
				{
					$db_arr1["status"] = CV_STATUS_RULE_DELETED;
					$db_arr2["notification_for"] = "SIP rule approval request rejected and rule has been deleted on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>SIP rule deleted successfully.</b></div>');
				}
				else// Means Rule rejected
				{
					$db_arr1["status"] = 5;
					$db_arr2["notification_for"] = "SIP rule approval request rejected on ".date("d-m-Y");
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>SIP rule rejected successfully.</b></div>');
				}

				$this->sip_model->updatesipRules($db_arr1, array('id'=>$rule_id));
				$this->sip_model->delete_emp_sip_dtls(array("sip_employee_details.rule_id"=>$rule_id));
				$this->front_model->insert_notifications($db_arr2);
			}
		}

		redirect(site_url("performance-cycle"));
	}
}
