<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Employee extends REST_Controller {
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
        $this->load->model('api/lti_rule_model');
        $this->load->model('api/template_model');
        
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
    function salary_get($rule_id='', $user_id='', $upload_id='')
    {	
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
                $end=end($data["salary_cycles_list"]);
                $data["salary_rule_list"] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$end['id']));
                $data['rule_id']=$data["salary_rule_list"][0]['id'];
                $data['staff_list'] = $this->rule_model->get_rule_wise_emp_list_for_increments($data["salary_rule_list"][0]['id']);
                $rule_id='';
                foreach($data['staff_list'] as $msl)
                        {
                            if($msl['id']==$this->id)
                            {
                               $user_id=$msl['id'];
                               $upload_id=$msl['upload_id'];
                               $rule_id=$data["salary_rule_list"][0]['id'];
                            }

                        } 
                        if($rule_id=='')
                        {
                           $rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
                        }
                    else {
                            
                            $data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
                            $data['user_salary_graph_dtls'] = $this->rule_model->get_employee_salary_dtls_for_graph($rule_id, $user_id, $upload_id);
                            $data['makt_salary_graph_dtls'] = $this->rule_model->get_employee_market_salary_dtls_for_graph($rule_id, $user_id, $upload_id);
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
                    }
                    
                $this->set_response($rdata, REST_Controller::HTTP_OK);
	}
    
    function bonus_get()
    {
        $data["bonus_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID));
        $end=end($data["bonus_cycles_list"]);
        $data['rule_id']=@$data["bonus_cycles_list"][0]['id'];
        $data["bonus_rule_list"] = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$end['id']));
        $data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($data["bonus_rule_list"][0]['id']);
        $ruleID='';
        foreach($data['staff_list'] as $msl)
                {
                    if($msl['id']==$this->id)
                    {
                       $userId=$msl['id'];
                       $uploadID=$msl['upload_id'];
                       $ruleID=$data["bonus_rule_list"][0]['id'];
                    }

                } 
                if($ruleID=='')
                {
                   $rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
                }
                else
                {
                    //echo 'href="'.('employee/dashboard/view_employee_bonus_increment_dtls/').$ruleID.'/'.$userId.'/'.$uploadID.'"';
                    $data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$ruleID));
                    $data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($ruleID);
                    $data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$ruleID, "employee_bonus_details.user_id"=>$userId));
                    $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data"=>array(
                                "rule_dtls"=>$data["rule_dtls"],
                                "bonus_dtls"=>$data['bonus_dtls']
                            )
                            );
                
                }
                $this->set_response($rdata, REST_Controller::HTTP_OK);
        }
    
    function rnr_get()
    {
        $data['emp_details'] = $this->rule_model->get_table_row("login_user","id, name, email, (select name from manage_designation where id = login_user.desig) as designation, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type", array("id"=>$this->id));
	$data["emp_rnr_history"] = $this->manager_model->get_emp_rnr_history(array("proposed_rnr_dtls.user_id"=>$this->id, "proposed_rnr_dtls.status <"=>3));

            if(count($data["emp_rnr_history"])==0)
            {
                $rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
            }
            else {
                $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data"=>array(
                                "Employee_dtls"=>$data['emp_details'],
                                "rnr_history"=>$data["emp_rnr_history"],
                                
                            ),
                            );
            }
            
            $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    function lti_get()
    {
        $lti_dtls = $this->rule_model->get_table_row("employee_lti_details", "employee_lti_details.*, (select upload_id from login_user where login_user.id = employee_lti_details.user_id) as upload_id", array("status"=>5, "user_id"=>$this->id), "id desc");
//		echo '<pre />';
//                print_r($lti_dtls); die;
             if(count($lti_dtls)==0)
             {
                 $rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
                 
             }
             else {
                 $rule_id=$lti_dtls['rule_id'];
             $user_id=$lti_dtls['user_id'];
             $upload_id=$lti_dtls['upload_id'];
		$data["rule_dtls"] = $this->lti_rule_model->get_rule_dtls_for_performance_cycles(array("lti_rules.id"=>$rule_id));
		if(!$data['rule_dtls']  or $data['rule_dtls']["status"] < 4)
		{
			$rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
		}	

		$data['staff_list'] = $this->lti_rule_model->get_rule_wise_emp_list_for_incentives($rule_id);	
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
//                print_r($vesting_arr); die;
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
                 $vesting2=[
                    'percentageOfVesting'=>$v2_per,
                    'Amount'=>$val,
                ];
                $val = $this->get_share_or_amtount_for_lti_vestings($data['emp_lti_dtls']["final_incentive"], $v2_per, 2, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $data['rule_dtls']["lti_linked_with"]);
                $total_incentive_befor_last += $val;
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
             }
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
    function latestsalaryreview_get()
    {
                $user_id=$this->id;
                $users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$user_id), "id desc");
               $data['attr']=$this->template_model->getAttr($users_last_tuple_dtls['row_num'],$users_last_tuple_dtls['data_upload_id']);
//                echo '<pre />';
//                print_r($data['attr']);
                if(count($data['attr'])==0)
                {
                    $rdata=array(
                            "status" => "failed",
                            "statusCode" => 301,
                            "message"=>"You have not came in any rule."
                            );
                }
                else {
                    $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data"=> $data['attr']
                            );
                }
                $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    function compensetion_get()
    {
        $uid=$this->id;
        $data['salary_rule_list']=$this->template_model->mysalaryrule('hr_parameter','FIND_IN_SET('.$uid.',user_ids) and status=7');
        $data['bonus']=$this->template_model->mysalaryrule('hr_parameter_bonus','FIND_IN_SET('.$uid.',user_ids) and status=7');
        $data['lti']=$this->template_model->mysalaryrule('lti_rules','FIND_IN_SET('.$uid.',user_ids) and status=7');
         $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data"=> array(
                                "salary_rules"=>$data['salary_rule_list'],
                                "bonus_rules"=>$data['bonus'],
                                "lti"=>$data['lti'],
                                
                                )
                            );
         $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    public function view_get($ruleID,$cycleID,$templateID)
        {
                $data['ruleID']=$ruleID;
                $data['cycleID']=$cycleID;
                $data['templateID']=$templateID;
                $data['latterhead']=$this->template_model->getLatterHead();
                $data['salary']=$this->template_model->mysalaryrule('hr_parameter','id='.$ruleID.'  and performance_cycle_id='.$cycleID);
                $data['bonus']=$this->template_model->mysalaryrule('hr_parameter_bonus','id='.$ruleID.'  and performance_cycle_id='.$cycleID);
                $data['lti']=$this->template_model->mysalaryrule('lti_rules','id='.$ruleID.'  and performance_cycle_id='.$cycleID);
                $uid=$this->id;
                $data['staff_list'] = $this->template_model->get_data('login_user','id='.$uid);
                $data['templatedesc']=$this->template_model->getTemplate($templateID);
                
                $page=$data['templatedesc'][0]->TemplateDesc;
                $staff_list=GetEmpAllDataFromEmpsal($data['staff_list']);
                $emmpinfo=getempdesc($staff_list,$staff_list[0]['id']); 

                $page = str_replace("{{employee_name}}",@$emmpinfo['name'],$page);
                $page = str_replace("{{email}}",@$emmpinfo['email'],$page);
                $page = str_replace("{{employee_function}}",@$emmpinfo['function'],$page);
                $page = str_replace("{{business_unit}}",@$emmpinfo['business_unit_3'],$page);
                $page = str_replace("{{employee_title}}",@$emmpinfo['desig'],$page);
                $page = str_replace("{{salary_increase}}",@$emmpinfo['Salary after last increase'],$page);
                $page = str_replace("{{new_base_salary}}",@$emmpinfo['crr_based_salary'],$page);
                $page = str_replace("{{new_target_bonus}}",@$emmpinfo['target_bonus'],$page);
                $page = str_replace("{{long_term_incentive_allocated}}",@$emmpinfo['final_incentive'],$page);
                $page = str_replace("{{target_lti_amount}}",@$emmpinfo['actual_incentive'],$page);
                $page = str_replace("{{bonus_payout}}",@$emmpinfo['Current target bonus'],$page);
                $page = str_replace("{{new_target_bonus}}",@$emmpinfo['final_bonus_per'],$page);
                $page = str_replace("{{vesting_table}}",@$emmpinfo['target_lti_dtls'],$page);
                $page = str_replace("{{target_lti}}",@$emmpinfo['actual_incentive'],$page);
                $page = str_replace("{{target_bonus_for_current_year}}",@$emmpinfo['target_bonus'],$page);
                $page = str_replace("{{bonus_amount_for_current_year}}",@$emmpinfo['final_bonus_per'],$page);
                $page = str_replace("{{salary_review}}",@$emmpinfo['crr_based_salary'],$page);
                $page = str_replace("{{bonus_multiplier_allocated}}",((@$emmpinfo['individual_weightage']*@$emmpinfo['individual_achievement'])+(@$emmpinfo['bl_3_weightage']*@$emmpinfo['bl_3_achievement'])+(@$emmpinfo['bl_2_weightage']*@$emmpinfo['bl_2_achievement'])+(@$emmpinfo['bl_1_weightage']*@$emmpinfo['bl_1_achievement'])+(@$emmpinfo['function_weightage']*@$emmpinfo['function_achievement'])),$page);

                //echo $page;
                $data['latterhead'][0]->latter_head_url;
                $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data"=> array(
                                "Background_url"=>$data['latterhead'][0]->latter_head_url,
                                "content"=>$page,
                                
                                
                                )
                            );
         $this->set_response($rdata, REST_Controller::HTTP_OK);
		
               
                   
                 
        }
}
