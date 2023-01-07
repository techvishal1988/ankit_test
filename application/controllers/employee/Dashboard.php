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
		$this->load->model("performance_cycle_model");
		$this->load->model("rule_model");
		$this->load->model('template_model');
		$this->load->model('lti_rule_model');
		$this->load->model("bonus_model");
		$this->load->model("manager_model");
		if($this->session->userdata('companyid_ses') == CV_SURVEY_COMPANY_ID)
		{
			redirect(site_url("survey/users"));
		}
		$this->session->set_userdata(array('sub_session'=>11));
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '')
		{			
			redirect(site_url("logout"));			
		}          
        HLP_is_valid_web_token();        
    }
	
	public function index()
	{		
		// $this->session->set_flashdata('message', $this->lang->line('msg_no_view_right'));
		// redirect(site_url("no-rights"));
		
		$data['msg'] = "";
		$data['title'] = "Dashboard";
		$data['body'] = "dashboard";
        $this->load->view('common/structure',$data);
	}
	
    public function view_emp_salary_dtls()
	{	
		$user_id = $this->session->userdata('userid_ses');
		$rule_dtls = $this->rule_model->get_table_row('salary_rule_users_dtls', 'rule_id', 'user_id = '.$user_id.' AND rule_id IN(SELECT id FROM hr_parameter WHERE status='.CV_STATUS_RULE_RELEASED.')', "rule_id DESC");
		
		if(!$rule_dtls)
		{
			redirect(site_url("dashboard"));
		}
		$rule_id = $rule_dtls["rule_id"];
		$user_dtls = $this->rule_model->get_table_row('login_user', 'upload_id', array("id"=>$user_id), "id desc");
		$upload_id = $user_dtls["upload_id"];
		$data['business_attributes'] = $this->rule_model->get_table("business_attribute", "id, display_name", "", "id asc");
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$data['user_salary_graph_dtls']=$this->rule_model->get_employee_salary_dtls_for_graph($user_id);
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
		$data['company_dtls'] = $this->rule_model->get_table_row("manage_company", "*", array("id"=>$this->session->userdata('companyid_ses')));
		$data['graph_for_show']='Designation';
		/*$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($$user_id);
		$data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id);
		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);
		$data['team_salary_graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));*/
		$data['title'] = "Salary Details";
		$data['body'] = "empl_sal_dtl_new";
		$data['emp']='employee';
		$this->load->view('common/structure',$data);	
	}
        
	public function view_emp_bonus_dtls()
	{	
		$user_id = $this->session->userdata('userid_ses');
		$rule_dtls = $this->rule_model->get_table_row('bonus_rule_users_dtls', 'rule_id', 'user_id = '.$user_id.' AND rule_id IN(SELECT id FROM hr_parameter_bonus WHERE status='.CV_STATUS_RULE_RELEASED.')', "rule_id DESC");
		
		if(!$rule_dtls)
		{
			redirect(site_url("dashboard"));
		}	
		$rule_id = $rule_dtls["rule_id"];
		
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		//$data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
		$data['title'] = "Bonus Details";
		$data['body'] = "view_emp_bonus_dtl";
		$data['removeleft']='removeleft';
		$this->load->view('common/structure',$data);	
	}
	
	public function view_emp_lti_dtls()
	{		
		$user_id = $this->session->userdata('userid_ses');
		$rule_dtls = $this->rule_model->get_table_row('lti_rule_users_dtls', 'rule_id', 'user_id = '.$user_id.' AND rule_id IN(SELECT id FROM lti_rules WHERE status='.CV_STATUS_RULE_RELEASED.')', "rule_id DESC");
		
		if(!$rule_dtls)
		{
			redirect(site_url("dashboard"));
		}
		
		$rule_id = $rule_dtls["rule_id"];
		
		$lti_dtls = $this->rule_model->get_table_row("employee_lti_details", "employee_lti_details.*, (select upload_id from login_user where login_user.id = employee_lti_details.user_id) as upload_id", array("status"=>5, "user_id"=>$user_id, "rule_id"=>$rule_id), "id desc");

		if(!$lti_dtls)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><strong>Warning !</strong> You have not came in any lti rule.</div>');                 
			redirect(base_url("dashboard"));                 
		}
		
		//$upload_id=$lti_dtls['upload_id'];
		
		$data['emp_lti_dtls'] = $this->lti_rule_model->get_emp_lti_dtls(array("employee_lti_details.rule_id"=>$rule_id, "employee_lti_details.user_id"=>$user_id));		
		
		$data['index_for_vesting'] = 0;

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
		
		$data['employee']='employee';
		$data['title'] = "Employee LTI Details";
		$data['body'] = "manager/view_emp_lti_dtls";
		$this->load->view('common/structure',$data);	
	}
	
	public function view_emp_rnr_dtls()
	{
		$data['msg'] = "";
		$uid = $this->session->userdata('userid_ses');
		$rule_dtls = $this->rule_model->get_table_row('proposed_rnr_dtls', 'id', array("proposed_rnr_dtls.user_id"=>$uid, "proposed_rnr_dtls.status"=>1), "id desc");
		
		$current_dt = date("Y-m-d");
		$data['rnr_rules'] = $this->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.award_type"=>4, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));
		
		if(!$rule_dtls and !$data['rnr_rules'])
		{
			redirect(site_url("dashboard"));
		}
	
		$data['emp_details'] = $this->rule_model->get_table_row("login_user","login_user.id, login_user.".CV_BA_NAME_EMP_FULL_NAME.", login_user.".CV_BA_NAME_EMP_EMAIL.", points, (SELECT name FROM manage_designation WHERE id = login_user.".CV_BA_NAME_DESIGNATION.") AS designation, (SELECT name FROM manage_currency WHERE manage_currency.id = login_user.".CV_BA_NAME_CURRENCY.") AS currency_type", array("id"=>$uid));
		$data["emp_rnr_history"] = $this->manager_model->get_emp_rnr_history(array("proposed_rnr_dtls.user_id"=>$uid, "proposed_rnr_dtls.status"=>1));
		
		if(count($data["emp_rnr_history"])==0)
		{
			//$this->session->set_flashdata('msg', '<div class="alert alert-danger"><strong>Warning !</strong> You have not came in any R and R rule.</div>');
			//redirect(base_url("dashboard"));
			$data['msg'] = '<div class="alert alert-danger"><strong>Warning !</strong> You have not came in any R and R rule.</div>';
		}
		
		$data['title'] = "Propose For R and R";
		$data['body'] = "employee/propose_for_rnr";
		$this->load->view('common/structure',$data);
	}
        
        public function comming()
        {
                $data['title'] = "Comming soon";
		$data['body'] = "view_emp_bonus_dtl";
                $data['removeleft']='removeleft';
		$this->load->view('common/structure',$data);	 
        }
        public function view_employee_salary_increments()
	{	
		$emp_salary_dtls = $this->rule_model->get_table_row("employee_salary_details", "*", array("user_id"=>$this->session->userdata('userid_ses'), "employee_salary_details.status"=>5), "id desc");

		if(!$emp_salary_dtls)
		{
			redirect(site_url("employee/dashboard"));
		}	

		$rule_id = $emp_salary_dtls["rule_id"];
		$upload_id = $emp_salary_dtls["upload_id"];
		$user_id = $this->session->userdata('userid_ses');

		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));

		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 6)
		{
			redirect(site_url("employee/dashboard"));
		}	

		$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id);//echo "<pre>";print_r($data['user_salary_graph_dtls']);die;
		$data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id, $upload_id);
		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);
		$data['team_salary_graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
		
		$data['title'] = "Increments Report";	
		$data['body'] = "view_emp_salary_dtl";
		$this->load->view('common/structure',$data);	
	}

	public function profile()
	{
		$data['msg'] = "";						
		$data['title'] = "Profile";
		$data['body'] = "profile";
		$this->load->view('common/structure',$data);		
	}
	public function donutgraph()
    {
		if(!helper_have_rights(CV_PG_TOTAL_REWARDS_STATEMENT_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata( '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_view_right_pc').'</b></span></div>');
			redirect(site_url("no-rights"));		
		}
		
        $user_id=$this->session->userdata('userid_ses');
        $data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($user_id);
		$data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id='', $user_id);
		$data['peer_salary_graph_dtls'] = $this->template_model->get_peer_employee_salary_dtls_for_graph($user_id);
		$data['team_salary_graph_dtls'] = $this->template_model->get_team_employee_salary_dtls_for_graph( $user_id);		
		$data['salary_dtls'] = $this->template_model->get_current_employee_salary_dtls_for_graph($user_id);
		$data['attr']=$this->template_model->getAttr($user_id);
		
		$data['graph_txt_dtls'] = $this->rule_model->get_table_row("emp_salary_graph_txt_dtls", "*", array("user_id"=>$user_id), "esg_id desc");
        $data['title'] = "Total Rewards Statement";
        $data['body'] = "donut";
        // echo "<pre>";print_r($data);die();
        $this->load->view('common/structure',$data);
    }
    /* CB:Harshit
    public function donutgraph_NIU()
    {
            $user_id=$this->session->userdata('userid_ses');
            $users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$user_id), "id desc");
            $data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($rule_id='', $user_id, $users_last_tuple_dtls['data_upload_id']);
	$data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id='', $user_id, $users_last_tuple_dtls['data_upload_id']);
	$data['peer_salary_graph_dtls'] = $this->template_model->get_peer_employee_salary_dtls_for_graph($user_id);
	$data['team_salary_graph_dtls'] = $this->template_model->get_team_employee_salary_dtls_for_graph( $user_id);		
	$data['salary_dtls'] = $this->template_model->get_current_employee_salary_dtls_for_graph($user_id);
	$data['attr']=$this->template_model->getAttr($users_last_tuple_dtls['row_num'],$users_last_tuple_dtls['data_upload_id']);
	
	$data['graph_txt_dtls'] = $this->rule_model->get_table_row("emp_salary_graph_txt_dtls", "*", array("user_id"=>$user_id), "esg_id desc");
	        $data['title'] = "Total Rewards Statement";
            //$data['title'] = "Current Salarys";
	//$data['body'] = "empl_sal_graph";
//                $data['graph_for_show']='Designation';
            $data['body'] = "donut";
             $this->load->view('common/structure',$data);
    }*/
        public function get_peer_employee_salary_dtls_for_graph($graph_for)
	{			
		$data['peer_salary_graph_dtls'] = $this->template_model->get_peer_employee_salary_dtls_for_graph($this->session->userdata('userid_ses'), $graph_for);
               echo '<pre />';print_r($data['peer_salary_graph_dtls']); 
                $data['salary_dtls'] = $this->template_model->get_current_employee_salary_dtls_for_graph($this->session->userdata('userid_ses'));
                if($graph_for=='grade')
                {
                    $graph_for='Designation';
                }
                else {
                    $graph_for=$graph_for;
                }
                $data['graph_for_show']=$graph_for;
		$this->load->view('peer_comparision_graph',$data);
			
	}
        public function comingsoonrandr()
	{
		$data['title'] = "Coming soon";
		$data['body'] = "employee/coming_soon";
		$data['dashboard']="employee/dashboard/";
		$data['message']="This section can customized as per organization requirement.";
		$this->load->view('common/structure',$data);
	}
	public function comingsoonlti()
	{
		$data['title'] = "Coming soon";
		$data['body'] = "employee/coming_soon";
		$data['dashboard']="employee/dashboard/";
		$data['message']="This section can customized as per organization requirement.";
		$this->load->view('common/structure',$data);
	}  
}
