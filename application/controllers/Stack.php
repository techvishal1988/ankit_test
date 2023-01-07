<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stack extends CI_Controller 
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
        
        public function grade($id)
        {
           $res= $this->Report_model->grade();
           $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
           foreach($res as $r)
            {
                    $res['Grade'][] = $r;
            }
            $data['res']=$res;
            $data['graphurl']=base_url('report/json_for_grade');
            $data['body']='report/stack/stack_grade';
            //$data['body']='report/grade';
            $data['breadcrumb']='Pay Range Analysis';
            $this->load->view('common/structure',$data);	
        }
        
        public function level($id)
        {
          $res= $this->Report_model->level();
          $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
           foreach($res as $r)
            {
                    $res['Level'][] = $r;
            }
            $data['res']=$res;
            $data['graphurl']=base_url('report/json_for_level');
            $data['body']='report/stack/stack_level';
            $data['breadcrumb']='Pay Range Analysis';
           //  $data['body']='report/level';
            $this->load->view('common/structure',$data);
            //$this->load->view('report/level',$data);  
        }
        
        public function designation($id)
        {
            $res= $this->Report_model->designation();
            $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
           foreach($res as $r)
            {
                    $res['DesignationTitle'][] = $r;
            }
            $data['res']=$res;
            $data['breadcrumb']='Pay Range Analysis';
            $data['graphurl']=base_url('report/json_for_desg');
            $data['body']='report/stack/stack_desig';
            $this->load->view('common/structure',$data);
            //$this->load->view('report/desig',$data); 
        }
        
        public function budget($pc_id)
        {
            $data['breadcrumb']='Budget utilization against allocated budget';
            $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
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
                    $data['msg']='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data not found.</b></div>';
                }
                $data['graphurl']=base_url('report/json_budget/'.$pc_id);
                $data['body']='report/stack/stack_budget';
                $this->load->view('common/structure',$data);
        }

        public function salary_increase_both($id)
            {
                $data['res']=$this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", "func.id, func.name, empsal.performance_rating,
                    
                    min(empsal.manager_discretions)  as 'Minimum_hike',
                    avg(empsal.manager_discretions) as 'Average_hike',max(empsal.manager_discretions) as 'Maximum_hike'", "lusr.id = empsal.user_id
                    and lusr.function_id = func.id
                    group by func.id, func.name, empsal.performance_rating", "lusr.id asc");
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_for_both_increase_salary');
                $data['body']='report/stack/stack_salary_increase_range';
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
            }
          
        public function get_salary_increase_rpt_data_function($id)
        { 
                 $data['res']= $this->Report_model->get_salary_increase_rpt_data_function();
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_get_salary_increase_rpt_data_function');
                $data['body']='report/stack/stack_salary_increase_range';
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
        }
        
        public function get_salary_increase_rpt_data_rating($id)
        { 
                $data['res'] = $this->Report_model->get_table("employee_salary_details empsal", "empsal.performance_rating, max(empsal.manager_discretions) as 'Maximum_hike', min(empsal.manager_discretions) as 'Minimum_hike', avg(empsal.manager_discretions) as 'Average_hike'", "", "id asc", "empsal.performance_rating");
                $data['breadcrumb']='Salary Increase Range Analysis';
                $data['graphurl']=base_url('report/json_get_salary_increase_rpt_data_rating');
                 $data['body']='report/stack/stack_salary_increase_range';
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);
            }
        
	public function get_crr_rpt_data_function($rule)
        {
			if(isset($rule))
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
                                $str .= "(SUM(CASE WHEN empsal.crr_val  < ".($row["max"])." THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '<".$row["max"]."',";
                        }                                
                        else
                        {
                                $str .= "(SUM(CASE WHEN ((empsal.crr_val >= ".($row["min"]).") AND(empsal.crr_val < ".($row["max"]).")) THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '".$row["min"]."-".$row["max"]."',";
                        }

                        if(($i+1)==count($crr_range_arr))
                        {
                                $str .= "(SUM(CASE WHEN (empsal.crr_val >= ".($row["max"]).") THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '>".$row["max"]."'";
                        }                            
                        $i++;
                }

                $rpt_data = $this->rule_model->get_table("employee_salary_details empsal, manage_function func, login_user lusr", $str, "lusr.id = empsal.user_id 
                AND lusr.function_id = func.id AND empsal.rule_id = ".$rule_id."
                group by func.id, func.name", "lusr.id asc");
//                echo '<pre />';
//                print_r($res);
                $data['res']=$rpt_data;
			}
               $data['breadcrumb']='Population Distribution on CR Range';
               $data['rule']= $this->Report_model->GetRule();
               $data['graphurl']=base_url('report/json_get_crr_rpt_data_function/'.$rule);
			   $data['title'] = "Population Distribution on CR Range";
               $data['body']='report/stack/stack_crr_report';
               //  $data['body']='report/level';
                $this->load->view('common/structure',$data);  
        }
        
         
        public function get_crr_rpt_data_rating($rule)
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
                                    $str .= "(SUM(CASE WHEN empsal.crr_val < ".($row["max"])." THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '<".$row["max"]."',";
                            }                                
                            else
                            {
                                    $str .= "(SUM(CASE WHEN ((empsal.crr_val >= ".($row["min"]).") AND(empsal.crr_val < ".($row["max"]).")) THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '".$row["min"]."-".$row["max"]."',";
                            }

                            if(($i+1)==count($crr_range_arr))
                            {
                                    $str .= "(SUM(CASE WHEN (empsal.crr_val >= ".($row["max"]).") THEN 1 ELSE 0 END) / COUNT(empsal.crr_val)) * 100 AS '>".$row["max"]."'";
                            }                            
                            $i++;
                    }

                    $rpt_data = $this->Report_model->get_table("employee_salary_details empsal", $str, "empsal.rule_id = ".$rule_id, "id asc", "empsal.performance_rating");
            
                $data['res']=$rpt_data;
                $data['breadcrumb']='Population Distribution on CR Range';
                $data['rule']= $this->Report_model->GetRule();
                $data['graphurl']=base_url('report/json_get_crr_rpt_data_rating/'.$rule);
				$data['title'] = "Population Distribution on CR Range";
                $data['body']='report/stack/stack_crr_report';
                $this->load->view('common/structure',$data);  
            }
        
        public function demo_level()
        {
            $res= $this->Report_model->level();
            $data["salary_cycles_list"] = $this->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
            foreach($res as $r)
             {
                     $res['Level'][] = $r;
             }
             $data['title']='[Demo] Graph for level';
             $data['res']=$res;
             $data['graphurl']=base_url('report/json_for_grade');
             $data['body']='report/stack/pie_grade';
             //$data['body']='report/grade';
             $data['breadcrumb']='Pay Range Analysis';
             $this->load->view('common/structure',$data);
        }
        
        public function paymix()
        {
             $res= $this->Report_model->paymix();
             $data['title']='Pay mix report';
             $data['res']=$res;
             $data['graphurl']=base_url('report/json_for_grade');
             $data['body']='report/stack/pie_paymix';
             //$data['body']='report/grade';
             $data['breadcrumb']='Pay Mix';
             $this->load->view('common/structure',$data);
        }
	
}
