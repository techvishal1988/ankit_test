<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Team extends REST_Controller {
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
        $this->load->model('api/performance_cycle_model');
        
        if($this->token!='' && $this->authname!='' )
        {
            $this->manager_model->setdb($this->authname);
            $this->bonus_model->setdb($this->authname);
            $this->performance_cycle_model->setdb($this->authname);
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
    
    public function rules_get()
    {
                $current_dt = date("Y-m-d");
                $salary_rule_list=$this->performance_cycle_model->get_salary_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter.status>="=>6,'hr_parameter.status !='=>8));
                $rule_list=[];
                 foreach($salary_rule_list as $emps)
                 {
                     $ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids'], $this->email);
                     if(count($ids)>0)
                     {
                        $rule_list[]=$emps;
                     }
                 }
                $employee = array();
                 foreach($rule_list as $k => $r)
                 {
                     $staff_list = $this->manager_model->list_of_manager_emps_for_increment($r['id'],$this->email);
		    $temp_arr = array();
                    if($staff_list)
                    {
                            $self_usrs_arr = array();
                            $other_usrs_arr = array();
                            foreach($staff_list as $row)
                            {
                                    if(strtoupper($row["last_action_by"]) == strtoupper($this->email))
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
                    //$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
                    //echo '<pre />';print_r($temp_arr);
                     $r['employee']=$temp_arr;
                     $employee[] = $r;
                 }
                 
                  $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$employee
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    public function increments_get($rule_id)
        {           
                $email=$this->email;
                $data['msg'] = "";		
		$data["staff_list"] = $this->manager_model->list_of_manager_emps_for_increment($rule_id,$email);	
                $data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");	
                //echo '<pre />';
                //print_r($data["staff_list"]);
                 $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data["staff_list"]
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
		
		
		
    }
    public function employees_get()
	{
	$data["staff_list"] = $this->manager_model->list_of_manager_emps($this->email);	
        $rdata=array(
                "status" => "success",
                "statusCode" => 200,
                "data" =>$data["staff_list"]
                );
        $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
    public function employeeincrement_get($rule_id, $user_id, $upload_id)
	{	
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id);//echo "<pre>";print_r($data['user_salary_graph_dtls']);die;
		$data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id, $upload_id,"market_salary");
		$data['peer_salary_graph_dtls'] = $this->rule_model->get_peer_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);
		$data['team_salary_graph_dtls'] = $this->rule_model->get_team_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id, $data["rule_dtls"]["user_ids"]);		
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
                $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>array(
                                'salary_dtls'=>$data['salary_dtls'],
                                'usersalarygraph'=>$data['user_salary_graph_dtls'],
                                'marketsalarygraph'=>$data['makt_salary_graph_dtls'],
                                'peersalarygraph'=>$data['peer_salary_graph_dtls'],
                                'teamsalarygraphdtls'=>$data['team_salary_graph_dtls'],
                            )
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
			
	}
    public function bonuslist_get($ruleID)
	{
                $employee=[];
                 
                    $staff_list = $this->manager_model->list_of_manager_emps_for_bonus_increment($ruleID,$this->email);
		    $temp_arr = array();
                    if($staff_list)
                    {
                            $self_usrs_arr = array();
                            $other_usrs_arr = array();
                            foreach($staff_list as $row)
                            {
                                    if(strtoupper($row["last_action_by"]) == strtoupper($this->email))
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
                    //echo '<pre />';print_r($temp_arr);
                     $r['employee']=$temp_arr;
                     $employee[] = $r;
                 
                 $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$employee
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK); 
		
	}
    public function empbonusdtl_get($rule_id, $user_id, $upload_id)
	{	
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		$data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
                $data['manager_staf_list'] = $this->manager_model->list_of_manager_emps_for_increment($this->email);
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
                
                        $arr=[];
                        foreach($data['manager_staf_list'] as $msl)
                        {
                            array_push($arr,$this->searchForId($msl['id'],$data['manager_staf_list']));
                        }
                        
                 
                $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data['bonus_dtls']/*array(
                                //'stafflist'=>$arr,
                                //'managerstaflist'=>$data['manager_staf_list'],
                               // 'bonusdtls'=>$data['bonus_dtls'],
                               
                                
                            )*/
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
                
		
		
	}
    public function searchForId($id, $array) 
        {
            foreach ($array as $key => $val) {
                if ($val['id'] === $id) {
                    return $array[$key];
                }
            }
            return null;
         }
    public function managerdiscretions_post()
	{
               
		$id = trim($this->post("empsalid"));
		$new_per = trim($this->post("percentage"));
                if($this->post('empsalid')=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee salary ID is missing"));
                        return; 

                    }
                if($this->post('percentage')=='')
                    {
                        header("HTTP/1.0 301 employee salary percentage is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee salary percentage is missing"));
                        return; 

                    }    
		if($id > 0 and $new_per > 0)
		{
			//$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status"=>1));
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "employee_salary_details.manager_emailid" => $this->email, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				$manager_max_incr_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]+$salary_dtls["Manager_discretionary_increase"];
				$manager_max_dec_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]-$salary_dtls["Manager_discretionary_decrease"];

				if($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per)
				{
					$max_hike = $salary_dtls["max_hike"];
					if($salary_dtls["recently_promoted"]=="Yes")
					{
						$max_hike = $salary_dtls["recently_promoted_max_hike"];
					}
					
					if($max_hike >= ($new_per + $salary_dtls["sp_manager_discretions"]))
					{					
						$manager_emps_total_budget = 0;
						$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_budget($salary_dtls["rule_id"], $salary_dtls["upload_id"], $salary_dtls["user_ids"], $salary_dtls["first_approver"]);

						if($manager_emps_total_budget_arr)
						{
							$manager_emps_total_budget = $manager_emps_total_budget_arr["increased_salary"];
						}
						
						$manager_emps_total_budget = $manager_emps_total_budget - ($salary_dtls["final_salary"] - $salary_dtls["increment_applied_on_salary"]);
						$total_max_budget = 0;
						$budget_percent_incr =0;

						//if($salary_dtls["overall_budget"] == "Manual")
						//{
							$managers_arr = json_decode($salary_dtls['manual_budget_dtls'],true);
							foreach($managers_arr as $key => $value)
							{
								if(strtoupper($this->email) == strtoupper($value[0])) 
								{
									$total_max_budget = $value[1] + (($value[1]*$value[2])/100); //$value[1];
								}
							}

						//}

						$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
						$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + $salary_dtls["sp_increased_salary"] + $increased_salary;

						if($total_max_budget >= ($manager_emps_total_budget + $increased_salary))
						{
							$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "manager_discretions"=>$new_per,"updatedby" =>$this->email, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->email), array("id"=>$id));

							$revised_comparative_ratio = 0;
							if($salary_dtls["market_salary"])
							{
								$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
							}
							
							$response =array("status"=>"Success",'statusCode'=>200,"message"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>round($revised_comparative_ratio));
							
						}
						else
						{
							$response =array("status"=>"Failed",'statusCode'=>301,"message"=>"Exceed your budget by allotted budget.", "final_updated_salary"=>0, "increased_salary"=>0,
								"revised_comparative_ratio"=>0);
							
						}					
						//echo "<pre>";print_r($salary_dtls);die;
					
					}
					else
					{
						$response =array("status"=>'Failed','statusCode'=>301,"message"=>"Increase percentage out of your max hike.", "updated_salary"=>0);
						
					}
				}
				else
				{
					$response =array("status"=>"Failed",'statusCode'=>301,"message"=>"Increase/decrease percentage out of your limit.", "updated_salary"=>0);
					
				}
			}
			else
			{
				echo "";
			}
		}
		else
		{
			$response =array("status"=>'Failed', 'statusCode'=>301,"message"=>"Percentage can not be 0.", "updated_salary"=>0);
		}
               
                $this->set_response($response, REST_Controller::HTTP_OK); 
	}     
    public function promotion_post($emp_salary_dtl_id)
	{
		$new_per = trim($this->post("percentage"));
		$new_desig = trim($this->post("newdesignation"));
		$new_citation = trim($this->post("citation"));
		$err_msg = "";
                if($emp_salary_dtl_id=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee salary ID is missing"));
                        return; 

                    }
                if($this->post('percentage')=='')
                    {
                        header("HTTP/1.0 301 employee salary percentage is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee salary percentage is missing"));
                        return; 

                    }   
                    if($this->post('citation')=='')
                    {
                        header("HTTP/1.0 301 employee citation is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee citation is missing"));
                        return; 

                    }   
                    if($this->post('newdesignation')=='')
                    {
                        header("HTTP/1.0 301 employee new designation is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee new designation is missing"));
                        return; 

                    }   
		if($new_per > 0 and $new_desig != "")
		{
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.manager_emailid" => $this->email, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				/*$max_per = $salary_dtls["standard_promotion_increase"] + $salary_dtls["sp_manager_discretionary_increase"];
				$min_per = $salary_dtls["standard_promotion_increase"] - $salary_dtls["sp_manager_discretionary_decrease"];

				if($max_per >= $new_per and $new_per >= $min_per)*/
				
				$max_hike = $salary_dtls["max_hike"];
				if($salary_dtls["recently_promoted"]=="Yes")
				{
					$max_hike = $salary_dtls["recently_promoted_max_hike"];
				}
				if($max_hike >= ($new_per + $salary_dtls["manager_discretions"]))
				{
					/*$manager_emps_total_budget = 0;
					$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_budget($salary_dtls["rule_id"], $salary_dtls["upload_id"], $salary_dtls["user_ids"], $salary_dtls["first_approver"]);

					if($manager_emps_total_budget_arr)
					{
						$manager_emps_total_budget = $manager_emps_total_budget_arr["final_salary"];
					}
					
					$manager_emps_total_budget = $manager_emps_total_budget - $salary_dtls["final_salary"];
					$total_max_budget = 0;//$salary_dtls["budget_amount"];
					$budget_percent_incr =0;// $salary_dtls["budget_percent"];

					$managers_arr = json_decode($salary_dtls['manual_budget_dtls'],true);
					foreach($managers_arr as $key => $value)
					{
						if(strtoupper($this->session->userdata('email_ses')) == strtoupper($value[0])) 
						{
							$total_max_budget = $value[1];
							$budget_percent_incr = $value[2];
						}
					}*/

					$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
					$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + (($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"])/100) + $increased_salary;

					/*if($total_max_budget >= ($manager_emps_total_budget + $increased_salary))
					{*/
						$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "sp_increased_salary" => $increased_salary, "emp_new_designation"=>$new_desig, "sp_manager_discretions"=>$new_per, "emp_citation"=>$new_citation,"updatedby" =>$this->email, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->email), array("id"=>$emp_salary_dtl_id));

					$revised_comparative_ratio = 0;
					if($salary_dtls["market_salary"])
					{
						$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
					}
						
						$response =array("status"=>"Success","message"=>"Ok","statusCode" => 200, "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>round($revised_comparative_ratio));
						
					/*}
					else
					{
						$err_msg = "Exceed your budget by allotted budget.";
					}	*/
				}
				else
				{
					$response = array('statusCode'=>301,"status"=>"failed",'message'=>"Increase percentage out of your max hike");
				}				
			}
			else
			{
                                $response = array('statusCode'=>301,"status"=>"failed",'message'=>"Salary detail ID not found");
				
			}
		}
		else
		{
			$response = array('statusCode'=>301,"status"=>"failed",'message'=>"Designation is required.","updated_salary"=>0);
		}

		
		$this->set_response($response, REST_Controller::HTTP_OK); 
	}    
    public function removepromotion_post()
	{
		$err_msg = "";
                $emp_salary_dtl_id=$this->post('empsalid');
                 if($emp_salary_dtl_id=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee salary ID is missing"));
                        return; 

                    }
		if($emp_salary_dtl_id > 0)
		{
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.manager_emailid" => $this->email, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + (($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"])/100);

				$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "sp_increased_salary" => 0, "emp_new_designation"=>"", "sp_manager_discretions"=>0, "emp_citation"=>"","updatedby" =>$this->email, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->email), array("id"=>$emp_salary_dtl_id));

					$revised_comparative_ratio = 0;
					if($salary_dtls["market_salary"])
					{
						$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
					}				
				
				$response =array("status"=>"Success","statusCode" => 200,"message"=>"Success", "updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "revised_comparative_ratio"=>round($revised_comparative_ratio));
				
			}
			else
			{
				$response = array("status"=>"faiiled","statusCode" => 301,"message"=>"Invalid request.","updated_salary"=>0,"revised_comparative_ratio"=>0);
			}
		}
		else
		{
			$response = array("status"=>"failed","statusCode" => 301,"message"=>"Invalid request.","updated_salary"=>0,"revised_comparative_ratio"=>0);
		}

		
		$this->set_response($response, REST_Controller::HTTP_OK); 
	}
    public function bonusrules_get()
    {
                $current_dt = date("Y-m-d");
                $salary_rule_list=$this->performance_cycle_model->get_bonus_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "hr_parameter_bonus.status>="=>6,"hr_parameter_bonus.status!=">8));
                $rlist=[];
                foreach($salary_rule_list as $emps)
                 {
                     $ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids'],$this->email);
                     if(count($ids)>0)
                     {
                        $rlist[]=$emps;
                     }
                 }
                 $employee=[];
                 foreach($rlist as $r)
                 {
                    $staff_list = $this->manager_model->list_of_manager_emps_for_bonus_increment($r['id'],$this->email);
		    $temp_arr = array();
                    if($staff_list)
                    {
                            $self_usrs_arr = array();
                            $other_usrs_arr = array();
                            foreach($staff_list as $row)
                            {
                                    if(strtoupper($row["last_action_by"]) == strtoupper($this->email))
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
                    //echo '<pre />';print_r($temp_arr);
                     $r['employee']=$temp_arr;
                     $employee[] = $r;
                 }
                 $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$employee
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);  
                
        }
        
    public function employeebonus_post()
	{
		$id = trim($this->post("empbonusid"));
		$new_val = trim($this->post("newval"));
		$type = trim($this->post("type"));
                    if($id=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee bonus ID is missing"));
                        return; 

                    }
                    if($new_val=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Employee bonus value is missing"));
                        return; 

                    }
                    if($type=='')
                    {
                        header("HTTP/1.0 301 employee salary ID is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Type is missing"));
                        return; 

                    }
		if($id > 0 and $new_val > 0 and $type > 0)
		{
			$bonus_dtls = $this->manager_model->get_employee_bonus_dtls_for_manager_discretions(array("employee_bonus_details.id"=>$id, "employee_bonus_details.manager_emailid" => $this->email, "hr_parameter_bonus.status"=>6, "employee_bonus_details.status <"=>5));
			if($bonus_dtls)
			{	
				if($type == 2)
				{
					$increased_bonus = $bonus_dtls["target_bonus"]*$new_val/100;
					$new_per = $new_val;
				}
				else
				{
					$increased_bonus = $new_val;
					$new_per = ($new_val/$bonus_dtls["target_bonus"])*100;
				}
							
				$manager_max_incr_per = $bonus_dtls["individual_achievement"]+$bonus_dtls["manager_discretionary_increase"];
				$manager_max_dec_per = $bonus_dtls["actual_bonus_per"]-$bonus_dtls["manager_discretionary_decrease"];

				if($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per)
				{
					$manager_emps_total_budget = 0;
					$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_bonus_budget($bonus_dtls["rule_id"], $bonus_dtls["upload_id"], $bonus_dtls["user_ids"], $bonus_dtls["first_approver"]);

					if($manager_emps_total_budget_arr)
					{
						$manager_emps_total_budget = $manager_emps_total_budget_arr["final_bonus"];
					}
					
					$manager_emps_total_budget = $manager_emps_total_budget - $bonus_dtls["final_bonus"];
					$total_max_budget = 0;
					$budget_percent_incr =0;

					//if($bonus_dtls["overall_budget"] == "Manual")
					//{
						$managers_arr = json_decode($bonus_dtls['manual_budget_dtls'],true);
						foreach($managers_arr as $key => $value)
						{
							if(strtoupper($this->email) == strtoupper($value[0])) 
							{
								$total_max_budget = $value[1];
								$budget_percent_incr = $value[2];
							}
						}

					//}
					
					
					
					//$final_increased_bonus = $bonus_dtls["target_bonus"] + $increased_bonus;

					if($total_max_budget >= ($manager_emps_total_budget + $increased_bonus))
					{
						$this->manager_model->update_tbl_data("employee_bonus_details", array("final_bonus"=>$increased_bonus, "final_bonus_per"=>$new_per,"updatedby" =>$this->id, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->id), array("id"=>$id));

						$response =array("status"=>"Success","statusCode" => 200,"message"=>"success", "new_per"=>round($new_per), "increased_bonus"=>$increased_bonus);
						
					}
					else
					{
						$response =array("status"=>"failed","statusCode" => 301,"message"=>"Exceed your budget by allotted budget.", "new_per"=>0, "increased_bonus"=>0);
						
					}					
					//echo "<pre>";print_r($salary_dtls);die;
				}
				else
				{
					$response =array("status"=>"failed","statusCode" => 301,"message"=>"Increase/decrease percentage out of your limit.", "new_per"=>0, "increased_bonus"=>0);
					
				}
			}
			else
			{
				echo "";
			}
		}
		else
		{
			echo "";
		}
                
             $this->set_response($response, REST_Controller::HTTP_OK);    
	}    
}
