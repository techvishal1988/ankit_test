<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->load->library('session', 'encrypt');			
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');  
		$this->load->model('Report_model');
		$this->load->model('performance_cycle_model');
		$this->load->model('rule_model');
		$this->load->model('admin_model');
		$this->load->model('bonus_model');
		$this->load->model('rnr_rule_model');
		$this->load->model("common_model");

		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '')
		{			
			redirect(site_url("dashboard"));			
		}
		HLP_is_valid_web_token();
    }
	
	public function index()
	{
                
		$data['title'] = "Report";
		$data['body']='report/all';
        $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		$this->load->view('common/structure',$data);	
	}
	
	public function headcount()
	{
		$data['title'] = "Head Count report";
		$data['body']='report/head_count';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);	
	}


	public function turnover()
	{
		$data['title'] = "Turnover Report";
		$data['body']='report/head_count';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");
		$data['report_type'] = 'turnover';

		$this->load->view('common/structure',$data);
	}


	public function performance_rating()
	{
		$data['title'] = "Performance Rating Distribution Report";
		$data['body']='report/performance_rating';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}

	public function potential_rating()
	{
		$data['title'] = "Potential Rating Distribution Report";
		$data['body']='report/potential_rating';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}

	public function promotion_report()
	{
		$data['title'] = "Promotion Cases Distribution Report";
		$data['body']='report/promotion_cases_distribution_report';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}

	public function identified_report()
	{
		$data['title'] = "Identified Successor's Report";
		$data['body']='report/identified_successor_report';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}

	public function successor_readyness_report()
	{
		$data['title'] = "Successor's Readiness Level Report";
		$data['body']='report/successor_readyness_report';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}

	public function promoted_successor_report()
	{
		$data['title'] = "Successor's Who Got promoted";
		$data['body']='report/promoted_successor_report';
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
		$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
		$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
		$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
		$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
		$data['tenure_list'] = $this->common_model->get_table("tenure_classification", "id, slot_no, start_month, end_month", array("status" => 1) , "id asc");

		$this->load->view('common/structure',$data);
	}
        
	public function talent_distribution()
	{
		$data['title'] = "Talent Rating Distribution Report";
		$data['body']='report/talent_distribution';
		$this->load->view('common/structure',$data);	
		/*$data['body']='demo';
		$this->load->view('common/structure',$data);*/
	}


 	public function talent_performance_distribution()
	{
		$data['title'] = "Talent vs Performance Rating Distribution Report";
		$data['body']='report/talent_vs_performance_distribution';
		$this->load->view('common/structure',$data);	
		/*$data['body']='demo';
		$this->load->view('common/structure',$data);*/
	}

	public function grade($id,$rpt_for="Base")
	{
	   $res= $this->Report_model->grade($rpt_for);
	   $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['Grade'][] = $r;
		}
		$data['res']=$res;
		$data['graphurl']=base_url('report/json_for_grade');
		$data['body']='report/report_grade';
		//$data['body']='report/grade';
		$data['title'] = "Report for grade";
		$data['breadcrumb']='Pay Range Analysis';
		$this->load->view('common/structure',$data);	
	}
	
	public function json_for_grade($rpt_for="Base")
	{
		$res= $this->Report_model->grade($rpt_for);
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['Grade'][] = $r;
		}
		
			$res=$res['Grade'];
			$last=end($res);
			echo '[';
			foreach($res as $k=>$val)
			{ 
				 if($val['Grade']==$last['Grade'])
						{
							$commaa='';
						}
						else 
						{
						  $commaa=',';  
						}

				?>
			   {

					"categorie": "<?php echo $val['Grade'] ?>", 
					"values": [
					<?php foreach($val as $key=>$v) {

						if($key!='Grade'){

						if($key=='Maximum')
						{
							$comma='';
						}
						else 
						{
						  $comma=',';  
						}

						?>

						{
							"value": <?php echo round($v,2) ?>, 
							"rate": "<?php echo $key ?>"
						}<?php echo $comma; } ?> 



							<?php } ?>   
							]
						}<?php echo $commaa ?>

					<?php }
	?>
	 ]
	 <?php
	}
		
	public function level($id,$rpt_for="Base")
	{
	  $res= $this->Report_model->level($rpt_for);
	  $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['Level'][] = $r;
		}
		$data['res']=$res;
		$data['graphurl']=base_url('report/json_for_level');
		$data['body']='report/all_report';
		$data['title'] = "Report for level";
		$data['breadcrumb']='Pay Range Analysis';
	   //  $data['body']='report/level';
		$this->load->view('common/structure',$data);
		//$this->load->view('report/level',$data);  
	}
	
	public function json_for_level($rpt_for="Base")
	{
		$res= $this->Report_model->level($rpt_for);
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['Level'][] = $r;
		}
		
			$res=$res['Level'];
			$last=end($res);
			echo '[';
			foreach($res as $k=>$val)
			{ 
				 if($val['Level']==$last['Level'])
						{
							$commaa='';
						}
						else 
						{
						  $commaa=',';  
						}

				?>
			   {

					"categorie": "<?php echo $val['Level'] ?>", 
					"values": [
					<?php foreach($val as $key=>$v) {

						if($key!='Level'){

						if($key=='Maximum')
						{
							$comma='';
						}
						else 
						{
						  $comma=',';  
						}

						?>

						{
							"value": <?php echo round($v) ?>, 
							"rate": "<?php echo $key ?>"
						}<?php echo $comma; } ?> 



							<?php } ?>   
							]
						}<?php echo $commaa ?>

					<?php }
	?>
	 ]
	 <?php
	}
	
	public function designation($id,$rpt_for="Base")
	{
		$res= $this->Report_model->designation($rpt_for);
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['DesignationTitle'][] = $r;
		}
		$data['res']=$res;
		$data['breadcrumb']='Pay Range Analysis';
		$data['graphurl']=base_url('report/json_for_desg');
		$data['title'] = "Report for designation";
		$data['body']='report/report_designation';
		$this->load->view('common/structure',$data);
		//$this->load->view('report/desig',$data); 
	}
	
	public function json_for_desg($rpt_for="Base")
	{
		$res= $this->Report_model->designation($rpt_for);
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	   foreach($res as $r)
		{
				$res['DesignationTitle'][] = $r;
		}
		
			$res=$res['DesignationTitle'];
			$last=end($res);
			echo '[';
			foreach($res as $k=>$val)
			{ 
				 if($val['DesignationTitle']==$last['DesignationTitle'])
						{
							$commaa='';
						}
						else 
						{
						  $commaa=',';  
						}

				?>
			   {

					"categorie": "<?php echo $val['DesignationTitle'] ?>", 
					"values": [
					<?php foreach($val as $key=>$v) {

						if($key!='DesignationTitle'){

						if($key=='Maximum')
						{
							$comma='';
						}
						else 
						{
						  $comma=',';  
						}

						?>

						{
							"value": <?php echo round($v) ?>, 
							"rate": "<?php echo $key ?>"
						}<?php echo $comma; } ?> 



							<?php } ?>   
							]
						}<?php echo $commaa ?>

					<?php }
	?>
	 ]
	 <?php
	}
	
	public function budget($pc_id=0)
	{
		$data['breadcrumb']='Budget Utilization Against Allocated Budget';
		$data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		if(($data["salary_cycles_list"]) and $pc_id==0)
		{
			redirect(site_url("report/budget/".$data["salary_cycles_list"][0]["id"]));
		}
		$performance_cycle_dtls = $this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
	
	$managers_budget_arr = array();
	$funct_arr = $this->rule_model->get_table("manage_function", "id, `name` as label, (select 0) AS allocated_budget, (select 0) AS actual_used_budget, (select 0) AS variance", "status = 1", "name asc");
	$salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.status >="=>6,"hr_parameter.status !="=>8));
			
	
	foreach($salary_rule_list as $rule_row)
	{
		$managers_arr = json_decode($rule_row['manual_budget_dtls'],true);
		foreach($managers_arr as $row)
		{
			$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_row['user_ids'].") and row_owner.first_approver='".$row[0]."'");

			$arr = array("email"=>$row[0], "rule_id"=>$rule_row["id"], "used_manager_budget" => 0);
			$arr['alloted_manager_budget'] = $row[1] + (($row[1]*$row[2])/100);
			
			if($managers_emp_arr)
			{
				$manager_used_budget = $this->rule_model->get_table_row("employee_salary_details", "sum(final_salary - increment_applied_on_salary) as manager_used_budget", "rule_id = ".$rule_row['id']." and user_id in (".implode(",",$managers_emp_arr).")", "id asc");
				
				$arr['used_manager_budget'] = $manager_used_budget["manager_used_budget"];
				$managers_budget_arr[] = $arr;
			}
		}
	}
	
	$final_funct_arr = array();

	foreach($funct_arr as $row)
	{
		foreach($managers_budget_arr as $manger)
		{
			$flag = $this->rule_model->get_table_row("login_user", "id", array("function_id"=>$row['id'], "email"=>$manger["email"]), "id asc");
			if($flag)
			{
				$row["allocated_budget"] += $manger["alloted_manager_budget"];
				$row["actual_used_budget"] += $manger["used_manager_budget"];
				$row["variance"] = $row["allocated_budget"] - $row["actual_used_budget"];
			}
		}
		if($row["allocated_budget"]>0)
		{
			$final_funct_arr['Grade'][] = $row;
		}
	}
			$data['res']=$final_funct_arr;
			if(!$final_funct_arr)
			{
				$data['msg']='<div style="color: red; position: absolute; text-align: center;  top: 25%; left: 50%;">Data not found.</div>';
			}
			$data['graphurl']=base_url('report/json_budget/'.$pc_id);
			$data['body']='report/budget';
			$data['title'] = "Report for Allocated Budget";
			$this->load->view('common/structure',$data);
	}

    public function json_budget($pc_id)
	{
        $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		$performance_cycle_dtls = $this->performance_cycle_model->get_performance_cycle_dtls(array("id"=>$pc_id, "status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
		if(!$performance_cycle_dtls)
		{
			redirect(site_url("performance-cycle"));
		}
		$managers_budget_arr = array();
		$funct_arr = $this->rule_model->get_table("manage_function", "id, `name` as label, (select 0) AS allocated_budget, (select 0) AS actual_used_budget, (select 0) AS variance", "status = 1", "name asc");
		$salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id, "hr_parameter.status >="=>6,"hr_parameter.status !="=>8));
                
		if(!$salary_rule_list)
                {
                    redirect(site_url("performance-cycle"));
                }
		foreach($salary_rule_list as $rule_row)
		{
			$managers_arr = json_decode($rule_row['manual_budget_dtls'],true);
			foreach($managers_arr as $row)
			{
				$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_row['user_ids'].") and row_owner.first_approver='".$row[0]."'");

				$arr = array("email"=>$row[0], "rule_id"=>$rule_row["id"], "used_manager_budget" => 0);
				$arr['alloted_manager_budget'] = $row[1] + (($row[1]*$row[2])/100);
				
				if($managers_emp_arr)
				{
					$manager_used_budget = $this->rule_model->get_table_row("employee_salary_details", "sum(final_salary - increment_applied_on_salary) as manager_used_budget", "rule_id = ".$rule_row['id']." and user_id in (".implode(",",$managers_emp_arr).")", "id asc");
					
					$arr['used_manager_budget'] = $manager_used_budget["manager_used_budget"];
					$managers_budget_arr[] = $arr;
				}
			}
		}
		
		$final_funct_arr = array();

		foreach($funct_arr as $row)
		{
			foreach($managers_budget_arr as $manger)
			{
				$flag = $this->rule_model->get_table_row("login_user", "id", array("function_id"=>$row['id'], "email"=>$manger["email"]), "id asc");
				if($flag)
				{
					$row["allocated_budget"] += $manger["alloted_manager_budget"];
					$row["actual_used_budget"] += $manger["used_manager_budget"];
					$row["variance"] = $row["allocated_budget"] - $row["actual_used_budget"];
				}
			}
			if($row["allocated_budget"]>0)
			{
				$final_funct_arr['Grade'][] = $row;
			}
		}
                $data['res']=$final_funct_arr;
                if(!$final_funct_arr)
                {
                    $data['msg']='<div style="color: red; position: absolute; text-align: center;  top: 25%; left: 50%;">Data not found.</div>';
                }
                $res=$final_funct_arr['Grade'];
                //echo '<pre />';print_r($res);
                $last=end($res);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     if($val['variance']==$last['variance'])
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['label'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='label' && $key!='id'){
                              //echo $key;  
                            if($key=='variance')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php }
        ?>
         ]
         <?php
                 
		
	}
        
	public function salary_increase_both($id)
	{
                $rpt_data = $this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", "func.id, func.name, empsal.performance_rating,
                    
                    min(empsal.manager_discretions)  as 'Minimum_hike',
                    avg(empsal.manager_discretions) as 'Average_hike',max(empsal.manager_discretions) as 'Maximum_hike'", "lusr.id = empsal.user_id
                    and lusr.function_id = func.id
                    group by func.id, func.name, empsal.performance_rating", "lusr.id asc");
                $data['res']=$rpt_data;
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_for_both_increase_salary');
                $data['body']='report/salary_increase_range';
				$data['title'] = "Salary Increase Range Analysis";
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
            }
			
	public function json_for_both_increase_salary()
	{
            $rpt_data = $this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", "func.id, func.name, empsal.performance_rating,
                    
                    min(empsal.manager_discretions)  as 'Minimum_hike',
                    avg(empsal.manager_discretions) as 'Average_hike',max(empsal.manager_discretions) as 'Maximum_hike'", "lusr.id = empsal.user_id
                    and lusr.function_id = func.id
                    group by func.id, func.name, empsal.performance_rating", "lusr.id asc");
            
                $res=$rpt_data;
                $last=end($res);
				$k=1;
                //print_r($last);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     //if($val['name']==$last['name'])
					 if((count($res)-1)==$k)
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['name'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='name' && $key!='id' && $key!='performance_rating'){

                            if($key=='Maximum_hike')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php $k++;}
        ?>
         ]
         <?php
        } 
		   
	public function get_salary_increase_rpt_data_function($id)
	{ 
                $rpt_data = $this->Report_model->get_salary_increase_rpt_data_function();
                $data['res']=$rpt_data;//echo "<pre>";print_r($rpt_data);die;
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_get_salary_increase_rpt_data_function');
                $data['body']='report/salary_increase_range';
				$data['title'] = "Salary Increase Range Analysis";
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
        }
        
	public function json_get_salary_increase_rpt_data_function()
	{
            $rpt_data = $this->Report_model->get_salary_increase_rpt_data_function();
            
                $res=$rpt_data;
                $last=end($res);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     if($val['name']==$last['name'])
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['name'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='name' && $key!='id' && $key!='performance_rating'){

                            if($key=='Maximum_hike')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php }
        ?>
         ]
         <?php
        }    
        
	public function get_salary_increase_rpt_data_rating($id)
	{ 
                $rpt_data = $this->Report_model->get_table("employee_salary_details empsal", "empsal.performance_rating, max(empsal.manager_discretions) as 'Maximum_hike', min(empsal.manager_discretions) as 'Minimum_hike', avg(empsal.manager_discretions) as 'Average_hike'", "", "id asc", "empsal.performance_rating");
                $data['res']=$rpt_data;
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_get_salary_increase_rpt_data_rating');
                $data['body']='report/salary_increase_range';
				$data['title'] = "Salary Increase Range Analysis";
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
            }
			
	public function json_get_salary_increase_rpt_data_rating()
	{
             $rpt_data = $this->Report_model->get_table("employee_salary_details empsal", "empsal.performance_rating, max(empsal.manager_discretions) as 'Maximum_hike', min(empsal.manager_discretions) as 'Minimum_hike', avg(empsal.manager_discretions) as 'Average_hike'", "", "id asc", "empsal.performance_rating");
            
                $res=$rpt_data;
                $last=end($res);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     if($val['performance_rating']==$last['performance_rating'])
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['performance_rating'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='performance_rating' && $key!='id' && $key!='performance_rating'){

                            if($key=='Average_hike')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php }
        ?>
         ]
         <?php
        }     
        
	public function get_crr_rpt_data_function($rule)
	{	
                $rule_id = $rule;
                $rule_dtls = $this->rule_model->get_table_row("hr_parameter", "comparative_ratio_range", array("id"=>$rule_id), "id asc");			
                $i=0;
                $str = "func.id, func.name,";
                $crr_range_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                foreach($crr_range_arr as $row)
                {  
                        if($i==0)
                        { 
                                $str .= "COUNT(CASE WHEN empsal.crr_val < ".$row["max"]." THEN 1 ELSE 0 END) AS '<".$row["max"]."',";
                        }                                
                        else
                        {
                                $str .= "COUNT(CASE WHEN ((empsal.crr_val >= ".$row["min"].") AND(empsal.crr_val < ".$row["max"].")) THEN 1 ELSE 0 END) AS '".$row["min"]."-".$row["max"]."',";
                        }

                        if(($i+1)==count($crr_range_arr))
                        {
                                $str .= "COUNT(CASE WHEN (empsal.crr_val >= ".$row["max"].") THEN 1 ELSE 0 END) AS '>".$row["max"]."'";
                        }                            
                        $i++;
                }

                $rpt_data = $this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", $str, "lusr.id = empsal.user_id 
                AND lusr.function_id = func.id 
                group by func.id, func.name", "lusr.id asc");
               $data['res']=$rpt_data; 
               $data['breadcrumb']='Population Distribution on CR Range';
               $data['rule']= $this->Report_model->GetRule();
               $data['graphurl']=base_url('report/json_get_crr_rpt_data_function/'.$rule);
               $data['body']='report/crr_report';
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);  
        }
        
	public function json_get_crr_rpt_data_function($rule)
	{
            
                $rule_id = $rule;
                $rule_dtls = $this->rule_model->get_table_row("hr_parameter", "comparative_ratio_range", array("id"=>$rule_id), "id asc");			
                $i=0;
                $str = "func.id, func.name,";
                $crr_range_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                foreach($crr_range_arr as $row)
                {  
                        if($i==0)
                        { 
                                $str .= "COUNT(CASE WHEN empsal.crr_val < ".$row["max"]." THEN 1 ELSE 0 END) AS '<".$row["max"]."',";
                        }                                
                        else
                        {
                                $str .= "COUNT(CASE WHEN ((empsal.crr_val >= ".$row["min"].") AND(empsal.crr_val < ".$row["max"].")) THEN 1 ELSE 0 END) AS '".$row["min"]."-".$row["max"]."',";
                        }

                        if(($i+1)==count($crr_range_arr))
                        {
                                $str .= "COUNT(CASE WHEN (empsal.crr_val >= ".$row["max"].") THEN 1 ELSE 0 END) AS '>".$row["max"]."'";
                        }                            
                        $i++;
                }

                $rpt_data = $this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", $str, "lusr.id = empsal.user_id 
                AND lusr.function_id = func.id 
                group by func.id, func.name", "lusr.id asc");
//                echo '<pre />';
//                print_r($res);
                $res=$rpt_data;
                $last=end($res);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     if($val['name']==$last['name'])
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['name'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='name' && $key!='id' && $key!='name'){

                            if($key=='>1.2' || $key=='>120')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php }
        ?>
         ]
         <?php
        }   
		
	public function get_crr_rpt_data_rating($rule)
	{			
		$data['breadcrumb']='Population Distribution on CR Range';
		$data['rule']= $this->Report_model->GetRule();
		$data['graphurl']=base_url('report/json_get_crr_rpt_data_rating/'.$rule);
		$data['body']='report/crr_report';
		//  $data['body']='report/level';
		$this->load->view('common/structure',$data);  
	}
	
        public function json_get_crr_rpt_data_rating($rule)
        {
             $rule_id = $rule;
                    $rule_dtls = $this->rule_model->get_table_row("hr_parameter", "comparative_ratio_range", array("id"=>$rule_id), "id asc");			
                    $i=0;
                    $str = "empsal.performance_rating,";
                    $crr_range_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                    foreach($crr_range_arr as $row)
                    {  
                            if($i==0)
                            { 
                                    $str .= "COUNT(CASE WHEN empsal.crr_val < ".$row["max"]." THEN 1 ELSE 0 END) AS '<".$row["max"]."',";
                            }                                
                            else
                            {
                                    $str .= "COUNT(CASE WHEN ((empsal.crr_val >= ".$row["min"].") AND(empsal.crr_val < ".$row["max"].")) THEN 1 ELSE 0 END) AS '".$row["min"]."-".$row["max"]."',";
                            }

                            if(($i+1)==count($crr_range_arr))
                            {
                                    $str .= "COUNT(CASE WHEN (empsal.crr_val >= ".$row["max"].") THEN 1 ELSE 0 END) AS '>".$row["max"]."'";
                            }                            
                            $i++;
                    }

                    $rpt_data = $this->Report_model->get_table("employee_salary_details empsal", $str, "", "id asc", "empsal.performance_rating");
            
                $res=$rpt_data;
                $last=end($res);
                echo '[';
                foreach($res as $k=>$val)
                { 
                     if($val['performance_rating']==$last['performance_rating'])
                            {
                                $commaa='';
                            }
                            else 
                            {
                              $commaa=',';  
                            }

                    ?>
                   {

                        "categorie": "<?php echo $val['performance_rating'] ?>", 
                        "values": [
                        <?php foreach($val as $key=>$v) {

                            if($key!='performance_rating' && $key!='id' && $key!='performance_rating'){

                            if($key=='>120' || $key=='>1.2')
                            {
                                $comma='';
                            }
                            else 
                            {
                              $comma=',';  
                            }

                            ?>

                            {
                                "value": <?php echo round($v) ?>, 
                                "rate": "<?php echo ucfirst(str_replace('_',' ',$key)) ?>"
                            }<?php echo $comma; } ?> 



                                <?php } ?>   
                                ]
                            }<?php echo $commaa ?>

                        <?php }
        ?>
         ]
         <?php
        }  
        function paymix()
        {
            $data['title'] = "Paymix report";
            $data['body']='report/pay_mix';
            $this->load->view('common/structure',$data);	
            
        }
		
		function paymix_new()
        {
            $data['title'] = "Paymix Report";
            $data['body']='report/paymix_new';
            $this->load->view('common/structure',$data);	
        }
		
        public function compposition()
        {
            $data['salary_cycles_list']= $this->rule_model->get_performance_cycles_for_api(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
            $data['title'] = "Comp Positioning Report";
			$data['body']='report/compposition';
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
			$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
			$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
			$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
			$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
            $this->load->view('common/structure',$data);	
            
		}


        public function salary_analysis()
        {
            $data['salary_cycles_list']= $this->rule_model->get_performance_cycles_for_api(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
            $data['title'] = "Salary Increase Range Report";
			$data['body']='report/salary_analysis';
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
			$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
			$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
			$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
			$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
            $this->load->view('common/structure',$data);	
		}


		public function salary_increase_budget()
        {
            $data['salary_cycles_list']= $this->rule_model->get_performance_cycles_for_api(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
            $data['title'] = "Salary Increase Budget Report";
			$data['body']='report/salary_budget';
			$business_attributes_cond_arr = array('status' => 1);
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", $business_attributes_cond_arr , "id asc");
			$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
			$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
			$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
			$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
            $this->load->view('common/structure',$data);
		}

		public function employee_salary_increase()
        {
            $data['salary_cycles_list']= $this->rule_model->get_performance_cycles_for_api(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
            $data['title'] = "Salary Increase Report";
			$data['body']='report/salary_increase';
			$business_attributes_cond_arr = array('status' => 1);
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", $business_attributes_cond_arr , "id asc");
			$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
			$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
			$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
			$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
            $this->load->view('common/structure',$data);
		}

		/*
		* get rule wise compposition report
		*/
		public function get_compposition_rule_wise() {

			$salary_rule_list = $this->rule_model->get_rule_dtls_with_plan(array("performance_cycle.status"=>1, "performance_cycle.type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
			$implode_variable = '&&';

			if(!empty($salary_rule_list)) {

				foreach($salary_rule_list as $key => $det) {

					$salary_rule_list[$key]['plan_rule_id'] = $det['performance_cycle_id'].$implode_variable.$det['id'];
				}
			}

			$data['salary_rule_list']= $salary_rule_list;
			$data['implode_variable']= $implode_variable;
            $data['title'] = "Comp Positioning Report";
			$data['body']='report/compposition_rule_wise';
			$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", "", "id asc");
			$attribute_details = get_business_attribute_display_name_array($data['business_attributes'], true);
			$data['display_field_name_array'] = $attribute_details['display_name_field_array'];
			$data['datakey_array'] = $attribute_details['attibute_field_name_array'];
			$data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);
            $this->load->view('common/structure',$data);

		}


        function payRange($type='base_salary')
        {
            $arr = "";
            if($this->session->userdata('keyword'))
            {
                    $arr = "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
            }

            $data['keyword'] =	$this->session->userdata('keyword');
            $this->session->unset_userdata('keyword');
            $staff_list = $this->admin_model->get_staff_list_for_download($arr);	
            $staff_list=GetEmpAllDataForPayRange($staff_list,$type);
            $data['breadcrumb']='Pay Range Report';
            $data['staff']=$staff_list; 
            $data['report_for']=$type;
            $data['title'] = "Pay Range Report";
            $data['body']='report/pay_range';
            $this->load->view('common/structure',$data);	
            
        }
        
        function payRangeAjax($type)
        {
            $arr = "";
            if($this->session->userdata('keyword'))
            {
                    $arr = "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
            }

            $data['keyword'] =	$this->session->userdata('keyword');
            $this->session->unset_userdata('keyword');
            $staff_list = $this->admin_model->get_staff_list_for_download($arr);	
            $staff_list=GetEmpAllDataForPayRange($staff_list,$type);
            $data['staff']=$staff_list;  
            $this->load->view('report/ajaxPayRange',$data);
        }
        function uti()
        {
           $data['cycle']=$this->Report_model->getAllCycle();
           $data['title'] = "Budget Utilisation Report";
           $data['breadcrumb']='Budget Utilisation';
           $data['body']='report/budget_utilization';
           $this->load->view('common/structure',$data);
           
        }
        function GetRules($cycleID)
        {
            $rules=$this->Report_model->getAllRulesOfCycle($cycleID);
//            echo '<pre />';
//            print_r($rules);
            $str.='<label style="color: #000 !important">Select Rule</label>';
            $str.='<select class="form-control" onchange="getRuleInfo(this.value)">';
            $str.='<option value="">Select Rule</option>';
            foreach($rules as $rule)
            {
                $str.="<option value='".$rule["id"].'+'.$rule["overall_budget"].'+'.$rule['manual_budget_dtls']."'>".$rule['salary_rule_name']."</option>";
            }
            $str.="</select>";
            echo $str;
        }
		
	public function get_managers_for_manual_bdgt()
	{
		$budget_type = $this->input->post("budget_type");
		$rule_id = $this->input->post("rid");
		if($rule_id)
		{
			$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);
                        //echo '<pre />';
//                        print_r($managers);
			if($managers)
			{
				$str_main = '<table class="table table-bordered" id="rtt"><thead>';
                                $str = '<tr>';

                                $str .= '<th>Manager Name</th><th>No of Employees</th><th>Current Salary</th><th>Salary review budget as per the plan</th>'; 				$colspn = 4;

                                if($budget_type == "Manual") 
                                {
                                                        $colspn = 5;
                                        $str .= '<th>Final Budget</th>';  
                                    }
                                    if($budget_type == "Automated but x% can exceed") 
                                {
                                                        $colspn = 5;
                                        $str .= '<th>Additional budget (as %age of the allocated budget)</th>';  
                                    }
                                                $str .= '<th>Revised Budget</th><th>Utilized budget</th>'; 
                                $str .= '</tr></thead><tbody>';  
                                $t=0;
                                $totalEmp=0;
                                $emptotalB=0;
				$i=1;
                                $revised=0;
				foreach ($managers as $row)
				{
					$manager_emp_budget_dtls = $this->calculate_budgt_manager_wise($rule_id, $row['first_approver']);
//                                        echo '<pre />';
//                                        print_r($manager_emp_budget_dtls); die;
                                        $manager_budget = $manager_emp_budget_dtls["budget"];
					$str .= '<tr><td>';
					if($row['manager_name'])
					{
				    	$str .= $row['manager_name'];
					}
					else
					{
						$str .= $row['first_approver'];
					}              
                                $t=$t+$manager_budget;
                                $revised=$revised+$manager_budget;
                                $totalEmp=$totalEmp+$manager_emp_budget_dtls["total_emps"];
                                $emptotalB=$emptotalB+$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"];
                                $str .= '</td>'
                                        . '<td class="txtalignright">'.$manager_emp_budget_dtls["total_emps"].'</td>'
                                        . '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]).'</td>'
                                        . '<td class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_budget).'
	              			<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" id="hf_pre_calculated_budgt_'.$i.'"/>
					<input type="hidden" value="'.$manager_emp_budget_dtls["managers_emps_tot_incremental_amt"].'" id="hf_incremental_amt_'.$i.'" />
	              			<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

                                if($budget_type == "Manual") 
                                {		
                                    $str .= '<td>'.$manager_emp_budget_dtls['currency']['currency_type'].'<input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.$manager_budget.'"  maxlength="12" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" required="required" onChange="calculat_percent_increased_val(1,this.value, '.$i.')">
                                    </td>';
			        }
			       
			        if($budget_type == "Automated but x% can exceed") 
                                {
                                    $str .= '<td>'.$manager_emp_budget_dtls['currency']['currency_type'].'<input type="text" class="form-control" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value=""  maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" required="required"  onChange="calculat_percent_increased_val(2,this.value, '.$i.')"></td>';
                                }
                                $str .= '<td id="td_revised_bdgt_'.$i.'" class="txtalignright">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_budget).'</td>';
                                $str .= '<td id="td_increased_amt_'.$i.'" class="txtalignright">'.HLP_get_formated_amount_common($manager_emp_budget_dtls["managers_emps_tot_incremental_amt"]).'</td>';
			        $str .= '</tr>';
				$i++;
				}
                    
				$str_main .='<tr class="tablealign"><th style="text-align: right;"><input type="hidden" value="'.$i.'" id="hf_manager_cnt"/>Total&nbsp;</th><th> '.HLP_get_formated_amount_common(round($totalEmp)).'</th><th>'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($emptotalB)).'</th><th id="th_total_budget">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($t)).'</th><th>'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($revised)).'</th><th colspan=2 id="th_total_budget">'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(round($t)).'</th></tr>';
				$str_main .= $str;
				$str_main .= '</tbody></table>'; 
				echo $str_main;
			}
			else
			{
				echo "";
			}
		}
	}
    
	public function calculate_budgt_manager_wise($rule_id, $manager_email)
	{	
		$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		
		$total_max_budget = 0;
		$managers_emps_tot_incremental_amt = 0;
		$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_dtls['user_ids'].") and row_owner.first_approver='".$manager_email."'");
//                echo '<pre />';
//                print_r($currency); die;
		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;
                        $currency = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$employee_id));
//                        echo '<pre />';
//                print_r($currency); die;
			$increment_applied_on_amt = 0;
			$performnace_based_increment_percet=0;

			$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
			
			/*$increment_applied_on_arr = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_INCREMENT_APPLIED_ON));

			if($increment_applied_on_arr)
			{
				$increment_applied_on_amt = $increment_applied_on_arr[0]["uploaded_value"];
			}*/
			
			$increment_applied_on_arr = $this->rule_model->get_salary_applied_on_elements_val($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], $rule_dtls["salary_applied_on_elements"]);

			if($increment_applied_on_arr)
			{
				foreach($increment_applied_on_arr as $salary_elem)
				{
					if($salary_elem["value"])
					{
						$increment_applied_on_amt += $salary_elem["value"];
					}
				}
			}
			
			$emp_salary_rating = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));

			$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$performnace_based_increment_percet = $value;
					}
				}			
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}

			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);

			$emp_market_salary = 0;
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);

			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
						$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
						$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
					}
				}
			}
			else
			{
				$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
				$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
				$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
			}			

			$crr_per = 0;
			if($emp_market_salary > 0)
			{
				$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;//$performnace_based_salary/$emp_market_salary;
				if($rule_dtls["comparative_ratio"] == "yes")
				{
					$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
				}
			}

			$i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $row1)
			{			
				if($i==0)
				{ 
					if($crr_per < $row1["max"])
					{
						break;
					}
				}
				elseif(($i+1)==count($crr_arr))
				{
					if($crr_per >= $row1["max"])
					{
						break;
					}
				}
				else
				{
					if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
					{
						break;
					}
				}
				$i++; 
			}

			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;	
			$crr_based_increment_percet = 0;
			$j=0;
			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value) 
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
					}
					$j++;
				}
			}
			else
			{
				$crr_based_increment_percet =  $crr_tbl_arr[$j];
			}
			//CB:: Ravi on 22-12-17
			//$current_emp_total_salary = ($increment_applied_on_amt) + (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($increment_applied_on_amt*$rule_dtls["standard_promotion_increase"])/100) + (($crr_based_increment_percet*$performnace_based_increment_percet)/100);
			//$total_max_budget += $current_emp_total_salary;
			$total_max_budget += (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100);
			$managers_emps_tot_incremental_amt += $increment_applied_on_amt;	
		}
		//return $total_max_budget;
		return array("total_emps"=>count($managers_emp_arr), "budget"=>$total_max_budget, "managers_emps_tot_incremental_amt"=>$managers_emps_tot_incremental_amt,"currency"=>$currency);
	}
        
	public function dbreports()
	{
		$data['breadcrumb']='Database Reports';
		$data['title']='Database Reports';
		$data['body']='report/db_reports';
		$this->load->view('common/structure',$data);
	}
	
	public function salaryReport($cycleID='')
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
				$data['report']=$hr_emps_data_arr;
				$data['body']='report/bonus_review';
				$this->load->view('report/bonus_review',$data);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;
				$data['body']='report/bonus_review';
				$this->load->view('report/bonus_review',$data);
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
			$salary_rule_list = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$scl['id']));
			if(count($salary_rule_list)!=0)
			{
				foreach($salary_rule_list as $srl)
				{
					//clean($scl['name'])
					$ruleArr[]=$this->Report_model->get_rule_wise_emp_list_for_increments_for_api_comp_graph($srl['id'], $arr);
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
				//$emp['crr_val'] = $emp['crr_val']*100;
				//$emp['comparative_ratio_range']=$rang;
				$empArr[]= $emp;
			}
		}
		for($i=0;$i<count($empArr);$i++)
		{
			foreach($empArr[$i] as $k=>$v)
			{
				if(in_array($k,$allowanceAyy))
				{
					$ba_name=$this->Report_model->getbusiness_attributeDisplayname('business_attribute',array('ba_name'=>str_replace('_',' ',$k),'status'=>'1'));
 
					if($ba_name[0]['status']==1)
					{
						//$k=$ba_name[0]['display_name'];
						$empArr[$i][$k]= $empArr[$i][$k];
						$empArr[$i][$ba_name[0]['display_name']] = $empArr[$i][$k];
						unset($empArr[$i][$k]);
						//                     $empArr[$i][$k]= array(
						//                                            'name'=>$ba_name[0]['display_name'],
						//                                            'value'=> $empArr[$i][$k]
						//                                           );
					}
					else 
					{
						unset($empArr[$i][$k]);
					}
				}
			}
		}
		$data['report']=$empArr;
		$data['body']='report/bonus_review';
		$this->load->view('report/bonus_review',$data);
    }
	
	public function bonus_review()
	{
		$data['breadcrumb']='Bonus Review';
		$data['title']='Bonus Review';
		$data['body']='report/bonus_review';
		
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "employee_bonus_details.user_id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "employee_bonus_details.user_id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
	
		$data['report']=$this->Report_model->bonus_review($arr);		
		$this->load->view('report/bonus_review',$data);
	}
		
	public function lti_review()
	{
		$data['breadcrumb']='LTI Review';
		$data['title']='LTI Review';
		$data['body']='report/bonus_review';
		
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr = "employee_lti_details.user_id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr = "employee_lti_details.user_id in (".$hr_emps_arr.")";
			}
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		$data['report']=$this->Report_model->lti_review($arr);
		$this->load->view('report/bonus_review',$data);
	}
		
	public function rnrreport()
	{
		$data['body']='report/bonus_review';
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$data['report']=$hr_emps_data_arr;		
				$this->load->view('report/bonus_review',$data);
				exit;	
			}
		}
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		$report=[];
		$rnr=$this->Report_model->getRNRInfoForDBReport();
		foreach($rnr as $rinfo)
		{
			$usrid=explode(',',$rinfo['user_ids']);
			foreach($usrid as $usr)
			{
				if($hr_emps_arr)// It is true for HR/MAnager case only
				{					
					if(!in_array($usr, $hr_emps_arr))
					{
						continue;
					}					
				}
				
				$ui=$this->Report_model->GetRnrDetailForEmp($usr);
				$report[]=(array_merge($ui[0],$rinfo)); 
				
			}			
		}
		foreach($report as $key=>$rr)
		{
			foreach($rr as $k=>$v)
			{
				if($k=='user_ids')
				{
					unset($report[$key][$k]);
				}
			}		  
		}
		$data['report']=$report;		
		$this->load->view('report/bonus_review',$data);
	}


	/* CB -Harshit
    public function salarySummery()
	{	
		$salaryRules=$this->Report_model->SalaryRules();
		$fdata=[];
		foreach($salaryRules as $sr)
		{
			$mangers=json_decode($sr['manual_budget_dtls']) ;  
			foreach($mangers as $mm)
			{
				$rule_id=$sr['id']; 
				$manager_email=$mm[0];
				$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			
				$total_max_budget = 0;
				$managers_emps_tot_incremental_amt = 0;
				$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_dtls['user_ids'].") and row_owner.first_approver='".$manager_email."'");
						
				foreach($managers_emp_arr as $row)
				{
					$employee_id = $row;
					$currency = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$employee_id));
					$increment_applied_on_amt = 0;
					$performnace_based_increment_percet=0;
		
					$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
					
					$increment_applied_on_arr = $this->rule_model->get_salary_applied_on_elements_val($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], $rule_dtls["salary_applied_on_elements"]);
		
					if($increment_applied_on_arr)
					{
						foreach($increment_applied_on_arr as $salary_elem)
						{
							if($salary_elem["value"])
							{
								$increment_applied_on_amt += $salary_elem["value"];
							}
						}
					}
					
					$emp_salary_rating = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));
		
					$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($rating_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
							{
								$performnace_based_increment_percet = $value;
							}
						}			
					}
					else
					{
						$performnace_based_increment_percet = $rating_dtls["all"];
					}
		
					$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);
		
					$emp_market_salary = 0;
					$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
		
					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($comparative_ratio_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
							{
								$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
								$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
								$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
							}
						}
					}
					else
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
						$emp_market_salary_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
						$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
					}			
		
					$crr_per = 0;
					if($emp_market_salary > 0)
					{
						$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
						if($rule_dtls["comparative_ratio"] == "yes")
						{
							$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
						}
					}
		
					$i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
					foreach($crr_arr as $row1)
					{			
						if($i==0)
						{ 
							if($crr_per <= $row1["max"])
							{
								break;
							}
						}
						elseif(($i+1)==count($crr_arr))
						{
							if($row1["max"] > $crr_per)
							{
								break;
							}
						}
						else
						{
							if($row1["min"] < $crr_per and $crr_per <= $row1["max"])
							{
								break;
							}
						}
						$i++; 
					}
		
					$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
					$crr_tbl_arr = $crr_tbl_arr_temp[$i];
					$rang_index = $i;	
					$crr_based_increment_percet = 0;
					$j=0;

					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($comparative_ratio_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
							{
								$crr_based_increment_percet =  $crr_tbl_arr[$j];
							}
							$j++;
						}
					}
					else
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
					}

					$total_max_budget += (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100);
					$managers_emps_tot_incremental_amt += $increment_applied_on_amt;	
				}

				$fdata[]= array(
								"manager_name"=>$currency['name'],
								"budget"=>$total_max_budget, "Used_budget"=>round($managers_emps_tot_incremental_amt),
								"currency"=>$currency['currency_type'],
								'Variance'=>round($total_max_budget-$managers_emps_tot_incremental_amt),
								'Perrcentage'=>HLP_get_formated_percentage_common($total_max_budget/$managers_emps_tot_incremental_amt*100),
								"total_employee"=>count($managers_emp_arr));
			}
		}
		
		$data['report']=$fdata;		
		$data['body']='report/bonus_review';
		$this->load->view('report/bonus_review',$data);
	}

	public function bonusSummery()
	{	
        $bonusRules=$this->Report_model->BonusRules();
         //echo '<pre />';
         $fd=[];
        foreach($bonusRules as $br)
        {
          $mangers=json_decode($br['manual_budget_dtls']) ;  
          //print_r($mangers);
         
	        foreach($mangers as $mm)
	        {
	            $rule_id=$br['id'];
	            $manager_email=$mm[0];
	            //print_r($rule_id); die;
	            $rule_dtls =  $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));		
			
				$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$rule_dtls['user_ids'].") and row_owner.first_approver='".$manager_email."'");
			
				$total_max_budget = 0;
				$managers_emps_tot_incremental_amt = 0;
				foreach($managers_emp_arr as $row)
				{
					$employee_id = $row;
	                $currency = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$employee_id));
					$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
				
					$bonus_applied_on_arr = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_BONUS_APPLIED_ON));
					$bonus_applied_on_amt = $bonus_applied_on_arr[0]["uploaded_value"];

					$emp_salary_rating = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));

					$performnace_based_increment_percet=0;
					$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);

					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($rating_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if($key_arr[1] == $emp_salary_rating[0]["value"])
							{
								$performnace_based_increment_percet = $value;
							}
						}			
					}
					else
					{
						$performnace_based_increment_percet = $rating_dtls["all"];
					}
							
					$emp_function_dtls = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_FUNCTION));

					$emp_function_achievement = 0;
					$function_achievement_arr = json_decode($rule_dtls["function_achievement"],true);

					foreach ($function_achievement_arr as $key => $value) 
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if($key_arr[1] == $emp_function_dtls[0]["value"])
						{
							$emp_function_achievement = $value; break;
						}
					}			

					$total_bl_weightage = 0;
					$total_bl_weightage_score = 0;
					$total_weightage_score = 0;
					$business_level_arr = json_decode($rule_dtls["business_level"],true);
					$i = 0;
					foreach ($business_level_arr as $key => $value) 
					{				
						$total_bl_weightage += $value;
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						$emp_business_level_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$key_arr[0]));

						$business_level_achievement_arr = json_decode($rule_dtls["business_level_achievement"],true);

						foreach ($business_level_achievement_arr[$i] as $k => $v) 
						{
							$k_arr =  explode(CV_CONCATENATE_SYNTAX, $k);
							if($k_arr[1] == $emp_business_level_arr["value"])
							{
								$total_bl_weightage_score += ($value*$v)/100;
							}
						}				
						$i++;
					}

					$total_weightage_score = (($performnace_based_increment_percet*$rule_dtls["individaul_bussiness_level"])/100) + (($emp_function_achievement*$rule_dtls["function_weightage"])/100) + $total_bl_weightage_score;
					$final_bonus_per = $total_weightage_score;//($total_bl_weightage_score/$total_bl_weightage)*$performnace_based_increment_percet;			
					$total_max_budget += ($bonus_applied_on_amt*$final_bonus_per)/100;
					$managers_emps_tot_incremental_amt += $bonus_applied_on_amt;
				}
				$fd[]= array("Manager_name"=>$currency['name'],
	                 "budget"=>round($total_max_budget), 
	                //"managers_emps_total_incremental_amt"=>round($managers_emps_tot_incremental_amt),
	                "total_emps"=>count($managers_emp_arr),
	                'Percentage'=>HLP_get_formated_percentage_common(($total_max_budget/$managers_emps_tot_incremental_amt)*100, 2, '.', ','),
	                'Used_budget'=>round($managers_emps_tot_incremental_amt),
	                'Variance'=>round($total_max_budget-$managers_emps_tot_incremental_amt)
	            );
	        }
        }
        $data['report']=$fd;
        $data['body']='report/bonus_review';
        $this->load->view('report/bonus_review',$data);          
	}
	*/

    public function salarySummery()
	{	
		$salaryRules=$this->Report_model->SalaryRules();
		$fdata=[];
		foreach($salaryRules as $sr)
		{
			$mangers=json_decode($sr['manual_budget_dtls']) ;  
			foreach($mangers as $mm)
			{
				$rule_id=$sr['id']; 
				$manager_email=$mm[0];
				$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			
				$total_max_budget = 0;
				$managers_emps_tot_incremental_amt = 0;
				$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
	
				foreach($managers_emp_arr as $row)
				{
					$employee_id = $row;
					$employee_salary_dtls = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$employee_id));
					$increment_applied_on_amt = 0;
					$performnace_based_increment_percet=0;

					$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");						
					
					$currency_arr = $this->rule_model->get_emp_currency_dtls(array("login_user.id"=>$employee_id));
					$currency = array("currency_type"=>$currency_arr["name"]);
					$from_currency_id = $currency_arr["id"];
		
					$increment_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["salary_applied_on_elements"].")");
			
					if($increment_applied_on_arr)
					{
						foreach($increment_applied_on_arr as $salary_elem)
						{
							if($users_dtls[$salary_elem["ba_name"]])
							{
								$increment_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
							}
						}
					}
		
					$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($rating_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
							{
								$performnace_based_increment_percet = $value;
							}
						}			
					}
					else
					{
						$performnace_based_increment_percet = $rating_dtls["all"];
					}
		
					$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);
		
					$emp_market_salary = 0;
					$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
		
					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($comparative_ratio_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
							{
								$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
								$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
								$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
							}
						}
					}
					else
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
						
						$emp_market_salary_arr = $this->rule_model->get_salary_elements_list("ba_name", array("id"=>$val_arr[0]));
						$emp_market_salary = $users_dtls[$emp_market_salary_arr[0]["ba_name"]];
					}			
		
					$crr_per = 0;
					if($emp_market_salary > 0)
					{
						$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
						if($rule_dtls["comparative_ratio"] == "yes")
						{
							$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
						}
					}
		
					$i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
					foreach($crr_arr as $row1)
					{			
						if($i==0)
						{ 
							if($crr_per < $row1["max"])
							{
								break;
							}
						}
						elseif(($i+1)==count($crr_arr))
						{
							if($crr_per >= $row1["max"])
							{
								break;
							}
						}
						else
						{
							if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
							{
								break;
							}
						}
						$i++; 
					}
		
					$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
					$crr_tbl_arr = $crr_tbl_arr_temp[$i];
					$rang_index = $i;	
					$crr_based_increment_percet = 0;
					$j=0;

					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($comparative_ratio_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
							{
								$crr_based_increment_percet =  $crr_tbl_arr[$j];
							}
							$j++;
						}
					}
					else
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
					}

					$total_max_budget += (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100);
					$managers_emps_tot_incremental_amt += $increment_applied_on_amt;

					// $total_max_budget += HLP_convert_currency($from_currency_id, $to_currency_id, ((($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100)));
					// $managers_emps_tot_incremental_amt += HLP_convert_currency($from_currency_id, $to_currency_id,$increment_applied_on_amt);	
				}
				$fullname = ($employee_salary_dtls[CV_BA_NAME_EMP_FULL_NAME] !='') ? $employee_salary_dtls[CV_BA_NAME_EMP_FULL_NAME] : $employee_salary_dtls[CV_BA_NAME_EMP_EMAIL];
				$fdata[]= array(
								"manager_name"=>$fullname,
								"budget"=>$total_max_budget, "Used_budget"=>round($managers_emps_tot_incremental_amt),
								"currency"=>$currency['currency_type'],
								'Variance'=>round($total_max_budget-$managers_emps_tot_incremental_amt),
								'Perrcentage'=>HLP_get_formated_percentage_common($total_max_budget/$managers_emps_tot_incremental_amt*100),
								"total_employee"=>count($managers_emp_arr));
			}
		}
		$data['report']=$fdata;		
		$data['body']='report/bonus_review';
		$this->load->view('report/bonus_review',$data);
	}
	
    public function bonusSummery()
	{	
        $bonusRules=$this->Report_model->BonusRules("id, manual_budget_dtls");
        $fd=[];
        foreach($bonusRules as $br)
        {
          	$mangers=json_decode($br['manual_budget_dtls']);
	        foreach($mangers as $mm)
	        {
	            $rule_id=$br['id'];
	            $manager_email=$mm[0];
	            $rule_dtls =  $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
				$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$manager_email."'");
			
				$total_max_budget = 0;
				$managers_emps_tot_incremental_amt = 0;
				foreach($managers_emp_arr as $row)
				{
					$employee_id = $row;
	                $employee_bonus_dtls = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$employee_id));



					/*$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
				
					$bonus_applied_on_arr = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_BONUS_APPLIED_ON));*/
					$users_dtls = $this->rule_model->get_table_row("login_user", "*", array("id"=>$employee_id), "id desc");
					$bonus_applied_on_arr = $this->rule_model->get_salary_elements_list("ba_name","id IN(".$rule_dtls["bonus_applied_on_elements"].")");
					// $bonus_applied_on_amt = $bonus_applied_on_arr[0]["uploaded_value"];
					if($bonus_applied_on_arr)
					{
						foreach($bonus_applied_on_arr as $salary_elem)
						{
							if($users_dtls[$salary_elem["ba_name"]])
							{
								$bonus_applied_on_amt += $users_dtls[$salary_elem["ba_name"]];
							}
						}
					}

					// $emp_salary_rating = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));

					$performnace_based_increment_percet=0;
					$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);

					if($rule_dtls["performnace_based_hike"] == "yes")
					{
						foreach ($rating_dtls as $key => $value) 
						{
							$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
							if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]))
							{
								$performnace_based_increment_percet = $value;
							}
						}			
					}
					else
					{
						$performnace_based_increment_percet = $rating_dtls["all"];
					}
							
					// $emp_function_dtls = $this->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_FUNCTION));

					$emp_function_achievement = 0;
					$function_achievement_arr = json_decode($rule_dtls["function_achievement"],true);

					foreach ($function_achievement_arr as $key => $value) 
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if(($users_dtls[CV_BA_NAME_FUNCTION]) and strtoupper($key_arr[1]) == strtoupper($users_dtls[CV_BA_NAME_FUNCTION]))
						{
							$emp_function_achievement = $value; break;
						}
					}			

					$total_bl_weightage = 0;
					$total_bl_weightage_score = 0;
					$total_weightage_score = 0;
					$business_level_arr = json_decode($rule_dtls["business_level"],true);
					$i = 0;
					foreach ($business_level_arr as $key => $value) 
					{				
						$total_bl_weightage += $value;
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						// $emp_business_level_arr = $this->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$key_arr[0]));

						$business_level_achievement_arr = json_decode($rule_dtls["business_level_achievement"],true);

						foreach ($business_level_achievement_arr[$i] as $k => $v) 
						{
							$k_arr =  explode(CV_CONCATENATE_SYNTAX, $k);
							if($k_arr[1] == $emp_business_level_arr["value"])
							{
								$total_bl_weightage_score += ($value*$v)/100;
							}
						}				
						$i++;
					}

					$total_weightage_score = (($performnace_based_increment_percet*$rule_dtls["individaul_bussiness_level"])/100) + (($emp_function_achievement*$rule_dtls["function_weightage"])/100) + $total_bl_weightage_score;
					$final_bonus_per = $total_weightage_score;			
					$total_max_budget += ($bonus_applied_on_amt*$final_bonus_per)/100;
					$managers_emps_tot_incremental_amt += $bonus_applied_on_amt;
				}
				$fullname = ($employee_bonus_dtls[CV_BA_NAME_EMP_FULL_NAME] !='') ? $employee_bonus_dtls[CV_BA_NAME_EMP_FULL_NAME] : $employee_bonus_dtls[CV_BA_NAME_EMP_EMAIL];
				$fd[]= array("Manager_name"=>$fullname,
	                 "budget"=>round($total_max_budget), 
	                //"managers_emps_total_incremental_amt"=>round($managers_emps_tot_incremental_amt),
	                "total_emps"=>count($managers_emp_arr),
	                'Percentage'=>HLP_get_formated_percentage_common(($total_max_budget/$managers_emps_tot_incremental_amt)*100, 2, '.', ','),
	                'Used_budget'=>round($managers_emps_tot_incremental_amt),
	                'Variance'=>round($total_max_budget-$managers_emps_tot_incremental_amt)
	            );
	        }
        }
        $data['report']=$fd;
        $data['body']='report/bonus_review';
        $this->load->view('report/bonus_review',$data);          
	}
		
	/*public function RnrSummery()
	{
                $rnrRules=$this->Report_model->rnrRules();
                foreach($rnrRules as $rnr)
                {
                   $rule_id= $rnr['id'];
                   $budget_type = $rnr['budget_type'];
                   $award_val =$rnr['award_value'];//award value
                   $award_fr_val = $rnr['award_frequency']; // award frequency
                   $totlaEmp=explode(',',$rnr['user_ids']);
                   if($rule_id)
		{
			$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
			$managers = $this->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);
//                        echo '<pre />';
//                        print_r($managers);
			if($managers)
			{
				
               
                
				foreach ($managers as $row)
				{
					//$manager_budget = $this->calculate_budgt_manager_wise($rule_id, $row['first_approver']);
					
					$managers_emp_arr = $this->rule_model->get_managers_employees("row_owner.user_id in (".$data["rule_dtls"]['user_ids'].") and row_owner.first_approver='".$row['first_approver']."'");
                                        $cr=$this->rule_model->getCurrency("proposed_rnr_dtls.user_id in (".$data["rule_dtls"]['user_ids'].")");
//                                       echo '<pre />';
//                                       print_r($cr);
					$manager_budget = $award_val*$award_fr_val * count($managers_emp_arr);
					
					             
	              	$info[]=array(
                            'Manager_name'=>$row['manager_name'],
                            'Total_budget'=>$manager_budget,
                            'Total_Employee'=>count($managers_emp_arr)
                        );
	              	
                               
		}
                        }
                }
                }
                
		
		
               
            $data['report']=$info;
            $data['body']='report/bonus_review';
            $this->load->view('report/bonus_review',$data);
	}*/
	public function RnrSummery()
	{
        $rnrRules=$this->Report_model->rnrRules("id, budget_type, award_value, award_frequency, (select GROUP_CONCAT(DISTINCT rrud.user_id) from rnr_rule_users_dtls as rrud where rrud.rule_id = rnr_rules.id) as user_ids");
        foreach($rnrRules as $rnr)
        {
           	$rule_id= $rnr['id'];
           	$budget_type = $rnr['budget_type'];
           	$award_val =$rnr['award_value'];//award value
           	$award_fr_val = $rnr['award_frequency']; // award frequency
           	$totlaEmp=explode(',',$rnr['user_ids']);
           	if($rule_id)
			{
				$data["rule_dtls"] = $this->rnr_rule_model->get_rule_dtls_for_performance_cycles(array("rnr_rules.id"=>$rule_id));
				// $managers = $this->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);
				$managers = $this->rule_model->get_managers_for_manual_bdgt("rnr_rule_users_dtls",$rule_id);

				if($managers)
				{
					foreach ($managers as $row)
					{	
						$managers_emp_arr = $this->rule_model->get_managers_employees("login_user.id IN (SELECT user_id FROM rnr_rule_users_dtls WHERE rule_id = ".$rule_id.") AND login_user.".CV_BA_NAME_APPROVER_1."='".$row['first_approver']."'");
						
	                    // $cr=$this->rule_model->getCurrency("proposed_rnr_dtls.user_id in (".$data["rule_dtls"]['user_ids'].")");
						$manager_budget = $award_val*$award_fr_val * count($managers_emp_arr);
						    
		              	$info[]=array(
	                        'Manager_name'=>$row['manager_name'],
	                        'Total_budget'=>$manager_budget,
	                        'Total_Employee'=>count($managers_emp_arr)
	                    );        
					}
                }
            }
        }   
        $data['report']=$info;
        $data['body']='report/bonus_review';
        $this->load->view('report/bonus_review',$data);
	}
	
    public function pay_range()
	{            
		$data['title'] = "Pay Range Analysis Report";
		$data['body']='report/pay_range_analysis';
		$this->load->view('common/structure',$data);	
	}
	
	//Start :: Nibha's Work ******************
	function employee_cost_new()
	{
		$data['title'] = "Employee Cost Report";
		$data['body']='report/employee_cost_final';
		$this->load->view('common/structure',$data);	
	}

  	function profit_revenue_cost_FTE()
	{
		$data['title'] = "Revenue and Profit per FTE vs Avg FTE Cost";
		$data['body']='report/profit_revenue_cost_all_fte';
		$this->load->view('common/structure',$data);	
	}
  	function profit_revenue_cost_sales()
	{
		$data['title'] = "Revenue and Profit as Sales vs Avg Sales Cost Report";
		$data['body']='report/profit_revenue_cost_sales';
		$this->load->view('common/structure',$data);	
	}
	//End :: Nibha's Work ******************


	public function employee_historical_report($performance_cycle_id=9, $rule_id=4)
	{	$this->load->model('business_attribute_model');

		$data["msg"] = "";
		if(($this->session->userdata('role_ses')!=1))
		{
			$data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';
		}

		$master_fields=$this->business_attribute_model->get_business_attributes_master_tables_list("status=1");
		foreach ($master_fields as  $fld) {
			$fldName=$fld['ba_name'];
			$data["{$fldName}_list"] = $this->common_model->get_table($fld['table'],"id, name", "status = 1", "name asc");
				
		}

		$data['title'] = "Employee History Report";
		$data['body'] = "employee_historical_report";
		$this->employee_historical_search();
		$this->load->view('common/structure',$data);
	}

	function employee_historical_mark_difference($a)
	{
		foreach ($a as $key => $value) {
			$a[$key] = CV_CONCATENATE_SYNTAX . $value . CV_CONCATENATE_SYNTAX;
		}
		return $a;
	}

	public function employee_historical_search()
	{
		$data["msg"] = "";
		
		if(($this->session->userdata('role_ses')!=1))
		{
			echo 'Access Denied';
		}

		if($this->input->post())
		{
			if(!$this->input->post("hf_select_all_filters"))
			{

				$skip_fields=['web_token','createdby', 'updatedon','pk','upload_id','id','incorrect_attempts','company_Id','is_accept_term'];

/*
				$master_fields= [
					'country' => 'manage_country',
					'city' => 'manage_city',
					'business_level_1' =>'manage_business_level_1',
					'business_level_2' =>'manage_business_level_2',
					'business_level_3' => 'manage_business_level_3',
					'level' => 'manage_level',
					'education' => 'manage_education' ,
					'critical_talent' => 'manage_critical_talent',
					'critical_position' => 'manage_critical_position',
					'special_category' => 'manage_special_category',				
					'function' => 'manage_function',
					'sub_function' => 'manage_subfunction',
					'sub_subfunction' => 'manage_sub_subfunction',
					'designation' => 'manage_designation',
					'grade' => 'manage_grade' ,
					'currency'=>'manage_currency'
				];
			/*	//s($master_fields);
				$select_str="`updatedon`, login_user_history.`id`, login_user_history.`email`, login_user_history.`name`, login_user_history.`status`, `incorrect_attempts`, `role`, `company_Id`, 
				`company_name`,`first_name`, `employee_code`,`gender`";
				//$select_str=",`manage_country`.`name` as country, manage_city.`name` as city, `function`, `business_level_1`, `business_level_2`, `business_level_3`, `subfunction`, `sub_subfunction`, `designation`, `grade`, `education`, `critical_talent`, `critical_position`, `special_category`, `level`, `currency`";
				/* $select_str.=", `tenure_company`, `tenure_role`, `recently_promoted`, `token`, `hr_user_id`, `manage_hr_only`, `is_manager`, `points`, `pic_url`, `company_joining_date`, `increment_purpose_joining_date`, `start_date_for_role`, `end_date_for_role`, `bonus_incentive_applicable`, `rating_for_last_year`, `rating_for_2nd_last_year`, `rating_for_3rd_last_year`, `rating_for_4th_last_year`, `rating_for_5th_last_year`, `rating_for_current_year`, `salary_after_last_increase`, `effective_date_of_last_salary_increase`, `salary_after_2nd_last_increase`, `effective_date_of_2nd_last_salary_increase`, `salary_after_3rd_last_increase`, `effective_date_of_3rd_last_salary_increase`, `salary_after_4th_last_increase`, `effective_date_of_4th_last_salary_increase`, `salary_after_5th_last_increase`, `effective_date_of_5th_last_salary_increase`, `total_salary_after_last_increase`, `total_salary_after_2nd_last_increase`, `total_salary_after_3rd_last_increase`, `total_salary_after_4th_last_increase`, `total_salary_after_5th_last_increase`, `target_salary_after_last_increase`, `target_salary_after_2nd_last_increase`, `target_salary_after_3rd_last_increase`, `target_salary_after_4th_last_increase`, `target_salary_after_5th_last_increase`, `current_base_salary`, `current_target_bonus`,
				`allowance_1`, `allowance_2`, `allowance_3`, `allowance_4`, `allowance_5`, `allowance_6`, `allowance_7`, `allowance_8`, `allowance_9`, `allowance_10`, 
				`total_compensation`, `increment_applied_on`, `job_code`, `job_name`, `job_level`, 
				`market_target_salary_level_min`, `market_total_salary_level_min`, `market_base_salary_level_min`, `market_target_salary_level_1`, `market_total_salary_level_1`, `market_base_salary_level_1`, `market_target_salary_level_2`, `market_total_salary_level_2`, `market_base_salary_level_2`, `market_target_salary_level_3`, `market_total_salary_level_3`, 
				`approver_1`, `approver_2`, `approver_3`, `approver_4`, `manager_name`, `authorised_signatory_for_letter`, `authorised_signatorys_title_for_letter`, `hr_authorised_signatory_for_letter`, `hr_authorised_signatorys_title_for_letter`,
				`market_base_salary_level_3`, `company_1_base_salary_min`, `company_1_base_salary_max`, `company_1_base_salary_average`, `company_2_base_salary_min`, `company_2_base_salary_max`, `company_2_base_salary_average`, `company_3_base_salary_min`, `company_3_base_salary_max`, `company_3_base_salary_average`, `average_base_salary_min`, `average_base_salary_max`, `average_base_salary_average`, `company_1_target_salary_min`, `company_1_target_salary_max`, `company_1_target_salary_average`, `company_2_target_salary_min`, `company_2_target_salary_max`, `company_2_target_salary_average`, `company_3_target_salary_min`, `company_3_target_salary_max`, `company_3_target_salary_average`, `average_target_salary_min`, `average_target_salary_max`, `average_target_salary_average`, `company_1_total_salary_min`, `company_1_total_salary_max`, `company_1_total_salary_average`, `company_2_total_salary_min`, `company_2_sotal_salary_max`, `company_2_total_salary_average`, `company_3_total_salary_min`, `company_3_total_salary_max`, `company_3_total_salary_average`, `average_total_salary_min`, `average_total_salary_max`, `average_total_salary_average`, 
				`market_target_salary_level_4`, `market_total_salary_level_4`, `market_base_salary_level_4`, `market_target_salary_level_5`, `market_total_salary_level_5`, `market_base_salary_level_5`, `market_target_salary_level_6`, `market_total_salary_level_6`, `market_base_salary_level_6`, `market_target_salary_level_7`, `market_total_salary_level_7`, `market_base_salary_level_7`, `market_target_salary_level_8`, `market_total_salary_level_8`, `market_base_salary_level_8`, `market_target_salary_level_9`, `market_total_salary_level_9`, `market_base_salary_level_9`, `market_target_salary_sevel_max`, `market_total_salary_level_max`, `market_base_salary_level_max`, 
				`performance_achievement`, 
				`allowance_11`, `allowance_12`, `allowance_13`, `allowance_14`, `allowance_15`, `allowance_16`, `allowance_17`, `allowance_18`, `allowance_19`, `allowance_20`, `allowance_21`, `allowance_22`, `allowance_23`, `allowance_24`, `allowance_25`, `allowance_26`, `allowance_27`, `allowance_28`, `allowance_29`, `allowance_30`, `allowance_31`, `allowance_32`, `allowance_33`, `allowance_34`, `allowance_35`, `allowance_36`, `allowance_37`, `allowance_38`, `allowance_39`, `allowance_40`, 
				`teeth_tail_ratio`, `previous_talent_rating`, `promoted_in_2_yrs`, `engagement_level`, `successor_identified`, `readyness_level`, `urban_rural_classification`, `employee_movement_into_bonus_plan`, 
				`other_data_9`, `other_data_10`, `other_data_11`, `other_data_12`, `other_data_13`, `other_data_14`, `other_data_15`, `other_data_16`, `Other_data_17`, `other_data_18`, `other_data_19`, `other_data_20`, 
				`notice_period`, `is_accept_term`, `web_token`";*/
/*
				$select_array=['updatedon', 'login_user_history.id', login_user_history.'email', login_user_history.'name', login_user_history.'status', 'incorrect_attempts', 'role', 'company_Id', 
				'company_name','first_name', 'employee_code','gender'];
				//$select_str=",'manage_country'.'name' as country, manage_city.'name' as city, 'function', 'business_level_1', 'business_level_2', 'business_level_3', 'subfunction', 'sub_subfunction', 'designation', 'grade', 'education', 'critical_talent', 'critical_position', 'special_category', 'level', 'currency'";
				 $select_str.=", 'tenure_company', 'tenure_role', 'recently_promoted', 'token', 'hr_user_id', 'manage_hr_only', 'is_manager', 'points', 'pic_url', 'company_joining_date', 'increment_purpose_joining_date', 'start_date_for_role', 'end_date_for_role', 'bonus_incentive_applicable', 'rating_for_last_year', 'rating_for_2nd_last_year', 'rating_for_3rd_last_year', 'rating_for_4th_last_year', 'rating_for_5th_last_year', 'rating_for_current_year', 'salary_after_last_increase', 'effective_date_of_last_salary_increase', 'salary_after_2nd_last_increase', 'effective_date_of_2nd_last_salary_increase', 'salary_after_3rd_last_increase', 'effective_date_of_3rd_last_salary_increase', 'salary_after_4th_last_increase', 'effective_date_of_4th_last_salary_increase', 'salary_after_5th_last_increase', 'effective_date_of_5th_last_salary_increase', 'total_salary_after_last_increase', 'total_salary_after_2nd_last_increase', 'total_salary_after_3rd_last_increase', 'total_salary_after_4th_last_increase', 'total_salary_after_5th_last_increase', 'target_salary_after_last_increase', 'target_salary_after_2nd_last_increase', 'target_salary_after_3rd_last_increase', 'target_salary_after_4th_last_increase', 'target_salary_after_5th_last_increase', 'current_base_salary', 'current_target_bonus',
				'allowance_1', 'allowance_2', 'allowance_3', 'allowance_4', 'allowance_5', 'allowance_6', 'allowance_7', 'allowance_8', 'allowance_9', 'allowance_10', 
				'total_compensation', 'increment_applied_on', 'job_code', 'job_name', 'job_level', 
				'market_target_salary_level_min', 'market_total_salary_level_min', 'market_base_salary_level_min', 'market_target_salary_level_1', 'market_total_salary_level_1', 'market_base_salary_level_1', 'market_target_salary_level_2', 'market_total_salary_level_2', 'market_base_salary_level_2', 'market_target_salary_level_3', 'market_total_salary_level_3', 
				'approver_1', 'approver_2', 'approver_3', 'approver_4', 'manager_name', 'authorised_signatory_for_letter', 'authorised_signatorys_title_for_letter', 'hr_authorised_signatory_for_letter', 'hr_authorised_signatorys_title_for_letter',
				'market_base_salary_level_3', 'company_1_base_salary_min', 'company_1_base_salary_max', 'company_1_base_salary_average', 'company_2_base_salary_min', 'company_2_base_salary_max', 'company_2_base_salary_average', 'company_3_base_salary_min', 'company_3_base_salary_max', 'company_3_base_salary_average', 'average_base_salary_min', 'average_base_salary_max', 'average_base_salary_average', 'company_1_target_salary_min', 'company_1_target_salary_max', 'company_1_target_salary_average', 'company_2_target_salary_min', 'company_2_target_salary_max', 'company_2_target_salary_average', 'company_3_target_salary_min', 'company_3_target_salary_max', 'company_3_target_salary_average', 'average_target_salary_min', 'average_target_salary_max', 'average_target_salary_average', 'company_1_total_salary_min', 'company_1_total_salary_max', 'company_1_total_salary_average', 'company_2_total_salary_min', 'company_2_sotal_salary_max', 'company_2_total_salary_average', 'company_3_total_salary_min', 'company_3_total_salary_max', 'company_3_total_salary_average', 'average_total_salary_min', 'average_total_salary_max', 'average_total_salary_average', 
				'market_target_salary_level_4', 'market_total_salary_level_4', 'market_base_salary_level_4', 'market_target_salary_level_5', 'market_total_salary_level_5', 'market_base_salary_level_5', 'market_target_salary_level_6', 'market_total_salary_level_6', 'market_base_salary_level_6', 'market_target_salary_level_7', 'market_total_salary_level_7', 'market_base_salary_level_7', 'market_target_salary_level_8', 'market_total_salary_level_8', 'market_base_salary_level_8', 'market_target_salary_level_9', 'market_total_salary_level_9', 'market_base_salary_level_9', 'market_target_salary_sevel_max', 'market_total_salary_level_max', 'market_base_salary_level_max', 
				'performance_achievement', 
				'allowance_11', 'allowance_12', 'allowance_13', 'allowance_14', 'allowance_15', 'allowance_16', 'allowance_17', 'allowance_18', 'allowance_19', 'allowance_20', 'allowance_21', 'allowance_22', 'allowance_23', 'allowance_24', 'allowance_25', 'allowance_26', 'allowance_27', 'allowance_28', 'allowance_29', 'allowance_30', 'allowance_31', 'allowance_32', 'allowance_33', 'allowance_34', 'allowance_35', 'allowance_36', 'allowance_37', 'allowance_38', 'allowance_39', 'allowance_40', 
				'teeth_tail_ratio', 'previous_talent_rating', 'promoted_in_2_yrs', 'engagement_level', 'successor_identified', 'readyness_level', 'urban_rural_classification', 'employee_movement_into_bonus_plan', 
				'other_data_9', 'other_data_10', 'other_data_11', 'other_data_12', 'other_data_13', 'other_data_14', 'other_data_15', 'other_data_16', 'Other_data_17', 'other_data_18', 'other_data_19', 'other_data_20', 
				'notice_period', 'is_accept_term', 'web_token'";*/

				$this->load->model('business_attribute_model');
				$master_fields=$this->business_attribute_model->get_business_attributes_master_tables_list("status=1");
				$ba_result=$this->business_attribute_model->get_business_attributes_custom("ba_name as ba_name,display_name as display_name","status=1");
				$header=$balist=[];
				$balist=['updatedon'=>"Updated On",'createdon'=> 'Created On','id'=>"UID",'status'=>"Status"];

				foreach ($ba_result as $key => $value) {
					$balist[$value['ba_name']]=$value['display_name'];
				}

				$otherFlds=['upload_id'=>'UploadId', 'updatedby'=>'UpdatedBy', 'createdby'=>'CreatedBy',  'createdby_proxy'=>'CreatedBy_proxy', 'updatedby_proxy'=>'UpdatedBy_Proxy'];

				$balist=array_merge($balist,$otherFlds);

				foreach ($balist as  $fldname => $display_name) {
					$header[$fldname] = $display_name;
					if (isset($master_fields[$fldname])) {
						//$fields[]="`{$master_fields[$fldname]}`.name as {$fldname}";		
						$fields[] = "`{$master_fields[$fldname]['table']}`.name as {$fldname}";
					} else {
						$fields[] = "`login_user_history`.{$fldname} as {$fldname}";
					}
				}

				$select_str=implode(",",$fields);
				//$select_str=$fldlist;//.",`upload_id`, `updatedby`, `createdby`, `createdon`, `createdby_proxy`, `updatedby_proxy`, `pk`";
				$select_str.=",concat(`login_user_history`.updatedon,`login_user_history`.id,`login_user_history`.upload_id) as pk ";
				$txt_start_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",$this->input->post("txt_start_date"))));	
				if($this->input->post("txt_end_date"))
				{
					$txt_end_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",$this->input->post("txt_end_date"). ' 23:59:59')));		
				}
				else
				{
					$txt_end_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",$this->input->post("txt_start_date"). ' 23:59:59')));	
				}
				$where =" login_user_history.updatedon >= '{$txt_start_date}' AND  login_user_history.updatedon <= '{$txt_end_date}' ";
				
				
				$filters = [
					'country' => CV_BA_NAME_COUNTRY,
					'city' => CV_BA_NAME_CITY,
					'business_level_1' => CV_BA_NAME_BUSINESS_LEVEL_1,
					'business_level_2' => CV_BA_NAME_BUSINESS_LEVEL_2,
					'business_level_3' => CV_BA_NAME_BUSINESS_LEVEL_3,
					'level' => CV_BA_NAME_LEVEL,
					'education' => CV_BA_NAME_EDUCATION,
					'critical_talent' => CV_BA_NAME_CRITICAL_TALENT,
					'critical_position' => CV_BA_NAME_CRITICAL_POSITION,
					'special_category' => CV_BA_NAME_SPECIAL_CATEGORY,				
					'function' => CV_BA_NAME_FUNCTION,
					'sub_function' => CV_BA_NAME_SUBFUNCTION,
					'sub_subfunction' => CV_BA_NAME_SUB_SUBFUNCTION,
					'designation' => CV_BA_NAME_DESIGNATION,
					'grade' => CV_BA_NAME_GRADE
				];				
				
				foreach ($filters as $key => $fldname) {
					$filter=$this->input->post($key);					
					if(!empty($filter)){
					unset($filter['all']);
					$in=implode(",",$filter);
					if($in && !empty($in)) 		$where .= " AND login_user_history.`{$fldname}` IN (".$in.") ";
					}
				}

				$filters_like = [		
					'email' => CV_BA_NAME_EMP_EMAIL,
					'name' => CV_BA_NAME_EMP_FULL_NAME,
					'employee_code' => CV_BA_NAME_EMP_CODE
				];	

				foreach ($filters_like as $key => $fldname) {
					if(!empty($this->input->post($key))){
						$filter=$this->input->post($key);
						$where .= " AND login_user_history.`{$fldname}` like '%{$filter}%' ";						
				   }
				}				
				$results=$this->Report_model->get_employee_historical_report($select_str,$where);
				//s($results,$select_str,$where);
				$old=[];
				foreach ($results as $key => $record) {
				 if(isset($old[$record['id']])){
					$diff=array_diff_assoc($record,$old[$record['id']]);
					$old[$record['id']]= array_merge($old[$record['id']],$diff);  //upd old with recent changes
					
					$diff=$this->employee_historical_mark_difference($diff);
					//$csv[$record['id']][$record['pk']]=$this->employee_historical_mark_difference($diff);
					$csv[$record['id']][$record['pk']]=array_merge($record,$diff);
				 }
				 else
				 {	$csv[$record['id']][$record['pk']]=$record;
					$old[$record['id']]= $record;
				 }	
				}
				$records=[];
				foreach (	$csv as  $pk) {
					foreach ($pk as  $record) {
						$records[]= $record;
					}
				}
				/*
				foreach ($records[0] as $k => $row)
				{
					$header[]=$k;
				}*/
			//	$fileName="hist_rpt_".$this->input->post("reportid").".csv";
			//	$sucess=$this->generateCSV($records,$header,$fileName,true);
				$fileName="hist_rpt_".date('dmYHis').".xlsx";
				$sucess=$this->generateXls($records,$header,$fileName,true);
				if($sucess)	echo '<div>Processing of record finished. Download file.<a style="margin-top:-5px;" class="btn btn-primary pull-right" href="'.base_url('uploads/'. $fileName).'">Download</a></div>';
				else "No Record Found!";
			}
		}
	}

	public function generateCSV($records, $header = [], $fileName = 'download.csv', $savefile = false)
	{

		if ($savefile) {
			$filePath = dirname(APPPATH) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName;
			//s(	$filename);
			$file = fopen($filePath, 'wb');
			// output each row of the data
			if ($header) fputcsv($file, $header);
			// output each row of the data
			foreach ($records as $row) {
				fputcsv($file, $row);
			}
			fclose($file);

			if (file_exists($filePath)) {
				return true;
			} else {
				return false;
			}
		} else {
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$fileName");
			header("Content-Type: application/csv;");

			// file creation 
			$file = fopen('php://output', 'w');
			if ($header) fputcsv($file, $header);
			foreach ($records as $key => $value) {
				fputcsv($file, $value);
			}
			fclose($file);
			exit;
		}
	}


	public function generateXls($records, $header=[], $fileName = 'download.xlsx',$savefile=false)
	{
		// load excel library
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header    
		$colNum = 0;

		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->SetCellValue(HLP_getCellFromColnum($colNum) . '1', $v);
			$colNum++;
		}
		// set Row
		$rowCount = count($header)? 2:1;
		foreach ($records as $row) {
			$colNum = 0;
			foreach ($row as $k => $v) {
				$str = str_replace(CV_CONCATENATE_SYNTAX, '', $v);
				$cell = HLP_getCellFromColnum($colNum) . $rowCount;
				$objPHPExcel->getActiveSheet()->SetCellValue($cell, $str);
				if ($v != $str) {
					$objPHPExcel->getActiveSheet()
						->getStyle($cell)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setRGB('FFFF00');
				}
				/*
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true)
			->setName('Verdana')
			->setSize(10)
			->getColor()->setRGB('6F6F6F');
			*/
				$colNum++;
			}
			$rowCount++;
		}
		if($savefile)
		{   $filePath=dirname(APPPATH).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$fileName;
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($filePath);
			if(file_exists($filePath))
			{return true;}
			else
			{return false;}
		}
		else
		{
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $fileName . '"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

		}
	
	}

	/*
	* Get Cost Summary grade wise in csv
	*/
	public function get_cost_summary_by_grade($rule_id) {

		$rule_id = (int)$rule_id;
		$emps_data_arr 		= array();
		$has_emp_data_cond 	= true;//false for admin
		$function_arr		= array();//filter for functions

		if(empty($rule_id)) {
			return;
		}

		//check function filter condition
		if(!empty($this->input->post("functions_name_grade"))) {

			$function_arr = $this->input->post("functions_name_grade");

		}

		/* Check user condition */
		if($this->session->userdata('role_ses') == 1) {//for hr admin

			$has_emp_data_cond = false;
			//no need for emps_data_arr

		} else if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users

			$emps_data 	= $this->session->userdata('hr_usr_ids_ses');

			if(!empty($emps_data)) {

				$emps_data_arr = explode(',', $this->session->userdata('hr_usr_ids_ses'));
			}

		} elseif($this->session->userdata('role_ses') == 10) {//Manager Type of Users

			$emps_data 	= HLP_get_manager_emps_arr($this->session->userdata('email_ses'));

			if(!empty($emps_data)) {

				foreach($emps_data as $e_key => $emp_det) {

					$emps_data_arr[$e_key] = $emp_det['id'];

				}
			}
		}

		/* End to check user condition */

		$rslt = $this->Report_model->cost_summary_by_grade($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);

		$this->export_summary_data_by_grade($rslt,'cost_summary_by_grade.csv');

		exit;
	}

	/*
	* Get Cost Summary performance rating wise in csv
	*/
	public function get_cost_summary_by_performance_rating($rule_id) {

		$rule_id = (int)$rule_id;
		$emps_data_arr 		= array();
		$has_emp_data_cond 	= true;//false for admin
		$function_arr		= array();//filter for functions

		if(empty($rule_id)) {
			return;
		}

		//check function filter condition
		if(!empty($this->input->post("functions_name_per"))) {

			$function_arr = $this->input->post("functions_name_per");

		}

		/* Check user condition */
		if($this->session->userdata('role_ses') == 1) {//for hr admin

			$has_emp_data_cond = false;
			//no need for emps_data_arr

		} else if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users

			$emps_data 	= $this->session->userdata('hr_usr_ids_ses');

			if(!empty($emps_data)) {

				$emps_data_arr = explode(',', $this->session->userdata('hr_usr_ids_ses'));
			}

		} elseif($this->session->userdata('role_ses') == 10) {//Manager Type of Users

			$emps_data 	= HLP_get_manager_emps_arr($this->session->userdata('email_ses'));

			if(!empty($emps_data)) {

				foreach($emps_data as $e_key => $emp_det) {

					$emps_data_arr[$e_key] = $emp_det['id'];

				}
			}
		}

		/* End to check user condition */
	
		$rslt = $this->Report_model->cost_summary_by_performance_rating($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);

		$this->export_summary_data_by_performance_rating($rslt,'cost_summary_by_performance_summary.csv');

		exit;
	}


	public function export_summary_data_by_grade($rslt, $fileName = 'cost_summary_by_grade.csv') {

		$data_array 	= array();
		$header_array 	= array();
		$last_array 	= array();

		if(!empty($rslt)) {

			$header_array[] = 'Band';
			$header_array[] = 'Role';
			$header_array[] = 'Head Count';
			$header_array[] = 'Current CTC';
			$header_array[] = 'Proposed CTC';
			$header_array[] = 'Increment';
			$header_array[] = 'Cost Impact Percentage';
			$header_array[] = 'Merit Cost Impact Amount';
			$header_array[] = 'Merit Cost Impact Percentage';
			$header_array[] = 'Promotion Cost Impact Amount';
			$header_array[] = 'Promotion Cost Impact Percentage';
			$header_array[] = 'Market Adjustment Cost Impact Amount';
			$header_array[] = 'Market Adjustment Cost Impact Percentage';

			$last_array['band'] 										= '';
			$last_array['role'] 										= 'Total';
			$last_array['headcount'] 									= 0;
			$last_array['current_ctc'] 									= 0;
			$last_array['proposed_ctc'] 								= 0;
			$last_array['increment'] 									= 0;
			$last_array['cost_impact'] 									= 0;
			$last_array['cost_impact_count'] 							= 0;
			$last_array['merit_cost_impact_amount'] 					= 0;
			$last_array['merit_cost_impact_percentage'] 				= 0;
			$last_array['merit_cost_impact_percentage_count'] 			= 0;
			$last_array['promotion_cost_impact_amount'] 				= 0;
			$last_array['promotion_cost_impact_percentage'] 			= 0;
			$last_array['promotion_cost_impact_percentage_count'] 		= 0;
			$last_array['market_adjustment_cost_impact_amount'] 		= 0;
			$last_array['market_adjustment_cost_percentage'] 			= 0;
			$last_array['market_adjustment_cost_percentage_count'] 		= 0;

			foreach($rslt as $key => $val) {

				$data_array[$key]['band'] 				= trim($val['band']) ?? '';
				$data_array[$key]['role'] 				= trim($val['role']) ?? '';
				$data_array[$key]['headcount'] 			= trim($val['headcount']) ?? 0;
				$data_array[$key]['current_ctc'] 		= trim($val['current_ctc']) ?? 0;
				$data_array[$key]['proposed_ctc'] 		= trim($val['proposed_ctc']) ?? 0;
				$data_array[$key]['increment'] 			= trim($val['increment']) ?? 0;

				$last_array['headcount'] 				+= $data_array[$key]['headcount'];
				$last_array['current_ctc'] 				+= $data_array[$key]['current_ctc'];
				$last_array['proposed_ctc'] 			+= $data_array[$key]['proposed_ctc'];
				$last_array['increment'] 				+= $data_array[$key]['increment'];

				$data_array[$key]['cost_impact'] 		= trim($val['cost_impact']) ? trim($val['cost_impact']). '%' : 0;

				$last_array['cost_impact'] 				= $last_array['cost_impact'] + $data_array[$key]['cost_impact'];
				$last_array['cost_impact_count'] 		= $last_array['cost_impact_count']	+	1;

				//cost impact
				$data_array[$key]['merit_cost_impact_amount'] 	= '-';
				$merit_cost_impact_amount 					= trim((float)$val['merit_amt']) ?? 0;

				if(!empty($merit_cost_impact_amount)) {

					$last_array['merit_cost_impact_amount'] 			+= $merit_cost_impact_amount;
					$data_array[$key]['merit_cost_impact_amount'] 		= round($merit_cost_impact_amount , 2);

				}

				$data_array[$key]['merit_cost_impact_percentage'] 	= '-';
				$merit_cost_impact_percentage 					= trim((float)$val['merit_per']) ?? 0;

				if(!empty($merit_cost_impact_percentage)) {

					$last_array['merit_cost_impact_percentage'] 		+= $merit_cost_impact_percentage;
					$last_array['merit_cost_impact_percentage_count'] 	= $last_array['merit_cost_impact_percentage_count'] + 1;
					$data_array[$key]['merit_cost_impact_percentage'] 	= round($merit_cost_impact_percentage , 2). '%';
				}
				
				//promotion_percentage
				$data_array[$key]['promotion_cost_impact_amount'] 	= '-';
				$promotion_cost_impact_amount 	= trim((float)$val['promotion_amt']) ?? 0;

				if(!empty($promotion_cost_impact_amount)) {

					$last_array['promotion_cost_impact_amount'] 			+= $promotion_cost_impact_amount;
					$data_array[$key]['promotion_cost_impact_amount'] 		= round($promotion_cost_impact_amount , 2);

				}

				$data_array[$key]['promotion_cost_impact_percentage'] 	= '-';
				$promotion_cost_impact_percentage 					= trim((float)$val['promotion_per']) ?? 0;

				if(!empty($promotion_cost_impact_percentage)) {

					$last_array['promotion_cost_impact_percentage'] 		+= $promotion_cost_impact_percentage;
					$last_array['promotion_cost_impact_percentage_count'] 	= $last_array['promotion_cost_impact_percentage_count'] + 1;
					$data_array[$key]['promotion_cost_impact_percentage'] 	= round($promotion_cost_impact_percentage , 2). '%';
				}

				//market_adjustment_cost_impact
				$data_array[$key]['market_adjustment_cost_impact_amount'] 	= '-';
				$market_adjustment_cost_impact_amount 					= trim((float)$val['market_adjustment_amt']) ?? 0;

				if(!empty($market_adjustment_cost_impact_amount)) {

					$last_array['market_adjustment_cost_impact_amount'] 			+= $market_adjustment_cost_impact_amount;
					$data_array[$key]['market_adjustment_cost_impact_amount'] 		= round($market_adjustment_cost_impact_amount , 2);

				}

				$data_array[$key]['market_adjustment_cost_percentage'] 	= '-';
				$market_adjustment_percentage 					= trim((float)$val['market_adjustment_per']) ?? 0;

				if(!empty($market_adjustment_percentage)) {

					$last_array['market_adjustment_cost_percentage'] 		+= $market_adjustment_percentage;
					$last_array['market_adjustment_cost_percentage_count'] 	= $last_array['market_adjustment_cost_percentage_count'] + 1;
					$data_array[$key]['market_adjustment_cost_percentage'] 	= round($market_adjustment_percentage , 2). '%';
				}

			}

		} else {

			$data_array[0]['band'] 										= 'NO DATA FOUND';
			$data_array[0]['role'] 										= '';
			$data_array[0]['headcount'] 								= '';
			$data_array[0]['current_ctc'] 								= '';
			$data_array[0]['proposed_ctc'] 								= '';
			$data_array[0]['increment'] 								= '';
			$data_array[0]['cost_impact'] 								= '';
			$data_array[0]['merit_cost_impact_amount'] 					= '';
			$data_array[0]['merit_cost_impact_percentage'] 				= '';
			$data_array[0]['promotion_cost_impact_amount'] 				= '';
			$data_array[0]['promotion_cost_impact_percentage'] 			= '';
			$data_array[0]['market_adjustment_cost_impact_amount'] 		= '';
			$data_array[0]['market_adjustment_cost_percentage'] 		= '';
			//"no data found";
		}

		if(!empty($last_array)) {

			//cost_impact
			if(!empty($last_array['cost_impact']) &&  !empty($last_array['cost_impact_count'])) {

				$last_array['cost_impact'] = round(($last_array['cost_impact'] / $last_array['cost_impact_count'] ), 2). '%';
			}

			unset($last_array['cost_impact_count']);

			//merit_cost_impact_percentage
			if(!empty($last_array['merit_cost_impact_amount'])) {

				$last_array['merit_cost_impact_amount'] = round(($last_array['merit_cost_impact_amount']), 2);
			}

			if(!empty($last_array['merit_cost_impact_percentage']) &&  !empty($last_array['merit_cost_impact_percentage_count'])) {

				$last_array['merit_cost_impact_percentage'] = round(($last_array['merit_cost_impact_percentage'] / $last_array['merit_cost_impact_percentage_count'] ), 2) . '%';
			}

			unset($last_array['merit_cost_impact_percentage_count']);

			//promotion_cost_impact_percentage
			if(!empty($last_array['promotion_cost_impact_amount'])) {

				$last_array['promotion_cost_impact_amount'] = round(($last_array['promotion_cost_impact_amount']), 2);
			}

			if(!empty($last_array['promotion_cost_impact_percentage']) &&  !empty($last_array['promotion_cost_impact_percentage_count'])) {

				$last_array['promotion_cost_impact_percentage'] = round(($last_array['promotion_cost_impact_percentage'] / $last_array['promotion_cost_impact_percentage_count'] ), 2) . '%';
			}

			unset($last_array['promotion_cost_impact_percentage_count']);

			//market_adjustment_cost_percentage
			if(!empty($last_array['market_adjustment_cost_impact_amount'])) {

				$last_array['market_adjustment_cost_impact_amount'] = round(($last_array['market_adjustment_cost_impact_amount']), 2);
			}

			if(!empty($last_array['market_adjustment_cost_percentage']) &&  !empty($last_array['market_adjustment_cost_percentage_count'])) {

				$last_array['market_adjustment_cost_percentage'] = round(($last_array['market_adjustment_cost_percentage'] / $last_array['market_adjustment_cost_percentage_count'] ), 2) . '%';
			}

			unset($last_array['market_adjustment_cost_percentage_count']);

			array_push($data_array,$last_array);

		}

		$this->generateCSV($data_array, $header_array, $fileName);

		return;

	}


	public function export_summary_data_by_performance_rating($rslt, $fileName = 'cost_summary_by_performance_summary.csv') {

		$data_array 	= array();
		$header_array 	= array();
		$last_array 	= array();

		if(!empty($rslt)) {

			$header_array[] = 'Band';
			$header_array[] = 'Head Count';
			$header_array[] = 'Current CTC';
			$header_array[] = 'Proposed CTC';
			$header_array[] = 'Increment';
			$header_array[] = 'Cost Impact Percentage';
			$header_array[] = 'Merit Cost Impact Amount';
			$header_array[] = 'Merit Cost Impact Percentage';
			$header_array[] = 'Promotion Cost Impact Amount';
			$header_array[] = 'Promotion Cost Impact Percentage';
			$header_array[] = 'Market Adjustment Cost Impact Amount';
			$header_array[] = 'Market Adjustment Cost Impact Percentage';

			$last_array['band'] 										= 'Total';
			$last_array['headcount'] 									= 0;
			$last_array['current_ctc'] 									= 0;
			$last_array['proposed_ctc'] 								= 0;
			$last_array['increment'] 									= 0;
			$last_array['cost_impact'] 									= 0;
			$last_array['cost_impact_count'] 							= 0;
			$last_array['merit_cost_impact_amount'] 					= 0;
			$last_array['merit_cost_impact_percentage'] 				= 0;
			$last_array['merit_cost_impact_percentage_count'] 			= 0;
			$last_array['promotion_cost_impact_amount'] 				= 0;
			$last_array['promotion_cost_impact_percentage'] 			= 0;
			$last_array['promotion_cost_impact_percentage_count'] 		= 0;
			$last_array['market_adjustment_cost_impact_amount'] 		= 0;
			$last_array['market_adjustment_cost_percentage'] 			= 0;
			$last_array['market_adjustment_cost_percentage_count'] 		= 0;

			foreach($rslt as $key => $val) {

				$data_array[$key]['band'] 				= trim($val['band']) ?? '';
				$data_array[$key]['headcount'] 			= trim($val['headcount']) ?? 0;
				$data_array[$key]['current_ctc'] 		= trim($val['current_ctc']) ?? 0;
				$data_array[$key]['proposed_ctc'] 		= trim($val['proposed_ctc']) ?? 0;
				$data_array[$key]['increment'] 			= trim($val['increment']) ?? 0;

				$last_array['headcount'] 				+= $data_array[$key]['headcount'];
				$last_array['current_ctc'] 				+= $data_array[$key]['current_ctc'];
				$last_array['proposed_ctc'] 			+= $data_array[$key]['proposed_ctc'];
				$last_array['increment'] 				+= $data_array[$key]['increment'];

				$data_array[$key]['cost_impact'] 		= trim($val['cost_impact']) ? trim($val['cost_impact']). '%' : 0;

				$last_array['cost_impact'] 				= $last_array['cost_impact'] + $data_array[$key]['cost_impact'];
				$last_array['cost_impact_count'] 		= $last_array['cost_impact_count']	+	1;

				//cost impact
				$data_array[$key]['merit_cost_impact_amount'] 	= '-';
				$merit_cost_impact_amount 					= trim((float)$val['merit_amt']) ?? 0;

				if(!empty($merit_cost_impact_amount)) {

					$last_array['merit_cost_impact_amount'] 			+= $merit_cost_impact_amount;
					$data_array[$key]['merit_cost_impact_amount'] 		= round($merit_cost_impact_amount , 2);

				}

				$data_array[$key]['merit_cost_impact_percentage'] 	= '-';
				$merit_cost_impact_percentage 					= trim((float)$val['merit_per']) ?? 0;

				if(!empty($merit_cost_impact_percentage)) {

					$last_array['merit_cost_impact_percentage'] 		+= $merit_cost_impact_percentage;
					$last_array['merit_cost_impact_percentage_count'] 	= $last_array['merit_cost_impact_percentage_count'] + 1;
					$data_array[$key]['merit_cost_impact_percentage'] 	= round($merit_cost_impact_percentage , 2). '%';
				}

				//promotion_percentage
				$data_array[$key]['promotion_cost_impact_amount'] 	= '-';
				$promotion_cost_impact_amount 	= trim((float)$val['promotion_amt']) ?? 0;

				if(!empty($promotion_cost_impact_amount)) {

					$last_array['promotion_cost_impact_amount'] 			+= $promotion_cost_impact_amount;
					$data_array[$key]['promotion_cost_impact_amount'] 		= round($promotion_cost_impact_amount , 2);

				}

				$data_array[$key]['promotion_cost_impact_percentage'] 	= '-';
				$promotion_cost_impact_percentage 					= trim((float)$val['promotion_per']) ?? 0;

				if(!empty($promotion_cost_impact_percentage)) {

					$last_array['promotion_cost_impact_percentage'] 		+= $promotion_cost_impact_percentage;
					$last_array['promotion_cost_impact_percentage_count'] 	= $last_array['promotion_cost_impact_percentage_count'] + 1;
					$data_array[$key]['promotion_cost_impact_percentage'] 	= round($promotion_cost_impact_percentage , 2). '%';
				}

				//market_adjustment_cost_impact
				$data_array[$key]['market_adjustment_cost_impact_amount'] 	= '-';
				$market_adjustment_cost_impact_amount 					= trim((float)$val['market_adjustment_amt']) ?? 0;

				if(!empty($market_adjustment_cost_impact_amount)) {

					$last_array['market_adjustment_cost_impact_amount'] 			+= $market_adjustment_cost_impact_amount;
					$data_array[$key]['market_adjustment_cost_impact_amount'] 		= round($market_adjustment_cost_impact_amount , 2);

				}

				$data_array[$key]['market_adjustment_cost_percentage'] 	= '-';
				$market_adjustment_percentage 					= trim((float)$val['market_adjustment_per']) ?? 0;

				if(!empty($market_adjustment_percentage)) {

					$last_array['market_adjustment_cost_percentage'] 		+= $market_adjustment_percentage;
					$last_array['market_adjustment_cost_percentage_count'] 	= $last_array['market_adjustment_cost_percentage_count'] + 1;
					$data_array[$key]['market_adjustment_cost_percentage'] 	= round($market_adjustment_percentage , 2). '%';
				}

			}

		} else {

			$data_array[0]['band'] 										= 'NO DATA FOUND';
			$data_array[0]['headcount'] 								= '';
			$data_array[0]['current_ctc'] 								= '';
			$data_array[0]['proposed_ctc'] 								= '';
			$data_array[0]['increment'] 								= '';
			$data_array[0]['cost_impact'] 								= '';
			$data_array[0]['merit_cost_impact_amount'] 					= '';
			$data_array[0]['merit_cost_impact_percentage'] 				= '';
			$data_array[0]['promotion_cost_impact_amount'] 				= '';
			$data_array[0]['promotion_cost_impact_percentage'] 			= '';
			$data_array[0]['market_adjustment_cost_impact_amount'] 		= '';
			$data_array[0]['market_adjustment_cost_percentage'] 		= '';
			//"no data found";
		}

		if(!empty($last_array)) {

			//cost_impact
			if(!empty($last_array['cost_impact']) &&  !empty($last_array['cost_impact_count'])) {

				$last_array['cost_impact'] = round(($last_array['cost_impact'] / $last_array['cost_impact_count'] ), 2). '%';
			}

			unset($last_array['cost_impact_count']);

			//merit_cost_impact_percentage
			if(!empty($last_array['merit_cost_impact_amount'])) {

				$last_array['merit_cost_impact_amount'] = round(($last_array['merit_cost_impact_amount']), 2);
			}

			if(!empty($last_array['merit_cost_impact_percentage']) &&  !empty($last_array['merit_cost_impact_percentage_count'])) {

				$last_array['merit_cost_impact_percentage'] = round(($last_array['merit_cost_impact_percentage'] / $last_array['merit_cost_impact_percentage_count'] ), 2) . '%';
			}

			unset($last_array['merit_cost_impact_percentage_count']);

			//promotion_cost_impact_percentage
			if(!empty($last_array['promotion_cost_impact_amount'])) {

				$last_array['promotion_cost_impact_amount'] = round(($last_array['promotion_cost_impact_amount']), 2);
			}

			if(!empty($last_array['promotion_cost_impact_percentage']) &&  !empty($last_array['promotion_cost_impact_percentage_count'])) {

				$last_array['promotion_cost_impact_percentage'] = round(($last_array['promotion_cost_impact_percentage'] / $last_array['promotion_cost_impact_percentage_count'] ), 2) . '%';
			}

			unset($last_array['promotion_cost_impact_percentage_count']);

			//market_adjustment_cost_percentage
			if(!empty($last_array['market_adjustment_cost_impact_amount'])) {

				$last_array['market_adjustment_cost_impact_amount'] = round(($last_array['market_adjustment_cost_impact_amount']), 2);
			}

			if(!empty($last_array['market_adjustment_cost_percentage']) &&  !empty($last_array['market_adjustment_cost_percentage_count'])) {

				$last_array['market_adjustment_cost_percentage'] = round(($last_array['market_adjustment_cost_percentage'] / $last_array['market_adjustment_cost_percentage_count'] ), 2) . '%';
			}

			unset($last_array['market_adjustment_cost_percentage_count']);

			array_push($data_array,$last_array);

		}

		$this->generateCSV($data_array, $header_array, $fileName);

		return;

	}

	/*
	* get Range Penetration & Average Increase summary
	*/
	public function get_range_pene_and_avg_increase_summary($rule_id) {

		$rule_id 			= (int)$rule_id;
		$emps_data_arr 		= array();
		$has_emp_data_cond 	= true;//false for admin
		$function_arr		= array();//filter for functions

		if(!empty($this->input->post("report_rating_ids"))) {

			$rating_arr = $this->input->post("report_rating_ids");

		}

		//check function filter condition
		if(!empty($this->input->post("functions_name_pene"))) {

			$function_arr = $this->input->post("functions_name_pene");

		}

		/* Check user condition */
		if($this->session->userdata('role_ses') == 1) {//for hr admin

			$has_emp_data_cond = false;
			//no need for emps_data_arr

		} else if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users

			$emps_data 	= $this->session->userdata('hr_usr_ids_ses');

			if(!empty($emps_data)) {

				$emps_data_arr = explode(',', $this->session->userdata('hr_usr_ids_ses'));
			}

		} elseif($this->session->userdata('role_ses') == 10) {//Manager Type of Users

			$emps_data 	= HLP_get_manager_emps_arr($this->session->userdata('email_ses'));

			if(!empty($emps_data)) {

				foreach($emps_data as $e_key => $emp_det) {

					$emps_data_arr[$e_key] = $emp_det['id'];

				}
			}
		}

		/* End to check user condition */
		$rslt = $this->Report_model->get_range_pene_and_avg_increase_summary($rule_id, $rating_arr, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$final_data = $this->Report_model->get_range_pene_and_avg_increase_final_summary($rule_id, $rating_arr, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$final_data_array = array();

		$header_array[] = 'PMS Rating';
		$header_array[] = 'Talent Rating';
		$header_array[] = 'Head Count';	
		$header_array[] = 'Min Avg Increase %';		
		$header_array[] = 'Q1 Pre Avg Penetration %';
		$header_array[] = 'Q1 Post Avg Penetration %';
		$header_array[] = 'Q1 Avg Increase %';
		$header_array[] = 'Q2 Pre Avg Penetration %';
		$header_array[] = 'Q2 Post Avg Penetration %';
		$header_array[] = 'Q2 Avg Increase %';
		$header_array[] = 'Q3 Pre Avg Penetration %';
		$header_array[] = 'Q3 Post Avg Penetration %';
		$header_array[] = 'Q3 Avg Increase %';
		$header_array[] = 'Q4 Pre Avg Penetration %';
		$header_array[] = 'Q4 Post Avg Penetration %';
		$header_array[] = 'Q4 Avg Increase %';
		$header_array[] = 'Max Pre Avg Penetration %';
		$header_array[] = 'Max Post Avg Penetration %';
		$header_array[] = 'Max Avg Increase %';

		if(!empty($rslt)) {

			foreach($rslt as $key => $rslt_data) {

				foreach($final_data as $f_key => $final_data_val ) {

					if($rslt_data['pms_rating'] == $final_data_val['pms_rating'] && 
						$rslt_data['talent_rating'] == $final_data_val['talent_rating']){

						if(!isset($final_data[$f_key]['headcount'])) {

							$final_data[$f_key]['headcount'] = 1;

						} else {

							$final_data[$f_key]['headcount'] = $final_data[$f_key]['headcount'] + 1;

						}

						//pre penetration

						//min
						if(!isset($final_data[$f_key]['min_pre'])) { $final_data[$f_key]['min_pre'] = 0; }
						if(!isset($final_data[$f_key]['min_pre_count'])) { $final_data[$f_key]['min_pre_count'] = 0; }

						//q1_pre
						if(!isset($final_data[$f_key]['q1_pre'])) { $final_data[$f_key]['q1_pre'] = 0; }
						if(!isset($final_data[$f_key]['q1_pre_count'])) { $final_data[$f_key]['q1_pre_count'] = 0; }

						//q2_pre
						if(!isset($final_data[$f_key]['q2_pre'])) { $final_data[$f_key]['q2_pre'] = 0; }
						if(!isset($final_data[$f_key]['q2_pre_count'])) { $final_data[$f_key]['q2_pre_count'] = 0; }

						//q3_pre
						if(!isset($final_data[$f_key]['q3_pre'])) { $final_data[$f_key]['q3_pre'] = 0; }
						if(!isset($final_data[$f_key]['q3_pre_count'])) { $final_data[$f_key]['q3_pre_count'] = 0; }

						//q4_pre
						if(!isset($final_data[$f_key]['q4_pre'])) { $final_data[$f_key]['q4_pre'] = 0; }
						if(!isset($final_data[$f_key]['q4_pre_count'])) { $final_data[$f_key]['q4_pre_count'] = 0; }

						//max_pre
						if(!isset($final_data[$f_key]['max_pre'])) { $final_data[$f_key]['max_pre'] = 0; }
						if(!isset($final_data[$f_key]['max_pre_count'])) { $final_data[$f_key]['max_pre_count'] = 0; }


						if(empty($rslt_data['pre_range_penetration']) || $rslt_data['pre_range_penetration'] < 0) {

							//<min
							$final_data[$f_key]['min_pre'] 			+= $final_data[$f_key]['min_pre'];
							$final_data[$f_key]['min_pre_count'] 	= $final_data[$f_key]['min_pre_count'] + 1;


						} else if($rslt_data['pre_range_penetration'] >=0 && $rslt_data['pre_range_penetration'] < 25 ) {
							//q1
							$final_data[$f_key]['q1_pre'] 		+= $rslt_data['pre_range_penetration'];
							$final_data[$f_key]['q1_pre_count'] = $final_data[$f_key]['q1_pre_count'] + 1;

						} else if($rslt_data['pre_range_penetration'] >= 25 && $rslt_data['pre_range_penetration'] < 50) {

							//q2
							$final_data[$f_key]['q2_pre'] 		+= $rslt_data['pre_range_penetration'];
							$final_data[$f_key]['q2_pre_count'] = $final_data[$f_key]['q2_pre_count'] + 1;

						} else if($rslt_data['pre_range_penetration'] >=50 && $rslt_data['pre_range_penetration'] < 75) {

							//q3
							$final_data[$f_key]['q3_pre'] 		+= $rslt_data['pre_range_penetration'];
							$final_data[$f_key]['q3_pre_count'] = $final_data[$f_key]['q3_pre_count'] + 1;

						} else if($rslt_data['pre_range_penetration'] >=75 && $rslt_data['pre_range_penetration'] < 100) {

							//q4
							$final_data[$f_key]['q4_pre'] 		+= $rslt_data['pre_range_penetration'];
							$final_data[$f_key]['q4_pre_count'] = $final_data[$f_key]['q4_pre_count'] + 1;

						} else if($rslt_data['pre_range_penetration'] >= 100) {

							//max
							$final_data[$f_key]['max_pre'] 		+= $rslt_data['pre_range_penetration'];
							$final_data[$f_key]['max_pre_count'] = $final_data[$f_key]['max_pre_count'] + 1;

						}
						//pre penetration end

						//post penetration

						//min
						if(!isset($final_data[$f_key]['min_post'])) { $final_data[$f_key]['min_post'] = 0; }
						if(!isset($final_data[$f_key][''])) { $final_data[$f_key]['min_post_count'] = 0; }

						//q1_ppost
						if(!isset($final_data[$f_key]['q1_post'])) { $final_data[$f_key]['q1_post'] 		 = 0; }
						if(!isset($final_data[$f_key]['q1_post_count'])) { $final_data[$f_key]['q1_post_count'] = 0; }

						//q2_post
						if(!isset($final_data[$f_key]['q2_post'])) { $final_data[$f_key]['q2_post'] 		 = 0; }
						if(!isset($final_data[$f_key]['q2_post_count'])) { $final_data[$f_key]['q2_post_count'] = 0; }

						//q3_post
						if(!isset($final_data[$f_key]['q3_post'])) { $final_data[$f_key]['q3_post'] 		 = 0; }
						if(!isset($final_data[$f_key]['q3_post_count'])) { $final_data[$f_key]['q3_post_count'] = 0; }

						//q4_post
						if(!isset($final_data[$f_key]['q4_post'])) { $final_data[$f_key]['q4_post'] 		 = 0; }
						if(!isset($final_data[$f_key]['q4_post_count'])) { $final_data[$f_key]['q4_post_count'] = 0; }

						//max_post
						if(!isset($final_data[$f_key]['max_post'])) { $final_data[$f_key]['max_post'] 		= 0; }
						if(!isset($final_data[$f_key]['max_post_count'])) { $final_data[$f_key]['max_post_count'] 	= 0; }


						if(empty($rslt_data['post_range_penetration']) || $rslt_data['post_range_penetration'] < 0) {

							//<min
							$final_data[$f_key]['min_post'] 		+= $final_data[$f_key]['min_post'];
							$final_data[$f_key]['min_post_count'] 	= $final_data[$f_key]['min_post_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >=0 && $rslt_data['post_range_penetration'] < 25 ) {
							//q1
							$final_data[$f_key]['q1_post'] 		+= $rslt_data['post_range_penetration'];
							$final_data[$f_key]['q1_post_count'] = $final_data[$f_key]['q1_post_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >= 25 && $rslt_data['post_range_penetration'] < 50) {

							//q2
							$final_data[$f_key]['q2_post'] 		+= $rslt_data['post_range_penetration'];
							$final_data[$f_key]['q2_post_count'] = $final_data[$f_key]['q2_post_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >=50 && $rslt_data['post_range_penetration'] < 75) {

							//q3
							$final_data[$f_key]['q3_post'] 		+= $rslt_data['post_range_penetration'];
							$final_data[$f_key]['q3_post_count'] = $final_data[$f_key]['q3_post_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >=75 && $rslt_data['post_range_penetration'] < 100) {

							//q4
							$final_data[$f_key]['q4_post'] 		+= $rslt_data['post_range_penetration'];
							$final_data[$f_key]['q4_post_count'] = $final_data[$f_key]['q4_post_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >= 100) {

							//max_post
							$final_data[$f_key]['max_post'] 		+= $rslt_data['post_range_penetration'];
							$final_data[$f_key]['max_post_count'] = $final_data[$f_key]['max_post_count'] + 1;

						}

						//post penetration end

						//avg penetration
						//min
						if(!isset($final_data[$f_key]['min_avg'])) { $final_data[$f_key]['min_avg'] = 0; }
						if(!isset($final_data[$f_key]['min_avg_count'])) { $final_data[$f_key]['min_avg_count'] = 0; }

						//q1_avg
						if(!isset($final_data[$f_key]['q1_avg'])) { $final_data[$f_key]['q1_avg'] 		 = 0; }
						if(!isset($final_data[$f_key]['q1_avg_count'])) { $final_data[$f_key]['q1_avg_count'] = 0; }

						//q2_avg
						if(!isset($final_data[$f_key]['q2_avg'])) { $final_data[$f_key]['q2_avg'] 		 = 0; }
						if(!isset($final_data[$f_key]['q2_avg_count'])) { $final_data[$f_key]['q2_avg_count'] = 0; }

						//q3_avg
						if(!isset($final_data[$f_key]['q3_avg'])) { $final_data[$f_key]['q3_avg'] 		 = 0; }
						if(!isset($final_data[$f_key]['q3_avg_count'])) { $final_data[$f_key]['q3_avg_count'] = 0; }

						//q4_avg
						if(!isset($final_data[$f_key]['q4_avg'])) { $final_data[$f_key]['q4_avg'] 		 = 0; }
						if(!isset($final_data[$f_key]['q4_avg_count'])) { $final_data[$f_key]['q4_avg_count'] = 0; }

						//max_avg
						if(!isset($final_data[$f_key]['max_avg'])) { $final_data[$f_key]['max_avg'] 		= 0; }
						if(!isset($final_data[$f_key]['max_avg_count'])) { $final_data[$f_key]['max_avg_count'] 	= 0; }


						if(empty($rslt_data['post_range_penetration']) || $rslt_data['post_range_penetration'] < 0) {

							//<min
							$final_data[$f_key]['min_avg'] 			+= $rslt_data['final_increment_per'];//$final_data[$f_key]['min_avg'];
							$final_data[$f_key]['min_avg_count'] 	= $final_data[$f_key]['min_avg_count'] + 1;


						} else if($rslt_data['post_range_penetration'] >=0 && $rslt_data['post_range_penetration'] < 25 ) {
							//q1
							$final_data[$f_key]['q1_avg'] 		+= $rslt_data['final_increment_per'];
							$final_data[$f_key]['q1_avg_count'] = $final_data[$f_key]['q1_avg_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >= 25 && $rslt_data['post_range_penetration'] < 50) {

							//q2
							$final_data[$f_key]['q2_avg'] 		+= $rslt_data['final_increment_per'];
							$final_data[$f_key]['q2_avg_count'] = $final_data[$f_key]['q2_avg_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >=50 && $rslt_data['post_range_penetration'] < 75) {

							//q3
							$final_data[$f_key]['q3_avg'] 		+= $rslt_data['final_increment_per'];
							$final_data[$f_key]['q3_avg_count'] = $final_data[$f_key]['q3_avg_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >=75 && $rslt_data['post_range_penetration'] < 100) {

							//q4
							$final_data[$f_key]['q4_avg'] 		+= $rslt_data['final_increment_per'];
							$final_data[$f_key]['q4_avg_count'] = $final_data[$f_key]['q4_avg_count'] + 1;

						} else if($rslt_data['post_range_penetration'] >= 100) {

							//max_avg
							$final_data[$f_key]['max_avg'] 		+= $rslt_data['final_increment_per'];
							$final_data[$f_key]['max_avg_count'] = $final_data[$f_key]['max_avg_count'] + 1;

						}
						//avg penetration end
					}
				}
			}

			foreach($final_data as $f => $final_val) {

				$final_data_array[$f]['pms_rating'] 	= $final_val['pms_rating'];
				$final_data_array[$f]['talent_rating'] 	= $final_val['talent_rating'];
				$final_data_array[$f]['headcount'] 		= $final_val['headcount'];

				//min with respect to post values
				//$final_data_array[$f]['min_pre_count'] 	= $final_val['min_pre_count'];
				$final_data_array[$f]['min_avg'] 		= 0;

				if($final_val['min_avg'] && $final_val['min_avg_count']) {
					//get avg
					$final_data_array[$f]['min_avg'] 		= round($final_val['min_avg'] / $final_val['min_avg_count'], 2) . '%';
				}

				//for q1
				$final_data_array[$f]['q1_pre'] 		= 0;

				if($final_val['q1_pre'] && $final_val['q1_pre_count']) {
					//get avg
					$final_data_array[$f]['q1_pre'] 		= round($final_val['q1_pre'] / $final_val['q1_pre_count'], 2) . '%';
				}

				$final_data_array[$f]['q1_post'] 		= 0;

				if($final_val['q1_post'] && $final_val['q1_post_count']) {
					//get avg
					$final_data_array[$f]['q1_post'] 		= round($final_val['q1_post'] / $final_val['q1_post_count'], 2) . '%';
				}

				$final_data_array[$f]['q1_avg'] 		= 0;

				if($final_val['q1_avg'] && $final_val['q1_avg_count']) {
					//get avg
					$final_data_array[$f]['q1_avg'] 		= round($final_val['q1_avg'] / $final_val['q1_avg_count'], 2) . '%';
				}

				//for q2
				$final_data_array[$f]['q2_pre'] 		= 0;

				if($final_val['q2_pre'] && $final_val['q2_pre_count']) {
					//get avg
					$final_data_array[$f]['q2_pre'] 		= round($final_val['q2_pre'] / $final_val['q2_pre_count'], 2) . '%';
				}

				$final_data_array[$f]['q2_post'] 		= 0;

				if($final_val['q2_post'] && $final_val['q2_post_count']) {
					//get avg
					$final_data_array[$f]['q2_post'] 		= round($final_val['q2_post'] / $final_val['q2_post_count'], 2) . '%';
				}

				$final_data_array[$f]['q2_avg'] 		= 0;

				if($final_val['q2_avg'] && $final_val['q2_avg_count']) {
					//get avg
					$final_data_array[$f]['q2_avg'] 		= round($final_val['q2_avg'] / $final_val['q2_avg_count'], 2) . '%';
				}

				//for q3
				$final_data_array[$f]['q3_pre'] 		= 0;

				if($final_val['q3_pre'] && $final_val['q3_pre_count']) {
					//get avg
					$final_data_array[$f]['q3_pre'] 		= round($final_val['q3_pre'] / $final_val['q3_pre_count'], 2) . '%';
				}

				$final_data_array[$f]['q3_post'] 		= 0;

				if($final_val['q3_post'] && $final_val['q3_post_count']) {
					//get avg
					$final_data_array[$f]['q3_post'] 		= round($final_val['q3_post'] / $final_val['q3_post_count'], 2) . '%';
				}

				$final_data_array[$f]['q3_avg'] 		= 0;

				if($final_val['q3_avg'] && $final_val['q3_avg_count']) {
					//get avg
					$final_data_array[$f]['q3_avg'] 		= round($final_val['q3_avg'] / $final_val['q3_avg_count'], 2) . '%';
				}

				//for q4
				$final_data_array[$f]['q4_pre'] 		= 0;

				if($final_val['q4_pre'] && $final_val['q4_pre_count']) {
					//get avg
					$final_data_array[$f]['q4_pre'] 		= round($final_val['q4_pre'] / $final_val['q4_pre_count'], 2) . '%';
				}

				$final_data_array[$f]['q4_post'] 		= 0;

				if($final_val['q4_post'] && $final_val['q4_post_count']) {
					//get avg
					$final_data_array[$f]['q4_post'] 		= round($final_val['q4_post'] / $final_val['q4_post_count'], 2) . '%';
				}

				$final_data_array[$f]['q4_avg'] 		= 0;

				if($final_val['q4_avg'] && $final_val['q4_avg_count']) {
					//get avg
					$final_data_array[$f]['q4_avg'] 		= round($final_val['q4_avg'] / $final_val['q4_avg_count'], 2) . '%';
				}

				//for max
				$final_data_array[$f]['max_pre'] 		= 0;

				if($final_val['max_pre'] && $final_val['max_pre_count']) {
					//get avg
					$final_data_array[$f]['max_pre'] 		= round($final_val['max_pre'] / $final_val['max_pre_count'], 2) . '%';
				}

				$final_data_array[$f]['max_post'] 		= 0;

				if($final_val['max_post'] && $final_val['max_post_count']) {
					//get avg
					$final_data_array[$f]['max_post'] 		= round($final_val['max_post'] / $final_val['max_post_count'], 2) . '%';
				}

				$final_data_array[$f]['max_avg'] 		= 0;

				if($final_val['max_avg'] && $final_val['max_avg_count']) {
					//get avg
					$final_data_array[$f]['max_avg'] 		= round($final_val['max_avg'] / $final_val['max_avg_count'], 2) . '%';
				}
			}

		}

		$fileName = "range_pene_and_avg_increase.csv";

		$this->generateCSV($final_data_array, $header_array, $fileName);

		exit;
	}


	/*
	* get promotion summary
	*/
	public function get_promotion_summary($rule_id) {

		$rule_id 			= (int)$rule_id;
		$emps_data_arr 		= array();
		$has_emp_data_cond 	= true;//false for admin
		$function_arr		= array();//filter for functions

		if(empty($rule_id)) {
			return;
		}

		//check function filter condition
		if(!empty($this->input->post("functions_name"))) {

			$function_arr = $this->input->post("functions_name");

		}

		/* Check user condition */
		if($this->session->userdata('role_ses') == 1) {//for hr admin

			$has_emp_data_cond = false;
			//no need for emps_data_arr

		} else if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users

			$emps_data 	= $this->session->userdata('hr_usr_ids_ses');

			if(!empty($emps_data)) {

				$emps_data_arr = explode(',', $this->session->userdata('hr_usr_ids_ses'));
			}

		} elseif($this->session->userdata('role_ses') == 10) {//Manager Type of Users

			$emps_data 	= HLP_get_manager_emps_arr($this->session->userdata('email_ses'));

			if(!empty($emps_data)) {

				foreach($emps_data as $e_key => $emp_det) {

					$emps_data_arr[$e_key] = $emp_det['id'];

				}
			}
		}

		/* End to check user condition */

		$cond = array('id' => $rule_id);

		$fileName = 'promotion_summary.csv';
		//get new promotion field
		$new_promotion_field 	= '';
		$data_array 			= array();
		$header_array 			= array();
		$last_array 			= array();
		$promotion_summary 		= array();

		$propmotion_basis_on = $this->common_model->get_table("hr_parameter", "id, promotion_basis_on",$cond , "id asc");

		if(!empty($propmotion_basis_on)) {

			$propmotion_basis_on = $propmotion_basis_on[0];

		} else {

			return;
		}

		if(!empty($propmotion_basis_on['promotion_basis_on'])) {

			if($propmotion_basis_on['promotion_basis_on'] == 1) {

				$new_promotion_field = 'emp_new_designation';

			} else if($propmotion_basis_on['promotion_basis_on'] == 2) {

				$new_promotion_field = 'emp_new_grade';

			} else if($propmotion_basis_on['promotion_basis_on'] == 3) {

				$new_promotion_field = 'emp_new_level';

			}

		}

		if(empty($new_promotion_field)) {

			return;
		}

		$data_array 			= $this->Report_model->get_grade_and_level_summary_by_rule($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$promotion_summary 		= $this->Report_model->get_promotion_summary($rule_id, $new_promotion_field, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$post_promotion_summary = $this->Report_model->get_post_promotion_summary($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);

		if(!empty($data_array)) {

			$header_array[] = 'Band';
			$header_array[] = 'Current Level';
			$header_array[] = 'HeadCount';
			$header_array[] = 'Promotion';
			$header_array[] = '% Promotion by level';
			$header_array[] = 'HeadCount Post Promotions';

			$last_array['band'] 						= 'Total';
			$last_array['current_level'] 				= '';
			$last_array['headcount'] 					= 0;
			$last_array['promotion'] 					= 0;
			$last_array['promotion_by_level'] 			= 0;
			$last_array['headcount_post_promotion'] 	= 0;

			foreach($data_array as $key => $val) {

				$data_array[$key]['band'] 					= trim($val['band']) ?? '';
				$data_array[$key]['current_level'] 			= trim($val['current_level']) ?? '';
				$data_array[$key]['headcount'] 				= trim($val['headcount']) ?? 0;
				$data_array[$key]['promotion'] 				= 0;

				if(!empty($promotion_summary)) {

					foreach($promotion_summary as $p_key => $promotion_val) {

						if($data_array[$key]['band'] == $promotion_val['band'] && $data_array[$key]['current_level'] == $promotion_val['current_level']) {

							$data_array[$key]['promotion'] 				= trim($promotion_val['promotion_count']) ?? 0;

						}
					}
				}

				$data_array[$key]['promotion_by_level'] = 0;

				if($data_array[$key]['headcount'] && $data_array[$key]['promotion']) {

					$data_array[$key]['promotion_by_level'] 	= round(($data_array[$key]['promotion']/$data_array[$key]['headcount']) * 100 , 2). '%';

				}

				$data_array[$key]['headcount_post_promotion'] = $data_array[$key]['headcount'] - $data_array[$key]['promotion'];

				if(!empty($post_promotion_summary)) {

					foreach($post_promotion_summary as $post_key => $post_promotion_val) {

						if($data_array[$key]['band_id'] == $post_promotion_val['new_band'] && $data_array[$key]['level_id'] == $post_promotion_val['new_level'] && $post_promotion_val['new_level_count']) {

							$data_array[$key]['headcount_post_promotion']  	= $data_array[$key]['headcount_post_promotion'] + $post_promotion_val['new_level_count'];

						}
					}
				}

				unset($data_array[$key]['band_id']);
				unset($data_array[$key]['level_id']);

				$last_array['headcount'] 				+= $data_array[$key]['headcount'];
				$last_array['promotion'] 				+= $data_array[$key]['new_level_count'];
				$last_array['headcount_post_promotion'] += $data_array[$key]['headcount_post_promotion'];

			}

		} else {

			$data_array[0]['band'] 							= 'NO DATA FOUND';
			$data_array[0]['current_level'] 				= '';
			$data_array[0]['headcount'] 					= '';
			$data_array[0]['promotion'] 					= '';
			$data_array[0]['promotion_by_level'] 			= '';
			$data_array[0]['headcount_post_promotion'] 		= '';
			//"no data found";
		}

		if(!empty($last_array)) {

			if(!empty($last_array['headcount']) &&  !empty($last_array['promotion'])) {

				$last_array['promotion_by_level'] = round((($last_array['promotion'] / $last_array['headcount']) * 100 ), 2). '%';
			}

			array_push($data_array,$last_array);

		}

		$this->generateCSV($data_array, $header_array, $fileName);

		exit;
	}


	/*
	* get miscellaneous summary report
	*/
	public function get_miscellaneous_summary($rule_id) {

		$rule_id 			= (int)$rule_id;
		$emps_data_arr 		= array();
		$has_emp_data_cond 	= true;//false for admin
		$function_arr		= array();//filter for functions


		if(empty($rule_id)) {
			return;
		}

		//check function filter condition
		if(!empty($this->input->post("functions_name_process"))) {

			$function_arr = $this->input->post("functions_name_process");

		}

		/* Check user condition */
		if($this->session->userdata('role_ses') == 1) {//for hr admin

			$has_emp_data_cond = false;
			//no need for emps_data_arr

		} else if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users

			$emps_data 	= $this->session->userdata('hr_usr_ids_ses');

			if(!empty($emps_data)) {

				$emps_data_arr = explode(',', $this->session->userdata('hr_usr_ids_ses'));
			}

		} elseif($this->session->userdata('role_ses') == 10) {//Manager Type of Users

			$emps_data 	= HLP_get_manager_emps_arr($this->session->userdata('email_ses'));

			if(!empty($emps_data)) {

				foreach($emps_data as $e_key => $emp_det) {

					$emps_data_arr[$e_key] = $emp_det['id'];

				}
			}
		}

		/* End to check user condition */

		$cond = array('id' => $rule_id);

		$fileName = 'miscellaneous_summary_report.csv';
		$data_array 			= array();
		$header_array 			= array();
		$last_array 			= array();
		$promotion_summary 		= array();

		$data_array 					= $this->Report_model->get_grade_summary_by_rule($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$esop_summary 					= $this->Report_model->get_esop_filed_summary($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr);
		$market_total_salary_level_9 	= $this->Report_model->get_filed_summary($rule_id, 'market_total_salary_level_9' , $has_emp_data_cond, $emps_data_arr, $function_arr);
		$market_total_salary_level_max 	= $this->Report_model->get_filed_summary($rule_id, 'market_total_salary_level_max', $has_emp_data_cond, $emps_data_arr, $function_arr);

		if(!empty($data_array)) {

			$header_array[] = 'Band';
			$header_array[] = 'HeadCount';
			$header_array[] = 'Additial PLI No.';
			$header_array[] = 'Additial PLI %';
			$header_array[] = 'Continuons Reward No. level 9';
			$header_array[] = 'Continuons Reward level 9 %';
			$header_array[] = 'Continuouns Reward No. level max';
			$header_array[] = 'Continuouns Reward level max %';

			$last_array['band'] 							= 'Total';
			$last_array['head_count'] 						= 0;
			$last_array['add_pli_no'] 						= 0;
			$last_array['add_pli_per'] 						= '';
			$last_array['continuous_reward_no_level_9_no'] 	= 0;
			$last_array['continuous_reward_level_9_per']	= '';
			$last_array['continuous_reward_no_level_max_no']= 0;
			$last_array['continuous_reward_level_max_per']	= '';

			foreach($data_array as $key => $val) {

				$data_array[$key]['band'] 					= trim($val['band']) ?? '';
				$data_array[$key]['headcount'] 				= trim($val['headcount']) ?? 0;
				$last_array['head_count'] += $data_array[$key]['headcount'];

				$data_array[$key]['add_pli_no'] 			= 0;
				$data_array[$key]['add_pli_per'] 			= 0;
				$data_array[$key]['continuous_reward_no_level_9_no'] 	= 0;
				$data_array[$key]['continuous_reward_level_9_per'] 		= 0;
				$data_array[$key]['continuous_reward_no_level_max_no'] 	= 0;
				$data_array[$key]['continuous_reward_level_max_per'] 	= 0;

				if(!empty($esop_summary)) {

					foreach($esop_summary as $e_key => $esop_val) {//dd($promotion_val);

						if($data_array[$key]['band'] == $esop_val['band']) {

							if(trim($esop_val['esopCount'])) {

								$data_array[$key]['add_pli_no'] = round($esop_val['esopCount'], 2);
								$last_array['add_pli_no'] 		+= $data_array[$key]['add_pli_no'];
							}
						}

						//get per
						$data_array[$key]['add_pli_no'] = (float)$data_array[$key]['add_pli_no'];

						if(!empty($data_array[$key]['headcount']) && !empty($data_array[$key]['add_pli_no'])) {

							$data_array[$key]['add_pli_per'] = round((($data_array[$key]['add_pli_no'] / $data_array[$key]['headcount']) * 100), 2). '%';

						}
					}
				}

				if(!empty($market_total_salary_level_9)) {

					foreach($market_total_salary_level_9 as $m_9_key => $market_total_salary_level_9_val) {

						if($data_array[$key]['band'] == $market_total_salary_level_9_val['band']) {

							if(trim($market_total_salary_level_9_val['fieldTotal'])) {

								$data_array[$key]['continuous_reward_no_level_9_no'] = round($market_total_salary_level_9_val['fieldTotal'], 2);
								$last_array['continuous_reward_no_level_9_no'] 		+= $data_array[$key]['continuous_reward_no_level_9_no'];
							}
						}

						//get per
						$data_array[$key]['continuous_reward_no_level_9_no'] = (float)$data_array[$key]['continuous_reward_no_level_9_no'];

						if(!empty($data_array[$key]['headcount']) && !empty($data_array[$key]['continuous_reward_no_level_9_no'])) {

							$data_array[$key]['continuous_reward_no_level_max'] = round((($data_array[$key]['continuous_reward_no_level_9_no'] / $data_array[$key]['headcount']) * 100), 2). '%';;

						}
					}
				}

				if(!empty($market_total_salary_level_max)) {

					foreach($market_total_salary_level_max as $m_m_key => $market_total_salary_level_max_val) {//dd($promotion_val);

						if($data_array[$key]['band'] == $market_total_salary_level_max_val['band']) {

							if(trim($market_total_salary_level_max_val['fieldTotal'])) {

								$data_array[$key]['continuous_reward_no_level_max_no'] = round($market_total_salary_level_max_val['fieldTotal'], 2);
								$last_array['continuous_reward_no_level_max_no'] 	  += $data_array[$key]['continuous_reward_no_level_max_no'];
							}

						}

						//get per
						$data_array[$key]['continuous_reward_no_level_max_no'] = (float)$data_array[$key]['continuous_reward_no_level_max_no'];

						if(!empty($data_array[$key]['headcount']) && !empty($data_array[$key]['continuous_reward_no_level_max_no'])) {

							$data_array[$key]['continuous_reward_level_max_per'] = round((($data_array[$key]['continuous_reward_no_level_max_no'] / $data_array[$key]['headcount']) * 100), 2). '%';;

						}
					}
				}
			}

		} else {

			$data_array[0]['band'] 								= 'NO DATA FOUND';
			$data_array[0]['headcount'] 						= '';
			$data_array[0]['add_pli_no'] 						= '';
			$data_array[0]['add_pli_per'] 						= '';
			$data_array[0]['continuous_reward_no_level_9_no'] 	= '';
			$data_array[0]['continuous_reward_level_9_per'] 	= '';
			$data_array[0]['continuous_reward_no_level_max_no'] = '';
			$data_array[0]['continuous_reward_level_max_per']   = '';
			//"no data found";
		}

		if(!empty($last_array)) {

			array_push($data_array,$last_array);

		}

		$this->generateCSV($data_array, $header_array, $fileName);

		exit;
	}
        
}
