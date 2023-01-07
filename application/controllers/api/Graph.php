<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Graph extends REST_Controller {
   
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->library('session', 'encrypt');			
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');  
        $this->load->model('Report_model');
        $this->load->model('performance_cycle_model');
        $this->load->model('api/rule_model');
        $this->load->model('admin_model');
        $this->load->model('Survey_model');
    }
	
    public function index_get()
	{
		$grade= $this->Report_model->grade();
		$lvl= $this->Report_model->level();
		$designation= $this->Report_model->designation();
		$arr=[
				'grade'=>$grade,
				'level'=>$lvl,
				'degignation'=>$designation
			 ];
		$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$arr
					);
		$this->set_response($rdata, REST_Controller::HTTP_OK);
	}


    public function report_get($rpt_for_active = "1", $cond = 0, $report_name = 'headcount')
    {
		//$rpt_for_active =1 Meand want to get active user data and other case want to inactive users data
		if($rpt_for_active != "1")
		{
			$rpt_for_active = 0;
		}
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "login_user.status = ".$rpt_for_active;		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr .= " AND login_user.id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr .= " AND login_user.id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
				
		if($this->session->userdata('keyword'))
		{
			if($arr)
			{
				$arr .= " AND ";
			}
			$arr .= "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}

		$data['keyword'] =	$this->session->userdata('keyword');
		$this->session->unset_userdata('keyword');

		if($cond) {//new code

			$attributes =  $this->admin_model->staff_attributes_for_export();

			//if required other attribute then add attribute name in below array, now only required these values
			$required_attributes_array = array('country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function',
			'subfunction', 'designation', 'grade', 'level', 'gender', 'company_joining_date', 'sub_subfunction', 'education', 'critical_talent', 'critical_position', 'special_category',
			 'urban_rural_classification');//'employee_code', 'name', 'email', 

			if($report_name == 'successor-readyness') {

				array_push($required_attributes_array, 'readyness_level');

			} else if ($report_name == 'identified') {

				array_push($required_attributes_array, 'successor_identified');

			} else if ($report_name == 'potential') {

				array_push($required_attributes_array, 'engagement_level');

			}

			if ($report_name != 'potential') {

				array_push($required_attributes_array, 'rating_for_current_year');//not req in potential report

			}
			//'increment_purpose_joining_date','approver_1', 'manager_name', 'currency', 'current_base_salary','current_target_bonus', 'total_compensation',

			//if required other attribute then add attribute name in below array, now only required these values
			$manage_table_fields_array = array('country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function', 'subfunction', 'designation', 'grade', 
			'level', 'rating_for_current_year' ,'education', 'critical_talent', 'critical_position', 'special_category', 'currency', 'sub_subfunction');

			$field_alias_array = array(
					'country' => 'cou',
					'city' => 'city',
					'business_level_1' => 'bl_1',
					'business_level_2' => 'bl_2',
					'business_level_3' => 'bl_3',
					'function' => 'fun',
					'subfunction' => 's_fun',
					'designation' => 'des',
					'grade' => 'gra',
					'level' => 'lev',
					'gender' => 'gen',
					'company_joining_date' => 'com_j_d',
					'sub_subfunction' => 's_s_fun',
					'education' => 'edu',
					'critical_talent' => 'cri_t',
					'critical_position' => 'cri_p',
					'special_category' => 's_cat',
					'urban_rural_classification' => 'urb_r_c',
					'engagement_level' => 'sal_lv',
					'rating_for_current_year' => 'r_cu_y',
			);


			foreach($attributes as $val)
			{
				if(in_array($val['ba_name'], $required_attributes_array)) {

					$alias = $val['ba_name'];

					if (in_array($report_name, array('potential', 'promotion'))) {

						if(array_key_exists($alias,$field_alias_array)) {

							$alias = $field_alias_array[$val['ba_name']];

						}
					}

					if(in_array($val['ba_name'], $manage_table_fields_array)) {

						$str[] = "manage_".$val['ba_name'].".name AS ".$alias;

					} else {

						$str[] = "login_user.".$val['ba_name'] ." AS ".$alias;

					}
				}
			}

			if ($report_name == 'promotion') {

				$str[] = "(YEAR(CURDATE()) - YEAR(`login_user`.`promoted_in_2_yrs`) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(`login_user`.`promoted_in_2_yrs`, '%m%d'))) AS pr_2_y";

			}
			$strdata = implode(",",$str);
			$staff_list = 	$this->admin_model->get_emp_list_for_report($arr, 50000, 0, false, $strdata);

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>$staff_list
			);

		} else {//previous code

			$staff_list = 	$this->admin_model->get_staff_list_for_download($arr);
			$staff_list	=	GetEmpAllDataFromEmpIdForReport($staff_list, true);
			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>$staff_list
			);

		}

		$this->set_response($rdata, REST_Controller::HTTP_OK);
	}


	
    public function paymix_get()
    {
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "login_user.id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "login_user.id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		if($this->session->userdata('keyword'))
		{
			if($arr)
			{
				$arr .= " AND ";
			}
			$arr .= "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}

		$data['keyword'] =	$this->session->userdata('keyword');
		$this->session->unset_userdata('keyword');
		$staff_list = $this->admin_model->get_staff_list_for_download($arr);	
		$staff_list=GetEmpAllDataFromEmpIdForReportNew($staff_list);
		$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$staff_list
					);
		$this->set_response($rdata, REST_Controller::HTTP_OK);
    }
   
    public function compposition_get($cycleID='', $rule_id=0, $report_type = '')
	{
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		$currency_arr = array();
		$curency_str  = "";

		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}
		}

		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "employee_salary_details.user_id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "employee_salary_details.user_id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		$ruleArr=[];
        if($cycleID=='')
        {
            $salary_cycles_list= $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
        }
        else
		{
		   $salary_cycles_list= $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID,"id"=>$cycleID));
		}

        foreach($salary_cycles_list as $scl)
        {
			if($rule_id)
			{
				$salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$scl['id'], "hr_parameter.id"=>$rule_id));
			}
			else
			{
				$salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$scl['id']));
			}

			if(count($salary_rule_list)!=0)
			{
				foreach($salary_rule_list as $srl)
				{
					if(($report_type == 'budget' || $report_type == 'salary') && $srl['to_currency_id']) {// get currency name

						$currency_arr[]		= 	$this->admin_model->get_table_row("manage_currency", "id, name" , array('id' => $srl['to_currency_id'], 'status' => 1) , "id ASC");
					}

					if($report_type == 'budget') {

						$cond			= 	(!empty($srl['include_promotion_budget']) && $srl['include_promotion_budget'] == 1) ? "":" - employee_salary_details.sp_increased_salary";
						$to_currency_id = 	$srl['to_currency_id'];
						$ruleArr[]		= 	$this->rule_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($srl['id'], $arr, $to_currency_id, $cond);

					} else {
						$ruleArr[]		=	$this->rule_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($srl['id'], $arr);
					}
				}
			}
		}

		$empArr=[];
        $allowanceAyy=['allowance_1','allowance_2','allowance_3','allowance_4','allowance_5','allowance_6','allowance_7','allowance_8','allowance_9','allowance_10'];
        for($i=0;$i<count($ruleArr);$i++)
        {
            foreach($ruleArr[$i] as $key=>$emp)
            {
				$crr_range_arr = json_decode($emp['comparative_ratio_range'], true);
				$k=0;
				foreach($crr_range_arr as $crr)
				{
					if($k==0)
                    { 
                      if(($emp['crr_val'])<$crr['max'])
                      {
                         $rang= '<'.$crr['max'];           
                         break; 
                      }
                    }                                
                    else
                    {
                       if($crr['min']<=($emp['crr_val']) && ($emp['crr_val'])<$crr['max'])
                        {
                           $rang= $crr['min'].' - '.$crr['max'];           
                           break; 
                        }     
                    }

                    if(($k+1)==count($crr_range_arr))
                    {
                        if(($emp['crr_val'])>=$crr['max'])
                        {
						   $k++;
                           $rang= '>'.$crr['max'];           
                           break; 
                        }
                    }                            
                    $k++;             
				}

				//get crr of the employee
				$pre_crr_val 		= 0;
				$salary 			= 0;
				$pre_crr_rang 	= '';
				// pre_crr_val
				if(!empty($emp['increment_applied_on_salary']) && !empty($emp['market_salary']) && number_format($emp['increment_applied_on_salary']) && number_format($emp['market_salary'])) {

					/*	check below code ($salary = $emp['final_salary']) after live if ok then remove commented code else open this code below code
						if ($emp['comparative_ratio'] == 'yes') {//set comparative_ratio

						$performnace_based_increment = (float)$emp['performnace_based_increment'];

						if(!empty($performnace_based_increment)) {

							$salary = $emp['increment_applied_on_salary'] + ($emp['increment_applied_on_salary'] / $performnace_based_increment);

						} else {

							$salary = $emp['increment_applied_on_salary'];

						}

					} else {

						$salary = $emp['increment_applied_on_salary'];

					} */

					$salary = $emp['final_salary'];

					if(!empty($salary) && number_format($salary)) {

						$pre_crr_val = round((($salary / $emp['market_salary']) * 100), 2);

					}

					if(!empty($pre_crr_val)) {

						$a = 0;

						foreach($crr_range_arr as $crr)
						{
							if($a==0)
							{
								if($pre_crr_val < $crr['max'])
								{
									$pre_crr_rang = '<'.$crr['max'];
									break;
								}

							} else {

								if($crr['min'] <= $pre_crr_val && $pre_crr_val < $crr['max'])
								{
									$pre_crr_rang = $crr['min'].' - '.$crr['max'];
									break;
								}
							}

							if(($a+1) == count($crr_range_arr))
							{
								if(($pre_crr_val) >= $crr['max'])
								{
									$a++;
									$pre_crr_rang = '>'.$crr['max'];
									break;
								}
							}

							$a++;
						}
					}
				}
				//end crr of the employee

				$emp['pre_crr_val']		= $pre_crr_val;
				$emp['pre_crr_range']	= $pre_crr_rang;
				$emp['crr_val'] 		= $emp['crr_val'];
				$emp['comparative_ratio_range']=$rang;
				$empArr[]= $emp;
            }
		}

        for($i=0;$i<count($empArr);$i++)
        {			
			foreach($empArr[$i] as $k=>$v)
			{
				if(in_array($k,$allowanceAyy))
				{
					//$ba_name=$this->rule_model->getbusiness_attributeDisplayname('business_attribute',array('ba_name'=>str_replace('_',' ',$k),'status'=>'1'));

					if(0 && !empty($ba_name[0]['status']) && $ba_name[0]['status']==1)
					{
						$empArr[$i][$k]= array(
												'name'=>$ba_name[0]['display_name'],
												'value'=> $empArr[$i][$k]
											);
					}
					else 
					{
						unset($empArr[$i][$k]);
					}
				}
			}
		}

		//add currency format in response
		if(!empty($currency_arr)) {

			$currency_arr_new = array();

			foreach($currency_arr as $key => $currency_data) {

				$currency_arr_new[$key] = $currency_data['name'];

			}

			$curency_str = implode(", ", array_unique($currency_arr_new) );

		}

		//remove extra keys incase of salary_analysis
		if($report_type == 'salary_analysis') {

			$allowed_keys_array = array("gender", "country",  "city",  "business_level_1",  "business_level_2",  "business_level_3",  "designation",  "function",
			  "sub_function",  "sub_sub_function",  "grade",  "level",  "education",  "critical_talent",  "critical_position",  "special_category",  "performance_rating",
				"manager_discretions",  "urban_rural_classification", "Salary_increase_percentage");

			foreach($empArr as $emp_key => $emp_data) {

				foreach($emp_data as $emp_data_key => $emp_data_val) {

					if(!in_array($emp_data_key, $allowed_keys_array)) {

						unset($empArr[$emp_key][$emp_data_key]);

					}
				}
			}
		}

        $rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$empArr,
					"currency" => $curency_str,
					);

		$this->set_response($rdata, REST_Controller::HTTP_OK);
    }
	
    public function payRange_get()
    {       
		$type=$this->get('type');   
		if($type=='')
		{
			header("HTTP/1.0 301 Email is missing");
			echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "You must have to pass which report you want see like base_salary, target_salary, total_salary."));
			return; 
		}
		
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "login_user.id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "login_user.id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		if($this->session->userdata('keyword'))
		{
			if($arr)
			{
				$arr .= " AND ";
			}
			$arr .= "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}
	
		$data['keyword'] =	$this->session->userdata('keyword');
		$this->session->unset_userdata('keyword');
		$staff_list = $this->admin_model->get_staff_list_for_download($arr);	
		$staff_list=GetEmpAllDataForPayRange($staff_list,$type);
		$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$staff_list
					);
		$this->set_response($rdata, REST_Controller::HTTP_OK);
    }  




    public function performanecycle_get()
    {
        $salary_cycles_list= $this->rule_model->get_performance_cycles_for_api(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
        $rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$salary_cycles_list
					);
		$this->set_response($rdata, REST_Controller::HTTP_OK);
    }
	
    public function budgetutilisationreport_get()
    {
         $ruleArr=[];
        $salary_cycles_list= $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
        foreach($salary_cycles_list as $scl)
        {
           $salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$scl['id']));
           if(count($salary_rule_list)!=0) {
            foreach($salary_rule_list as $srl)
            {
                //clean($scl['name'])
                $ruleArr[]=$this->rule_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($srl['id']);
            }
            }
        }
        $empArr=[];
        $allowanceAyy=['allowance_1','allowance_2','allowance_3','allowance_4','allowance_5','allowance_6','allowance_7','allowance_8','allowance_9','allowance_10'];
        for($i=0;$i<count($ruleArr);$i++)
        {
            foreach($ruleArr[$i] as $key=>$emp)
            {
              $crr_range_arr = json_decode($emp['comparative_ratio_range'], true);
              $k=0;
              foreach($crr_range_arr as $crr)
              {
                  if($k==0)
                    { 
                      
                      
                      if(($emp['crr_val'])<$crr['max'])
                      {
                         $rang= '<'.$crr['max'];           
                         break; 
                      }
                    }                                
                    else
                    {
                       if($crr['min']<=($emp['crr_val']) && ($emp['crr_val'])<$crr['max'])
                        {
                           $rang= $crr['min'].' - '.$crr['max'];           
                           break; 
                        }     
                    }

                    if(($k+1)==count($crr_range_arr))
                    {
                        if(($emp['crr_val'])>=$crr['max'])
                        {
						   $k++;
                           $rang= '>'.$crr['max'];           
                           break; 
                        }
                    }                            
                    $k++;
              
              
             
              } 
              $emp['crr_val'] = $emp['crr_val'];
              $emp['comparative_ratio_range']=$rang;
               $empArr[]= $emp;
            }
        }
        for($i=0;$i<count($empArr);$i++)
        {
          foreach($empArr[$i] as $k=>$v)
          {
//              echo $k;
              if(in_array($k,$allowanceAyy))
              {
                  //echo str_replace('_',' ',$k);
                  $ba_name=$this->rule_model->getbusiness_attributeDisplayname('business_attribute',array('ba_name'=>str_replace('_',' ',$k),'status'=>'1'));
                  //print_r($ba_name['display_name']); 
                  if($ba_name[0]['status']==1)
                  {
                     $empArr[$i][$k]= array(
                                            'name'=>$ba_name[0]['display_name'],
                                            'value'=> $empArr[$i][$k]
                                           );
                  }
                  else 
                  {
                      unset($empArr[$i][$k]);
                  }
              }
          }
        }
//        echo '<pre />';
//        print_r($empArr); die;
        $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$empArr
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
    }
    
    public function SurveyResult_get($surveyID='',$userids='')
    {       
              
            if($surveyID=='')
            {
                header("HTTP/1.0 301 Survey ID is missing");
                echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "You must have to pass Survey ID"));
                return; 

            }
           
           $data['question']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]); 
           $myarr=[];
          foreach($data['question'] as $qu)
          {
             $myarr[]=[
                 'question'=>$qu['QuestionName'],
                 'choices'=>$this->Survey_model->get_data('survey_answers',$where=['question_id'=>$qu['question_id']])
             ]; 
             $qarray[]['question']= $this->Survey_model->get_data('survey_answers',$where=['question_id'=>$qu['question_id']]);
             
          }
//          echo '<pre />';
//          print_r($myarr); 
          $emp=[];
          for($i=0;$i<count($myarr);$i++)
          {
              $k=0;
              foreach($myarr[$i]['choices'] as $s) {
              if($user_ids)
                    {
                            $where='question_id = '.$s['question_id'].' AND surveyAnsID = '.$s['surveyAnsID'].' AND user_id IN ('.str_replace('_',',',$user_ids).')';
                            $anscount=$this->Survey_model->get_data('user_survey_answer',$where);
                    }
                    else
                    {
                            $anscount=$this->Survey_model->get_data('user_survey_answer',$where=['question_id'=>$s['question_id'],'surveyAnsID'=>$s['surveyAnsID']]);
                    }
               
                foreach($anscount as $e)  
                {
                    $emp[]=$e['user_id'];    
                }
              $myarr[$i]['choices'][$k]['employees']= $emp;      
              $k++;
              }
               
          }
          $kk=0;
         for($co=0;$co<count($myarr);$co++)
         {
              $kl=0;
             foreach($myarr[$co]['choices'] as $k=>$s) {
                 
                 foreach($s as $key=>$vv) {
//                     echo $kl.'->'.$key.'<br/>';
                 if($key=='Answer')
                 {
                      $myarr[$co]['choices'][$kl]['choice'] =$myarr[$co]['choices'][$kl][$key];
                      unset($myarr[$co]['choices'][$kl][$key]);
                 }
                 
                 if($key!='choice' && $key!='employees')
                 {
                   unset($myarr[$co]['choices'][$kl][$key]);
                     
                 }
                 
                 
                 }
              $kl++;
             }
               $kk++;
         }
         
            $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$myarr
                            );
//            echo '<pre />';
//            print_r($rdata); die;
            $this->set_response($rdata, REST_Controller::HTTP_OK);
	}


	public function promotedSuccessorReportData_get($rpt_for_active = "1", $cond = 0)
    {
		//$rpt_for_active =1 Meand want to get active user data and other case want to inactive users data
		if($rpt_for_active != "1")
		{
			$rpt_for_active = 0;
		}
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "login_user.status = ".$rpt_for_active;
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;
			}
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;
			}
		}

		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);
			if(count($hr_emps_arr)>1)
			{
				$arr .= " AND login_user.id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr .= " AND login_user.id in (".$hr_emps_arr.")";
			}
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//

		if($this->session->userdata('keyword'))
		{
			if($arr)
			{
				$arr .= " AND ";
			}
			$arr .= "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}

		//Add Successor Identified condition
		$arr .= " AND login_user.successor_identified = 'Yes'";

		$data['keyword'] =	$this->session->userdata('keyword');
		$this->session->unset_userdata('keyword');

		if($cond) {//new code

			$attributes =  $this->admin_model->staff_attributes_for_export();

			//if required other attribute then add attribute name in below array, now only required these values
			$required_attributes_array = array('employee_code', 'name', 'email', 'country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function',
			'subfunction', 'designation', 'grade', 'level', 'gender', 'company_joining_date', 'rating_for_current_year', 'sub_subfunction', 'education', 'critical_talent', 'critical_position', 'special_category',
			 'urban_rural_classification', 'promoted_in_2_yrs');

			//if required other attribute then add attribute name in below array, now only required these values
			$manage_table_fields_array = array('country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function', 'subfunction', 'designation', 'grade', 
			'level', 'rating_for_current_year' ,'education', 'critical_talent', 'critical_position', 'special_category', 'currency', 'sub_subfunction');


			foreach($attributes as $val)
			{
				if(in_array($val['ba_name'], $required_attributes_array)) {

					//$attrarr[$val['ba_name']] =	$val['display_name'];

					if(in_array($val['ba_name'], $manage_table_fields_array)) {

						$str[] = "manage_".$val['ba_name'].".name AS ".$val['ba_name'];

					} else {

						$str[] = "login_user.".$val['ba_name'];

					}
				}
			}

			$strdata = implode(",",$str);
			$staff_list = 	$this->admin_model->get_emp_list_for_report($arr, 50000, 0, false, $strdata);

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>$staff_list,
			);

		} else {//previous code

			$staff_list = 	$this->admin_model->get_staff_list_for_download($arr);
			$staff_list	=	GetEmpAllDataFromEmpIdForReport($staff_list, true);
			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>$staff_list,
			);

		}

		$this->set_response($rdata, REST_Controller::HTTP_OK);
	}
	

	/*
	* get compposition report rule wise
	*/
	public function compposition_rule_wise_get($cycleID, $rule_id, $report_type = '') {
		$cycleID 	= (int)$cycleID;
		$rule_id 	= (int)$rule_id;

		if(!$cycleID || !$rule_id) {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		}

		$arr 				= "";		
		$hr_emps_arr 		= "";
		$hr_emps_data_arr 	= "";
		$currency_arr 		= array();
		$curency_str  		= "";
		$emp_data 			= array();
		$emp_data_array 	= array();
		$ruleArr			= [];

		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				return;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				return;	
			}
		}

		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "employee_salary_details.user_id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "employee_salary_details.user_id in (".$hr_emps_arr.")";
			}	
		}

		$salary_cycles_list= $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID,"id"=>$cycleID));

		if(empty($salary_cycles_list)) {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		} else {

			$salary_cycles_list = $salary_cycles_list[0];

		}

		$salary_rule_det = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$salary_cycles_list['id'], "hr_parameter.id"=>$rule_id));

		if(empty($salary_rule_det)) {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		} else {

			$salary_rule_det = $salary_rule_det[0];

		}

		if(($report_type == 'budget' || $report_type == 'salary') && $salary_rule_det['to_currency_id']) {// get currency name

			$currency_arr		= 	$this->admin_model->get_table_row("manage_currency", "id, name" , array('id' => $salary_rule_det['to_currency_id'], 'status' => 1) , "id ASC");
		}		

		if($report_type == 'budget') {

			$cond			= 	(!empty($salary_rule_det['include_promotion_budget']) && $salary_rule_det['include_promotion_budget'] == 1) ? "":" - employee_salary_details.sp_increased_salary";
			$to_currency_id = 	$salary_rule_det['to_currency_id'];
			$emp_data		= 	$this->rule_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($salary_rule_det['id'], $arr, $to_currency_id, $cond);
		
		} else {

			$emp_data		=	$this->rule_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($salary_rule_det['id'], $arr);
		}

		if(empty($salary_rule_det['salary_position_based_on']) || empty($emp_data)) {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		}

		if($salary_rule_det['salary_position_based_on'] == 1) {//distance

			$emp_data_array = $this->get_emp_data_with_range_by_distance_model($emp_data);

		} else if ($salary_rule_det['salary_position_based_on'] == 2){//Quartile

			$emp_data_array = $this->get_emp_data_with_range_by_quartile_model($emp_data, $salary_rule_det['comparative_ratio']);

		} else {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		}

		if(empty($emp_data_array)) {

			$rdata=array(
				"status" => "success",
				"statusCode" => 200,
				"data" =>""
			);

			$this->set_response($rdata, REST_Controller::HTTP_OK);
			return;

		}		

		//add currency format in response
		if(!empty($currency_arr)) {

			$currency_arr_new = array();

			foreach($currency_arr as $key => $currency_data) {

				$currency_arr_new[$key] = $currency_data['name'];

			}

			$curency_str = implode(", ", array_unique($currency_arr_new) );

		}

		//remove extra keys incase of salary_analysis
		if($report_type == 'salary_analysis') {

			$allowed_keys_array = array("gender", "country",  "city",  "business_level_1",  "business_level_2",  "business_level_3",  "designation",  "function",
			  "sub_function",  "sub_sub_function",  "grade",  "level",  "education",  "critical_talent",  "critical_position",  "special_category",  "performance_rating",
				"manager_discretions",  "urban_rural_classification", "Salary_increase_percentage");

			foreach($empArr as $emp_key => $emp_data) {

				foreach($emp_data as $emp_data_key => $emp_data_val) {

					if(!in_array($emp_data_key, $allowed_keys_array)) {

						unset($empArr[$emp_key][$emp_data_key]);

					}
				}
			}
		}

        $rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$emp_data_array,
					"currency" => $curency_str,
					);

		$this->set_response($rdata, REST_Controller::HTTP_OK);
	}
	

	/*
	* pass employee data and get data with range and uset extra field for
	* distance model compposition rule wise report
	*/
	public function get_emp_data_with_range_by_distance_model(array $emp_data) {

		$data_array = array();

		if(empty($emp_data)) {
			return;
		}

		foreach($emp_data as $key => $emp) {

			//get crr of the employee
			$post_crr_val 	= 0;
			$post_crr_rang 	= '';
			$pre_crr_rang   = '';

			$crr_range_arr = json_decode($emp['comparative_ratio_range'], true);
			$k = 0;

			foreach($crr_range_arr as $crr)	{

				if($k == 0) {

					if(($emp['crr_val'])<$crr['max']) {

						$pre_crr_rang = '<'.$crr['max'];           
						break; 
					}

				} else {

					if($crr['min']<=($emp['crr_val']) && ($emp['crr_val'])<$crr['max']) {

						$rapre_crr_rangng = $crr['min'].' - '.$crr['max'];           
						break;

					}     
				}

				if(($k+1)==count($crr_range_arr)) {

					if(($emp['crr_val'])>=$crr['max']) {

						$k++;
						$pre_crr_rang = '>'.$crr['max'];           
						break; 
					}
				}
				$k++;             
			}

			// post_crr_val
			if(!empty($emp['final_salary']) && !empty($emp['market_salary']) && number_format($emp['final_salary']) && number_format($emp['market_salary'])) {

				if(!empty($emp['final_salary']) && number_format($emp['final_salary'])) {

					$post_crr_val = round((($emp['final_salary'] / $emp['market_salary']) * 100), 2);

				}

				if(!empty($post_crr_val)) {

					$a = 0;

					foreach($crr_range_arr as $crr) {

						if($a == 0) {

							if($post_crr_val < $crr['max']) {

								$post_crr_rang = '<'.$crr['max'];
								break;
							}

						} else {

							if($crr['min'] <= $post_crr_val && $post_crr_val < $crr['max']) {

								$post_crr_rang = $crr['min'].' - '.$crr['max'];
								break;
							}
						}

						if(($a+1) == count($crr_range_arr)) {

							if(($post_crr_val) >= $crr['max']) {

								$a++;
								$post_crr_rang = '>'.$crr['max'];
								break;
							}
						}
						$a++;
					}
				}
			}
			//end crr of the employee

			$emp['post_crr_val']		= $post_crr_val;
			$emp['post_c_rng']	    	= $post_crr_rang;
			$emp['pre_crr_val'] 		= $emp['crr_val'];
			$emp['pre_c_rng']			= $pre_crr_rang;
			$data_array[$key] 			= $emp;
		}

		/*$allowance_array = ['allowance_1','allowance_2','allowance_3','allowance_4','allowance_5','allowance_6','allowance_7','allowance_8','allowance_9','allowance_10',
							'performance_cycle_id','salary_rule_name','cycle_name','comparative_ratio','comparative_ratio_range','performnace_based_increment',
							'emp_name','email_id','designation','increment_applied_on_salary','company_name','crr_val','current_base_salary','market_salary','final_salary',
							'actual_salary','Salary_increase_percentage','max_hike','manager_discretions' 	
							];

		foreach($data_array as $k => $data_val) {

			foreach($data_val as $data_key => $val) {

				if(in_array($data_key , $allowance_array)) {

					unset($data_array[$k][$data_key]);
				}
			}
		}

		return $data_array;*/

		$data_final_array = array();
		$field_array = $this->get_compposition_report_field_array();

		foreach($data_array as $k => $data_val) {//dd($data_val);

			foreach($data_val as $data_key => $val) {

				if(array_key_exists($data_key, $field_array)) {

					$data_final_array[$k][$field_array[$data_key]] = $val;
				}
			}
		}

		return $data_final_array;
	}


	/*
	* pass employee data and get data with range and uset extra field for
	* quartile model compposition rule wise report
	*/
	public function get_emp_data_with_range_by_quartile_model(array $emp_data, $rule_comparative_ratio) {

		$data_array = array();

		if(empty($emp_data)) {
			return;
		}

		foreach($emp_data as $emp_key => $emp) {

			//get crr of the employee
			/*$post_crr_val 	= 0;
			$post_crr_rang 	= '';
			$pre_crr_rang   = '';

			$increment_applied_on_amt_for_quartile = $emp['increment_applied_on_amt'];

			if($rule_comparative_ratio == "yes") {

				$emp_salary 							= trim($emp['increment_applied_on_salary']);
				$performnace_based_increment 			= trim($emp['performnace_based_increment']);
				$increment_applied_on_amt_for_quartile 	= 0;

				if(!empty($performnace_based_increment) && !empty($emp_salary)) {//performnace_based_salary

					$increment_applied_on_amt_for_quartile = $emp_salary + (($emp_salary * $performnace_based_increment)/100);
				}
			}

			$crr_range_arr = json_decode($emp['comparative_ratio_range'], true);
			$k = 0;
			$min_mkt_salary = 0;


			// pre_crr_val
			foreach($crr_range_arr as $pre_range_key => $row1) {

				$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $pre_range_key);

				if($k == 0)
				{
					if($increment_applied_on_amt_for_quartile < $emp[$quartile_range_arr[1]])
					{
						$pre_crr_rang = " < ".$row1["max"];
						break;
					}
				}
				else
				{
					if($min_mkt_salary <= $increment_applied_on_amt_for_quartile && $increment_applied_on_amt_for_quartile < $emp[$quartile_range_arr[1]])
					{
						$pre_crr_rang = $row1["min"].' - '.$row1["max"];
						break;
					}
				}

				if(($k+1)==count($crr_range_arr))
				{
					if($increment_applied_on_amt_for_quartile >= $emp[$quartile_range_arr[1]])
					{
						$k++;
						$pre_crr_rang = " > ".$row1["max"];
						break;
					}
				}

				$min_mkt_salary = $emp[$quartile_range_arr[1]];
				$k++;
			}


			// post_crr_val
			if(!empty($emp['final_salary']) && !empty($emp['market_salary']) && number_format($emp['final_salary']) && number_format($emp['market_salary'])) {

				if(!empty($emp['final_salary']) && number_format($emp['final_salary'])) {

					$post_crr_val = round((($emp['final_salary'] / $emp['market_salary']) * 100), 2);

				}

				if(!empty($post_crr_val)) {

					$a = 0;
					$post_min_mkt_salary = 0;
					$increment_applied_on_amt_for_quartile = $post_crr_val;

					foreach($crr_range_arr as $post_range_key => $row1) {

						$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $post_range_key);
		
						if($a == 0)
						{
							if($increment_applied_on_amt_for_quartile < $emp[$quartile_range_arr[1]])
							{
								$post_crr_rang = " < ".$row1["max"];
								break;
							}
						}
						else
						{
							if($post_min_mkt_salary <= $increment_applied_on_amt_for_quartile && $increment_applied_on_amt_for_quartile < $emp[$quartile_range_arr[1]])
							{
								$post_crr_rang = $row1["min"].' - '.$row1["max"];
								break;
							}
						}

						if(($a+1)==count($crr_range_arr))
						{
							if($increment_applied_on_amt_for_quartile >= $emp[$quartile_range_arr[1]])
							{
								$a++;
								$post_crr_rang = " > ".$row1["max"];
								break;
							}
						}

						$post_min_mkt_salary = $emp[$quartile_range_arr[1]];
						$a++; 
					}

				}
			}
			//end crr of the employee

			$emp['post_crr_val']		= $post_crr_val;
			$emp['post_crr_range']	    = $post_crr_rang;
			$emp['pre_crr_val'] 		= $emp['crr_val'];
			$emp['pre_crr_rang']		= $pre_crr_rang;*/

			$emp['post_c_rng']	    	= $emp['post_quartile_range_name'];
			$emp['pre_c_rng']			= $emp['pre_quartile_range_name'];
			$data_array[$emp_key] 		= $emp;
		}

		/*$allowance_array = ['allowance_1','allowance_2','allowance_3','allowance_4','allowance_5','allowance_6','allowance_7','allowance_8','allowance_9','allowance_10',
							'performance_cycle_id','salary_rule_name','cycle_name','comparative_ratio','comparative_ratio_range','performnace_based_increment',
							'emp_name','email_id','designation','increment_applied_on_salary','company_name','crr_val','current_base_salary','market_salary','final_salary',
							'actual_salary','Salary_increase_percentage','max_hike','manager_discretions'];*/

		$data_final_array = array();
		$field_array = $this->get_compposition_report_field_array();

		foreach($data_array as $k => $data_val) {

			foreach($data_val as $data_key => $val) {

				if(array_key_exists($data_key, $field_array)) {

					$data_final_array[$k][$field_array[$data_key]] = $val;
				}

				/*if(in_array($data_key , $allowance_array)) {

					unset($data_array[$k][$data_key]);
				}*/
			}
		}

		return $data_final_array;
	}


	public function get_compposition_report_field_array() {

		return $field_array = array(
			'country' => 'cou',
			'city' => 'city',
			'business_level_1' => 'bl_1',
			'business_level_2' => 'bl_2',
			'business_level_3' => 'bl_3',
			'function' => 'fun',
			'sub_function' => 's_fun',
			'grade' => 'gra',
			'level' => 'lev',
			'gender' => 'gen',
			'sub_sub_function' => 's_s_fun',
			'education' => 'edu',
			'critical_talent' => 'cri_t',
			'critical_position' => 'cri_p',
			'special_category' => 's_cat',
			'urban_rural_classification' => 'urb_r_c',
			'post_c_rng' => 'post_c_rng',
			'pre_c_rng' => 'pre_c_rng',
			'performance_rating' => 'pf_rat'
		);

	}

}
