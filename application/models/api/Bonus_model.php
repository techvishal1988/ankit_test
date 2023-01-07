<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_model extends CI_Model
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
    

   /* public function getAttributeValue_NIU($conditionArray=array(),$groupBy = ''){
    	$returnValue = $this->db->select('*');
    	if(count($conditionArray)>0){
    		$returnValue->where($conditionArray);
    	}
    	if($groupBy != ''){
    		$returnValue->distinct($groupBy);
    	}
    	return $returnValue->get('datum')->result_array();
    }

    public function getPerformanceCycleDtl_NIU($conditionArray=array()){
    	$returnValue = $this->db->select('*');
    	if(count($conditionArray)>0){
    		$returnValue->where($conditionArray);
    	}
    	return $returnValue->get('performance_cycle')->row_array();
    }*/

    public function insert_bonus_rules($insertData){
    	$this->db->insert('hr_parameter_bonus',$insertData);
        return $this->db->insert_id();
    }

    public function get_bonus_rule_dtls($condition_arr)
    {   
        $this->db->select("hr_parameter_bonus.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date");
        $this->db->from("hr_parameter_bonus");
        $this->db->join("performance_cycle","performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
        return $this->db->where($condition_arr)->get()->row_array();
    }   

    public function updateBonusRules($updateData,$conditionArr){
        $this->db->where($conditionArr)->update('hr_parameter_bonus',$updateData);
    }


   /* public function getRuledetails($conditionArray){
    	$getRule = $this->db->select('*');
    	if(count($conditionArray) > 0){
    		$getRule->where($conditionArray);
    	}
    	return $getRule->get('hr_parameter_bonus')->row_array();
    }*/

    public function get_employees_by_uploaded_id_list_NIU($upload_id)
	{	
		$this->db->select("login_user.*");
		$this->db->from("tuple");
		$this->db->join("login_user","tuple.user_id = login_user.id");
		$this->db->where("data_upload_id = '$upload_id'");
		return $this->db->get()->result_array();
	}

	/*public function get_user_performance_ratings($upload_id, $user_id,  $condition_arr=array())
	{
		if($condition_arr)
		{
			$rating_elements_list = $this->get_salary_elements_list("id", $condition_arr);
		}
		$this->db->select("datum.*");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		if($condition_arr)
		{
			return $this->db->where(array("tuple.user_id"=>$user_id,"tuple.data_upload_id"=>$upload_id, "datum.data_upload_id"=>$upload_id, "datum.business_attribute_id"=>$rating_elements_list[0]["id"]))->get()->result_array();
		}
		else
		{
			return $this->db->where(array("tuple.user_id"=>$user_id,"tuple.data_upload_id"=>$upload_id, "datum.data_upload_id"=>$upload_id))->get()->result_array();
		}
	}*/

    //************************************** RV ********************************
    public function get_bussiness_attributes_list($select_fields, $condition_arr)
    {   
        $this->db->select($select_fields);
        $this->db->from("business_attribute");
        return $this->db->where($condition_arr)->get()->result_array();
    }

    public function get_bussiness_level_header_list($condition_in_arr)
    {   
        $atti_ids = $this->array_value_recursive('id', $condition_in_arr);
        $this->db->select("distinct (`display_name_override`), business_attribute_id");
        $this->db->from("datum");
       // $this->db->where("data_upload_id",$upload_id);
        return $this->db->where_in("business_attribute_id",$atti_ids)->get()->result_array();
    }  

    public function array_value_recursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    } 

    public function get_bussiness_level_values($condition_in_arr)
    {
       $atti_ids = $this->array_value_recursive('id', $condition_in_arr);
        $this->db->select("distinct (`uploaded_value`), business_attribute_id, display_name_override");
        $this->db->from("datum");
        //$this->db->where("data_upload_id",$upload_id);
        return $this->db->where_in("business_attribute_id",$atti_ids)->get()->result_array();
    }

    public function get_rule_wise_emp_list_for_increments($rule_id)
    {
		//CB::Ravi on 15-02-2018
        //$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, employee_bonus_details.upload_id, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, hr_parameter_bonus.bonus_rule_name as rule_name, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.rule_id, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name");
		$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, login_user.upload_id, employee_bonus_details.final_bonus, employee_bonus_details.final_bonus_per, hr_parameter_bonus.bonus_rule_name as rule_name, employee_bonus_details.status as emp_bonus_status, employee_bonus_details.rule_id, performance_cycle.name as performance_cycle_name, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type, employee_bonus_details.last_action_by, employee_bonus_details.manager_emailid, (select login_user.name from login_user where login_user.email = employee_bonus_details.last_action_by) as last_manager_name");
        $this->db->from("employee_bonus_details");
        $this->db->join("login_user","login_user.id = employee_bonus_details.user_id");        
        $this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
        $this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
        $this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
        $this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
        $this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
        $this->db->join("manage_level", "manage_level.id = login_user.level","left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->join("hr_parameter_bonus","hr_parameter_bonus.id = employee_bonus_details.rule_id");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
        $this->db->where(array("employee_bonus_details.rule_id"=>$rule_id));
		$this->db->order_by("employee_bonus_details.last_action_by asc");
        $this->db->order_by("login_user.name asc");
        $data = $this->db->get()->result_array();
        $tempArr =  array();    
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
	
    public function get_employee_bonus_dtls($condition_arr)
    {   
       $this->db->select("login_user.name, login_user.email, login_user.upload_id, (select manage_designation.name from manage_designation where manage_designation.id = login_user.desig) as current_designation, employee_bonus_details.*, (select hr_parameter_bonus.status from hr_parameter_bonus where hr_parameter_bonus.id = employee_bonus_details.rule_id) as rule_status, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_CURRENCY_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as currency_type");
        $this->db->from("employee_bonus_details");
        $this->db->join("login_user","login_user.id = employee_bonus_details.user_id");
        if($condition_arr)
        {
            $this->db->where($condition_arr);
        }
        return $this->db->get()->row_array();
    }
}