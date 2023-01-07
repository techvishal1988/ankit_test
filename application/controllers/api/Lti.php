<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Lti extends REST_Controller {
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
        $this->load->model('api/lti_rule_model');
        $this->load->model('api/performance_cycle_model');
        
        if($this->token!='' && $this->authname!='' )
        {
            $this->manager_model->setdb($this->authname);
            $this->bonus_model->setdb($this->authname);
            $this->lti_rule_model->setdb($this->authname);
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
		//$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		$data['staff_list'] = $this->lti_rule_model->list_of_manager_emps_for_lti_increment($this->email);
                //print_r($data['staff_list']);
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
                 $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data["staff_list"]
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
    public function rules_get()
        {
            	$current_dt = date("Y-m-d");
                $salary_rule_list=$this->performance_cycle_model->get_lti_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "lti_rules.status>="=>6,"lti_rules.status!=">8));
                $rules=[];
                $employee=[];
                foreach($salary_rule_list as $emps)
                 {
                     $ids=$this->manager_model->checkManagerEmpinRule($emps['user_ids'],$this->email);
                     if(count($ids)>0)
                     {
                        $rules[]=$emps;
                     }
                 }
                 foreach($rules as $r)
                 {
                      $staff_list = $this->manager_model->list_of_manager_emps_for_lti_incentives($r['id'],$this->email);
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
    public function detail_get($rule_id, $user_id, $upload_id)
	{	
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		$data['is_open_frm_manager_side'] = "1";
		$cdt = date("Y-m-d");		
		$data['emp_lti_dtls'] = $this->lti_rule_model->get_emp_lti_dtls(array("employee_lti_details.rule_id"=>$rule_id, "employee_lti_details.user_id"=>$user_id));
		$data['index_for_vesting'] = 0;
		$business_attribute_id=0;
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
		$emp_target_lti_on_val = $emp_target_lti_on_arr['value'];
		
		$target_lti_elem_arr = json_decode($data["rule_dtls"]["target_lti_elem"],true);
		
		foreach ($target_lti_elem_arr as $key => $value) 
		{
			$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
			if(($emp_target_lti_on_val) and strtoupper($val_arr[1]) == strtoupper($emp_target_lti_on_val))
			{
				if($data["rule_dtls"]["lti_linked_with"]=="Stock Value")
				{
					$index_for_vesting = $key+1;
				}
				else
				{
					$index_for_vesting = $key;
				}
				break;
			}
		}
                $vesting_arr=json_decode($data["rule_dtls"]["target_lti_dtls"]);
//                echo '<pre />';
//                print_r($vesting_arr); 
                $last_not_null_vesting_index = 0;
                $total_incentive_befor_last = 0;
                if($vesting_arr[1]->vesting_1_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 1;
                }
                if($vesting_arr[2]->vesting_2_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 2;
                }
                if($vesting_arr[3]->vesting_3_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 3;
                }
                if($vesting_arr[4]->vesting_4_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 4;
                }
                if($vesting_arr[5]->vesting_5_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 5;
                }
                if($vesting_arr[6]->vesting_6_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 6;
                }
                if($vesting_arr[7]->vesting_7_arr[$index_for_vesting]>0)
                {
                        $last_not_null_vesting_index = 7;
                }
                $stock_share_price = $vesting_arr[0]->grant_value_arr[0];
                
                
                
                $v1_per = 0; 
                if($vesting_arr[1]->vesting_1_arr[$index_for_vesting])
                { $v1_per = $vesting_arr[1]->vesting_1_arr[$index_for_vesting];}
                $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v1_per, 1, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                $total_incentive_befor_last += $val;
                $vesting1=[
                    'percentageOfVesting'=>$v1_per,
                    'Amount'=>$val,
                ];
                
                
                
                $v2_per = 0; 
                if($vesting_arr[2]->vesting_2_arr[$index_for_vesting])
                 { $v2_per = $vesting_arr[2]->vesting_2_arr[$index_for_vesting];}
                 $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v2_per, 2, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                $total_incentive_befor_last += $val;
                 $vesting2=[
                    'percentageOfVesting'=>$v2_per,
                    'Amount'=>$val,
                ];
                
                
                
                
                $v3_per = 0; 
                 if($vesting_arr[3]->vesting_3_arr[$index_for_vesting])
                     { $v3_per = $vesting_arr[3]->vesting_3_arr[$index_for_vesting];}
		$val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v3_per, 3, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                    $total_incentive_befor_last += $val;
                $vesting3=[
                    'percentageOfVesting'=>$v3_per,
                    'Amount'=>$val,
                ];
                
                
                
                
                $v4_per = 0; 
                if($vesting_arr[4]->vesting_4_arr[$index_for_vesting])
                { $v4_per = $vesting_arr[4]->vesting_4_arr[$index_for_vesting];}
                           
                $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v4_per, 4, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                $total_incentive_befor_last += $val;
                
                 $vesting4=[
                    'percentageOfVesting'=>$v4_per,
                    'Amount'=>$val,
                ];
                 
                 
                 $v5_per = 0; 
                    if($vesting_arr[5]->vesting_5_arr[$index_for_vesting])
                    { $v5_per = $vesting_arr[5]->vesting_5_arr[$index_for_vesting];}
                    
                    
                    $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v5_per, 5, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                        $total_incentive_befor_last += $val;
                    
                 $vesting5=[
                    'percentageOfVesting'=>$v5_per,
                    'Amount'=>$val,
                ];
                 
                 
                 $v6_per = 0; 
                if($vesting_arr[6]->vesting_6_arr[$index_for_vesting])
                    { $v6_per = $vesting_arr[6]->vesting_6_arr[$index_for_vesting];}
                    
                    $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v6_per, 6, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                            $total_incentive_befor_last += $val;
                            
                $vesting6=[
                    'percentageOfVesting'=>$v6_per,
                    'Amount'=>$val,
                ];          
                
                
                $v7_per = 0; 
                if($vesting_arr[7]->vesting_7_arr[$index_for_vesting])
                { $v7_per = $vesting_arr[7]->vesting_7_arr[$index_for_vesting];}
                
                $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v7_per, 7, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                $total_incentive_befor_last += $val;
               
                
                $vesting7=[
                    'percentageOfVesting'=>$v7_per,
                    'Amount'=>$val,
                ]; 
                
                $data['vesting']=[
                    "vesting1"=>$vesting1,
                    "vesting2"=>$vesting2,
                    "vesting3"=>$vesting3,
                    "vesting4"=>$vesting4,
                    "vesting5"=>$vesting5,
                    "vesting6"=>$vesting6,
                    "vesting7"=>$vesting7,
                ];
		$rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" => $data,
                     );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
	} 
    function get_share_or_amtount_for_lti_vestings($incentive, $per, $current_index, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $lti_linked_with)
        {
                    if($lti_linked_with=="Stock Value")
                    {
                            if($current_index == $last_not_null_vesting_index)
                            {
                                    return round(($incentive/$stock_share_price) - $total_incentive_befor_last);
                            }
                            $vest_amt = ($incentive*$per)/100;
                            return round($vest_amt/$stock_share_price);
                    }
                    else
                    {
                            if($current_index == $last_not_null_vesting_index)
                            {
                                    return round($incentive - $total_incentive_befor_last);
                            }
                            return round(($incentive*$per)/100);
                    }	
            }   
    function update_post()
    {
        if($this->post("txt_target_lti_amt") and $this->post("txt_target_lti_amt") > 0 and $this->post("hf_emp_lti_id") > 0)
		{
			$usr_lti_dtls = $this->manager_model->get_employee_lti_dtls_for_manager_discretions(array("employee_lti_details.id"=>$this->post("hf_emp_lti_id"), "employee_lti_details.manager_emailid" => $this->email, "lti_rules.status"=>6, "employee_lti_details.status <"=>5));
			
			if(!empty($usr_lti_dtls) and strtolower($usr_lti_dtls["manager_emailid"]) == strtolower($this->email))
			{
				$usr_lti_req_amt = $this->post("txt_target_lti_amt");
				
				$manager_max_incr_amt = $usr_lti_dtls["actual_incentive"] + ($usr_lti_dtls["actual_incentive"]*$usr_lti_dtls["manager_discretionary_increase"])/100;
				$manager_max_dec_amt = $usr_lti_dtls["actual_incentive"] - ($usr_lti_dtls["actual_incentive"]*$usr_lti_dtls["manager_discretionary_decrease"])/100;
				
				if($manager_max_incr_amt >= $usr_lti_req_amt and $manager_max_dec_amt <= $usr_lti_req_amt)
				{
					$manager_emps_total_budget = 0;
					$manager_emps_total_budget_for_msg = 0;
					$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_lti_budget($usr_lti_dtls["rule_id"], $usr_lti_dtls["upload_id"], $usr_lti_dtls["user_ids"], $usr_lti_dtls["first_approver"]);

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
						if(strtoupper($this->email) == strtoupper($value[0])) 
						{
							$total_max_budget = round($value[1] + (($value[1]*$value[2])/100));
						}
					}

					if($total_max_budget >= ($manager_emps_total_budget + $usr_lti_req_amt))
					{
						$this->manager_model->update_tbl_data("employee_lti_details", array("final_incentive"=>$usr_lti_req_amt, "updatedby" =>$this->session->userdata('userid_ses'), "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->email), array("id"=>$this->post("hf_emp_lti_id")));
						//$this->session->set_flashdata('message', '<div align="left" style="color:blue;" id="notify"><span><b>Data successfully updated.</b></span></div>');
                                                $rdata=array(
                                                "status" => "success",
                                                "statusCode" => 200,
                                                "message" =>'Data successfully updated.'
                                                );
					}
					else
					{
						//$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Exceed your budget by allotted budget.</b></span></div>');
						//$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Exceed your budget by allotted budget. You have only left '. ($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.</b></span></div>');
                                                $rdata=array(
                                                "status" => "failed",
                                                "statusCode" => 301,
                                                "message" =>'Exceed your budget by allotted budget. You have only left '. ($total_max_budget - $manager_emps_total_budget_for_msg) .' amount of budget.'
                                                );
					}
				}
				else
				{
					//$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Increase/decrease amount out of your limit.</b></span></div>');					
                                        $rdata=array(
                                                "status" => "failed",
                                                "statusCode" => 301,
                                                "message" =>'Increase/decrease amount out of your limit'
                                                );
                                        
				}
				
			}
		}
                
                $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
   
}
