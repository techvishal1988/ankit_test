<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User extends REST_Controller {
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
        $this->load->helper('api_helper');
        $this->load->model('api/user_model');
        $this->load->model('api/manager_model');
        $this->load->model('api/admin_model');
        $this->token=@apache_request_headers()['token'];
        $this->authname=@apache_request_headers()['authname'];
        if($this->token!='' && $this->authname!='' )
        {
            $this->user_model->setdb($this->authname);
            $udata=$this->user_model->userByToken(apache_request_headers()['token']);
            if(count($udata)==1)
            {
                $this->id=$udata[0]->id;
                $this->email=$udata[0]->email;
                $this->role=$udata[0]->role;
                $this->company_id=$udata[0]->company_Id;

           }
        
         }
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function login_post()
	{
		$data['msg'] = "";
		//$data['body'] = "index";
                 if($this->post('email')=='')
                    {
                        header("HTTP/1.0 301 Email is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Email is missing"));
                        return; 

                    }
                    
                 if($this->post('password')=='')
                    {
                        header("HTTP/1.0 301 Password is missing");
                        echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "Password is missing"));
                        return; 

                    }   
		if($this->post('email')!=''&&$this->post('password')!='')
		{
			
                           
				$uname = $this->post('email');
				$pass = md5($this->post("password"));

				$username_arr = explode('@',$uname);
				$domain_name = end($username_arr);

				$this->load->model("domain_model");
				$domain_dtls = $this->domain_model->is_valid_domain($domain_name);

				if($domain_dtls)
				{
                                   
					$this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));	

					$this->load->model("front_model");
					$result = $this->front_model->is_valid_user($uname,$pass, $domain_dtls['company_Id']);
					$company_dtls = $this->front_model->get_table_row("manage_company","*", array("id"=>$domain_dtls['company_Id'], "dbname"=>$domain_dtls['dbname']));
					if($result)
					{	
						if($company_dtls)
						{
							$color = "00ADEF";
							if($company_dtls['company_color'])
							{
								$color = $company_dtls['company_color'];
							}
							
							if($company_dtls['company_light_color'])
							{
								$company_light_color = $company_dtls['company_light_color'];
							}
							else
							{
								$company_light_color = $company_dtls['company_color'];
							}
							//echo '<pre />';
                                                        //print_r($result);
                                                        //print_r($domain_dtls['dbname']);
                                                        //die;
                                                        if($result['is_manager']==1 || $result['role']==11) {
                                                        $token=md5(uniqid(rand(), true));
                                                        $this->user_model->setdb($domain_dtls['dbname']);
                                                        $this->user_model->updatetoken($result['id'],$token);
							$detail = array(
								'userid_ses'=>$result['id'],
                                                                'email_ses' => $result['email'],
                                                                'username_ses' => $result['name'],
                                                                'role_ses' => $result['role'],
                                                                'is_manager_ses' => $result['is_manager'],
                                                                'manage_hr_only_ses' => $result['manage_hr_only'],
								'companyid_ses' => $domain_dtls['company_Id'],
								'companyname_ses' => $domain_dtls['company_name'],
								'domainname_ses' => $domain_dtls['domainName'],
								'company_color_ses' => $color,
								'company_light_color_ses' => $company_light_color,
								'company_logo_ses' => $company_dtls['company_logo'],	
								'company_bg_img_url_ses' => $company_dtls['company_bg_img'],
								'proxy_userid_ses'=>$result['id'],	
								'proxy_role_ses' => $result['role'],
                                                                'authname'=>$domain_dtls['dbname'],
                                                                'token'=>$token
								);
                                                         $rdata=array(
                                                                    "status" => "success",
                                                                    "statusCode" => 200,
                                                                    "data" =>$detail
                                                        );
							//$this->load->model("common_model");
							//print_r($this->common_model->set_permissions_session_arr()); die;
                                                        }
                                                        else
                                                        {
                                                           $rdata=array(
                                                                "status" => "failed",
                                                                "statusCode" => 301,
                                                                "message" => "You do not have access privilege to this app. Please contact system administrator"
                                                            ); 
                                                        }
							
						}
						else
						{
                                                    $rdata=array(
                                                        "status" => "failed",
                                                        "statusCode" => 301,
                                                        "message" => "Invalid company"
                                                        );
							
						}						
					}
					else
					{
						
                                                $rdata=array(
                                                        "status" => "failed",
                                                        "statusCode" => 301,
                                                        "message" => "Invalid email or password"
                                                        );
					}
				}
				else
				{
                                    
					
                                          $rdata=array(
                                                        "status" => "failed",
                                                        "statusCode" => 301,
                                                        "message" => "Invalid email or password"
                                                        );
				}
			
						
		}
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
		
	}
    public function profile_get()
        {
            if($this->token!='')
            {
               $data['profile']=$this->user_model->profile($this->id);
               $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data['profile']
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
            }
            else
            {
                
                 echo json_encode(array("status" => "failed", "statusCode" => 305, "message" => "Invalid token"));
                 exit; 
            }
        }
    public function employee_get($empId)
	{
//		if(!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME))
//		{
//			$this->session->set_flashdata('message', "<div align='left' style='color:red;' id='notify'><span><b>You don't have view rights.</b></span></div>");
//			redirect(site_url("no-rights"));		
//		}
//		
		$data['msg'] = "";
		$tupleData = $this->admin_model->staffDetails($empId);
		$data['staffDetail'] = $this->admin_model->completeStafDetails(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));

		$rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$data["staffDetail"]
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
    public function umd_post()
	{
		$id = trim($this->post("emp_sal_id"));
		$new_per = trim($this->post("new_per"));
		if($id > 0 and $new_per > 0)
		{
			//$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "row_owner.first_approver" => $this->session->userdata('email_ses'), "hr_parameter.status"=>6, "employee_salary_details.status"=>1));
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$id, "employee_salary_details.manager_emailid" => $this->email, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				$max_hike = $salary_dtls["max_hike"];
				if($salary_dtls["recently_promoted"]=="Yes")
				{
					$max_hike = $salary_dtls["recently_promoted_max_hike"];
				}
				
				if($max_hike >= $new_per)
				{
					/*$manager_max_incr_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]+$salary_dtls["standard_promotion_increase"]+$salary_dtls["Manager_discretionary_increase"];
					$manager_max_dec_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]+$salary_dtls["standard_promotion_increase"]-$salary_dtls["Manager_discretionary_decrease"];*/

					$manager_max_incr_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]+$salary_dtls["Manager_discretionary_increase"];
					$manager_max_dec_per = $salary_dtls["performnace_based_increment"]+$salary_dtls["crr_based_increment"]-$salary_dtls["Manager_discretionary_decrease"];

					if($manager_max_incr_per >= $new_per and $manager_max_dec_per <= $new_per)
					{
						$manager_emps_total_budget = 0;
						//$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_budget($salary_dtls["rule_id"], $salary_dtls["upload_id"], $salary_dtls["user_ids"], $this->session->userdata('email_ses'));
						$manager_emps_total_budget_arr = $this->manager_model->get_managers_employees_total_budget($salary_dtls["rule_id"], $salary_dtls["upload_id"], $salary_dtls["user_ids"], $salary_dtls["first_approver"]);

						if($manager_emps_total_budget_arr)
						{
							$manager_emps_total_budget = $manager_emps_total_budget_arr["final_salary"];
						}
						
						$manager_emps_total_budget = $manager_emps_total_budget - $salary_dtls["final_salary"];
						$total_max_budget = 0;//$salary_dtls["budget_amount"];
						$budget_percent_incr =0;// $salary_dtls["budget_percent"];

						//if($salary_dtls["overall_budget"] == "Manual")
						//{
							$managers_arr = json_decode($salary_dtls['manual_budget_dtls'],true);
							foreach($managers_arr as $key => $value)
							{
								if(strtoupper($this->email) == strtoupper($value[0])) 
								{
									$total_max_budget = $value[1];
									$budget_percent_incr = $value[2];
								}
							}

						//}

						$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
						$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + $salary_dtls["sp_increased_salary"] + $increased_salary;

						if($total_max_budget >= ($manager_emps_total_budget + $increased_salary))
						{
							$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "manager_discretions"=>$new_per,"updatedby" =>$this->id, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->id), array("id"=>$id));

							$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
							
							$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>round($revised_comparative_ratio));
							echo json_encode($response); die;
						}
						else
						{
							$response =array("status"=>false,"msg"=>"Exceed your budget by allotted budget.", "final_updated_salary"=>0, "increased_salary"=>0,
								"revised_comparative_ratio"=>0);
							echo json_encode($response); die;
						}					
						//echo "<pre>";print_r($salary_dtls);die;
					}
					else
					{
						$response =array("status"=>false,"msg"=>"Increae/decrease percentage out of your limit.", "updated_salary"=>0);
						echo json_encode($response); die;
					}
				}
				else
				{
					$response =array("status"=>false,"msg"=>"Increae percentage out of your max hike.", "updated_salary"=>0);
					echo json_encode($response); die;
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
	}
    public function ueprmotiondetail_post($emp_salary_dtl_id)
	{
		$new_per = trim($this->post("txt_emp_sp_salary_per"));
		$new_desig = trim($this->post("txt_emp_new_designation"));
		$new_citation = trim($this->post("txt_citation"));
		$err_msg = "";

		if($new_per > 0 and $new_desig != "")
		{
			$salary_dtls = $this->manager_model->get_employee_salary_dtls_for_manager_discretions(array("employee_salary_details.id"=>$emp_salary_dtl_id, "employee_salary_details.manager_emailid" => $this->email, "hr_parameter.status"=>6, "employee_salary_details.status <"=>5));
			if($salary_dtls)
			{
				$max_per = $salary_dtls["standard_promotion_increase"] + $salary_dtls["sp_manager_discretionary_increase"];
				$min_per = $salary_dtls["standard_promotion_increase"] - $salary_dtls["sp_manager_discretionary_decrease"];

				if($max_per >= $new_per and $new_per >= $min_per)
				{
					$manager_emps_total_budget = 0;
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
						if(strtoupper($this->email) == strtoupper($value[0])) 
						{
							$total_max_budget = $value[1];
							$budget_percent_incr = $value[2];
						}
					}

					$increased_salary = $salary_dtls["increment_applied_on_salary"]*$new_per/100;
					$final_salary_increased_salary = $salary_dtls["increment_applied_on_salary"] + (($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"])/100) + $increased_salary;

					if($total_max_budget >= ($manager_emps_total_budget + $increased_salary))
					{
						$this->manager_model->update_tbl_data("employee_salary_details", array("final_salary"=>$final_salary_increased_salary, "sp_increased_salary" => $increased_salary, "emp_new_designation"=>$new_desig, "sp_manager_discretions"=>$new_per, "emp_citation"=>$new_citation,"updatedby" =>$this->email, "updatedon" =>date("Y-m-d H:i:s"), "updatedby_proxy"=>$this->id), array("id"=>$emp_salary_dtl_id));

						$revised_comparative_ratio = HLP_get_formated_percentage_common(($final_salary_increased_salary/$salary_dtls["market_salary"])*100);
						
						$response =array("status"=>true,"msg"=>"Ok", "final_updated_salary"=>HLP_get_formated_amount_common($final_salary_increased_salary), "increased_salary"=>HLP_get_formated_amount_common($increased_salary), "revised_comparative_ratio"=>round($revised_comparative_ratio));
						echo json_encode($response); die;
					}
					else
					{
						$err_msg = "Exceed your budget by allotted budget.";
					}	
				}
				else
				{
					$err_msg = "Increae/decrease percentage out of your limit.";
				}
				
			}
			else
			{
				$err_msg = "Invalid request.";
			}
		}
		else
		{
			$err_msg = "Designation is required.";
		}

		$response =array("status"=>false,"msg"=>$err_msg, "updated_salary"=>0);
		echo json_encode($response);
	}

}
