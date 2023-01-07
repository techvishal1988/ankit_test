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
		$this->load->model("front_model");
		$this->load->model("admin_model");
		$this->load->model("common_model");
		$this->session->set_userdata(array('sub_session'=>$this->session->userdata('role_ses')));
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '')
		{			
			if($this->input->is_ajax_request())
			{
				echo "[".CV_HTTP_UNAUTHORIZED."]";die;	 
			}
			else
			{		
				redirect(site_url("login"));			
			}
		}  
		HLP_is_valid_web_token();                     
    }
	
	public function index()
	{		
		/*if(!helper_have_rights(CV_DASHBOARD_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', "<div align='left' style='color:red;' id='notify'><span><b>You don't have view rights.</b></span></div>");
			redirect(site_url("no-rights"));		
		}*/
		if($this->session->userdata('role_ses')==11)
                {
                    redirect(base_url('employee/dashboard'));
                }
                $data['msg'] = "";						
		$data['title'] = "Dashboard";
		$data["statics"] = $this->front_model->get_dashboard_statics();
		$data["notifications"] = $this->front_model->get_notifications(array("to_user_id"=>$this->session->userdata('userid_ses'), "is_readed"=>0));
                if(IsHR($this->session->userdata('role_ses')) && $this->session->userdata('manage_hr_only_ses')!=1)
                {
                    $data['body'] = "dashboard_hr";
                }
                else {
                    $data['body'] = "dashboard";
                }
							
		$this->load->view('common/structure',$data);
	}
        public function hr()
        {
            if($this->session->userdata('role_ses')==11)
                {
                    redirect(base_url('employee/dashboard'));
                }
		$data['msg'] = "";						
		$data['title'] = "Dashboard";
		$data["statics"] = $this->front_model->get_dashboard_statics();
		$data["notifications"] = $this->front_model->get_notifications(array("to_user_id"=>$this->session->userdata('userid_ses'), "is_readed"=>0));
		$data['body'] = "dashboard";					
		$this->load->view('common/structure',$data);
        }
        public function profile()
	{
		$data['msg'] = "";						
		$data['title'] = "Profile";
		$data['body'] = "profile";
		$this->load->view('common/structure',$data);		
	}

	public function templateDelete($id=''){
		//$flag =$this->db->where('id',$id)->update('email_templates',array('status'=>2));
		$flag =$this->db->where('id',$id)->delete('email_templates');

		if($flag){
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record Deleted</b></div>');
		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Operation Failed</b></div>');
		}

			redirect($_SERVER['HTTP_REFERER']);
	}
	public function emailTemplate($id='')
	{
		$data['template_list']=$this->common_model->getEmailTemplateList();
		$data['triggerPoints'] = $this->common_model->getTriggerPoints($id);	
		
		if($id != ''){
			$data['templates'] = $this->db->where('id',$id)->get('email_templates')->row();	
			$data['template_id']= $data['templates']->id;
			
		}else{
			$data['templates'] = array();
			$data['template_id']= '';
		}

		$data['msg'] = "";						
		$data['title'] = "Email Template";
		//$data['body'] = "Template";
		$data['body'] = "template";
		

		$this->load->view('common/structure',$data);		
	}


	
	public function mark_notification_readed()
	{	
		$this->front_model->update_notifications(array("to_user_id"=>$this->session->userdata('userid_ses'), "is_readed"=>0), array("is_readed"=>1));
//		echo 1;
	}

	public function no_rights()
	{
		$data['msg'] = "";
		if(!$this->session->flashdata('message'))
		{
			$data['msg'] = '<div style="margin-bottom:0px;" class="alert alert-danger"><strong> You do not have the rights.</strong></div>';
		}
		
		$data['title'] = "Don't have rights";
		$data['body'] = "rights_error";	
		$this->load->view('common/structure',$data);
	}
	
	public function set_proxy()
	{
		$prox_user_email = $this->input->post('txt_proxy_search');
		if($this->session->userdata('role_ses')==10)
        {
            $whr_cnd = "login_user.status = 1 AND login_user.role > ".$this->session->userdata('proxy_role_ses')." AND login_user.role <= 11 AND login_user.id != ".$this->session->userdata('userid_ses')." AND login_user.".CV_BA_NAME_EMP_EMAIL." = '".$prox_user_email."'  AND (login_user.".CV_BA_NAME_APPROVER_1." = '".$this->session->userdata('email_ses')."' OR login_user.".CV_BA_NAME_APPROVER_2." = '".$this->session->userdata('email_ses')."' OR login_user.".CV_BA_NAME_APPROVER_3." = '".$this->session->userdata('email_ses')."' OR login_user.".CV_BA_NAME_APPROVER_4." = '".$this->session->userdata('email_ses')."')";    
        }
        else if($this->session->userdata('role_ses') > 1 and $this->session->userdata('role_ses') < 10)
        {
			$whr_cnd = "login_user.status = 1 AND login_user.manage_hr_only = 0 AND login_user.".CV_BA_NAME_EMP_EMAIL." = '".$prox_user_email."'";			
			if($this->session->userdata('hr_usr_ids_ses'))
			{
				$hr_usr_ids_ses = $this->session->userdata('hr_usr_ids_ses');
				$this->db->simple_query('SET SESSION group_concat_max_len=9999999');
				$hr_emps_1st_approver_arr = $this->db->select("GROUP_CONCAT(CONCAT(id) SEPARATOR ',') AS usr_ids")->where("login_user.".CV_BA_NAME_EMP_EMAIL." IN (SELECT DISTINCT(lusr.".CV_BA_NAME_APPROVER_1.") FROM login_user lusr WHERE lusr.id IN (".$this->session->userdata('hr_usr_ids_ses')."))")->get("login_user")->row_array();
				if($hr_emps_1st_approver_arr["usr_ids"])
				{
					$hr_usr_ids_ses .=  ", ".$hr_emps_1st_approver_arr["usr_ids"];
				}			
				$whr_cnd .= " AND login_user.id IN (".$hr_usr_ids_ses.")";
			}
        }
        else
		{
			$whr_cnd = "login_user.status = 1 AND login_user.".CV_BA_NAME_EMP_EMAIL." = '".$prox_user_email."'";
        }
		
		$prox_users_dtls = $this->front_model->get_table_row("login_user","*", $whr_cnd);	
		if($prox_users_dtls=='')
		{
			 $msg='<div class="alert alert-warning alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error!</strong> Employee not found for proxy.
				  </div>';
		   $this->session->set_flashdata('msg', @$msg); 
		   redirect(site_url("dashboard")); 
		}
		if($prox_users_dtls)
		{
			$detail = array(
				'userid_ses'=>$prox_users_dtls['id'],
				'email_ses' => $prox_users_dtls['email'],
				'username_ses' => $prox_users_dtls['name'],
				'role_ses' => $prox_users_dtls['role'],
                                'is_manager_ses' => $prox_users_dtls['is_manager'],
                                'manage_hr_only_ses' => $prox_users_dtls['manage_hr_only'],
				);
			$this->session->set_userdata($detail);
			$this->common_model->set_permissions_session_arr();
		}
		if($this->session->userdata('role_ses') < 11)
		{
			redirect(site_url("dashboard"));
		}
		/*elseif($this->session->userdata('role_ses') == 2)
		{
			redirect(site_url("dashboard"));
		}
		elseif($this->session->userdata('role_ses') == 3)
		{
			redirect(site_url("dashboard"));
		}
		elseif($this->session->userdata('role_ses') == 4)
		{
			redirect(site_url("dashboard"));
		}*/
		else
		{
                  
			redirect(site_url("employee/dashboard"));
		}						
	}
	
	public function reset_proxy()
	{
		$prox_users_dtls = $this->front_model->get_table_row("login_user","*", array("status" => 1, "id" => $this->session->userdata('proxy_userid_ses')));	
		
		$detail = array(
			'userid_ses'=>$prox_users_dtls['id'],
			'email_ses' => $prox_users_dtls['email'],
			'username_ses' => $prox_users_dtls['name'],
			'role_ses' => $prox_users_dtls['role'],
                        'is_manager_ses' => $prox_users_dtls['is_manager'],
                         'manage_hr_only_ses' => $prox_users_dtls['manage_hr_only'],
			);
		$this->session->set_userdata($detail);
		$this->common_model->set_permissions_session_arr();
		
		if($this->session->userdata('role_ses') < 11)
		{
			redirect(site_url("dashboard"));
		}
		/*elseif($this->session->userdata('role_ses') == 2)
		{
			redirect(site_url("dashboard"));
		}
		elseif($this->session->userdata('role_ses') == 3)
		{
			redirect(site_url("dashboard"));
		}
		elseif($this->session->userdata('role_ses') == 4)
		{
			redirect(site_url("dashboard"));
		}*/
		else
		{
			redirect(site_url("employee/dashboard"));
		}						
	}
	
	public function get_users_for_proxy()
	{
          $is_need_update = 0;//1=Yes,0=No
          $user_id = $this->session->userdata('userid_ses');  
	  $term = $this->input->get('term', TRUE);
          /*if($this->session->userdata('role_ses')==3)
          {
                $country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
                $where ="login_user.role > 1 and login_user.status = 1";
               	if($country_arr_view)
			{
				$where .= " and login_user.country_id in (".$country_arr_view.")";
			}
			
			if($city_arr_view)
			{
				$where .= " and login_user.city_id in (".$city_arr_view.")";
			}

			if($bl1_arr_view)
			{
				$where .= " and login_user.business_level_1_id in (".$bl1_arr_view.")";
			}

			if($bl2_arr_view)
			{
				$where .= " and login_user.business_level_2_id in (".$bl2_arr_view.")";
			}

			if($bl3_arr_view)
			{
				$where .= " and login_user.business_level_3_id in (".$bl3_arr_view.")";
			}

			if($function_arr_view)
			{
				$where .= " and login_user.function_id in (".$function_arr_view.")";
			}

			if($sub_function_arr_view)
			{
				$where .= " and login_user.sub_function_id in (".$sub_function_arr_view.")";
			}

			if($sub_function_arr_view)
			{
				$where .= " and login_user.desig in (".$sub_function_arr_view.")";
			}

			if($grade_arr_view)
			{
				$where .= " and login_user.grade in (".$grade_arr_view.")";
			}

			
			$user_ids_arr = array();
			$data['employees'] = $this->common_model->get_users_for_proxy($term,$where);
                        //print_r($data['employees']);
          }
          else
          {*/
            $this->common_model->get_users_for_proxy($term,$condition_arr='');  
          //}
          
	}
        public function notifications()
        {
                $data['title'] = "Notifications";
		$data['body'] = "notifications";	
		$this->load->view('common/structure',$data);
                $this->mark_notification_readed();
        }
		
	public function propose_rnr_to_anyone()
	{		
		$this->load->model("performance_cycle_model");
		$data['msg'] = "";	
		$current_dt = date("Y-m-d");
		$data['rnr_rules'] = $this->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.award_type"=>4, "rnr_rules.status !="=>8));
		
		if($this->input->post())
		{
			$rule_id = $this->input->post("ddl_rnr");
			$rule_dtls = $this->front_model->get_table_row("rnr_rules","criteria, award_type, is_approval_required, award_value, award_frequency, emp_frequency_for_award, budget_type, budget_dtls, (select sum(rnr_rules.award_value) from proposed_rnr_dtls join rnr_rules on rnr_rules.id = proposed_rnr_dtls.rule_id where proposed_rnr_dtls.rule_id = '".$rule_id."' and proposed_rnr_dtls.status < 3 ) as total_proposed_award_val", array("rnr_rules.id"=>$rule_id, "status"=>6, "rnr_rules.award_type"=>4), "rule_name asc");
			if($rule_dtls)
			{				
				$users_dtls = $this->front_model->get_table_row("login_user","*", array("status" => 1, "email" => $this->input->post("txt_emp_email")));	
                if($users_dtls)
                {   
					$last_award_dtls_of_emp = $this->front_model->get_table_row("proposed_rnr_dtls","createdon", array("rule_id"=>$rule_id, "user_id"=>$users_dtls["id"], "status <"=>3), "id desc");
					
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
							redirect(site_url("propose-for-recognized-rnr"));
						}
					}
										
					$db_arr["rule_id"] = $rule_id;
					$db_arr["user_id"] = $users_dtls["id"];
					$db_arr["status"] = 2;
					$db_arr["createdby"] = $this->session->userdata('userid_ses');
					$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
					$db_arr["createdon"] = date("Y-m-d H:i:s");	
					if($rule_dtls["is_approval_required"]==2)
					{
						$db_arr["status"] = 1;//Note :: It means no need approval.
						$db_arr["updatedon"] = date("Y-m-d H:i:s");	
					}			
					$this->admin_model->insert_data_in_tbl("proposed_rnr_dtls", $db_arr);	
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Award has been proposed successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid user. Please select a valid user.</b></div>');
				}
				
			}
			redirect(site_url("propose-for-recognized-rnr"));
		}
		
		$data['title'] = "Propose For R and R";
		$data['body'] = "propose_rnr_to_anyone";
		$this->load->view('common/structure',$data);
	}
	
	public function get_rnr_rule_dtls_to_anyone($rule_id)
	{
		$rule_dtls = $this->front_model->get_table_row("rnr_rules","criteria, award_type, award_value, award_frequency, emp_frequency_for_award, budget_type, budget_dtls, (select sum(rnr_rules.award_value) from proposed_rnr_dtls join rnr_rules on rnr_rules.id = proposed_rnr_dtls.rule_id where proposed_rnr_dtls.rule_id = '".$rule_id."' and proposed_rnr_dtls.status < 3 ) as total_proposed_award_val", array("rnr_rules.id"=>$rule_id, "rnr_rules.award_type"=>4), "rule_name asc");
		if($rule_dtls)
		{
			$response =array("status"=>true,"msg"=>"Ok", "rule_dtls"=>$rule_dtls);
		}
		else
		{
			$response =array("status"=>false,"msg"=>"Not Ok", "rule_dtls"=>"");
		}
		
		echo json_encode($response); die;
	}
	
	public function get_users_for_rnr()
	{
		$user_id = $this->session->userdata('userid_ses');  
		$term = $this->input->get('term', TRUE);
		$where ="login_user.role > 1 and login_user.status = 1 and login_user.id != ".$user_id;
		$data['employees'] = $this->common_model->get_users_for_proxy($term,$where);
	}
	
	public function change_password()
	{       
        $data['msg'] = '';
		$user_id = $this->session->userdata('userid_ses');
		
		if($user_id != $this->session->userdata('proxy_userid_ses'))
		{
			redirect(site_url("dashboard"));
		}
		
        if($_POST)
		{
            $this->form_validation->set_rules('old_password', 'old password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~#%*?&])[A-Za-z\d$@$!~#%*?&]{8,}/]|matches[confirm_password]', array('regex_match' => 'New password must contain at least 8 characters including <br> one uppercase letter, one lowercase letter, one number and one special character.'));
			//$this->form_validation->set_rules('new_password', 'New password must contain at least 8 characters including <br\> one uppercase letter, one lowercase letter, one number and one special character.', 'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/]', array('regex_match' => '%s'));
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required');

            if($this->form_validation->run())
			{
                $old_pass = md5($this->input->post("old_password"));
                $new_pass = md5($this->input->post("new_password"));
				$flag = $this->front_model->change_password(array("id"=>$user_id, "status"=>"1", "pass"=>$old_pass), array("pass"=>$new_pass, "updatedby" => $user_id, "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")));
				
				if ($flag)
				{
				  $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Password updated successfully.</b></div>');
				}
				else
				{
				  $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Old password is incorrect.</b></div>');
				}
				
                redirect("change-password");
            }
        }
        $data['title'] = "Change Password";
        $data['body'] = "change_password";
		$this->load->view('common/structure',$data);
    }

	public function get_crsf_field()
	{
		echo $this->security->get_csrf_hash();//HLP_get_crsf_field();
	}

}
