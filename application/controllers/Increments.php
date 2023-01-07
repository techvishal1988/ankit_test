<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Increments extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');

		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');
		$this->load->model("rule_model");
		$this->load->model("bonus_model");
		$this->load->model("sip_model");
		$this->load->model("common_model");
		$this->load->model("lti_rule_model");
		$this->load->model("manager_model");

		$this->lang->load('message', 'english');
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->check_uri() == false)
		{
			redirect(site_url("dashboard"));
		}
		HLP_is_valid_web_token();
	}

	public function check_uri()
	{
		if($this->session->userdata('role_ses') > 9)
		{
			$method = $this->router->fetch_method();
			if ($method == 'get_peer_employee_salary_dtls_for_graph' or $method == 'get_emp_market_data_graph_for_multiple_benchmark' or $method == 'get_emp_team_data_for_graph' or $method == 'get_emp_salary_movement_data_graph' or $method == 'update_emp_additional_field_dtls' or $method == 'update_emp_promotion_basis_on' or $method == 'get_promotion_suggestion_dtls'  or $method == 'ins_upd_salary_promotion_comment')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}

//************************************ Functionality Start For Salary Rules ****************************

	public function view_increments($rule_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$data['msg'] = "";
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data["rule_dtls"]  or $data["rule_dtls"]["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$this->load->model('performance_cycle_model');
		$data['salary_rule_list'] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.id"=>$rule_id));
		
		$data['is_open_frm_hr_side'] = 1;
		$data['urls_arr'] = array(
							"emp_increments_list_url"=>"increments/get_emp_increment_list_for_manager_frm_hr_ajax",
							"modify_increment_url"=>"increments/update_manager_discretions_by_hr",
							"modify_rating_url"=>"increments/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"hr/update-promotions",
							"delete_promotion_url"=>"increments/delete_emp_promotions_dtls",
							"increment_file_format_d_url"=>"increments/get_hr_emps_file_to_upload_increments",
							"increment_file_upload_url"=>"increments/bulk_upload_hr_emps_increments"
							);
							
		$this->method_call =& get_instance(); 
		//Piy@25feb filter 
		$master_fields=['function','subfunction','sub_subfunction','designation',
		'grade','level','special_category','education','country','business_level_1',
		'business_level_2','business_level_3','employee_role',
		'critical_position','employee_type','critical_talent',
						'country','city','readyness_level','successor_identified'/*,'name','manager_name'*/];
		$cols=[];
		foreach ($master_fields as $fldName) {
			$cols[]="GROUP_CONCAT(DISTINCT {$fldName}) as $fldName ";
		}

		$result=$this->rule_model->get_table_row("salary_rule_users_dtls",implode(",",$cols),"rule_id={$rule_id}","rule_id");
		foreach ($result as $fldName => $value) {
			$data["{$fldName}_list"]=explode(",",$value);
		}
		
		$data['title'] = "View Increment";
		$data['body'] = "salary/salary_rule_list_hr_manager_landing";
		$this->load->view('common/structure',$data);  
	}	
	
	public function get_managers_list_for_salary_rule_ajax($rule_id, $newId, $is_need_data_only=0)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$whr_cnd = "employee_salary_details.rule_id = ".$rule_id;
		if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
		{
			if(!$this->session->userdata('hr_usr_ids_ses'))
			{
				redirect(site_url("performance-cycle"));
			}
			$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		$data["managers_downline_arr"] = $this->rule_model->allManager($whr_cnd);
		
		$all_managers_in_a_rule_arr = array();
		$managers_arr = json_decode($data["rule_dtls"]['manual_budget_dtls'], true);
		foreach($managers_arr as $key => $value)
		{
			$all_managers_in_a_rule_arr[] = strtolower($value[0]);
		}
		
		$data['all_managers_in_a_rule_arr'] = $all_managers_in_a_rule_arr;
		$data['newId'] = $newId;
		$data["is_open_frm_hr_side"] = 1;
		$data["is_enable_approve_btn"] = 0;
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

	public function view_increments_ravij($rule_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$data['msg'] = "";
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data["rule_dtls"]  or $data["rule_dtls"]["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$this->load->model('performance_cycle_model');
		$data['salary_rule_list'] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.id"=>$rule_id));
		
		$data['is_open_frm_hr_side'] = 1;
		$data['urls_arr'] = array(
							"emp_increments_list_url"=>"increments/get_emp_increment_list_for_manager_frm_hr_ajax",
							"modify_increment_url"=>"increments/update_manager_discretions_by_hr",
							"modify_rating_url"=>"increments/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"hr/update-promotions",
							"delete_promotion_url"=>"increments/delete_emp_promotions_dtls",
							"increment_file_format_d_url"=>"increments/get_hr_emps_file_to_upload_increments",
							"increment_file_upload_url"=>"increments/bulk_upload_hr_emps_increments"
							);
							
		$this->method_call =& get_instance(); 
		//Piy@25feb filter 
		$master_fields=['function','subfunction','sub_subfunction','designation',
		'grade','level','special_category','education','country','business_level_1',
		'business_level_2','business_level_3','employee_role',
		'critical_position','employee_type','critical_talent',
						'country','city','readyness_level','successor_identified'/*,'name','manager_name'*/];
		$cols=[];
		foreach ($master_fields as $fldName) {
			$cols[]="GROUP_CONCAT(DISTINCT {$fldName}) as $fldName ";
		}

		$result=$this->rule_model->get_table_row("salary_rule_users_dtls",implode(",",$cols),"rule_id={$rule_id}","rule_id");
		foreach ($result as $fldName => $value) {
			$data["{$fldName}_list"]=explode(",",$value);
		}
		
		$data['title'] = "View Increment";
		$data['body'] = "salary/salary_rule_list_hr_manager_landing_ravij";
		$this->load->view('common/structure',$data);  
	}	
	
	public function get_managers_list_for_salary_rule_ajax_ravij($rule_id, $newId, $is_need_data_only=0)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		
		$whr_cnd = "employee_salary_details.rule_id = ".$rule_id;
		if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
		{
			if(!$this->session->userdata('hr_usr_ids_ses'))
			{
				redirect(site_url("performance-cycle"));
			}
			$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		
		$data["managers_downline_arr"] = $this->rule_model->get_all_approver1_bdgt_dtls_for_increment_list_hr($rule_id, $data["rule_dtls"]["include_promotion_budget"], $whr_cnd);
		
		if($data["rule_dtls"]["budget_accumulation"]==1)
		{
					
			$data["managers_accumulated_arr"] = $this->rule_model->get_all_approver1_accumulated_bdgt_dtls_for_increment_list_hr($rule_id, $data["rule_dtls"]["include_promotion_budget"], $whr_cnd);
		}
		//echo "<pre>";print_r($data["managers_accumulated_arr"]);die;		
		
		$data["is_open_frm_hr_side"] = 1;
		$data["is_enable_approve_btn"] = 0;
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
	
	
	public function view_increments_search_ajax($rule_id,$start=0)
	{	
		$search_cnd_arr=[];
		$search_cnd_arr[] ="srud.rule_id={$rule_id}";

		$filters = [
			'level' => CV_BA_NAME_LEVEL,
			'education' => CV_BA_NAME_EDUCATION,		
			'special_category' => CV_BA_NAME_SPECIAL_CATEGORY,				
			'function' => CV_BA_NAME_FUNCTION,
			'sub_function' => 'subfunction',
			'sub_subfunction' => 'sub_subfunction',//CV_BA_NAME_SUB_SUBFUNCTION,
			'designation' => CV_BA_NAME_DESIGNATION,
			'grade' => CV_BA_NAME_GRADE,


			'critical_talent' => CV_BA_NAME_CRITICAL_TALENT,
			'critical_position' => CV_BA_NAME_CRITICAL_POSITION,		
			'manager_name' => CV_BA_NAME_MANAGER_NAME,				
			'employee_type' => CV_BA_NAME_EMPLOYEE_TYPE,
			'employee_role' => CV_BA_NAME_EMPLOYEE_ROLE,
			'country' => CV_BA_NAME_COUNTRY,		
			'city' => CV_BA_NAME_CITY,		

			'business_level_1' => CV_BA_NAME_BUSINESS_LEVEL_1,
			'business_level_2' => CV_BA_NAME_BUSINESS_LEVEL_2,
			'business_level_3' => CV_BA_NAME_BUSINESS_LEVEL_3,
			'name' => CV_BA_NAME_EMP_FULL_NAME,
		];

		foreach ($filters as $key => $fldname) {
			$filter = $this->input->post($key);
			if (in_array($key, ['name', 'manager_name'])) {
				$filter = explode(",", $filter[0]);
			}
			if (!empty($filter)) {
				unset($filter['all']);
				$in = implode("','", $filter);
				if ($in && !empty($in)) 	$search_cnd_arr[] = " srud.`{$fldname}` IN ('" . $in . "') ";
			}
		}

		echo $this->get_emp_increment_list_for_manager_frm_hr_ajax($rule_id,'','', 0,$search_cnd_arr,$start);	
	}
	public function view_increments_search_field_data_ajax($rule_id,$fldName)
	{	
			@$query=$_GET['query'];
			header('Content-Type: application/json');
			echo  $this->rule_model->get_users_name($rule_id,$fldName,$query);
			exit();
	}
	public function get_emp_increment_list_for_manager_frm_hr_ajax($rule_id,$email,$newId, $emp_sal_dtl_tbl_id=0,$search_cnd_arr=[],$start='')
	{	//Piy@31Jan
		$limit='';
		if(count($search_cnd_arr))
		{   $limit=250; 		
			$whr_cnd= implode(" and ",$search_cnd_arr);
			 //pagination settings
			 $config['base_url'] = site_url("increments/view_increments/{$rule_id}");
			 $config['total_rows'] =$this->rule_model->get_table_row("salary_rule_users_dtls srud","count(rule_id) as cnt",$whr_cnd,"rule_id")['cnt'];
			 $config['per_page'] = $limit;
			 $config['uri_segment'] = 4;
			 $choice = $config['total_rows'] / $config['per_page'];
			// $config['num_links'] = floor($choice);
		
			 //config for bootstrap pagination class integration
			 $config['full_tag_open'] = '<ul class="pagination">';
			 $config['full_tag_close'] = '</ul>';
			 $config['first_link'] = 'First';
			 $config['last_link'] ='Last';
			 $config['first_tag_open'] = '<li>';
			 $config['first_tag_close'] = '</li>';
			 $config['prev_link'] = 'Previous';
			 $config['prev_tag_open'] = '<li class="prev">';
			 $config['prev_tag_close'] = '</li>';
			 $config['next_link'] = 'Next';
			 $config['next_tag_open'] = '<li>';
			 $config['next_tag_close'] = '</li>';
			 $config['last_tag_open'] = '<li>';
			 $config['last_tag_close'] = '</li>';
			 $config['cur_tag_open'] = '<li class="active"><a href="#">';
			 $config['cur_tag_close'] = '</a></li>';
			 $config['num_tag_open'] = '<li>';
			 $config['num_tag_close'] = '</li>';
	
			 $this->load->library('pagination');
			 $this->pagination->initialize($config);	 
			 $data['page'] = ($start)?$start:0;//($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	 
			 // fetch employees list
			// $data['results'] =$this->rule_model->get_table("employee_salary_details","count(rule_id) as cnt,rule_id","rule_id={$rule_id}","rule_id");// [['d','d'],['d','d']];//$this->AjaxPaginationModel->getEmployees($config['per_page'], $data['page']);       
			 // create pagination links
	 
			if($this->input->post('ajax')) {
				$data['links'] = str_replace("{$config['base_url']}/","",str_replace("href","href='#' page_id", $this->pagination->create_links()));
			 }
		}
		$data['paging']=(count($search_cnd_arr))?1:0;

		$cdt = date("Y-m-d");
		$data['newId']=$newId;
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}

		if($emp_sal_dtl_tbl_id)
		{
			$whr_cnd = "employee_salary_details.id = ".$emp_sal_dtl_tbl_id;
		}
		else
		{
			if(count($search_cnd_arr))
			{ 
				$whr_cnd= implode(" and ",$search_cnd_arr);
			}else
			{
				$whr_cnd= "employee_salary_details.rule_id = ".$rule_id." AND employee_salary_details.approver_1 = '".base64_decode($email)."'";
			}
			
			if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
			{
				$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
			}
		}
		$data['staff_list'] = $this->rule_model->get_rule_wise_emp_increment_list_for_hr_manager($whr_cnd,$limit,$start);
		$data['performance_rating_list']=$this->common_model->get_table("manage_rating_for_current_year", "*", array('status'=>'1'), "order_no ASC");
		
		$data["view_emp_increments_dtls_path"] = "view-employee-increments";
		$data["is_open_frm_hr_side"] = 1;
		$data['is_hr_can_edit_hikes'] = 0;
		if($data['rule_dtls']["status"] == 6 or $data['rule_dtls']["status"] == 7)
		{
			if(helper_have_rights(CV_INCREMENTS_ID, CV_INSERT_RIGHT_NAME) == true and $this->session->userdata('role_ses') != CV_ROLE_BUSINESS_UNIT_HEAD)
			{
				$data['is_hr_can_edit_hikes'] = 1;
			}
		}
		
		if($data["rule_dtls"]['promotion_basis_on']==2)
		{
			$data['promotion_basic_list']=$this->common_model->get_table("manage_grade", "id, name", "status=1", "order_no ASC");
			$data['list_of_new_designation']=$this->common_model->get_table("manage_designation", "id, name", "status=1", "order_no ASC");
			$data['list_of_new_level']=$this->common_model->get_table("manage_level", "id, name", "status=1", "order_no ASC");
			
			$data['level_name'] = "Grade";
			$str="'new_designation','new_level'";
		}
		else if($data["rule_dtls"]['promotion_basis_on']==3)
		{
			$data['promotion_basic_list']=$this->common_model->get_table("manage_level", "id, name", "status=1", "order_no ASC");
			$data['list_of_new_designation']=$this->common_model->get_table("manage_designation", "id, name", "status=1", "order_no ASC");
			$data['list_of_new_grade']=$this->common_model->get_table("manage_grade", "id, name", "status=1", "order_no ASC");
			
			$data['level_name'] = "Level";
			$str="'new_grade','new_designation'";
		}
		else if($data["rule_dtls"]['promotion_basis_on']==1)
		{
			$data['promotion_basic_list']=$this->common_model->get_table("manage_designation", "id, name", "status=1", "order_no ASC");			
			$data['list_of_new_grade']=$this->common_model->get_table("manage_grade", "id, name", "status=1", "order_no ASC");
			$data['list_of_new_level']=$this->common_model->get_table("manage_level", "id, name", "status=1", "order_no ASC");
			
			$data['level_name'] = "Designation";
			$str="'new_grade','new_level'";
		}
		
		//$cond="where module_name='hr_screen' AND attribute_name NOT IN (".$str.") AND status=1 order by col_attributes_order ASC";
		
		if($data["rule_dtls"]['promotion_basis_on'] == 0)
		{
			$cond = "WHERE module_name='hr_screen' AND status=1 AND attribute_name NOT IN (".CV_PROMOTION_RELATED_COLUMNS_ARRAY.") ORDER BY col_attributes_order ASC";
		}
		else
		{
			$cond = "WHERE module_name='hr_screen' AND status=1 ORDER BY col_attributes_order ASC";
		}		
		$data['table_atrributes']=$this->common_model->getTableAttributes($cond);
		
		$data['currency_rate_dtls'] = $this->rule_model->get_currency_rate_dtls();
		
		if($emp_sal_dtl_tbl_id)
		{
			return $this->load->view('salary/ajax_emp_row_for_salary', $data, true);
		}
		else
		{
			$this->load->view('salary/ajax_emp_list_new',$data);
		}
	}

	public function upd_emp_performance_rating_for_salary($rule_id, $user_id, $rating_id)
	{
		$salary_elem_ba_list = $this->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$emp_current_sal_dtls =$this->rule_model->get_table_row("employee_salary_details","id, user_id, increment_applied_on_salary, proreta_multiplier, final_salary, sp_manager_discretions,promotion_comment, status", array("rule_id"=>$rule_id, "user_id"=>$user_id));
		$new_rating_dtls =$this->rule_model->get_table_row("manage_rating_for_current_year","id, name", array("id"=>$rating_id, "status"=>1));

		$response = HLP_update_users_performance_rating_for_salary_rule($rule_dtls, $emp_current_sal_dtls, $new_rating_dtls, $salary_elem_ba_list, 2);
		if($response["status"])
		{
			$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($rule_id, $emp_current_sal_dtls["id"]);
			$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
		}
		echo json_encode($response); die;
	}

	public function view_employee_increment_dtls($rule_id, $user_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		if(HLP_requested_is_valid($user_id)==false)
		{
			redirect(site_url("performance-cycle"));
		}

		$cdt = date("Y-m-d");
		//$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.createdby"=>$this->session->userdata('userid_ses'), "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		//$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		//$data['staff_list'] = $this->rule_model->get_rule_wise_emp_list_for_increments($rule_id);

		$whr_cnd = "";
		if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
		{
			$whr_cnd = "employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		$data['staff_list'] = $this->rule_model->get_rule_wise_emp_list_for_increments($rule_id, $whr_cnd);

		/*$current_usr_index = array_search($user_id, array_column($data['staff_list'], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("performance-cycle"));
		}*/
		//$upload_id = $data['staff_list'][$current_usr_index]["upload_id"];

		//$data['user_salary_graph_dtls']=$this->rule_model->get_employee_salary_dtls_for_graph($user_id);
		$data['salary_dtls'] 	= $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));

		$data['grade_list']=$this->common_model->get_table("manage_grade", "id, name", "", "order_no asc");
//$data['role_list']=$this->common_model->get_table("roles", "id, name", "", "id asc");
$data['performance_rating_list']=$this->common_model->get_table("manage_rating_for_current_year", "*", array('status'=>'1'), "order_no ASC");

$data['designation_list']=$this->common_model->get_table("manage_designation", "id, name", "", "order_no asc");

$data['level_list']=$this->common_model->get_table("manage_level", "id, name", "", "order_no asc");

		$data['company_dtls'] = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		//$data['is_hr_valid'] = $this->rule_model->check_hr_permission_on_salary_dtls($rule_id);

		$data['is_hr_can_edit_hikes'] = 0;
		if($data['rule_dtls']["status"] == 6 or $data['rule_dtls']["status"] == 7)
		{

			// $emps_in_rule_dtls = $this->rule_model->get_table_row("employee_salary_details", "COUNT(*) AS total_emp_in_rule, (SELECT COUNT(*) FROM employee_salary_details WHERE employee_salary_details.status = 5 AND employee_salary_details.rule_id = ".$rule_id.") AS total_appoved_emp_in_rule", array("rule_id"=>$rule_id));


			// if($emps_in_rule_dtls["total_emp_in_rule"] == $emps_in_rule_dtls["total_appoved_emp_in_rule"] and ($this->session->userdata('role_ses') == 1 or $data['rule_dtls']["createdby"] == $this->session->userdata("userid_ses")))
			// {
			//$data['is_hr_can_edit_hikes'] = 1;
			if(helper_have_rights(CV_INCREMENTS_ID, CV_INSERT_RIGHT_NAME) == true and $this->session->userdata('role_ses') != CV_ROLE_BUSINESS_UNIT_HEAD)
			{
				$data['is_hr_can_edit_hikes'] = 1;
			}
			//}
		}

		$data['emp_bonus_dtls'] = "";
		if($data['rule_dtls']['linked_bonus_rule_id'])
		{
			$data['emp_bonus_dtls'] = $this->rule_model->get_table_row("employee_bonus_details", "target_bonus, final_bonus, final_bonus_per", array("rule_id"=>$data['rule_dtls']['linked_bonus_rule_id'], "user_id"=>$user_id));
		}

		$data['is_open_frm_hr_side'] = 1;
		$data['urls_arr'] = array(
							"main_increments_list_url"=>"view-increments",
							"emp_increment_dtls_pg_url"=>"view-employee-increments",
							"modify_increment_url"=>"increments/update_manager_discretions_by_hr",							
							"modify_rating_url"=>"increments/upd_emp_performance_rating_for_salary",
							"modify_promotion_url"=>"hr/update-promotions",
							"delete_promotion_url"=>"increments/delete_emp_promotions_dtls"
							);

		//Set business attribute name for title
		$table_atrributes_cond 	= "WHERE module_name='hr_screen' AND status=1 AND attribute_name IN ('increment_applied_on_salary', 'current_position_pay_range', 'current_target_bonus', 'final_salary', 'revised_variable_salary','new_positioning_in_pay_range', 'merit_increase_amount', 'market_correction_amount', 'sp_increased_salary') ORDER BY col_attributes_order ASC";
		$table_atrributes		= $this->common_model->getTableAttributes($table_atrributes_cond);

		$data['table_atrribute_name_array'] = array();

		if(!empty($table_atrributes)) {

			foreach($table_atrributes as $key => $table_atrribute_value) {

				$data['table_atrribute_name_array'][$table_atrribute_value->attribute_name] = $table_atrribute_value->display_name; 

			}
		}//echo "<pre>";print_r($data['table_atrribute_name_array']);die;
		//End business attribute name for title

		$data['graph_for_show']='Designation';
		$data['title'] = "Increments Report";
		$data['body'] = "salary/empl_sal_dtl_new";
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

		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$emp_salary_dtls["rule_id"]));

		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph_new($emp_salary_dtls["rule_id"], $emp_salary_dtls["user_id"], $peer_type, $order_by);

		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$emp_salary_dtls["rule_id"], "employee_salary_details.user_id"=>$emp_salary_dtls["user_id"]));

		/*if($peer_type=='grade')
		{
			$peer_type='Designation';
		}
		else {
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
//************************************ Functionality End For Salary Rules ****************************


//************************************ Functionality Start For Bonus Rules ****************************
	public function view_bonus_increments($rule_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.createdby"=>$this->session->userdata('userid_ses'), "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		$data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['title'] = "Increments List";
		$data['body'] = "view_bonus_increment_index";
		$this->load->view('common/structure',$data);
	}

	public function view_employee_bonus_increment_dtls($rule_id, $user_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		if(HLP_requested_is_valid($user_id)==false)
		{
			redirect(site_url("performance-cycle"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id, "hr_parameter_bonus.createdby"=>$this->session->userdata('userid_ses'), "hr_parameter_bonus.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
				
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
		
		if(!$data['bonus_dtls'])
		{
			redirect(site_url("view-bonus-increments/".$rule_id));
		}
		
		$data['is_hr_can_edit_bonus'] = 0;
		if($data['rule_dtls']["status"] == 6 or $data['rule_dtls']["status"] == 7)
		{
			if(helper_have_rights(CV_INCREMENTS_ID, CV_INSERT_RIGHT_NAME))
			{
				$data['is_hr_can_edit_bonus'] = 1;
				
				if($this->input->post("txt_target_bonus_amt") and $this->input->post("txt_target_bonus_amt") > 0)
				{
					$emp_bonus_dtls = $data['bonus_dtls'];
					
					if(!empty($emp_bonus_dtls))
					{
						$increased_bonus = $this->input->post("txt_target_bonus_amt");
						$new_per=($this->input->post("txt_target_bonus_amt")/$emp_bonus_dtls["target_bonus"])*100;
						
						$this->manager_model->update_tbl_data("employee_bonus_details", array("final_bonus"=>$increased_bonus, "final_bonus_per"=>$new_per,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_bonus_dtls["id"]));
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data successfully updated.</b></div>');
						redirect(site_url("view-employee-bonus-increments/".$rule_id."/".$user_id));
					}
				}				
			}
		}

		$data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
		
		$data['title'] = "Increments Report";
		$data['body'] = "manager/view_emp_bonus_dtl";
		$this->load->view('common/structure',$data);
	}
//************************************ Functionality End For Bonus Rules ****************************

//************************************ Functionality Start For Sip Rules ****************************
	public function view_sip_increments($rule_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id, "sip_hr_parameter.createdby"=>$this->session->userdata('userid_ses'), "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}
		$data['staff_list'] = $this->sip_model->get_rule_wise_emp_list_for_sip(array("sip_employee_details.rule_id"=>$rule_id));
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['title'] = "SIP Employees Wise List";
		$data['body'] = "sip/view_sip_increment_index";
		$this->load->view('common/structure',$data);
	}

	public function view_employee_sip_dtls($rule_id, $user_id)
	{
		if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view inrements rights.</b></div>');
			redirect(site_url("no-rights"));
		}

		if(HLP_requested_is_valid($user_id)==false)
		{
			redirect(site_url("performance-cycle"));
		}

		$cdt = date("Y-m-d");
		$data["rule_dtls"] = $this->sip_model->get_sip_rule_dtls(array("sip_hr_parameter.id"=>$rule_id, "sip_hr_parameter.createdby"=>$this->session->userdata('userid_ses'), "sip_hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}

		$data['staff_list'] = $this->sip_model->get_rule_wise_emp_list_for_sip(array("sip_employee_details.rule_id"=>$rule_id));
		$data['sip_dtls'] = $this->sip_model->get_employee_sip_dtls(array("sip_employee_details.rule_id"=>$rule_id, "sip_employee_details.user_id"=>$user_id));

		$data['title'] = "Increments Report";
		$data['body'] = "sip/view_emp_sip_dtl";
		$this->load->view('common/structure',$data);
	}
//************************************ Functionality End For Sip Rules ****************************

//************************************ Functionality Start For LTI Rules ****************************
	public function view_lti_incentive_list($rule_id)
	{
		/*if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You do not have view inrements rights.</b></span></div>');
			redirect(site_url("no-rights"));
		}*/

		$cdt = date("Y-m-d");
		//$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.createdby"=>$this->session->userdata('userid_ses'), "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		$rule_dtls = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id, "lti_rules.createdby"=>$this->session->userdata('userid_ses'), "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		if(!$rule_dtls  or $rule_dtls["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}

		$data['rule_dtls']=$rule_dtls;
		$data['staff_list'] = $this->lti_rule_model->get_rule_wise_emp_list_for_incentives($rule_id);
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data['rule_id'] = $rule_id;
		$data['title'] = "Incentives List";
		$data['body'] = "view_lti_incentive_list";
		$this->load->view('common/structure',$data);
	}

	public function view_emp_lti_dtls($rule_id, $user_id)
	{
		/*if(!helper_have_rights(CV_INCREMENTS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You do not have view inrements rights.</b></span></div>');
			redirect(site_url("no-rights"));
		}*/

		if(HLP_requested_is_valid($user_id)==false)
		{
			redirect(site_url("performance-cycle"));
		}

		$cdt = date("Y-m-d");
		//$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "lti_rules.id"=>$rule_id, "lti_rules.createdby"=>$this->session->userdata('userid_ses'), "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id, "lti_rules.createdby"=>$this->session->userdata('userid_ses'), "lti_rules.status !="=>CV_STATUS_RULE_DELETED));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			redirect(site_url("performance-cycle"));
		}

		$data['staff_list'] = $this->lti_rule_model->get_rule_wise_emp_list_for_incentives($rule_id);
		$current_usr_index = array_search($user_id, array_column($data['staff_list'], 'id'));
		if($current_usr_index === FALSE)
		{
			redirect(site_url("performance-cycle"));
		}
		$upload_id = $data['staff_list'][$current_usr_index]["upload_id"];

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

		$data['title'] = "Employee LTI Details";
		//$data['body'] = "view_emp_lti_dtls";
		$data['body'] = "manager/view_emp_lti_dtls";
		$this->load->view('common/structure',$data);
	}
//************************************ Functionality End For LTI Rules ****************************



	// public function exportemplist($rule_id)
	// {
	// 	$staff_list = $this->rule_model->get_rule_wise_emp_list_for_increments($rule_id);
	// 	$staff_list=GetEmpAllDataFromEmpId($staff_list);
	// 	downloadcsv($staff_list);
	// }

	public function exportemplist($rule_id)
	{
		$whr_cnd = "employee_salary_details.rule_id = ".$rule_id;
		if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
		{
			$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		$staff_list = $this->rule_model->get_rule_wise_emp_list_for_increment($whr_cnd);
		$staff_list=GetEmpAllDataFromEmpId_ruleList($staff_list,$rule_id);
		downloadcsv($staff_list);
	}
	public function exportemplistbonus($rule_id)
	{
		$staff_list = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
		$staff_list=GetEmpAllDataFromEmpId($staff_list);
		downloadcsv($staff_list);
	}

	public function exportemplistsip($rule_id)
	{
		$staff_list = $this->sip_model->get_emp_sip_dtls_to_export(array("sed.rule_id"=>$rule_id));
		downloadcsv($staff_list);
	}

	public function exportemplistlti($rule_id)
	{
		$staff_list = $this->lti_rule_model->get_rule_wise_emp_list_for_incentives($rule_id);
		$staff_list=GetEmpAllDataFromEmpId($staff_list);
		downloadcsv($staff_list);
	}


	///updatesalary rule by hr @rajesh

	public function update_manager_discretions_by_hr()
	{
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

			// $salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "hr_parameter.status"=>6, "employee_salary_details.status"=>5));
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "employee_salary_details.letter_status !="=>CV_RELEASED_LETTER_STATUS, "hr_parameter.status >="=>6, "hr_parameter.status <="=>7));

			if($salary_dtls)
			{


				$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;

				//$promotion_increased_salary = $salary_dtls["increment_applied_on_salary"]*$promotion_per/100;

				//$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + $increased_salary + $salary_dtls["sp_increased_salary"];
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
				
				

				//$salary_comment_arr =$this->manager_model->get_table_row("employee_salary_details","salary_comment", array("id"=>$id));

							$temp="";
							$salaryComment=[];
							// if($new_per>0)
							// {
							// 	// $salary_comment=" HR BP : ".HLP_get_formated_percentage_common($new_per)."%";

							// 	$salaryComment[]=array(
							// 		'email'=>strtolower($this->session->userdata('email_ses'))
							// 		,"name"=>$this->session->userdata('username_ses')
							// 		,"increment_per"=>HLP_get_formated_percentage_common($new_per)
							// 		,"permotion_per"=>HLP_get_formated_percentage_common($salary_dtls['standard_promotion_increase'])
							// 		,"changed_by"=>'HR'
							// 		,"role"=>"HR"
							// 		,"rating"=>$salary_dtls['performance_rating']
							// 		,"final_salary"=>$final_salary_increased_salary
							// 		,"final_increment_amount"=>$final_salary_increased_salary-$salary_dtls["increment_applied_on_salary"]
							// 		,"final_increment_per"=>HLP_get_formated_percentage_common($new_per+$salary_dtls["standard_promotion_increase"])

							// 	);
							// }

							$salaryComment[]=array(
									'email'=>strtolower($this->session->userdata('email_ses'))
									,"name"=>$this->session->userdata('username_ses')
									,"increment_per"=>HLP_get_formated_percentage_common($new_per)
									,"permotion_per"=>HLP_get_formated_percentage_common($salary_dtls['sp_manager_discretions'])
									,"changed_by"=>'HR'
									,"role"=>"HR"
									,"rating"=>$salary_dtls['performance_rating']
									,"final_salary"=>$final_salary_increased_salary
									,"final_increment_amount"=>$final_salary_increased_salary-$salary_dtls["increment_applied_on_salary"]
									//,"final_increment_per"=>HLP_get_formated_percentage_common($new_per+$salary_dtls["sp_manager_discretions"]
									,"final_increment_per"=>HLP_get_formated_percentage_common($final_total_hike),
									"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")	
								);


							if($salary_dtls['promotion_comment']!="")
							{
								$temp=json_decode($salary_dtls['promotion_comment'],true);
								if(json_last_error()=== JSON_ERROR_NONE)
								{
									for($i=0;$i<count($temp);$i++)
									{
										if($temp[$i]['email']!=strtolower($this->session->userdata('email_ses')))
										{
											$salaryComment[]=$temp[$i];
										}
										// else
										// {
										// 	$salaryComment[$i]['permotion_per']=$temp[$i]['permotion_per'];
										// }

									}

								}
							}




				########## Commented By Kingjuliean ############

				// "sp_increased_salary"=>$promotion_increased_salary, "sp_manager_discretions"=>$promotion_per,
				#################################################

				$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "manager_discretions"=>$final_total_hike, $hike_column_name=>$new_per,"promotion_comment"=>json_encode($salaryComment),"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$id));

				/*$revised_comparative_ratio = 0;
				if($salary_dtls["market_salary"])
				{
					$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
				}*/

				if($this->input->is_ajax_request())
				{
					/*$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>$revised_comparative_ratio);*/
					$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($salary_dtls["rule_id"], $id);
					$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
					echo json_encode($response); die;
				}
				else
				{
					$this->session->set_flashdata("open_manager_panel", "1");
					$this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data updated successfully.</b></div>');
					redirect(site_url("view-increments/".$salary_dtls['rule_id']));
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



	///delete promotion by hr
	public function delete_emp_promotions_dtls($emp_salary_dtl_id)
	{
		$err_msg = "";
		if($emp_salary_dtl_id > 0)
		{
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "hr_parameter.status"=>6));

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
				$crr_arr = json_decode($salary_dtls["comparative_ratio_range"], true);

				//$this->manager_model->update_tbl_data("employee_salary_details", array("manager_discretions"=>($salary_dtls["final_merit_hike"] + $salary_dtls["crr_based_increment"]), "final_salary"=>$final_salary_increased_salary, "final_market_hike"=>$salary_dtls["crr_based_increment"], "mkt_salary_after_promotion"=>$salary_dtls["market_salary"], "crr_after_promotion"=>$salary_dtls["crr_val"],"quartile_range_name_after_promotion"=>$salary_dtls["pre_quartile_range_name"], "post_quartile_range_name" => HLP_get_quartile_position_range_name($salary_dtls, $final_salary_increased_salary, $crr_arr), "sp_increased_salary" => 0, $promotion_col_name=>"", "sp_manager_discretions"=>0,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_salary_dtl_id));
				
				$db_upd_arr = array("manager_discretions"=>($salary_dtls["final_merit_hike"] + $salary_dtls["crr_based_increment"]), "final_salary"=>$final_salary_increased_salary, "final_market_hike"=>$salary_dtls["crr_based_increment"], "mkt_salary_after_promotion"=>$salary_dtls["market_salary"], "crr_after_promotion"=>$salary_dtls["crr_val"],"quartile_range_name_after_promotion"=>$salary_dtls["pre_quartile_range_name"], "post_quartile_range_name" => HLP_get_quartile_position_range_name($salary_dtls, $final_salary_increased_salary, $crr_arr), "sp_increased_salary" => 0, "emp_new_designation"=>"", "emp_new_grade"=>"", "emp_new_level"=>"", "sp_manager_discretions"=>0,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
				
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
				
				$this->session->set_flashdata("open_manager_panel", "1");
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
		//echo json_encode($response);
	}
	
	public function update_emp_promotions_dtls($emp_salary_dtl_id)
	{
		$err_msg = "";
		$new_per = round(trim($this->input->post("txt_emp_sp_salary_per")), CV_SALARY_HIKE_ROUND_OFF);
		$new_desig = trim($this->input->post("txt_emp_new_designation"));
		
		$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.letter_status !="=>CV_RELEASED_LETTER_STATUS, "hr_parameter.status >="=>6, "hr_parameter.status <="=>7));

		if($salary_dtls)
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
			$new_dtls_after_promotion = HLP_get_new_mkt_dtls_after_promotion(1, $salary_dtls);
				
			/*$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
			$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + (($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"])/100) + $increased_salary;*/

			$temp="";
			$promotionComment=[];
			$promotionComment[]=array(
					'email'=>strtolower($this->session->userdata('email_ses'))
					,"name"=>$this->session->userdata('username_ses')
					,"increment_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_final_total_hike"])
					,"permotion_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_promotion_hike"])
					,"changed_by"=>'HR'
					,"role"=>"HR"
					,"rating"=>$salary_dtls['performance_rating']
					,"final_salary"=>$new_dtls_after_promotion["n_final_salary"]
					,"final_increment_amount"=>$new_dtls_after_promotion["n_final_salary"] - $salary_dtls["increment_applied_on_salary"]
					,"final_increment_per"=>HLP_get_formated_percentage_common($salary_dtls["final_merit_hike"] + $new_dtls_after_promotion["n_promotion_hike"] + $new_dtls_after_promotion["n_market_hike"]),
					"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
					"createdon" => date("Y-m-d H:i:s")
				);

			if($salary_dtls['promotion_comment']!="")
			{
				$temp=json_decode($salary_dtls['promotion_comment'],true);
				if(json_last_error()=== JSON_ERROR_NONE)
				{
					for($i=0;$i<count($temp);$i++)
					{
						if($temp[$i]["email"]!=strtolower($this->session->userdata('email_ses')))
						{
							$promotionComment[]=$temp[$i];
						}
					}
				}
			}
			$db_upd_arr = array("manager_discretions"=>$new_dtls_after_promotion["n_final_total_hike"], "final_salary"=>$new_dtls_after_promotion["n_final_salary"], "final_market_hike"=>$new_dtls_after_promotion["n_market_hike"], "mkt_salary_after_promotion"=>$new_dtls_after_promotion["n_market_salary_for_crr"], "crr_after_promotion"=>$new_dtls_after_promotion["n_crr_val"], "sp_increased_salary" =>$new_dtls_after_promotion["n_promotion_salary"], "sp_manager_discretions"=>$new_dtls_after_promotion["n_promotion_hike"], $new_dtls_after_promotion["promotion_col_name"]=>$new_dtls_after_promotion["emp_new_post_id"], "promotion_comment"=>json_encode($promotionComment), "quartile_range_name_after_promotion"=>$new_dtls_after_promotion["quartile_range_name_after_promotion"], "post_quartile_range_name"=>$new_dtls_after_promotion["post_quartile_range_name"], "updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses"));
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
			
			/*if($salary_dtls["market_salary"])
			{
				$revised_comparative_ratio = HLP_get_formated_percentage_common(($new_dtls_after_promotion["n_final_salary"]/$salary_dtls["market_salary"])*100);
			}*/
			/*$revised_comparative_ratio = 0;
			if($new_dtls_after_promotion["n_market_salary_for_crr"])
			{
				$revised_comparative_ratio = HLP_get_formated_percentage_common(($new_dtls_after_promotion["n_final_salary"]/$new_dtls_after_promotion["n_market_salary_for_crr"])*100);
			}
			$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($new_dtls_after_promotion["n_final_salary"]), "increased_salary"=>HLP_get_formated_amount_common($new_dtls_after_promotion["n_promotion_salary"]), "revised_comparative_ratio"=>$revised_comparative_ratio);*/
			
			$new_data = $this->get_emp_sal_row_and_managers_budget_dtls_for_salary($salary_dtls["rule_id"], $emp_salary_dtl_id);
			$response =array("status"=>true,"msg"=>"Ok", "emp_row_dtls"=>$new_data["emp_row_dtls"], "managers_bdgt_dtls_arr"=>$new_data["managers_bdgt_dtls_arr"]);
			echo json_encode($response); die;
		}
		else
		{
			$err_msg = "Invalid request.";
		}

		$response =array("status"=>false,"msg"=>$err_msg, "updated_salary"=>0);
		echo json_encode($response);
	}
	
	public function get_promotion_suggestion_dtls($emp_id)
	{
		$usr_dtls = $this->rule_model->get_table_row("login_user", CV_BA_NAME_DESIGNATION.", ".CV_BA_NAME_GRADE.", ".CV_BA_NAME_LEVEL, array("id"=>$emp_id), "id ASC");
		
		$promotion_upgradation_cnd = "status = 1 AND (designation_frm = ".$usr_dtls[CV_BA_NAME_DESIGNATION]." OR designation_frm = 0) AND (grade_frm = ".$usr_dtls[CV_BA_NAME_GRADE]." OR grade_frm = 0) AND (level_frm = ".$usr_dtls[CV_BA_NAME_LEVEL]." OR level_frm = 0)";
		$new_promotion_upgradation_dtls = $this->rule_model->get_table_row("tbl_promotion_up_gradation", "designation_to, grade_to, level_to", $promotion_upgradation_cnd, "id ASC");
		if($new_promotion_upgradation_dtls)
		{
			$response =array("status"=>true, "emp_s_designation"=>$new_promotion_upgradation_dtls["designation_to"], "emp_s_grade"=>$new_promotion_upgradation_dtls["grade_to"], "emp_s_level"=>$new_promotion_upgradation_dtls["level_to"]);
		}
		else
		{
			$response =array("status"=>false);
		}
		
		echo json_encode($response);
	}
	
	
	/* *** Function to prepare data to replace employees table row and all manager's budget dtls *** */
	private function get_emp_sal_row_and_managers_budget_dtls_for_salary($rule_id, $emp_sal_dtl_tbl_pk_id)
	{
		$emp_row_dtls=$this->get_emp_increment_list_for_manager_frm_hr_ajax($rule_id,"",0,$emp_sal_dtl_tbl_pk_id);
		
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

	public function update_emp_additional_field_dtls()
	{
		//$_SESSION['active'] = trim($this->input->post("con")) ;

		$emp_salary_dtl_id = $this->input->post("emp_sal_id");
		/*$field_name = trim($this->input->post("field_name"));
		$field_val = trim($this->input->post("field_val"));*/
		$err_msg = "";

		if($emp_salary_dtl_id)
		{
			/*$salary_dtls = $this->rule_model->get_table_row("employee_salary_details", "rule_id", array("status <"=>5, "id"=>$emp_salary_dtl_id));
			if($salary_dtls)*/

			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.letter_status !="=>CV_RELEASED_LETTER_STATUS, "hr_parameter.status >="=>6, "hr_parameter.status <="=>7));

			$can_edit_data = 0;//No
			if(!empty($salary_dtls) and $this->session->userdata('role_ses') < 10)
			{
				$can_edit_data = 1;//Yes
			}
			elseif(!empty($salary_dtls) and $this->session->userdata('role_ses') == 10 and $salary_dtls["status"] < 5)
			{
				$can_edit_data = 1;//Yes
			}

			if($can_edit_data)
			{
				$esop_val = "";
				$retention_bonus_val = "";
				$pay_per_val = "";
				if($this->input->post("esop_val"))
				{
					$esop_val = $this->input->post("esop_val");
				}
				if($this->input->post("retention_bonus_val"))
				{
					$retention_bonus_val = $this->input->post("retention_bonus_val");
				}
				if($this->input->post("pay_per_val"))
				{
					$pay_per_val = $this->input->post("pay_per_val");
				}
				//$this->manager_model->update_tbl_data("employee_salary_details", array($field_name=>$field_val,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_salary_dtl_id));
				$this->manager_model->update_tbl_data("employee_salary_details", array("esop"=>$esop_val, "retention_bonus"=>$retention_bonus_val, "pay_per"=>$pay_per_val, "updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_salary_dtl_id));

				$response =array("status"=>true,"msg"=>"Data updated successfully.");
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

		$response =array("status"=>false,"msg"=>$err_msg);
		echo json_encode($response);
	}


	public function update_salary_rule_comments($rule_id,$user_id){


		$salary_id =$this->input->post('txt_salary_id');
		$salary_comment =$this->input->post('txt_salary_comment');

		if($salary_id!='' && $salary_comment!=''){
			$salary_comment_arr =$this->manager_model->get_table_row("employee_salary_details","salary_comment", array("id"=>$salary_id));
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
		redirect(site_url("view-employee-increments/".$rule_id."/".$user_id));
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
		redirect(site_url("view-employee-increments/".$rule_id."/".$user_id));
	}

	public function update_emp_promotion_basis_on()
	{
		$emp_sal_tbl_pk_id =$this->input->post('emp_sal_id');
		$new_position_id =$this->input->post('new_position_id');
		$new_position_for =$this->input->post('new_position_for');
		/*$new_grade =$this->input->post('emp_new_grade');
		$new_level =$this->input->post('emp_new_level');*/

		$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_sal_tbl_pk_id, "employee_salary_details.letter_status !="=>CV_RELEASED_LETTER_STATUS, "hr_parameter.status >="=>6, "hr_parameter.status <="=>7));

		$can_edit_data = 0;//No
		if(!empty($salary_dtls) and $this->session->userdata('role_ses') < 10)
		{
			$can_edit_data = 1;//Yes
		}
		elseif(!empty($salary_dtls) and $this->session->userdata('role_ses') == 10 and $salary_dtls["status"] < 5)
		{
			$can_edit_data = 1;//Yes
		}

		if($can_edit_data == 1 and $new_position_id>0 and ($new_position_for))
		{
			//if(isset($_POST['txt_emp_new_designation']) && isset($_POST['emp_new_grade']))
			/*if(isset($_POST['emp_new_grade']))
			{
				$this->manager_model->update_tbl_data("employee_salary_details", array("emp_new_designation"=>$new_desig,"emp_new_grade"=>$new_grade,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")) , array("id"=>$emp_sal_tbl_pk_id));
			}
			else if(isset($_POST['emp_new_level']))
			{
				$this->manager_model->update_tbl_data("employee_salary_details", array("emp_new_level"=>$new_level,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")) , array("id"=>$emp_sal_tbl_pk_id));
			}
			else if(isset($_POST['txt_emp_new_designation']))
			{
				$this->manager_model->update_tbl_data("employee_salary_details", array("emp_new_designation"=>$new_desig,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")) , array("id"=>$emp_sal_tbl_pk_id));
			}*/
			
			$this->manager_model->update_tbl_data("employee_salary_details", array($new_position_for=>$new_position_id,"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")) , array("id"=>$emp_sal_tbl_pk_id));

			$response =array("status"=>true,"msg"=>"Ok");
		}
		else
		{
			$response =array("status"=>false,"msg"=>"Data not updated.");
		}
		echo json_encode($response); die;
	}

	//*Start :: CB::Ravi on 31-05-09 To upload bulk Increments By the HR *********************
	public function get_hr_emps_file_to_upload_increments($rule_id)
	{
		$cdt = date("Y-m-d");
		//$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("performance_cycle.start_date <="=>$cdt, "performance_cycle.end_date >="=>$cdt, "hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id, "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));

		$whr_cnd = "employee_salary_details.rule_id = ".$rule_id;
		if($this->session->userdata('role_ses') > 1 and $rule_dtls["createdby"] != $this->session->userdata('userid_ses'))
		{
			$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		//$staff_list = $this->manager_model->get_managers_direct_emps_list(array("employee_salary_details.rule_id" => $rule_id));
		$staff_list = $this->manager_model->get_managers_direct_emps_list($whr_cnd);
		$manager_emailid = strtolower($this->session->userdata('email_ses'));
        HLP_get_manager_hr_emps_file_to_upload_increments($rule_dtls, $staff_list,$manager_emailid);
	}

	public function bulk_upload_hr_emps_increments($rule_id)
	{
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
						$req_response = HLP_bulk_upload_hr_managers_direct_emps_increments($rule_dtls, $csv_file,$manager_emailid, 2);
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
			}
		}

		redirect(site_url("view-increments/".$rule_id));
	}
	//*End :: CB::Ravi on 31-05-09 To upload bulk Increments By the HR *********************

	/* ************** Start :: Insert/Update Salary/Promotion Comments section ************** */
	public function ins_upd_salary_promotion_comment($is_manager)
	{
		$emp_sal_dtl_tbl_id =$this->input->post('hf_usr_tbl_id');
		$usr_comment =$this->input->post('txt_comment');

		if($emp_sal_dtl_tbl_id > 0 && $usr_comment!='')
		{
			$old_comment_dtls = $this->rule_model->get_table_row("employee_salary_details", "status, comments", array("id"=>$emp_sal_dtl_tbl_id));
			
			$role = "HR";
			$role_type = "HR";
			if($this->session->userdata('role_ses') == 1)
			{
				$role = "Admin";
				$role_type = "Admin";
			}
			elseif($is_manager==1)
			{
				$role = "Approver";
				$role_type = "Approver-".$old_comment_dtls["status"];
			}
			
			$login_usr_id = $this->session->userdata('userid_ses');
			$new_comment_arr = array(
									"msg"=>$usr_comment,
									"role"=>$role,
									"type"=>$role_type,
									"c_by"=>$login_usr_id,
									"c_on"=>date("d/m/Y H:i:s"),
									"c_by_name"=>$this->session->userdata("username_ses"),												
									"c_by_proxy"=>$this->session->userdata("proxy_userid_ses"),
									);
			$db_arr = array();
			if($old_comment_dtls["comments"] != "")
			{
				$old_comment_arr = json_decode($old_comment_dtls["comments"], true);
				$flag = true;
				foreach($old_comment_arr as $row)
				{
					if($row["c_by"]==$login_usr_id)
					{
						$db_arr[] = $new_comment_arr;
						$flag = false;
					}
					else
					{
						$db_arr[] = $row;
					}					
				}
				if($flag)
				{
					$db_arr[] = $new_comment_arr;
				}
			}
			else
			{
				$db_arr[] = $new_comment_arr;
			}

			$this->manager_model->update_tbl_data("employee_salary_details", array("comments"=>json_encode($db_arr),"updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->session->userdata("proxy_userid_ses")), array("id"=>$emp_sal_dtl_tbl_id));
			$response = array("status"=>true, "new_comment_dtls"=>json_encode($db_arr));
		}
		else
		{
			$response = array("status"=>false, "msg"=>"comments required.");
		}
		echo json_encode($response);
	}
	/* ************** End :: Insert/Update Salary/Promotion Comments section ************** */

	################### Export Log Report #############################


	public function exportLogReport($rule_id)
	{
		$whr_cnd = "employee_salary_details.rule_id = ".$rule_id;
		if($this->session->userdata('role_ses') > 1 and $data["rule_dtls"]["createdby"] != $this->session->userdata('userid_ses'))
		{
			$whr_cnd .= " AND employee_salary_details.user_id IN (".$this->session->userdata('hr_usr_ids_ses').")";
		}
		$salary_dtls = $this->rule_model->get_table_row("hr_parameter", "esop_title,pay_per_title,retention_bonus_title, rounding_final_salary", array("id"=>$rule_id));

		$staff_list = $this->rule_model->get_rule_wise_emp_list_for_increment($whr_cnd);

		$str='<table border=1>';
		$str.='<tr>';
		$str.='<th colspan=20></th>';
		$str.='<th colspan=6>Approver 1</th>';
		$str.='<th colspan=6>Approver 2</th>';
		$str.='<th colspan=6>Approver 3</th>';
		$str.='<th colspan=6>Approver 4</th>';
		$str.='<th colspan=6>HR</th>';
		$str.='</tr>';
		$str.='<tr>';

		$str.='<th>Employee Code</th>';
		$str.='<th>Employee Full name</th>';
		$str.='<th>Email ID</th>';
		$str.='<th>DOJ</th>';
		$str.='<th>Business</th>';
		$str.='<th>Product</th>';
		$str.='<th>Channel</th>';
		$str.='<th>Function</th>';
		$str.='<th>Sub Function</th>';
		$str.='<th>Role</th>';
		$str.='<th>Designation/Title</th>';
		$str.='<th>Grade</th>';
		$str.='<th>Uploaded Rating</th>';
		$str.='<th>Compa Ratio</th>';
		$str.='<th>Pro-Ration Factor</th>';
		$str.='<th>Original Recommendation</th>';
		$str.='<th>Approver-1</th>';
		$str.='<th>Approver-2</th>';
		$str.='<th>Approver-3</th>';
		$str.='<th>Approver-4</th>';

		$str.='<th>Rating</th>';
		$str.='<th>Increment %</th>';
		$str.='<th>Promotion (Yes/No)</th>';
		$str.='<th>Final Increment Percentage</th>';
		$str.='<th>Final Increment Amount</th>';
		$str.='<th>Final New Salary</th>';

		$str.='<th>Rating</th>';
		$str.='<th>Increment %</th>';
		$str.='<th>Promotion (Yes/No)</th>';
		$str.='<th>Final Increment Percentage</th>';
		$str.='<th>Final Increment Amount</th>';
		$str.='<th>Final New Salary</th>';

		$str.='<th>Rating</th>';
		$str.='<th>Increment %</th>';
		$str.='<th>Promotion (Yes/No)</th>';
		$str.='<th>Final Increment Percentage</th>';
		$str.='<th>Final Increment Amount</th>';
		$str.='<th>Final New Salary</th>';

		$str.='<th>Rating</th>';
		$str.='<th>Increment %</th>';
		$str.='<th>Promotion (Yes/No)</th>';
		$str.='<th>Final Increment Percentage</th>';
		$str.='<th>Final Increment Amount</th>';
		$str.='<th>Final New Salary</th>';

		$str.='<th>Rating</th>';
		$str.='<th>Increment %</th>';
		$str.='<th>Promotion (Yes/No)</th>';
		$str.='<th>Final Increment Percentage</th>';
		$str.='<th>Final Increment Amount</th>';
		$str.='<th>Final New Salary</th>';
		if($salary_dtls['esop_title']!='')
		{
			$str.='<th>'.$salary_dtls['esop_title'].'</th>';
		}
		if($salary_dtls['pay_per_title']!='')
		{
			$str.='<th>'.$salary_dtls['pay_per_title'].'</th>';
		}
		if($salary_dtls['retention_bonus_title']!='')
		{
			$str.='<th>'.$salary_dtls['retention_bonus_title'].'</th>';
		}

		$str.='</tr>';

		foreach($staff_list as $row)
		{
			$str.='<tr>';
			$str.='<td>'.$row['employee_code'].'</td>';
			$str.='<td>'.$row['emp_name'].'</td>';
			$str.='<td>'.$row['email_id'].'</td>';
			$str.='<td>'.$row['joining_date_for_increment_purposes'].'</td>';
			$str.='<td>'.$row['business_level_1'].'</td>';
			$str.='<td>'.$row['business_level_2'].'</td>';
			$str.='<td>'.$row['business_level_3'].'</td>';
			$str.='<td>'.$row['function'].'</td>';
			$str.='<td>'.$row['sub_function'].'</td>';
			$str.='<td>'.$row['designation'].'</td>';
			$str.='<td>'.$row['special_category'].'</td>';
			$str.='<td>'.$row['grade'].'</td>';
			$str.='<td>'.$row['emp_performance_rating'].'</td>';
			 if($row['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
                  {
                  $current_position_pay_range = $row["post_quartile_range_name"];
                  }
                  else
                  {

					  $current_position_pay_range = HLP_get_formated_percentage_common($row["crr_val"]).'%';
                  }
			$str.='<td>'.$current_position_pay_range.'</td>';
			$str.='<td>'.$row['proreta_multiplier'].'</td>';
			 $all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];
			$str.='<td>'.$all_hikes_total.'</td>';
			$str.='<td>'.$row['approver_1'].'</td>';
			$str.='<td>'.$row['approver_2'].'</td>';
			$str.='<td>'.$row['approver_3'].'</td>';
			$str.='<td>'.$row['approver_4'].'</td>';


			//$temp=json_decode($row['promotion_comment']);

			if($row['promotion_comment']!="")
							{
								$temp=json_decode($row['promotion_comment'],true);

								if(json_last_error()=== JSON_ERROR_NONE)
								{
									$a1=$a2=$a3=$a4=$hr='';
									for($i=0;$i<count($temp);$i++)
									{
										if($temp[$i]['changed_by']=='Approver-1')
										{
											$a1.='<td>'.$temp[$i]['rating'].'</td>';
											$a1.='<td>'. HLP_get_formated_percentage_common($temp[$i]['increment_per']).'</td>';
											if($temp[$i]['permotion_per']!=0)
											{
												$a1.='<td>Yes</td>';
											}
											else
											{
												$a1.='<td>No</td>';
											}

											$a1.='<td>'.HLP_get_formated_percentage_common($temp[$i]['final_increment_per']) .'</td>';
											$a1.='<td>'.HLP_get_formated_amount_common( $temp[$i]['final_increment_amount']).'</td>';
											//$a1.='<td>'.HLP_get_formated_amount_common($temp[$i]['final_salary']).'</td>';
											$a1.='<td>'.HLP_get_formated_amount_common(HLP_get_round_off_val($temp[$i]['final_salary'], $salary_dtls["rounding_final_salary"])).'</td>';
										}
										elseif ($temp[$i]['changed_by']=='Approver-2') {
											$a2.='<td>'.$temp[$i]['rating'].'</td>';
											$a2.='<td>'.HLP_get_formated_percentage_common($temp[$i]['increment_per']).'</td>';
											if($temp[$i]['permotion_per']!=0)
											{
												$a2.='<td>Yes</td>';
											}
											else
											{
												$a2.='<td>No</td>';
											}

											$a2.='<td>'.HLP_get_formated_percentage_common($temp[$i]['final_increment_per']) .'</td>';
											$a2.='<td>'.HLP_get_formated_amount_common( $temp[$i]['final_increment_amount']).'</td>';
											//$a2.='<td>'.HLP_get_formated_amount_common($temp[$i]['final_salary']).'</td>';
											$a2.='<td>'.HLP_get_formated_amount_common(HLP_get_round_off_val($temp[$i]['final_salary'], $salary_dtls["rounding_final_salary"])).'</td>';
										}
										elseif ($temp[$i]['changed_by']=='Approver-3') {
											$a3.='<td>'.$temp[$i]['rating'].'</td>';
											$a3.='<td>'.HLP_get_formated_percentage_common($temp[$i]['increment_per']).'</td>';
											if($temp[$i]['permotion_per']!=0)
											{
												$a3.='<td>Yes</td>';
											}
											else
											{
												$a3.='<td>No</td>';
											}

											$a3.='<td>'.HLP_get_formated_percentage_common($temp[$i]['final_increment_per']) .'</td>';
											$a3.='<td>'.HLP_get_formated_amount_common( $temp[$i]['final_increment_amount']).'</td>';
											//$a3.='<td>'.HLP_get_formated_amount_common($temp[$i]['final_salary']).'</td>';
											$a3.='<td>'.HLP_get_formated_amount_common(HLP_get_round_off_val($temp[$i]['final_salary'], $salary_dtls["rounding_final_salary"])).'</td>';
										}
										elseif ($temp[$i]['changed_by']=='Approver-4') {
											$a4.='<td>'.$temp[$i]['rating'].'</td>';
											$a4.='<td>'.HLP_get_formated_percentage_common($temp[$i]['increment_per']).'</td>';
											if($temp[$i]['permotion_per']!=0)
											{
												$a4.='<td>Yes</td>';
											}
											else
											{
												$a4.='<td>No</td>';
											}

											$a4.='<td>'.HLP_get_formated_percentage_common($temp[$i]['final_increment_per']) .'</td>';
											$a4.='<td>'.HLP_get_formated_amount_common( $temp[$i]['final_increment_amount']).'</td>';
											//$a4.='<td>'.HLP_get_formated_amount_common($temp[$i]['final_salary']).'</td>';
											$a4.='<td>'.HLP_get_formated_amount_common(HLP_get_round_off_val($temp[$i]['final_salary'], $salary_dtls["rounding_final_salary"])).'</td>';
										}
										elseif ($temp[$i]['changed_by']=='HR') {
											$hr.='<td>'.$temp[$i]['rating'].'</td>';
											$hr.='<td>'.HLP_get_formated_percentage_common($temp[$i]['increment_per']).'</td>';
											if($temp[$i]['permotion_per']!=0)
											{
												$hr.='<td>Yes</td>';
											}
											else
											{
												$hr.='<td>No</td>';
											}

											$hr.='<td>'.HLP_get_formated_percentage_common($temp[$i]['final_increment_per']) .'</td>';
											$hr.='<td>'.HLP_get_formated_amount_common( $temp[$i]['final_increment_amount']).'</td>';
											//$hr.='<td>'.HLP_get_formated_amount_common($temp[$i]['final_salary']).'</td>';
											$hr.='<td>'.HLP_get_formated_amount_common(HLP_get_round_off_val($temp[$i]['final_salary'], $salary_dtls["rounding_final_salary"])).'</td>';
										}


									}

									if($a1=='')
									{
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
									}
									else
									{
										$str.=$a1;
									}
									if($a2=='')
									{
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
									}
									else
									{
										$str.=$a2;
									}
									if($a3=='')
									{
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
									}
									else
									{
										$str.=$a3;
									}
									if($a4=='')
									{
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
									}
									else
									{
										$str.=$a4;
									}
									if($hr=='')
									{
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
										$str.='<td></td>';
									}
									else
									{
										$str.=$hr;
									}

								}
							}
							else
							{
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';

			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';

			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';

			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';

			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';
			$str.='<td></td>';



							}


			if($salary_dtls['esop_title']!='')
			{
			$str.='<th>'.$row['esop'].'</th>';
			}
			if($salary_dtls['pay_per_title']!='')
			{
			$str.='<th>'.$row['pay_per'].'</th>';
			}
			if($salary_dtls['retention_bonus_title']!='')
			{
			$str.='<th>'.$row['retention_bonus'].'</th>';
			}
			$str.='</tr>';
		}
		$str.='</table>';
		//echo $str;


$filename =  'log_report_'.time().".xls";


	header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=$filename.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	echo $str;
	exit;

	}


	####################################################################


}
