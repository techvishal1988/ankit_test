<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_cycle extends CI_Controller
{
	 public function __construct()
	 {
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
		$this->load->model("performance_cycle_model");
		$this->load->model("approvel_model");
		$this->load->model("upload_model");
		$this->load->model("admin_model");
		$this->load->model("rule_model");
		$this->load->model("bonus_model");
		$this->load->model("lti_rule_model");
		$this->load->model("common_model");
		$this->load->model("template_model");
		$this->lang->load('message', 'english');
		$this->current_data_time = date("Y-m-d H:i:s");
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{
			redirect(site_url("dashboard"));
		}
		HLP_is_valid_web_token();
  }

	public function index($id=0, $isdelete=0)
	{

		$data['msg'] = "";
		if(!helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_view_right_pc').'</b></span></div>');
			redirect(site_url("no-rights"));
		}

		if(!helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_create_right_pc').'</b></div>';
		}

		$user_id = $this->session->userdata("userid_ses");
		$currentDateTime = date("Y-m-d H:i:s");
		if($isdelete and $id)
		{
			$data["edit_dtls"] = $this->performance_cycle_model->get_performance_cycle_dtls(array("status"=>1, "id"=>$id));
			$cycle_type = $data["edit_dtls"]["type"];
			if(!(($cycle_type==CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID and $data["edit_dtls"]["salary_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID and $data["edit_dtls"]["bonus_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_LTI_TYPE_ID and $data["edit_dtls"]["lti_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID and $data["edit_dtls"]["rnr_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_SALES_ID and $data["edit_dtls"]["sip_rules_count"]>0)))
			{
				$perf_cycle_db_arr = array(
					"status"=> 2,
					"updatedby"=>$user_id,
					"updatedon"=>$currentDateTime,
					"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")
				);
				$this->performance_cycle_model->update_performance_cycle_dtls(array("id"=>$id), $perf_cycle_db_arr);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <b>'.$this->lang->line('msg_delete_success').'</b></div>');
				redirect(site_url("performance-cycle"));
			}
			redirect(site_url("performance-cycle"));
		}

		if($id)
		{
			$data["edit_dtls"] = $this->performance_cycle_model->get_performance_cycle_dtls(array("status"=>1, "id"=>$id));
			$cycle_type = $data["edit_dtls"]["type"];
			$data['edit_dtls_disable'] = false;
			if(($cycle_type==CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID and $data["edit_dtls"]["salary_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID and $data["edit_dtls"]["bonus_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_LTI_TYPE_ID and $data["edit_dtls"]["lti_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID and $data["edit_dtls"]["rnr_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_SALES_ID and $data["edit_dtls"]["bonus_rules_count"]>0))
			{
				$data['edit_dtls_disable'] = true;
			}
		}


		if($this->input->post())
		{

			if(!helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_INSERT_RIGHT_NAME))
			{
				//$this->session->set_flashdata('message', "<div align='left' style='color:red;' id='notify'><span><b>You don't have insert rights.</b></span></div>");
				redirect(site_url("performance-cycle"));
			}

			$performance_cycle_name = $this->input->post('txt_performance_cycle_name');
			$description = $this->input->get_post('txt_description');


			$start_dt=explode("/",$this->input->post('txt_start_dt'));
			$start_date=($start_dt[2].'-'.$start_dt[1].'-'.$start_dt[0]);
			$end_dt=explode("/",$this->input->post('txt_end_dt'));
			$end_date=($end_dt[2].'-'.$end_dt[1].'-'.$end_dt[0]);


			if (strtotime($end_date) < strtotime($start_date))
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Start date must be less than end date.</b></div>');
				redirect(site_url("performance-cycle"));
			}

			if(($cycle_type==CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID and $data["edit_dtls"]["salary_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID and $data["edit_dtls"]["bonus_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_LTI_TYPE_ID and $data["edit_dtls"]["lti_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID and $data["edit_dtls"]["rnr_rules_count"]>0) or ($cycle_type==CV_PERFORMANCE_CYCLE_SALES_ID and $data["edit_dtls"]["bonus_rules_count"]>0))
			{
				$performance_cycle_db_arr = array(
										"name"=>$performance_cycle_name,
										"end_date"=>$end_date,
										"start_date"=>$start_date,
										"description"=>$description,
										"updatedby"=>$user_id,
										"updatedon"=>$currentDateTime,
										"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")
										);
			} else {
				$performance_cycle_db_arr = array(
										"name"=>$performance_cycle_name,
										"type" =>$this->input->post('ddl_type'),
										"start_date"=>$start_date,
										"end_date"=>$end_date,
										"description"=>$description,
										"updatedby"=>$user_id,
										"updatedon"=>$currentDateTime,
										"updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")
										);

			}
			if($id)
			{
				$this->performance_cycle_model->update_performance_cycle_dtls(array("id"=>$id), $performance_cycle_db_arr);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <b>'.$this->lang->line('msg_no_edit_success').'</b></div>');
				redirect($_SERVER['HTTP_REFERER']);
				//redirect(site_url("performance-cycle"));
			}

			$performance_cycle_db_arr["createdby"] = $user_id;
			$performance_cycle_db_arr["createdon"] = $currentDateTime;
			$performance_cycle_db_arr["createdby_proxy"] = $this->session->userdata("proxy_userid_ses");

			$performance_cycle_id = $this->performance_cycle_model->insert_performance_cycle($performance_cycle_db_arr);
			//$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_create_success').'</b></div>');
			redirect(site_url("performance-cycle"));
		}

		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		$data["bonus_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID));
		$data["lti_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_LTI_TYPE_ID));
		$data["rnr_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID));
		$data["sale_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALES_ID));
		$data['title'] = "Design Compensation Plans";
		$data['body'] = "performance_cycle";
		$this->load->view('common/structure',$data);
	}

	public function salary_rule_list($pc_id)
	{
		$data['msg'] = "";

		if(!helper_have_rights(CV_COMP_SALARY, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_salary').'</b></div>');
			redirect(site_url("no-rights"));
		}
		if(!helper_have_rights(CV_COMP_SALARY, CV_INSERT_RIGHT_NAME) and $this->session->userdata('role_ses') != CV_ROLE_BUSINESS_UNIT_HEAD)
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_to_create_salary').'</b></div>';
		}

		$user_id = $this->session->userdata("userid_ses");

		$performance_cycle_dtls = $this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		if(!$performance_cycle_dtls)
		{
			redirect(site_url("performance-cycle"));
		}

		$data['cycle_dtls'] = $performance_cycle_dtls;

		if($this->input->post() and $this->input->post("hf_rule_id"))
		{
            $rule_id = $this->input->post("hf_rule_id");
			$rules_release_approvel_dtls = $this->approvel_model->get_rules_release_approvel_pending_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.id"=>$rule_id));
			if($rules_release_approvel_dtls)
			{
				$send_mail = 0;//Means no need to send mail to anyone
				if($this->input->post("btn_release"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 1;//Means need to send mail to all employees about rule released
					}
					$this->update_login_user_tbl_on_salary_rule_release($rule_id, 1, $send_mail);
					$this->rule_model->update_rules(array('id'=>$rule_id),array('template_id'=>$this->input->post("TempateID"),"status"=>CV_STATUS_RULE_RELEASED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_release_success_salary').'</b></div>');
				}
				elseif($this->input->post("btn_send_to_manager"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 2;//Means need to send mail to Managers about rule send for verification
					}
					$this->update_login_user_tbl_on_salary_rule_release($rule_id, 0, $send_mail);
					$this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>7, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_to_manager_success_salary').'</b></div>');
				}

				redirect(site_url("salary-rule-list/".$pc_id));
			}
		}

		$salary_rule_list_by_self = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.createdby"=>$user_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$salary_rule_list_by_other = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.createdby !="=>$user_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$data["salary_rule_list"] = array_merge($salary_rule_list_by_self, $salary_rule_list_by_other);
		$data['totalempinrule']=$this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		//$empids='';
		$empids = array();
		foreach($data['totalempinrule'] as $temp)
		{
			//$empids.=$temp['user_ids'];
			$empids[] = $temp['id'];
		}

		//$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);
		if($empids)
		{
			$data['emp_not_in_rule'] = $this->rule_model->get_table_row("login_user", "COUNT(*) AS total_emp_cnt", "status = 1 AND role > 1 AND id NOT In (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id IN(".implode(",", $empids)."))", "id ASC");
		}
		$data['approvel_request_list'] = "";
		if(helper_have_rights(CV_APPROVE_SALARY, CV_UPDATE_RIGHT_NAME))
		{
			$condition_arr = " (approvel_requests.type = 2 and hr_parameter.status != ".CV_STATUS_RULE_DELETED.")";
			$data['approvel_request_list'] = $this->approvel_model->get_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		}

		$data['rules_release_approvel_list'] = $this->approvel_model->get_rules_release_approvel_pending_list(array("hr_parameter.performance_cycle_id"=>$pc_id));



		$data['template']=$this->template_model->get_templates('template', array('RuleType'=>'salary'));

		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = "Salary Rules";
		$data['body'] = "salary/salary_rule_list";
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('common/structure',$data);
	}

	public function notinrule($pc_id)
	{
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, status, ba_name", "", "id asc");
		/*$data['totalempinrule']=$this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id));

		$empids='';
		foreach($data['totalempinrule'] as $temp)
		{
			 $empids.=$temp['user_ids'];
		}

		$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);*/
		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = "Salary Rules";
		$data['body'] = "admin/employee_not_in_rule";
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);

		$this->load->view('common/structure',$data);
	}

	public function bonusnotinrule($pc_id)
	{
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, status, ba_name", "", "id asc");
		/*$data['totalempinrule']=$this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id));

		$empids='';
		foreach($data['totalempinrule'] as $temp)
		{
			 $empids.=$temp['user_ids'];
		}

		$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);*/
		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = CV_BONUS_SIP_LABEL_NAME." Rules";
		$data['body'] = "admin/employee_not_in_bonus_rule";
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$this->load->view('common/structure',$data);
	}

	public function update_login_user_tbl_on_salary_rule_release($rule_id, $is_need_to_upd_datum, $mail_for)
	{
		// Note :: $mail_for 0=No need to send mail, 1=Employee Only & Managers, $mail_for 2=Manager Only
		//		   $is_need_to_upd_datum 0=rule send to manager for verification, 1=Rule released finally
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		if(!$rule_dtls  or $rule_dtls["status"] < 6)
		{
			redirect(site_url("performance-cycle"));
		}

		$staff_list = $this->approvel_model->staffs_to_update_datum_on_salary_rule_release(array("employee_salary_details.rule_id"=>$rule_id));
		$emailTemplate=$this->common_model->getEmailTemplate("newSalaryRuleRelesed");
		//Final released condition and need to update datum table
		if($is_need_to_upd_datum)
		{
			$upload_db_arr = array(
								"original_file_name"=>CV_DEFAULT_FILE_NAME,
								"uploaded_file_name"=>CV_DEFAULT_FILE_NAME,
								"status"=>1,
								"upload_date"=>date("Y-m-d H:i:s"),
								"uploaded_by_user_id"=>$this->session->userdata('userid_ses'),
								"createdby_proxy"=>$this->session->userdata("proxy_userid_ses"));
			$upload_id=$this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
		}
		$row_no = 0;
		############ Get SMTP DEtails FOR Sending Mail #############

          $email_config=HLP_GetSMTP_Details();

        #############################################################
		foreach ($staff_list as $row) {

        if ($is_need_to_upd_datum) {
                $sal_elem_arr = json_decode($row['increment_applied_on_elem_dtls'], true);
                if ($sal_elem_arr) {
                    $users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id" => $row["user_id"]), "id desc");
                    $db_arr = array();
                    $db_arr["upload_id"] = $upload_id;
                    $db_arr["updatedby"] = $this->session->userdata('userid_ses');
                    $db_arr["updatedby_proxy"] = $this->session->userdata('proxy_userid_ses');
                    $db_arr["updatedon"] = date("Y-m-d H:i:s");

                    if (trim($row['emp_new_designation'])) {
                        $des_arr = $this->upload_model->get_table_row("manage_grade", "id", array("name" => $row['emp_new_designation']));
                        if ($des_arr) {
                            $new_desig_id = $des_arr["id"];
                        } else {
                            $this->admin_model->insert_data_in_tbl("manage_grade", array("name" => $row['emp_new_designation']));
                            $new_desig_id = $this->db->insert_id();
                        }
                        //$db_arr[CV_BA_NAME_DESIGNATION] = $new_desig_id;
                        $db_arr[CV_BA_NAME_GRADE] = $new_desig_id;
                    }

                    foreach ($sal_elem_arr as $elem_row) {
                        $sal_elem_new_val = $elem_row["value"] + (($elem_row["value"] * $row["manager_discretions"]) / 100);
                        $db_arr[$elem_row["ba_name"]] = $sal_elem_new_val;
                    }

                    //Start :: Moved Previous Salary Elements (1 Level)
                    $db_arr[CV_BA_NAME_SALARY_AFTER_LAST_INCREASE] = $users_dtls[CV_BA_NAME_CURRENT_BASE_SALARY];
                    $db_arr[CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE] = date("Y-m-d");

                    $db_arr[CV_BA_NAME_SALARY_AFTER_2ND_LAST_INCREASE] = $users_dtls[CV_BA_NAME_SALARY_AFTER_LAST_INCREASE];
                    $db_arr[CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE] = $users_dtls[CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE];

                    $db_arr[CV_BA_NAME_SALARY_AFTER_3RD_LAST_INCREASE] = $users_dtls[CV_BA_NAME_SALARY_AFTER_2ND_LAST_INCREASE];
                    $db_arr[CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE] = $users_dtls[CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE];

                    $db_arr[CV_BA_NAME_SALARY_AFTER_4TH_LAST_INCREASE] = $users_dtls[CV_BA_NAME_SALARY_AFTER_3RD_LAST_INCREASE];
                    $db_arr[CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE] = $users_dtls[CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE];

                    $db_arr[CV_BA_NAME_SALARY_AFTER_5TH_LAST_INCREASE] = $users_dtls[CV_BA_NAME_SALARY_AFTER_4TH_LAST_INCREASE];
                    $db_arr[CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE] = $users_dtls[CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE];
                    //End :: Moved Previous Salary Elements (1 Level)
                    $this->rule_model->manage_users_history("id = " . $row["user_id"]);
                    $this->admin_model->update_tbl_data("login_user", $db_arr, array("id" => $row["user_id"]));
                }
            }

        if ($mail_for == "1") {
            if ($row[CV_BA_NAME_EMP_EMAIL]) {


				$str=str_replace("{{rule_name}}",$rule_dtls["salary_rule_name"], $emailTemplate[0]->email_body);

			    $mail_body=$str;

                $mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

                //$this->common_model->send_emails(CV_EMAIL_FROM, $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body);

                $this->common_model->send_emails($email_config['email_from'], $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
            }
        }
    }

		//Notify to manager that new rule released to check and verify before showing to employees
		if($mail_for == 2)
		{
			//$managers = $this->rule_model->get_managers_for_manual_bdgt($rule_dtls["user_ids"]);
			$managers = $this->rule_model->get_managers_for_manual_bdgt("salary_rule_users_dtls", $rule_id);
			foreach($managers as $value)
			{
				if($value["first_approver"])
				{
					$str=str_replace("{{rule_name}}",$rule_dtls["salary_rule_name"], $emailTemplate[0]->email_body);

			    	$mail_body=$str;

                $mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

					//$this->common_model->send_emails(CV_EMAIL_FROM, $value["first_approver"], $mail_sub, $mail_body);

					 $this->common_model->send_emails($email_config['email_from'], $value["first_approver"], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
		}
	}

	public function bonus_rule_list($pc_id)
	{
		$data['msg'] = "";

		if(!helper_have_rights(CV_COMP_BONUS, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_bonus').'</b></div>');
			redirect(site_url("no-rights"));
		}
		if(!helper_have_rights(CV_COMP_BONUS, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_to_create_bonus').'</b></div>';
		}

		$user_id = $this->session->userdata("userid_ses");
		$performance_cycle_dtls=$this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1));
		if(!$performance_cycle_dtls or ($performance_cycle_dtls["type"] != CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID and $performance_cycle_dtls["type"] != CV_PERFORMANCE_CYCLE_SALES_ID))
		{
			redirect(site_url("performance-cycle"));
		}

		if($this->input->post() and $this->input->post("hf_rule_id"))
		{
			$rule_id = $this->input->post("hf_rule_id");
			$rules_release_approvel_dtls = $this->approvel_model->get_bonus_rules_release_approvel_pending_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id, "hr_parameter_bonus.id"=>$rule_id));
			if($rules_release_approvel_dtls)
			{
				$send_mail = 0;//Means no need to send mail to anyone
				if($this->input->post("btn_release"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 1;//Means need to send mail to all employees about rule released
					}
					$this->update_login_user_tbl_on_bonus_rule_release($rule_id, 1, $send_mail);
					$this->bonus_model->updateBonusRules(array('template_id'=>$this->input->post("TempateID"),"status"=>CV_STATUS_RULE_RELEASED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array('id'=>$rule_id));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_release_success_bonus').'</b></div>');
				}
				elseif($this->input->post("btn_send_to_manager"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 2;//Means need to send mail to Managers about rule send for verification
					}
					$this->update_login_user_tbl_on_bonus_rule_release($rule_id, 0, $send_mail);
					$this->bonus_model->updateBonusRules(array('template_id'=>$this->input->post("TempateID"),"status"=>7, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array('id'=>$rule_id));
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_to_manager_success_bonus').'</b></div>');
				}
				redirect(site_url("bonus-rule-list/".$pc_id));
			}
		}

		$bonus_rule_list_by_self = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id, "hr_parameter_bonus.createdby"=>$user_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		$bonus_rule_list_by_other = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id, "hr_parameter_bonus.createdby !="=>$user_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));

		$data["bonus_rule_list"] = array_merge($bonus_rule_list_by_self, $bonus_rule_list_by_other);

		$data['totalempinrule']=$this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		$bonus_rule_ids = array();
		foreach($data['totalempinrule'] as $temp)
		{
			 $bonus_rule_ids[] = $temp['id'];
		}
		//$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);
		if($bonus_rule_ids)
		{
			$data['emp_not_in_rule'] = $this->rule_model->get_table_row("login_user", "COUNT(*) AS total_emp_cnt", "id NOT IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id IN(".implode(",", $bonus_rule_ids)."))", "id ASC");
		}

		$data['approvel_request_list'] = "";
		if(helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$condition_arr = " (approvel_requests.type = 3 AND hr_parameter_bonus.status != ".CV_STATUS_RULE_DELETED.")";
			$data['approvel_request_list'] = $this->approvel_model->get_bonus_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		}

		$data['rules_release_approvel_list'] = $this->approvel_model->get_bonus_rules_release_approvel_pending_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id));
		$data['template']=$this->template_model->get_templates('template', array('RuleType'=>'bonus'));

		$data['rule_txt_name'] = CV_BONUS_LABEL_NAME;
		
		$data['cycle_type'] = $performance_cycle_dtls["type"];
		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = $data['rule_txt_name']." Rules";
		$data['body'] = "bonus_rule_list";
		$this->load->view('common/structure',$data);
	}

	public function sip_rule_list($pc_id)
	{
		$data['msg'] = "";

		if(!helper_have_rights(CV_COMP_BONUS, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_sip').'</b></div>');
			redirect(site_url("no-rights"));
		}
		if(!helper_have_rights(CV_COMP_BONUS, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_to_create_sip').'</b></div>';
		}

		$user_id = $this->session->userdata("userid_ses");
		$performance_cycle_dtls=$this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1));
		if(!$performance_cycle_dtls or $performance_cycle_dtls["type"] != CV_PERFORMANCE_CYCLE_SALES_ID)
		{
			redirect(site_url("performance-cycle"));
		}

		if($this->input->post() and $this->input->post("hf_rule_id"))
		{
			$rule_id = $this->input->post("hf_rule_id");
			$rules_release_approvel_dtls = $this->approvel_model->get_sip_rules_release_approvel_pending_list(array("sip_hr_parameter.performance_cycle_id"=>$pc_id, "sip_hr_parameter.id"=>$rule_id));

			if($rules_release_approvel_dtls)
			{
				$send_mail = 0;//Means no need to send mail to anyone
				if($this->input->post("btn_release"))
				{
					if($this->input->post("chk_send_mail")) {
						$send_mail = 1;//Means need to send mail to all employees about rule released
					}
					$this->update_login_user_tbl_on_sip_rule_release($rule_id, 1, $send_mail);
					$this->sip_model->updateSipRules(array('template_id'=>$this->input->post("TempateID"),"status"=>CV_STATUS_RULE_RELEASED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array('id'=>$rule_id));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_release_success_sip').'</b></div>');
				}
				elseif($this->input->post("btn_send_to_manager"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 2;//Means need to send mail to Managers about rule send for verification
					}
					$this->update_login_user_tbl_on_sip_rule_release($rule_id, 0, $send_mail);
					$this->sip_model->updateSipRules(array('template_id'=>$this->input->post("TempateID"),"status"=>7, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array('id'=>$rule_id));
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_to_manager_success_sip').'</b></div>');
				}
				redirect(site_url("sip-rule-list/".$pc_id));
			}
		}

		$sip_rule_list_by_self = $this->performance_cycle_model->get_sip_rules_list(array("sip_hr_parameter.performance_cycle_id"=>$pc_id, "sip_hr_parameter.createdby"=>$user_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		$sip_rule_list_by_other = $this->performance_cycle_model->get_sip_rules_list(array("sip_hr_parameter.performance_cycle_id"=>$pc_id, "sip_hr_parameter.createdby !="=>$user_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		$data["sip_rule_list"] = array_merge($sip_rule_list_by_self, $sip_rule_list_by_other);

		$data['totalempinrule']=$this->performance_cycle_model->get_sip_rules_list(array("sip_hr_parameter.performance_cycle_id"=>$pc_id, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$sip_rule_ids = array();
		foreach($data['totalempinrule'] as $temp)
		{
			 $sip_rule_ids[] = $temp['id'];
		}
		//$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);

		if($sip_rule_ids)
		{
			$data['emp_not_in_rule'] = $this->rule_model->get_table_row("login_user", "COUNT(*) AS total_emp_cnt", "id NOT IN (SELECT user_id FROM sip_rule_users_dtls WHERE rule_id IN(".implode(",", $sip_rule_ids)."))", "id ASC");
		}

		$data['approvel_request_list'] = "";
		if(helper_have_rights(CV_APPROVE_BONUS, CV_UPDATE_RIGHT_NAME))
		{
			$condition_arr = " (approvel_requests.type = 6 AND sip_hr_parameter.status != ".CV_STATUS_RULE_DELETED.")";
			$data['approvel_request_list'] = $this->approvel_model->get_sip_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		}

		$data['rules_release_approvel_list'] = $this->approvel_model->get_sip_rules_release_approvel_pending_list(array("sip_hr_parameter.performance_cycle_id"=>$pc_id));
		$data['template']=$this->template_model->get_templates('template', array('RuleType'=>'bonus'));

		$data['rule_txt_name'] = CV_BONUS_LABEL_NAME;
		if($performance_cycle_dtls["type"] == CV_PERFORMANCE_CYCLE_SALES_ID) {
			$data['rule_txt_name'] = CV_BONUS_SIP_LABEL_NAME;
		}

		$data['cycle_type'] = $performance_cycle_dtls["type"];
		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = $data['rule_txt_name']." Rules";
		$data['body'] = "sip/sip_rule_list";
		$this->load->view('common/structure',$data);
	}

	public function update_login_user_tbl_on_sip_rule_release($rule_id, $is_need_to_upd_login_user_tbl, $mail_for)
	{
		// Note :: $mail_for 0=No need to send mail, 1=Employee Only & Managers, $mail_for 2=Manager Only
	    //		   $is_need_to_upd_login_user_tbl 0=rule send to manager for verification, 1=Rule released finally

		$rule_dtls = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id));
		$emailTemplate=$this->common_model->getEmailTemplate("newBonusRuleRelesed");
		if(!$rule_dtls  or $rule_dtls["status"] < 6)
		{
			redirect(site_url("performance-cycle"));
		}

		$staff_list = $this->approvel_model->staffs_to_update_datum_on_sip_salary_rule_release(array("employee_sip_details.rule_id"=>$rule_id));

		//Final released condition and need to update datum table
		if($is_need_to_upd_login_user_tbl)
		{
			$upload_db_arr = array(
								"original_file_name"=>CV_DEFAULT_FILE_NAME,
								"uploaded_file_name"=>CV_DEFAULT_FILE_NAME,
								"status"=>1,
								"upload_date"=>date("Y-m-d H:i:s"),
								"uploaded_by_user_id"=>$this->session->userdata('userid_ses'),
								"createdby_proxy"=>$this->session->userdata("proxy_userid_ses"));
			$upload_id=$this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
		}

			############ Get SMTP DEtails FOR Sending Mail #############

          $email_config=HLP_GetSMTP_Details();

        #############################################################
		foreach($staff_list as $row)
		{
			//Final released condition and need to update datum table
			if($is_need_to_upd_login_user_tbl)
			{
				$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$row["user_id"]), "id desc");

				$db_arr=array();
				$db_arr["upload_id"] = $upload_id;
				$db_arr[CV_BA_NAME_CURRENT_TARGET_BONUS] = $users_dtls[CV_BA_NAME_CURRENT_TARGET_BONUS];
				$db_arr["updatedby"] = $this->session->userdata('userid_ses');
				$db_arr["updatedby_proxy"] = $this->session->userdata('proxy_userid_ses');
				$db_arr["updatedon"] = date("Y-m-d H:i:s");

				$this->rule_model->manage_users_history("id = ".$row["user_id"]);
				$this->admin_model->update_tbl_data("login_user", $db_arr, array("id"=>$row["user_id"]));
			}

			//Need to send mail to all employee to inform that rule released, they can check his new sip
			if($mail_for == "1")
			{
				if($row[CV_BA_NAME_EMP_EMAIL])
				{
					$str=str_replace("{{rule_name}}",$rule_dtls["sip_rule_name"], $emailTemplate[0]->email_body);

					$mail_body=$str;

					$mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

					//$this->common_model->send_emails(CV_EMAIL_FROM, $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body);

					$this->common_model->send_emails($email_config['email_from'], $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
		}

		//Notify to manager that new rule released to check and verify before showing to employees
		if($mail_for == 2)
		{
			//$managers = $this->rule_model->get_managers_for_manual_bdgt($rule_dtls["user_ids"]);
			$managers = $this->rule_model->get_managers_for_manual_bdgt("sip_rule_users_dtls", $rule_id);

			foreach($managers as $value)
			{
				if($value["first_approver"])
				{
					$str=str_replace("{{rule_name}}",$rule_dtls["sip_rule_name"], $emailTemplate[0]->email_body);

					$mail_body=$str;

					$mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

					//$this->common_model->send_emails(CV_EMAIL_FROM, $value["first_approver"], $mail_sub, $mail_body);

					$this->common_model->send_emails($email_config['email_from'], $value["first_approver"], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
		}
	}

	public function lti_rule_list($pc_id)
	{
		$data['msg'] = "";

		if(!helper_have_rights(CV_COMP_LTI, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_lti').'</b></span></div>');
			redirect(site_url("no-rights"));
		}
		if(!helper_have_rights(CV_COMP_LTI, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_to_create_lti').'</b></span></div>';
		}

		$user_id = $this->session->userdata("userid_ses");

		$performance_cycle_dtls = $this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1, "type"=>CV_PERFORMANCE_CYCLE_LTI_TYPE_ID));
		if(!$performance_cycle_dtls)
		{
			redirect(site_url("performance-cycle"));
		}

		if($this->input->post() and $this->input->post("hf_rule_id"))
		{
			$rule_id = $this->input->post("hf_rule_id");
			$rules_release_approvel_dtls = $this->approvel_model->get_lti_rules_release_approval_pending_list(array("lti_rules.performance_cycle_id"=>$pc_id, "lti_rules.id"=>$rule_id));
			if($rules_release_approvel_dtls)
			{
				$send_mail = 0;//Means no need to send mail to anyone
				if($this->input->post("btn_release"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 1;//Means need to send mail to all employees about rule released
					}
					$this->send_mail_to_manager_n_emp_on_lti_rule_release($rule_id, 1, $send_mail);
					$this->lti_rule_model->update_rules(array('id'=>$rule_id), array('template_id'=>$this->input->post("TempateID"), "status"=>CV_STATUS_RULE_RELEASED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_release_success_lti').'</b></div>');
				}
				elseif($this->input->post("btn_send_to_manager"))
				{
					if($this->input->post("chk_send_mail"))
					{
						$send_mail = 2;//Means need to send mail to Managers about rule send for verification
					}
					$this->send_mail_to_manager_n_emp_on_lti_rule_release($rule_id, 0, $send_mail);
					$this->lti_rule_model->update_rules(array('id'=>$rule_id), array('template_id'=>$this->input->post("TempateID"), "status"=>7, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_sent_to_manager_success_lti').'</b></div>');
				}
				redirect(site_url("lti-rule-list/".$pc_id));
			}
		}

		$lti_rule_list_by_self = $this->performance_cycle_model->get_lti_rules_list(array("lti_rules.performance_cycle_id"=>$pc_id, "lti_rules.createdby"=>$user_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		$lti_rule_list_by_other = $this->performance_cycle_model->get_lti_rules_list(array("lti_rules.performance_cycle_id"=>$pc_id, "lti_rules.createdby !="=>$user_id, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		$data["lti_rule_list"] = array_merge($lti_rule_list_by_self, $lti_rule_list_by_other);

		$data['lti_approvel_request_list'] = "";
		if(helper_have_rights(CV_APPROVE_LTI, CV_UPDATE_RIGHT_NAME))
		{
			$condition_arr = " (approvel_requests.type = 4 and lti_rules.status != ".CV_STATUS_RULE_DELETED.")";
			$data['lti_approvel_request_list'] = $this->approvel_model->get_lti_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		}

		$data['rules_release_approvel_list'] = $this->approvel_model->get_lti_rules_release_approval_pending_list(array("lti_rules.performance_cycle_id"=>$pc_id));
		$data['template']=$this->template_model->get_templates('template', array('RuleType'=>'lti'));
		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = "LTI Rules";
		$data['body'] = "lti_rule_list";
		$this->load->view('common/structure',$data);
	}

	public function send_mail_to_manager_n_emp_on_lti_rule_release($rule_id, $is_need_to_upd_datum, $mail_for)
	{
		// Note :: $mail_for 0=No need to send mail, 1=Employee Only & Managers, $mail_for 2=Manager Only
		//		   $is_need_to_upd_datum 0=rule send to manager for verification, 1=Rule released finally

		$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		$emailTemplate=$this->common_model->getEmailTemplate("newLtiRuleRelesed");
		if(!$rule_dtls  or $rule_dtls["status"] < 6)
		{
			redirect(site_url("performance-cycle"));
		}

		$staff_list = $this->lti_rule_model->get_rule_wise_emp_list_for_incentives($rule_id);
		############ Get SMTP DEtails FOR Sending Mail #############

          $email_config=HLP_GetSMTP_Details();

        #############################################################
		foreach($staff_list as $row)
		{
			//Need to send mail to all employee to inform that rule released, they can check his new bonus
			if($mail_for == "1")
			{
				if($row[CV_BA_NAME_EMP_EMAIL])
				{
					$str=str_replace("{{rule_name}}",$rule_dtls["rule_name"], $emailTemplate[0]->email_body);

					$mail_body=$str;

					$mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

					//$this->common_model->send_emails(CV_EMAIL_FROM, $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body);

					$this->common_model->send_emails($email_config['email_from'],  $row[CV_BA_NAME_EMP_EMAIL], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
		}

		//Notify to manager that new rule released to check and verify before showing to employees
		if($mail_for == 2)
		{
			$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $rule_id);
			foreach($managers as $value)
			{
				if($value["first_approver"])
				{
					$str=str_replace("{{rule_name}}",$rule_dtls["rule_name"], $emailTemplate[0]->email_body);

					$mail_body=$str;

					$mail_sub =  $emailTemplate[0]->email_subject. date("d/m/Y H:i:s");

					//$this->common_model->send_emails(CV_EMAIL_FROM, $value["first_approver"], $mail_sub, $mail_body);
					$this->common_model->send_emails($email_config['email_from'],  $value["first_approver"], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
				}
			}
		}
	}

	public function rnr_rule_list($pc_id)
	{
		$data['msg'] = "";

		if(!helper_have_rights(CV_COMP_RNR, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_rnr').'</b></div>');
			redirect(site_url("no-rights"));
		}
		if(!helper_have_rights(CV_COMP_RNR, CV_INSERT_RIGHT_NAME))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right_to_create_rnr').'</b></span></div>';
		}

		$user_id = $this->session->userdata("userid_ses");

		$performance_cycle_dtls = $this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1, "type"=>CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID));
		if(!$performance_cycle_dtls)
		{
			redirect(site_url("performance-cycle"));
		}

		$rnr_rule_list_by_self = $this->performance_cycle_model->get_rnr_rules_list(array("rnr_rules.performance_cycle_id"=>$pc_id, "rnr_rules.createdby"=>$user_id, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		$rnr_rule_list_by_other = $this->performance_cycle_model->get_rnr_rules_list(array("rnr_rules.performance_cycle_id"=>$pc_id, "rnr_rules.createdby !="=>$user_id, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		$data["rnr_rule_list"] = array_merge($rnr_rule_list_by_self, $rnr_rule_list_by_other);

		$data['rnr_approvel_request_list'] = "";
		if(helper_have_rights(CV_APPROVE_RNR, CV_UPDATE_RIGHT_NAME))
		{
			$condition_arr = " (approvel_requests.type = 5 and rnr_rules.status != ".CV_STATUS_RULE_DELETED.")";
			$data['rnr_approvel_request_list'] = $this->approvel_model->get_rnr_rules_approvel_request_list($this->session->userdata("userid_ses"), $condition_arr);
		}

		$data['performance_cycle_id'] = $pc_id;
		$data['title'] = "R and R";
		$data['body'] = "rnr_rule_list";
		$this->load->view('common/structure',$data);
	}

	public function coverage($cycleID,$type)
	{
		$data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
		$data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
		$data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		$data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		$data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		$data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		$data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
		$data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");
		$data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		$data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");
		$data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
		$data['sub_sub_function_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1", "name asc");
		if($type=='bonus')
		{
		   $data["salary_rule_list"] = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$cycleID, "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		}
		if($type=='salary')
		{
			$data["salary_rule_list"] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$cycleID, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		}
		if($type=='lti')
		{
			$data["salary_rule_list"] = $this->performance_cycle_model->get_lti_rules_list(array("lti_rules.performance_cycle_id"=>$cycleID, "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		}
		if($type=='rnr')
		{
		   $data["salary_rule_list"] = $this->performance_cycle_model->get_rnr_rules_list(array("rnr_rules.performance_cycle_id"=>$cycleID, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		}
		if($type=='sip')
		{
		   $data["salary_rule_list"] = $this->performance_cycle_model->get_sip_rules_list(array("sip_hr_parameter.performance_cycle_id"=>$cycleID, "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		}
		$data['title'] = "Peformance Plan Coverage";
		$data['body'] = "admin/coverage";
		$this->load->view('common/structure',$data);
	}

	################# Kingjuliean Work ###################

	public function getEmailTemplate()
	{
		$data['first_mail']=$this->common_model->getEmailTemplate(SALARY_RULE_APPROVE);
		$data['reminder_mail']=$this->common_model->getEmailTemplate(SALARY_RULE_APPROVE_REMINDER);
		//print_r($result);
		echo json_encode($data);
	}

	public function sentEmailToApprovers($id)//,$rule_name
	{

		$conditions=' id='.$id;

		$data_arr = array(
			'condtion'	=>	$conditions,
			'user_list'	=>	'',
			'user_session_id'	=> $this->session->userdata('userid_ses'),
			'user_session_email'=> $this->session->userdata('email_ses'),
			'rule_id'	=> $id,
		);

		$this->db->insert(''.CV_PLATFORM_DB_NAME.'.corn_job_queue',array('json_text'=>json_encode($data_arr),'compnay_id'=>$this->session->userdata('companyid_ses'),'mail_stage'=>SALARY_RULE_APPROVE, 'status' => 0,'createdon' => date("Y-m-d H:i:s",time())));

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your emails are queued and will go out shortly</b></div>');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reminderEmailToApprovers($id)//,$rule_name
	{

		//$conditions		=' id='.$id;
		//$performance_cycle_id	=	getSingleTableData('hr_parameter',$conditions,'performance_cycle_id');
		//$conditions2	= ' id='.$performance_cycle_id[0]->performance_cycle_id;
		//$rule_name		= getSingleTableData('performance_cycle',$conditions2,'name');

		$data_arr = array(
				'condtion'=>''
				,'user_list'=>''
				,'user_session_id'=>$this->session->userdata('userid_ses')
				,'user_session_email'=>$this->session->userdata('email_ses')
				,'rule_id'=>$id
				//,'plan_name'=>$rule_name[0]->name
			);

		$this->db->insert(''.CV_PLATFORM_DB_NAME.'.corn_job_queue',array('json_text'=>json_encode($data_arr),'compnay_id'=>$this->session->userdata('companyid_ses'),'mail_stage'=>SALARY_RULE_APPROVE_REMINDER, 'status' => 0,'createdon' => date("Y-m-d H:i:s",time())));

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your emails are queued and will go out shortly.</b></div>');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function getEmailBonusRuleTemplate()
	{
		$data['first_mail']=$this->common_model->getEmailTemplate('newBonusRuleApproved');
		$data['reminder_mail']=$this->common_model->getEmailTemplate('bonusRuleApproveReminder');
		//print_r($result);
		echo json_encode($data);
	}


	public function sentEmailBonusToApprove($id)
		{

			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("bonus_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('hr_parameter_bonus',$conditions2,'bonus_rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("newBonusRuleApproved");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{bonus_rule_name}}",$rule_name[0]->bonus_rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
				$mail_body=$str;

				//$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}

		public function reminderEmailBonusToApprovers($id,$rule_name)
		{

			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("bonus_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('hr_parameter_bonus',$conditions2,'bonus_rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("bonusRuleApproveReminder");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{bonus_rule_name}}",$rule_name[0]->bonus_rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
				$mail_body=$str;

				//$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}


		public function getEmailLtiRuleTemplate()
	{
		$data['first_mail']=$this->common_model->getEmailTemplate('newLtiRuleApproved');
		$data['reminder_mail']=$this->common_model->getEmailTemplate('ltiRuleApproveReminder');
		//print_r($result);
		echo json_encode($data);
	}


	public function sentEmailLtiToApprove($id)
		{
			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('lti_rules',$conditions2,'rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("newLtiRuleApproved");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{lti_rule_name}}",$rule_name[0]->rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
				$mail_body=$str;

				//$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}

		public function reminderEmailLtiToApprovers($id,$rule_name)
		{
			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("lti_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('lti_rules',$conditions2,'rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("ltiRuleApproveReminder");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{lti_rule_name}}",$rule_name[0]->rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
			    $mail_body=$str;

				//$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}

		  public function getEmailrnrRuleTemplate()
			{
				$data['first_mail']=$this->common_model->getEmailTemplate('newRandRRuleApproved');
				$data['reminder_mail']=$this->common_model->getEmailTemplate('rnrRuleApproveReminder');
				//print_r($result);
				echo json_encode($data);
			}


	public function sentEmailrnrToApprove($id)
		{
			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("rnr_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('rnr_rules',$conditions2,'rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("newRandRRuleApproved");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{rnr_rule_name}}",$rule_name[0]->rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
				$mail_body=$str;

				//$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}

		public function reminderEmailrnrToApprovers($id,$rule_name)
		{
			############ Get SMTP DEtails FOR Sending Mail #############

			$email_config=HLP_GetSMTP_Details();

			#############################################################

			$managers = $this->rule_model->get_managers_for_manual_bdgt("rnr_rule_users_dtls", $id);

			$conditions2=' id='.$id;
			$rule_name=getSingleTableData('rnr_rules',$conditions2,'rule_name');
			$emailTemplate=$this->common_model->getEmailTemplate("rnrRuleApproveReminder");

			foreach ($managers as $row) {

				$str=str_replace("{{approvers_first_name}}",$row['manager_name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{rnr_rule_name}}",$rule_name[0]->rule_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['first_approver'] , $str);
				$str=str_replace("{{url}}",site_url() , $str);
			    $mail_body=$str;

			//	$this->common_model->send_emails(CV_EMAIL_FROM, $row->approver_1, $emailTemplate[0]->email_subject, $mail_body);

				$this->common_model->send_emails($email_config['email_from'],  $row['first_approver'] , $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

			}

		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
            redirect($_SERVER['HTTP_REFERER']);


		}



	#####################################################

// update status for Release letter to manager
 public function releaseLetterToManager_NIU()
 {
// 	 print_r($_POST);
 // 	$mpdf = new mPDF('',    // mode - default ''
 // '',    // format - A4, for example, default ''
 // 0,     // font size - default 0
 // '',    // default font family
 // 15,    // margin_left
 // 15,    // margin right
 // 16,     // margin top
 // 16,    // margin bottom
 // 9,     // margin header
 // 9,     // margin footer
 // 'L');  // L - landscape, P - portrait

 // release to manager
// $this->rule_model->update_rules(array('id'=>$rule_id),array("status"=>7, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));

// $this->rule_model->update_rules(array('id'=>$_POST['hf_rule_id']),array('template_id'=>$_POST['TempateID'],"status"=>CV_STATUS_RULE_RELEASED, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));

 $get_templatestatus=$this->admin_model->get_table_row("hr_parameter",'template_id,id',['id'=>$_POST['hf_rule_id']]);

if($get_templatestatus['template_id']=='0')
{
  $this->rule_model->update_rules(array('id'=>$_POST['hf_rule_id']),array("status"=>7,"template_id"=>$_POST['TempateID'], "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
  $templateid=$_POST['TempateID'];
}else{
$templateid=$get_templatestatus['template_id'];
}


 $manager_ids=explode(',',$_POST['manager_ids']);
 for ($i=0; $i <count($manager_ids) ; $i++){

  $employee_list=$this->admin_model->get_table("employee_salary_details", 'user_id,emp_name',['approver_1'=>$manager_ids[$i],'rule_id'=>$_POST['hf_rule_id']]);

		foreach ($employee_list as $key => $value)
		{

		// update letter_status
			$this->template_model->updateCommon('employee_salary_details',array("letter_status"=>3),array('user_id'=>$value['user_id'],'rule_id'=>$_POST['hf_rule_id']));

		}

 }

$data['TempateID']=$templateid;
$data['rule_id']=$_POST['hf_rule_id'];
$data['managers']=$_POST['manager_ids'];
$manager_data['json_text']=serialize($data);
$manager_data['compnay_id']=$this->session->userdata('companyid_ses');
// $manager_data['rule_id']=$_POST['hf_rule_id'];
$manager_data['mail_stage']='genarate_letter';
$manager_data['status']=1;
$dbname = CV_PLATFORM_DB_NAME;
$this->db->query("Use $dbname");
$this->db->insert("corn_job_queue", $manager_data);

 }

	public function releaseLetterToManager()
	{

		$rule_id 			= $this->input->post('hf_rule_id', TRUE);
		$template_id 		= $this->input->post('TempateID', TRUE);
		$manager_ids_str 	= $this->input->post('manager_ids', TRUE);
		$manager_ids_arr 	= $this->input->post('managers', TRUE);
		$manager_ids_list 	= array();

		$get_templatestatus=$this->admin_model->get_table_row("hr_parameter",'template_id,id',['id'=>$rule_id]);

		if($get_templatestatus['template_id']=='0')
		{
			$this->rule_model->update_rules(array('id'=>$rule_id),array("template_id" => $template_id, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => $this->current_data_time));
			//$templateid=$_POST['TempateID'];
		}
		/*else
		{
			$templateid=$get_templatestatus['template_id'];
		}*/

		$db_arr = array();
		$manager_ids = explode(',', $manager_ids_str);

		for ($i=0; $i < count($manager_ids); $i++)
		{
			$employee_list=$this->admin_model->get_table("employee_salary_details", 'id',['rule_id'=>$rule_id, 'status'=>5, 'letter_status'=>0, 'approver_1'=>$manager_ids[$i]]);

			foreach ($employee_list as $row)
			{
				$db_arr[] = array("id"=> $row["id"], "letter_status"=>1, "updatedby"=>$this->session->userdata('userid_ses'), "updatedon"=> $this->current_data_time, "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
			}
		}

		if($db_arr)
		{
			// update letter_status
			$this->db->update_batch('employee_salary_details', $db_arr, "id");
		}

		/*
		* Get manager ids from manager mails
		*/
		if(!empty($manager_ids)) {

			//manager_ids have managers email
			$this->load->model("user_model");
			$manager_ids_array = $this->user_model->get_users_details_from_emails( "id", $manager_ids);

			if(!empty($manager_ids_array)) {

				foreach($manager_ids_array as $key => $manager_val) {

					$manager_ids_list[$key] = $manager_val['id'];
				}
			}
		}

		//$data['managers']=$_POST['manager_ids'];
		//$manager_data['json_text']=serialize($data);
		//$manager_data['status']=1;

		$data['rule_id']			= $rule_id;
		$data['managers']			= $manager_ids_list;
		$manager_data['json_text']	= json_encode($data);
		$manager_data['compnay_id'] = $this->session->userdata('companyid_ses');
		$manager_data['mail_stage'] = NEW_SALARY_RULE_RELESED_MANAGER;
		$manager_data['status']		= 0;
		$manager_data['createdon']	= $this->current_data_time;

		$this->db->query("Use ". CV_PLATFORM_DB_NAME);

		//$is_req_exist = $this->db->select("q_id")->from("corn_job_queue")->where(array("compnay_id"=>$manager_data['compnay_id'], "mail_stage"=>$manager_data['mail_stage'], "status"=>$manager_data['status'], "json_text"=>$manager_data['json_text']))->get()->row_array();

		$condition_array = array("compnay_id" => $manager_data['compnay_id'],
								 "mail_stage" => $manager_data['mail_stage'],
								 "status" => $manager_data['status'],
								 "json_text"=> $manager_data['json_text']);

		$is_req_exist = $this->common_model->get_table("corn_job_queue", "q_id", $condition_array, "q_id");

		if(!$is_req_exist)
		{
			$this->admin_model->insert_data_in_tbl("corn_job_queue", $manager_data);
			//$this->db->insert("corn_job_queue", $manager_data);
		}

	}

	public function finalReleaseLetterToEmployee()
	{

		$rule_id 			= $this->input->post('hf_rule_id', TRUE);
		$template_id 		= $this->input->post('TempateID', TRUE);
		$employee_ids_str 	= $this->input->post('hf_manager_ids_for_emp_release', TRUE);
		$employee_ids_arr 	= $this->input->post('chk_manager_to_release_emps', TRUE);
		$employee_ids_list 	= array();
		//$rule_id = $_POST['hf_rule_id'];

		$get_templatestatus=$this->admin_model->get_table_row("hr_parameter",'template_id,id',['id'=>$rule_id]);

		if($get_templatestatus['template_id']=='0')
		{
			$this->rule_model->update_rules(array('id'=>$rule_id),array("template_id"=>$_POST['TempateID'], "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
			//$templateid=$_POST['TempateID'];
		}
		/*else
		{
			$templateid=$get_templatestatus['template_id'];
		}*/

		$db_arr = array();
		$employee_ids = explode(',',$employee_ids_str);

		for ($i=0; $i < count($employee_ids); $i++)
		{
			$employee_list	= $this->admin_model->get_table("employee_salary_details", 'id',['rule_id'=>$rule_id, 'status'=>5, 'letter_status <='=>1, 'approver_1'=>$employee_ids[$i]]);

			foreach ($employee_list as $row)
			{
				$db_arr[] = array("id"=>$row["id"], "letter_status"=>3, "updatedby"=>$this->session->userdata('userid_ses'), "updatedon"=>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
			}
		}

		if($db_arr)
		{
			// update letter_status
			$this->db->update_batch('employee_salary_details', $db_arr, "id");
		}

		//$data['TempateID']=$templateid;
		$data['rule_id']			= $rule_id;
		$data['managers']			= $employee_ids;//$_POST['hf_manager_ids_for_emp_release'];
		$manager_data['json_text']  = json_encode($data);//serialize($data);
		$manager_data['compnay_id'] = $this->session->userdata('companyid_ses');
		$manager_data['mail_stage'] = NEW_SALARY_RULE_RELESED_EMPLOYEE;
		$manager_data['status']		= 0;
		$manager_data['createdon']	= $this->current_data_time;

		$dbname = CV_PLATFORM_DB_NAME;
		$this->db->query("Use $dbname");

		//$is_req_exist = $this->db->select("q_id")->from("corn_job_queue")->where(array("compnay_id"=>$manager_data['compnay_id'], "mail_stage"=>$manager_data['mail_stage'], "status"=>$manager_data['status'], "json_text"=>$manager_data['json_text']))->get()->row_array();

		$condition_array = array("compnay_id" => $manager_data['compnay_id'],
								"mail_stage" => $manager_data['mail_stage'],
								"status" => $manager_data['status'],
								"json_text"=> $manager_data['json_text']
								);

		$is_req_exist = $this->common_model->get_table("corn_job_queue", "q_id", $condition_array, "q_id");

		if(!$is_req_exist)
		{
			$this->admin_model->insert_data_in_tbl("corn_job_queue", $manager_data);
			//$this->db->insert("corn_job_queue", $manager_data);
		}

	}

}
