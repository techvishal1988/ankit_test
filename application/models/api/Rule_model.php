<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Rule_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		
    }	
    public function setdb($dbname)
    {
       $this->db->query("use ".$dbname); 
    }
    public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}
    public function get_rule_dtls_for_performance_cycles($condition_arr)
	{	
		$this->db->select("hr_parameter.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle","performance_cycle.id = hr_parameter.performance_cycle_id");
		return $this->db->where($condition_arr)->get()->row_array();
	}
    public function get_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id)
	{	
                $this->db->select("display_name, value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
		$this->db->where(array("business_attribute.module_name"=>CV_PREVIOUS_INCREMENTS));
		$this->db->where(array("business_attribute.status"=>1));
		$this->db->order_by("business_attribute.id","desc");
		return $this->db->get()->result_array();
	}  	
        public function get_employee_market_salary_dtls_for_graph($rule_id, $uid, $upload_id,$marketDATA)
	{	
		$this->db->select("display_name, value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
		//CB:Ravi on 22-02-2018
		//$this->db->where(array("business_attribute.module_name"=>CV_MARKET_SALARY_ELEMENT));
		$this->db->where(array("business_attribute.module_name"=>$marketDATA));
		$this->db->order_by("datum.value","asc");
		return $this->db->get()->result_array();
	} 
        public function get_peer_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id, $rule_user_ids, $graph_on=CV_GRADE)
	{	
		$this->db->select("id, grade, level");
		$this->db->from("login_user");
		$this->db->where(array("login_user.id"=>$uid));
		$user_grade_level_dtls = $this->db->get()->row_array();

		$this->db->select("login_user.name, login_user.email, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, `final_salary`");
		$this->db->from("employee_salary_details");	
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");	
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->where("login_user.id != '".$uid."' and login_user.id in (".$rule_user_ids.")");
		if($graph_on==CV_LEVEL)
		{
			$this->db->where(array("login_user.level"=>$user_grade_level_dtls["level"]));
		}
		else
		{
			$this->db->where(array("login_user.grade"=>$user_grade_level_dtls["grade"]));
		}
		$this->db->order_by("final_salary","asc");
		return $this->db->get()->result_array();		
	} 
        public function get_team_employee_salary_dtls_for_graph($rule_id, $uid, $upload_id, $rule_user_ids)
	{	
		$this->db->select("row_owner.first_approver");
		$this->db->from("row_owner");
		$this->db->where(array("row_owner.upload_id"=>$upload_id, "row_owner.user_id" =>$uid));
		$user_first_approver = $this->db->get()->row_array()["first_approver"];

		if($user_first_approver)
		{
			$this->db->select("user_id");
			$this->db->from("row_owner");
			//$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$user_first_approver));
                        $this->db->where(array( "first_approver"=>$user_first_approver));
			$this->db->where("user_id != '".$uid."' and user_id in (".$rule_user_ids.")" );
			$team_user_arr = $this->db->get()->result_array();
			
			if($team_user_arr)
			{
				$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

				$this->db->select("login_user.name, login_user.email, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, `final_salary`");
				$this->db->from("employee_salary_details");		
				$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
				$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
				$this->db->where_in("employee_salary_details.user_id",$team_user_ids);
				$this->db->order_by("final_salary","asc");
				return $this->db->get()->result_array();
			}
		}
	} 
        public function get_employee_salary_dtls($condition_arr)
	{	
		$this->db->select("login_user.name, login_user.email, (select manage_designation.name from manage_designation where manage_designation.id = login_user.desig) as current_designation, employee_salary_details.id, employee_salary_details.manager_emailid, employee_salary_details.user_id, `increment_applied_on_salary`, `performnace_based_increment`, `performnace_based_salary`, `crr_based_increment`, `crr_based_salary`, `standard_promotion_increase`, market_salary, `final_salary`, employee_salary_details.actual_salary, employee_salary_details.manager_discretions, (select hr_parameter.status from hr_parameter where hr_parameter.id = employee_salary_details.rule_id) as rule_status, employee_salary_details.sp_manager_discretions, employee_salary_details.emp_new_designation, employee_salary_details.emp_citation, employee_salary_details.sp_increased_salary, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	} 
public function get_user_cell_value_frm_datum($upload_id, $row_no, $condition_arr=array())
	{		
		/*$this->db->select("*");
		$this->db->from("tuple");
		$user_tuple_dtls = $this->db->where(array("tuple.user_id"=>$user_id))->order_by("id","desc")->get()->row_array();*/

		$this->db->select("datum.*");
		$this->db->from("datum");
	return $this->db->where(array("data_upload_id"=>$upload_id, "row_num"=>$row_no))->where($condition_arr)->get()->row_array();
	}
    public function get_table_row($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->row_array();		
	}    
        public function get_rule_wise_emp_list_for_increments($rule_id)
	{	
		/*$this->db->select("login_user.id, login_user.name, login_user.email, employee_salary_details.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		return $this->db->get()->result_array();*/

		/*$this->db->select("login_user.id, login_user.name, login_user.email, employee_salary_details.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		return $this->db->get()->result_array();*/

		//CB::Ravi on 15-02-2018
		//$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, employee_salary_details.upload_id");
		$this->db->select("login_user.id,employee_salary_details.increment_applied_on_salary,employee_salary_details.final_salary,employee_salary_details.market_salary,employee_salary_details.final_salary, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, login_user.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		/*$this->db->where(array("role >"=> 1, "login_user.status !="=>2));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}*/
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		$data = $this->db->get()->result_array();
		$tempArr =	array();	
		if($data)
		{
			foreach($data as $row)
			{
				$row["date_of_joining"] = "";
				$row["performance_rating"] = "";

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["date_of_joining"] = $dt["value"];
				}

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["performance_rating"] = $dt["value"];
				}

				$tempArr[] = $row;
			}
		}
		return $tempArr;
	}  
        public function get_rule_wise_emp_list_for_increments_for_api_graph($rule_id)
	{	
		/*$this->db->select("login_user.id, login_user.name, login_user.email, employee_salary_details.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		return $this->db->get()->result_array();*/

		/*$this->db->select("login_user.id, login_user.name, login_user.email, employee_salary_details.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		return $this->db->get()->result_array();*/

		//CB::Ravi on 15-02-2018
		//$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, employee_salary_details.upload_id");
		$this->db->select("login_user.id,hr_parameter.salary_rule_name,performance_cycle.name as cycle_name,employee_salary_details.increment_applied_on_salary,employee_salary_details.final_salary,employee_salary_details.market_salary,employee_salary_details.final_salary, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, login_user.upload_id");
		$this->db->from("employee_salary_details");
		$this->db->join("login_user","login_user.id = employee_salary_details.user_id");		
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
                $this->db->join("hr_parameter", "hr_parameter.id = employee_salary_details.rule_id");
                $this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		/*$this->db->where(array("role >"=> 1, "login_user.status !="=>2));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}*/
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		$this->db->order_by("login_user.name asc");
		$data = $this->db->get()->result_array();
		$tempArr =	array();	
		if($data)
		{
			foreach($data as $row)
			{
				$row["date_of_joining"] = "";
				$row["performance_rating"] = "";

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["date_of_joining"] = $dt["value"];
				}

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["performance_rating"] = $dt["value"];
				}

				$tempArr[] = $row;
			}
		}
		return $tempArr;
	}  
    public function get_rule_wise_emp_list_for_increments_for_api_comp_graph($rule_id, $arr = "", $to_currency_id = "", $cond="")
	{
		$this->db->select("hr_parameter.performance_cycle_id,hr_parameter.salary_rule_name,performance_cycle.name as cycle_name,hr_parameter.comparative_ratio,hr_parameter.comparative_ratio_range,"
                        . "employee_salary_details.performnace_based_increment,employee_salary_details.emp_name,employee_salary_details.email_id,employee_salary_details.gender,"
                        . "employee_salary_details.country,employee_salary_details.city,employee_salary_details.business_level_1,employee_salary_details.business_level_2,employee_salary_details.business_level_3,"
                        . "employee_salary_details.designation,employee_salary_details.function,employee_salary_details.sub_function,employee_salary_details.sub_sub_function,"
                        . "employee_salary_details.grade,employee_salary_details.level,employee_salary_details.education,employee_salary_details.increment_applied_on_salary,"
                        . "employee_salary_details.critical_talent,employee_salary_details.critical_position,employee_salary_details.special_category,"
                        . "employee_salary_details.company_name, employee_salary_details.crr_val,employee_salary_details.performance_rating,"
                        . "employee_salary_details.current_base_salary,employee_salary_details.market_salary,employee_salary_details.final_salary,"
                        . "employee_salary_details.actual_salary,employee_salary_details.allowance_1,employee_salary_details.allowance_2,"
                        . "employee_salary_details.allowance_3,employee_salary_details.allowance_4,employee_salary_details.allowance_5,"
                        . "employee_salary_details.allowance_6,employee_salary_details.allowance_7,employee_salary_details.allowance_8,employee_salary_details.allowance_9,employee_salary_details.allowance_10,"
                        . "((employee_salary_details.final_salary - employee_salary_details.increment_applied_on_salary) / employee_salary_details.increment_applied_on_salary)*100 as Salary_increase_percentage,"
						. "employee_salary_details.max_hike,employee_salary_details.manager_discretions,login_user.urban_rural_classification AS urban_rural_classification,"
						. "employee_salary_details.pre_quartile_range_name,employee_salary_details.post_quartile_range_name"
						);
		if(!empty($to_currency_id)) {//this cond use in case of salary increase budget report
			$this->db->select("(employee_salary_details.emp_final_bdgt * currency_rates.rate) as allocated_budget,"
							. "(employee_salary_details.final_salary - employee_salary_details.increment_applied_on_salary {$cond}) * rate as utilized_budget, "
							. "(employee_salary_details.emp_final_bdgt - (employee_salary_details.final_salary - employee_salary_details.increment_applied_on_salary {$cond}) * rate) as available_budget"
			);
		}

		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter", "hr_parameter.id = employee_salary_details.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id","left");

		if(!empty($to_currency_id)) {//this cond use in case of salary increase budget report
			$this->db->join("manage_currency", "UPPER(manage_currency.name) = UPPER(employee_salary_details.currency)");
			$this->db->join("currency_rates", "currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = {$to_currency_id}");
		}

		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));

		if($arr)
		{
			$this->db->where($arr);
		}
		$data = $this->db->get()->result_array();

		return $data;
	}


        public function getbusiness_attributeDisplayname($table,$data)
        {
            return $this->db->get_where($table,$data)->result_array();
        }
        public function get_performance_cycles_for_api($condition_arr)
	{
		$this->db->select("performance_cycle.id,performance_cycle.name, ");
		$this->db->from("performance_cycle");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("performance_cycle.id asc");
		return $this->db->get()->result_array();
	}
	     
        
}