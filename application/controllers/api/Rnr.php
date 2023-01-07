<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Rnr extends REST_Controller {
    public $id='';
    public $email='';
    public $role='';
    public $company_id='';
    public $token='';
    public $authname='';
    function __construct()
        {
        // Construct the parent class
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('domain_model');
        $this->load->model('common_model');
        $this->load->library('form_validation');
        $this->token=@apache_request_headers()['token'];
        $this->authname=@apache_request_headers()['authname'];
        $this->load->model('api/manager_model');
        $this->load->model('api/user_model');
        $this->load->model('api/rule_model');
        $this->load->model('api/bonus_model');
        $this->load->model('api/rnr_rule_model');
        $this->load->model('api/performance_cycle_model');
        $this->load->model('api/admin_model');
        
        if($this->token!='' && $this->authname!='' )
        {
            $this->manager_model->setdb($this->authname);
            $this->bonus_model->setdb($this->authname);
            $this->rnr_rule_model->setdb($this->authname);
            $udata=$this->user_model->userByToken(apache_request_headers()['token']);
         if(count($udata)==1)
         {
             $this->id=$udata[0]->id;
             $this->email=$udata[0]->email;
             $this->role=$udata[0]->role;
             $this->company_id=$udata[0]->company_Id;
             
         }
         else
         {
          
             echo json_encode(array("status" => "failed", "statusCode" => 305, "message" => "Invalid token"));
            exit;  
         }
         
         
        }
        else
         {
          
             echo json_encode(array("status" => "failed", "statusCode" => 305, "message" => "Invalid token"));
            exit; 
         }
        
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function index_get()
	{
		$data['msg'] = "";		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_rnr($this->email);	
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
		$rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data["staff_list"]
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
     public function rnrdetail_get($uid)
	{
		
		
		$data['msg'] = "";	
		//$data['rnr_rules'] = $this->rule_model->get_table("rnr_rules","id, rule_name", "status = 6 and id in ", "rule_name asc");
		$current_dt = date("Y-m-d");
		$data['rnr_rules'] = $this->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.status !="=>8));
		$data['emp_details'] = $this->rule_model->get_table_row("login_user","id, name, email, (select name from manage_designation where id = login_user.desig) as designation, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type", array("id"=>$uid));
		$data["emp_rnr_history"] = $this->manager_model->get_emp_rnr_history(array("proposed_rnr_dtls.user_id"=>$uid, "proposed_rnr_dtls.status <"=>3));	
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_rnr($this->email);	
                $customarr=[
                    "staff"=>$data["staff_list"],
                    "rnrRules"=>$data["rnr_rules"],
                    "empDetail"=>$data['emp_details'],
                    "rnrHistory"=>$data["emp_rnr_history"],   
                ];
		$rdata=array(
                            "status" => "Success",
                            "statusCode" => 200,
                            "data" =>$customarr
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
	}   
        public function rnrrule_get($rule_id)
	{
		$rule_dtls = $this->rule_model->get_table_row("rnr_rules","criteria, award_value, award_frequency, emp_frequency_for_award, budget_dtls, (select sum(rnr_rules.award_value) from proposed_rnr_dtls join rnr_rules on rnr_rules.id = proposed_rnr_dtls.rule_id where proposed_rnr_dtls.rule_id = '".$rule_id."' and proposed_rnr_dtls.status < 3 ) as total_proposed_award_val", array("rnr_rules.id"=>$rule_id), "rule_name asc");
		$rule_dtls["managers_budget"] = 0;
		$rule_dtls["manager_available_budget"] = 0;
		$managers_arr = json_decode($rule_dtls['budget_dtls'],true);
//                echo '<pre />';
//                print_r($rule_dtls); 
//                print_r($managers_arr);
		foreach($managers_arr as $key => $value)
		{
                    //echo $value[0];
			if(strtoupper($this->email) == strtoupper($value[0])) 
			{
               $rule_dtls["managers_budget"] = $value[1];
			}
		}
		$rule_dtls["manager_available_budget"] = $rule_dtls["managers_budget"] - $rule_dtls['total_proposed_award_val'];
		
		$rdata=array(
                            "status" => "Success",
                            "statusCode" => 200,
                            "data" =>$rule_dtls
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
    function update_post($uid,$rule_id)
    {
                    $current_dt = date("Y-m-d");
                    $data['rnr_rules'] = $this->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.status !="=>8));
			$rule_dtls = $this->rule_model->get_table_row("rnr_rules","criteria, award_type, award_value, award_frequency, emp_frequency_for_award, budget_type, budget_dtls, (select sum(rnr_rules.award_value) from proposed_rnr_dtls join rnr_rules on rnr_rules.id = proposed_rnr_dtls.rule_id where proposed_rnr_dtls.rule_id = '".$rule_id."' and proposed_rnr_dtls.status < 3 ) as total_proposed_award_val", array("rnr_rules.id"=>$rule_id, "status"=>6), "rule_name asc");
			if($rule_dtls)
			{
				$managers_budget = 0;
				$manager_available_budget = 0;
				$managers_arr = json_decode($rule_dtls['budget_dtls'],true);
				foreach($managers_arr as $key => $value)
				{
					if(strtoupper($this->email) == strtoupper($value[0])) 
					{
						$managers_budget = $value[1];
					}
				}
				$manager_available_budget = $managers_budget - $rule_dtls['total_proposed_award_val'];
				//Below condition to increate manager budget because budget_type is 'No limit'
//                                echo '<pre />';
//                                print_r($rule_dtls);
				if($rule_dtls["budget_type"]=="No limit")
				{
					$rule_dtls["manager_available_budget"] = $rule_dtls["managers_budget"]+$rule_dtls['award_value'];
				}
				
				if($manager_available_budget >= $rule_dtls['award_value'] or $rule_dtls['award_type'] = 2 or $rule_dtls['award_type'] == 3)
				{
					$last_award_dtls_of_emp = $this->rule_model->get_table_row("proposed_rnr_dtls","createdon", array("rule_id"=>$rule_id, "user_id"=>$uid, "status <"=>3), "id desc");
					//print_r($last_award_dtls_of_emp); die;
					if($last_award_dtls_of_emp)
					{
						$start_date = strtotime(date("Y-m-d", strtotime($last_award_dtls_of_emp["createdon"])));
						$end_date = strtotime(date("Y-m-d"));				
						
						$diff = abs($end_date - $start_date);
						$days = floor($diff / (60*60*24));
						$months = round($days/30);
                                                //echo $months; die;
						if($months < $rule_dtls['emp_frequency_for_award'])
						{
//							$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>You can not give this award before '.$rule_dtls['emp_frequency_for_award'].' months.</b></span></div>');
//							redirect(site_url("manager/propose-for-rnr/".$uid));
                                                        $rdata=array(
                                                                "status" => "failed",
                                                                "statusCode" => 301,
                                                                "message"=>'You can not give this award before '.$rule_dtls['emp_frequency_for_award'].' months.',
                                                                
                                                                );
                                                        echo json_encode($rdata);
                                                        exit; 
                                                        
						}
					}
										
					$db_arr["rule_id"] = $rule_id;
					$db_arr["user_id"] = $uid;
					$db_arr["status"] = 2;
					$db_arr["createdon"] = date("Y-m-d H:i:s");	
                                        $db_arr["createdby"] = $this->id;
                                        $db_arr["updatedon"] = date("Y-m-d H:i:s");
					//$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
//                                        echo '<pre />';
//                                        print_r($db_arr); die;
					$this->admin_model->insert_data_in_tbl("proposed_rnr_dtls", $db_arr);	
					//$this->session->set_flashdata('message', '<div align="left" style="color:green;" id="notify"><span><b>Award has been proposed successfully.</b></span></div>');
                                        $rdata=array(
                                                                "status" => "success",
                                                                "statusCode" => 200,
                                                                "message"=>'Award has been proposed successfully',
                                                                
                                                                );
				}
				else
				{
					//$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Your available amount ('.$manager_available_budget.') is insufficient, Selected award amount is '.$rule_dtls['award_value'].'.</b></span></div>');
                                         $rdata=array(
                                                                "status" => "failed",
                                                                "statusCode" => 301,
                                                                "message"=>'Your available amount ('.$manager_available_budget.') is insufficient, Selected award amount is '.$rule_dtls['award_value'],
                                                                
                                                                );
					
				}
			}
                        $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    public function employee($empID)
    {
        $rr=$this->rnr_rule_model->getRules(array('rnr_rules.user_ids'=>$empID));
        echo '<pre />';
        print_r($rr);
    }
   
}
