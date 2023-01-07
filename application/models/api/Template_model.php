<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Template_model extends CI_Model
{
    function __construct()
    {
                parent::__construct();
                $this->load->database();
		$dbname = $this->session->userdata("dbname_ses");
		if(trim($dbname))
		{
			$this->db->query("Use $dbname");		
		}
		date_default_timezone_set('Asia/Calcutta');
    }	    
    
    public function saveTemplate($data)
    {
        $res=  $this->db->insert('template',$data);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function updateTemplate($templateID,$data)
    {
        $this->db->where(array('templateID'=>$templateID));
        $res=$this->db->update('template',$data);
         if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_staff_list($condition_arr="",$limit=50000, $start=0)
	{	
		//Note :: status  7 or more than 6 means rule is completed with all emp Salary/Bonus increments
                if($limit==0 and $start==0)      
                    { 
                        $this->db->select("*");
                    }
                    else
                    {
                        $this->db->select("employee_bonus_details.individual_weightage,employee_bonus_details.individual_achievement,employee_bonus_details.bl_3_weightage,
employee_bonus_details.bl_3_achievement,employee_bonus_details.bl_2_weightage,employee_bonus_details.bl_2_achievement,
employee_bonus_details.bl_1_weightage,employee_bonus_details.bl_1_achievement,employee_bonus_details.function_weightage,
employee_bonus_details.function_achievement,lti_rules.rule_name,lti_rules.lti_linked_with,lti_rules.target_lti_dtls,employee_lti_details.final_incentive,employee_lti_details.actual_incentive,employee_bonus_details.target_bonus,employee_bonus_details.final_bonus_per,employee_salary_details.*,login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, login_user.upload_id, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as performance_rating, (select count(*) from hr_parameter where hr_parameter.status <= 6 and hr_parameter.status != 5 and FIND_IN_SET(login_user.id, hr_parameter.user_ids)) as emp_count_in_salary_rules, (select count(*) from hr_parameter_bonus where hr_parameter_bonus.status <= 6 and hr_parameter_bonus.status != 5 and FIND_IN_SET(login_user.id, hr_parameter_bonus.user_ids)) as emp_count_in_bonus_rules");
                    }
                $this->db->from('login_user');    
		//$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, login_user.upload_id, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3, (select count(*) from hr_parameter where hr_parameter.status <= 6 and FIND_IN_SET(login_user.id, hr_parameter.user_ids)) emp_count_in_salary_rules, (select count(*) from hr_parameter_bonus where hr_parameter_bonus.status <= 6 and FIND_IN_SET(login_user.id, hr_parameter_bonus.user_ids)) emp_count_in_bonus_rules");
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		//$this->db->join("manage_bussiness_unit", "manage_bussiness_unit.id = login_user.bussiness_unit_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
                $this->db->join("employee_lti_details", "employee_lti_details.user_id = login_user.id","left");
                $this->db->join("employee_bonus_details", "employee_bonus_details.user_id = login_user.level","left");
                $this->db->join("employee_salary_details", "employee_salary_details.user_id = login_user.id","left");
                $this->db->join("lti_rules", "lti_rules.id = employee_lti_details.rule_id","left");
                $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where(array("role >"=> 2, "login_user.status !="=>2));
                
                
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
                if($limit==0 and $start==0)      
                    { 
                        return $this->db->count_all_results();        
                    }   
                $this->db->limit($limit, $start);    
		return $this->db->get()->result_array(); //$data = $this->db->get()->result_array();
		/*$tempArr =	array();	
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
		return $tempArr;*/
	}
        
    public function mysalaryrule($table,$condition)
    {
       // $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get($table)->result_array();
    }
        public function getTemplate($templateID)
    {
        return $this->db->get_where('template',array('TemplateID'=>$templateID))->result();
    }
    
    public function get_old_template($table,$condition)
    {
        return $this->db->get_where($table,$condition)->result();
    }
    public function get_data($table,$condition)
    {
        return $this->db->get_where($table,$condition)->result_array();
    }
    public function get_templates($table,$condition)
    {
        return $this->db->get_where($table,$condition)->result();
    }
    public function getalltemplate()
    {
        return $this->db->get('template')->result();
    }
    public function getAttr($RowNo,$uploadID)
    {
        
       $this->db->select("datum.value,business_attribute.display_name");
       $this->db->from('datum');
       $this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
       $this->db->where(array("datum.data_upload_id"=>$uploadID,"datum.row_num"=>$RowNo,"business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT));
       return $this->db->get()->result_array();
        
       
    }
    public function get_peer_employee_salary_dtls_for_graph($uid, $graph_on=CV_GRADE)
    {	
            $this->db->select("id, grade, level");
            $this->db->from("login_user");
            $this->db->where(array("login_user.id"=>$uid));
            $user_grade_level_dtls = $this->db->get()->row_array();

            $this->db->select("login_user.name, login_user.email, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.user_id = login_user.id and tuple.data_upload_id = login_user.upload_id and datum.data_upload_id = tuple.data_upload_id and tuple.row_num = datum.row_num ORDER BY tuple.id  and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ."  DESC LIMIT 1) as final_salary");
            $this->db->from("login_user");
            $this->db->where("login_user.id !=".$uid);
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
    public function get_current_employee_salary_dtls_for_graph($uid)
    {	
            $this->db->select("login_user.name, login_user.email, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.user_id = login_user.id and tuple.data_upload_id = login_user.upload_id and datum.data_upload_id = tuple.data_upload_id and tuple.row_num = datum.row_num ORDER BY tuple.id  and business_attribute_id = ". CV_CURRENT_BASE_SALARY_ID ."  DESC LIMIT 1) as final_salary");
            $this->db->from("login_user");
            $this->db->where("login_user.id =".$uid);
            $this->db->order_by("final_salary","asc");
            return $this->db->get()->row_array();		
    } 
    public function get_team_employee_salary_dtls_for_graph($uid)
	{	
		$this->db->select("row_owner.first_approver");
		$this->db->from("row_owner"); 
		$this->db->where(array("row_owner.user_id"=>$uid));
                $this->db->order_by('row_owner.id','DESC');
		$user_first_approver = $this->db->get()->row_array()["first_approver"];

		if($user_first_approver)
		{
			$this->db->select("user_id");
			$this->db->from("row_owner");
			//$this->db->where(array("upload_id"=>$upload_id, "first_approver"=>$user_first_approver));
                        $this->db->where(array( "first_approver"=>$user_first_approver));
			$this->db->where("user_id !=".$uid );
			$team_user_arr = $this->db->get()->result_array();
			
			if($team_user_arr)
			{
                            
				$team_user_ids = $this->array_value_recursive('user_id', $team_user_arr);

				$this->db->select("login_user.name, login_user.email, "
                                        . "(select value from tuple join datum on datum.row_num = tuple.row_num where tuple.user_id"
                                        . " = login_user.id and tuple.data_upload_id = login_user.upload_id and datum.data_upload_id "
                                        . "= tuple.data_upload_id and tuple.row_num = "
                                        . "datum.row_num ORDER BY tuple.id  and business_attribute_id "
                                        . "= ". CV_CURRENT_BASE_SALARY_ID ." "
                                        . " DESC LIMIT 1) as final_salary");
				$this->db->from("login_user");		
				$this->db->where_in("login_user.id",$team_user_ids);
				$this->db->order_by("final_salary","asc");
				return $this->db->get()->result_array();
			}
		}
	} 
        public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}
    public function savedata($table,$data)
    {
        $res=$this->db->insert($table,$data);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    public function mypdf()
    {
        return $this->db->query('select * from user_pdf where user_id='.$this->session->userdata('userid_ses'))->result();
    }
    
    public function header_image($data,$compID)
    {
        $this->db->where('id',$compID);
        $this->db->update('manage_company',$data);
    }
    
    public function getLatterHead()
    {
        return $this->db->get_where('manage_company',array('id'=>$this->session->userdata('companyid_ses')))->result();
    }
    
    
	
	     
}